<?php

require_once("JSONRPC/Server.php");
require_once("JSONRPC/Client.php");
require_once("JSONRPC/ClientFilterBase.php");
require_once("JSONRPC/filters/client/ProcessForkerCallback.php");
require_once("JSONRPC/filters/client/ProcessForkerConfig.php");


/**
 * JSONRPC_client plugin that overrides the client's default synchronous behaviour making it
 * asynchronous. It creates new CLI PHP processes on the same machine with the client and 
 * sends them requests via pipes/files. It can be used to launch multiple functions in parallel
 * on child processes and to control these processes.
 *
 * TODO: Limit the number of running processes and use the arrNewProcesses to delay
 * requests.
 * TODO: Write process stream lock function for synchronization.
 * TODO: The other TODOs in this document.
 */
class JSONRPC_process_forker_client extends JSONRPC_client_filter_plugin_base
{
	/**
	 * STDIN pipe index.
	 */
	const STDIN = 0;
	
	/**
	 * STDOUT pipe index.
	 */
	const STDOUT = 1;
	
	/**
	 * STDERR pipe index.
	 */
	const STDERR = 2;
	
	/**
	* The temporary files name prefix.
	*/
	const TEMPORARY_FILE_NAME_PREFIX = "PROCESS_FORKER_";
	
	
	/**
	* @var string _strTemporaryDirectoryPath The temporary directory to use for temporary
	* files. 
	*/
	protected $_strTemporaryDirectoryPath = NULL;
	
	/**
	* @var array _arrEnvironmentVariables The environment variables to pass to the child
	* processes.
	*/
	protected $_arrEnvironmentVariables = array();
	
	/**
	* @var array _arrNewProcesses An array of objects containing information about all
	* the new processes indexed by the call ID in the following format:
	*	array(
	* 		"callback" => JSONRPC_proces_forker_callback,
	*			"config" => JSONRPC_proces_forker_config,
	* 		"json_request" => "{}",
	* 		"endpoint_url" => "/var/vhosts/test/api.php",
	* 		"handle" => $hProcessHandle,
	* 		"pipes" => array(
	* 			1 => $hStdin,
	* 			2 => $hStdout,
	* 			3 => $hStderr
	* 		)
	* 	).
	* This exists for future extensions. It may be used to delay process creation and limit the
	* number of running processes.
	*/
	protected $_arrNewProcesses = array();
	
	/**
	* @var array _arrRunningProcesses An array of objects containing information about all 
	* the failed processes indexed by the call ID in the same format of the running processes
	* array.
	*/
	protected  $_arrRunningProcesses = array();
	
	/**
	* @var array _arrFailedProcesses An array of objects containing information about all the
	* failed processes indexed by the call ID in the same format of the running processes
	* array.
	*/
	protected $_arrFailedProcesses = array();
	
	/**
	* @var int _nCallIDTemp The last call's temporary ID. Used as index for all the arrays that
	* retain useful information about the running worker processes.
	*/
	protected $_nCallIDTemp = NULL;
	
	/**
	* @staticvar object _JSONRPCClient JSONRPC_client instance used to access the
	* processRAWResponse method.
	*/
	protected static $_JSONRPCClient = NULL;
	
	/**
	* Class constructor that initializes the child environment.
	*
	* @param array arrEnvironmentVariables The environment variables that need to be
	* passed to the child processes.
	* @return null.
	*/
	public function __construct($arrEnvironmentVariables = array(), $strTemporaryDirectoryPath = NULL)
	{
		if(!is_array($arrEnvironmentVariables))
			throw new Exception("Invalid environment variables. The parameter must be an array.");
	
		$this->_arrEnvironmentVariables = array_merge(
			$_ENV,
			$arrEnvironmentVariables
		);
		
		if(is_null($strTemporaryDirectoryPath))
			$strTemporaryDirectoryPath = sys_get_temp_dir(); /* Use system temporary directory. */
		else if(!is_string($strTemporaryDirectoryPath))
			throw new Exception("Invalid temporary directory path. It must be a string.");
		else if(!file_exists($strTemporaryDirectoryPath))
			mkdir($strTemporaryDirectoryPath, 0777, true);
			
		$this->_strTemporaryDirectoryPath = $strTemporaryDirectoryPath;
	}

