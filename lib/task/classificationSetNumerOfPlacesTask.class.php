<?php

class classificationSetNumerOfPlacesTask extends sfBaseTask
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

    $this->namespace        = 'classification';
    $this->name             = 'SetNumerOfPlaces';
    $this->briefDescription = 'Sets numer_of_places';
    $this->detailedDescription = <<<EOF
Sets numer_of_places in classification_translation table
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
	die('asdsada');
 	// initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $databaseManager->getDatabase($options['connection'])->getConnection();
   
    $countriesData = array(
    		array('countryId' => 151, 'countrySlug' => 'me'),
    );    
    foreach($countriesData as $country){
    	$query = "SELECT
					cc.classification_id,
					COUNT(cc.id) AS numberOfPlaces
				FROM `company` c
				JOIN `company_classification` cc
				ON cc.company_id=c.id
				WHERE country_id={$country['countryId']}
				GROUP BY cc.classification_id";    	
    	$ccNumberOfPlaces = $this->_connection->prepare($sql);
    	$ccNumberOfPlaces->execute();
    	foreach ($ccNumberOfPlaces as $cc){
    		$query = "UPDATE classification_translation SET number_of_places='{$cc->numberOfPlaces}' WHERE id='{$cc['classification_id']}' AND lang='{$country['lang']}' LIMIT 1";
    		echo $query."<br />";
    	}
    }
  }
  
  
}
