<?php
require_once("JSONRPC/ClientFilterBase.php");
require_once("JSONRPC/Server.php");

/**
* JSON-RPC 2.0 client filter plugin.
* Adds APC caching.
* APC cache complete clearing can be accomplished with ::clearEntireCache(), if needed.
*/
class JSONRPC_client_filter_cache_APC extends JSONRPC_client_filter_plugin_base
{
	/**
	* String function names as keys, integer seconds as values.
	* Zero seconds means infinite.
	* Must contain only functions which are to be cached.
	*/
	protected $_arrFunctionToCacheSeconds;
	
	
	/**
	* JSONRPC request object id.
	*/
	protected $_nCallID;
	
	
	/**
	* Result retrieve from cache.
	*/
	protected $_strCachedJSONResponse;
	
	
	/**
	* Wether $_strCachedJSONResponse contains a successfully retrieved cached result.
	*/
	protected $_bServingCache=false;
	
	
	/**
	* Value read from $_arrFunctionToCacheSeconds.
	*/
	protected $_nCacheSeconds;
	
	
	/**
	* Cache store key.
	*/
	protected $_strCacheKey_temporary=NULL;
	
	
	public function __construct($arrFunctionToCacheSeconds)
	{
		$this->_arrFunctionToCacheSeconds=$arrFunctionToCacheSeconds;
	}
	
	
	public function beforeJSONEncode(&$arrRequest)
	{
		if(array_key_exists($arrRequest["method"], $this->_arrFunctionToCacheSeconds))
		{
			$this->_strCacheKey_temporary=$arrRequest["method"]."_".md5(json_encode($arrRequest["params"]));
			if(array_key_exists("lang", $arrRequest))
				$this->_strCacheKey_temporary.="_".$arrRequest["lang"];
			if(isset($_SERVER["SERVER_NAME"]))
				$this->_strCacheKey_temporary.=$_SERVER["SERVER_NAME"];
			
			$this->_strCachedJSONResponse=apc_fetch($this->_strCacheKey_temporary, $this->_bServingCache);
			
			if($this->_bServingCache)
				$this->_nCallID=$arrRequest["id"];
			else
				$this->_nCacheSeconds=$this->_arrFunctionToCacheSeconds[$arrRequest["method"]];
		}
		else
		{
			$this->_bServingCache=false;
			$this->_strCacheKey_temporary=NULL;
		}
	}
	
	
	public function makeRequest($strJSONRequest, $strEndpointURL, &$bCalled)
	{
		if($this->_bServingCache)
		{
			$bCalled=true;
			return $this->_strCachedJSONResponse;
		}
	}
	
	
	public function afterJSONDecode(&$arrResponse)
	{
		if(
			!$this->_bServingCache
			&& is_string($this->_strCacheKey_temporary)
			&& is_array($arrResponse)
			&& array_key_exists("result", $arrResponse)
			&& !array_key_exists("error", $arrResponse)
		)
		{
			assert($arrResponse["jsonrpc"]==JSONRPC_server::JSONRPC_VERSION);
			unset($arrResponse["jsonrpc"]);
			unset($arrResponse["id"]);
			
			apc_store($this->_strCacheKey_temporary, json_encode($arrResponse), $this->_nCacheSeconds);
			
			$arrResponse["jsonrpc"]=JSONRPC_server::JSONRPC_VERSION;
			$arrResponse["id"]=$this->_nCallID;
		}
		
		if($this->_bServingCache)
		{
			$arrResponse["jsonrpc"]=JSONRPC_server::JSONRPC_VERSION;
			$arrResponse["id"]=$this->_nCallID;
			
			$this->_strCachedJSONResponse=NULL;
		}
	}
	
	
	public static function clearEntireCache()
	{
		apc_clear_cache();
		apc_clear_cache("system");
		apc_clear_cache("user");
		apc_clear_cache("opcode");
	}
}
