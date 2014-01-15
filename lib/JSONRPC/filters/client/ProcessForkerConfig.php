<?php

/**
 * Config class that retains the configuration parameters for each call. 
 */
class JSONRPC_process_forker_config
{
	/**
	 * @var bool _bRunAsPrivilegedUser Determines the process forker plugin to use
	 * sudo for the call.
	 */
	protected $_bRunAsPrivilegedUser = NULL;
	
	
	/**
	 * Class constructor that initializes the config parameters.
	 *
	 * @param bool bRunAsPrivilegedUser. Determines the process forker plugin to use
	 * sudo for the call.
	 *
	 * @return null.
	 */
	public function __construct($bRunAsPrivilegedUser = false)
	{
		$this->_bRunAsPrivilegedUser = $bRunAsPrivilegedUser;
	}
	
	/**
	 * @return bool. Run with sudo or not.
	 */
	public function runAsPrivilegedUser()
	{
		return $this->_bRunAsPrivilegedUser;
	}
}
