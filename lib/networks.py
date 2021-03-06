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
	parser.add_option("-i","--infrastructure_label",dest="infrastructure_id",help="The infrastructure in which to look for networks")
	parser.add_option("-l","--network_label",dest="network_label",help="The network to retrieve.",default=0)

	(options, args) = parser.parse_args()
	config.ensureRequired(parser,options)
	
	if options.network_label==0:
		ret=bsi.networks(options.infrastructure_id)
	else:
		ret=bsi.networks(options.infrastructure_id,[options.network_label])
	print json.dumps(ret,indent=4)

except JSONRPC_Exception.JSONRPC_Exception as e:
	print >> sys.stderr,"\x1B[31m"+str(e.strMessage)+"\x1B[m"
#except BaseException as e :
#	print >> sys.stderr,"\x1B[31m"+str(e)+"\x1B[m"
	