	/**
	* Extracts the callback function and memorizes it.
	*
	* @param array arrRequest The request body.
	*/
	public function beforeJSONEncode(&$arrRequest)
	{
		assert(is_null($this->_nCallIDTemp));
		assert(is_int($arrRequest["id"]) && $arrRequest["id"] > 0);
		assert(!array_key_exists($arrRequest["id"], $this->_arrNewProcesses));
		assert(!array_key_exists($arrRequest["id"], $this->_arrRunningProcesses));
		assert(!array_key_exists($arrRequest["id"], $this->_arrFailedProcesses));
		
		if(isset($arrRequest["params"][0]) && is_object($arrRequest["params"][0]) && !strcasecmp(get_class($arrRequest["params"][0]), "JSONRPC_process_forker_config"))
			$this->_arrNewProcesses[$arrRequest["id"]]["config"] = array_shift($arrRequest["params"]);
		else
			$this->_arrNewProcesses[$arrRequest["id"]]["config"] = new JSONRPC_process_forker_config();
		
		if(isset($arrRequest["params"][0]) && is_object($arrRequest["params"][0]) && !strcasecmp(get_class($arrRequest["params"][0]), "JSONRPC_process_forker_callback"))
			$this->_arrNewProcesses[$arrRequest["id"]]["callback"] = array_shift($arrRequest["params"]);
		else
			$this->_arrNewProcesses[$arrRequest["id"]]["callback"] = NULL;

		$this->_nCallIDTemp = $arrRequest["id"];
	}

