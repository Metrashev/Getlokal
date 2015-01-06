<?php

class goodImagesTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addArguments(array(
    ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'frontend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      new sfCommandOption('start', null, sfCommandOption::PARAMETER_OPTIONAL, 'Start from possition', 0),
      // add your own options here
    ));

    $this->namespace        = 'images';
    $this->name             = 'list';
    $this->briefDescription = 'Images list';
    $this->detailedDescription = <<<EOF
    
  [php symfony images:list]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    date_default_timezone_set('Europe/Bucharest');
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'] ? $options['connection'] : null)->getConnection();

    $query = Doctrine::getTable('Image')
                ->createQuery('i');

    $i = $options['start'];
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
        
        echo $image->getFile()->getDiskPath()."\n";
        
        /* $proc = round($i/$count * 100);
    
        fputs(STDOUT, 'Done: '.$i.'/'.$count.str_repeat(' ',13-strlen($i.$count)).'['.str_repeat('#', round($proc / 5)).str_repeat('-', 20 - round($proc /5)).'] '.$proc."%\n");
        
        fputs(STDOUT, str_repeat(chr(8), 80)); */
      }
      
      unset($images);
      
      gc_collect_cycles();
    }
  }
}