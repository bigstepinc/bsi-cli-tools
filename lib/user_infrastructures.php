<?php

require_once("config.php");


global $bsi;
global $nBillableUserID;

$arrInfrastructures=$bsi->user_infrastructures($nBillableUserID);

var_export($arrInfrastructures);
