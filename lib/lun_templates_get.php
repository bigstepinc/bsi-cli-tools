<?php
/**
* The config.php file is required in order to retrieve user specific data (BSI_API_KEY and BSI_ENDPOINT_URL)
*/
require_once("config.php");




global $bsi;



$arrTemplatesFromPublic=$bsi->lun_templates_public();

var_export($arrTemplatesFromPublic);
