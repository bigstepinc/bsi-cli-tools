<?php
require_once("JSONRPC_Exception.php");
require_once("filters/server/Reflection.php");

class JSONRPC_server
{
	private function __construct(){}


	/**
	* Exposed RPC function names.
	* 
	* This array should not appear in stack traces (it is cumbersome, and is a security issue), 
	* that's why it is not passed as a param.
	*/
	public static $arrAllowedFunctionCalls=array();

	
	/**
	* RPC Exception codes are allowed in the response by checking the Exception type.
	*/
	public static $arrExceptionTypesForCodes=array("JSONRPC_Exception");

	
	/**
	* RPC Exception messages are allowed in the response by checking the Exception type.
	*/
	public static $arrExceptionTypesForMessages=array("JSONRPC_Exception");
	
	
	/**
	* Simple safe-guard. Must be set to true after successfull authentication.
	*/
	public static $bAuthenticated=false;
	
	
	/**
	* Simple safe-guard. Must be set to true after successfull authorization.
	*/
	public static $bAuthorized=false;
	
	
	/**
	* Filter plugins which extend JSONRPC_server_filter_plugin_base.
	*/
	public static $arrFilterPlugins=array();

	
	/**
	* JSONRPC log file path.
	*/
	public static $strErrorLogFilePath="";
	
	
	/**
	* HTTP response code.
	*/
	public static $nHTTPResponseCode=0;
	
	
	/**
	* Wether serving a Notification request.
	*/
	public static $bNotificationMode=false;
	
	
	/**
	* If true, it will validate input types.
	*/
	public static $bValidateTypes=false;
	
	
	public static function processRequest($strJSONRequest=NULL)
	{
		self::_exitWithResponse(self::processRequestAndReturn($strJSONRequest));
	}
	
	
	public static function processRequestAndReturn($strJSONRequest)
	{
		$mxRequestID=NULL;
		
		try
		{
			if(is_null($strJSONRequest))
				$strJSONRequest=file_get_contents("php://input");
			
			foreach(self::$arrFilterPlugins as $objFilterPlugin)
				$objFilterPlugin->beforeJSONDecode($strJSONRequest);
			
			
			if(!strlen(trim($strJSONRequest)))
				throw new JSONRPC_Exception("Invalid request. Empty input. Was expecting a POST request of a JSON.", JSONRPC_Exception::PARSE_ERROR);
			
			
			try
			{
				$arrRequest=self::_json_decode_safe($strJSONRequest);
			}
			catch(Exception $exc)
			{
				throw new JSONRPC_Exception($exc->getMessage().". RAW request: ".$strJSONRequest, JSONRPC_Exception::PARSE_ERROR);
			}
			
			if(isset($arrRequest[0]))
				throw new JSONRPC_Exception("JSON-RPC batch requests are not supported by this server.", JSONRPC_Exception::INVALID_REQUEST);
				

			if(isset($arrRequest["method"]) && is_string($arrRequest["method"]) && strlen(trim($arrRequest["method"])) && array_key_exists("params", $arrRequest))
			{
				$arrFunctionReflection = null;

				try 
				{
					$arrFunctionReflection = JSONRPC_filter_reflection::reflectionFunction($arrRequest["method"]);
				} 
				catch (Exception $e) 
				{
				}
				
				if(!is_null($arrFunctionReflection))
				{
					self::namedParamsTranslationAndValidation($arrFunctionReflection["function_params"], $arrRequest["params"], $arrRequest["method"]);
					self::validateDataTypes($arrFunctionReflection["function_params"], $arrRequest["params"]);
				}
			}

			
			foreach(self::$arrFilterPlugins as $objFilterPlugin)
				$objFilterPlugin->afterJSONDecode($arrRequest);
		
			
			//A String containing the name of the method to be invoked. 
			//Method names that begin with the word rpc followed by a period character (U+002E or ASCII 46)
			//are reserved for rpc-internal methods and extensions and MUST NOT be used for anything else.
			if(
				!isset($arrRequest["method"]) 
				|| !is_string($arrRequest["method"]) 
				|| !strlen(trim($arrRequest["method"]))
			)
				throw new JSONRPC_Exception("The \"method\" key must be a string with a function name.", JSONRPC_Exception::INVALID_REQUEST);
			
			
			
			//A Structured value that holds the parameter values to be used during the invocation of the method.
			//This member MAY be omitted.
			if(!array_key_exists("params", $arrRequest))
				$arrRequest["params"]=array();
			
			if(!is_array($arrRequest["params"]))
				throw new JSONRPC_Exception("The \"params\" key must be an array.", JSONRPC_Exception::INVALID_REQUEST);


			
			if(is_callable($arrRequest["method"]) || function_exists($arrRequest["method"]))
			{
				$arrFunctionReflection=JSONRPC_filter_reflection::reflectionFunction($arrRequest["method"]);
				self::namedParamsTranslationAndValidation($arrFunctionReflection["function_params"], $arrRequest["params"], $arrRequest["method"]);
				self::validateDataTypes($arrFunctionReflection["function_params"], $arrRequest["params"]);
			}


			//An identifier established by the Client that MUST contain a String, Number, or NULL value if included. 
			//If it is not included it is assumed to be a notification. 
			//The value SHOULD normally not be Null and Numbers SHOULD NOT contain fractional parts.
			self::$bNotificationMode=!array_key_exists("id", $arrRequest);
			
			if(!self::$bNotificationMode && !is_int($arrRequest["id"]) && !is_null($arrRequest["id"]))
				throw new JSONRPC_Exception("The \"id\" key must be an integer, a null or be omitted for Notification requests.", JSONRPC_Exception::INVALID_REQUEST);
			
			if(!self::$bNotificationMode)
				$mxRequestID=$arrRequest["id"];
			
			
			
			//A String specifying the version of the JSON-RPC protocol. MUST be exactly "2.0".
			if(!isset($arrRequest["jsonrpc"]) || $arrRequest["jsonrpc"]!=self::JSONRPC_VERSION)
				throw new JSONRPC_Exception("The \"jsonrpc\" version must be equal to ".self::JSONRPC_VERSION, JSONRPC_Exception::INVALID_REQUEST);
			
			
			
			self::assertFunctionNameAllowed($arrRequest["method"]);
			
			
			
			//Safe-guard, so developers don't accidentally open the RPC server to the world (default is false, not authenticated).
			//Exceptions should be thrown by authentication filters.
			//Authentication filters must set JSONRPC_server::$bAuthenticated to true upon successfull authentication.
			if(!self::$bAuthenticated)
				throw new JSONRPC_Exception("Not authenticated (bad credentials or signature).", JSONRPC_Exception::NOT_AUTHENTICATED);
			
			
			//Safe-guard, so developers don't accidentally open the RPC server to any user account (default is false, not authorized).
			//Exceptions should be thrown by authorization filters.
			//Authorization filters must set JSONRPC_server::$bAuthorized to true upon successfull authorization.
			if(!self::$bAuthorized)
				throw new JSONRPC_Exception("Authenticated user is not authorized.", JSONRPC_Exception::NOT_AUTHORIZED);
				
			
			$arrResponse=array("result"=>null);
			$arrResponse["result"]=self::callFunction($arrRequest["method"], $arrRequest["params"]);
			
			if(isset($arrFunctionReflection) && count($arrFunctionReflection))
				self::returnDataTypeValidation($arrRequest["method"], $arrFunctionReflection["function_return_type"], $arrResponse["result"]);

			if(!self::$nHTTPResponseCode)
			{
				if(self::$bNotificationMode)
					self::$nHTTPResponseCode=self::HTTP_204_NO_CONTENT;
				else
					self::$nHTTPResponseCode=self::HTTP_200_OK;
			}
		}
		catch(Exception $exc)
		{
			try
			{
				self::_log_exception($exc);
				
				//Gives a chance to log the original Exception and/or throw another "translated" Exception.
				//If nothing is thrown inside exceptionCatch, this catch block will rethrow the original Exception anyway.
				foreach(self::$arrFilterPlugins as $objFilterPlugin)
					$objFilterPlugin->exceptionCatch($exc);
				throw $exc;
			}
			catch(Exception $exc)
			{
				$strExceptionClass=get_class($exc);
			
				if(in_array($strExceptionClass, self::$arrExceptionTypesForMessages))
					$strMessage=$exc->getMessage();
				else
					$strMessage="Internal error.";
					
				
				if(in_array($strExceptionClass, self::$arrExceptionTypesForCodes))
					$nCode=(int)$exc->getCode();
				else
					$nCode=0;
				
				
				if(!self::$nHTTPResponseCode)
				{
					if(
						in_array($nCode, array(
							JSONRPC_Exception::NOT_AUTHENTICATED, 
							JSONRPC_Exception::NOT_AUTHORIZED
						))
					)
					{
						self::$nHTTPResponseCode=self::HTTP_403_FORBIDDEN;
					}
					else
					{
						self::$nHTTPResponseCode=self::HTTP_500_INTERNAL_SERVER_ERROR;
					}
				}
				
				$arrResponse["error"]=array(
					"message"=>$strMessage,
					"code"=>$nCode,
				);
			}
		}
		
		$arrResponse["jsonrpc"]=self::JSONRPC_VERSION;
		if(!self::$bNotificationMode)
			$arrResponse["id"]=$mxRequestID;
			
		
		foreach(self::$arrFilterPlugins as $objFilterPlugin)
			$objFilterPlugin->response($arrResponse);
		
		return $arrResponse;
	}
	
	
	protected static function _exitWithResponse($arrResponse)
	{
		self::_http_response_code(self::$nHTTPResponseCode);
		self::_header("Cache-Control: no-cache, must-revalidate");
		self::_header("Expires: Mon, 26 Jul 1991 05:00:00 GMT");
		self::_header("Accept-Ranges: none");
		self::_header("Connection: close");
		self::_header("Content-type: application/json");
		//self::_header("Content-type: text/plain;charset=utf-8");
		
		
		/**
		* JSON-RPC 2.0 Specification, 4.1 Notification
		* Notifications are not confirmable by definition, since they do not have a Response object to be returned. 
		* As such, the Client would not be aware of any errors (like e.g. "Invalid params","Internal error").
		*/
		if(!self::$bNotificationMode)
			echo json_encode($arrResponse);
		
		if(in_array(self::$nHTTPResponseCode, array(
			self::HTTP_200_OK, 
			self::HTTP_204_NO_CONTENT,
		)))
		{
			exit(0);
		}
		exit(1);
	}

	
	public static function callFunction($strFunctionName, $arrParams)
	{
		ignore_user_abort(true);
		
		
		self::assertFunctionNameAllowed($strFunctionName);
		
		
		foreach(self::$arrFilterPlugins as $objFilterPlugin)
			$objFilterPlugin->resolveFunctionName($strFunctionName);
		
		
		$bCalled=false;
		foreach(self::$arrFilterPlugins as $objFilterPluginExisting)
		{
			$mxResult=$objFilterPluginExisting->callFunction($strFunctionName, $arrParams, $bCalled);
			if($bCalled)
				break;
		}
		
		if(!$bCalled)
		{
			if(!is_callable($strFunctionName))
				throw new JSONRPC_Exception("Internal error. The function ".$strFunctionName." is not defined or loaded.", JSONRPC_Exception::METHOD_NOT_FOUND);
			$mxResult=call_user_func_array($strFunctionName, self::array_make_references($arrParams));
		}
			
		return $mxResult;
	}
	
	
	public static function addFilterPlugin($objFilterPlugin)
	{
		foreach(self::$arrFilterPlugins as $objFilterPluginExisting)
			if(get_class($objFilterPluginExisting)==get_class($objFilterPlugin))
				return;
	
		self::$arrFilterPlugins[]=$objFilterPlugin;
	}
	
	
	public static function removeFilterPlugin($objFilterPlugin)
	{
		$nIndex=NULL;
		foreach(self::$arrFilterPlugins as $nIndexExisting=>$objFilterPluginExisting)
			if(get_class($objFilterPluginExisting)==get_class($objFilterPlugin))
			{
				$nIndex=$nIndexExisting;
				break;
			}
		if(!is_int($nIndex))
			throw new Exception("Failed to remove filter plugin object, maybe plugin is not registered.");
		
		array_splice(self::$arrFilterPlugins, $nIndex, 1);
	}
	
	
	public static function assertFunctionNameAllowed($strFunctionName)
	{
		$bFunctionNameAllowed=false;
		foreach(self::$arrFilterPlugins as $objFilterPlugin)
		{
			$bFunctionNameAllowed=$objFilterPlugin->isFunctionNameAllowed($strFunctionName);
			if($bFunctionNameAllowed)
				break;
		}
		
		if(!$bFunctionNameAllowed && !in_array($strFunctionName, self::$arrAllowedFunctionCalls))
		{
			self::$nHTTPResponseCode=self::HTTP_403_FORBIDDEN;
			throw new JSONRPC_Exception("The function \"".$strFunctionName."\" is not whitelisted and/or does not exist.", JSONRPC_Exception::METHOD_NOT_FOUND);
		}
		
		return true;
	}
	
	
	protected static function _json_decode_safe($strJSON, $bAssoc=true)
	{
		$mxReturn=json_decode($strJSON, $bAssoc);
		if(json_last_error()!==JSON_ERROR_NONE)
		{
			static $arrJSONErrorCodes=array(
				JSON_ERROR_DEPTH=>"JSON_ERROR_DEPTH",
				JSON_ERROR_STATE_MISMATCH=>"JSON_ERROR_STATE_MISMATCH",
				JSON_ERROR_CTRL_CHAR=>"JSON_ERROR_CTRL_CHAR",
				JSON_ERROR_SYNTAX=>"JSON_ERROR_SYNTAX",
				JSON_ERROR_UTF8=>"JSON_ERROR_UTF8",
			);
			
			if(isset($arrJSONErrorCodes[json_last_error()]))
				throw new Exception($arrJSONErrorCodes[json_last_error()]);
				
			throw new Exception("JSON deserialization failed.");
		}
		
		return $mxReturn;
	}
	
	
	public static function &array_make_references(&$arrSomething)
	{ 
		$arrAllValuesReferencesToOriginalValues=array();
		foreach($arrSomething as $mxKey=>&$mxValue)
			$arrAllValuesReferencesToOriginalValues[$mxKey]=&$mxValue;
		return $arrAllValuesReferencesToOriginalValues;
	}
	
	
	protected static function _log_exception($exc)
	{
		try
		{
			if(strlen(self::$strErrorLogFilePath))
			{
				if(!file_exists(dirname(self::$strErrorLogFilePath)))
					mkdir(dirname(self::$strErrorLogFilePath), 0777, true);
				
				$strClientInfo="";
				if(array_key_exists("REMOTE_ADDR", $_SERVER))
					$strClientInfo.=" ".$_SERVER["REMOTE_ADDR"];
				if(array_key_exists("HTTP_USER_AGENT", $_SERVER))
					$strClientInfo.=" ".$_SERVER["HTTP_USER_AGENT"];
				
				$strErrorLine=PHP_EOL.PHP_EOL.str_repeat("-", 100).PHP_EOL.
					(isset($_SERVER["REQUEST_URI"])?$_SERVER["REQUEST_URI"].PHP_EOL:"").
					date("Y-m-d H:i:s u e").$strClientInfo.PHP_EOL.
					$exc->getFile()."#".$exc->getLine().PHP_EOL.
					"Error type: ".get_class($exc).". Error message: ".$exc->getMessage()." Error code: ".$exc->getCode().PHP_EOL.
					"Stack trace: ".$exc->getTraceAsString().PHP_EOL.PHP_EOL
				;
				error_log($strErrorLine, 3, self::$strErrorLogFilePath);
			}
		}
		catch(Exception $exc)
		{
		}
	}
	
	
	const HTTP_200_OK=200;
	const HTTP_204_NO_CONTENT=204;
	const HTTP_401_UNAUTHORIZED=401;
	const HTTP_403_FORBIDDEN=403;
	const HTTP_500_INTERNAL_SERVER_ERROR=500;
	
