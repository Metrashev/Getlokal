<?php

class updateGeoIpCountriesTask extends sfBaseTask
{
    protected function configure()
    {
        mb_internal_encoding("UTF-8");
        $this->addArguments(array());

        $this->addOptions(array (
            new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
            new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
            new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'))
        );

        $this->namespace = 'update';
        $this->name = 'geo_ip';
        $this->briefDescription = 'Update the Country IP database';
        $this->detailedDescription = <<<EOF
[php symfony update:geo-ip] 
EOF;
    }

    protected function execute($arguments = array(), $options = array())
    {
        $databaseManager = new sfDatabaseManager ( $this->configuration );
        $connection = $databaseManager->getDatabase ( $options ['connection'] ? $options ['connection'] : null )->getConnection ();
        $connection->setAttribute ( Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true );

        
        set_time_limit(0); 
        $file = file_get_contents('http://worlddatapro.googlecode.com/files/GeoIPCountryWhois.csv');

        if(!@$file){
            set_time_limit(0); 
                $file_content = file_get_contents('http://www.maxmind.com/download/geoip/database/GeoIPCountryCSV.zip');
                file_put_contents(sfConfig::get('sf_web_dir') . '/geo_ip_files/GeoIPCountryCSV.zip', $file_content);
                $zip_file = sfConfig::get('sf_web_dir') . '/geo_ip_files/GeoIPCountryCSV.zip';
                $zipArchive = new ZipArchive();
                $result = $zipArchive->open($zip_file);
                if($result === TRUE){
                        $zipArchive->extractTo(sfConfig::get('sf_web_dir') . '/geo_ip_files');
                        $zipArchive->close();
                }
                else{
                        echo 'Zip Result Error';
                }
        }
        else{
            file_put_contents(sfConfig::get('sf_web_dir') . '/geo_ip_files/GeoIPCountryWhois.csv', $file);
        }
        
        echo PHP_EOL;
        echo 'File downloaded';
        
        
        
        $table_sql = 'DROP TABLE IF EXISTS `geoip_countries`;
                    CREATE TABLE IF NOT EXISTS `geoip_countries` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `ip_from` varchar(128) NOT NULL,
                      `ip_to` varchar(128) NOT NULL,
                      `integer_from` int(11) NOT NULL,
                      `integer_to` int(11) NOT NULL,
                      `country_slugs` varchar(10) NOT NULL,
                      `country_names` varchar(255) NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB  DEFAULT CHARSET=utf8;';

        echo PHP_EOL;
        echo 'Table Dropped';
        echo PHP_EOL;
        echo 'Table Created';
        echo PHP_EOL;
        $con = Doctrine::getConnectionByTableName('geoip_countries');
        $con->execute($table_sql);
        
        //$new_values = 'INSERT INTO geoip_countries(id, ip_from, ip_to, integer_from, integer_to, country_slugs, country_names) VALUES ';
        
        echo 'Insert Values...';
        echo PHP_EOL;
        
        $i=0;
        $counter_data = count(file(sfConfig::get('sf_web_dir') . '/geo_ip_files/GeoIPCountryWhois.csv'));
        
        $new_values = 'INSERT INTO geoip_countries(ip_from, ip_to, integer_from, integer_to, country_slugs, country_names) VALUES ';

        if (($handle = fopen(sfConfig::get('sf_web_dir') . '/geo_ip_files/GeoIPCountryWhois.csv', 'r')) !== FALSE) {
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $i++;
                    if($i%1000 == 0){
			$new_values = trim($new_values, ',').';';
			$con = Doctrine::getConnectionByTableName('geoip_countries');
		        $con->execute($new_values);
			$new_values = 'INSERT INTO geoip_countries(ip_from, ip_to, integer_from, integer_to, country_slugs, country_names) VALUES ';
                    }
                    
                    $ip_from = $data[0];
                    $ip_to = $data[1];
                    $long_from = $data[2];
                    $long_to = $data[3];
                    $country_slugs = $data[4];
                    $country_names = $data[5];
                    if($i == $counter_data){
                        $new_values .= '( "'.$ip_from.'", "'.$ip_to.'", '.$long_from.', '.$long_to.', "'.$country_slugs.'", "'.$country_names.'");';
                    }
                    else{
                        $new_values .= '( "'.$ip_from.'", "'.$ip_to.'", '.$long_from.', '.$long_to.', "'.$country_slugs.'", "'.$country_names.'"),';
                    }
		}
		fclose($handle);
	}

        $new_values = str_replace(',INSERT', ';INSERT', $new_values);
        
        $con = Doctrine::getConnectionByTableName('geoip_countries');
        $con->execute($new_values);
        
        echo $i.' Rows Inserted';

    }
}
