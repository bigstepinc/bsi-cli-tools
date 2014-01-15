<?php

require_once("config.php");

if($argc!=2)
	die("Syntax:  <public_ssh_key>\n");

$strSSHKey=$argv[1];

global $bsi;

$objReturned=$bsi->user_ssh_key_create($nBillableUserID,$strSSHKey);

var_export($objReturned);
