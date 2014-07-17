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
	parser.add_option("-p","--power_command",dest="power_command",help="The power command to send: on,off,reset,soft")
	parser.add_option("-f","--force",dest="force",help="If bForceShutdownIfOn is true, function checks if power status is SERVER_POWER_STATUS_ON when trying to turn off a server. If the power is off, a shut down command is sent and a power on is tried again.",default=0)

	(options, args) = parser.parse_args()
	config.ensureRequired(parser,options)
	
	if(0>(["on","off","soft","reset"].index(options.power_command))):
		print >> sys.stderr,"\x1B[31mPower argument must be one of :off,on,reset,soft\x1B[m"
		sys.exit()
	
	ret=bsi.node_server_power_set(options.node_id, options.power_command, options.force)
	print json.dumps(ret,indent=4)

except JSONRPC_Exception.JSONRPC_Exception as e:
	print >> sys.stderr,"\x1B[31m"+str(e.strMessage)+"\x1B[m"
#except BaseException as e :
#	print >> sys.stderr,"\x1B[31m"+str(e)+"\x1B[m"
	

