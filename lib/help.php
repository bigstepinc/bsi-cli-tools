<?php

echo "
BSI CLI Tools.
=============

Bigstep Infrastructure CLI Tools to control the infrastructure. 
Syntax: bsi <command> [command params]

Available commands:\n";

$arrCommands=array(
		"cluster_create" => 		"Create a cluster with a number of nodes with a specific configuration.", 
		"cluster_contract" => 		"Contract a cluster (i.e. reduce the number of nodes).",
		"cluster_delete" =>		"Delete a cluster (keep the LUNS) to free resources.",
		"cluster_expand"=>		"Expand a cluster (i.e. increase the number of nodes).",
		"cluster_get"=>			"Returns an description of a cluster.",
		"cluster_ips"=>			"Returns the ips used by a cluster.",
		"cluster_nodes"=>		"Returns the nodes contained by a cluster.",
		"cluster_servers"=>		"Returns the servers used by the nodes of a cluster.",
		"cluster_start"=>		"Starts a cluster from a stopped state.",
		"cluster_stop"=>		"Stopps a cluster to free resources. Use it to restore it's state at a later time",
		"cluster_attach_to_network" =>  "Attaches a cluster interface to a network",
		"cluster_detach" =>  		"Detaches a cluster interface from the connected network",
		"infrastructure_clear"=>	"Deletes everything that can be deleted from an infrastructure.",
		"infrastructure_create"=>	"Creates a new infrastructure. This infrastructure comes with associated WAN and SAN networks",
		"infrastructure_deploy"=>	"Deployes the registered changes. Tp be used to start any operation registered. Use after any create, edit, delete command.",
		"infrastructure_get"=>		"Retrieves information about the clusters, networks and LUNS of an infrastructure.",
		"infrastructure_user_add"=>	"Adds a new user. The user will be an admin user but will not have any right. Use infrastructure_user_add to add it as a delegate to a specific infrastructure.",
		"infrastructure_user_remove"=>	"Removes a delegate user from an infrastructure.",
		"lan_create"=>			"Create a LAN network inside an infrastructure.",
		"lun_attach_to_node"=>		"Attach a LUN to a node.",
		"lun_detach_from_node"=>	"Detach LUN from a node.",
		"lun_clone"=>			"Clone a LUN to make a replica of it. This will also create a snapshot and the original LUN will no longer be deletable unless all clones are deleted.",
		"lun_create"=>			"Create a LUN of a specified size either empty block device or by cloning a template.",
		"lun_delete"=>			"Deletes a LUN",
		"lun_expand"=>			"Expand a LUN. This will expand the LUN on the storage device so that it has another size. It will also atempt to expand the FS on it using parted.",
		"lun_get"=>			"Displayes information about a LUN.",
		"lun_snapshots"=>		"Retrieves the snapshots associated with a LUN.",
		"lun_templates_get"=>		"Retrieves all the templates of a LUN.",
		"network_create"=>		"Creates a network.",
		"network_delete"=>		"Delete a network.",
		"node_get"=>			"Retrieves information about a node.",
		"node_power_get"=>		"Retrieves the power status of a node.",
		"node_power_off"=>		"Powers off a node.",
		"node_power_on"=>		"Powers on a node.",
		"resource_utilizations"=>	"Retrieves the resource utilization of a node",
		"snapshot_create"=>		"Create snapshot of a LUN",
		"snapshot_rollback"=>		"Reverts a LUN to a snapshot.",
		"user_get"=>			"Retrieves data about a user.",
		"user_infrastructures"=>	"Retrieves all infrastructures to which the user is a delegate.",
		"user_ssh_key_upload"=>		"Set the PUBLIC SSH key to be configured on all servers and devices provisioned by the sistem for the current user.",
);

foreach($arrCommands as $strCommand=>$strDoc)
{
	printf("%-27s %s\n",$strCommand,$strDoc);
}

echo "For help with individual commands run the command with no params\n\n";
