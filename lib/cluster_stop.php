<?php

require_once("config.php");

if($argc!=2)
	die("Syntax: <cluster_id>\n");

$nClusterID=$argv[1];

$objCluster=$bsi->cluster_get($nClusterID);

echo "Stopping cluster ".$objCluster['cluster_label']." (#".$nClusterID.")\n";

$objCluster=$bsi->cluster_stop($nClusterID);

echo "cluster is=";
var_export($objCluster);


echo "\n Don't forget you need to run infrastructure_deploy for the actual deployment\n";



