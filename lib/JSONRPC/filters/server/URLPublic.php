<?php
require_once("JSONRPC/Server.php");
require_once("JSONRPC/ServerFilterBase.php");

class JSONRPC_filter_url_public extends JSONRPC_server_filter_plugin_base
{
	protected $_arrEncryptionKeys;
	protected $_strAPIKEY;
	protected $_strKeyIndex;
	
	
	public function __construct($arrEncryptionKeys, $strKeyIndex, $strAPIKEY)
	{
		$this->_arrEncryptionKeys=$arrEncryptionKeys;
		$this->_strKeyIndex=$strKeyIndex;
		$this->_strAPIKEY=$strAPIKEY;
	}
	
	
	public function beforeJSONDecode(&$strJSONRequest)
	{
		$strJSONRequest=$this->PublicURLParamsToJSONRequest($_GET);
		
		
		$arrRequest=json_decode($strJSONRequest, true);
		if(json_last_error()!==JSON_ERROR_NONE)
			throw new JSONRPC_Exception("Failed to decode URL request.");

		$arrRequest["id"]=NULL;
		$arrRequest["jsonrpc"]=JSONRPC_server::JSONRPC_VERSION;
		
		$arrRequest["method"]=$arrRequest["m"];
		$arrRequest["params"]=$arrRequest["p"];
		unset($arrRequest["m"]);
		unset($arrRequest["p"]);
		
		if(isset($arrRequest["e"]))
		{
			$arrRequest["expires"]=$arrRequest["e"];
			unset($arrRequest["e"]);
			
			if($arrRequest["expires"]<time())
				throw new JSONRPC_Exception("Replay attack prevention. Request is past \"expires\" timestamp.", JSONRPC_Exception::REQUEST_EXPIRED);
		}
		
			
		//PublicURLParamsToJSONRequest throws if something goes wrong.
		JSONRPC_server::$bAuthenticated=true;
		JSONRPC_server::$bAuthorized=JSONRPC_server::$bAuthenticated;
		
		$strJSONRequest=json_encode($arrRequest);
	}


	
	/**
	* Returns a HTTP URL with the function call with the request HTTP param encrypted so that the link can be exposed in browsers, e-mails, etc.
	* Functions called by a JSONRPC URL do not have to return in JSONRPC format necessarily, and may instead issue HTTP redirects, render HTML documents, force downloads, etc.
	* @param string $strEndpointURL.
	* @param string $strFunctionName.
	* @param array $arrParams.
	* @param int $nMaxAgeSeconds=NULL.
	*/
	public function URLRequestGenerate($strEndpointURL, $strFunctionName, $arrParams, $nMaxAgeSeconds=NULL, $nMode=self::MODE_AES_128)
	{
		$arrRequest=array(
			"m"=>$strFunctionName, 
			"p"=>$arrParams,
		);
		if(isset($nMaxAgeSeconds))
			$arrRequest["e"]=time()+(int)$nMaxAgeSeconds;
		
		return $this->JSONRequestToPublicURL($strEndpointURL, json_encode($arrRequest), $nMode);
	}
	
	
	public function URLParamDecrypt($strBase64Data, $strIV)
	{
		$strEncryptedData=base64_decode($strBase64Data, true);
		if($strEncryptedData===false)
			throw new Exception("Base64 input contains characters outside of the base64 character set.");
		
		$strIVBytes=self::hex2raw($strIV);
		
		$strDecryptedCompressed=mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->_arrEncryptionKeys[$this->_strKeyIndex], $strEncryptedData, MCRYPT_MODE_CBC, $strIVBytes);
		
		$strReturn=gzinflate($strDecryptedCompressed);
		
