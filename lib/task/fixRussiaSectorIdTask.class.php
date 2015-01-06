<?php

// Exec: php symfony task:newsletterUsersTask
class fixRussiaSectorId extends sfBaseTask {
    protected function configure() {
        $this->addArguments(array());
        $this->addOptions(array(new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'), new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'), new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine')));

        $this->namespace = 'fix';
        $this->name = 'russia_sector_id';
        $this->briefDescription = 'fix company sector_id by getting it from company->classification_id';
    }

    protected function execute($arguments = array(), $options = array()) {
        // initialize the database connection
        $databaseManager = new sfDatabaseManager($this->configuration);
        $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();
        try{
			$data = $connection->query("UPDATE `company` c SET sector_id = (SELECT sector_id FROM classification_sector cs WHERE cs.classification_id = c.classification_id LIMIT 1) WHERE country_id = 184")->execute();
			echo PHP_EOL."Done!".PHP_EOL;
		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}

    }
}
