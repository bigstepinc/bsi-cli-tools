<?php
require_once("JSONRPC/ClientFilterBase.php");

/**
* JSON-RPC 2.0 client filter plugin.
* Adds authentication and signed request expiration for the JSONRPC ResellerDomainsAPI.
* Also translates thrown exceptions.
*/
class JSONRPC_filter_signature_add extends JSONRPC_client_filter_plugin_base
{
	protected $_strAPIKEY;
	protected $_arrExtraURLVariables;
	
	
	public function __construct($strAPIKEY, $arrExtraURLVariables=array())
	{
		$this->_strAPIKEY=$strAPIKEY;
		$this->_arrExtraURLVariables=$arrExtraURLVariables;
	}
	
	
	public function beforeJSONEncode(&$arrRequest)
	{
		$arrRequest["expires"]=time()+86400;
	}
	
	
	public function afterJSONEncode(&$strJSONRequest, &$strEndpointURL, &$arrHTTPHeaders)
	{
		static $strHashingFunction=NULL;
		
		if(!isset($strHashingFunction))
		{
			if(in_array("sha256", hash_algos()))
				$strHashingFunction="sha256";
			else if(in_array("md5", hash_algos()))
				$strHashingFunction="md5";
			else
				throw new Exception("hash_algos() does not list at least one of the required hashing functions: md5 or sha256.");
		}
		
		$strVerifyHash=hash_hmac($strHashingFunction, $strJSONRequest, $this->_strAPIKEY);
		
		if(strpos($strEndpointURL, "?")!==false)
			$strEndpointURL.="&";
		else
			$strEndpointURL.="?";
		
		//Does not check for existing URL params. Either way, duplication or overwriting must be considered a conflict and must be resolved.
		$strEndpointURL.="verify=".urlencode($strVerifyHash);
		
		foreach($this->_arrExtraURLVariables as $strKey=>$strValue)
			$strEndpointURL.="&".urlencode($strKey)."=".urlencode($strValue);
	}
}
