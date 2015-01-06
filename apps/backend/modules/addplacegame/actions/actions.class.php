<?php

require_once dirname(__FILE__).'/../lib/addplacegameGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/addplacegameGeneratorHelper.class.php';

/**
 * addplacegame actions.
 *
 * @package    getLokal
 * @subpackage addplacegame
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class addplacegameActions extends autoAddplacegameActions
{
public function executeFilter(sfWebRequest $request)
  {
    $this->setPage(1);

    if ($request->hasParameter('_reset'))
    {
      $this->setFilters($this->configuration->getFilterDefaults());

      $this->redirect('@user_profile_addplacegame');
    }

    $this->filters = $this->configuration->getFilterForm($this->getFilters());

    $this->filters->bind($request->getParameter($this->filters->getName()));
    if ($this->filters->isValid())
    {
      $this->setFilters($this->filters->getValues());

       if($request->getParameter('csv') == 'true') {
       
      	ini_set('max_execution_time', 6000);
        set_time_limit(0);
        ini_set('memory_limit','1024M');
               $this->getResponse ()->clearHttpHeaders ();
                $this->getResponse ()->setHttpHeader ( 'Pragma-Type', 'public' );
				$this->getResponse ()->setHttpHeader ( 'Expires', '0' );				
				$this->getResponse ()->setHttpHeader ( 'Content-Type', 'application/vnd.ms-excel;charset:UTF-8' );
				$this->getResponse ()->setHttpHeader ( 'Content-Disposition', 'attachment; filename=UserExportGame.xls' );
				$this->getResponse ()->setHttpHeader ( 'Content-Transfer-Encoding', 'binary' );
                $this->setLayout('csv');
            }else
            {
      $this->redirect('@user_profile_addplacegame');
            }
    }

    $this->pager = $this->getPager();
    $this->sort = $this->getSort();

     if($request->getParameter('csv') == 'true') {
     	
        $this->setTemplate('csvList');
              
     } else
     { 
     	 $this->setTemplate('index');
     }
  }
  
protected function buildQuery()
  {
    $tableMethod = $this->configuration->getTableMethod();
    if (null === $this->filters)
    {
      $this->filters = $this->configuration->getFilterForm($this->getFilters());
    }

    $this->filters->setTableMethod($tableMethod);

    $query = $this->filters->buildQuery($this->getFilters());
    $rootAlias = $query->getRootAlias();
    $query->innerJoin($rootAlias.'.Company c1')           
            ->addWhere('c1.created_by is not null');	
    $this->addSortQuery($query);

    $event = $this->dispatcher->filter(new sfEvent($this, 'admin.build_query'), $query);
    $query = $event->getReturnValue();

    return $query;
  }
}
