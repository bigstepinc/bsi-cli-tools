<?php

require_once("config.php");

global $bsi;

if($argc!=3)
	die("Syntax: <cluster_id> <cluster_interface_index>\n");

$nClusterID=$argv[1];
$nClusterInterfaceIndex=$argv[2];

$bsi->cluster_interface_detach($nClusterID, $nClusterInterfaceIndex);


echo "\n Don't forget you need to run infrastructure_deploy for the actual deployment\n";
