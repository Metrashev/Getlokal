<?php

require_once dirname ( __FILE__ ) . '/../lib/mail_bgGeneratorConfiguration.class.php';
require_once dirname ( __FILE__ ) . '/../lib/mail_bgGeneratorHelper.class.php';

/**
 * mail_bg actions.
 *
 * @package    getLokal
 * @subpackage mail_bg
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mail_bgActions extends autoMail_bgActions {
	
	public function executeAddCompany(sfWebRequest $request) {
		$this->forward404Unless ( $company = Doctrine::getTable ( 'Company' )->findOneById ( $request->getParameter ( 'id' ) ) );
		
		$new_object = new mailBgCampaign ();
		$new_object->setCompany ( $company );
		$new_object->setCity ( $company->getCity () );
		$new_object->save ();
		$this->getUser ()->setFlash ( 'success', 'New company added' );
		
		$this->redirect ( '@mail_bg_campaign' );
	}
	
	public function executeBatchActivate(sfWebRequest $request) {
		if (! $ids = $request->getParameter ( 'ids' )) {
			$this->getUser ()->setFlash ( 'error', 'You must at least select one item.' );
			
			$this->redirect ( '@mail_bg_campaign' );
		}
		$error = false;
		$city = '';
		foreach ( $ids as $id ) {
			$this->forward404Unless ( $mail_bg_item = Doctrine::getTable ( 'mailBgCampaign' )->find ( $id ) );
			if ($mail_bg_item->getNumberOfActiveItemsInCity () < mailBgCampaign::MAX_ITEMS_PER_CITY) {
				$mail_bg_item->setIsActive ( true );
				$mail_bg_item->save ();
			
			} else {
				$city.=$mail_bg_item->getCity()->getName().', ';
				$error = true;
			}
		
		}
		if (! $error) {
			$this->getUser ()->setFlash ( 'notice', 'The selected companies have been activated in the feed.' );
		} else {
			$this->getUser ()->setFlash ( 'error', 'The selected companies were NOT activated. More than ' . mailBgCampaign::MAX_ITEMS_PER_CITY . ' active companies in feed per city. ' .$city );
		}
		$this->redirect ( '@mail_bg_campaign' );
	}
	
	public function executeBatchDeactivate(sfWebRequest $request) {
		if (! $ids = $request->getParameter ( 'ids' )) {
			$this->getUser ()->setFlash ( 'error', 'You must at least select one item.' );
			
			$this->redirect ( '@mail_bg_campaign' );
		}
		
		foreach ( $ids as $id ) {
			$this->forward404Unless ( $mail_bg_item = Doctrine::getTable ( 'mailBgCampaign' )->find ( $id ) );
			$mail_bg_item->setIsActive ( false );
			$mail_bg_item->save ();
		}
		$this->getUser ()->setFlash ( 'notice', 'The selected companies have been deactivated in the feed.' );
		$this->redirect ( '@mail_bg_campaign' );
	}
	
	public function executeChangeStatus(sfWebRequest $request) {
		$this->mail_bg_item = $this->getRoute ()->getObject ();
		
		if ($this->mail_bg_item->getIsActive () == true) {
			$this->mail_bg_item->setIsActive ( false );
			$this->mail_bg_item->save ();
			$this->getUser ()->setFlash ( 'notice', 'Feed Item Successfully Deactivated' );
		} else {
			if ($this->mail_bg_item->getNumberOfActiveItemsInCity () < mailBgCampaign::MAX_ITEMS_PER_CITY) {
				$this->mail_bg_item->setIsActive ( true );
				$this->mail_bg_item->save ();
				$this->getUser ()->setFlash ( 'notice', 'Feed Item Successfully Activated' );
			} else {
				$this->getUser ()->setFlash ( 'error', 'More than ' . mailBgCampaign::MAX_ITEMS_PER_CITY . ' active companies in feed per city '.$this->mail_bg_item->getCity()->getName().'. Item not activated!' );
			
			}
		}
		
		$this->redirect ( '@mail_bg_campaign' );
	}
  
	public function executeFilter(sfWebRequest $request)
  {
    $this->setPage(1);

    if ($request->hasParameter('_reset'))
    {
      $this->setFilters($this->configuration->getFilterDefaults());

      $this->redirect('@mail_bg_campaign');
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
				$this->getResponse ()->setHttpHeader ( 'Content-Disposition', 'attachment; filename=MailBgFeedExport.xls' );
				$this->getResponse ()->setHttpHeader ( 'Content-Transfer-Encoding', 'binary' );
                $this->setLayout('csv');
            }else
            {
      
      
      $this->redirect('@mail_bg_campaign');
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
	
}
