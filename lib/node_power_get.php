<?php

if($argc!=2)
	die("Syntax:  <node_id>\n");

require_once("config.php");

global $bsi;

$nNodeID=$argv[1];

$strPowerStatus=$bsi->node_server_power_get($nNodeID);

var_export($strPowerStatus);
echo "\n";



