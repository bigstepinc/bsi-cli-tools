<?php

/**
 * Callback class that retains the additional parameters of the call besides the call result. 
 * It is used by the JSONRPC_process_forker_client plugin.
 */
class JSONRPC_process_forker_callback
{
	/**
	 * @var array The additional parameters of the callback besides the call result.
	 */
	protected $_arrParameters = array();
	/**
	 * @var callable Callback function
	 */
	protected $_callableFunction = NULL;
	
	
	/**
	 * Class constructor that initializes the callback function and parameters.
	 *
	 * @param callable callableFunction The callback function to be called.
	 * @param array arrParams The callback function parameters.
	 *
	 * @return null.
	 */
	public function __construct($callableFunction, $arrParameters = array())
	{
		if(!is_callable($callableFunction))
			throw new Exception("Invalid callback function. The callback function must be callable.");
	
		$this->_callableFunction = $callableFunction;
		$this->_arrParameters = $arrParameters;
	}
	
	/**
	 * Calls the callback function with the given parameters and the provided result.
	 *
	 * @param mixed mixedResult The result of the function call.
	 *
	 * @return null.
	 */
	public function call($mixedResult)
	{
		call_user_func_array(
			$this->_callableFunction,
			array_merge(
				array(
					$mixedResult
				),
				$this->_arrParameters
			)
		);
	}
}
