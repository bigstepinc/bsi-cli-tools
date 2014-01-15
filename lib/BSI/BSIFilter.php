<?php
require_once("JSONRPC/ClientFilterBase.php");
require_once("BSI/BSI_Exception.php");


class BSIFilter extends JSONRPC_client_filter_plugin_base
{

	public function __construct()
	{

	}

    public function exceptionCatch($exception)
	{
        if($exception->getCode() >= 0)
            throw new BSI_Exception($exception->getMessage(), $exception->getCode());
        else 
            throw $exception;
    }
}