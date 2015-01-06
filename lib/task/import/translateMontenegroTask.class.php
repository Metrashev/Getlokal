<?php

class translateMontenegroTask extends importBaseTask
{	
	protected function configure(){
		
		$this->addOptions(array(
		new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
		new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
		new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine')
		// add your own options here
		));
		$this->addArgument('key', sfCommandArgument::OPTIONAL, 'The module used', false);
		
		$this->namespace        = 'import_translation';
		$this->name             = 'montenegro';
// 		var_dump(sfConfig::get("sf_web_dir"));die;

	}
	
	protected function execute($arguments = array(), $options = array()){
		mb_internal_encoding("UTF-8");
		// initialize the database connection
		$this->_databaseManager = new sfDatabaseManager ( $this->configuration );
        $this->_connection = $this->_databaseManager->getDatabase ( $options ['connection'] ? $options ['connection'] : null )->getConnection ();
       	$opts = $this->getOptions();
       	
       	$available_options = "(category_article|badge|category_events|classification|feature_company|feature|sector)";
         if(!($arguments['key'])){
         	echo PHP_EOL."Missing --key=$available_options".PHP_EOL;
         	return;
         }
        
        switch($arguments['key']){
        	case "category_article": $this->handleCategoryArticle();break;
        	case "badge": $this->handleBadge();break;
        	case "category_events": $this->handleCategoryEvents();break;
        	case "classification": $this->handleClassification();break;
        	case "feature_company": $this->handleFeatureCompany();break;
        	case "feature": $this->handleFeature();break;
        	case "sector": $this->handleSector();break;
        	case "all":{
        		$this->handleCategoryArticle();
        		$this->handleBadge();
        		$this->handleCategoryEvents();
        		$this->handleClassification();
        		$this->handleFeatureCompany();
        		$this->handleFeature();
        		$this->handleSector();
        		break;
        	}
        	default: echo "No such module".PHP_EOL."Available options are $available_options";return;
        }
	}
	
	protected function handleCategoryArticle(){
		$this->addSource           ("category_article","montenegro/category_article_translation_en_me_utf.csv");
		$this->setSourceTable      ("category_article","category_article_translation");
		$this->setSourceColumns    ("category_article",array('id','title','slug','lang'));
		$this->fetchSourceData     ("category_article",importBaseTask::SKIP_FIRST_ROW);
		$this->filterSourceData    ("category_article",$this->getLangFilter("me"));
		$this->mapSourceData       ("category_article",$this->getIsActiveMapper(1));
		$this->mapSourceData("category_article",$this->getCheckSlugMapper());
		
		$cat_query = $this->bulkInsert ("category_article");
		 
		echo $cat_query.PHP_EOL.PHP_EOL.PHP_EOL;
		
		$this->executeSource("category_article");
	}
	
	protected function handleBadge(){
		$this->addSource           ("badge","montenegro/badge_translation_en_me_utf.csv");
        $this->setSourceTable      ("badge","badge_translation");
        $this->setSourceColumns    ("badge",array("id","name","description","lang"));
        $this->fetchSourceData     ("badge",importBaseTask::SKIP_FIRST_ROW);
        $this->filterSourceData    ("badge",$this->getLangFilter("me"));
        $this->mapSourceData       ("badge", function($row){
        	$row['long_description'] = ""; // otherwise NULL is imported
        	return $row;
        });
        $badge_query = $this->bulkInsert ("badge");
        
        echo $badge_query.PHP_EOL.PHP_EOL.PHP_EOL;
        
        $this->executeSource("badge");
	}
	
	protected function handleCategoryEvents(){
		$this->addSource           ("category_events","montenegro/category_events_translation_en_me_utf.csv");
        $this->setSourceTable      ("category_events","category_translation");
        $this->setSourceColumns    ("category_events",array('id','title','slug','lang'));
        $this->fetchSourceData     ("category_events",importBaseTask::SKIP_FIRST_ROW);
        $this->filterSourceData    ("category_events",$this->getLangFilter("me"));
        $this->mapSourceData       ("category_events", $this->getIsActiveMapper(1));
        $this->mapSourceData("category_events",$this->getCheckSlugMapper());
        
        $category_events = $this->bulkInsert ("category_events");
        echo $category_events.PHP_EOL.PHP_EOL.PHP_EOL;
        
        $this->executeSource("category_events");
	}
	
