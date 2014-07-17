from JSONRPC.Client import JSONRPC_client
from JSONRPC.filters.client.SignatureAdd import JSONRPC_filter_signature_add


class BSI(JSONRPC_client):

	_instance = None

	_objFilterPlugin = None

				

	def __init__(self, strJSONRPCRouterURL, strLogFilePath = None):
	
		super(BSI, self).__init__(strJSONRPCRouterURL, strLogFilePath)

		



	"""
	* This is a static function for using the BSI class as a singleton.
	* In order to work with only an instance, instead of instantiating the class,
	* call this method.
	*
	* @return object BSI._instance. It will return the same instance, no matter 
	* how many times this function is called.
	"""

	@staticmethod	
	def getInstance(strJSONRPCRouterURL, strLogFilePath = None):

		if BSI._instance is None :
			BSI._instance = BSI(strJSONRPCRouterURL, strLogFilePath)

		return BSI._instance	

			

	
	"""
	This afc is currently running.
	
	
	"""
	AFC_STATUS_RUNNING="running"
	
	
	"""
	Cluster interface index 1.
	
	
	"""
	CLUSTER_INTERFACE_INDEX_1=1
	
	
	"""
	Cluster interface index 2.
	
	
	"""
	CLUSTER_INTERFACE_INDEX_2=2
	
	
	"""
	Cluster interface index 3.
	
	
	"""
	CLUSTER_INTERFACE_INDEX_3=3
	
	
	"""
	SAN cluster interface.
	
	Cluster interface index reserved for SAN networks.
	"""
	CLUSTER_INTERFACE_INDEX_SAN=0
	
	
	"""
	SQLSelection array row span.
	
	
	"""
	COLLAPSE_ARRAY_ROW_SPAN="array_row_span"
	
	
	"""
	SQLSelection array subrows.
	
	
	"""
	COLLAPSE_ARRAY_SUBROWS="array_subrows"
	
	
	"""
	SQLSelection array subrows table.
	
	
	"""
	COLLAPSE_ARRAY_SUBROWS_TABLE="array_subrows_table"
	
	
	"""
	SQLSelection HTML rows array.
	
	
	"""
	COLLAPSE_HTML_ROWS_ARRAY="html_rows_array"
	
	
	"""
	SQLSelection HTML rows string.
	
	
	"""
	COLLAPSE_HTML_ROWS_STRING="html_rows_string"
	
	
	"""
	SQLSelection none.
	
	
	"""
	COLLAPSE_NONE="none"
	
	
	"""
	Important event.
	
	
	"""
	EVENT_SEVERITY_IMPORTANT="important"
	
	
	"""
	Info event.
	
	
	"""
	EVENT_SEVERITY_INFO="info"
	
	
	"""
	Success event.
	
	
	"""
	EVENT_SEVERITY_SUCCESS="success"
	
	
	"""
	Trigger event.
	
	
	"""
	EVENT_SEVERITY_TRIGGER="trigger"
	
	
	"""
	Warning event.
	
	
	"""
	EVENT_SEVERITY_WARNING="warning"
	
	
	"""
	Predefined hardware configurations.
	
	
	"""
	HARDWARE_CONFIGURATIONS_PREDEFINED="predefined"
	
	
	"""
	User predefined hardware configurations.
	
	
	"""
	HARDWARE_CONFIGURATIONS_USER_PREDEFINED="user_predefined"
	
	
	"""
	LAN IP pool.
	
	
	"""
	IPPOOL_DESTINATION_LAN="lan"
	
	
	"""
	SAN IP Pool.
	
	
	"""
	IPPOOL_DESTINATION_SAN="san"
	
	
	"""
	WAN IP pool.
	
	
	"""
	IPPOOL_DESTINATION_WAN="wan"
	
	
	"""
	IPv4 IP pool.
	
	
	"""
	IPPOOL_TYPE_IPV4="ipv4"
	
	
	"""
	IPv6 IP pool.
	
	
	"""
	IPPOOL_TYPE_IPV6="ipv6"
	
	
	"""
	The maximum number of LUNs that can exist in a LUN Array.
	
	
	"""
	LUN_ARRAY_MAX_LUN_COUNT=10
	
	
	"""
	LUN default SSH port.
	
	The default value of the LUN SSH port.
	"""
	LUN_DEFAULT_SSH_PORT=22
	
	
	"""
	LUN_STORAGE_TYPE_ISCSI_SSD.
	
	
	"""
	LUN_STORAGE_TYPE_ISCSI_SSD="iscsi_ssd"
	
	
	"""
	LAN network.
	
	
	"""
	NETWORK_TYPE_LAN="lan"
	
	
	"""
	SAN network.
	
	
	"""
	NETWORK_TYPE_SAN="san"
	
	
	"""
	WAN network.
	
	
	"""
	NETWORK_TYPE_WAN="wan"
	
	
	"""
	CPU Load node measurement type.
	
	
	"""
	NODE_MEASUREMENT_TYPE_CPU_LOAD="cpu_load"
	
	
	"""
	Disk size node measurement type.
	
	
	"""
	NODE_MEASUREMENT_TYPE_DISK_SIZE="disk_size"
	
	
	"""
	Disk used node measurement type.
	
	
	"""
	NODE_MEASUREMENT_TYPE_DISK_USED="disk_used"
	
	
	"""
	Network interface input node measurement type.
	
	
	"""
	NODE_MEASUREMENT_TYPE_NETWORK_INTERFACE_INPUT="net_if_input"
	
	
	"""
	Network interface output node measurement type.
	
	
	"""
	NODE_MEASUREMENT_TYPE_NETWORK_INTERFACE_OUTPUT="net_if_output"
	
	
	"""
	RAM size node measurement type.
	
	
	"""
	NODE_MEASUREMENT_TYPE_RAM_SIZE="ram_size"
	
	
	"""
	RAM used node measurement type.
	
	
	"""
	NODE_MEASUREMENT_TYPE_RAM_USED="ram_used"
	
	
	"""
	Clone operation.
	
	
	"""
	OPERATION_TYPE_CLONE="clone"
	
	
	"""
	Create operation.
	
	
	"""
	OPERATION_TYPE_CREATE="create"
	
	
	"""
	Delete operation.
	
	
	"""
	OPERATION_TYPE_DELETE="delete"
	
	
	"""
	Edit operation.
	
	
	"""
	OPERATION_TYPE_EDIT="edit"
	
	
	"""
	Start operation.
	
	
	"""
	OPERATION_TYPE_START="start"
	
	
	"""
	Stop operation.
	
	
	"""
	OPERATION_TYPE_STOP="stop"
	
	
	"""
	Finished provision status.
	
	
	"""
	PROVISION_STATUS_FINISHED="finished"
	
	
	"""
	Not started provision status.
	
	
	"""
	PROVISION_STATUS_NOT_STARTED="not_started"
	
	
	"""
	Ongoing provision status.
	
	
	"""
	PROVISION_STATUS_ONGOING="ongoing"
	
	
	"""
	Redis acquired lock expire time.
	
	
	"""
	REDIS_ACQUIRED_LOCK_EXPIRE_TIME=60
	
	
	"""
	Expire time for redis second lock.
	
	Expire time for redis second lock
	"""
	REDIS_ACQUIRED_LOCK2_EXPIRE_TIME=100
	
	
	"""
	Redis cached keys expire time.
	
	
	"""
	REDIS_CACHED_KEYS_EXPIRE_TIME=360
	
	
	"""
	Redis critical token.
	
	Redis critical token
	"""
	REDIS_CRITICAL_TOKEN="critical"
	
	
	"""
	Invalid redis token.
	
	
	"""
	REDIS_INVALID_TOKEN="invalid"
	
	
	"""
	Redis token.
	
	
	"""
	REDIS_TOKEN="token"
	
	
	"""
	Valid redis token.
	
	
	"""
	REDIS_VALID_TOKEN="valid"
	
	
	"""
	Server drive installed in the server.
	
	
	"""
	SERVER_DRIVE_INSTALLED="installed"
	
	
	"""
	Server drive not installed in any server.
	
	
	"""
	SERVER_DRIVE_SPARE="spare"
	
	
	"""
	Maximum Servers Quantity.
	
	
	"""
	SERVER_MAX_SERVERS_QUANTITY=5
	
	
	"""
	Null power command. No action.
	
	Used with some power functions which are both setter and getter to just interrogate without action.
	"""
	SERVER_POWER_STATUS_NONE="none"
	
	
	"""
	Server powered off.
	
	Power down chassis into soft off (S4/S5 state). WARNING: This command does not initiate a clean shutdown of the operating system prior to powering down the system.
	"""
	SERVER_POWER_STATUS_OFF="off"
	
	
	"""
	Server powered on.
	
	Power up chassis.
	"""
	SERVER_POWER_STATUS_ON="on"
	
	
	"""
	Server power reset.
	
	This command will perform a hard reset.
	"""
	SERVER_POWER_STATUS_RESET="reset"
	
	
	"""
	Server power status soft.
	
	Initiate a soft-shutdown of OS via ACPI. This can be done in a number of ways, commonly by simulating an overtemperture or by simulating a power button press. It is necessary for there to be Operating System support for ACPI and some sort of daemon watching for events for this soft power to work.
	"""
	SERVER_POWER_STATUS_SOFT="soft"
	
	
	"""
	Server power status unknown.
	
	Returned when a server is not allocated to an instance, the instance is not deployed or has an ongoing deploy operation.
	"""
	SERVER_POWER_STATUS_UNKNOWN="unknown"
	
	
	"""
	Available server.
	
	
	"""
	SERVER_STATUS_AVAILABLE="available"
	
	
	"""
	Not available server.
	
	
	"""
	SERVER_STATUS_UNAVAILABLE="unavailable"
	
	
	"""
	Used server.
	
	
	"""
	SERVER_STATUS_USED="used"
	
	
	"""
	Active service status.
	
	
	"""
	SERVICE_STATUS_ACTIVE="active"
	
	
	"""
	Deleted service status.
	
	
	"""
	SERVICE_STATUS_DELETED="deleted"
	
	
	"""
	Ordered service status.
	
	
	"""
	SERVICE_STATUS_ORDERED="ordered"
	
	
	"""
	Stopped service status.
	
	
	"""
	SERVICE_STATUS_STOPPED="stopped"
	
	
	"""
	Suspended service status.
	
	
	"""
	SERVICE_STATUS_SUSPENDED="suspended"
	
	
	"""
	DSA algorithm.
	
	
	"""
	SSH_DSA_ALGORITHM_IDENTIFIER="ssh-dsa"
	
	
	"""
	DSS algorithm.
	
	
	"""
	SSH_DSS_ALGORITHM_IDENTIFIER="ssh-dss"
	
	
	"""
	OpenSSH SSH key.
	
	
	"""
	SSH_KEY_FORMAT_OPENSSH="openssh"
	
	
	"""
	PKCS1 SSH key.
	
	
	"""
	SSH_KEY_FORMAT_PKCS1="pkcs#1"
	
	
	"""
	PKCS8 SSH key.
	
	
	"""
	SSH_KEY_FORMAT_PKCS8="pkcs#8"
	
	
	"""
	SSH2 SSH key.
	
	
	"""
	SSH_KEY_FORMAT_SSH2="ssh2"
	
	
	"""
	RSA algorithm.
	
	
	"""
	SSH_RSA_ALGORITHM_IDENTIFIER="ssh-rsa"
	
	
	"""
	STORAGE_MAX_LUN_SIZE.
	
	
	"""
	STORAGE_MAX_LUN_SIZE=1000000
	
	
	"""
	Storage minimum LUN size.
	
	
	"""
	STORAGE_MIN_LUN_SIZE_MB=2048
	
	
	"""
	Dummy driver storage type.
	
	
	"""
	STORAGE_TYPE_DUMMY_DRIVER="dummy_driver"
	
	
	"""
	Nexenta_Standard_1 storage type.
	
	
	"""
	STORAGE_TYPE_NEXENTA_STANDARD_1="nexenta_standard_1"
	
	
	"""
	North switch device.
	
	North switch device 
	"""
	SWITCH_DEVICE_NORTH="north"
	
	
	"""
	Top of rack switch device.
	
	Top of Rack switch device
	"""
	SWITCH_DEVICE_TOR="tor"
	
	
	"""
	Not verified user e-mail address.
	
	
	"""
	USER_LOGIN_EMAIL_STATUS_NOT_VERIFIED="not_verified"
	
	
	"""
	Verified user e-mail address.
	
	
	"""
	USER_LOGIN_EMAIL_STATUS_VERIFIED="verified"
	
	
	"""
	Admin user.
	
	
	"""
	USER_TYPE_ADMIN="admin"
	
	
	"""
	Billable user.
	
	
	"""
	USER_TYPE_BILLABLE="billable"
	

	


		
	


