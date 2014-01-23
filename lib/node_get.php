<?php

require_once("config.php");


if($argc!=2)
	die("Syntax: <node_id>\n");

global $bsi;

$nNodeID=$argv[1];

$objNode=$bsi->node_get($nNodeID);

var_export($objNode);
