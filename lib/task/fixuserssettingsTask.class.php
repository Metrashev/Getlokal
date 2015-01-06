<?php

class fixuserssettingsTask extends sfBaseTask
{
  protected function configure()
  {

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      
    ));

    $this->namespace        = 'task';
    $this->name             = 'fix-users-settings';
    $this->briefDescription = 'Fixes missing users settings, inclusing allowing newsletter.';
    $this->detailedDescription = <<<EOF
The [fix-users-settings|INFO] fixes missing settings from users, including newsletter bug.
Call it with:

  [php symfony fix-users-settings|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
    $q = $connection->prepare('SELECT u.id FROM sf_guard_user u 
        LEFT JOIN user_setting us ON u.id=us.id
        LEFT JOIN user_profile up ON u.id=up.id
        WHERE u.is_active=1 AND us.id IS NULL AND up.id IS NOT NULL');
    
    $q->execute();
    $results = $q->fetchAll();

    $total = count($results);
    $displayed = array();
    $i = 0;
    foreach ($results as $k => $r) {
        $i++;
        $percent = floor(($i / $total)*100);
        if (!in_array($percent, $displayed)) {
            $displayed[] = $percent;
            echo "{$percent}%\n";
        }
        $id = $r['id'];
        if ($id) {
            $sett = new UserSetting();
            $sett->setId($id);
            $sett->save();
        }
    }
    echo "... done :) {$total} users fixed";
  }
}
