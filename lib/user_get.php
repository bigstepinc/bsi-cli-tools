<?php

require_once("BSI/BSI.php");
require_once("config.php");


if($argc!=2)
	die("Syntax: ".$argv[0]." <user_id>\n");


global $bsi;

$nUserID=$argv[1];



$objUser=$bsi->user_get($nUserID);

var_export($objUser);
