<?php

require_once("config.php");


if($argc!=2)
	die("Syntax: <infrastructure_id>\n");

global $bsi;
global $nBillableUserID;

$nInfrastructureID=(int)$argv[1];

$strStartTimestamp=date("Y-m-d\TH:i:s\Z",strtotime("-1 Month"));
$strEndTimestamp=date("Y-m-d\TH:i:s\Z",strtotime("+1 Month"));

$arrUtilizations=$bsi->resource_utilization_summary($nBillableUserID, $strStartTimestamp, $strEndTimestamp,array($nInfrastructureID));


var_export($arrUtilizations);

