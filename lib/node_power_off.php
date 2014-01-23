<?php

require_once("config.php");


if($argc<=1 || $argc>3)
	die("Syntax: <node_id> [soft/hard]\n");

global $bsi;

$nNodeID=$argv[1];
if($argc==3)
	$strOffType=$argv[2];
else
	$strOffType="soft";


$strPowerStatus=$bsi->node_server_power_set($nNodeID,$strOffType);

var_export($strPowerStatus);
echo "\n";



