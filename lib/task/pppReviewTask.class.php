<?php

class pppReviewTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
    ));

    $this->namespace        = 'ppp';
    $this->name             = 'Review';
    $this->briefDescription = 'Sets the latest review to PPP comapnies without review_id.';
    $this->detailedDescription = <<<EOF
The [pppReview|INFO] task does things.
Call it with:

  [php symfony pppReview|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    $query = Doctrine::getTable('Company')
            ->createQuery('c')
            ->innerJoin('c.AdServiceCompany adc WITH adc.ad_service_id = ? ', 11 )
            ->where ('adc.status = "active"')
            ->andWhere ('adc.active_from <= '.ProjectConfiguration::nowAlt().'')
            ->andWhere ('((adc.active_to is null AND adc.crm_id is not null) OR (adc.active_to >= '.ProjectConfiguration::nowAlt().' AND  adc.crm_id is null)) ')
            ->andWhere('c.review_id IS NULL OR c.review_id = ?', '')
            ->execute();

    if ($query->count()) {
        echo $query->count().' PPP companies without review.'.PHP_EOL;
        $done = 0;
        foreach ($query as $company) {
            $review = Doctrine::getTable('Review')
                    ->createQuery('r')
                    ->where('r.company_id = ?', $company->getId())
                    ->orderBy('r.created_at')                   
                    ->fetchOne();

            if ($review) {
                $con = Doctrine::getConnectionByTableName('company');
                $con->execute("UPDATE `company` SET review_id=".$review->getId ()." WHERE id=".$company->getId()." LIMIT 1;");
                $done++;
            }
            else {
                 $skipped[] = $company->getId();
            }
        }
        echo PHP_EOL.$done.' DONE.'.PHP_EOL;
        echo PHP_EOL.'SKIPPED (NO REVIEW):'.PHP_EOL.implode(',', $skipped).PHP_EOL;
    }

  }
}
