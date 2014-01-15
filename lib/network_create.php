<?php

if($argc!=4)
	die("Syntax:  <infrastructure_id> <network_label> <network_type>\n");

$nInfrastructureID=$argv[1];

/**
* The config.php file is required in order to retrieve user specific data. 
*/
require_once("config.php");


$objNetwork = array(
	"network_label" => $argv[2],
	"network_type" => $argv[3],
);

$objLANNetwork = $bsi->network_create($nInfrastructureID,$objNetwork);

var_export($objNetwork);

