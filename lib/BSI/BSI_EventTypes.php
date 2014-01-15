<?php
/**
* BSI, API v1.0 
*/
class BSI_EventTypes extends Exception
{ 



	/**
	* Cluster cloned.
	* Severity: info.
	* 
	* A cluster has been successfully cloned, but not yet deployed.
	*/
	const CLUSTER_CLONED=69;


	/**
	* Cluster created.
	* Severity: info.
	* 
	* A cluster has been successfully created, but not yet deployed.
	*/
	const CLUSTER_CREATED=61;


	/**
	* Cluster deleted.
	* Severity: info.
	* 
	* A cluster has been successfully deleted, but not yet deployed.
	*/
	const CLUSTER_DELETED=64;


	/**
	* Cluster deployed.
	* Severity: success.
	* 
	* Deploy completed for cluster operation.
	*/
	const CLUSTER_DEPLOYED=12;


	/**
	* Cluster edited.
	* Severity: info.
	* 
	* A cluster has been successfully edited, but not yet deployed.
	*/
	const CLUSTER_EDITED=65;


	/**
	* Cluster interface created.
	* Severity: info.
	* 
	* A cluster interface has been successfully created, but not yet deployed.
	*/
	const CLUSTER_INTERFACE_CREATED=68;


	/**
	* Cluster interface deleted.
	* Severity: info.
	* 
	* A cluster interface has been successfully deleted.
	*/
	const CLUSTER_INTERFACE_DELETED=103;


	/**
	* Cluster interface deployed.
	* Severity: success.
	* 
	* Deploy completed for cluster interface operation.
	*/
	const CLUSTER_INTERFACE_DEPLOYED=16;


	/**
	* Cluster interface edited.
	* Severity: info.
	* 
	* A cluster interface has been successfully edited, but not yet deployed.
	*/
	const CLUSTER_INTERFACE_EDITED=88;


	/**
	* Cluster interface undeployed.
	* Severity: success.
	* 
	* Cluster interface is in "ordered" status and the IPs have been deallocated.
	*/
	const CLUSTER_INTERFACE_UNDEPLOYED=19;


	/**
	* Cluster interfaces public IPv4 missing.
	* Severity: warning.
	* 
	* Cluster interface is connected to a WAN network but doesn't have a public IPv4 assigned.
	*/
	const CLUSTER_INTERFACE_WAN_IPV4_MISSING=58;


	/**
	* Cluster interfaces public IP missing.
	* Severity: important.
	* 
	* Cluster interfaces connected to a WAN network should have a public IP address assigned.
	*/
	const CLUSTER_INTERFACES_WAN_IP_MISSING=57;


	/**
	* Cluster node count is zero.
	* Severity: warning.
	* 
	* Cluster is configured with zero nodes (servers).
	*/
	const CLUSTER_NODE_COUNT_ZERO=49;


	/**
	* Cluster not bootable.
	* Severity: warning.
	* 
	* Cluster doesn't have any bootable LUNs attached.
	*/
	const CLUSTER_NOT_BOOTABLE=47;


	/**
	* Cluster started.
	* Severity: info.
	* 
	* A cluster has been successfully started after being stopped, but it is not yet deployed.
	*/
	const CLUSTER_STARTED=99;


	/**
	* Cluster stopped.
	* Severity: info.
	* 
	* A cluster has been successfully stopped, but not yet deployed.
	*/
	const CLUSTER_STOPPED=98;


	/**
	* Cluster undeployed.
	* Severity: success.
	* 
	* Cluster is in "ordered" status and the servers have been deallocated.
	*/
	const CLUSTER_UNDEPLOYED=15;


	/**
	* Firewall deleted.
	* Severity: info.
	* 
	* A firewall has been deleted.
	*/
	const FIREWALL_DELETED=113;


	/**
	* Infrastructure created.
	* Severity: info.
	* 
	* An infrastructure has been successfully created, but not yet deployed.
	*/
	const INFRASTRUCTURE_CREATED=76;


