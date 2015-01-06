<?php
use Doctrine\ORM\EntityManager;

class clearRejectedPlacesTask extends sfBaseTask
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
    $this->name             = 'RejectedPlaces';
    $this->briefDescription = 'Clearing Rejected Places (Companies with status = 4)';
    $this->detailedDescription = <<<EOF
Removing Companies with status = 4
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    $res = Doctrine_Query::create()
        ->select("COUNT(id) as count")
        ->from('Company c')
        ->where('c.status = 4')
    	->fetchArray();
    $count = $res[0]['count'];

    echo "$count elements fount.".PHP_EOL;

    $con = Doctrine::getConnectionByTableName('company');
    $delete = $con->execute("DELETE FROM `company` WHERE status = 4 LIMIT $count;");

  }
}
