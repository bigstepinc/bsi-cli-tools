"""
* BSI, API v1.1 
"""
class BSI_EventTypes(object):



	"""
	Cluster cloned.
	Severity: info.
	
	A cluster has been successfully cloned, but not yet deployed.
	"""
	CLUSTER_CLONED=69


	"""
	Cluster created.
	Severity: info.
	
	A cluster has been successfully created, but not yet deployed.
	"""
	CLUSTER_CREATED=61


	"""
	Cluster deleted.
	Severity: info.
	
	A cluster has been successfully deleted, but not yet deployed.
	"""
	CLUSTER_DELETED=64


	"""
	Cluster deploy started.
	Severity: info.
	
	Deploy started for cluster operation.
	"""
	CLUSTER_DEPLOY_STARTED=125


	"""
	Cluster deployed.
	Severity: success.
	
	Deploy completed for cluster operation.
	"""
	CLUSTER_DEPLOYED=12


	"""
	Cluster edited.
	Severity: info.
	
	A cluster has been successfully edited, but not yet deployed.
	"""
	CLUSTER_EDITED=65


	"""
	Cluster instance count is zero.
	Severity: warning.
	
	Cluster is configured with zero instances (servers).
	"""
	CLUSTER_INSTANCE_COUNT_ZERO=49


	"""
	Cluster interface created.
	Severity: info.
	
	A cluster interface has been successfully created, but not yet deployed.
	"""
	CLUSTER_INTERFACE_CREATED=68


	"""
	Cluster interface deleted.
	Severity: info.
	
	A cluster interface has been successfully deleted.
	"""
	CLUSTER_INTERFACE_DELETED=103


	"""
	Cluster interface deploy started.
	Severity: info.
	
	Deploy started for cluster interface operation.
	"""
	CLUSTER_INTERFACE_DEPLOY_STARTED=126


	"""
	Cluster interface deployed.
	Severity: success.
	
	Deploy completed for cluster interface operation.
	"""
	CLUSTER_INTERFACE_DEPLOYED=16


	"""
	Cluster interface edited.
	Severity: info.
	
	A cluster interface has been successfully edited, but not yet deployed.
	"""
	CLUSTER_INTERFACE_EDITED=88


	"""
	Cluster interface undeployed.
	Severity: success.
	
	Cluster interface is in "ordered" status and the IPs have been deallocated.
	"""
	CLUSTER_INTERFACE_UNDEPLOYED=19


	"""
	Cluster interfaces public IPv4 missing.
	Severity: warning.
	
	Cluster interface is connected to a WAN network but doesn't have a public IPv4 assigned.
	"""
	CLUSTER_INTERFACE_WAN_IPV4_MISSING=58


	"""
	Cluster interfaces public IP missing.
	Severity: important.
	
	Cluster interfaces connected to a WAN network should have a public IP address assigned.
	"""
	CLUSTER_INTERFACES_WAN_IP_MISSING=57


	"""
	Cluster not bootable.
	Severity: warning.
	
	Cluster doesn't have any bootable LUNs attached.
	"""
	CLUSTER_NOT_BOOTABLE=47


	"""
	Cluster started.
	Severity: info.
	
	A cluster has been successfully started after being stopped, but it is not yet deployed.
	"""
	CLUSTER_STARTED=99


	"""
	Cluster stopped.
	Severity: info.
	
	A cluster has been successfully stopped, but not yet deployed.
	"""
	CLUSTER_STOPPED=98


	"""
	Cluster undeployed.
	Severity: success.
	
	Cluster is in "ordered" status and the servers have been deallocated.
	"""
	CLUSTER_UNDEPLOYED=15


	"""
	Firewall deleted.
	Severity: info.
	
	A firewall has been deleted.
	"""
	FIREWALL_DELETED=113


	"""
	Infrastructure created.
	Severity: info.
	
	An infrastructure has been successfully created, but not yet deployed.
	"""
	INFRASTRUCTURE_CREATED=76


	"""
	Infrastructure deploy started.
	Severity: info.
	
	Deploy started for the specified infrastructure.
	"""
	INFRASTRUCTURE_DEPLOY_STARTED=127


	"""
	Infrastructure deployed.
	Severity: success.
	
	Deploy completed for every operation on the specified infrastructure.
	"""
	INFRASTRUCTURE_DEPLOYED=39


	"""
	Infrastructure user added.
	Severity: info.
	
	A user has been added to an infrastructure.
	"""
	INFRASTRUCTURE_USER_ADDED=77


	"""
	Infrastructure user removed.
	Severity: info.
	
	A user has been removed from an infrastructure.
	"""
	INFRASTRUCTURE_USER_REMOVED=80


	"""
	Infrastructure user updated.
	Severity: info.
	
	An infrastructure user has been updated.
	"""
	INFRASTRUCTURE_USER_UPDATED=79


	"""
	Instance cloned.
	Severity: info.
	
	An instance has been successfully cloned, but not yet deployed.
	"""
	INSTANCE_CLONED=72


	"""
	Instance created.
	Severity: info.
	
	An instance has been successfully created, but not yet deployed.
	"""
	INSTANCE_CREATED=63


	"""
	Instance deleted.
	Severity: info.
	
	An instance has been successfully deleted, but not yet deployed.
	"""
	INSTANCE_DELETED=66


	"""
	Instance edited.
	Severity: info.
	
	An instance has been successfully edited, but not yet deployed.
	"""
	INSTANCE_EDITED=67


	"""
	Instance interface created.
	Severity: info.
	
	An instance interface has been successfully created, but not yet deployed.
	"""
	INSTANCE_INTERFACE_CREATED=70


	"""
	Instance interface deleted.
	Severity: info.
	
	An instance interface has been successfully deleted, but not yet deployed.
	"""
	INSTANCE_INTERFACE_DELETED=116


	"""
	Instance interface edited.
	Severity: info.
	
	An instance interface has been successfully edited, but not yet deployed.
	"""
	INSTANCE_INTERFACE_EDITED=71


	"""
	Instance interface stopped.
	Severity: info.
	
	An instance interface has been successfully stopped, but not yet deployed.
	"""
	INSTANCE_INTERFACE_STOPPED=102


	"""
	Instance stopped.
	Severity: info.
	
	An instance has been successfully stopped, but not yet deployed.
	"""
	INSTANCE_STOPPED=101


	"""
	IP address allocated.
	Severity: info.
	
	An IP address has been successfully allocated.
	"""
	IP_ALLOCATED=41


	"""
	IP address deallocated.
	Severity: info.
	
	An IP address has been successfully deallocated.
	"""
	IP_DEALLOCATED=87


	"""
	IP index allocated.
	Severity: success.
	
	IP index has been successfully allocated.
	"""
	IP_INDEX_ALLOCATED=40


	"""
	IPPool cleared.
	Severity: info.
	
	Ippool was cleared and all ips deleted. The ippool itself is still operational.
	"""
	IPPOOL_CLEARED=105


	"""
	IP pool created.
	Severity: info.
	
	An IP pool has been successfully created, but not yet deployed.
	"""
	IPPOOL_CREATED=85


	"""
	IP pool deleted.
	Severity: info.
	
	An IP pool has been successfully deleted, but not yet deployed.
	"""
	IPPOOL_DELETED=86


	"""
	IP pool deploy started.
	Severity: info.
	
	Deploy started for IP pool operation.
	"""
	IPPOOL_DEPLOY_STARTED=128


	"""
	IP pool deployed.
	Severity: success.
	
	Deploy completed for IP pool operation.
	"""
	IPPOOL_DEPLOYED=28


	"""
	IP pool deleted.
	Severity: info.
	
	An IP pool has been successfully edited, but not yet deployed.
	"""
	IPPOOL_EDITED=84


	"""
	IPPool stopped.
	Severity: info.
	
	An IPPool has been successfully stopped, but not yet deployed.
	"""
	IPPOOL_STOPPED=100


	"""
	IP pool undeployed.
	Severity: success.
	
	IP pool is in "ordered" status and the IPs have been deallocated.
	"""
	IPPOOL_UNDEPLOYED=31


	"""
	LUN array cloned.
	Severity: info.
	
	.
	"""
	LUN_ARRAY_CLONED=122


	"""
	LUN array created.
	Severity: info.
	
	.
	"""
	LUN_ARRAY_CREATED=121


	"""
	LUN array deleted.
	Severity: info.
	
	.
	"""
	LUN_ARRAY_DELETED=123


	"""
	LUN array deploy started.
	Severity: info.
	
	Deploy started for LUN array operation.
	"""
	LUN_ARRAY_DEPLOY_STARTED=129


	"""
	LUN array deployed.
	Severity: success.
	
	.
	"""
	LUN_ARRAY_DEPLOYED=124


	"""
	LUN array edited.
	Severity: info.
	
	.
	"""
	LUN_ARRAY_EDITED=118


	"""
	LUN array started.
	Severity: info.
	
	.
	"""
	LUN_ARRAY_STARTED=119


	"""
	LUN array stopped.
	Severity: info.
	
	.
	"""
	LUN_ARRAY_STOPPED=120


	"""
	LUN attached instance.
	Severity: info.
	
	A LUN has been successfully attached to an existing instance.
	"""
	LUN_ATTACHED_INSTANCE=90


	"""
	LUN cloned.
	Severity: info.
	
	A LUN has been successfully cloned, but not yet deployed.
	"""
	LUN_CLONED=74


	"""
	LUN created.
	Severity: info.
	
	A LUN has been successfully created, but not yet deployed.
	"""
	LUN_CREATED=73


	"""
	LUN deleted.
	Severity: info.
	
	A LUN has been successfully deleted, but not yet deployed.
	"""
	LUN_DELETED=75


	"""
	LUN deploy started.
	Severity: info.
	
	Deploy started for LUN operation.
	"""
	LUN_DEPLOY_STARTED=130


	"""
	LUN deployed.
	Severity: success.
	
	Deploy completed for LUN operation.
	"""
	LUN_DEPLOYED=32


	"""
	LUN detached instance.
	Severity: info.
	
	A LUN has been successfully detached from an existing instance.
	"""
	LUN_DETACHED_INSTANCE=94


	"""
	LUN edited.
	Severity: info.
	
	A LUN has been successfully edited, but not yet deployed.
	"""
	LUN_EDITED=97


	"""
	LUN started.
	Severity: info.
	
	A LUN has been successfully started after being stopped, but it is not yet deployed.
	"""
	LUN_STARTED=115


	"""
	LUN stopped.
	Severity: info.
	
	A LUN has been successfully stopped, but not yet deployed.
	"""
	LUN_STOPPED=114


	"""
	Network created.
	Severity: info.
	
	A network has been successfully created, but not yet deployed.
	"""
	NETWORK_CREATED=81


	"""
	Network deleted.
	Severity: info.
	
	A network has been successfully deleted, but not yet deployed.
	"""
	NETWORK_DELETED=83


	"""
	Network deploy started.
	Severity: info.
	
	Deploy started for network operation.
	"""
	NETWORK_DEPLOY_STARTED=131


	"""
	Network deployed.
	Severity: success.
	
	Deploy completed for network operation.
	"""
	NETWORK_DEPLOYED=24


	"""
	Network edited.
	Severity: info.
	
	A network has been successfully edited, but not yet deployed.
	"""
	NETWORK_EDITED=82


	"""
	Network started.
	Severity: info.
	
	A network has been successfully started after being stopped, but it is not yet deployed.
	"""
	NETWORK_STARTED=107


	"""
	Network stopped.
	Severity: info.
	
	A network has been successfully stopped, but not yet deployed.
	"""
	NETWORK_STOPPED=106


	"""
	Network undeployed.
	Severity: success.
	
	Network is in "ordered" status and the IP pools have been deallocated.
	"""
	NETWORK_UNDEPLOYED=27


	"""
	Product current operation cancelled.
	Severity: info.
	
	A product's current operation has been successfully cancelled.
	"""
	PRODUCT_CURRENT_OPERATION_CANCELLED=78


	"""
	User delegate added.
	Severity: info.
	
	An user has delegated another user to be his representative. The delegate can now create infrastructures on behalf of the represented user.
	"""
	USER_DELEGATE_ADDED=91


	"""
	User delegate removed.
	Severity: info.
	
	A user is no longer the delegate of another user.
	"""
	USER_DELEGATE_REMOVED=92


	"""
	User SSH key successfully created.
	Severity: info.
	
	The user's SSH key has been successfully created.
	"""
	USER_SSH_KEY_CREATED=59


	"""
	User SSH key deleted.
	Severity: info.
	
	The user's SSH key has been successfully deleted.
	"""
	USER_SSH_KEY_DELETED=89
