<?php
class JSONRPC_server_filter_plugin_base
{
	public function __construct()
	{
	}
	
	
	/**
	* Should be used complementary to the authorization on JSONRPC_server::$arrAllowedFunctionCalls.
	* This function is called before JSONRPC_server_filter_plugin_base::resolveFunctionName.
	* @param string $strFunctionName.
	*/
	public function isFunctionNameAllowed($strFunctionName)
	{
		return false;
	}
	
	
	/**
	* Should be used to 
	* - decrypt or decode an input (binary or string) into the expected JSONRPC_server JSON input format;
	* - log raw input.
	* @param string &$strJSONRequest.
	*/
	public function beforeJSONDecode(&$strJSONRequest)
	{
	}
	
	
	/**
	* Should be used to 
	* - add authorization and authentication based on param values within the JSON request;
	* - translate or decode input params into the expected JSONRPC_server array input format.
	* Upon successfull authentication this function must set JSONRPC_server::$bAuthenticated to true.
	* Upon successfull authorization this function must set JSONRPC_server::$bAuthorized to true.
	* @param array &$arrRequest.
	* @param string $strJSONRequest.
	*/
	public function afterJSONDecode(&$arrRequest)
	{
	}
	
	
	/**
	* Should be used to update the JSONRPC_server response with additional info.
	* @param array &$arrJSONRPCResponse. Associative array in JSONRPC_server response.
	*/
	public function response(&$arrJSONRPCResponse)
	{
	}
	
	
	/**
	* Translates an API declared function name to an internally callable function name.
	* @param string &$strFunctionName.
	*/
	public function resolveFunctionName(&$strFunctionName)
	{
	}
	
	
	/**
	* Should wrap call_user_func_array to allow for custom centralised error handling 
	* with/and function call retries, before returning to RPC client (and other uses).
	*
	* Caller (JSONRPC_server) is responsible for not calling strFunctionName more than once
	* (first plugin enountered to implement this filter which returned true in &$bCalled must be the only one to make a call).
	*
	* Plugins are responsible of making sure $bCalled is set to true if an attempt is made to call the function, 
	* even if an unhandled or handled exception occurs.
	*
	* @param string $strFunctionName.
	* @param array $arrParams.
	* @param bool &$bCalled. Return param. True if the function in strFunctionName was called, oterwise false.
	* @return mixed. Returns the call_user_func_array result with $bCalled set to true. Otherwise returns NULL and $bCalled will be set to false.
	*/
	public function callFunction($strFunctionName, $arrParams, &$bCalled)
	{
		assert(!$bCalled);
		
		$bCalled=false;
	}
	
	
	/**
	* Should be used to rethrow exceptions as different types.
	* The first plugin to throw an exception will be the last one.
	* If there are no filter plugins registered or none of the plugins have thrown an exception,
	* then JSONRPC_client will throw the original Exception.
	* @param Exception $exception.
	*/
	public function exceptionCatch($exception)
	{
	}
}