	/**
	* Creates a new process and sends the request.
	*
	* @param string strJSONRequest The JSON encoded request.
	* @param string strEndpointURL The endpoint URL to use with the php command.
	* @param bool bCalled The bCalled variable from the JSONRPC_client sent by reference.
	* It is set to true in order to override the default JSONRPC_client makeRequest
	* mechanism.
	* 
	* @return string Asynchronous fake success. 
	*/
	public function makeRequest($strJSONRequest, $strEndpointURL, &$bCalled)
	{
		$bCalled = true;
		
		$nCallID = $this->_nCallIDTemp;
		$this->_nCallIDTemp = NULL;
		
		$this->_arrNewProcesses[$nCallID]["json_request"] = $strJSONRequest;
		$this->_arrNewProcesses[$nCallID]["endpoint_url"] = $strEndpointURL;

		$CaughtException = NULL;
		
		try
		{
			$strStdinTmpFile = tempnam(
				$this->_strTemporaryDirectoryPath,
				self::TEMPORARY_FILE_NAME_PREFIX."STDIN_"
			);
			if($strStdinTmpFile === false)
				throw new Exception("STDIN file creation failed.");
			
			$hStdinTmpFile = fopen($strStdinTmpFile, "w");
			if(!is_resource($hStdinTmpFile))
				throw new Exception("STDIN file open failed.");
			
			/* Set the file to unblocking in order to avoid the process to hang when writing. */
			if(!stream_set_blocking($hStdinTmpFile, false))
				throw new Exception("Making the STDIN stream non-blocking failed.");

			/* Write to the STDIN file before creating a child process to avoid synchronization. */
			if(!self::fwrite($hStdinTmpFile, $strJSONRequest))
				throw new Exception("STDIN file write failed. The JSON request couldn't be written.");
			
			/* Don't need the file any more. Ignore fclose failure. */
			fclose($hStdinTmpFile);

			$arrDescriptor = array(
				self::STDIN => array("file", $strStdinTmpFile, "r"),
				self::STDOUT => array("pipe", "w"),
				self::STDERR => array("pipe", "w"),
			);

			if($this->_arrNewProcesses[$nCallID]["config"]->runAsPrivilegedUser())
				$strPrepend = "sudo -n -E ";
			else
				$strPrepend = "";

			/* Change the behaviour of the proc_open function by using exec. Avoid the creation
			of an additional shell process. */
			$this->_arrNewProcesses[$nCallID]["handle"] = proc_open(
				"exec " . $strPrepend . " php ".$strEndpointURL,
				$arrDescriptor,
				$this->_arrNewProcesses[$nCallID]["pipes"],
				NULL, /* default cwd path */
				$this->_arrEnvironmentVariables
			);
			if(!is_resource($this->_arrNewProcesses[$nCallID]["handle"]))
				throw new Exception("Child process creation failed.");
			
			$this->_arrRunningProcesses[$nCallID] = $this->_arrNewProcesses[$nCallID];
			
			foreach($this->_arrNewProcesses[$nCallID]["pipes"] as $hProcessPipe)
			{
				if(!is_resource($hProcessPipe))
				{
					$this->killProcess($nCallID);
					throw new Exception("Process pipe is invalid.");
				}
				
				if(!stream_set_blocking($hProcessPipe, false))
				{
					$this->killProcess($nCallID);
					throw new Exception("Process pipe set unblocking property failed."); 
				}
			}
		}
		catch(Exception $e)
		{
			$CaughtException = $e;
			
			$this->_arrFailedProcesses[$nCallID] = $this->_arrNewProcesses[$nCallID];
		}
		
		unset($this->_arrNewProcesses[$nCallID]);

		/* The file will be deleted when it won't be used by a process any more. The file is
		opened by the current process. The errors are logged.*/
		try
		{
			if(file_exists($strStdinTmpFile))
				unlink($strStdinTmpFile);
		}
		catch(Exception $e)
		{
			try
			{
				$strTrace=var_export($e->getTrace(), true);
			}
			catch(Exception $exc)
			{
				$strTrace=$e->getTraceAsString();
			}
			
			error_log("ProcessForker cleanup failed with message: ".$e->getMessage().". ".__FILE__."#".__LINE__.PHP_EOL.$strTrace);
		}
		
		/* Synchronous behaviour if no callback has been specified. */
		if(is_null($CaughtException) && is_null($this->_arrRunningProcesses[$nCallID]["callback"]))
		{
			/* Wait indefinitely. */
			$mxProcessStatus = $this->waitProcess($nCallID);
			
			$mxProcessOutput = self::fread($this->_arrRunningProcesses[$nCallID]["pipes"][self::STDOUT]);
			if($mxProcessOutput === false)
			{
				if($mxProcessStatus)
				{
					$mxProcessError = self::fread($this->_arrRunningProcesses[$nCallID]["pipes"][self::STDERR]);
					$strProcessError = $mxProcessError ? $mxProcessError:"Unknown error";	

					throw new Exception("Child process encountered an error with the following message: ".$strProcessError.".");	
				}
				else
					throw new Exception("Child process output read timed out.");
			}
			
			$this->closeProcess($nCallID);
			
			return $mxProcessOutput;
		}
			
		$arrFakeSuccess = array(
			"result" => NULL,
			"id" => $nCallID,
			"jsonrpc" => JSONRPC_server::JSONRPC_VERSION
		);
		
		if(!is_null($CaughtException))
				throw $CaughtException;
		
		return json_encode($arrFakeSuccess);
	}
	
