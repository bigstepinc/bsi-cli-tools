<?php

require_once("config.php");

global $bsi;


if($argc!=2)
	die("Syntax: <cluster_id>\n");


$nClusterID=$argv[1];

$objCluster=$bsi->cluster_get($nClusterID);

echo "Cluster ".$objCluster['cluster_label']." (#".$nClusterID.")\n";

$arrNodes=$bsi->cluster_nodes($nClusterID);


foreach($arrNodes as $objNode)
{
	echo "Node ".$objNode['node_label']." (#".$objNode['node_id'].")\n";
	var_export($objNode);
}

