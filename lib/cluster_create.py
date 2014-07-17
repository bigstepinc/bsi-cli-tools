import sys
from BSI.BSI import BSI
from config import Config
import json
from JSONRPC import JSONRPC_Exception
from optparse import OptionParser

try:
	config=Config()
	bsi = config.bsi

	parser = OptionParser()
	parser.add_option("-i","--infrastructure_id",dest="infrastructure_id",help="the infrastructure in which to create this cluster")
	parser.add_option("-l","--label",dest="cluster_label",help="The cluster's unique label is used to create the cluster_subdomain. It is editable and can be used to call API functions.")
	parser.add_option("-n","--cluster_instance_count",dest="cluster_instance_count",help="The number of instances to be created on the cluster.")
	parser.add_option("-r","--cluster_ram_gbytes",dest="cluster_ram_gbytes",help="The minimum RAM capacity of each instance.")
	parser.add_option("-p","--cluster_processor_count",dest="cluster_processor_count",help="The CPU count on each instance.")
	parser.add_option("-m","--cluster_processor_core_mhz",dest="cluster_processor_core_mhz",help="The minimum clock speed of a CPU.")
	parser.add_option("-c","--cluster_processor_core_count",dest="cluster_processor_core_count",help="The minimum cores of a CPU.")
	parser.add_option("-w","--attach_to_wan",dest="attach_to_wan",help="Set to 1 if you want this cluster to be attached to a wan network.Default=1",default=1)
	parser.add_option("-t","--lun_template_id",dest="lun_template_id",help="The LUN template ID or name. At the moment, the only template available is \"ubuntu_12_LTS\"")
	parser.add_option("-a","--lun_array_storage_type",dest="lun_array_storage_type",help="Represents the LUN's type of storage. For the moment, the only possible value is LUN_STORAGE_TYPE_ISCSI_SSD.Default=iscsi_ssd", default="iscsi_ssd")
	parser.add_option("-s","--lun_size_mbytes_default",dest="lun_size_mbytes_default",help="The capacity of each LUN in MBytes.",default=2048)

	

	(options, args) = parser.parse_args()
	config.ensureRequired(parser,options)

	obj={
		"cluster_label":options.cluster_label,
		"cluster_instance_count":int(options.cluster_instance_count),
		"cluster_ram_gbytes": int(options.cluster_ram_gbytes),
		"cluster_processor_count":int(options.cluster_processor_count),
		"cluster_processor_core_mhz":int(options.cluster_processor_core_mhz),
		"cluster_processor_core_count":int(options.cluster_processor_core_count)
	}

	cluster=bsi.cluster_create(options.infrastructure_id, obj)
	
	wan_network=None	
	if(options.attach_to_wan==1):
		networks=bsi.networks(options.infrastructure_id)			
		wan_network
		for network in networks:
			if(networks[network]["network_type"]==BSI.NETWORK_TYPE_WAN):
				wan_network=networks[network]["network_subdomain"]	
	if(wan_network==None):
		print >> sys.stderr,"\x1B[31mCould not find wan network in infrastructure\x1B[m"
		sys.exit()
	
	ret=bsi.cluster_interface_attach_network(cluster["cluster_label"],1,wan_network)	


	obj={
		"lun_array_label":options.cluster_label,
		"lun_template_id":options.lun_template_id,
		"lun_array_storage_type":options.lun_array_storage_type,
		"lun_array_count":int(options.cluster_instance_count),
		"lun_size_mbytes_default":int(options.lun_size_mbytes_default),
		"lun_array_expand_with_cluster":True
	}

	lun_array=bsi.lun_array_create(options.infrastructure_id, obj)
	
	bsi.lun_array_attach_cluster(lun_array["lun_array_label"], cluster["cluster_label"])	
	
	print json.dumps(cluster, indent=4)
	config.print_deploy_warning()
	
except JSONRPC_Exception.JSONRPC_Exception as e:
	print >> sys.stderr,"\x1B[31m"+str(e.strMessage)+"\x1B[m"
	

