
"""
* BSI, API v1.1 
"""

class BSI_Exception(Exception):

	

	"""
	Cluster is already deployed.
	
	Cluster is already deployed. Used in forms.
	"""
	CLUSTER_HAS_NO_UNPROVISIONED_INSTANCES=194


	"""
	A cluster interface is being connected to a network of an invalid type.
	
	A cluster interface must be connected to:
	  - a SAN network if its index is 0
	  - any other type of network if its index is greater than 0.
	"""
	CLUSTER_INTERFACE_NETWORK_ATTACH_FAILURE=151


	"""
	Not allowed to attach network.
	
	.
	"""
	CLUSTER_INTERFACE_NETWORK_ATTACH_NOT_ALLOWED=188


	"""
	Not allowed to detach network.
	
	.
	"""
	CLUSTER_INTERFACE_NETWORK_DETACH_NOT_ALLOWED=187


	"""
	Cluster interface not found.
	
	This error code may be the result of an internal error or anomaly, which cannot be fixed or worked around.
	"""
	CLUSTER_INTERFACE_NOT_FOUND=186


	"""
	Cluster creation or editing fails because of an invalid LUN template.
	
	A cluster cannot be created or edited using a LUN template that:
	  - is from another infrastructure
	  - does not exist in storage.
	"""
	CLUSTER_INVALID_LUN_TEMPLATE=150


	"""
	Cluster not found.
	
	.
	"""
	CLUSTER_NOT_FOUND=185


	"""
	Domain label already in use.
	
	.
	"""
	DOMAIN_LABEL_ALREADY_IN_USE=197


	"""
	DNS domain label invalid.
	
	A domain label must follow the rules:
	  - can be between 1 and 63 characters long
	  - start with a letter
	  - end with a letter or a digit
	  - contain only letters, digits and hyphens(-).
	"""
	DOMAIN_LABEL_INVALID=199


	"""
	Unable to resolve subdomain label.
	
	A subdomain label of one of the following: "cluster", "infrastructure", "ippool", "lun", "network", "instance" could not be resolved.
	"""
	DOMAIN_LABEL_UNABLE_TO_RESOLVE=198


	"""
	Domain name invalid.
	
	Invalid domain name. See RFC 1035 for more information.
	"""
	DOMAIN_NAME_INVALID=17


	"""
	Invalid email address.
	
	Invalid RFC 5321, 5322 and 2821 email address. It is possible for some valid addresses to be rejected because some RFC specifications are not implemented or not allowed (the domain part is not allowed to be an IP address, the domain must have a IANA root and cannot be a simple hostname, comments are not supported and other limitations).
	"""
	EMAIL_ADDRESS_INVALID=54


	"""
	Event not found.
	
	The event to be operated on was not found.
	"""
	EVENT_NOT_FOUND=148


	"""
	Could not find a hardware configuration.
	
	Matching a hardware configuration doesn't always work depending on the configured target hardware, internal matching algorithms and/or hardware availability.
	"""
	HARDWARE_CONFIGURATIONS_NOT_FOUND=141


	"""
	Infrastructure is locked for deploy.
	
	Infrastructure cannot be deployed in certain conditions. 
	Example: infrastructure has elements that have operations ongoing at the time when infrastructure_deploy method is called.
	"""
	INFRASTRUCTURE_DEPLOY_STATUS_LOCKED=206


	"""
	Infrastructure has ongoing changes.
	
	Changes cannot be applied to a product while the infrastructure it belongs to has ongoing changes.
	"""
	INFRASTRUCTURE_HAS_ONGOING_CHANGES=216


	"""
	Infrastructure not found.
	
	The infrastructure does not exist.
	"""
	INFRASTRUCTURE_NOT_FOUND=152


	"""
	Infrastructure user removal is not allowed.
	
	The infrastructure owner cannot be removed.
	"""
	INFRASTRUCTURE_USER_REMOVE_NOT_ALLOWED=145


	"""
	Infrastructures mixing not allowed.
	
	Elements of one infrastructure cannot be used on another. For example, a LUN created on infrastructure A cannot be attached to an instance of infrastructure B.
	"""
	INFRASTRUCTURES_MIXING_NOT_ALLOWED=110


	"""
	Instance interface not found.
	
	.
	"""
	INSTANCE_INTERFACE_NOT_FOUND=219


	"""
	Cannot delete the last instance from a cluster.
	
	Cannot delete the last instance from a cluster.
	"""
	INSTANCE_IS_LAST_FROM_CLUSTER=178


	"""
	Instance locked by an ongoing deployment.
	
	During deployment some operations are not allowed.
	"""
	INSTANCE_LOCKED_BY_DEPLOY=179


	"""
	Instance not active.
	
	Some operations require the service status to be active. 
	For example powering the instance on or off requires a server to be allocated to the instance.
	"""
	INSTANCE_NOT_ACTIVE=100


	"""
	Invalid RSA cipher format.
	
	RSA ciphers must be prefixed with the ID of the RSA pair and a slash ("/"). See the temp_key_pair_id property of the object returned by transport_request_public_key().
	"""
	INVALID_FORMAT_RSA_CIPHER=163


	"""
	Empty string password.
	
	Password cannot be an empty string.
	"""
	INVALID_PASSWORD_EMPTY=164


	"""
	Invalid MD5 password.
	
	Some functions require passwords to be an MD5 hash.
	"""
	INVALID_PASSWORD_MD5=161


	"""
	Invalid absolute HTTP URL.
	
	Invalid absolute HTTP URL.
	"""
	INVALID_URL_HTTP_ABSOLUTE=165


	"""
	Invalid user type.
	
	An invalid user type was specified as an object property or function parameter.
	"""
	INVALID_USER_TYPE=162


	"""
	IP address has an invalid format.
	
	An IP address (IPv4 or IPv6) has an invalid format.
	"""
	IP_ADDRESS_INVALID=153


	"""
	IP address not found.
	
	The IP address does not exist.
	"""
	IP_ADDRESS_NOT_FOUND=166


	"""
	IP provision fails because no IP address is available.
	
	The error is thrown during the IP address provision, if the IP address is not in the IPPool's range.
	"""
	IP_PROVISION_NO_IP_AVAILABLE=83


	"""
	IP address reserve failure.
	
	The instance network interface and the IP Pool must be on the same network (must have the same network_id property value).
	"""
	IP_RESERVE_FAILED=19


	"""
	IPPool create failure.
	
	If an IPPool is created, but can not find any free subnet pools from which to allocate IP addresses, this exception is thrown.
	"""
	IPPOOL_CREATE_FAILED=16


	"""
	At least one cluster network interface must be connected to a network.
	
	At least one cluster network interface must be connected to a network.
	"""
	IPPOOL_DEPLOY_CLUSTER_INTERFACES_DISCONNECTED=159


	"""
	IPPool exhausted.
	
	The IP pool has run out of available IP addresses.
	"""
	IPPOOL_EXHAUSTED=160


	"""
	Maxim count of IP pools reached.
	
	There is a maximum count of one public IPv6 IP pool. IP pools for LAN networks cannot be allocated at the moment.
	"""
	IPPOOL_MAXIMUM_COUNT_REACHED=7


	"""
	Not allowed to change the IP pool's parent network.
	
	This operation is currently unsupported.
	"""
	IPPOOL_NETWORK_CHANGING_NOT_ALLOWED=189


	"""
	Language not available.
	
	Language is not available.
	"""
	LANGUAGE_NOT_AVAILABLE=196


	"""
	LUN array is already attached.
	
	A LUN array that is already attached to a cluster does not support the operation "lun_array_attach_cluster".
	"""
	LUN_ARRAY_IS_ATTACHED=203


	"""
	The LUN array is not bootable.
	
	.
	"""
	LUN_ARRAY_NOT_BOOTABLE=202


	"""
	LUN deploy failed.
	
	The LUN could not be deployed.
	"""
	LUN_DEPLOY_FAILED=142


	"""
	LUN import already cancelled.
	
	The LUN import could not be cancelled as it has already been cancelled.
	"""
	LUN_IMPORT_ALREADY_CANCELLED=124


	"""
	LUN import already finalized.
	
	The LUN import could not be cancelled as it has already been finalized.
	"""
	LUN_IMPORT_ALREADY_FINALIZED=125


	"""
	Flat file size get failed.
	
	The size of the flat file could not be retrieved.
	"""
	LUN_IMPORT_FLAT_FILE_SIZE_GET_FAILED=131


	"""
	Invalid OVA file.
	
	The file MIME does not match the required OVA file MIME. The OVA file must be a tar archive.
	"""
	LUN_IMPORT_INVALID_OVA=128


	"""
	LUN import not cancelled.
	
	The LUN import could not be restarted. Only cancelled LUN imports can be restarted.
	"""
	LUN_IMPORT_NOT_CANCELLED=126


	"""
	OVA file deflation failed.
	
	The OVA file could not be deflated. The OVA file might be broken.
	"""
	LUN_IMPORT_OVA_DEFLATION_FAILED=130


	"""
	OVA temporary deflation directory creation failed.
	
	A temporary directory for the OVA deflation could not be created.
	"""
	LUN_IMPORT_OVA_DIRECTORY_CREATION_FAILED=129


	"""
	OVA MIME get failed.
	
	The OVA file MIME could not be retrieved.
	"""
	LUN_IMPORT_OVA_MIME_GET_FAILED=127


	"""
	LUN is already attached.
	
	A LUN that is already attached to an instance does not support the operation "lun_attach_instance".
	"""
	LUN_IS_ATTACHED=144


	"""
	LUN is not attached.
	
	A LUN that is not already attached to an instance does not support the operation "lun_detach_instance".
	"""
	LUN_IS_NOT_ATTACHED=111


	"""
	LUN not active.
	
	For certain operations, LUNs are required to be in active status.
	For example, lun_edit() can operate only on an active LUN.
	"""
	LUN_NOT_ACTIVE=80


	"""
	LUN size provided is invalid.
	
	LUN size provided for an edit operation is less than the original size of LUN.
	LUN size provided is greater than the maximum allowed or less than the minimum allowed.
	"""
	LUN_SIZE_INVALID=91


	"""
	The maximum count of LUNs on a LUN Array or instances on a cluster has been exceeded.
	
	.
	"""
	MAXIMUM_COUNT_EXCEEDED=204


	"""
	Only one WAN and SAN network per infrastructure.
	
	An infrastructure can have only one WAN and one SAN network attached to it.
	"""
	NETWORK_LIMIT_EXCEEDED=154


	"""
	Network cannot be deleted.
	
	WAN and SAN networks cannot be deleted from an infrastructure.
	"""
	NETWORK_NOT_DELETABLE=155


	"""
	Authentication failure.
	
	Authentication is required and it failed. Possible reasons include:
	 - invalid request parameters;
	 - invalid authentication method;
	 - incorrect credentials;
	 - incorrect signature.
	
	This error normally occurs if authentication is required. It may also occur on functions which perform authentication, if called directly.
	"""
	NOT_AUTHENTICATED=73


	"""
	Authorization failure.
	
	Authenticated user failed authorization. Reasons include:
	 - the called function is not allowed for the authenticated user's type;
	 - authenticated user does not have access to the operated upon resources.
	"""
	NOT_AUTHORIZED=71


	"""
	A feature is not implemented.
	
	Thrown when a certain feature or capability is not implemented yet, is reserved or is planned.
	"""
	NOT_IMPLEMENTED=3


	"""
	The provided object is invalid.
	
	.
	"""
	OBJECT_IS_INVALID=218


	"""
	Type of the parameter provided is not as expected.
	
	Type of the parameter provided is not as expected. For example, any label provided is expected to be a string.
	"""
	PARAM_TYPE_MISMATCH=93


	"""
	Value of parameter is invalid.
	
	Some parameters' values require specific formats of input data, or a specific set of allowed values.
	"""
	PARAM_VALUE_INVALID=143


	"""
	Incorrect user password.
	
	Thrown when authentication fails due to incorrect user password.
	"""
	PASSWORD_INCORRECT=45


	"""
	Invalid product edit parameters.
	
	General error code thrown by edit functions. Inspect the thrown error message for more information.
	"""
	PRODUCT_EDIT_INVALID_PARAMETERS=96


	"""
	Infrastructure mismatch.
	
	Object property "infrastructure_id" is not the infrastructure of the specified object.
	"""
	PRODUCT_INFRASTRUCTURE_MISMATCH=140


	"""
	Product does not exist.
	
	A requested resource, such as calling "luns()", or an object property which points to a resource (for example the "network_id" key on an IP pool object) does not exist.
	"""
	PRODUCT_NOT_FOUND=103


	"""
	Product with changes cannot be started.
	
	.
	"""
	PRODUCT_WITH_CHANGES_CANNOT_BE_STARTED=209


	"""
	Product with changes cannot be stopped.
	
	.
	"""
	PRODUCT_WITH_CHANGES_CANNOT_BE_STOPPED=208


	"""
	Product with delete operation not deployed cannot be edited.
	
	.
	"""
	PRODUCT_WITH_DELETE_OPERATION_CANNOT_BE_EDITED=211


	"""
	Invalid property value.
	
	An object's property value did not pass a validation test.
	"""
	PROPERTY_IS_INVALID=137


	"""
	Mandatory property.
	
	Some object properties are mandatory.
	"""
	PROPERTY_IS_MANDATORY=135


	"""
	Unknown property.
	
	Unknown object properties are sometimes not allowed to help catch caller typos or incorrect calls with objects which have optional properties with defaults.
	"""
	PROPERTY_IS_UNKNOWN=136


	"""
	Read only object property.
	
	Some object property values are not allowed to change. 
	For example, calling cluster_edit() with a modified infrastructure_id property might issue this error.
	"""
	PROPERTY_READ_ONLY=138


	"""
	Server drive not found.
	
	A server drive with a certain ID is not found in the database.
	"""
	SERVER_DRIVE_NOT_FOUND=177


	"""
	Server might not be ready for power status polling.
	
	Please try again later.
	"""
	SERVER_MIGHT_NOT_BE_READY_FOR_POWER_GET=210


	"""
	The server power status cannot be changed. A deploy process is currently ongoing.
	
	.
	"""
	SERVER_POWER_LOCKED_BY_ONGOING_OPERATION=214


	"""
	An operation cannot take place because the server is powered on.
	
	Some operations, such as unmounting LUNs, expanding LUNs, swapping an instance's serverwhen a server_type is changed, require the affected servers to already be powered off before a deploy call.
	"""
	SERVER_POWERED_ON=87


	"""
	Server type is not available.
	
	.
	"""
	SERVER_TYPE_UNAVAILABLE=212


	"""
	Service status is not valid.
	
	The system only supports the following service statuses that can be used for a product: "ordered", "active", "suspended", "stopped", "deleted".
	"""
	SERVICE_STATUS_INVALID=95


	"""
	SSH key unknown encoding.
	
	SSH keys are expected to be encoded in base64.
	"""
	SSH_KEY_DATA_INCORRECT_FORMAT=25


	"""
	Invalid OpenSSH/SSH2 key.
	
	OpenSSH/SSH2 key data is not valid, taking into consideration  RFC 3447 and  RFC 4716.
	"""
	SSH_KEY_INVALID_DATA_OPENSSH_SSH2=28


	"""
	Invalid PKCS#1 key.
	
	PKCS#1 key data is not valid, taking into account RFC 3447.
	"""
	SSH_KEY_INVALID_DATA_PKCS1=31


	"""
	Invalid PKCS#8 key.
	
	PKCS#8 key data is not valid, taking into account RFC 2459.
	"""
	SSH_KEY_INVALID_DATA_PKCS8=35


	"""
	Unknown SSH key format.
	
	SSH key format is not recognized. The allowed ssh key formats are: OpenSSH, SSH2, PKCS#1, PKCS#8.
	"""
	SSH_KEY_UNKNOWN_FORMAT=23


	"""
	Unknown algorithm identifier prefix for a certain SSH key.
	
	An unknown algorithm identifier prefix is found when  decoding SSH key data. The allowed alogorithm identifiers are: ssh-rsa, ssh-dsa, ssh-dss.
	"""
	SSH_KEY_UNKWOWN_ALGORITHM_IDENTIFIER=21


	"""
	No LUN template with the given ID exists.
	
	A LUN template is searched, but the template does not exist.
	"""
	STORAGE_LUN_TEMPLATE_NOT_FOUND=68


	"""
	Snapshot not found.
	
	Can occur when searching for LUN template snapshots or attempting to retrieve or operate on a specific snapshot.
	"""
	STORAGE_SNAPSHOT_NOT_FOUND=94


	"""
	Switch device interface does not exist.
	
	Error code returned when trying to get a switch device that does not exist.
	"""
	SWITCH_DEVICE_INTERFACE_NOT_FOUND=207


	"""
	Invalid timestamp format.
	
	Timestamps must be in a particular ISO 8601 format and in UTC. Example format: "2013-12-31T14:09:12Z".
	"""
	TIMESTAMP_INVALID=149


	"""
	File upload failed.
	
	An error has been encountered while uploading the file.
	"""
	UPLOAD_FAILED=114


	"""
	Upload file creation failed.
	
	A temporary file for the AJAX upload could not be created.
	"""
	UPLOAD_FILE_CREATION_FAILED=115


	"""
	Upload file move failed.
	
	The temporary file for the AJAX upload could not be moved.
	"""
	UPLOAD_FILE_MOVE_FAILED=118


	"""
	Upload file open failed.
	
	The temporary file created for the AJAX upload could not be opened for writing.
	"""
	UPLOAD_FILE_OPEN_FAILED=117


	"""
	Upload stream open failed.
	
	The AJAX upload stream could not be opened for reading.
	"""
	UPLOAD_STREAM_OPEN_FAILED=116


	"""
	A user cannot add himself as his own delegate.
	
	.
	"""
	USER_DELEGATE_CANNOT_ADD_SELF=193


	"""
	User account is disabled.
	
	Some operations are not allowed on a disabled account. Disabled accounts cannot be authenticated and are restricted from some associations or modifications for security reasons.
	"""
	USER_DISABLED=62


	"""
	Verification email rate limit.
	
	Password recovery or login email address verification emails are rate limited to prevent spamming.
	"""
	USER_EMAIL_LIMIT_REACHED=52


	"""
	Duplicate user login emails are not allowed.
	
	The login email must be unique per user account.
	"""
	USER_LOGIN_EMAIL_ALREADY_EXISTS=57


	"""
	The new user login email is the same as the existing one.
	
	.
	"""
	USER_LOGIN_EMAIL_IS_THE_SAME=192


	"""
	User login email is not verified.
	
	For security reasons, most operations are not allowed on newly created user accounts with an unverified login email address.
	"""
	USER_LOGIN_EMAIL_NOT_VERIFIED=46


	"""
	The specified user is not a delegate.
	
	A user is not a delegate of another user.
	"""
	USER_NOT_A_DELEGATE=213


	"""
	User is not associated with the infrastructure.
	
	A user was not associated with the infrastructure provided in infrastructure_remove_user.
	"""
	USER_NOT_ASSOCIATED_WITH_INFRASTRUCTURE=174


	"""
	User is not billable.
	
	The user must be billable in order to be able to perform certain operations.
	"""
	USER_NOT_BILLABLE=217


	"""
	User not found.
	
	A user was not found for a specified user ID (object property, function parameter, etc).
	"""
	USER_NOT_FOUND=42


	"""
	Duplicate SSH keys are not allowed.
	
	A user cannot have duplicate SSH keys.
	"""
	USER_SSH_KEY_DUPLICATE=10


	"""
	SSH key not found.
	
	A SSH key was not found for a specified SSH key ID (object property, function parameter, etc).
	"""
	USER_SSH_KEY_NOT_FOUND=6


	"""
	User SSH keys maximum count exceeded.
	
	The number of associated SSH keys has a finite maximum.
	"""
	USER_SSH_KEYS_MAXIMUM_COUNT_EXCEEDED=8
