<?php

require_once("config.php");

global $bsi;

if($argc!=2)
	die("Syntax: <lun_id>\n");

$nLunID=$argv[1];

$objLUN=$bsi->lun_delete($nLunID);

var_export($objLUN);

echo "\n Don't forget you need to run infrastructure_deploy for the actual deployment\n";
