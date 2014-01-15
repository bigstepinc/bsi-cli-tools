<?php

if($argc!=2)
	die("Syntax: <cluster_id>\n");

require_once("config.php");


global $bsi;


$nClusterID=$argv[1];

$objCluster=$bsi->cluster_get($nClusterID);

echo "Deleting cluster ".$objCluster['cluster_label']." (#".$nClusterID.")\n";

$bsi->cluster_delete($nClusterID);

$objCluster = $bsi->cluster_get($nClusterID);

var_export($objCluster);

echo "\n Don't forget you need to run infrastructure_deploy for the actual deployment\n";
