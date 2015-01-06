<?php

// Exec: php symfony task:importCountriesTask 
class importCountriesTask extends sfBaseTask {
    protected function configure() {
        $this->addArguments(array());
        $this->addOptions(array(new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'), new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'), new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine')));

        $this->namespace = 'task';
        $this->name = 'importCountriesTask';
        $this->briefDescription = 'Import new countries task';
        $this->detailedDescription = <<<EOF
Import new countries
EOF;
    }

    protected function execute($arguments = array(), $options = array()) {
        $startTime = time();

        // initialize the database connection
        date_default_timezone_set('Europe/Sofia');
        $databaseManager = new sfDatabaseManager($this->configuration);
        $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();
        $connection->setAttribute(Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true);

        gc_enable();

        $path = sfConfig::get('sf_upload_dir') . '/countries.csv';
        if (file_exists($path)) {
            if (($handle = fopen($path, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $country = new Country;
                    $country->setNameEn($data[0]);
                    $country->setSlug(strtolower($data[1]));
                    $country->save();
                }

                fclose($handle);
            }
        }
        else {
            echo "File: ", $path, ' not found!';
        }

        gc_collect_cycles();
    }
}