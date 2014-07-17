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

	(options, args) = parser.parse_args()
	config.ensureRequired(parser,options)

	cluster=bsi.clusters(options.infrastructure_id, [options.cluster_label])
	cluster=cluster[cluster.keys()[0]]

	lun_arrays=bsi.lun_arrays(options.infrastructure_id)
	for lun_array in lun_arrays:
		if(int(lun_arrays[lun_array]["cluster_id"])==int(cluster["cluster_id"])):
			print json.dumps(bsi.lun_array_luns(lun_arrays[lun_array]["lun_array_id"]),indent=4)
	
except JSONRPC_Exception.JSONRPC_Exception as e:
	print >> sys.stderr,"\x1B[31m"+str(e.strMessage)+"\x1B[m"
	

