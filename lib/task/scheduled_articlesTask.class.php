<?php

class scheduled_articlesTask extends sfBaseTask
{
  protected function configure()
  {

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
    ));

    $this->namespace        = 'task';
    $this->name             = 'scheduled_articles';
    $this->briefDescription = 'Cron command to publish scheduled articles (run hourly)';
    $this->detailedDescription = <<<EOF
The [scheduled_articles|INFO] publishes articles scheduled for later publish.
Call it with:

  [php symfony scheduled_articles|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
    $waiting_articles = Doctrine::getTable('Article')->createQuery('a')
        ->where("a.status='publish_on'")
        ->addWhere('a.publish_on <= '.ProjectConfiguration::nowAlt().'')
        ->execute();
    foreach ($waiting_articles as $a) {
        $a->setStatus('approved');
        $a->setCreatedAt($a->getPublishOn());
        $a->save();
        print "published article ".$a->getId() . " by " . $a->getUserProfile()->getName() . "\n";
    }
  }
}
