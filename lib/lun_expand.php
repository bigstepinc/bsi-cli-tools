<?php
/**
* The config.php file is required in order to retrieve user specific data (BSI_API_KEY and BSI_ENDPOINT_URL)
*/
require_once("config.php");

global $bsi;

if($argc!=3)
	die("Syntax: <lun_id> <new_size>\n");



$nLunID=$argv[1];

$objLun = $bsi->lun_get($nLunID);

unset($objLun['current_operation']);

$objLun['lun_size_mbytes']=$argv[2];

var_export($objLun);

$nInfrastructureID=$objLun['infrastructure_id'];

$bsi->lun_edit($nLunID,$objLun);

var_export($objLun);

echo "\n Don't forget you need to run infrastructure_deploy for the actual deployment\n";