	/**
	* Wait for some child processes to finish execution and execute the callbacks if any.
	*
	* @param int nSelectTimeout The select timeout in microseconds. Defaults to -1
	* (INFINITE).
	* @param int nProcessTimeout The process timeout in microseconds. Defaults to -1
	* (INFINITE).
	* @param int nIOTimeout The IO operations timeout in microseconds. Defaults to -1
	* (INFINITE).
	*
	* @return int. The number of finished processes.
	*/
	public function selectRequests($nSelectTimeout = -1, $nProcessTimeout = -1, $nIOTimeout = -1)
	{
		$nSelectTimeoutSec = 0;
	
		/* The select function uses NULL as a value for INFINITE. */
		if($nSelectTimeout === -1)
		{
			$nSelectTimeout = NULL;
			$nSelectTimeoutSec = NULL;
		}
	
		/* Lazy initialization. */
		if(is_null(self::$_JSONRPCClient))
			self::$_JSONRPCClient = new JSONRPC_client(NULL);

		/* Compose the select array. */
		$arrStdoutAndStderrProcessPipes = array();
		
		foreach($this->_arrRunningProcesses as $objProcess)
		{
			$arrStdoutAndStderrProcessPipes []= $objProcess["pipes"][self::STDOUT];
			$arrStdoutAndStderrProcessPipes []= $objProcess["pipes"][self::STDERR];
		}
		
		/* If there are no running processes return. */
		if(!count($arrStdoutAndStderrProcessPipes))
			return 0;
		
		/* Avoid select error. */
		$Null = NULL;
		
		/* Select doesn't work on windows for pipes opened by proc_open function. If a process
		dies before it could output anything the select function will consider the STDOUT and 
		STDERR pipes ready for reading. */
		$nNoOfEvents = @stream_select($arrStdoutAndStderrProcessPipes, $Null, $Null, $nSelectTimeoutSec, $nSelectTimeout);
		if($nNoOfEvents === false)
			throw new Exception("Process pipes select failed.");
		
		/* No events occurred. */
		if(!$nNoOfEvents)
			return 0;
		
		$nFinishedProcesses = 0;
		
		foreach($arrStdoutAndStderrProcessPipes as $hProcessPipe)
		{
			$nProcessIndex = NULL;
			$nProcessPipeIndex = NULL;
		
			foreach($this->_arrRunningProcesses as $nCallID => $objProcess)
			{
				if($hProcessPipe === $objProcess["pipes"][self::STDOUT])
				{
					$nProcessIndex = $nCallID;
					$nProcessPipeIndex = self::STDOUT;
					
					break;
				}
				if($hProcessPipe === $objProcess["pipes"][self::STDERR])
				{
					$nProcessIndex = $nCallID;
					$nProcessPipeIndex = self::STDERR;
					
					break;
				}
			}
			
			if(!is_null($nProcessIndex) && !is_null($nProcessPipeIndex))
			{
				$nProcessEndStatus = $this->waitProcess($nProcessIndex, $nProcessTimeout);
				/* If there is data to be read but the process is still running ignore. */
				if($nProcessEndStatus === false)
					continue;
				
				try
				{
					$strProcessOutput = self::fread($hProcessPipe, $nIOTimeout);
					if($strProcessOutput === false)
							throw new Exception("Process pipe read failed.");
					
					if($nProcessPipeIndex === self::STDERR)
						throw new Exception("Process encountered an error with the following message: ".$strProcessOutput.".");
					
					$mxProcessOutput = self::$_JSONRPCClient->processRAWResponse($strProcessOutput, false);
				}
				catch(Exception $e)
				{
					$mxProcessOutput = $e;
					
					$this->_arrFailedProcesses[$nProcessIndex] = $this->_arrRunningProcesses[$nProcessIndex];
				}
			
				if(is_object($this->_arrRunningProcesses[$nProcessIndex]["callback"]) && !strcasecmp(get_class($this->_arrRunningProcesses[$nProcessIndex]["callback"]), "JSONRPC_process_forker_callback"))
					$this->_arrRunningProcesses[$nProcessIndex]["callback"]->call($mxProcessOutput);
				
				$this->closeProcess($nProcessIndex);
				
				$nFinishedProcesses++;
			}
		}
		
		return $nFinishedProcesses;
	}