	protected function handleClassification(){
		$this->addSource           ("classification","montenegro/classification_translation_en_me_utf.csv");
        $this->setSourceTable      ("classification","classification_translation");
        $this->setSourceColumns    ("classification",array('id','title','slug','lang'));
        $this->fetchSourceData     ("classification",importBaseTask::SKIP_FIRST_ROW);
        $this->filterSourceData    ("classification",$this->getLangFilter("me"));
        $this->mapSourceData       ("classification", function($row){
        	$row['is_active'] = 0;
        	$row['short_title'] = $row['title'];
        	$row['page_title'] = $row['title'];
        	$row['keywords'] = "";
        	$row['description'] = "";
        	$row['meta_description'] = "";
        	$row['old_slug'] = $row['slug'];
        	//$row['num']
        	return $row;
        });
        $this->mapSourceData("classification",$this->getCheckSlugMapper());
        $classification = $this->bulkInsert ("classification");
        
        echo $classification.PHP_EOL.PHP_EOL.PHP_EOL;
        
        $this->executeSource("classification");
        
	}
	
	protected function handleFeatureCompany(){
		$this->addSource           ("feature_company","montenegro/feature_company_translation_en_me_utf.csv");
        $this->setSourceTable      ("feature_company","feature_company_translation");
        $this->setSourceColumns    ("feature_company",array('id','name','lang'));
        $this->fetchSourceData     ("feature_company",importBaseTask::SKIP_FIRST_ROW);
        $this->filterSourceData    ("feature_company",$this->getLangFilter("me"));
        $this->mapSourceData       ("feature_company", $this->getIsActiveMapper(1));
        $feature_company = $this->bulkInsert ("feature_company");
        
        echo $feature_company.PHP_EOL.PHP_EOL.PHP_EOL;
        
        $this->executeSource("feature_company");
	}
	
	protected function handleFeature(){
		$this->addSource           ("feature","montenegro/feature_translation_utf.csv");
        $this->setSourceTable      ("feature","feature_translation");
        $this->setSourceColumns    ("feature",array('id','name','lang'));
        $this->fetchSourceData     ("feature",importBaseTask::SKIP_FIRST_ROW);
        $this->filterSourceData    ("feature",$this->getLangFilter("me"));
        $this->mapSourceData       ("feature",$this->getIsActiveMapper(1));
        $feature = $this->bulkInsert ("feature");
        
        echo $feature.PHP_EOL.PHP_EOL.PHP_EOL;
        
        $this->executeSource("feature");
	}
	
	protected function handleSector(){
		$this->addSource           ("sector","montenegro/sector_translation_en_me_utf.csv");
        $this->setSourceTable      ("sector","sector_translation");
        $this->setSourceColumns    ("sector",array('id','title','slug','lang'));
        $this->fetchSourceData     ("sector",importBaseTask::SKIP_FIRST_ROW);
        $this->filterSourceData    ("sector",$this->getLangFilter("me"));
        $this->mapSourceData       ("sector", function($row){
        	$row['page_title'] = $row['title'];
        	$con = Doctrine::getConnectionByTableName("sector_translation");
        	$row['rank'] = $con->execute("SELECT rank FROM sector_translation WHERE id = ? AND lang = 'en'",array($row['id']))->fetchColumn();
        	$row['description'] = "";
        	$row['meta_description'] = "";
        	return $row;
        });
        $this->mapSourceData("sector",$this->getCheckSlugMapper());
        $sector = $this->bulkInsert ("sector");
        
        echo $sector.PHP_EOL.PHP_EOL.PHP_EOL;
        
        $this->executeSource("sector");
	}
}