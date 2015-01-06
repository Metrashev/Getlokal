<?php

require_once dirname(__FILE__).'/../lib/companyGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/companyGeneratorHelper.class.php';

/**
 * company actions.
 *
 * @package    getLokal
 * @subpackage company
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class companyActions extends autoCompanyActions
{
  public function executeImages(sfWebRequest $request)
  {
    $this->forward404Unless($this->company = Doctrine::getTable('Company')->find($request->getParameter('id')));
    
    $this->images = Doctrine::getTable('Image')
                      ->createQuery('i')
                      ->innerJoin('i.CompanyImage c')
                      ->where('c.company_id = ?', $this->company->getId())
                      ->execute();
                      
    $this->form = new ImageForm();
    if($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));

      if($this->form->isValid())
      {
        $image = new Image();
        $image->setCaption($this->form->getValue('caption'));
        $image->setFile($this->form->getValue('file'));
        $image->setUserId($this->getUser()->getId());
        $image->save();
        
        $company_image = new CompanyImage();
        $company_image->setCompanyId($this->company->getId());
        $company_image->setImageId($image->getId());
        $company_image->save();
        
        if(!$this->company->getImageId())
        {
          $this->company->setImageId($image->getId());
          $this->company->save();
        }
        
        $this->redirect('company/images?id='. $this->company->getId());
      }
    }
  }
  
  public function executeGetCitiesAutocomplete(sfWebRequest $request) {
		$culture = $this->getUser ()->getCulture ();
		$this->getResponse ()->setContentType ( 'application/json' );
		
		$q = "%" . $request->getParameter ( 'q' ) . "%";
		
		$limit = $request->getParameter ( 'limit', 20 );
		
		// FIXME: use $limit
		$dql = Doctrine_Query::create ()
                        ->from ( 'City c' )
                        ->innerJoin('c.Translation ctr')
                        ->where ( 'ctr.name LIKE ?', $q )
                        ->limit ( $limit );
		$this->rows = $dql->execute();
		$cities = array();

		foreach ( $this->rows as $row ) {
                        $cities [$row ['id']] = $row->getCityNameByCulture().', ' .$row->getCounty()->getName();	
		}
		
		return $this->renderText ( json_encode ( $cities ) );
	
	}
	
  public function executeGetClassifiersAutocomplete(sfWebRequest $request) {
		$culture = $this->getUser ()->getCulture ();
		$this->getResponse ()->setContentType ( 'application/json' );
		
		$q = "%" . $request->getParameter ( 'q' ) . "%";
		
		$limit = $request->getParameter ( 'limit', 20 );
		
		$dql = Doctrine_Query::create ()->select ( 'id, t.title' )->from ( 'Classification c' )->innerJoin ( 'c.Translation t' )->where ( 't.title LIKE ? ', $q )->

		limit ( $limit );

		//echo $dql->getSqlQuery(); exit();
		$this->rows = $dql->execute ();
		$classifiers = array ();
		
		if ($this->rows)
    {
  		foreach ( $this->rows as $row ) {
  			$classifiers [$row ['id']] = $row['title'];
  		
  		}
  	}
		return $this->renderText ( json_encode ( $classifiers ) );
	}

  public function executeShow(sfWebRequest $request)
  {
    $this->company = $this->getRoute()->getObject();
    
  
    $this->setTemplate('show');
  }
  


  public function executePPP(sfWebRequest $request)
  {
    $this->forward404Unless($this->company = Doctrine::getTable('Company')->find($request->getParameter('id')));
    $this->object = new AdServiceCompany ();
		$this->object->setCompanyId ( $this->company->getId () );
		$this->object->setAdServiceId(11);		
			              
    $this->form = new backendOrderForm($this->object);
    if($request->isMethod('post'))
    {
      $params = $request->getParameter ( $this->form->getName () );
	  $this->form->bind ( $params );
     if($this->form->isValid())
      {
      	$this->form->save();
      	$this->getUser ()->setFlash ( 'notice', 'PPP Saved Successfully' );
					
        $this->redirect('company/pPP?id='. $this->company->getId());
      }
    }
  }
  
  public function executeSetStatus(sfWebRequest $request)
  {
  	  $this->forward404Unless($this->company = Doctrine::getTable('Company')->find($request->getParameter('id')));
        $status = $request->getParameter('status'); 
        $this->company->setStatus($status);
        $this->company->save();
        $this->getUser ()->setFlash ( 'notice', ' Saved Successfully' );
		 $this->redirect('@company');
  }
  
  public function executeDeal(sfWebRequest $request)
  {
  $this->forward404Unless($this->company = Doctrine::getTable('Company')->find($request->getParameter('id')));
     $this->object = new AdServiceCompany ();
		$this->object->setCompanyId ( $this->company->getId () );
		$this->object->setAdServiceId(13);		
	
		              
    $this->form = new backendOrderForm($this->object);
    if($request->isMethod('post'))
    {
      $params = $request->getParameter ( $this->form->getName () );
	  $this->form->bind ( $params );
     if($this->form->isValid())
      {
      	$offer = $this->form->save();
      	$activeTo = strtotime('+90 days', strtotime ($offer->getActiveFrom()));
      	$offer->setActiveTo(date("Y-m-d", $activeTo));
      	$offer->save();
      	$this->getUser ()->setFlash ( 'notice', 'PPP Saved Successfully' );
					
        $this->redirect('company/deal?id='. $this->company->getId());
      }
    }
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));
    
 
    if ($this->getRoute()->getObject()->getCompanyPage()){
    if ($this->getRoute()->getObject()->getCompanyPage()->getPageAdmin())
    {
    	foreach ($this->getRoute()->getObject()->getCompanyPage()->getPageAdmin() as $admin)
    	{
    		$admin->delete();
    	}
    }
   
    $this->getRoute()->getObject()->getCompanyPage()->delete();
    }
    if ($this->getRoute()->getObject()->delete())
    {
      $this->getUser()->setFlash('notice', 'The item was deleted successfully.');
    }

    $this->redirect('@company');
  }

  public function executeSecure(sfWebRequest $request)
  {
  }

  public function executeLogout(sfWebRequest $request)
  {
    $this->getUser()->signOut();

    $this->redirect(sfWpAdmin::getProperty('login_route'));
  }

  public function executeFilter(sfWebRequest $request)
  {
    $this->setPage(1);

    if ($request->hasParameter('_reset'))
    {
      $this->setFilters($this->configuration->getFilterDefaults());

      $this->redirect('@company');
    }

    $this->filters = $this->configuration->getFilterForm($this->getFilters());

    $this->filters->bind($request->getParameter($this->filters->getName()));
    if ($this->filters->isValid())
    {
   $this->setFilters($this->filters->getValues());
   if($request->getParameter('csv') == 'true') {
        ini_set('max_execution_time', 20000);
        set_time_limit(0);
        ini_set('memory_limit','2048M');
               $this->getResponse ()->clearHttpHeaders ();
                $this->getResponse ()->setHttpHeader ( 'Pragma-Type', 'public' );
        $this->getResponse ()->setHttpHeader ( 'Expires', '0' );
        $this->getResponse ()->setHttpHeader ( 'Content-Type', 'application/vnd.ms-excel;charset:UTF-8' );
        $this->getResponse ()->setHttpHeader ( 'Content-Disposition', 'attachment; filename=CompanyExport.xls' );
        $this->getResponse ()->setHttpHeader ( 'Content-Transfer-Encoding', 'binary' );
                $this->setLayout('csv');
            }else
            {

      $this->redirect('@company');
            }
    }

    $this->pager = $this->getPager();
    $this->sort = $this->getSort();
   if($request->getParameter('csv') == 'true'){

        $this->setTemplate('csvList');

     } else
     {
       $this->setTemplate('index');
     }

  }

}
