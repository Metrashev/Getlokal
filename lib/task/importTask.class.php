<?php

class importTask extends sfBaseTask
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
    $this->name             = 'images';
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

    $query = Doctrine::getTable('Image')
                ->createQuery('i');

    $i = 0;
    $count = $query->count();
    
    gc_enable();
    
    while($i< $count)
    {
      $images = $query
                  ->limit(1000)
                  ->offset($i)
                  ->execute();
                  
      foreach($images as $image)
      {
        $i++;
        if(is_readable($image->getFile()->getDiskPath()))
        {
          continue;
        }
        
        if($image->getType() == 'user')
          $path = '/Gluster/uploads/people/'. $image->getFilename();
        elseif($image->getType() == 'event')
          $path = '/Gluster/uploads/event/'. $image->getFilename();
        else
        {
          $company = Doctrine::getTable('Company')
                      ->createQuery('c')
                      ->innerJoin('c.CompanyImage ci')
                      ->where('ci.image_id = ?', $image->getId())
                      ->fetchOne();
          if($company->getCountryId() == 2)
            $path = '/Gluster/uploads/company/'. $image->getFilename();
          else
            $path = '/Gluster/uploads/company_ro/'. $image->getFilename();
        }
          
        
        $temp = sfConfig::get('sf_upload_dir'). '/temp.jpg';
        if(!$content = file_get_contents($path)) continue;
        file_put_contents($temp, $content);
        
        $file = new sfValidatedFile($image->getFilename(), filetype($temp), $temp, filesize($temp));
        $image->setFile($file);
        $image->save();

        $proc = round($i/$count * 100);
    
        fputs(STDOUT, 'Done: '.$i.'/'.$count.str_repeat(' ',13-strlen($i.$count)).'['.str_repeat('#', round($proc / 5)).str_repeat('-', 20 - round($proc /5)).'] '.$proc."%\n");
        
        fputs(STDOUT, str_repeat(chr(8), 80));
      }
      
      gc_collect_cycles();
    }
  }
}