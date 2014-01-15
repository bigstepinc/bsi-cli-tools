<?php
/**
* The config.php file is required in order to retrieve user specific data (BSI_API_KEY and BSI_ENDPOINT_URL)
*/
require_once("config.php");

global $bsi;


if($argc!=3)
	die("Syntax: <infrastructure_id> <user_email>\n");

$nInfrastructureID=$argv[1];
$strUserEmail=$argv[2];


$objInfrastructure = $bsi->infrastructure_user_add($nInfrastructureID, $strUserEmail);

var_export($objInfrastructure);