	/**
	* Infrastructure deployed.
	* Severity: success.
	* 
	* Deploy completed for every operation on the specified infrastructure.
	*/
	const INFRASTRUCTURE_DEPLOYED=39;


	/**
	* Infrastructure user added.
	* Severity: info.
	* 
	* A user has been added to an infrastructure.
	*/
	const INFRASTRUCTURE_USER_ADDED=77;


	/**
	* Infrastructure user removed.
	* Severity: info.
	* 
	* A user has been removed from an infrastructure.
	*/
	const INFRASTRUCTURE_USER_REMOVED=80;


	/**
	* Infrastructure user updated.
	* Severity: info.
	* 
	* An infrastructure user has been updated.
	*/
	const INFRASTRUCTURE_USER_UPDATED=79;


	/**
	* IP address allocated.
	* Severity: info.
	* 
	* An IP address has been successfully allocated.
	*/
	const IP_ALLOCATED=41;


	/**
	* IP address deallocated.
	* Severity: info.
	* 
	* An IP address has been successfully deallocated.
	*/
	const IP_DEALLOCATED=87;


	/**
	* IP index allocated.
	* Severity: success.
	* 
	* IP index has been successfully allocated.
	*/
	const IP_INDEX_ALLOCATED=40;


	/**
	* Ippool Cleared.
	* Severity: info.
	* 
	* Ippool was cleared and all ips deleted. The ippool itself is still operational.
	*/
	const IPPOOL_CLEARED=105;


	/**
	* IP pool created.
	* Severity: info.
	* 
	* An IP pool has been successfully created, but not yet deployed.
	*/
	const IPPOOL_CREATED=85;


	/**
	* IP pool deleted.
	* Severity: info.
	* 
	* An IP pool has been successfully deleted, but not yet deployed.
	*/
	const IPPOOL_DELETED=86;


	/**
	* IP pool deployed.
	* Severity: success.
	* 
	* Deploy completed for IP pool operation.
	*/
	const IPPOOL_DEPLOYED=28;


	/**
	* IP pool deleted.
	* Severity: info.
	* 
	* An IP pool has been successfully edited, but not yet deployed.
	*/
	const IPPOOL_EDITED=84;


	/**
	* IPPool stopped.
	* Severity: info.
	* 
	* An IPPool has been successfully stopped, but not yet deployed.
	*/
	const IPPOOL_STOPPED=100;


	/**
	* IP pool undeployed.
	* Severity: success.
	* 
	* IP pool is in "ordered" status and the IPs have been deallocated.
	*/
	const IPPOOL_UNDEPLOYED=31;


	/**
	* LUN attached node.
	* Severity: info.
	* 
	* A LUN has been successfully attached to an existing node.
	*/
	const LUN_ATTACHED_NODE=90;


	/**
	* LUN cloned.
	* Severity: info.
	* 
	* A LUN has been successfully cloned, but not yet deployed.
	*/
	const LUN_CLONED=74;


	/**
	* LUN created.
	* Severity: info.
	* 
	* A LUN has been successfully created, but not yet deployed.
	*/
	const LUN_CREATED=73;


	/**
	* LUN deleted.
	* Severity: info.
	* 
	* A LUN has been successfully deleted, but not yet deployed.
	*/
	const LUN_DELETED=75;


	/**
	* LUN deployed.
	* Severity: success.
	* 
	* Deploy completed for LUN operation.
	*/
	const LUN_DEPLOYED=32;


	/**
	* LUN detached node.
	* Severity: info.
	* 
	* A LUN has been successfully detached from an existing node.
	*/
	const LUN_DETACHED_NODE=94;


	/**
	* LUN edited.
	* Severity: info.
	* 
	* A LUN has been successfully edited, but not yet deployed.
	*/
	const LUN_EDITED=97;


	/**
	* LUN started.
	* Severity: info.
	* 
	* A LUN has been successfully started after being stopped, but it is not yet deployed.
	*/
	const LUN_STARTED=115;


