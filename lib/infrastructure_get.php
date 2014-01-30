<?php


require_once("config.php");
if($argc!=2)
	die("Syntax: <infrastructure_id>\n");


global $bsi;

$nInfrastructureID=$argv[1];
try
{
	$arrInfrastructure=$bsi->infrastructure_get($nInfrastructureID);

}catch(Exception $e)
{
	die($e->getMessage()."\n");
}

echo "Infrastructure ".$arrInfrastructure['infrastructure_label']."(".$arrInfrastructure['infrastructure_id'].")\n";
echo "Description: ".$arrInfrastructure['infrastructure_description']."\n";
echo "Pending operations count:".$arrInfrastructure['infrastructure_ongoing_deployments_counter']."\n";


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
printf("%3s %-20s % 3s %-50s %-30s %10s\n", "ID", "Name", "NodeCount", "NodeCharacteristics", "Networks", "Status");

 foreach($arrObjects['rows'] as $objElement)
 {
	if($objElement['cluster_service_status']==BSI::SERVICE_STATUS_DELETED)
		continue;
 	$arrNetworks=$bsi->cluster_networks($objElement['cluster_id']);
 	$arrNetworksOnly="";
 	foreach($arrNetworks as $arrNetwork)
 	{
 		$arrNetworksOnly[]=$arrNetwork['network_label'];
 	}


 	printf("%3s %-20s %-10d %d x (%dMhz, %d Cores) CPU, %dGB RAM %-30s %10s\n",
 		$objElement['cluster_id'],
 		$objElement['cluster_label'],
 		$objElement['cluster_node_count'],
		$objElement['cluster_processor_count'],
		$objElement['cluster_processor_core_mhz'],
		$objElement['cluster_processor_core_count'],
		$objElement['cluster_ram_gbytes'],
		implode(",",$arrNetworksOnly),
		$objElement['cluster_service_status']
	);

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
 	printf("%5s %-40s %-10s\n",
 		$objElement['network_id'],
 		$objElement['network_label'],
 		$objElement['network_type']);
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
printf("%5s %-40s %5s %5s %10s-%-10s %10s %10s %5d %6s\n",
	$objElement['ippool_id'],
	$objElement['ippool_label'],
	$objElement['ippool_type'],
	$objElement['ippool_destination'],
	$objElement['ippool_range_start_human_readable'],
	$objElement['ippool_range_end_human_readable'],
	$objElement['ippool_gateway_human_readable'],
	$objElement['ippool_netmask_human_readable'],
	$objElement['network_id'],
	$objElement['ippool_service_status']);

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
 	printf("%5d %5d %10d %-3s %-5s \n",
 		$objElement['lun_id'],
 		$objElement['node_id'],
 		$objElement['lun_size_mbytes'],
 		$objElement['lun_bootable']==1 ? "Yes" : "No",
 		$objElement['lun_service_status']
 		);
 }


//$arrColumns=$bsi->infrastructure_selection_columns($nInfrastructureID,'luns');
//var_export($arrColumns);


