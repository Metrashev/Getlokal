<?php

class reindexTask extends sfBaseTask
{
  protected function configure()
  {
  	sfConfig::set('sf_debug', false);
    $this->addArguments(array(
    ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'task'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));
 
    $this->namespace        = '';
    $this->name             = 'reindex';
    $this->briefDescription = 'Re score company';
    $this->detailedDescription = <<<EOF
    
    
  [php symfony reindex]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
  
    date_default_timezone_set('Europe/Bucharest');
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();
    $connection->setAttribute(Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true );
 
       
    $query = Doctrine::getTable('Company')
                ->createQuery('c')                
                ->innerJoin('c.Country')
                ->where('c.status = 0');

    $i = 0;
    $count = $query->count();
    
    gc_enable();
    
    while($i< $count)
    {
      $companies = $query
                  ->limit(10)
                  ->offset($i)
                  ->execute();
        
      foreach($companies as $company)
      {
      $score = 1; 
      if ($company->get ( 'phone' )!='')
      {
      	$score += 0.1;

      }
      if ($company->get ( 'description' )!='')
      {
      	$score += 0.1;

      }
      if ($company->get ( 'number_of_reviews' )> 0)
      {
      	$review_score = $company->get ( 'number_of_reviews' )*  0.01;

      	$score +=($review_score > 0.25 ? 0.25 : $review_score);

      }
      if ($company->get ( 'average_rating' )> 0)
      {     

      	$score += $company->get ( 'average_rating' )*  0.05;

      }
      if ($company->getApprovedImages(true) > 0)
      {      	
      		$score += 0.1;
      }
      if ($company->getActivePPPService(true) > 0)
      {      	
      		$score += 0.3;
      }
   
      $company->setScore($score);
      $company->save();
      $company->free ();
	  $company = null;
	  unset ( $company );
/*
 * UPDATE company SET score = 1;
UPDATE company SET score = score + 0.1 WHERE phone > '';
UPDATE company SET score = score + 0.1 WHERE description != '';
UPDATE company SET score = score + IF(number_of_reviews * 0.01 > 0.25, 0.25, number_of_reviews * 0.01) WHERE number_of_reviews > 0;
UPDATE company SET score = score + (average_rating * 0.05) WHERE average_rating > 0;
UPDATE company c SET c.score = c.score + (SELECT IF(COUNT(*) * 0.02 > 0.2, 0.2, COUNT(*) * 0.02) FROM company_image ci INNER JOIN image i ON i.id = ci.image_id AND i.status = 'approved' WHERE ci.company_id = c.id );
UPDATE company SET score = score + if((SELECT 1 FROM ad_service_company WHERE status = 'active' AND active_from < '.ProjectConfiguration::nowAlt().' AND (crm_id IS NOT NULL OR active_to > '.ProjectConfiguration::nowAlt().') AND ad_service_id = 11 AND company_id = company.id GROUP BY company_id) = 1, 0.3, 0);

 */
        $i++;
        $proc = round($i/$count * 100);
    
        fputs(STDOUT, 'Done: '.$i.'/'.$count.str_repeat(' ',13-strlen($i.$count)).'['.str_repeat('#', round($proc / 5)).str_repeat('-', 20 - round($proc /5)).'] '.$proc."% MEM: ".round((memory_get_usage()/1024)/1024, 2)."\n");
        
        fputs(STDOUT, str_repeat(chr(8), 80));
      }
       $companies->free();
       $companies = null;
	   unset ($companies);
       gc_collect_cycles();
     
	 
    }
  }
}