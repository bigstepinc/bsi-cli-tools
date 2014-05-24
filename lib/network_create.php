<?php

if($argc!=4)
	die("Syntax:  <infrastructure_id> <network_label> <network_type>\n");

$nInfrastructureID=(int)$argv[1];

/**
* The config.php file is required in order to retrieve user specific data. 
*/
require_once("config.php");


$objNetwork = array(
	"infrastructure_id" =>(int) $argv[1],
	"infrastructure_id" => $nInfrastructureID,
	"network_label" => $argv[2],
	"network_type" => $argv[3],
	"network_id_name" => $argv[3],
);

$objLANNetwork = $bsi->network_create($nInfrastructureID,$objNetwork);

var_export($objNetwork);

