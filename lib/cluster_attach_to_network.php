<?php

require_once("config.php");

global $bsi;

if($argc!=4)
	die("Syntax: <cluster_id> <cluster_interface_index> <network_id>\n");

$nClusterID=$argv[1];
$nClusterInterfaceIndex=$argv[2];
$nNetworkID=$argv[3];

$bsi->cluster_interface_attach_network($nClusterID, $nClusterInterfaceIndex, $nNetworkID);


echo "\n Don't forget you need to run infrastructure_deploy for the actual deployment\n";
