<?php
require_once("JSONRPC/ClientFilterBase.php");

/**
* JSON-RPC 2.0 client filter plugin.
* Adds authentication and signed request expiration for the JSONRPC ResellerDomainsAPI.
* Also translates thrown exceptions.
*/
class DebugLogger extends JSONRPC_client_filter_plugin_base
{
	const LOG_TO_CONSOLE=true;
	const LOG_TO_FILE=false;

	public $strLogPath="php://stdout";

	
	public function __construct($bLogType, $strLogPath="php://stdout")
	{
		if(!$bLogType)
		{
			if($strLogPath!="php://stdout")
				$this->strLogPath=$strLogPath;
			else
				throw new Exception("No log path specified");
		}
	}
	
	
	public function afterJSONEncode(&$strJSONRequest, &$strEndpointURL, &$arrHTTPHeaders)
	{
		ob_start();

		echo "Sent request at: ".date("Y-m-d H:i:s. O e ")."\n";
		echo $this->json_format($strJSONRequest);
		echo "\n\n\n";

		$this->logger(ob_get_clean());
	}	
	

	public function beforeJSONDecode(&$strJSONResponse)
	{
		ob_start();

		echo "Received response at ".date("Y-m-d H:i:s O e ")."\n";
		echo $this->json_format($strJSONResponse);
		echo "\n\n\n";

		$this->logger(ob_get_clean());
	}


	public function json_format($strJSON, $nIndentLevel=0, $strTabCharacter="  ")
	{
	    $strNewJSON="";
	    $bInString=false;

	    $nLength=strlen($strJSON);

		$strNewJSON.=str_repeat($strTabCharacter, $nIndentLevel);
		
	    for($nCharacterPosition=0; $nCharacterPosition<$nLength; $nCharacterPosition++)
	    {
	        $strCharacter=$strJSON[$nCharacterPosition];
			switch($strCharacter)
	        {
	            case "{":
	            case "[":
					if(!$bInString)
	                {
	                    $strNewJSON.=$strCharacter."\r\n".str_repeat($strTabCharacter, $nIndentLevel+1);
	                    $nIndentLevel++;
	                }
	                else
	                    $strNewJSON.=$strCharacter;
	                break;
	            case "}":
	            case "]":
	                if(!$bInString)
	                {
	                    $nIndentLevel--;
	                    $strNewJSON.="\r\n".str_repeat($strTabCharacter, $nIndentLevel).$strCharacter;
	                }
	                else
	                    $strNewJSON.=$strCharacter;
	                break;
	            case ",":
	                if(!$bInString)
	                    $strNewJSON.=",\r\n".str_repeat($strTabCharacter, $nIndentLevel);
	                else
	                    $strNewJSON.=$strCharacter;
	                break;
	            case ":":
	                if(!$bInString)
	                    $strNewJSON.=": ";
	                else
	                    $strNewJSON.=$strCharacter;
	                break;
	            case "\"":
	                if($nCharacterPosition > 0 && $strJSON[$nCharacterPosition-1] != "\\")
	                    $bInString=!$bInString;
	            default:
	                $strNewJSON.=$strCharacter;
	                break;                    
	        }
	    }

	    return $strNewJSON;
	}


	public function logger($string)
	{
		file_put_contents($this->strLogPath, $string, FILE_APPEND);
	}
}


