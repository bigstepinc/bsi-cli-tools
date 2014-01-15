<?php
/**
* The config.php file is required in order to retrieve user specific data (BSI_API_KEY and BSI_ENDPOINT_URL)
*/
require_once("config.php");

global $bsi;

if($argc!=2)
	die("Syntax: <infrastructure_name>\n");

$strInfrastructureName=$argv[1];

$objInfrastructure = $bsi->infrastructure_create($nUserID, $strInfrastructureName, "", $nBillableUserID);
$nInfrastructureID = $objInfrastructure["infrastructure_id"];

var_export($objInfrastructure);

