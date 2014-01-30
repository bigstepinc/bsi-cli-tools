<?php


require_once("config.php");


if($argc!=2)
	die("Syntax: ".$argv[0]." <cluster_id>\n");


$nClusterID=$argv[1];

$objCluster=$bsi->cluster_get($nClusterID);

echo "Cluster ".$objCluster['cluster_label']." (#".$nClusterID.")\n";

$arrNodes=$bsi->cluster_nodes($nClusterID);


foreach($arrNodes as $objNode)
{
	$nNodeID=$objNode['node_id'];
	$arrNodeIPs=$bsi->node_ips($nNodeID);

	echo "Node ".$nNodeID." has IPs:\n";	

	foreach($arrNodeIPs as $objIP)
	{
		echo "\t".$objIP['ippool_destination']."(".$objIP['ip_type']."):".$objIP['ip_human_readable']."\n";
	}
}

