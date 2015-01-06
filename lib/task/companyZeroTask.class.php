<?php

class companyZeroTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'company';
    $this->name             = 'Zero';
    $this->briefDescription = 'Fixes companies with zero coordinates.';
    $this->detailedDescription = <<<EOF
The [companyZero|INFO] task does things.
Call it with:

  [php symfony companyZero|INFO]
EOF;
  }

  public function getC() {
      $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
    $connection->setAttribute ( Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true );
    
    return $connection;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
    $connection->setAttribute ( Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true );
    
    echo PHP_EOL.'Fixing companies with 0 lat and 0 long.'.PHP_EOL;
    
    $i = 0;    
    $con = Doctrine::getConnectionByTableName('company_location');    
    
    $cnt = Doctrine_Query::create()
            ->select('c.id')
            ->from('Company c')
            ->innerJoin('c.CompanyLocation cl')
            ->innerJoin('c.City ci')
            ->where('cl.latitude = 0 AND cl.longitude = 0  AND ci.lat != 0 AND ci.lng != 0 AND ci.lat IS NOT NULL AND ci.lng IS NOT NULL')
            ->count();
    
    echo PHP_EOL.$cnt.' Company Locations to be DONE.'.PHP_EOL;
    sleep(2);
    
    $file = sfConfig::get('sf_config_dir').'/databases.yml';
    $config = file_exists($file) ? sfYaml::load($file) : array();
    
    $db = isset($config['all']['doctrine']['param']) ? $config['all']['doctrine']['param'] : array();
    
    $tmp = explode (';', $db['dsn']);
    $server = explode('=', $tmp[0]);
    $server = $server[1];
    $database = explode('=', $tmp[1]);
    $database = $database[1];
    
    //$connection = mysql_connect($server, $db['username'], $db['password'], $database, null, null);
    $connection = mysql_connect($server, $db['username'], $db['password']);
    $dbConnect = mysql_select_db($database, $connection);
    
    $query = 'SELECT cl.id AS locationId, ci.lat AS cityLatitude, ci.lng AS cityLongitude
          FROM company AS c
          INNER JOIN company_location AS cl ON c.id = cl.company_id
          INNER JOIN city AS ci ON c.city_id = ci.id
          WHERE cl.latitude = 0 AND cl.longitude = 0 AND ci.lat != 0 AND ci.lng != 0 AND ci.lat IS NOT NULL AND ci.lng IS NOT NULL';
    
    if (!$result = mysql_query($query)) {
        die (mysql_error());
    }
    
    $data = array();
    $count = 0;
    
    while ($row = mysql_fetch_assoc($result)) {
        $data = array(
            'id' => $row['locationId'],
            'lat' => $row['cityLatitude'],
            'lng' => $row['cityLongitude']
            );
        
        if ($data['id']) {
            $con->execute("UPDATE `company_location` SET latitude='".$data['lat']."',longitude='".$data['lng']."' WHERE id='".$data['id']."';");
            $i++;
        }
        
        if ($i % 1000 == 0) {
            echo $i.' x 1000  done.'.PHP_EOL;
        }
    }

    echo PHP_EOL.$i.'  Done!'.PHP_EOL; 

  }
}
