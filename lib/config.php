<?php
define("BASE_PATH", dirname(__FILE__));
set_include_path(
	get_include_path()
	.PATH_SEPARATOR.BASE_PATH
);



require_once("BSI/BSI.php");
require_once("JSONRPC/filters/client/SignatureAdd.php");

define("BSI_ENDPOINT_URL",getenv("BSI_ENDPOINT_URL"));
define("BSI_API_KEY",getenv("BSI_API_KEY"));


$arrBSIKey=split(":", BSI_API_KEY , 2);
$nBillableUserID=$arrBSIKey[0];



if(strlen(BSI_ENDPOINT_URL) == 0)
	throw new Exception("BSI_ENDPOINT_URL constant not set in config.php");

if(strlen(BSI_API_KEY) == 0)
	throw new Exception("BSI_API_KEY constant not set in config.php");

if($nBillableUserID == null)
	throw new Exception("\$nBillableUserID unset, needed for infrastructure_create.");
	

/**
* In order to be able to make API calls, a BSI client object is needed. 
* It can be obtained with the instantiate_new_client($nUserID) function from config.php.
* $nUserID is automatically extracted from API_KEY constant in config.php
*/
$arrUserIDAPIKey = explode(":", BSI_API_KEY, 2);
$nUserID = (int)$arrUserIDAPIKey[0];

$bsi = new BSI(BSI_ENDPOINT_URL);
$objPluginSignatureAdd = new JSONRPC_filter_signature_add(
	BSI_API_KEY, 
	array("user_id" => $nUserID)
);

$bsi->addFilterPlugin($objPluginSignatureAdd);


