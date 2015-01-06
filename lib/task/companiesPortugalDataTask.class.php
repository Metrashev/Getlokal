<?php

class companiesPortugalDataTask extends sfBaseTask
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

    $this->namespace        = 'companies';
    $this->name             = 'PortugalData';
    $this->briefDescription = 'Fixes "NULL" fields to NULL and sets street = full_address';
    $this->detailedDescription = <<<EOF
The [companiesPortugalData|INFO] task does things.
Call it with:

  [php symfony companiesPortugalData|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
    $connection->setAttribute ( Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true );

    echo 'Started portugal data fix.'.PHP_EOL;
    $done = 0;
    $companies = Doctrine_Query::create()
            ->select('c.id')
            ->from('Company c')
            ->where('c.country_id = ?', 180)
            ->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR)
            ->execute();
    
    foreach ($companies as $comp) {
        $c = Doctrine::getTable('Company')->findOneById($comp);
        
        foreach ($c as $field => $el) {
            $functionName = "set".ucfirst($field);
            if ($el === 'NULL') {
                $c->$functionName(NULL);
            }            
        }

        $c->save();

        $cl = Doctrine::getTable('CompanyLocation')->findOneById($c->getLocation_id());

        foreach ($cl as $field => $el) {
            $functionName = "set".ucfirst($field);
            if ($el === 'NULL') {
                $cl->$functionName(NULL);
            }
            if ($field === 'street') {
                $cl->$functionName($cl->getFull_address());
            }
        }

        $cl->save();
        
        echo'Done: '.$comp.PHP_EOL;
        $done++;
    }
    
    echo $done.' companies DONE.'.PHP_EOL;
    
  }
}