	/**
	* Wait for all the processes to finish execution and execute the callbacks if any.
	*
	* @param int nProcessTimeout The process timeout in microseconds. Defaults to -1
	* (INFINITE).
	* @param int nIOTimeout The IO operations timeout in microseconds. Defaults to -1
	* (INFINITE).
	*
	* TODO: Should be rewritten to use selectRequests method.
	*
	* @return array. Array with the outputs of the child processes indexed by call ID.
	*/
	public function waitRequests($nProcessTimeout = -1, $nIOTimeout = -1)
	{
		/* Lazy initialization. */
		if(is_null(self::$_JSONRPCClient))
			self::$_JSONRPCClient = new JSONRPC_client(NULL);
	
		$nFinishedProcesses = 0;
	
		foreach($this->_arrRunningProcesses as $nCallID => $objProcess)
		{
			try
			{
				$mxProcessStatus = $this->waitProcess($nCallID, $nProcessTimeout);
				if($mxProcessStatus === false)
					throw new Exception("Child process timed out.");

				$mxProcessOutput = self::fread($objProcess["pipes"][self::STDOUT], $nIOTimeout);
				if($mxProcessOutput === false)
				{
					if($mxProcessStatus)
					{
						$mxProcessError = self::fread($objProcess["pipes"][self::STDERR], $nIOTimeout);					
						$strProcessError = $mxProcessError ? $mxProcessError:"Unknown error";	

						throw new Exception("Child process encountered an error with the following message: ".$strProcessError.".");	
					}
					else
						throw new Exception("Child process output read timed out.");
				}

				$mxProcessOutput = self::$_JSONRPCClient->processRAWResponse($mxProcessOutput, false);
			}
			catch(Exception $e)
			{
				$mxProcessOutput = $e;
			}
			
			if(is_object($objProcess["callback"]) && !strcasecmp(get_class($objProcess["callback"]), "JSONRPC_process_forker_callback"))
				$objProcess["callback"]->call($mxProcessOutput);
			
			$nFinishedProcesses++;

			$this->closeProcess($nCallID);
		}
		
		return $nFinishedProcesses;
	}
	
	/**
	* Reads the output of a process and returns it.
	*
	* @param int nCallID The ID of the call.
	* @param int nPipeIndex The index of the pipe to read from. It may have one of the
	* following values: 1 for STDOUT and 2 for STDERR. It defaults to 1(STDOUT).
	* @param int nIOTimeout The IO operations timeout in microseconds. Defaults to -1
	* (INFINITE).
	*
	* @return mixed. The output of the process or false when it times out.
	*/
	public function readProcessPipe($nCallID, $nPipeIndex = self::STDOUT, $nIOTimeout = -1)
	{
		if(!array_key_exists($nCallID, $this->_arrRunningProcesses))
			throw new Exception("Invalid call ID. There is no running process with the specified call ID.");
			
		return self::fread($this->_arrRunningProcesses[$nCallID]["pipes"][self::STDOUT], $nIOTimeout);
	}
	
	/**
	* Waits for a process to finish execution with a timeout.
	*
	* @param int nCallID The ID of the call.
	* @param int nTimeout The timeout to use. It defaults to -1(INFINITE).
	*
	* @return mixed The exit code or false if the process times out.
	*/
	public function waitProcess($nCallID, $nTimeout = -1)
	{
		if(!array_key_exists($nCallID, $this->_arrRunningProcesses))
			throw new Exception("Invalid call ID. There is no running process with the specified call ID.");
	
		$nStartTime = microtime(true);

		do
		{
			$arrProcessStatus = proc_get_status($this->_arrRunningProcesses[$nCallID]["handle"]);
			if(!$arrProcessStatus["running"])
				return $arrProcessStatus["exitcode"];
		}
		while($nTimeout === -1 || (microtime(true) - $nStartTime) <= $nTimeout);

		return false;
	}
	
	/**
	* Closes a process. If the process is still running it blocks until it exits.
	*
	* @param int nCallID The ID of the call.
	*
	* @return int. The process end status.
	*/
	public function closeProcess($nCallID)
	{
		if(!array_key_exists($nCallID, $this->_arrRunningProcesses))
			throw new Exception("Invalid call ID. There is no running process with the specified call ID.");
	
		/* Close the pipes to avoid deadlock. */
		foreach($this->_arrRunningProcesses[$nCallID]["pipes"] as $hProcessPipe)
			fclose($hProcessPipe); /* Ignore it's output. */
	
		$nExitCode = proc_close($this->_arrRunningProcesses[$nCallID]["handle"]);

		unset($this->_arrRunningProcesses[$nCallID]);
		
		return $nExitCode;
	}
	
