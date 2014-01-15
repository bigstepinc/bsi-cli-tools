<?php
/**
* The config.php file is required in order to retrieve user specific data (BSI_API_KEY and BSI_ENDPOINT_URL)
*/
require_once("config.php");

if($argc!=3)
	die("Syntax: <lun_id> <node_id>\n");



$nLunID=$argv[1];
$nNodeID=$argv[2];

global $bsi;


$objLUN=$bsi->lun_attach_node($nLunID,$nNodeID);

var_export($objLUN);
