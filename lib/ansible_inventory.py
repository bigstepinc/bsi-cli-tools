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
	parser.add_option("-l","--list",action="store_true")

	(options, args) = parser.parse_args()

	ret={}	
	infrastructures=bsi.infrastructures(config.nBSIUserID)
	for infr in infrastructures:
		clusters=bsi.clusters(infr)
		for clstr in clusters:
			ret[clstr+"."+infr]={}
			ret[clstr+"."+infr]["hosts"]=[]
			instances=bsi.cluster_instances(clstr)
			for instance in instances:		
				ret[clstr+"."+infr]["hosts"].append(instances[instance]["instance_subdomain"])
	print json.dumps(ret,indent=4)
	
	

except JSONRPC_Exception.JSONRPC_Exception as e:
	print >> sys.stderr,"\x1B[31m"+str(e.strMessage)+"\x1B[m"
#except BaseException as e :
#	print >> sys.stderr,"\x1B[31m"+str(e)+"\x1B[m"
	

