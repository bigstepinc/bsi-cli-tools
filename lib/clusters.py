#infrastructures.py
from JSONRPC import JSONRPC_Exception
from BSI.BSI import BSI
from config import Config
import json
import sys
from optparse import OptionParser

try:
	config=Config()
	bsi = config.bsi

	parser = OptionParser()
	parser.add_option("-i","--infrastructure_label",dest="infrastructure_id",help="The infrastructure in which to look for clusters")
	parser.add_option("-l","--cluster_label",dest="cluster_label",help="The cluster to retrieve.",default=0)

	(options, args) = parser.parse_args()
	config.ensureRequired(parser,options)
	
	if options.cluster_label==0:
		ret=bsi.clusters(options.infrastructure_id)
	else:
		ret=bsi.clusters(options.infrastructure_id,[options.cluster_label])
	print json.dumps(ret,indent=4)

except JSONRPC_Exception.JSONRPC_Exception as e:
	print >> sys.stderr,"\x1B[31m"+str(e.strMessage)+"\x1B[m"
#except BaseException as e :
#	print >> sys.stderr,"\x1B[31m"+str(e)+"\x1B[m"
	

