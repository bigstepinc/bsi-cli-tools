<?php
/**
* BSI, API v1.0 
*/
class BSI_Exception extends Exception
{ 


	/**
	* A cluster interface is being connected to a network of an invalid type.
	* 
	* A cluster interface must be connected to:
	*   - a SAN network if its index is 0
	*   - any other type of network if its index is greater than 0.
	*/
	const CLUSTER_INTERFACE_NETWORK_ATTACH_FAILURE=151;


	/**
	* Cluster creation or editing fails because of an invalid LUN template.
	* 
	* A cluster cannot be created or edited using a LUN template that:
	*   - is from another infrastructure
	*   - does not exist in storage.
	*/
	const CLUSTER_INVALID_LUN_TEMPLATE=150;


	/**
	* Domain name invalid.
	* 
	* Invalid domain name. See RFC 1035 for more information.
	*/
	const DOMAIN_NAME_INVALID=17;


	/**
	* Invalid email address.
	* 
	* Invalid RFC 5321, 5322 and 2821 email address. It is possible for some valid addresses to be rejected because some RFC specifications are not implemented or not allowed (the domain part is not allowed to be an IP address, 
	* the domain must have a IANA root and cannot be a simple hostname, 
	* comments are not supported and other limitations).
	*/
	const EMAIL_ADDRESS_INVALID=54;


	/**
	* Event not found.
	* 
	* The event to be operated on was not found.
	*/
	const EVENT_NOT_FOUND=148;


	/**
	* Could not find a hardware configuration.
	* 
	* Matching a hardware configuration doesn't always work depending on the configured target hardware, internal matching algorithms and/or hardware availability.
	*/
	const HARDWARE_CONFIGURATIONS_NOT_FOUND=141;


	/**
	* Infrastructure not found.
	* 
	* The infrastructure does not exist.
	*/
	const INFRASTRUCTURE_NOT_FOUND=152;


	/**
	* Infrastructure user removal is not allowed.
	* 
	* The infrastructure owner cannot be removed.
	*/
	const INFRASTRUCTURE_USER_REMOVE_NOT_ALLOWED=145;


	/**
	* Infrastructures mixing not allowed.
	* 
	* Elements of one infrastructure cannot be used on another. For example, a LUN created on infrastructure A cannot be attached to a node of infrastructure B.
	*/
	const INFRASTRUCTURES_MIXING_NOT_ALLOWED=110;


	/**
	* Invalid RSA cipher format.
	* 
	* RSA ciphers must be prefixed with the ID of the RSA pair and a slash ("/"). See the temp_key_pair_id property of the object returned by transport_request_public_key().
	*/
	const INVALID_FORMAT_RSA_CIPHER=163;


	/**
	* Empty string password.
	* 
	* Password cannot be an empty string.
	*/
	const INVALID_PASSWORD_EMPTY=164;


	/**
	* Invalid MD5 password.
	* 
	* Some functions require passwords to be a MD5 hash.
	*/
	const INVALID_PASSWORD_MD5=161;


	/**
	* Invalid absolute HTTP URL.
	* 
	* Invalid absolute HTTP URL.
	*/
	const INVALID_URL_HTTP_ABSOLUTE=165;


	/**
	* Invalid user type.
	* 
	* An invalid user type was specified as an object property or function parameter.
	*/
	const INVALID_USER_TYPE=162;


	/**
	* IP address has an invalid format.
	* 
	* An IP address (IPv4 or IPv6) has an invalid format.
	*/
	const IP_ADDRESS_INVALID=153;


	/**
	* IP address not found.
	* 
	* The IP address does not exist.
	*/
	const IP_ADDRESS_NOT_FOUND=166;


	/**
	* IP provision fails because no IP address is available.
	* 
	* The error is thrown during the IP address provision, if the IP address is not in the IPPool's range.
	*/
	const IP_PROVISION_NO_IP_AVAILABLE=83;


	/**
	* IP address reserve failure.
	* 
	* The node network interface and the IP Pool must be on the same network (must have the same network_id property value).
	*/
	const IP_RESERVE_FAILED=19;


	/**
	* IPPool create failure.
	* 
	* If an IPPool is created, but can not find any free subnets from which to allocate IP addresses, this exception is thrown.
	*/
	const IPPOOL_CREATE_FAILED=16;


	/**
	* At least one cluster network interface must be connected to a network.
	* 
	* At least one cluster network interface must be connected to a network.
	*/
	const IPPOOL_DEPLOY_CLUSTER_INTERFACES_DISCONNECTED=159;


