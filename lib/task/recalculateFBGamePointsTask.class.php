<?php

// Exec: php symfony task:recalculateFBGamePointsTask
class recalculateFBGamePointsTask extends sfBaseTask {
    protected function configure() {
        $this->addArguments(array());
        $this->addOptions(array(new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'), new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'), new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine')));

        $this->namespace = 'task';
        $this->name = 'recalculateFBGamePointsTask';
        $this->briefDescription = 're-calculate user points task';
        $this->detailedDescription = <<<EOF
Re-calculate user points
EOF;
    }

    protected function execute($arguments = array(), $options = array()) {
        $startTime = time();

        // initialize the database connection
        date_default_timezone_set('Europe/Sofia');
        $databaseManager = new sfDatabaseManager($this->configuration);
        $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();
        $connection->setAttribute(Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true);

        gc_enable();

        $gameId = 6;

        $result = Doctrine::getTable('FacebookReviewGameUser')
                ->createQuery('frgu')
                ->where('frgu.facebook_review_game_id = ?', $gameId)
                ->execute();

        foreach ($result as $res) {
            $res->setPoints(0);
            $res->save();
        }


        $result = Doctrine::getTable('FacebookReviewGameUser')
                ->createQuery('frgu')
                ->where('frgu.facebook_review_game_id = ?', $gameId)
                ->addGroupBy('frgu.user_id')
                ->execute();

        foreach ($result as $res) {
            $subResult = Doctrine::getTable('InvitedUser')
                    ->createQuery('iu')
                    ->where('iu.user_id = ?', $res->getUserId())
                    ->addGroupBy('iu.facebook_uid, iu.email')
                    ->execute();

            foreach ($subResult as $subRes) {
                $cnt = 0;

                if ($subRes->getEmail()) {
                    $cnt = Doctrine::getTable('SfGuardUser')
                            ->createQuery('sgu')
                            ->where('sgu.email_address = ?', $subRes->getEmail())
                            ->count();
                }
                elseif ($subRes->getFacebookUid()) {
                    $cnt = Doctrine::getTable('UserProfile')
                            ->createQuery('up')
                            ->where('up.facebook_uid = ?', $subRes->getFacebookUid())
                            ->count();
                }

                if ($cnt) {
                    $points = $res->getPoints();
                    $res->setPoints($points + 1);
                    $res->save();
                }
            }
        }

        gc_collect_cycles();

        echo 'OK';
    }
}