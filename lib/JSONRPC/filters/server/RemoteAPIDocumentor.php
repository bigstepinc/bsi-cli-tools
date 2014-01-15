<?php
require_once("JSONRPC/Client.php");
require_once("JSONRPC/ServerFilterBase.php");

class JSONRPC_filter_RemoteAPIDocumentor extends JSONRPC_server_filter_plugin_base
{
	protected $_strPublishEndpointURL;
	protected $_nProjectVersionID;
	
	public function __construct($strPublishEndpointURL, $nProjectVersionID)
	{
		$this->_nProjectVersionID=$nProjectVersionID;
		$this->_strPublishEndpointURL=$strPublishEndpointURL;
	}
	
	public function beforeJSONDecode(&$strJSONRequest)
	{
		if(!strlen($strJSONRequest) && isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"]=="GET")
		{
			$rapidClient=new JSONRPC_client($this->_strPublishEndpointURL);
			
			
			$bSSLMode=isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"]=="on";
			$strFullURL=($bSSLMode?"https://":"http://").$_SERVER["HTTP_HOST"];
			if(
				($bSSLMode && (int)$_SERVER["SERVER_PORT"]!=443)
				|| (!$bSSLMode && (int)$_SERVER["SERVER_PORT"]!=80)
			)
				$strFullURL.=":".(int)$_SERVER["SERVER_PORT"];
			$strFullURL.=$_SERVER["REQUEST_URI"];
			
			
			$strHTMLDocumentation=$rapidClient->published_html_interface(
				$this->_nProjectVersionID,
				$strFullURL,
				$this->_strPublishEndpointURL,
				JSONRPC_server::$arrAllowedFunctionCalls
			);
			
			
			header("Content-type: text/html; charset=utf-8");
			
			echo $strHTMLDocumentation;
			
			exit(0);
		}
	}
}
