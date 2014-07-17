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

	private_templates=None	
	if options.infrastructure_id!=0:
	        private_templates=bsi.lun_templates(options.infrastructure_id)

        public_templates=bsi.lun_templates_public()
	
	if(private_templates!=None):
	        templates=dict(private_templates.items()+public_templates.items())
	else:
		templates=public_templates

	print json.dumps(templates,indent=4)

except JSONRPC_Exception.JSONRPC_Exception as e:
	print >> sys.stderr,"\x1B[31m"+str(e.strMessage)+"\x1B[m"
#except BaseException as e :
#	print >> sys.stderr,"\x1B[31m"+str(e)+"\x1B[m"
	

