<?php

if($argc!=2)
	die("Syntax:  <network_id>\n");

$nNetworkID=$argv[1];

/**
* The config.php file is required in order to retrieve user specific data. 
*/
require_once("config.php");

$bsi->network_delete($nNetworkID);

echo "\n Don't forget you need to run infrastructure_deploy for the actual deployment\n";
