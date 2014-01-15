<?php
require_once("JSONRPC_Exception.php");


/**
* JSON-RPC 2.0 client.
* http://www.jsonrpc.org/specification
* Batch RPC calls and notifications are not implemented.
*/
class JSONRPC_client
{
	/**
	* JSON-RPC protocol call ID.
	*/
	protected $_nCallID=0;
	
	
	/**
	* Filter plugins which extend JSONRPC_client_filter_plugin_base.
	*/
	protected $_arrFilterPlugins=array();
	
	
	/**
	* JSON-RPC server endpoint URL
	*/
	protected $_strJSONRPCRouterURL;
	
	
	public function __construct($strJSONRPCRouterURL)
	{
		$this->_strJSONRPCRouterURL=trim($strJSONRPCRouterURL);
	}
	
	
	protected $_strHTTPUser=NULL;
	protected $_strHTTPPassword=NULL;
	public function httpCredentialsSet($strUsername, $strPassword)
	{
		assert(is_string($strUsername));
		assert(is_string($strPassword));
		
		$this->_strHTTPUser=$strUsername;
		$this->_strHTTPPassword=$strPassword;
	}
	
	
	protected function _rpc($strFunctionName, $arrParams)
	{
		$arrRequest=array(
			"method"=>$strFunctionName,
			"params"=>$arrParams,
			
			"id"=>++$this->_nCallID,
			"jsonrpc"=>self::JSONRPC_VERSION,
		);
		
		
		foreach($this->_arrFilterPlugins as $objFilterPlugin)
			$objFilterPlugin->beforeJSONEncode($arrRequest);
		
		$strRequest=json_encode($arrRequest);
		$strJSONRPCEndpointURL=$this->_strJSONRPCRouterURL;
		
		$arrHTTPHeaders=array(
			"Content-type"=>"application/json",
		);
		
		foreach($this->_arrFilterPlugins as $objFilterPlugin)
			$objFilterPlugin->afterJSONEncode($strRequest, $strJSONRPCEndpointURL, $arrHTTPHeaders);
		
		
		$_arrHTTPHeaders=array();
		foreach($arrHTTPHeaders as $strHeaderName=>$strHeaderContents)
			$_arrHTTPHeaders[]=$strHeaderName.": ".$strHeaderContents;
		
		
		$bErrorMode=false;
		$bCalled=false;
		foreach($this->_arrFilterPlugins as $objFilterPlugin)
		{
			$strResult=$objFilterPlugin->makeRequest($strRequest, $strJSONRPCEndpointURL, $bCalled);
			if($bCalled)
				break;
			assert(is_null($strResult));
		}
		
		if(!$bCalled)
		{
			$cURL=curl_init();
			curl_setopt($cURL, CURLOPT_URL, $strJSONRPCEndpointURL);
			curl_setopt($cURL, CURLOPT_HEADER, false);
			
			if(is_string($this->_strHTTPUser))
				curl_setopt($cURL, CURLOPT_USERPWD, $this->_strHTTPUser.":".(string)$this->_strHTTPPassword);
			
			curl_setopt($cURL, CURLOPT_HTTPHEADER, $_arrHTTPHeaders);
			curl_setopt($cURL, CURLOPT_POST, true);
			curl_setopt($cURL, CURLOPT_POSTFIELDS, $strRequest);
			curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
			
			curl_setopt($cURL, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER, false);
			$strResult=curl_exec($cURL);
			
			if(false===$strResult)
				throw new JSONRPC_Exception("cURL error. Error message: ".curl_error($cURL).". cURL error code: ".curl_errno($cURL));
			
			$nHTTPResponseCode=curl_getinfo($cURL, CURLINFO_HTTP_CODE);
			$bErrorMode=$nHTTPResponseCode!==200;
			
			curl_close($cURL);
		}
		
		return $this->processRAWResponse($strResult, $bErrorMode);
	}
	
	
	public function processRAWResponse($strResult, $bErrorMode=false)
	{
		try
		{
			foreach($this->_arrFilterPlugins as $objFilterPlugin)
				$objFilterPlugin->beforeJSONDecode($strResult);
				
			try
			{
				$mxResponse=self::_json_decode_safe($strResult, true);
			}
			catch(Exception $exc)
			{
				throw new JSONRPC_Exception($exc->getMessage().". RAW response from server: ".$strResult, JSONRPC_Exception::PARSE_ERROR);
			}
			
			
			foreach($this->_arrFilterPlugins as $objFilterPlugin)
				$objFilterPlugin->afterJSONDecode($mxResponse);
				
			
			if(!is_array($mxResponse) || ($bErrorMode && !array_key_exists("error", $mxResponse)))
				throw new JSONRPC_Exception("Invalid response structure. RAW response: ".$strResult, JSONRPC_Exception::INTERNAL_ERROR);
			else if(array_key_exists("result", $mxResponse) && !array_key_exists("error", $mxResponse) && !$bErrorMode)
				return $mxResponse["result"];
			
			throw new JSONRPC_Exception((string)$mxResponse["error"]["message"], (int)$mxResponse["error"]["code"]);
		}
		catch(JSONRPC_Exception $exc)
		{
			foreach($this->_arrFilterPlugins as $objFilterPlugin)
				$objFilterPlugin->exceptionCatch($exc);
			throw $exc;
		}
	}
	
	
	public function addFilterPlugin($objFilterPlugin)
	{
		foreach($this->_arrFilterPlugins as $objFilterPluginExisting)
			if(get_class($objFilterPluginExisting)==get_class($objFilterPlugin))
				throw new Exception("Multiple instances of the same filter are not allowed.");
	
		array_push($this->_arrFilterPlugins, $objFilterPlugin);
	}
	
	
	public function removeFilterPlugin($objFilterPlugin)
	{
		$nIndex=NULL;
		foreach($this->_arrFilterPlugins as $nIndexExisting=>$objFilterPluginExisting)
			if(get_class($objFilterPluginExisting)==get_class($objFilterPlugin))
			{
				$nIndex=$nIndexExisting;
				break;
			}
		if(!is_int($nIndex))
			throw new Exception("Failed to remove filter plugin object, maybe plugin is not registered.");
		
		array_splice($this->_arrFilterPlugins, $nIndex, 1);
	}
	
	
	public function rpcFunctions()
	{
		return $this->_rpc("rpc.functions", array());
	}
	
	
	public function rpcReflectionFunction($strFunctionName)
	{
		return $this->_rpc("rpc.reflectionFunction", array($strFunctionName));
	}
	
	
	public function rpcReflectionFunctions($arrFunctionNames)
	{
		return $this->_rpc("rpc.reflectionFunctions", array($arrFunctionNames));
	}
	
	
	public function __call($strFunctionName, $arrParams)
	{
		return $this->_rpc($strFunctionName, $arrParams);
	}
	
	
	protected static function _json_decode_safe($strJSON, $bAssoc=true)
	{
		$mxReturn=json_decode($strJSON, $bAssoc);
		if(json_last_error()!=JSON_ERROR_NONE)
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
	
	const JSONRPC_VERSION="2.0";
}