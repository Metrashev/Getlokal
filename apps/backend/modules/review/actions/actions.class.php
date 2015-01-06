<?php

require_once dirname(__FILE__).'/../lib/reviewGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/reviewGeneratorHelper.class.php';

/**
 * review actions.
 *
 * @package    getLokal
 * @subpackage review
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reviewActions extends autoReviewActions
{
  public function executeMark(sfWebRequest $request)
  {
    $this->forward404Unless($review = Doctrine::getTable('Review')->find($request->getParameter('id')));

    if($review->recommended_at)
      $review->recommended_at = NULL;
    else
      $review->recommended_at = date('Y-m-d H:i:s');

    $review->save();

    $this->redirect($request->getReferer());
  }


  public function executeBatchApprove(sfWebRequest $request) {
		$ids = $request->getParameter ( 'ids' );
		$culture='bg';
		$records = Doctrine_Query::create()
	      ->from('Review')
	      ->whereIn('id', $ids)
	      ->execute();
		foreach ( $records as $review ) {

			$review->setIsPublished(true);
            $review->save();

		}
		$this->getUser ()->setFlash ( 'notice', 'The selected reviews have been approved successfully.' );

		$this->redirect ( '@review' );
	}

  public function executeBatchDisapprove(sfWebRequest $request) {
		$ids = $request->getParameter ( 'ids' );
		$records = Doctrine_Query::create()
	      ->from('Review')
	      ->whereIn('id', $ids)
	      ->execute();

		foreach ( $records as $review ) {

				$review->setIsPublished(false);
				$review->save();

			$date = date ( 'd.m.y H:m', strtotime ( $review->getCreatedAt () ) );
			$company = $review->getCompany ();

				if ($company->getIsClaimed()) {
					$pageAdmins = Doctrine::getTable('PageAdmin')
				      ->createQuery ( 'p' )
				      ->innerjoin ( 'p.CompanyPage cp' )
				      ->innerjoin ( 'cp.Company c' )
				      ->where('c.id=?', $company->getId() )
				      ->andWhere('p.status = ?', 'approved')
				      ->execute();

				    //$mails[]=array();
				    foreach ($pageAdmins as $pageAdmin){
				    	$mails[$pageAdmin->getUserProfile()->getEmailAddress()]=$pageAdmin->getUserProfile()->getFirstName().' '.$pageAdmin->getUserProfile()->getLastName();


						$message1 = $this->getMailer ()->compose ();
						if ($company->getCountry()->getId()==1){
							$message1->setSubject ( 'Deaktivirano mnenie v GetLokal' );
							$message1->setFrom ( array ('getlokal@getlokal.com' => 'getlokal' ) );
							$mailBody1 = $this->getPartial ( 'mail/review_business_deactivated_mail_for_bg', array ('company' => $company, 'date' => $date, 'pageAdmin' => $pageAdmin ) );
						}elseif ($company->getCountry()->getId()==2){
							$message1->setSubject ( 'Opinia despre '.$company->getDisplayTitle('ro')  .' a fost dezactivată' );
							$message1->setFrom ( array ('romania@getlokal.com' => 'Echipa getlokal.ro' ) );
							$mailBody1 = $this->getPartial ( 'mail/review_business_deactivated_mail_for_ro', array ('company' => $company, 'date' => $date, 'pageAdmin' => $pageAdmin  ) );
					    }

						$message1->setTo ( array ($pageAdmin->getUserProfile()->getEmailAddress() => $pageAdmin->getUserProfile()->getFirstName().' '.$pageAdmin->getUserProfile()->getLastName() ) );
						$message1->setBody ( $mailBody1, 'text/html' );

						$mailSent1 = $this->getMailer ()->send ( $message1 );

						// If mail sending failed,
						if (! $mailSent1) {
							$this->getUser ()->setFlash ( 'error', 'The email was not sent to the RUPA.' );
						} else {
							$this->getUser ()->setFlash ( 'notice', 'The email was sent to the RUPA.' );
						}
				    }
				}

			    $message3 = $this->getMailer ()->compose ();

			    if ($company->getCountry()->getId()==1){
                	$message3->setSubject ( 'Deaktivirano mnenie v GetLokal ' );
                	$message3->setFrom ( array ('getlokal@getlokal.com' => 'getlokal' ) );
                	$mailBody3 = $this->getPartial ( 'mail/review_unnapproved_notification_mail_for_bg', array ('company' => $review->getCompany() ) );
                }elseif ($company->getCountry()->getId()==2){
                	$message->setSubject ('Răspuns dezactivat în getlokal');
					$message->setFrom(array ('romania@getlokal.com' => 'Echipa getlokal.ro'));
					$mailBody = $this->getPartial('mail/answer_unnapproved_notification_mail_for_ro', array ('company' => $company, 'date' => $date));
                }


                $message3->setTo ( array ($review->getUserProfile()->getEmailAddress () ) );

                $message3->setBody ( $mailBody3, 'text/html' );

                $mailSent3 = $this->getMailer ()->send ( $message3 );

                if (! $mailSent3) {
                    $this->getUser ()->setFlash ( 'error', 'The email was not sent to the RU.' );
                } else {
                    $this->getUser ()->setFlash ( 'notice', 'The email was sent to the RU.' );
                }

	}
	$this->redirect ( '@review' );
  }

  public function executeFilter(sfWebRequest $request)
  {
    $this->setPage(1);

    if ($request->hasParameter('_reset'))
    {
      $this->setFilters($this->configuration->getFilterDefaults());

      $this->redirect('@review');
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
				$this->getResponse ()->setHttpHeader ( 'Content-Disposition', 'attachment; filename=ReviewExport.xls' );
				$this->getResponse ()->setHttpHeader ( 'Content-Transfer-Encoding', 'binary' );
                $this->setLayout('csv');
            }else
            {

      $this->redirect('@review');
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