	/**
	* IPPool exchausted.
	* 
	* The IPPool has run out of available IP addresses.
	*/
	const IPPOOL_EXHAUSTED=160;


	/**
	* Maxim count of IPPools exceeded.
	* 
	* There is a maximum of one public IPv6 IP pool. IPv6 and IPv4 IP pools cannot be allocated at the moment.
	*/
	const IPPOOL_MAXIMUM_COUNT_EXCEEDED=7;


	/**
	* LUN deploy failed.
	* 
	* The LUN could not be deployed.
	*/
	const LUN_DEPLOY_FAILED=142;


	/**
	* LUN import already cancelled.
	* 
	* The LUN import could not be cancelled as it has already been cancelled.
	*/
	const LUN_IMPORT_ALREADY_CANCELLED=124;


	/**
	* LUN import already finalized.
	* 
	* The LUN import could not be cancelled as it has already been finalized.
	*/
	const LUN_IMPORT_ALREADY_FINALIZED=125;


	/**
	* Flat file size get failed.
	* 
	* The size of the flat file could not be retrieved.
	*/
	const LUN_IMPORT_FLAT_FILE_SIZE_GET_FAILED=131;


	/**
	* Invalid OVA file.
	* 
	* The file MIME does not match the required OVA file MIME. The OVA file must be a tar archive.
	*/
	const LUN_IMPORT_INVALID_OVA=128;


	/**
	* LUN import not cancelled.
	* 
	* The LUN import could not be restarted. Only cancelled LUN imports can be restarted.
	*/
	const LUN_IMPORT_NOT_CANCELLED=126;


	/**
	* OVA file deflation failed.
	* 
	* The OVA file could not be deflated. The OVA file might be broken.
	*/
	const LUN_IMPORT_OVA_DEFLATION_FAILED=130;


	/**
	* OVA temporary deflation directory creation failed.
	* 
	* A temporary directory for the OVA deflation could not be created.
	*/
	const LUN_IMPORT_OVA_DIRECTORY_CREATION_FAILED=129;


	/**
	* OVA MIME get failed.
	* 
	* The OVA file MIME could not be retrieved.
	*/
	const LUN_IMPORT_OVA_MIME_GET_FAILED=127;


	/**
	* LUN is already attached.
	* 
	* A LUN that is already attached to a node does not support the operation "lun_attach_node".
	*/
	const LUN_IS_ATTACHED=144;


	/**
	* LUN is not attached.
	* 
	* A LUN that is not already attached to a node does not support the operation "lun_detach_node".
	*/
	const LUN_IS_NOT_ATTACHED=111;


	/**
	* LUN not active.
	* 
	* For certain operations, LUNs are required to be in active status.
	* For example, lun_edit() can operate only on an active LUN.
	*/
	const LUN_NOT_ACTIVE=80;


	/**
	* LUN size provided for edit is invalid.
	* 
	* LUN size provided for an edit operation is less than the original size of LUN.
	*/
	const LUN_SIZE_INVALID=91;


	/**
	* Only one WAN and SAN network per infrastructure.
	* 
	* An infrastructure can have only one WAN and one SAN network attached to it.
	*/
	const NETWORK_LIMIT_EXCEEDED=154;


	/**
	* Network cannot be deleted.
	* 
	* WAN and SAN networks cannot be deleted from an infrastructure.
	*/
	const NETWORK_NOT_DELETABLE=155;


	/**
	* A node interface is being connected to a network of an invalid type.
	* 
	* A node interface must be connected to:
	*   - a SAN network if its index is 0
	*   - any other type of network if its index is greater than 0.
	*/
	const NODE_INTERFACE_NETWORK_ATTACH_FAILURE=156;


	/**
	* Unknown node measurement type.
	* 
	* The supplied argument for node_measurement_type is invalid. It can only be one of: "CPU", "RAM", "Disk", "NetworkInterfaces", "CustomMeasurementType".
	*/
	const NODE_MEASUREMENT_TYPE_UNKNOWN=171;


	/**
	* Node not active.
	* 
	* For certain operations, nodes are required to be in active status.
	* For example, node_edit() can operate only on an active node.
	*/
	const NODE_NOT_ACTIVE=100;


	/**
	* Cannot get the power status of a server.
	* 
	* The power status of a node's server cannot be determined if the node was never deployed or if the node is still being deployed.
	*/
	const NODE_SERVER_POWER_FAILURE=157;


