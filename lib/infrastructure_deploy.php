<?php
/**
* The config.php file is required in order to retrieve user specific data (BSI_API_KEY and BSI_ENDPOINT_URL)
*/
require_once("config.php");

if($argc!=2)
	die("Syntax: <infrastructure_id>\n");


$nInfrastructureID=$argv[1];

global $bsi;

$bsi->infrastructure_deploy($nInfrastructureID);


/**
* A deploy method requires an amount of time to process all the changes that need to be taken into consideration. To ensure
* that the newly created cluster is available with its latest configuration, it is recommended to check its status repeatedly before continuing.
*/

$objInfrastructure = $bsi->infrastructure_get($nInfrastructureID);

echo "Deploying changes";

while($objInfrastructure["infrastructure_ongoing_deployments_counter"] != "0")
{
	echo ".";
	sleep(1);
	$objInfrastructure = $bsi->infrastructure_get($objInfrastructure["infrastructure_id"]);
}

var_export($objInfrastructure);
