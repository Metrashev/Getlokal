<?php
header("Access-Control-Allow-Origin: *");
require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

ProjectConfiguration::validateIPAddress();
$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', false);
sfContext::createInstance($configuration)->dispatch();
