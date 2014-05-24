<?php

if($argc!=4)
	die("Syntax:  <network_id>\n");

$nNetworkID=$argv[1];

/**
* The config.php file is required in order to retrieve user specific data. 
*/
require_once("config.php");

;

$objLANNetwork = $bsi->network_delete($nNetworkId);

var_export($objNetwork);

echo "\n Don't forget you need to run infrastructure_deploy for the actual deployment\n";
