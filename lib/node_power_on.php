<?php

require_once("config.php");


if($argc!=2)
	die("Syntax: <node_id>\n");

global $bsi;

$nNodeID=$argv[1];

$strPowerStatus=$bsi->node_server_power_set($nNodeID,"on");

var_export($strPowerStatus);
echo "\n";



