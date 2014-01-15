<?php
class JSONRPC_client_filter_plugin_base
{
	public function __construct()
	{
	}
	
	
	/**
	* Should be used to 
	* - add extra request object keys;
	* - translate or encode output params into the expected server request object format.
	* @param array &$arrRequest.
	*/
	public function beforeJSONEncode(&$arrRequest)
	{
	}
	
	
	/**
	* Should be used to 
	* - encrypt, encode or otherwise prepare the JSON request string into the expected server input format;
	* - log raw output.
	* @param string &$strJSONRequest.
	* @param string &$strEndpointURL.
	* @param string &$arrHTTPHeaders.
	*/
	public function afterJSONEncode(&$strJSONRequest, &$strEndpointURL, &$arrHTTPHeaders)
	{
	}
	
	
	/**
	* First plugin to make a request will be the last one. The respective plugin MUST set &$bCalled to true.
	* @return mixed. The RAW string output of the server or false on error (or can throw).
	*/
	public function makeRequest($strJSONRequest, $strEndpointURL, &$bCalled)
	{
	}


	/**
	* Should be used to 
	* - decrypt, decode or otherwise prepare the JSON response into the expected JSON-RPC client format;
	* - log raw input.
	* @param string &$strJSONResponse.
	*/
	public function beforeJSONDecode(&$strJSONResponse)
	{
	}
	
	
	/**
	* Should be used to 
	* - add extra response object keys;
	* - translate or decode response params into the expected JSON-RPC client response object format.
	* @param array &$arrResponse.
	*/
	public function afterJSONDecode(&$arrResponse)
	{
	}


	/**
	* Should be used to rethrow exceptions as different types.
	* The first plugin to throw an exception will be the last one.
	* If there are no filter plugins registered or none of the plugins have thrown an exception,
	* then JSONRPC_client will throw the original JSONRPC_Exception.
	* @param JSONRPC_Exception $exception.
	*/
	public function exceptionCatch($exception)
	{
	}
}
