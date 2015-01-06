<?php

// Пусни всички сезонните баджове (is_seasonal = 1) преди да изпълниш заявката, след изпълнение на заявката - махни сезонните
// Exec: php symfony task:rebadgesTask
// Пусни всички сезонните баджове (is_seasonal = 1) преди да изпълниш заявката, след изпълнение на заявката - махни сезонните
class RebadgesTask extends sfBaseTask {
    protected function configure() {
        $this->addArguments(array());
        $this->addOptions(array(new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'), new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'), new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine')));

        $this->namespace = 'task';
        $this->name = 'rebadgesTask';
        $this->briefDescription = 'rebadges task';
        $this->detailedDescription = <<<EOF
Re-badges all users
EOF;
    }

    protected function execute($arguments = array(), $options = array()) {
        $startTime = time();

        // initialize the database connection
        date_default_timezone_set('Europe/Sofia');
        $databaseManager = new sfDatabaseManager($this->configuration);
        $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();
        $connection->setAttribute(Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true);


        // Remove all not seasonal badges
        $query = Doctrine::getTable('UserBadge')->createQuery('ub')
                ->leftJoin('ub.Badge as b')
                //->where('ub.user_id = ?', array('43976'))
                //->andWhere('b.is_seasonal != 1');
                ->where('b.is_seasonal != 1');

        $userBadges = $query->execute();
        foreach ($userBadges as $userBadge) {
            $userBadge->delete();
        }

        echo "Removed all not seasonal badges \n\r";


        //Get all user statics
        $query = Doctrine::getTable('UserStat')->createQuery('us')
                ->addOrderBy('us.user_id');
                //->addWhere('user_id = 43976');
        $userStats = $query->execute();

        gc_enable();
        $con = Doctrine::getConnectionByTableName('UserBadge');
        foreach ($userStats as $stat) {
            $user_id = $stat->getUserId();

            echo 'User id: ' . $user_id . "\n\r";

            //if ($stat->getUserId() == '43976') {
                $result = $con->execute("
                SELECT us.user_id, us.keyname, us.keyvalue as current_value, br.badge_id as badge_id, br.keyvalue as max_value
                FROM user_stat as us
                INNER JOIN badge_requirement_field as brf on (us.keyname = brf.keyname)
                INNER JOIN badge_requirement as br on (brf.requirement_id = br.id)
                LEFT JOIN badge as b on (br.badge_id = b.id)
                LEFT JOIN user_badge as ub on (br.badge_id = ub.badge_id AND ub.user_id = us.user_id)
                WHERE us.user_id = ? /*AND b.is_active = 1 <- ALL BADGES*/ AND us.keyvalue >= br.keyvalue 
                    AND b.is_seasonal != 1 
                    AND b.id NOT IN (SELECT ubb.badge_id FROM user_badge ubb WHERE ubb.user_id = ?)
                GROUP BY b.id
                ", array($user_id, $user_id));

                $potentialBadges = $result->fetchAll();

                foreach ($potentialBadges as $pBadge) {
                    $query = Doctrine::getTable('BadgeRequirementField')->createQuery('brf')
                            ->leftJoin('brf.BadgeRequirement br')
                            ->leftJoin('br.Badge b')
                            ->where('b.id = ?', array($pBadge['badge_id']));

                    $badgeRequirements = $query->execute();

                    $requirements = array();
                    $joins = array();
                    $cnt = 0;
                    foreach ($badgeRequirements as $bRequirement) {
                        $logic = '';

                        if ($bRequirement->getBadgeRequirement()->getGroupNo() == 1) {
                            $logic = ' AND ';
                        } else {
                            $logic = ' OR ';
                        }

                        if (!$cnt) {
                            $logic .= '(';
                        }

                        if (!$cnt) {
                            $requirements[] = $logic . "(us.keyname = '" . $bRequirement->getKey() . "' AND us.keyvalue >= " .
                                    $bRequirement->getBadgeRequirement()->getValue() . ")";
                        }
                        else
                        {
                            $joins[] = "LEFT JOIN user_stat as us{$cnt} ON (us.user_id = us{$cnt}.user_id)";

                            $requirements[] = $logic . "(us{$cnt}.keyname = '" . $bRequirement->getKey() . "' AND us{$cnt}.keyvalue >= " .
                                    $bRequirement->getBadgeRequirement()->getValue() . ")";
                        }

                        $cnt++;
                    }

                    $queryRequirements = implode('', $requirements) . ')';

                    $queryJoins = implode(' ', $joins);

                    $result = $con->execute("
                        SELECT us.id
                        FROM user_stat as us
                        {$queryJoins}
                        WHERE us.user_id = {$user_id} {$queryRequirements}
                        GROUP BY us.keyname;
                    ");

                    $result = $result->fetchAll();
                    if (count($result)) {
                        $badge = new UserBadge();
                        $badge->setBadgeId($pBadge['badge_id']);
                        $badge->setUserId($user_id);
                        $badge->save();
                    }
                }
            //}
        }

        gc_collect_cycles();

        $endTime = time();
        $datediff = ($startTime - $endTime);

        echo 'Days: ', round($datediff / 86400), '  ', 'Hours: ', round($datediff / 3600), '  ', 'Minutes: ', round($datediff / 60), '  ', 'Seconds:', $datediff;
    }
}