	protected static function _http_response_code($nHTTPResponseCode)
	{
		if(!self::$nHTTPResponseCode)
			self::$nHTTPResponseCode=self::HTTP_500_INTERNAL_SERVER_ERROR;
		
		static $arrHTTPResponseCodesToText=array(
			self::HTTP_200_OK=>"OK",
			self::HTTP_204_NO_CONTENT=>"No Content",
			self::HTTP_401_UNAUTHORIZED=>"Unauthorized",
			self::HTTP_403_FORBIDDEN=>"Forbidden",
			self::HTTP_500_INTERNAL_SERVER_ERROR=>"Internal Server Error",
		);
		self::_header("HTTP/1.1 ".(int)$nHTTPResponseCode." ".$arrHTTPResponseCodesToText[(int)$nHTTPResponseCode], /*$bReplace*/ true, $nHTTPResponseCode);
	}
	
	
	protected static function _header($strHeader, $bReplace=true)
	{
		if(
			//serving HTTP request.
			
			isset($_SERVER["REQUEST_METHOD"]) 
			&& in_array(
				$_SERVER["REQUEST_METHOD"], 
				array("GET", "POST", "PUT", "HEAD", "DELETE")
			)
		)
			header($strHeader, $bReplace);
	}
	
	const JSONRPC_VERSION="2.0";


