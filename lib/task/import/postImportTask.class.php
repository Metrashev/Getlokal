<?php

class postImportTask extends importBaseTask
{
	protected $_companiesWithRank = 24;
	
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

    $this->namespace        = 'post';
    $this->name             = 'import';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [clearSerbia|INFO] task does things.
Call it with:

  [php symfony clearSerbia|INFO]
EOF;
    $this->_arCountries = array(
    		'bg' => array('id' => 1, 'slug' => 'bg'),
    		'me' => array('id' => 151, 'slug' => 'me'),
    		'ru' => array('id' => 184, 'slug' => 'ru'),
    		'hu' => array('id' => 104, 'slug' => 'hu'),
    		'fi' => array('id' => 78, 'slug' => 'fi'),
    );
  }

  protected function execute($arguments = array(), $options = array())
  {
        $this->_databaseManager = new sfDatabaseManager($this->configuration);
        $this->_connection = $this->_databaseManager->getDatabase($options['connection'])->getConnection();

        $PROCESS = array(
        		// options for functions '_handleNumberOfPlaces', '_insertFromCompanyIntoPage', '_hanleRatings'
        		'fi' => array( '_handleNumberOfPlaces', '_hanleRatings') // the functions to run for this country
//         		'me' => array( '_handleNumberOfPlaces', '_hanleRatings') // the functions to run for this country
        );
		foreach ($PROCESS as $slug => $functionsTeExecute){
			if(isset($this->_arCountries[$slug])){
				$data = $this->_arCountries[$slug];
				if(sizeof($functionsTeExecute)){
					foreach ($functionsTeExecute as $functionName){
						$this->$functionName($data);
					}
				}
			}
		}
        
  }
  
  protected function _handleNumberOfPlaces($data){
  		$table = 'classification_translation';
  		$sql = "SELECT 
					cc.classification_id, 
					COUNT(company_id) AS numberOfPlaces
				FROM `company_classification` cc
				JOIN company c
				ON c.id=cc.company_id
				WHERE c.country_id={$data['id']}
				GROUP BY cc.classification_id";
  		$classificationCompanies = $this->_connection->prepare($sql);
  		$classificationCompanies->execute();
  		echo "UPDATING `number_of_places` IN  `classification_translation` table FOR: ".strtoupper($data['slug']).PHP_EOL." ...".PHP_EOL;
  		$c = 0;
  		foreach ($classificationCompanies as $cc){
  			$c++;
  			$sql = "UPDATE `classification_translation` SET `number_of_places`='{$cc['numberOfPlaces']}' WHERE `id`='{$cc['classification_id']}' AND `lang`='{$data['slug']}' LIMIT 1";
  			$tableConnection = Doctrine::getConnectionByTableName($table);
	  		$tableConnection->execute($sql);
  		}
  		echo "DONE: $c CALSSIFICATION TRANSLATIONS WERE UPDATED FOR: ".strtoupper($data['slug']).PHP_EOL;
  }
  
  protected function _insertFromCompanyIntoPage($data){
	  	$sql = "SELECT foreign_id FROM `page` WHERE country_id={$data['id']} AND `type`=2";
	  	$pages = $this->_connection->prepare($sql);
	  	$pages->execute();
	  	$arPages = array();
	  	foreach ($pages as $page){
	  		$arPages[$page['foreign_id']] = 1;
	  	}
	  	echo "COMPANIES IN PAGE FOR: ".strtoupper($data['slug'])." - ".sizeof($arPages).PHP_EOL;
	  	
	  	$sql = "SELECT id, created_at, updated_at FROM `company` WHERE country_id={$data['id']}";
	  	$companies = $this->_connection->prepare($sql);
	  	$companies->execute();
	  	$importInPage = array();
	  	$columns = array('foreign_id', 'created_at', 'updated_at', 'type', 'is_public', 'country_id'); 
	  	$table = 'page';
	  	foreach ($companies as $company){
	  		if(!isset($arPages[$company['id']])){
	  			$importInPage[] = array('foreign_id' => $company['id'], 
					  					'created_at' => $company['created_at'], 
					  					'updated_at' => $company['updated_at'], 
	  									'type' => '2',
	  									'is_public' => '1',
					  					'country_id' => $data['id'] );
	  		}
	  	}
	  	echo "COMPANIES TO BE INSERTED IN PAGE - ".sizeof($importInPage).PHP_EOL."....".PHP_EOL;
	  	$count = 0;
	  	if(sizeof($importInPage)){
	  		$queries = $this->_bulkInsert($importInPage, $table, $columns);
	  		foreach ($queries as $sql){
	  			$count += substr_count($sql, ')') - 1;
	  			$tableConnection = Doctrine::getConnectionByTableName($table);
	  			$tableConnection->execute($sql);
	  			break;
	  		}
	  	}
	  	echo "DONE - $count RECORDS INSERTED".PHP_EOL;
  }
  
  protected function _hanleRatings($data){
  		echo "SETTING RATINGS ...".PHP_EOL;
	  	$sql = "SELECT id FROM `sector` s WHERE is_active=1 ORDER BY rank ASC LIMIT 6";
	  	$sectors = $this->_connection->prepare($sql);
	  	$sectors->execute();
	  	foreach ($sectors as $sector){
	  		$companies = Doctrine_Query::create()
	  		->select('c.id')
	  		->from('company c')
	  		->where("average_rating >=3 AND country_id={$data['id']} AND c.sector_id={$sector['id']}")
	  		->fetchArray();
	  		 
	  		$companiesToSetRatingTo = $this->_companiesWithRank - sizeof($companies);
	  		if($companiesToSetRatingTo){
	  			$table = 'company';
	  			$sql = "UPDATE `$table` SET `average_rating`='3.1' WHERE average_rating=0 AND country_id={$data['id']} AND sector_id={$sector['id']} LIMIT $companiesToSetRatingTo";
	  			echo $sql.";".PHP_EOL;
	  			$tableConnection = Doctrine::getConnectionByTableName($table);
				$tableConnection->execute($sql);
	  			
	  		}
	  	}  	  	
	  	echo "DONE: RATING WERE SET".PHP_EOL;
  }
}
