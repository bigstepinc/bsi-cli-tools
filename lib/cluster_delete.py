import sys
from BSI.BSI import BSI
from config import Config
import json
from JSONRPC import JSONRPC_Exception
from optparse import OptionParser
import traceback

try:
	config=Config()
	bsi = config.bsi

	parser = OptionParser()

	parser.add_option("-i","--infrastructure_id",dest="infrastructure_id",help="the infrastructure in which to create this cluster")
	parser.add_option("-l","--label",dest="cluster_label",help="The cluster's unique label is used to create the cluster_subdomain. It is editable and can be used to call API functions.")

	(options, args) = parser.parse_args()
	config.ensureRequired(parser,options)
	
	cluster=bsi.clusters(options.infrastructure_id, [options.cluster_label])
	cluster=cluster[cluster.keys()[0]]
	infrastructure_id=cluster["infrastructure_id"]
	instances=bsi.cluster_instances(options.cluster_label)
	for instance in instances:
		if(instances[instance]["instance_service_status"]==BSI.SERVICE_STATUS_ACTIVE):
			bsi.instance_server_power_set(instance,BSI.SERVER_POWER_STATUS_SOFT,True) 

	lun_arrays=bsi.lun_arrays(infrastructure_id)
	for lun_array in lun_arrays:
		if(int(lun_arrays[lun_array]["cluster_id"])==int(cluster["cluster_id"])):
			bsi.lun_array_delete(int(lun_arrays[lun_array]["lun_array_id"]))

	ret=bsi.cluster_delete(options.cluster_label)

	print json.dumps(ret,indent=4)
	config.print_deploy_warning()
	
except JSONRPC_Exception.JSONRPC_Exception as e:
	print >> sys.stderr,"\x1B[31m"+str(e.strMessage)+"\x1B[m"
	traceback.print_exc(file=sys.stderr)	

