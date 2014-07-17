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
	parser.add_option("-l","--infrastructure_label",dest="infrastructure_label",help="The infrastructure's unique label is used to create the infrastructure_subdomain. Can be used to call API functions.")
	parser.add_option("-d","--infrastructure_description",dest="infrastructure_description",help="An arbitrary UTF-8 string. It is not used by the API and cannot be referenced.",default="")
	
	(options, args) = parser.parse_args()
	config.ensureRequired(parser,options)

	obj={
		"infrastructure_label":options.infrastructure_label,
		"infrastructure_description":options.infrastructure_description,
		"user_id_owner": config.nBSIUserID
	}

	ret=bsi.infrastructure_create(config.nBSIUserID, obj)

	print json.dumps(ret,indent=4)

except JSONRPC_Exception.JSONRPC_Exception as e:
	print >> sys.stderr,"\x1B[31m"+str(e.strMessage)+"\x1B[m"
	

