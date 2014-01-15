<?php
/**
* The config.php file is required in order to retrieve user specific data (BSI_API_KEY and BSI_ENDPOINT_URL)
*/
require_once("config.php");
$nBillableUserID = 16;

if($argc!=2)
	die("Syntax:  <cluster_id> <new_node_count>\n");


$nClusterID=$argv[1];

global $bsi;


$objCluster = $bsi->cluster_get($nClusterID);

unset($objCluster['current_operation']);
if($objCluster['cluster_node_count']<=$nNodeCount)
	die("new_node_count must be smaller than the current node count which is currently ".$objCluster['cluster_node_count']."\n");


$objCluster['cluster_node_count']=$nNodeCount;

$objCluster=$bsi->cluster_edit($nClusterID,$objCluster);

var_export($objCluster);

echo "\n Don't forget you need to run infrastructure_deploy for the actual deployment\n";
