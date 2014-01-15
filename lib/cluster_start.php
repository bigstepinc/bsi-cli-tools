<?php

if($argc!=2)
	die("Syntax: <cluster_id>\n");

require_once("config.php");



$nClusterID=$argv[1];

$objCluster=$bsi->cluster_get($nClusterID);

echo "Starting cluster ".$objCluster['cluster_label']." (#".$nClusterID.")\n";

$objCluster=$bsi->cluster_start($nClusterID);

var_export($objCluster);


echo "\n Don't forget you need to run infrastructure_deploy for the actual deployment\n";



