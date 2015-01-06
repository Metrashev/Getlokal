<?php

require_once (dirname ( __FILE__ ) . '/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration ( 'frontend', 'dev', true );
sfContext::createInstance ( $configuration );
sfConfig::set ( 'sf_logging_enabled', false );
ini_set ( 'memory_limit', '3500M' );
set_time_limit ( 0 );
ini_set ( 'auto_detect_line_endings', 1 );

//define('REPORT_EMAIL', sfConfig::get('sf_import_report_email'));




GLImport::message ( 'en title import started' );

$connection = GLImport::initDatabaseConnection ( $configuration, 'doctrine' );


GLImport::setEnTitles($connection);


GLImport::message ( 'en title import commited' );