	/**
	* Authentication failure.
	* 
	* Authentication is required and it failed. Possible reasons include:
	*  - invalid request parameters;
	*  - invalid authentication method;
	*  - incorrect credentials;
	*  - incorrect signature.
	* 
	* This error normally occurs if authentication is required. It may also occur on functions which perform authentication, if called directly.
	*/
	const NOT_AUTHENTICATED=73;


	/**
	* Authorization failure.
	* 
	* Authenticated user failed authorization. Reasons include:
	*  - the called function is not allowed for the authenticated user's type;
	*  - authenticated user does not have access to the operated upon resources.
	*/
	const NOT_AUTHORIZED=71;


	/**
	* A feature is not implemented.
	* 
	* Thrown when a certain feature or capability is not implemented yet, is reserved or is planned.
	*/
	const NOT_IMPLEMENTED=3;


	/**
	* Type of the parameter provided is not as expected.
	* 
	* Type of the parameter provided is not as expected. For example, any ID provided is expected to be an unsigned integer.
	*/
	const PARAM_TYPE_MISMATCH=93;


	/**
	* Value of parameter is invalid.
	* 
	* Some parameters' values require specific formats of input data, or a specific set of allowed values.
	*/
	const PARAM_VALUE_INVALID=143;


	/**
	* Incorrect user password.
	* 
	* Thrown when authentication fails due to incorrect user password.
	*/
	const PASSWORD_INCORRECT=45;


	/**
	* Invalid product edit parameters.
	* 
	* The infrastructure ID of the product (cluster, node, LUN, etc.) cannot be changed.
	* The ID of a product (cluster, node, LUN, etc.) cannot be changed.
	*/
	const PRODUCT_EDIT_INVALID_PARAMETERS=96;


	/**
	* Infrastructure mismatch.
	* 
	* Object property "infrastructure_id" is not the infrastructure of the specified object.
	*/
	const PRODUCT_INFRASTRUCTURE_MISMATCH=140;


	/**
	* Product does not exist.
	* 
	* A requested resource, such as calling "lun_get()", or an object property which points to a resource (for example the "network_id" key on an IPPool object) does not exist.
	*/
	const PRODUCT_NOT_FOUND=103;


	/**
	* Invalid property value.
	* 
	* An object's property value did not pass a validation test.
	*/
	const PROPERTY_IS_INVALID=137;


	/**
	* Mandatory property.
	* 
	* Some object properties are mandatory.
	*/
	const PROPERTY_IS_MANDATORY=135;


	/**
	* Unknown property.
	* 
	* Unknown object properties are sometimes not allowed to help catch caller typos or incorrect calls with objects which have optional properties with defaults.
	*/
	const PROPERTY_IS_UNKNOWN=136;


	/**
	* Read only object property.
	* 
	* Some object property values are not allowed to change. 
	* For example, calling cluster_edit() with a modified infrastructure_id property might issue this error.
	*/
	const PROPERTY_READ_ONLY=138;


	/**
	* An operation cannot take place because the server is powered on.
	* 
	* Some operations (such as unmounting LUNs, expanding LUNs, booting a node on different hardware) require a server to already be powered off before a deploy call.
	* Servers will not automatically be powered off.
	*/
	const SERVER_POWERED_ON=87;


	/**
	* Service status is not valid.
	* 
	* The system only supports the following service statuses that can be used for a product: "ordered", "active", "suspended", "stopped", "deleted".
	*/
	const SERVICE_STATUS_INVALID=95;


	/**
	* SSH key unknown encoding.
	* 
	* SSH keys are expected to be encoded in base64.
	*/
	const SSH_KEY_DATA_INCORRECT_FORMAT=25;


	/**
	* Invalid OpenSSH/SSH2 key.
	* 
	* OpenSSH/SSH2 key data is not valid, taking into consideration  RFC 3447 and  RFC 4716.
	*/
	const SSH_KEY_INVALID_DATA_OPENSSH_SSH2=28;


	/**
	* Invalid PKCS#1 key.
	* 
	* PKCS#1 key data is not valid, taking into account RFC 3447.
	*/
	const SSH_KEY_INVALID_DATA_PKCS1=31;


	/**
	* Invalid PKCS#8 key.
	* 
	* PKCS#8 key data is not valid, taking into account RFC 2459.
	*/
	const SSH_KEY_INVALID_DATA_PKCS8=35;