	/**
	* Signals a process.
	*
	* @param int nCallID The ID of the call.
	* @param int nSignalCode The UNIX signal code.
	*
	* @return int. The process status.
	*/
	public function signalProcess($nCallID, $nSignalCode)
	{
		if(!array_key_exists($nCallID, $this->_arrRunningProcesses))
			throw new Exception("There is no running process with call ID ".json_encode($nCallID).".");
		
		return (int)proc_terminate($this->_arrRunningProcesses[$nCallID]["handle"], $nSignalCode);
	}
	
	/**
	* Kills a process by sending the SIGKILL UNIX signal.
	*
	* @param int nCallID The ID of the call.
	*
	* @return int. The process end status.
	*/
	public function killProcess($nCallID)
	{
		$this->signalProcess($nCallID, SIGILL);
		
		unset($this->_arrRunningProcesses[$nCallID]);
	
		return (int)$this->closeProcess($nCallID);
	}
	
	/**
	* Wrapper for the fwrite function that assures that the whole provided string has been
	* written with a specified timeout. The file/pipe must have the unblocking property set.
	*
	* @param handle hFileHandle The handle of the file to write to.
	* @param string strToBeWritten The string that needs to be written to the file.
	* @param int nTimeout The timeout to use. It defaults to -1(INFINITE).
	* 
	* @return bool True for success or false for failure.
	*/
	public static function fwrite($hFileHandle, $strToBeWritten, $nTimeout = -1)
	{
		assert(is_resource($hFileHandle));
		assert(is_string($strToBeWritten));
	
		$nBytesLeft = strlen($strToBeWritten);
		$nStartTime = microtime(true);
		
		do
		{
			$nBytesWritten = fwrite($hFileHandle, $strToBeWritten, $nBytesLeft);
			if($nBytesWritten !== false)
			{
				$nBytesLeft -= $nBytesWritten;
				if($nBytesLeft <= 0) /* nByteLeft can't be lower than 0 */
					return true;

				$strToBeWritten = substr($strToBeWritten, $nBytesWritten);
			}
		}
		while($nTimeout === -1 || (microtime(true) - $nStartTime) <= $nTimeout);

		return false;
	}

	/**
	* Wrapper for the fread function that reads from a file untill it times out or it reads an empty
	* string. The file/pipe must have the unblocking property set.
	*
	* @param handle hFileHandle The handle of the file to read from.
	* @param int nTimeout The timeout to use. It defaults to -1(INFINITE).
	* 
	* @return bool True for success or false for failure.
	*/
	public static function fread($hFileHandle, $nTimeout = -1)
	{
		assert(is_resource($hFileHandle));
	
		$strReadString = "";
		$nStartTime = microtime(true);

		do
		{
			$strPartialReadString = fread($hFileHandle, 4096);
			if($strPartialReadString !== false)
			{
				$strReadString .= $strPartialReadString;
				if(!strlen($strPartialReadString))
					break;
			}
		}
		while($nTimeout === -1 || (microtime(true) - $nStartTime) <= $nTimeout);

		return strlen($strReadString) ? $strReadString:false;
	}

	/**
	* Wrapper for the flock function that tries to lock a file with a timeout. The file/pipe must
	* have the unblocking property set.
	*
	* @param handle hFileHandle The handle of the file to lock.
	* @param int nOperation The operation bit mask of the flock function.
	* @param int nTimeout The timeout to use. It defaults to -1(INFINITE).
	* 
	* @return bool True for success or false for failure.
	*/
	public static function flock($hFileHandle, $nOperation, $nTimeout = -1)
	{
		$bWouldBlock = true;
		$nStartTime = microtime(true);

		do
		{
			$bLocked = flock($hFileHandle, $nOperation | LOCK_NB, $bWouldBlock);
		}
		while($bWouldBlock && ($nTimeout === -1 || (microtime(true) - $nStartTime) <= $nTimeout));

		return $bLocked;
	}
}
