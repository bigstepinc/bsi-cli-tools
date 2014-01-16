<?php

require_once("config.php");

global $bsi;

if($argc!=2)
	die("Syntax:  <infrastructure_id>\n");

$nInfrastructureID=$argv[1];
try
{
	$arrInfrastructure=$bsi->infrastructure_get($nInfrastructureID);

}catch(Exception $e)
{
	die($e->getMessage()."\n");
}


echo "Clearing Infrastructure ".$arrInfrastructure['infrastructure_label']."(".$arrInfrastructure['infrastructure_id'].")\n";


//CLUSTERS

$objQueryConditions=array(
	"columns"=>array(
		'cluster_id',
		'cluster_label',
		'cluster_node_count',
		'cluster_ram_gbytes',
		'cluster_processor_count',
		'cluster_processor_core_mhz',
		'cluster_processor_core_count',
		'cluster_service_status'
	),
	"where" => array(),
    "order_by" => array(),
	"limit" => array(0, 100)
);

$arrObjects=$bsi->infrastructure_selection(
	$nInfrastructureID,
	"clusters",
	$objQueryConditions
);



printf("\nCLUSTERS:\n");

 foreach($arrObjects['rows'] as $objElement)
 {
	 if($objElement['cluster_service_status']==BSI::SERVICE_STATUS_DELETED)      
                continue; 

 	echo "Deleting cluster ". $objElement['cluster_id']." ".$objElement['cluster_label']."\n";
	$bsi->cluster_delete($objElement['cluster_id']);

 }



//NETWORKS


$objQueryConditions=array(
	"columns"=>array(
		'network_id',
		'network_label',
		'network_type',
	),
	"where" => array(),
    "order_by" => array(),
	"limit" => array(0,100)
);

$arrObjects=$bsi->infrastructure_selection(
	$nInfrastructureID,
	"networks",
	$objQueryConditions
);


printf("\nNETWORKS:\n");
printf("%5s %-40s %3s\n",'ID','Name','Type','Status');

 foreach($arrObjects['rows'] as $objElement)
 {
		if($objElement['network_type']=='wan' || $objElement['network_type']=='san')
			continue;
		echo "Deleting network ".$objElement['network_id']." ". $objElement['network_label']."\n";	
		$bsi->network_delete($objElement['network_id']);
 }

//IPPools


$objQueryConditions=array(
	"columns"=>array(
		'ippool_id',
		'ippool_label',
		'ippool_type',
                'ippool_destination',
		'ippool_range_start_human_readable',
		'ippool_range_end_human_readable',
		'ippool_gateway_human_readable',
		'ippool_netmask_human_readable',
		'network_id',
		'ippool_service_status',
	),
	"where" => array(),
    "order_by" => array(),
	"limit" => array(0,100)
);

$arrObjects=$bsi->infrastructure_selection(
	$nInfrastructureID,
	"ippools",
	$objQueryConditions
);


printf("\nIPPools:\n");
printf("%5s %-40s %3s %10s %20s %10s %10s %4s %5s\n", 'ID', 'Name', 'Type', 'Destination', 'Range', 'Gateway', 'Netmask', 'NetworkID', 'Status');

foreach($arrObjects['rows'] as $objElement)
{

	echo "Deleting ippool ".$objElement['ippool_id']." ".$objElement['ippool_label']."\n";
	$bsi->ippool_delete($objElement['ippool_id']);
	
}








//LUNs

$objQueryConditions=array(
	"columns"=>array(
		'lun_id',
		'node_id',
		'lun_size_mbytes',
		'lun_bootable',
		'lun_created_timestamp',
		'storage_type',
		'lun_service_status'
	),
	"where" => array(),
    "order_by" => array(),
	"limit" => array(0, 100)
);

$arrObjects=$bsi->infrastructure_selection(
	$nInfrastructureID,
	"luns",
	$objQueryConditions
);

printf("\nLUNS:\n");
printf("%5s %5s %10s %-3s %-5s %10s\n",'ID','NodeId','Size(MB)','Bootable','StorageType','Status');
 
foreach($arrObjects['rows'] as $objElement)
 {
		echo "Deleting LUN ".$objElement['lun_id']."\n";
		$bsi->lun_delete($objElement['lun_id']);
 }




echo "\n Don't forget you need to run infrastructure_deploy for the actual deployment\n";
