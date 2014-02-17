<?php
/**
* The config.php file is required in order to retrieve user specific data (BSI_API_KEY and BSI_ENDPOINT_URL)
*/
require_once("config.php");

if($argc!=2)
	die("Syntax: <lun_id>\n");



$nLunID=$argv[1];

global $bsi;

$objLUN=$bsi->lun_detach_node($nLunID);

var_export($objLUN);
