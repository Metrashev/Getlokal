<?php

class importBadgeTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addArguments(array(
    ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'import';
    $this->name             = 'badges';
    $this->briefDescription = 'Import images';
    $this->detailedDescription = <<<EOF
    Import BAC results from edu.ro
    
  [php symfony import:bac]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    date_default_timezone_set('Europe/Bucharest');
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();
    
    $query = "
    SELECT sub_x.user, sub_x.badge_id, SUM(IF(sub_x.group_count >= 1, 1,0)) as requirement_count, sub_x.requirement FROM 
      (SELECT x.*, x.requirements as requirement, x.user_id as user, SUM(IF(x.sum_score >= x.value, 1, 0)) group_count FROM
        (SELECT b.id AS badge_id, us.user_id, b.requirements as requirements, br.group_no AS group_no, br.keyvalue AS value, SUM(us.keyvalue) sum_score FROM user_stat AS us
        INNER JOIN badge_requirement_field brf ON brf.keyname = us.keyname
        INNER JOIN badge_requirement br ON br.id = brf.requirement_id
        INNER JOIN badge b ON b.id = br.badge_id
        LEFT JOIN user_badge ub ON ub.badge_id = b.id
        WHERE ub.id IS NULL
        GROUP BY us.user_id, brf.requirement_id) x
      GROUP BY x.user_id, x.group_no) sub_x
    GROUP BY sub_x.user, sub_x.badge_id
    HAVING sub_x.requirement = requirement_count";
    
    $con = Doctrine::getConnectionByTableName('user_stat');
    $result = $con->execute($query);
    
    while ($row = $result->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
      $badge = new UserBadge();
      $badge->setBadgeId($row['badge_id']);
      $badge->setUserId($row['user']);
      $badge->save();
    }
    
  }
}