	/**
	* LUN stopped.
	* Severity: info.
	* 
	* A LUN has been successfully stopped, but not yet deployed.
	*/
	const LUN_STOPPED=114;


	/**
	* Network created.
	* Severity: info.
	* 
	* A network has been successfully created, but not yet deployed.
	*/
	const NETWORK_CREATED=81;


	/**
	* Network deleted.
	* Severity: info.
	* 
	* A network has been successfully deleted, but not yet deployed.
	*/
	const NETWORK_DELETED=83;


	/**
	* Network deployed.
	* Severity: success.
	* 
	* Deploy completed for network operation.
	*/
	const NETWORK_DEPLOYED=24;


	/**
	* Network edited.
	* Severity: info.
	* 
	* A network has been successfully edited, but not yet deployed.
	*/
	const NETWORK_EDITED=82;


	/**
	* Network started.
	* Severity: info.
	* 
	* A network has been successfully started after being stopped, but it is not yet deployed.
	*/
	const NETWORK_STARTED=107;


	/**
	* Network stopped.
	* Severity: info.
	* 
	* A network has been successfully stopped, but not yet deployed.
	*/
	const NETWORK_STOPPED=106;


	/**
	* Network undeployed.
	* Severity: success.
	* 
	* Network is in "ordered" status and the IP pools have been deallocated.
	*/
	const NETWORK_UNDEPLOYED=27;


	/**
	* Node cloned.
	* Severity: info.
	* 
	* A node has been successfully cloned, but not yet deployed.
	*/
	const NODE_CLONED=72;


	/**
	* Node created.
	* Severity: info.
	* 
	* A node has been successfully created, but not yet deployed.
	*/
	const NODE_CREATED=63;


	/**
	* Node deleted.
	* Severity: info.
	* 
	* A node has been successfully deleted, but not yet deployed.
	*/
	const NODE_DELETED=66;


	/**
	* Node edited.
	* Severity: info.
	* 
	* A node has been successfully edited, but not yet deployed.
	*/
	const NODE_EDITED=67;


	/**
	* Node interface created.
	* Severity: info.
	* 
	* A node interface has been successfully created, but not yet deployed.
	*/
	const NODE_INTERFACE_CREATED=70;


	/**
	* Node interface deleted.
	* Severity: info.
	* 
	* A node interface has been successfully deleted, but not yet deployed.
	*/
	const NODE_INTERFACE_DELETED=116;


	/**
	* Node interface edited.
	* Severity: info.
	* 
	* A node interface has been successfully edited, but not yet deployed.
	*/
	const NODE_INTERFACE_EDITED=71;


	/**
	* Node interface stopped.
	* Severity: info.
	* 
	* A node interface has been successfully stopped, but not yet deployed.
	*/
	const NODE_INTERFACE_STOPPED=102;


	/**
	* Node stopped.
	* Severity: info.
	* 
	* A node has been successfully stopped, but not yet deployed.
	*/
	const NODE_STOPPED=101;


	/**
	* Product current operation cancelled.
	* Severity: info.
	* 
	* A product's current operation has been successfully cancelled.
	*/
	const PRODUCT_CURRENT_OPERATION_CANCELLED=78;


	/**
	* User delegate added.
	* Severity: info.
	* 
	* An user has delegated another user to be his representative. The delegate can now create infrastructures on behalf of the represented user.
	*/
	const USER_DELEGATE_ADDED=91;


	/**
	* User delegate removed.
	* Severity: info.
	* 
	* An user no longer a delegate of another user.
	*/
	const USER_DELEGATE_REMOVED=92;


	/**
	* User SSH key successfully created.
	* Severity: info.
	* 
	* An user's SSH key has been successfully created.
	*/
	const USER_SSH_KEY_CREATED=59;


	/**
	* User SSH key deleted.
	* Severity: info.
	* 
	* An user's SSH key has been successfully deleted.
	*/
	const USER_SSH_KEY_DELETED=89;
}