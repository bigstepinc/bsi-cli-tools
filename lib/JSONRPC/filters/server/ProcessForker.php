<?php

require_once("JSONRPC/Server.php");
require_once("JSONRPC/ServerFilterBase.php");
require_once("JSONRPC/filters/client/ProcessForker.php");


/**
 * JSONRPC_server plugin that overrides the client's 
 */
class JSONRPC_process_forker_server extends JSONRPC_server_filter_plugin_base
{
	/**
	 *	@var int nIOTimeout The IO operations timeout in microseconds.
	 */
	protected $_nIOTimeout = -1;
	/**
	 * @var array arrStreamStates Array of objects with the saved states of the following
	 * streams: STDIN, STDOUT and STDERR.
	 */
	 protected $_arrStreamStates = array();
	
	
	/**
	 * Class constructor used to alter the used timeouts.
	 *
	 * @param int nIOTimeout The IO operations timeout. Defaults to -1(INFINITE).
	 *
	 * @return null.
	 */
	public function __construct($nIOTimeout = -1)
	{
		$this->_nIOTimeout = $nIOTimeout;
	}

	/**
	 * Reads the request from STDIN and updates the strJSONRequest to the read value.
	 *
	 * @param string strJSONRequest The JSON request reference that will be replaced with
	 * the read JSON request.
	 */
	public function beforeJSONDecode(&$strJSONRequest)
	{
		if(strcasecmp(php_sapi_name(), "cli"))
			throw new Exception("Invalid SAPI. The process forker requires CLI SAPI.");
			
		$arrStreams = array(
			STDIN,
			STDOUT,
			STDERR
		);
		
		foreach($arrStreams as $hStreamHandle)
			if(!stream_is_local($hStreamHandle))
				throw new Exception("The STDIN, STDOUT and STDERR streams must be local.");
	
		$this->_saveStreamStates();
		
		stream_set_blocking(STDIN, false);
		
		/* No synchronization needed. The data is already in the STDIN file. */
		$strJSONRequest = JSONRPC_process_forker_client::fread(STDIN, $this->_nIOTimeout);
		if($strJSONRequest === false)
			throw new Exception("STDIN read failed. The request couldn't be read.");
			
		$this->_restoreStreamStates();
		
		/* The signature add plugin uses GET parameters which can't be used in CLI mode. As 
		a result the process forker server plugin needs to set the authenticated and authorized
		flags as well. */
		JSONRPC_server::$bAuthenticated = true;
		JSONRPC_server::$bAuthorized = true;
	}
	
	/**
	 * Saves the current stream states of the following streams for future restoration: STDIN, 
	 * STDOUT and STDERR.
	 *
	 * @return null.
	 */
	protected function _saveStreamStates()
	{	
		$arrStreams = array(
			JSONRPC_process_forker_client::STDIN => STDIN,
			JSONRPC_process_forker_client::STDOUT => STDOUT,
			JSONRPC_process_forker_client::STDERR => STDERR
		);
		
		foreach($arrStreams as $nStreamIndex => $hStreamHandle)
			$this->_arrStreamStates[$nStreamIndex] = stream_get_meta_data($hStreamHandle);
	}
	
	/**
	 * Restores the following streams to their previously saved states: STDIN, STDOUT and
	 * STDERR.
	 *
	 * @return null.
	 */
	protected function _restoreStreamStates()
	{
		foreach($this->_arrStreamStates as $nStreamIndex => $objStreamState)
		{
			$hStreamHandle = NULL;
		
			switch($nStreamIndex)
			{
				case JSONRPC_process_forker_client::STDIN:
					$hStreamHandle = STDIN;
					break;
					
				case JSONRPC_process_forker_client::STDOUT:
					$hStreamHandle = STDOUT;
					break;
					
				case JSONRPC_process_forker_client::STDERR:
					$hStreamHandle = STDERR;
					break;
					
				default:
					throw new Exception("Invalid saved stream index. You've reached unreachable code.");
			}
			
			/* The plugin modified only the blocking property.  */
			stream_set_blocking($hStreamHandle, $objStreamState["blocked"]);
		}
	}
}