	public static function isAssociativeArray($array)
	{
  		if(!is_array($array))
  			return false;

  		//http://stackoverflow.com/a/4254008/1852030
  		return (bool)count(array_filter(array_keys($array), "is_string"));
	}

	public static function validateDataTypes($arrParamsDetails, &$arrParams)
	{
		if(!self::$bValidateTypes)
			return;
			
		for ($i=0; $i < count($arrParamsDetails); $i++)
		{
			$strParamName = $arrParamsDetails[$i]["param_name"];

			if(!array_key_exists($i, $arrParams))
			{
				if(strlen($arrParamsDetails[$i]["param_default_value_json"]) == 0)
					throw new JSONRPC_Exception("Parameter at index " . $i . " [" . json_encode($strParamName) . "] is mandatory and doesn't have a default value.", JSONRPC_Exception::INVALID_PARAMS);
				else
					return;
			}

			if(is_null($arrParams[$i]) && $arrParamsDetails[$i]["param_default_value_json"] !== "null")
				throw new JSONRPC_Exception("Parameter " . $strParamName . " cannot be NULL.", JSONRPC_Exception::INVALID_PARAMS);

			switch ($arrParamsDetails[$i]["param_type"])
			{
				case "integer":

					if(is_int($arrParams[$i]))
						break;

					if((string)(int)$arrParams[$i] !== (string)$arrParams[$i])
						throw new JSONRPC_Exception("Parameter at index " . $i . " [" . json_encode($strParamName) . "], must be an integer (Number JSON type with no decimals), " . gettype($arrParams[$i]) . " given.", JSONRPC_Exception::INVALID_PARAMS);

					$arrParams[$i] = (int) $arrParams[$i];

					break;		


				case "float":

					if(is_float($arrParams[$i]) || is_int($arrParams[$i]))
						break; 
					
					if((string)(float)$arrParams[$i] !== $arrParams[$i])
						throw new JSONRPC_Exception("Parameter at index " . $i . " [" . json_encode($strParamName) . "], must be a Number., " . gettype($arrParams[$i]) . " given.", JSONRPC_Exception::INVALID_PARAMS);

					$arrParams[$i] = (float) $arrParams[$i];

					break;					


				case "string":

					if(is_string($arrParams[$i]))
						break;

					$arrParams[$i] = (string) $arrParams[$i];

					break;					


				case "array":

					if(!is_array($arrParams[$i]))
						throw new JSONRPC_Exception("Parameter at index " . $i . " [" . json_encode($strParamName) . "], must be an Array, " . gettype($arrParams[$i]) . " given.", JSONRPC_Exception::INVALID_PARAMS);
					else if(self::isAssociativeArray($arrParams[$i]))
						throw new JSONRPC_Exception("Parameter at index " . $i . " [" . json_encode($strParamName) . "], must be an Array, Object (key:value collection) given.", JSONRPC_Exception::INVALID_PARAMS);
		

					break;


				case "object":

					if(!self::isAssociativeArray($arrParams[$i]) && $arrParams[$i] != array() && !is_object($arrParams[$i]))
						throw new JSONRPC_Exception("Parameter at index " . $i . " [" . json_encode($strParamName) . "], must be an Object (key:value collection), " . gettype($arrParams[$i]) . " given.", JSONRPC_Exception::INVALID_PARAMS);

					break;


				case "boolean":

					if(is_bool($arrParams[$i]))
						break;

					if((string)$arrParams[$i] === "0")
						$arrParams[$i] = false;
					else if((string)$arrParams[$i] === "1")
						$arrParams[$i] = true;
					else
						throw new JSONRPC_Exception("Parameter at index " . $i . " [" . json_encode($strParamName) . "], must be Boolean, " . gettype($arrParams[$i]) . " given.", JSONRPC_Exception::INVALID_PARAMS);

					break;					
			}
		}
	}


