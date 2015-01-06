<?php

// Exec: php symfony task:reuserstatTask
class ReuserstatTask extends sfBaseTask {
    protected function configure() {
        $this->addArguments(array());
        $this->addOptions(array(new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'), new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'), new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine')));

        $this->namespace = 'task';
        $this->name = 'reuserstatTask';
        $this->briefDescription = 're-user stat task';
        $this->detailedDescription = <<<EOF
Override user statisctics for all users
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

        echo "Events_category...\n\r";
        // Override events from UserStat
        $query = Doctrine::getTable('Event')
                ->createQuery('e')
                ->select('COUNT(e.id) as cnt, e.category_id as catid, e.user_id as uid')
                //->where('e.user_id IS NOT NULL')
                ->groupBy('e.category_id, e.user_id');

        $userStats = $query->execute();
        foreach ($userStats as $userStat) {
            echo ".";
                $query = Doctrine::getTable('UserStat')
                        ->createQuery('us')
                        ->where('user_id = ?', array($userStat->getUid()))
                        ->addWhere("keyname = 'event_category_" . $userStat->getCatid() . "'");
                $userSt = $query->execute();

                if (!$userSt || !count($userSt)) {
                    echo "+";
                    $userSt = new UserStat();
                    $userSt->setUserId($userStat->getUid());
                    $userSt->setKeyname('event_category_' . $userStat->getCatid());
                    $userSt->setKeyvalue($userStat->getCnt());
                    $userSt->save();
                }
        }
        echo "Events_category: done \n\r";

        echo "Events...\n\r";
        // All cnt
        $query = Doctrine::getTable('Event')
                ->createQuery('e')
                ->select('COUNT(e.id) as cnt, e.user_id as uid')
                //->where('e.user_id IS NOT NULL')
                ->groupBy('e.user_id');

        $userStats = $query->execute();
        foreach ($userStats as $userStat) {
            echo ".";
            $query = Doctrine::getTable('UserStat')
                    ->createQuery('us')
                    ->where('user_id = ?', array($userStat->getUid()))
                    ->addWhere("keyname = 'events'");
            $userSt = $query->execute();

            if (!$userSt || !count($userSt)) {
                echo "+";
                $userSt = new UserStat();
                $userSt->setUserId($userStat->getUid());
                $userSt->setKeyname('events');
                $userSt->setKeyvalue($userStat->getCnt());
                $userSt->save();
            }
        }

        echo "Events: done \n\r";


        echo "Photo_classifications...\n\r";
        // Override photos from UserStat
        $photo_classifications = Doctrine::getTable('CompanyImage')
                ->createQuery('r')
                ->select('count(i.id) as cnt, c.classification_id as clsid, i.user_id as uid, r.id')
                ->innerJoin('r.Company c')
                ->innerJoin('r.Image i')
                ->groupBy('c.classification_id, i.user_id');

        $userStats = $photo_classifications->execute();
        
        foreach ($userStats as $userStat) {
                echo ".";
                $query = Doctrine::getTable('UserStat')
                        ->createQuery('us')
                        ->where('user_id = ?', array($userStat->getUid()))
                        ->addWhere("keyname = 'photo_classification_" . $userStat->getClsid() . "'");
                $userSt = $query->execute();

                if (!$userSt || !count($userSt)) {
                    echo "+";
                    $userSt = new UserStat();
                    $userSt->setUserId($userStat->getUid());
                    $userSt->setKeyname('photo_classification_' . $userStat->getClsid());
                    $userSt->setKeyvalue($userStat->getCnt());
                    $userSt->save();
                }
        }
        
        echo "Photo_classifications: done\n\r";
        

        echo "Photo_sectors...\n\r";
        $photo_sectors = Doctrine::getTable('CompanyImage')
                ->createQuery('r')
                ->select('count(i.id) as cnt, c.sector_id as clsid, i.user_id as uid, r.id')
                ->innerJoin('r.Company c')
                ->innerJoin('r.Image i')
                ->groupBy('c.sector_id, i.user_id');

        $userStats = $photo_sectors->execute();
        foreach ($userStats as $userStat) {
                echo ".";
                $query = Doctrine::getTable('UserStat')
                        ->createQuery('us')
                        ->where('user_id = ?', array($userStat->getUid()))
                        ->addWhere("keyname = 'photo_sector_" . $userStat->getClsid() . "'");
                $userSt = $query->execute();

                if (!$userSt || !count($userSt)) {
                    echo "+";
                    $userSt = new UserStat();
                    $userSt->setUserId($userStat->getUid());
                    $userSt->setKeyname('photo_sector_' . $userStat->getClsid());
                    $userSt->setKeyvalue($userStat->getCnt());
                    $userSt->save();
                }
        }
        echo "Photo_sectors: done\n\r";
        

        echo "Photos: \n\r";
        $photos = Doctrine::getTable('Image')
            ->createQuery('i')
            ->select('count(i.id) as cnt, i.user_id as uid')
/*            ->leftJoin("i.UserProfile as up")
            ->leftJoin("up.UserStat us")
            ->where('us.keyname != ?', array("photos"))
 */
            ->groupBy('i.user_id');

        /*
         * SELECT i.id AS i__id, i.user_id AS i__1, COUNT(i.id) AS i__0,
            FROM image i 
            LEFT JOIN user_profile u ON i.user_id = u.id 
            LEFT JOIN user_stat u2 ON u.id = u2.user_id 
            WHERE (u2.keyname != 'photos') GROUP BY i.user_id
            echo $photos->getSqlQuery();
            exit;
        */

        $userStats = $photos->execute();
        foreach ($userStats as $userStat) {
                echo ".";
                $query = Doctrine::getTable('UserStat')
                        ->createQuery('us')
                        ->where('user_id = ?', array($userStat->getUid()))
                        ->addWhere("keyname = 'photos'");
                $userSt = $query->execute();

                if (!$userSt || !count($userSt)) {
                    echo "+";
                    $userSt = new UserStat();
                    $userSt->setUserId($userStat->getUid());
                    $userSt->setKeyname('photos');
                    $userSt->setKeyvalue($userStat->getCnt());
                    $userSt->save();
                }
        }
        echo "Photos: done\n\r";

        gc_collect_cycles();

        $endTime = time();
        $datediff = ($startTime - $endTime);

        echo 'Days: ', round($datediff / 86400), '  ', 'Hours: ', round($datediff / 3600), '  ', 'Minutes: ', round($datediff / 60), '  ', 'Seconds:', $datediff;
    }
}