	/**
	* Unknown SSH key format.
	* 
	* SSH key format is not recognized. The allowed ssh key formats are: OpenSSH, SSH2, PKCS#1, PKCS#8.
	*/
	const SSH_KEY_UNKNOWN_FORMAT=23;


	/**
	* Unknown algorithm identifier prefix for a certain SSH key.
	* 
	* An unknown algorithm identifier prefix is found when  decoding SSH key data. The allowed alogorithm identifiers are: ssh-rsa, ssh-dsa, ssh-dss.
	*/
	const SSH_KEY_UNKWOWN_ALGORITHM_IDENTIFIER=21;


	/**
	* No LUN template with the given ID exists.
	* 
	* A LUN template is searched, but the template does not exist.
	*/
	const STORAGE_LUN_TEMPLATE_NOT_FOUND=68;


	/**
	* Storage pool is not found.
	* 
	* Storage pool cannot be found. This situation can appear in the following context:
	* - given a storage type name, the system could not find any storage pools that have this storage type name as property.
	* - given a storage pool ID, the system could not find any information related to it or the ID provided does not exist.
	*/
	const STORAGE_POOL_NOT_FOUND=64;


	/**
	* Snapshot not found.
	* 
	* Can occur when searching for LUN template snapshots or attempting to retrieve or operate on a specific snapshot.
	*/
	const STORAGE_SNAPSHOT_NOT_FOUND=94;


	/**
	* Invalid timestamp format.
	* 
	* Timestamps must be in a particular ISO 8601 format and in UTC. Example format: "2013-12-31T14:09:12Z".
	*/
	const TIMESTAMP_INVALID=149;


	/**
	* File upload failed.
	* 
	* An error has been encountered while uploading the file.
	*/
	const UPLOAD_FAILED=114;


	/**
	* Upload file creation failed.
	* 
	* A temporary file for the AJAX upload could not be created.
	*/
	const UPLOAD_FILE_CREATION_FAILED=115;


	/**
	* Upload file move failed.
	* 
	* The temporary file for the AJAX upload could not be moved.
	*/
	const UPLOAD_FILE_MOVE_FAILED=118;


	/**
	* Upload file open failed.
	* 
	* The temporary file created for the AJAX upload could not be opened for writing.
	*/
	const UPLOAD_FILE_OPEN_FAILED=117;


	/**
	* Upload stream open failed.
	* 
	* The AJAX upload stream could not be opened for reading.
	*/
	const UPLOAD_STREAM_OPEN_FAILED=116;


	/**
	* User account is disabled.
	* 
	* Some operations are not allowed on a disabled account. Disabled accounts cannot be authenticated and are restricted from some associations or modifications for security reasons.
	*/
	const USER_DISABLED=62;


	/**
	* Verification email rate limit.
	* 
	* Password recovery or login email address verification emails are rate limited to prevent spamming.
	*/
	const USER_EMAIL_LIMIT_REACHED=52;


	/**
	* Duplicate user login emails are not allowed.
	* 
	* The login email must be unique per user account.
	*/
	const USER_LOGIN_EMAIL_ALREADY_EXISTS=57;


	/**
	* User login email is not verified.
	* 
	* For security reasons, some or most operations are not allowed on newly created user accounts with an unverified login email address.
	*/
	const USER_LOGIN_EMAIL_NOT_VERIFIED=46;


	/**
	* User is not associated with the infrastructure.
	* 
	* A user was not associated with the infrastructure provided in infrastructure_remove_user.
	*/
	const USER_NOT_ASSOCIATED_WITH_INFRASTRUCTURE=174;


	/**
	* User not found.
	* 
	* A user was not found for a specified user ID (object property, function parameter, etc).
	*/
	const USER_NOT_FOUND=42;


	/**
	* Duplicate SSH keys are not allowed.
	* 
	* A user cannot have duplicate SSH keys.
	*/
	const USER_SSH_KEY_DUPLICATE=10;


	/**
	* SSH key not found.
	* 
	* A SSH key was not found for a specified SSH key ID (object property, function parameter, etc).
	*/
	const USER_SSH_KEY_NOT_FOUND=6;


	/**
	* User SSH keys maximum count exceeded.
	* 
	* The number of associated SSH keys has a finite maximum.
	*/
	const USER_SSH_KEYS_MAXIMUM_COUNT_EXCEEDED=8;
}