	public static function returnDataTypeValidation($strMethodName, $strExpectedDataType, &$mxResult)
	{
		if($strExpectedDataType=="mixed")
			return;
		
		if($strExpectedDataType=="unknown")
			return;
		
		if(
			is_array($mxResult) 
			&& $strExpectedDataType=="object" 
			&& (
				self::isAssociativeArray($mxResult) 
				|| !count($mxResult)
			)
		)
		{
			$mxResult=(object)$mxResult;
		}
		else if(is_int($mxResult) && $strExpectedDataType=="float")
			$mxResult=(float)$mxResult;
		
		
		$strReturnType=gettype($mxResult);
		
		if($strReturnType=="double")
			$strReturnType="float";
		
		
		if(strtolower($strReturnType) != strtolower($strExpectedDataType))
			throw new JSONRPC_Exception("Method ".json_encode($strMethodName)." declared return type is ".$strExpectedDataType.", and it attempted returning ".$strReturnType.". The function call may have succeeded as it attempted to return.", JSONRPC_Exception::INVALID_RETURN_TYPE);
	}


	public static function namedParamsTranslationAndValidation($arrParamsDetails, &$arrParams, $strMethodName)
	{
		//Count number of mandatory parameters
		$nMandatoryParams = 0;

		foreach ($arrParamsDetails as $arrParam) 
		{
			if(strlen($arrParam["param_default_value_json"]) == 0)
				$nMandatoryParams++;
			else
				break;
		}


		if(count($arrParams) > 0 && self::isAssociativeArray($arrParams))
		{
			//Named parameteres
			$arrNewParams = array();

			foreach ($arrParamsDetails as $arrParamProperties) 
			{
				if(array_key_exists($arrParamProperties["param_name"], $arrParams))
					$arrNewParams[] = $arrParams[$arrParamProperties["param_name"]];
				else if(strlen($arrParamProperties["param_default_value_json"]) > 0)
					$arrNewParams[] = $arrParamProperties["param_default_value_json"];
				else
					throw new JSONRPC_Exception("Missing mandatory method parameter " . json_encode($arrParamProperties["param_name"]) . " for method " . json_encode($strMethodName) . ".", JSONRPC_Exception::INVALID_PARAMS);
			
				unset($arrParams[$arrParamProperties["param_name"]]);
			}


			if(count($arrParams) > 0)
				throw new JSONRPC_Exception("Too many parameters given to method " . json_encode($strMethodName) . ". Extra parameters: " . json_encode(array_keys($arrParams)) . ".", JSONRPC_Exception::INVALID_PARAMS);
				
			$arrParams = $arrNewParams;
		}
		else 
		{
			//Unnamed params

			if(count($arrParams) > count($arrParamsDetails))
				throw new JSONRPC_Exception("Too many parameters given to method " . json_encode($strMethodName) . ". Expected " . $nMandatoryParams . " parameter(s): " . json_encode(self::getParamNames($arrParamsDetails)) . ".", JSONRPC_Exception::INVALID_PARAMS);
				
			if(count($arrParams) < $nMandatoryParams)
				throw new JSONRPC_Exception("Not enough parameters for method " . json_encode($strMethodName) . ". Expected " . $nMandatoryParams . " parameter(s): " . json_encode(self::getParamNames($arrParamsDetails)) . ".", JSONRPC_Exception::INVALID_PARAMS);
		}
	}


	public static function getParamNames($arrParamsDetails)
	{
		$arrParamsName = array();

		if(count($arrParamsDetails) > 0)
			foreach ($arrParamsDetails as $value) 
				if(strlen($value["param_default_value_json"]) > 0)
					$arrParamsName[] = $value["param_name"] . "=" . $value["param_default_value_json"];					
				else
					$arrParamsName[] = $value["param_name"];	

		return $arrParamsName;
	}
}
