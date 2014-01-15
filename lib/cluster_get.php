<?php

require_once("config.php");

if($argc!=2)
	die("Syntax:  <cluster_id>\n");

$nClusterID=(int)$argv[1];


global $bsi;



$arrCluster=$bsi->cluster_get($nClusterID);

var_export($arrCluster);

