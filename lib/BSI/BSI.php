<?php
require_once("JSONRPC/Client.php");
require_once("BSI/BSIFilter.php");

/**
* JSON-RPC 2.0 client filter plugin.
* Adds authentication and signed request expiration for the JSONRPC ResellerDomainsAPI.
* Also translates thrown exceptions.
*/
class BSI extends JSONRPC_client
{
	public function __construct($strJSONRPCURL)
	{
		parent::__construct($strJSONRPCURL);
		
		$this->addFilterPlugin(new BSIFilter());
	}	

	// 134 134functions available on endpoint. 278

	public function network_create($nInfrastructureID, $objNetwork)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function network_get($nNetworkID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function network_deploy($nNetworkID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function network_delete($nNetworkID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function network_current_operation_cancel($nNetworkID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function node_get($nNodeID, $bShowIPMICredentials=false)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function node_interface_get($nNodeInterfaceID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function node_server_power_get($nNodeID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function node_server_power_set($nNodeID, $strPowerCommand)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function lun_create($nInfrastructureID, $objLun)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function lun_get($nLunID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function lun_edit($nLunID, $objLun)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function lun_current_operation_cancel($nLunID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function lun_deploy($nLunID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function lun_delete($nLunID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function lun_clone($nInfrastructureID, $nLunID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function lun_template_get($nLunTemplateID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function snapshot_create($nLunID, $strSnapshotName)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function snapshot_rollback($nSnapshotID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function lun_snapshots($nLunID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function user_ssh_key_create($nUserID, $strSSHKey)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function user_ssh_key_get($nSSHKeyID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function user_ssh_key_delete($nSSHKeyID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function infrastructure_node_interfaces($nInfrastructureID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function lun_attach_node($nLunID, $nNodeID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function lun_detach_node($nLunID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function lun_templates_public()
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function user_ssh_keys($nUserID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function user_api_key_regenerate($nUserID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function node_luns($nNodeID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function lun_templates_infrastructure($nInfrastructureID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function infrastructure_get($nInfrastructureID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function infrastructure_create($nUserID, $strInfrastructureName, $strInfrastructureDescription, $nUserIDBillable)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function node_interfaces($nNodeID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function node_ips($nNodeID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function node_networks($nNodeID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function ippool_get($nIPPoolID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function ippool_delete($nIPPoolID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function ip_get($nIPAddressID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function ippool_deploy($nIPPoolID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function ippool_ips($nIPPoolID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function user_authenticate_password($strLoginEmail, $strPassword)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function user_authenticate_password_md5($strLoginEmail, $strPassword_MD5)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function user_authenticate_password_encrypted($strLoginEmail, $strAESCipherPassword, $strRSACipherAESKey)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function cluster_create($nInfrastructureID, $objCluster)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function cluster_get($nClusterID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function cluster_edit($nClusterID, $objCluster)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function cluster_current_operation_cancel($nClusterID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function cluster_deploy($nClusterID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function cluster_delete($nClusterID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function infrastructure_deploy($nInfrastructureID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function infrastructure_current_operation_cancel($nInfrastructureID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function cluster_nodes($nClusterID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function infrastructure_selection($nInfrastructureID, $strTable, $objQueryConditions, $strCollapseType='array_subrows')
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function user_selection($nUserID, $strTable, $objQueryConditions, $strCollapseType='array_subrows')
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function user_get($nUserID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function user_password_recovery($strLoginEmail, $strRedirectURL, $strAESKey)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function user_send_verification_email_update_login_email($nUserID, $strLoginEmail, $strRedirectURL, $strAESKey)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function lun_upload_target_url($nInfrastructureID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function lun_upload_max_size($nInfrastructureID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function infrastructure_user_remove($nInfrastructureID, $nUserID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function user_create_md5($strDisplayName, $strLoginEmail, $strPassword_MD5, $strRedirectURL, $strType='admin', $strAESKey=NULL, $strCreateSource='signup')
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function user_update_display_name($nUserID, $strDisplayName)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function user_change_password_md5($nUserID, $strPassword_MD5)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function transport_request_public_key($bGenerateNewIfNotFound=true)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function user_send_verification_email_user_create($strLoginEmail, $strRedirectURL, $strAESKey, $strCreateType='signup')
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function user_email_to_user_id($strLoginEmail)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function infrastructure_summary($nInfrastructureID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function hardware_configurations($nUserID, $arrSearchTypes=array ())
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function network_ippools($nNetworkID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function user_change_password_encrypted($nUserID, $strAESCipherPassword, $strRSACipherAESKey)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function cluster_interface_get($nClusterInterfaceID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function cluster_interfaces($nClusterID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function cluster_networks($nClusterID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function lun_template_create_from_lun($nLunID, $strStorageTypeName=NULL, $strName=NULL, $strDescription=NULL)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function cluster_interface_node_interfaces($nClusterInterfaceID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function node_interface_ips($nNodeInterfaceID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function user_infrastructures($nUserID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function cluster_luns($nClusterID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function cluster_id($nInfrastructureID, $strIDName, $strNewIDName=NULL)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function node_id($nInfrastructureID, $strIDName, $strNewIDName=NULL)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function ippool_create($nInfrastructureID, $objIPPool)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function infrastructure_user_update($nInfrastructureID, $strUserEmail, $objSettings)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function infrastructure_user_ssh_keys($nInfrastructureID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function user_delegate_add($nUserID, $strDelegateUserEmail)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function user_delegate_remove($nUserID, $strDelegateUserEmail, $bRemoveInfrastructurePermissions=false)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function user_delegates($nUserID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function infrastructure_user_add($nInfrastructureID, $strUserEmail, $objSettings=NULL)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function network_cluster_interfaces($nNetworkID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function network_id($nInfrastructureID, $strIDName, $strNewIDName=NULL)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function events_reviewed_set($nInfrastructureID, $arrEventIDs, $bReviewed=true)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function events_reviewed_delete($nInfrastructureID, $strOlderThanTimestamp)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function event_counters($nInfrastructureID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function events_delete($nInfrastructureID, $arrEventIDs)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function clusters($nInfrastructureID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function ippools($nInfrastructureID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function networks($nInfrastructureID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function nodes($nInfrastructureID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function luns($nInfrastructureID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function infrastructure_selection_columns($nInfrastructureID, $strTable)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function user_selection_columns($nUserID, $strTable)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function cluster_rename($nClusterID, $strClusterName)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function network_rename($nNetworkID, $strNetworkName)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function node_rename($nNodeID, $strNodeName)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function lun_rename($nLunID, $strLunName)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function user_delegate_of($nUserID, $arrUserTypes=array ())
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function user_create_encrypted($strDisplayName, $strLoginEmail, $strAESCipherPassword, $strRSACipherAESKey, $strRedirectURL, $strType='admin', $strAESKey=NULL)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function user_create($strDisplayName, $strLoginEmail, $strPassword, $strRedirectURL, $strType='admin', $strAESKey=NULL)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function user_infrastructure_invite_accept($nInfrastructureID, $nUserID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function lun_id($nInfrastructureID, $strIDName, $strNewIDName=NULL)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function ippool_stop($nIPPoolID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function lun_templates($nInfrastructureID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function cluster_stop($nClusterID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function cluster_start($nClusterID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function ippool_id($nInfrastructureID, $strIDName, $strNewIDName=NULL)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function throw_error($nErrorCode)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function network_stop($nNetworkID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function network_start($nNetworkID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function cluster_interface_attach_network($nClusterID, $nClusterInterfaceIndex, $nNetworkID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function resource_utilization_summary($nUserIDBillable, $strStartTimestamp, $strEndTimestamp, $arrInfrastructureIDs=NULL)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function ippool_start($nIPPoolID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function lun_start($nLunID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function lun_stop($nLunID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function ippool_current_operation_cancel($nIPPoolID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function server_get($nServerID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function servers($nInfrastructureID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function infrastructure_query($nInfrastructureID, $strQuery, $strCollapseType='array_subrows')
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function query_parser($strQuery)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function monitoring_measurements_rendering_get($nNodeID, $arrMeasurementIDs, $objRenderingOptions=array ())
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function monitoring_node_measurements_get($nNodeID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function monitoring_measurement_values_get($nNodeMeasurementID)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function cluster_match_servers($nInfrastructureID, $objCluster, $nServerCount)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function lun_template_id_infrastructure($nInfrastructureID, $strIDName, $strNewIDName=NULL)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	public function lun_template_id_public($strIDName)
	{
		return $this->_rpc(__FUNCTION__, func_get_args());
	}

	/*
	* Dynamic function calling functionality disabled!
	*/
	public function __call($strFunctionName, $arrParams)
	{
		throw new JSONRPC_Exception("Method not found!", JSONRPC_Exception::METHOD_NOT_FOUND);	
	}
	


	
	/**
	* Not called AFC queue status.
	*/
	const AFC_STATUS_NOT_CALLED='not_called';
	
	
	/**
	* Successful AFC queue status.
	*/
	const AFC_STATUS_RETURNED_SUCCESS='returned_success';
	
	
	/**
	* Error AFC queue status.
	*/
	const AFC_STATUS_THROWN_ERROR='thrown_error';
	
	
	/**
	* Error while retrying AFC queue status.
	*/
	const AFC_STATUS_THROWN_ERROR_RETRYING='thrown_error_retrying';
	
	
	/**
	* Asynchronous AFC queue.
	*/
	const AFC_TYPE_ASYNCHRONOUS='asynchronous';
	
	
	/**
	* Normal debug AFC queue.
	*/
	const AFC_TYPE_DEBUG_NORMAL='debug_normal';
	
	
	/**
	* Debug RPC server AFC queue.
	*/
	const AFC_TYPE_DEBUG_RPC_SERVER='debug_rpc_server';
	
	
	/**
	* Cluster interface index 1.
	*/
	const CLUSTER_INTERFACE_INDEX_1=1;
	
	
	/**
	* SQLSelection array row span.
	*/
	const COLLAPSE_ARRAY_ROW_SPAN='array_row_span';
	
	
	/**
	* SQLSelection array subrows.
	*/
	const COLLAPSE_ARRAY_SUBROWS='array_subrows';
	
	
	/**
	* SQLSelection array subrows table.
	*/
	const COLLAPSE_ARRAY_SUBROWS_TABLE='array_subrows_table';
	
	
	/**
	* SQLSelection HTML rows array.
	*/
	const COLLAPSE_HTML_ROWS_ARRAY='html_rows_array';
	
	
	/**
	* SQLSelection HTML rows string.
	*/
	const COLLAPSE_HTML_ROWS_STRING='html_rows_string';
	
	
	/**
	* SQLSelection none.
	*/
	const COLLAPSE_NONE='none';
	
	
	/**
	* Not verified DNS domain.
	*/
	const DNS_DOMAIN_NOT_VERIFIED='not_verified';
	
	
	/**
	* Verified DNS domain.
	*/
	const DNS_DOMAIN_VERIFIED='verified';
	
	
	/**
	* Shared DNS server.
	*/
	const DNS_SERVER_SHARED='shared';
	
	
	/**
	* Developer endpoint.
	*/
	const ENDPOINT_DEVELOPER='developer';
	
	
	/**
	* DHCP endpoint.
	*/
	const ENDPOINT_DHCP_URL_PUBLIC='dhcp_url_public';
	
	
	/**
	* Diagram endpoint.
	*/
	const ENDPOINT_DIAGRAM='jsonrpc-2.0-diagram';
	
	
	/**
	* IPC endpoint.
	*/
	const ENDPOINT_IPC='ipc';
	
	
	/**
	* IPC endpoint.
	*/
	const ENDPOINT_IPC_URL_PUBLIC='ipc_url_public';
	
	
	/**
	* JSONRPC endpoint.
	*/
	const ENDPOINT_JSONRPC='jsonrpc-2.0';
	
	
	/**
	* JSONRPC endpoint.
	*/
	const ENDPOINT_JSONRPC_URL='jsonrpc-2.0-url';
	
	
	/**
	* PHPUnit endpoint.
	*/
	const ENDPOINT_PHPUNIT='phpunit';
	
	
	/**
	* Public endpoint.
	*/
	const ENDPOINT_PUBLIC='public';
	
	
	/**
	* Event development environment.
	*/
	const EVENT_ENVIRONMENT_DEVELOPMENT='development';
	
	
	/**
	* Event production environment.
	*/
	const EVENT_ENVIRONMENT_PRODUCTION='production';
	
	
	/**
	* Event quarantine environment.
	*/
	const EVENT_ENVIRONMENT_QUARANTINE='quarantine';
	
	
	/**
	* Debugging event.
	*/
	const EVENT_SEVERITY_DEBUG='debug';
	
	
	/**
	* Important event.
	*/
	const EVENT_SEVERITY_IMPORTANT='important';
	
	
	/**
	* Info event.
	*/
	const EVENT_SEVERITY_INFO='info';
	
	
	/**
	* Success event.
	*/
	const EVENT_SEVERITY_SUCCESS='success';
	
	
	/**
	* Trigger event.
	*/
	const EVENT_SEVERITY_TRIGGER='trigger';
	
	
	/**
	* Warning event.
	*/
	const EVENT_SEVERITY_WARNING='warning';
	
	
	/**
	* Private event.
	*/
	const EVENT_VISIBILITY_PRIVATE='private';
	
	
	/**
	* Public event.
	*/
	const EVENT_VISIBILITY_PUBLIC='public';
	
	
	/**
	* Allow firewall traffic.
	*/
	const FIREWALL_ACTION_ALLOW='allow';
	
	
	/**
	* Block firewall traffic.
	*/
	const FIREWALL_ACTION_BLOCK='block';
	
	
	/**
	* Incoming firewall traffic.
	*/
	const FIREWALL_DIRECTION_INCOMING='incoming';
	
	
	/**
	* Outgoing firewall traffic.
	*/
	const FIREWALL_DIRECTION_OUTGOING='outgoing';
	
	
	/**
	* ICMP echo reply.
	*/
	const FIREWALL_ICMP_TYPE_ECHO_REPLY='echo_reply';
	
	
	/**
	* ICMP echo request.
	*/
	const FIREWALL_ICMP_TYPE_ECHO_REQUEST='echo_request';
	
	
	/**
	* IPv4 firewall.
	*/
	const FIREWALL_IP_TYPE_IPV4='ipv4';
	
	
	/**
	* IPv6 firewall.
	*/
	const FIREWALL_IP_TYPE_IPV6='ipv6';
	
	
	/**
	* All protocols firewall.
	*/
	const FIREWALL_PROTOCOL_ALL='all';
	
	
	/**
	* ICMP firewall.
	*/
	const FIREWALL_PROTOCOL_ICMP='icmp';
	
	
	/**
	* TCP firewall.
	*/
	const FIREWALL_PROTOCOL_TCP='tcp';
	
	
	/**
	* UDP firewall.
	*/
	const FIREWALL_PROTOCOL_UDP='udp';
	
	
	/**
	* Iptables firewall.
	*/
	const FIREWALL_TYPE_IPTABLES='iptables';
	
	
	/**
	* Predefined hardware configurations.
	*/
	const HARDWARE_CONFIGURATIONS_PREDEFINED='predefined';
	
	
	/**
	* User predefined hardware configurations.
	*/
	const HARDWARE_CONFIGURATIONS_USER_PREDEFINED='user_predefined';
	
	
	/**
	* LAN IP pool.
	*/
	const IPPOOL_DESTINATION_LAN='lan';
	
	
	/**
	* OOB IP Pool.
	*/
	const IPPOOL_DESTINATION_OOB='oob';
	
	
	/**
	* SAN IP Pool.
	*/
	const IPPOOL_DESTINATION_SAN='san';
	
	
	/**
	* Temporay IP pool.
	*/
	const IPPOOL_DESTINATION_TMP='tmp';
	
	
	/**
	* WAN IP pool.
	*/
	const IPPOOL_DESTINATION_WAN='wan';
	
	
	/**
	* IPv4 IP pool.
	*/
	const IPPOOL_TYPE_IPV4='ipv4';
	
	
	/**
	* IPv6 IP pool.
	*/
	const IPPOOL_TYPE_IPV6='ipv6';
	
	
	/**
	* Crescendo firewall.
	*/
	const LOAD_BALANCER_CRESCENDO='crescendo';
	
	
	/**
	* HAProxy load balancer.
	*/
	const LOAD_BALANCER_HAPROXY='haproxy';
	
	
	/**
	* LAN network.
	*/
	const NETWORK_TYPE_LAN='lan';
	
	
	/**
	* SAN network.
	*/
	const NETWORK_TYPE_SAN='san';
	
	
	/**
	* WAN network.
	*/
	const NETWORK_TYPE_WAN='wan';
	
	
	/**
	* Clone operation.
	*/
	const OPERATION_TYPE_CLONE='clone';
	
	
	/**
	* Create operation.
	*/
	const OPERATION_TYPE_CREATE='create';
	
	
	/**
	* Delete operation.
	*/
	const OPERATION_TYPE_DELETE='delete';
	
	
	/**
	* Edit operation.
	*/
	const OPERATION_TYPE_EDIT='edit';
	
	
	/**
	* Start operation.
	*/
	const OPERATION_TYPE_START='start';
	
	
	/**
	* Stop operation.
	*/
	const OPERATION_TYPE_STOP='stop';
	
	
	/**
	* Finished provision status.
	*/
	const PROVISION_STATUS_FINISHED='finished';
	
	
	/**
	* Not started provision status.
	*/
	const PROVISION_STATUS_NOT_STARTED='not_started';
	
	
	/**
	* Ongoing provision status.
	*/
	const PROVISION_STATUS_ONGOING='ongoing';
	
	
	/**
	* Demand resource utilization.
	*/
	const RESOURCE_UTILIZATION_TYPE_DEMAND='demand';
	
	
	/**
	* Reserve resource utilization.
	*/
	const RESOURCE_UTILIZATION_TYPE_RESERVATION='reservation';
	
	
	/**
	* Server edit type complete.
	*/
	const SERVER_EDIT_TYPE_COMPLETE='complete';
	
	
	/**
	* Server edit type IPMI.
	*/
	const SERVER_EDIT_TYPE_IPMI='ipmi';
	
	
	/**
	* Server powered off.
	*/
	const SERVER_POWER_STATUS_OFF='off';
	
	
	/**
	* Server powered on.
	*/
	const SERVER_POWER_STATUS_ON='on';
	
	
	/**
	* Server power reset.
	*/
	const SERVER_POWER_STATUS_RESET='reset';
	
	
	/**
	* Server power status soft.
	*/
	const SERVER_POWER_STATUS_SOFT='soft';
	
	
	/**
	* Server power status unknown.
	*/
	const SERVER_POWER_STATUS_UNKNOWN='unknown';
	
	
	/**
	* Available server.
	*/
	const SERVER_STATUS_AVAILABLE='available';
	
	
	/**
	* Server is registering or will be registering.
	*/
	const SERVER_STATUS_REGISTERING='registering';
	
	
	/**
	* Not available server.
	*/
	const SERVER_STATUS_UNAVAILABLE='unavailable';
	
	
	/**
	* Used server.
	*/
	const SERVER_STATUS_USED='used';
	
	
	/**
	* Active service status.
	*/
	const SERVICE_STATUS_ACTIVE='active';
	
	
	/**
	* Deleted service status.
	*/
	const SERVICE_STATUS_DELETED='deleted';
	
	
	/**
	* Ordered service status.
	*/
	const SERVICE_STATUS_ORDERED='ordered';
	
	
	/**
	* Stopped service status.
	*/
	const SERVICE_STATUS_STOPPED='stopped';
	
	
	/**
	* Suspended service status.
	*/
	const SERVICE_STATUS_SUSPENDED='suspended';
	
	
	/**
	* DSA algorithm.
	*/
	const SSH_DSA_ALGORITHM_IDENTIFIER='ssh-dsa';
	
	
	/**
	* DSS algorithm.
	*/
	const SSH_DSS_ALGORITHM_IDENTIFIER='ssh-dss';
	
	
	/**
	* OpenSSH SSH key.
	*/
	const SSH_KEY_FORMAT_OPENSSH='openssh';
	
	
	/**
	* PKCS1 SSH key.
	*/
	const SSH_KEY_FORMAT_PKCS1='pkcs#1';
	
	
	/**
	* PKCS8 SSH key.
	*/
	const SSH_KEY_FORMAT_PKCS8='pkcs#8';
	
	
	/**
	* SSH2 SSH key.
	*/
	const SSH_KEY_FORMAT_SSH2='ssh2';
	
	
	/**
	* RSA algorithm.
	*/
	const SSH_RSA_ALGORITHM_IDENTIFIER='ssh-rsa';
	
	
	/**
	* Dummy driver storage type.
	*/
	const STORAGE_TYPE_DUMMY_DRIVER='dummy_driver';
	
	
	/**
	* Nexenta_Standard_1 storage type.
	*/
	const STORAGE_TYPE_NEXENTA_STANDARD_1='nexenta_standard_1';
	
	
	/**
	* Not verified user e-mail address.
	*/
	const USER_LOGIN_EMAIL_STATUS_NOT_VERIFIED='not_verified';
	
	
	/**
	* Verified user e-mail address.
	*/
	const USER_LOGIN_EMAIL_STATUS_VERIFIED='verified';
	
	
	/**
	* Admin user.
	*/
	const USER_TYPE_ADMIN='admin';
	
	
	/**
	* Billable user.
	*/
	const USER_TYPE_BILLABLE='billable';
	
}
