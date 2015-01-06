<?php

class ClearBulgariaTask extends sfBaseTask
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

    $this->namespace        = 'clear';
    $this->name             = 'Bulgaria';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [countyClear|INFO] task does things.
Call it with:

  [php symfony countyClear|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    echo "County clear Bulgaria".PHP_EOL;
    
    $wrongs = Doctrine_Query::create()
        ->select('co.id, c.id, count(c.id) as cnt')
        ->from('County co')
        ->leftJoin('co.City c')
        ->where('co.country_id = 1')
        ->andWhere('co.id > 70')
        ->groupBy('co.id')
        ->setHydrationMode(Doctrine::HYDRATE_SCALAR)
        ->execute();
    
    foreach ($wrongs as $w) {
        if ($w['c_cnt'] == 0) {
            $con = Doctrine::getConnectionByTableName('county');
            $con->execute("DELETE FROM `county` WHERE id=".$w['co_id'].";");
            
            echo "DELETED   ".$w['co_id'].PHP_EOL;
        }
    }
    // add your code here
  }
}
