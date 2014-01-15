<?php
/**
* The config.php file is required in order to retrieve user specific data (BSI_API_KEY and BSI_ENDPOINT_URL)
*/
require_once("config.php");
global $bsi;

if($argc!=2)
	die("Syntax: <lun_id>\n");



$nLunID=$argv[1];

$objLun = $bsi->lun_get($nLunID);

var_export($objLun);
