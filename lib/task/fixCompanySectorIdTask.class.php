<?php

class fixCompanySectorIdTask extends sfBaseTask
{
	protected function configure()
	{
		// // add your own arguments here
		// $this->addArguments(array(
		//   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
		// ));

		$this->addOptions(array(
				new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
				new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
				new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
				// add your own options here
		));

		$this->namespace = 'fix';
		$this->name = 'company_sector_id';
		$this->briefDescription = 'fix company sector_id by getting it from company->classification_id';
	}

	protected function execute($arguments = array(), $options = array())
	{
		// initialize the database connection
		$databaseManager = new sfDatabaseManager($this->configuration);
		$connection = $databaseManager->getDatabase($options['connection'])->getConnection();

		// add your code here
		try{
			$data = $connection->query("UPDATE `company` c SET sector_id = (SELECT sector_id FROM classification_sector cs WHERE cs.classification_id = c.classification_id LIMIT 1) WHERE c.sector_id IS NULL")->execute();
			echo PHP_EOL."Done!".PHP_EOL;
		} catch (PDOException $e) {
			print "Error!: " . $e->getMessage() . "<br/>";
			die();
		}
	}
}

