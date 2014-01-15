<?php
/**
* The config.php file is required in order to retrieve user specific data (BSI_API_KEY and BSI_ENDPOINT_URL)
*/
require_once("config.php");

global $bsi;


if($argc!=3)
	die("Syntax: <infrastructure_id> <user_id>\n");

$nInfrastructureID=$argv[1];
$nUserID=$argv[2];


$objInfrastructure = $bsi->infrastructure_user_remove($nInfrastructureID, $nUserID);

var_export($objInfrastructure);

