<?php

require_once("JSONRPC/ClientFilterBase.php");


class BSI_log_plugin extends JSONRPC_client_filter_plugin_base
{
	protected $_strOutputFile;

	public function __construct()
	{
		$this->_strOutputFile = fopen("php://stdout", "w");
	}
	
	public function afterJSONEncode(&$strJSONRequest, &$strEndpointURL, &$arrHTTPHeaders)
	{
		$strNow = date("d.m.Y, G:i:s:u a");
		
		$objJSONRequest = json_decode($strJSONRequest);
		
		fwrite(
			$this->_strOutputFile,
			"\r\n" . $strNow . ": \r\n\r\n" .
			"Method: " .var_export($objJSONRequest->method,true) . "\r\n\r\n".
			"Params: " . var_export($objJSONRequest->params, true) . "\r\n\r\n"
		);
	}
	
	public function beforeJSONDecode(&$arrResponse)
	{
		$strNow = date("d.m.Y, G:i:s:u a");
		
		$objJSONRequest = json_decode($arrResponse);
		
		if(array_key_exists("result", $objJSONRequest))
		{
			fwrite(
				$this->_strOutputFile,
				"\r\n" . $strNow . ": \r\n\r\n" .
				"Result: " .var_export($objJSONRequest->result,true) . "\r\n\r\n"
			);
		}
		else if(array_key_exists("error", $objJSONRequest))
		{
			fwrite(
				$this->_strOutputFile,
				"\r\n" . $strNow . ": \r\n\r\n" .
				"Error: " .var_export($objJSONRequest->error,true) . "\r\n\r\n"
			);
		}
		else
		{
			fwrite(
					$this->_strOutputFile,
					"\r\n" . $strNow . ": \r\n\r\n" .
					"RAW Response: " .var_export($objJSONRequest,true) . "\r\n\r\n"
			);
		}
	}
}