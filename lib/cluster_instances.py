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
	parser.add_option("-l","--label",dest="cluster_label",help="The cluster's unique label is used to create the cluster_subdomain. It is editable and can be used to call API functions.")

	(options, args) = parser.parse_args()
	config.ensureRequired(parser,options)

	ret=bsi.cluster_instances(options.cluster_label)

	print json.dumps(ret,indent=4)
	
except JSONRPC_Exception.JSONRPC_Exception as e:
	print >> sys.stderr,"\x1B[31m"+str(e.strMessage)+"\x1B[m"
	

