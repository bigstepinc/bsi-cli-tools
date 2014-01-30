<?php

require_once("config.php");

global $bsi;

if($argc!=9)
	die("Syntax: <infrastructure_id> <cluster_name> <node_count> <RAM> <Core_MHZ> <processor_count> <processor_core_count> <LUN_template_name>\n");

$nInfrastructureID=(int)$argv[1];
$strClusterName=$argv[2];
$nNodeCount=(int)$argv[3];
$nRAM=(int)$argv[4];
$nCoreMhz=(int)$argv[5];
$nProcessorCount=(int)$argv[6];
$nProcessorCoreCount=(int)$argv[7];
$strLunTemplateName=$argv[8];

$objCluster = array(
	"cluster_id"=>NULL,
	"cluster_label" => $strClusterName,
	"cluster_id_name" => $strClusterName,
	"cluster_ipv4_public_auto_create_and_allocate" => true,
	"cluster_node_count" => $nNodeCount,
	"cluster_ram_gbytes" => $nRAM,
	"cluster_processor_core_mhz" => $nCoreMhz,
	"cluster_processor_count" => $nProcessorCount,
	"cluster_processor_core_count" => $nProcessorCoreCount,
	"lun_template_id" => $bsi->lun_template_id_public($strLunTemplateName),
	"lun_storage_type" => "iscsi_ssd"
);

$objCluster = $bsi->cluster_create($nInfrastructureID, $objCluster);
$nClusterID = $objCluster["cluster_id"];



/**
* After creating an infrastructure, a WAN network is automatically available.
* For further usage, the WAN network ID is needed.
*/

$nWANID = $bsi->network_id($nInfrastructureID, "WAN");


/**
* In order to connect the newly created cluster to the infrastructure's WAN network, one cluster interface
* must be attached to the corresponding WAN network.
* Every cluster has 4 interfaces, identified by a cluster interface index. However, only 3 of them are available. 
* In this example, the second interface is used for WAN connection.
* If another cluster interface is already connected to a WAN network, an exception will be thrown.
*/


$bsi->cluster_interface_attach_network($nClusterID, 1, $nWANID);


var_export($objCluster);

echo "\n Don't forget you need to run infrastructure_deploy for the actual deployment\n";