		return (string)$strReturn;
	}

	
	public function URLParamDecode($strBase64Data)
	{
		$strGzDeflatedData=base64_decode($strBase64Data, true);
		if($strGzDeflatedData===false)
			throw new Exception("Base64 input contains characters outside of the base64 character set.");
		
		$strReturn=gzinflate($strGzDeflatedData);
		
		return (string)$strReturn;
	}
	
	public function URLParamEncrypt($strData, $strIV)
	{
		$strCompressedData=gzdeflate($strData, 9);
		if($strCompressedData===false)
			throw new Exception("Failed to compress data before encryption.");
		
		$strIVBytes=self::hex2raw($strIV);
		
		$strEncryptedData=mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->_arrEncryptionKeys[$this->_strKeyIndex], $strCompressedData, MCRYPT_MODE_CBC, $strIVBytes);
		
		$strBase64=base64_encode($strEncryptedData);
		
		//if(md5($this->URLParamDecrypt($strBase64, self::raw2hex($strIVBytes)))!=md5($strData))
			//throw new Exception("Encrypted data failed decryption test.");
		
		return $strBase64;
	}
	
	
	public function JSONRequestToPublicURL($strRequestURL, $strJSONRequest, $nMode=self::MODE_AES_128)
	{
		if ($nMode==self::MODE_PLAIN)
			$arrPublicRequest=$this->JSONRequestToURLPlainParams($strJSONRequest);			
		else if ($nMode==self::MODE_AES_128)
			$arrPublicRequest=$this->JSONRequestToURLEncryptedParams($strJSONRequest);
		else if ($nMode==self::MODE_BASE64)
			$arrPublicRequest=$this->JSONRequestToURLBase64Params($strJSONRequest);
		else 
			throw new JSONRPC_Exception("Unknown mode specified");
		
		if((int)$nMode!= /*default*/ self::MODE_AES_128)
			$arrPublicRequest["m"]=(int)$nMode;
	
		if(strpos($strRequestURL, "?")!==false)
			$strRequestURL.="&";
		else
			$strRequestURL.="?";
		
		//Does not check for existing URL params. Either way, deduplication or overwriting must be considered a conflict and must be resolved.
		$strRequestURL.=http_build_query($arrPublicRequest);

		return $strRequestURL;
	}
	
	
	public function PublicURLParamsToJSONRequest($arrParams, $bEmptyOnError=false)
	{
		try
		{
			foreach($this->_arrEncryptionKeys as $strKeyIndex=>$strKey)
			{
				if(isset($arrParams[$strKeyIndex]))
				{
					$this->_strKeyIndex=$strKeyIndex;
					
					$arrParams[$strKeyIndex]=str_replace(" ", "+", $arrParams[$strKeyIndex]);//invalid text transform text mail clients fix
					
					$strVerify=self::raw2hex(base64_decode(self::base64URLUnescape($arrParams["v"]), true));
					
					$nMode=array_key_exists("m", $arrParams)
						? (int)$arrParams["m"] 
						: self::MODE_AES_128
					;

					if ($nMode==self::MODE_AES_128)
						$strJSONRequest=$this->URLParamDecrypt(self::base64URLUnescape($arrParams[$strKeyIndex]), $strVerify, $strKeyIndex);
					else if ($nMode==self::MODE_PLAIN)
						$strJSONRequest=$arrParams[$strKeyIndex];
					else if ($nMode==self::MODE_BASE64)
						$strJSONRequest=$this->URLParamDecode(self::base64URLUnescape($arrParams[$strKeyIndex]));
					else 
						throw new JSONRPC_Exception("Unknown mode specified"); 

					$strSignatureForComparison=$this->JSONRequestSignatureAndIV($strJSONRequest);
					
					if($strSignatureForComparison!=$strVerify)
						throw new JSONRPC_Exception("Authentication failure. Verify hash incorrect.", JSONRPC_Exception::NOT_AUTHENTICATED);
				
					return $strJSONRequest;
				}
			}
			
			throw new JSONRPC_Exception("Invalid params.");
		}
		catch(Exception $exc)
		{
			if($bEmptyOnError)
				return json_encode(array());
			throw $exc;
		}
	}
	
	
	public function JSONRequestToURLEncryptedParams($strJSONRequest)
	{
		$strIVAndSignature=$this->JSONRequestSignatureAndIV($strJSONRequest);
		
		$strEncryptedParam=self::URLParamEncrypt($strJSONRequest, $strIVAndSignature);
		
		$arrProtectedOptions=array(
			$this->_strKeyIndex=>self::base64URLEscape($strEncryptedParam),
			"v"=>self::base64URLEscape(base64_encode(self::hex2raw($strIVAndSignature))),
		);
		
		return $arrProtectedOptions;
	}


	public function JSONRequestToURLPlainParams($strJSONRequest)
	{
		$strIVAndSignature=$this->JSONRequestSignatureAndIV($strJSONRequest);
	
		
		$arrProtectedOptions=array(
			$this->_strKeyIndex=>$strJSONRequest,
			"v"=>self::base64URLEscape(base64_encode(self::hex2raw($strIVAndSignature))),
		);
		
		return $arrProtectedOptions;
	}
	

	public function JSONRequestToURLBase64Params($strJSONRequest)
	{
		$strIVAndSignature=$this->JSONRequestSignatureAndIV($strJSONRequest);
	
		$strCompressedData=gzdeflate($strJSONRequest, 9);
		if($strCompressedData===false)
			throw new Exception("Failed to compress data.");
			
		$strBase64=base64_encode($strCompressedData);
		
		$arrProtectedOptions=array(
			$this->_strKeyIndex=>self::base64URLEscape($strBase64),
			"v"=>self::base64URLEscape(base64_encode(self::hex2raw($strIVAndSignature))),
		);
		
		return $arrProtectedOptions;
	}
	
	public function JSONRequestSignatureAndIV($strJSONRequest)
	{
		return strtolower(hash_hmac("md5", $strJSONRequest, $this->_strAPIKEY));
	}
	
	
	public static function base64URLEscape($strBase64)
	{
		return str_replace(array("+", "/", "="), array("-", "_", "" /*.*/), $strBase64);
	}

	
	public static function base64URLUnescape($strBase64URLSafe)
	{
		return str_replace(array("-", "_", "."), array("+", "/", "="), $strBase64URLSafe);
	}
	
	
	public static function hex2raw($strHexString)
	{
		$strRawBytes="";
		$arrChunks=str_split($strHexString, 2);
		for($i=0; $i<count($arrChunks); $i++)
			$strRawBytes.=chr(hexdec($arrChunks[$i]));
		return $strRawBytes;
	}
	
	public static function raw2hex($s)
	{
		$op="";
		for($i = 0; $i < strlen($s); $i++)
			$op.=str_pad(dechex(ord($s[$i])), 2, "0", STR_PAD_LEFT);
		return $op;
	}

	const MODE_AES_128=0;
	const MODE_PLAIN=1;
	const MODE_BASE64=2;
}
