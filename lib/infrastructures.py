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
	parser.add_option("-i","--infrastructure_id",dest="infrastructure_id",help="The infrastructure in which to create this cluster",default=0)

	(options, args) = parser.parse_args()
	config.ensureRequired(parser,options)
	
	if options.infrastructure_id==0:
		ret=bsi.infrastructures(config.nBSIUserID)
	else:
		ret=bsi.infrastructures(config.nBSIUserID,[options.infrastructure_id])
	print json.dumps(ret,indent=4)

except JSONRPC_Exception.JSONRPC_Exception as e:
	print >> sys.stderr,"\x1B[31m"+str(e.strMessage)+"\x1B[m"
#except BaseException as e :
#	print >> sys.stderr,"\x1B[31m"+str(e)+"\x1B[m"
	

