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
	parser.add_option("-l","--node_id",dest="node_id",help="The node to set power via ipmi")

	(options, args) = parser.parse_args()
	config.ensureRequired(parser,options)
	

	ret=bsi.node_server_power_get(options.node_id)
	print json.dumps(ret,indent=4)

except JSONRPC_Exception.JSONRPC_Exception as e:
	print >> sys.stderr,"\x1B[31m"+str(e.strMessage)+"\x1B[m"
#except BaseException as e :
#	print >> sys.stderr,"\x1B[31m"+str(e)+"\x1B[m"
	

