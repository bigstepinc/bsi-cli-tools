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
	parser.add_option("-o","--old_cluster_label",dest="old_cluster_label",help="Used to identify the cluster")

	parser.add_option("-l","--cluster_label",dest="cluster_label",help="The cluster's unique label is used to create the cluster_subdomain. It is editable and can be used to call API functions.")
	parser.add_option("-n","--cluster_instance_count",dest="cluster_instance_count",help="The number of instances to be created on the cluster.")
	parser.add_option("-r","--cluster_ram_gbytes",dest="cluster_ram_gbytes",help="The minimum RAM capacity of each instance.")
	parser.add_option("-p","--cluster_processor_count",dest="cluster_processor_count",help="The CPU count on each instance.")
	parser.add_option("-m","--cluster_processor_core_mhz",dest="cluster_processor_core_mhz",help="The minimum clock speed of a CPU.")
	parser.add_option("-c","--cluster_processor_core_count",dest="cluster_processor_core_count",help="The minimum cores of a CPU.")
	

	(options, args) = parser.parse_args()
	if options.old_cluster_label==None:
		parser.print_help()
		sys.exit()

	obj=bsi.clusters([options.old_cluster_label])
	
	if options.cluster_label!=None:
		obj["cluster_label"]=options.cluster_label
	if options.cluster_instance_count!=None:
		obj["cluster_instance_count"]=int(options.cluster_instance_count)
	if options.cluster_ram_gbytes!=None:
		obj["cluster_ram_gbytes"]=int(options.cluster_ram_gbytes)
	if options.cluster_processor_count!=None:
		obj["cluster_processor_count"]=int(options.cluster_processor_count)
	if options.cluster_processor_core_mhz!=None:
		obj["cluster_processor_core_mhz"]=int(options.cluster_processor_core_mhz)
	if options.cluster_processor_core_count!=None:	
		obj["cluster_processor_core_count"]=int(options.cluster_processor_core_count)

	ret=bsi.cluster_edit(options.options.old_cluster_label, obj)

	print json.dumps(ret,indent=4)
	config.print_deploy_warning()
	
except JSONRPC_Exception.JSONRPC_Exception as e:
	print >> sys.stderr,"\x1B[31m"+str(e.strMessage)+"\x1B[m"
#except BaseException as e :
#	print >> sys.stderr,"\x1B[31m"+str(e)+"\x1B[m"
