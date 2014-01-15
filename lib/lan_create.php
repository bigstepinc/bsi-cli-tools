<?php


if($argc!=2)
	die("Syntax: <cluster_id>\n");

require_once("config.php");


$nClusterID = (int)$argv[1];
$objCluster = $bsi->cluster_get($nClusterID);

$nInfrastructureID = $objCluster["infrastructure_id"];

$arrClusterNodes = $bsi->cluster_nodes($nClusterID);

$objNetwork = array(
	"network_id" => null,
	"network_name" => "test_lan",
	"network_id_name" => "test_lan",
	"network_label" => "test_lan",
	"network_type" => BSI::NETWORK_TYPE_LAN,
);

$objNetwork = $bsi->network_create($nInfrastructureID, $objNetwork);

$arrClusterInterfaces = $bsi->cluster_interfaces($nClusterID);

foreach($arrClusterInterfaces as $objClusterInterface) 
{
	if($objClusterInterface["network_id"] == null)
	{
		$bsi->cluster_interface_attach_network($nClusterID, $objClusterInterface["cluster_interface_index"], $nNetworkID);
		break;
	}
}
