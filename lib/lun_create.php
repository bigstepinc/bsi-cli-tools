<?php

require_once("config.php");

global $bsi;

if($argc!=4)
	die("Syntax: <infrastructure_id> <lun_lanel> <lun_size_mbytes>\n");

$nInfrastructureID=$argv[1];

$objLUN=array(
	"lun_label"=>$argv[2],
	"lun_bootable"=>false,
	"lun_boot_order"=>0,
	"lun_size_mbytes"=>(int)$argv[3]
);

$objLUN=$bsi->lun_create($nInfrastructureID,$objLUN);
var_export($objLUN);

echo "\n Don't forget you need to run infrastructure_deploy for the actual deployment\n";
