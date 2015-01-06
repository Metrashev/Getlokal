<?php

// Exec: php symfony task:newsletterUsersTask
class fixCompanyImages extends sfBaseTask {
    protected function configure() {
        $this->addArguments(array());
        $this->addOptions(array(new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'), new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'), new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine')));

        $this->namespace = 'task';
        $this->name = 'fixCompanyImages';
        $this->briefDescription = 'fix company images bugged when uploading from mobile';
        $this->detailedDescription = <<<EOF
fix newsletter users
EOF;
    }

    protected function execute($arguments = array(), $options = array()) {
        $startTime = time();

        // initialize the database connection
        date_default_timezone_set('Europe/Sofia');
        $databaseManager = new sfDatabaseManager($this->configuration);
        $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();
        $connection->setAttribute(Doctrine_Core::ATTR_AUTO_FREE_QUERY_OBJECTS, true);
        print "fetching bugged places ...\n";
        $companies = Doctrine::getTable('Company')->createQuery('c')
            ->select('c.id', 'ci.image_id')
            ->innerJoin('c.CompanyImage ci')
            ->addWhere('c.image_id IS NULL')
            ->execute();

        foreach ($companies as $company) {
            $company->setImageId($company->getCompanyImage()->getFirst()->getId());
            $company->save();
            print " -- fixed ".$company->getSlug()."\n";
        }


    }
}
