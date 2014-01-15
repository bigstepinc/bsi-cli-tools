<?php
require_once("JSONRPC/ServerFilterBase.php");

/**
* When using multiple plugins, it is preferable for the Reflection plugin to be added first to make necessary translations in time.
*/
class JSONRPC_filter_reflection extends JSONRPC_server_filter_plugin_base
{
	protected static $_arrJSONRPCReflectionFunctions=array(
		"rpc.functions"=>"JSONRPC_filter_reflection::functions",
		"rpc.reflectionFunction"=>"JSONRPC_filter_reflection::reflectionFunction",
		"rpc.reflectionFunctions"=>"JSONRPC_filter_reflection::reflectionFunctions",
	);

	protected static $_bCodeComments=true;
	
	public function __construct($bCodeComments=true)
	{
		assert(is_bool($bCodeComments));
		self::$_bCodeComments=$bCodeComments;
	}
	
	
	public function isFunctionNameAllowed($strFunctionName)
	{
		return array_key_exists($strFunctionName, self::$_arrJSONRPCReflectionFunctions);
	}
	
	
	public function resolveFunctionName(&$strFunctionName)
	{
		if($this->isFunctionNameAllowed($strFunctionName))
			$strFunctionName=self::$_arrJSONRPCReflectionFunctions[$strFunctionName];
	}
	
	
	public function beforeJSONDecode(&$strJSONRequest)
	{
		if(!JSONRPC_server::$bAuthenticated || !JSONRPC_server::$bAuthorized)
		{
			$arrRequest=json_decode($strJSONRequest, true);
			if($this->isFunctionNameAllowed($arrRequest["method"]))
			{
				JSONRPC_server::$bAuthenticated=true;
				JSONRPC_server::$bAuthorized=JSONRPC_server::$bAuthenticated;
			}
		}
	}
	
	
	public function afterJSONDecode(&$arrRequest)
	{
		if(!JSONRPC_server::$bAuthenticated || !JSONRPC_server::$bAuthorized)
		{
			if($this->isFunctionNameAllowed($arrRequest["method"]))
			{
				JSONRPC_server::$bAuthenticated=true;
				JSONRPC_server::$bAuthorized=JSONRPC_server::$bAuthenticated;
			}
		}
	}
	
	
	public static function functions()
	{
		return JSONRPC_server::$arrAllowedFunctionCalls;
	}
	
	
	/**
	* This function is exposed through RPC as authorized and authenticated for any caller.
	* It validates on its own if the requested Reflection is for an exposed function.
	* @param string $strFunctionName. Unresolved function name, as seen on the RPC.
	*/
	public static function reflectionFunction($strFunctionName)
	{
		JSONRPC_server::assertFunctionNameAllowed($strFunctionName);


		foreach(JSONRPC_server::$arrFilterPlugins as $objFilterPlugin)
			$objFilterPlugin->resolveFunctionName($strFunctionName);


		if(function_exists($strFunctionName))
			$reflector=new ReflectionFunction($strFunctionName);
		else if(is_callable($strFunctionName))
		{
			$arrClassAndStaticMethod=explode("::", $strFunctionName);
			$reflector=new ReflectionMethod($arrClassAndStaticMethod[0], $arrClassAndStaticMethod[1]);
		}
		else
			throw new JSONRPC_Exception("The function \"".$strFunctionName."\" is not defined or loaded.", JSONRPC_Exception::METHOD_NOT_FOUND);


		$arrFunctionReflection=array(
			"function_return_type"=>"unknown",
			"function_documentation_comment"=>$reflector->getDocComment(),
			"function_params"=>array(),
		);

		static $arrTypeMnemonicsToTypes=array(
			"n"=>"integer",
			"f"=>"float",
			"str"=>"string",
			"arr"=>"array",
			"b"=>"boolean",
			"obj"=>"object",
			"mx"=>"mixed",
		);

		static $arrPHPTypesToTypes=array(
			"int"=>"integer",
			"double"=>"float",
			"float"=>"float",
			"string"=>"string",
			"array"=>"array",
			"bool"=>"boolean",
			"object"=>"object",
			"mixed"=>"mixed",
			"null"=>"null",
			"none"=>"unknown",
		);

		if(strpos($arrFunctionReflection["function_documentation_comment"], "@return")!==false)
		{
			$arrReturnParts=explode("@return", $arrFunctionReflection["function_documentation_comment"], 2);
			$arrReturnParts=explode(".", $arrReturnParts[1], 2);
			$strReturnType=trim($arrReturnParts[0]);

			if(in_array($strReturnType, $arrTypeMnemonicsToTypes))
				$arrFunctionReflection["function_return_type"]=$strReturnType;
			else if(isset($arrPHPTypesToTypes[strtolower($strReturnType)]))
				$arrFunctionReflection["function_return_type"]=$arrPHPTypesToTypes[strtolower($strReturnType)];
		}

		$nErrorsPosition=strpos($arrFunctionReflection["function_documentation_comment"], "@errors");
		if($nErrorsPosition!==false)
		{
			$arrParts=preg_split("/[\.\r\n]+/", substr($arrFunctionReflection["function_documentation_comment"], $nErrorsPosition+strlen("@errors ")));
			$arrFunctionReflection["function_error_constants"]=preg_split("/[\s,]+/", $arrParts[0]);
		}
		else
			$arrFunctionReflection["function_error_constants"]=array();

		$arrReflectionParameters=$reflector->getParameters();
		foreach($arrReflectionParameters as $reflectionParameter)
		{
			$arrParam=array(
				"param_name"=>str_replace(array("\$", "&"), array("", ""), $reflectionParameter->getName()),
			);

			
			$arrParam["param_type"]="unknown";
			foreach($arrTypeMnemonicsToTypes as $strMnemonic=>$strType)
			{
				if(
					substr($arrParam["param_name"], 0, strlen($strMnemonic))===$strMnemonic
					&& ctype_upper(substr($arrParam["param_name"], strlen($strMnemonic), 1))
				)
				{
					$arrParam["param_type"]=$strType;
					break;
				}
			}
			
			
			if($reflectionParameter->isDefaultValueAvailable())
			{
				$arrParam["param_default_value_json"]=json_encode($reflectionParameter->getDefaultValue());
				$arrParam["param_default_value_constant_name"] = self::reflectionConstantName($reflectionParameter->getName(), $arrFunctionReflection["function_documentation_comment"]);
			}
			else
			{
				$arrParam["param_default_value_json"]="";
				$arrParam["param_default_value_constant_name"] = "";
			}
			$arrFunctionReflection["function_params"][]=$arrParam;
		}
		
		if(!self::$_bCodeComments)
			unset($arrFunctionReflection["function_documentation_comment"]);
		
		return $arrFunctionReflection;
	}
	
	
	public static function reflectionFunctions($arrFunctionNames)
	{
		$arrReflectionFunctions=array();
		
		foreach($arrFunctionNames as $strFunctionName)
			$arrReflectionFunctions[$strFunctionName]=self::reflectionFunction($strFunctionName);
		
		return $arrReflectionFunctions;
	}

	/**
	 * Returns the name of the constant given as a default parameter.
	 * In order to find the name of the constant it must appear in the doc comment of the function in the following format:
	 *  "* @param .... $parameterName=CONSTANT_NAME...."
	 * @param  int $strReflectionParameterName. The name of the parameter.
	 * @param  string $strDocComment. The doc comment of the function.
	 * @return string. The name of the constant or an empty string if not found.
	 */
	public static function reflectionConstantName($strReflectionParameterName, $strDocComment)
	{

		$arrDocCommentLines = explode("\n", $strDocComment);
		foreach ($arrDocCommentLines as $strDocCommentLine)
		{

			$arrRegexMatches = array();

			if (preg_match("/^[\w\W]*@param[\w\W]*" . $strReflectionParameterName  . "=/", $strDocCommentLine, $arrRegexMatches))
			{

				$nOffset = strlen($arrRegexMatches[0]);
				if (preg_match("/[A-Z]{1,1}[A-Z0-9_]+/", $strDocCommentLine, $arrRegexMatches, 0, $nOffset))
				{
					if ($arrRegexMatches[0] !== "NULL")
						return $arrRegexMatches[0];
				}

				return "";
			}
		}
		return "";

	}


}
