#help.py

from BSI.BSI import BSI
from config import Config
import pprint

config=Config()
bsi = config.bsi


pp = pprint.PrettyPrinter(indent=4)

print """
BSI CLI Tools.
=============

Bigstep Infrastructure CLI Tools to control the infrastructure. 
Syntax: bsi <command> [command params]

Available commands:\n""";

arrCommands={
"infrastructures":"Retrieve infrastructure(s)",
"infrastructure_create":"Create new infrastructure",
"infrastructure_deploy":"Deploy ordered changes to an infrastructure",
"cluster_create":"Create a new cluster",
"cluster_delete":"Delete a cluster",
"cluster_edit":"Edit an existing cluster",
"cluster_instances":"Get details about the instances of a cluster.",
"clusters":"Retrieve cluster(s)",
"instance_server_power_get":"Get power status of a instance's server",
"instance_server_power_set":"Set power status of a instance's server via ipmi",
"networks":"Retrieve network(s) details",
"lun_templates":"Retrieve a list of public and private templates",
"ansible_inventory":"Generate an ansible inventory file",
"lun_array_luns":"Retrive luns of a cluster"
}

skeys=arrCommands.keys()
skeys.sort()
for cmd in skeys:
	print("{0:<30} {1:<100}".format(cmd,arrCommands[cmd]))	

print 
