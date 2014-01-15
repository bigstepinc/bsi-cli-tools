<?php
require_once("JSONRPC/ServerFilterBase.php");

class JSONRPC_filter_signature_verify extends JSONRPC_server_filter_plugin_base
{
	protected $_strAPIKEY;
	
	public function __construct($strAPIKEY)
	{
		$this->_strAPIKEY=$strAPIKEY;
	}
	
	public function beforeJSONDecode(&$strJSONRequest)
	{
		if(!JSONRPC_server::$bAuthenticated || !JSONRPC_server::$bAuthorized)
		{
			self::_validateSignatureURLParams();
			
			$_GET["verify"]=strtolower(trim($_GET["verify"]));
			$strHashingFunction=strlen($_GET["verify"])==32?"md5":"sha256";
			$strComparisonHash=strtolower(trim(hash_hmac($strHashingFunction, $strJSONRequest, $this->_strAPIKEY)));
			
			if($strComparisonHash!=$_GET["verify"])
			{
				throw new JSONRPC_Exception("Authentication failure. Verify hash incorrect.", JSONRPC_Exception::NOT_AUTHENTICATED);
			}
			else
			{
				JSONRPC_server::$bAuthenticated=true;
				JSONRPC_server::$bAuthorized=JSONRPC_server::$bAuthenticated;
			}
		}
		
	}
	
	
	public function afterJSONDecode(&$arrRequest)
	{
		//if(!isset($arrRequest["expires"]))
			//throw new JSONRPC_Exception("This JSON-RPC server requires the request object to be extended with the \"expires\" integer property, which must contain a unix timestamp in seconds.");
			
		if(isset($arrRequest["expires"]) && $arrRequest["expires"]<TIME)
			throw new JSONRPC_Exception("Replay attack prevention. Request is past \"expires\" timestamp. Please check your machine's date and time.");
	}

	
	private static function _validateSignatureURLParams()
	{
		if(!isset($_GET["verify"]))
			throw new JSONRPC_Exception("Missing \"verify\" URL parameter.", JSONRPC_Exception::NOT_AUTHENTICATED);
		
		$_GET["verify"]=strtolower(trim($_GET["verify"]));
		
		if(strlen($_GET["verify"])!=32 && strlen($_GET["verify"])!=64)
			throw new JSONRPC_Exception("Incorrect length for \"verify\" URL parameter. Must be 32 characters for MD5 and 64 characters for SHA256.", JSONRPC_Exception::NOT_AUTHENTICATED);
			
		if(!ctype_xdigit($_GET["verify"]))
			throw new JSONRPC_Exception("The \"verify\" URL parameter must contain only hexadecimal characters [0-9a-f].", JSONRPC_Exception::NOT_AUTHENTICATED);
	}
}
