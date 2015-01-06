<?php

/**
 * offer actions.
 *
 * @package    getLokal
 * @subpackage offer
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class offerActions extends sfActions {

  public function executeIndex(sfWebRequest $request) 
  {
    $country_id = $this->getUser()->getCountry()->getId();
    $culture = sfContext::getInstance()->getUser()->getCulture();
    //$city_id = CompanyOfferTable::checkCity($request);
    $city_id = $request->getParameter('city_id', null);
    $cityName = $request->getParameter('city', null);
    
    $sector_id = $request->getParameter('sector_id', null);
    $sectorSlug = $request->getParameter('slug', null);
    
    $page = $request->getParameter('page', 1);
    $page = is_numeric($page) ? $page : 1;
    
    $this->order = $request->getParameter('order', null);

    if(is_null($city_id) && $cityName != null) {        
    	$query1 = Doctrine::getTable('City')
    	->createQuery('c')
        ->innerJoin('c.Translation ctr')
        ->select('c.id, ctr.name')
    	->where('c.slug = ?', $cityName);    	
    	$city = $query1->fetchOne();    	
    	if(!$city) {
    		$city = Doctrine::getTable('Country')
    		->createQuery('cou')
    		->select('cou.id, cou.name_en')
    		->where('cou.name_en = ?', $cityName)
    		->fetchOne();    		
    		if(!$city) {
    			$this->forward404Unless($city, 'City not found');
    		}
    	}else{ 
    		$city_id = $city->getId();
    	}
    }    
     
    if(is_null($sector_id) && $sectorSlug != null) {
    	$query2 = Doctrine::getTable('SectorSlugLog')
    	->createQuery('sec')
    	->select('sec.id, sec.old_slug')
    	->where('sec.lang = ?', $culture)
    	->andWhere('sec.old_slug = ?', $sectorSlug);
    
    	$sector = $query2->fetchOne();
    
    	if(!$sector) {
    		$sector = Doctrine::getTable('SectorSlugLog')
    		->createQuery('sec')
    		->innerJoin('sec.Sector s')
    		->innerJoin('s.Translation t')
    		->andWhere('t.slug = ?', $sectorSlug)
    		->andWhere('sec.lang = ?', $culture)
    		->fetchOne();    		
    		$this->forward404Unless($sector, 'Sector not found');    
    		$this->redirect('offerCitySector', array('sf_culture' => $culture, //redirect to the new  sector slug url
    				'city' => $request->getParameter('city', null),
    				'slug' => $sector->getOldSlug()
    		), 301);
    	}    
    	$sector_id = $sector->getSectorId();
    }

    $choices = CompanyOfferTable::getChoices($country_id, $city_id, $sector_id, $culture);
    $this->form = new CompanyOfferFilterFormFrontend(array(), array('choices' => $choices, 'orderDefault' => $this->order));
    $this->form->setDefault('city_id', $choices['defaults']['city']);
    $this->form->setDefault('sector_id', $choices['defaults']['sector']);

    $query = CompanyOfferTable::getOnlyActiveOffersQuery($city_id, $country_id, $sector_id, $this->order);
    $this->pager = new sfDoctrinePager('CompanyOffer', 12);
    $this->pager->setPage($page);
    $this->pager->setQuery($query);
    $this->pager->init();
    
    $isAjax = $request->getParameter('is_ajax', 0);
	if($isAjax){
		$html = $this->getPartial('offersList',array('pager'=>$this->pager));
		echo $html;
		die;
		return sfView::NONE;
	}
    
    $this->getResponse()->setTitle('Offers');
    breadCrumb::getInstance()->removeRoot();
   
   	$this->choices = $choices;
  }

    public function executeShow(sfWebRequest $request)
    {
    	$this->json_post=false;
    	// if ($request->getParameter ( 'jsp' ) ) {
    	// 	$this->setTemplate('reload');
    	// }
        $this->company_offer = Doctrine_Core::getTable('CompanyOffer')
            ->find($request->getParameter('id'));

        ///Redirection if company offer id does not exit

        if(!$this->company_offer)
        {
            $this->redirect('offer/index', 404);
        }

        $this->user = $this->getUser()->getGuardUser();
        $this->offersLeft = ($this->company_offer->getMaxPerUser() - $this->company_offer->getVouchersPerOffer($this->user, true));
        $this->forward404Unless($this->company_offer,
            sprintf('Object company_offer does not exist (%s).', $request->getParameter('id')));
        $this->isPreview = $request->getParameter('preview', false);
        if (
            !$this->company_offer->IsActive() && $this->isPreview &&
            !($this->getUser()->getPageAdminUser() || $this->getUser()->isGetlokalAdmin())
        ) {
            // redirect to companySettings login to preview offer
            $this->redirect('companySettings/login');
        }

        $this->getResponse()->setTitle($this->company_offer->getTitle());
        $this->form = new sfGuardFormSignin();
        breadCrumb::getInstance()->removeRoot();


         //Expired deals - 301 redirect to Deals Index page for the domain

        if( !$this->company_offer->IsActive() && !$this->isPreview && !$this->company_offer->ActiveSevenDays()){
            $this->redirect('offer/index', 301);
        }

    }

  public function executeNew(sfWebRequest $request) {

    $this->is_getlokal_admin = (($this->getUser ()->getGuardUser () && in_array ( $this->getUser ()->getGuardUser ()->getId (), sfConfig::get ( 'app_getlokal_power_user', array () ) )) ? true : false);

    if (! $this->getUser ()->getPageAdminUser () && ! $this->is_getlokal_admin) {
      $this->redirect ( 'companySettings/login' );
    }

    if (! $this->is_getlokal_admin) {
      $this->adminuser = $this->getUser ()->getPageAdminUser ();
      $this->user = $this->adminuser->getUserProfile ()->getsfGuardUser ();
      $query = Doctrine::getTable ( 'Company' )->createQuery ( 'c' )->innerJoin ( 'c.CompanyPage p' )->innerJoin ( 'p.PageAdmin a' )->where ( 'a.user_id = ?', $this->user->getId () )->andWhere ( 'a.status = ?', 'approved' )->andWhere ( 'c.slug = ?', $request->getParameter ( 'slug' ) );

      $this->company = $query->fetchOne ();

      $this->forwardUnless ( $this->company, 'companySettings', 'noAccess' );
      $this->company->setUser ( $this->getUser () );
    } else {
      $this->adminuser = null;
      $this->user = $this->getUser ()->getGuardUser ();
      $this->company = Doctrine::getTable ( 'Company' )->findOneBySlug ( $request->getParameter ( 'slug' ) );

    }

    $ad_service_product = $this->company->getActiveDealServiceAvailable () ? $this->company->getActiveDealServiceAvailable () : $this->company->getRegisteredDealService ();
    if ($ad_service_product) {
      $this->deal = new CompanyOffer ();
      if ($ad_service_product->getStatus () == 'paid') {
        $this->deal->setIsActive ( true );
      }
      $this->deal->setAdServiceCompanyId ( $ad_service_product->getId () );
      $this->deal->setCompanyId ( $this->company->getId () );
      $this->form = new CompanyOfferForm ( $this->deal );
      
      if ($request->isMethod ( 'POST' )) {
      	//$this->form->getErrorSchema()->addError(new sfValidatorError("file", "max_size"));
      	if(myTools::isExceedingMaxPhpSize()){
      		$this->form->getErrorSchema()->addError(new sfValidatorError($this->form->getValidator("file"), "max_size"));
      	}else{
        	$this->processForm ( $request, $this->form );
      	}
        
      }

    } else {
      $this->getUser ()->setFlash ( 'error', 'No product ordered' );
    }

    if (!$this->is_getlokal_admin){
      $q = Doctrine::getTable ( 'Company' )
      ->createQuery ( 'c' )
      ->innerJoin ( 'c.CompanyPage p' )
      ->innerJoin ( 'p.PageAdmin a' )
      ->where ( 'a.user_id = ?', $this->user->getId () )
      ->andWhere ( 'a.status = ?', 'approved' );
      $this->companies = $q->execute ();

    }else {
      $this->companies =array();
    }

    $this->getResponse ()->setSlot ( 'sub_module', 'offer' );
    $this->getResponse ()->setSlot ( 'sub_module_parameters', array ('companies' => $this->companies, 'company' => $this->company, 'adminuser' => $this->adminuser ) );
    $this->getResponse ()->setTitle ( 'New Offer' );
  }

    public function executeEdit(sfWebRequest $request) {
        $this->company_offer = CompanyOfferTable::getInstance()->find($request->getParameter('id'));
        $this->forward404Unless($this->company_offer,
            sprintf('Object company_offer does not exist (%s).', $request->getParameter('id')));
        $this->is_getlokal_admin = $this->getUser()->isGetlokalAdmin();

        if (!$this->getUser()->getPageAdminUser() && !$this->is_getlokal_admin) {
            $this->redirect('companySettings/login');
        }

        if (!$this->is_getlokal_admin) {
            $this->adminuser = $this->getUser()->getPageAdminUser();
            $this->user = $this->adminuser->getUserProfile()->getsfGuardUser();

            $query = Doctrine::getTable('Company' )->createQuery('c')
                ->innerJoin('c.CompanyPage p')
                ->innerJoin('p.PageAdmin a')
                ->where('a.user_id = ?', $this->user->getId())
                ->andWhere('a.status = ?', 'approved')
                ->andWhere('c.id = ?', $this->company_offer->getCompany()->getId());

            $this->company = $query->fetchOne();
        } else {
            $this->adminuser = null;
            $this->user = $this->getUser()->getGuardUser();

            $this->company = Doctrine::getTable('Company')->findOneById(
                $this->company_offer->getCompanyId());
        }
        $this->forwardUnless($this->company, 'companySettings', 'noAccess');
        $this->company->setUser($this->getUser());

        if ($this->company_offer->canEdit() || $this->is_getlokal_admin) {
            $this->active = ($request->getParameter('active', false) ? true : false);
            if ($this->active) {
                $this->company_offer->setIsActive(true);
            }
            $this->form = new CompanyOfferForm($this->company_offer);
        } else {
            $this->form = new CompanyOfferEditForm($this->company_offer);
        }

        if ($request->isMethod('POST')) {
            $this->processForm($request, $this->form);
        }

        if (!$this->is_getlokal_admin) {
            $q = Doctrine::getTable('Company')
                ->createQuery('c')
                ->innerJoin('c.CompanyPage p')
                ->innerJoin('p.PageAdmin a')
                ->where('a.user_id = ?', $this->user->getId())
                ->andWhere('a.status = ?', 'approved');
            $this->companies = $q->execute();
        } else {
            $this->companies =array();
        }

        $this->getResponse()->setSlot('sub_module', 'offer');
        $this->getResponse()->setSlot('sub_module_parameters', array(
            'companies' => $this->companies,
            'company' => $this->company,
            'offer' => $this->company_offer,
            'adminuser' => $this->adminuser
        ));
        $this->getResponse()->setTitle($this->company_offer->getTitle());
    }

    public function executeDelete(sfWebRequest $request) {
        $this->company_offer = CompanyOfferTable::getInstance()
            ->find($request->getParameter('id'));
        $this->forward404Unless(
            $this->company_offer,
            sprintf('Object company_offer does not exist (%s).', $request->getParameter('id'))
        );

        if (!$this->getUser()->getPageAdminUser()) {
            $this->redirect('companySettings/login');
        }

        $this->adminuser = $this->getUser()->getPageAdminUser();
        $this->user = $this->adminuser->getUserProfile()->getsfGuardUser();

        $query = Doctrine::getTable('Company')->createQuery('c')
            ->innerJoin('c.CompanyPage p')
            ->innerJoin('p.PageAdmin a')
            ->where('a.user_id = ?', $this->user->getId())
            ->andWhere('a.status = ?', 'approved')
            ->andWhere('c.id = ?', $this->company_offer->getCompany()->getId());

        $this->company = $query->fetchOne();

        $this->forwardUnless($this->company, 'companySettings', 'noAccess');
        $this->company->setUser($this->getUser());

        if ($this->company_offer->canDelete()) {
            $ad_service = $this->company_offer->getAdServiceCompany();

            $ad_service->setDealStartDate(null);
            $con = Doctrine::getConnectionByTableName('AdServiceCompany');

            try {
                $con->beginTransaction();

                $ad_service->save();
                $this->company_offer->delete();

                $con->commit();
            } catch(Exception $e) {
                $con->rollback();
                $this->getUser()->setFlash('error', 'We were unable to delete your deal.');
                return sfView::SUCCESS;
            }
        } else {
            $this->getUser()->setFlash('error',
                'This deal is active and cannot be deleted. You can delete offers with no vouchers issued.');
        }
        $this->redirect('companySettings/offers?slug=' . $this->company->getSlug());
    }

  public function executeDeactivate(sfWebRequest $request) {

    $this->forward404Unless($this->company_offer = Doctrine_Core::getTable ( 'CompanyOffer' )->find ( array ($request->getParameter ( 'id' ) ) ), sprintf ( 'Object company_offer does not exist (%s).', $request->getParameter ( 'id' ) ) );
    $is_getlokal_admin = (($this->getUser ()->getGuardUser () && in_array ( $this->getUser ()->getGuardUser ()->getId (), sfConfig::get ( 'app_getlokal_power_user', array () ) )) ? true : false);

    if (! $this->getUser ()->getPageAdminUser () && ! $is_getlokal_admin) {
      $this->redirect ( 'companySettings/login' );
    }

    if (! $is_getlokal_admin) {
      $this->adminuser = $this->getUser ()->getPageAdminUser ();
      $this->user = $this->adminuser->getUserProfile ()->getsfGuardUser ();

      $query = Doctrine::getTable ( 'Company' )->createQuery ( 'c' )->innerJoin ( 'c.CompanyPage p' )->innerJoin ( 'p.PageAdmin a' )->where ( 'a.user_id = ?', $this->user->getId () )->andWhere ( 'a.status = ?', 'approved' )->andWhere ( 'c.id = ?', $this->company_offer->getCompany ()->getId () );

      $this->company = $query->fetchOne ();
    } else {
      $this->adminuser = null;
      $this->user = $this->getUser ()->getGuardUser ();

      $this->company = Doctrine::getTable ( 'Company' )->findOneById ( $this->company_offer->getCompanyId () );

    }
    $this->forwardUnless ( $this->company, 'companySettings', 'noAccess' );
    $this->company->setUser ( $this->getUser () );
    $this->company_offer->setIsActive ( 0 );
    $this->company_offer->save ();
    $this->getUser ()->setFlash ( 'notice', 'The offer was deactivated successfully.' );

    $this->redirect ( 'companySettings/offers?slug=' . $this->company->getSlug () );
  }

   protected function processForm(sfWebRequest $request, sfForm $form)
    {
        $params = $request->getParameter($form->getName(), array());
        $files = $request->getFiles($form->getName());
        
        if ($form->isNew()) {
            $params['country_id'] = $this->company->getCity()->getCounty()->getCountryId();
            $params['code'] = mb_convert_case(substr(uniqid(md5(rand ()), true), 0, 8), MB_CASE_UPPER, "UTF-8");
            $params['created_by'] = $this->user->getId();
        } else {
            $params['updated_by'] = $this->user->getId();
        }

        
        $files=$request->getFiles($form->getName());
        $temp_dir = sfConfig::get ( 'sf_web_dir' ) .'/images/offers';
        if(!is_dir($temp_dir)){
            mkdir($temp_dir, '0777');
        }
        if($files['file']['tmp_name']){
            $image = new Image();

            $x1 = $this->getRequestParameter ( 'x1' );
            $y1 = $this->getRequestParameter ( 'y1' );
            $x2 = $this->getRequestParameter ( 'x2' );
            $y2 = $this->getRequestParameter ( 'y2' );
            $width = $this->getRequestParameter ( 'width' );
            $height = $this->getRequestParameter ( 'height' );

            $ext = pathinfo($files['file']['name'], PATHINFO_EXTENSION);

            $new_name = substr ( uniqid ( md5 ( rand () . date ( 'Y-m-d h:i:s' ) ), true ), 0, 8 );

            $img = new ImageManipulator ( $files['file']['tmp_name']);

            $img->cropOfferImage($x1, $y1, $x2, $y2);

            $file = $new_name.'.'.$ext;

            $img->save($temp_dir.$file);


            $files['file']['tmp_name']=$temp_dir.$file;
            $files['file']['size']=filesize($files['file']['tmp_name']);
            $files['file']['name']= $file;
        }
        $form->bind($params, $files);

        $isDraft = (bool) $request->getParameter('draft', false);
        if ($form->isValid()) {
            $company_offer = $form->save();
            //var_dump($form->getValue('file'));  exit();
            if ($isDraft) {
                $company_offer->setIsDraft(1);
            } else {
                $company_offer->setIsDraft(0);
            }

             if ((isset($params['file_delete']) && $company_offer->getImageId()) || 
                 ($company_offer->getImageId() && $form->getValue('file'))){
                 
                $offer_image = Doctrine_Core::getTable('Image')
                        ->findbyId($company_offer->getImageId());
                
                $theImage = Doctrine::getTable('Image')
                        ->createQuery('im')
                        ->Where('im.id = ?', $company_offer->getImageId())
                        ->fetchOne();


                $deleteOfferImage = Doctrine_Query::create()
                        ->delete()
                        ->from('Image')
                        ->Where('id = ?', $company_offer->getImageId())
                        ->execute();


                $company_offer->setImageId(null);
                
            }

            if ($form->getValue('file')) {
                if ($form->isNew() || !$company_offer->getImageId()) {
                    $image = new Image();
                } else {
                    $offer_image = Doctrine_Core::getTable('Image')
                        ->findbyId($company_offer->getImageId());
                    $image = new Image($offer_image);
                }
                
                $image->setFile($form->getValue('file'));
                $image->setUserId($this->user->getId());
                $image->save();

                unlink($temp_dir.$files['file']['name']);
                
                $company_offer->setImageId($image->getId());
                $this->getUser()->setFlash('notice', 'The offer was added successfully.');
            }
  
            if ($company_offer->isModified()) {
                $company_offer->save();
            }

            $redirect = 'companySettings/offers?slug=' . $this->company->getSlug();
            if ($isDraft) {
                $redirect .= '&drafts=1';
            }
            $this->redirect($redirect);
        }

        $this->getUser()->setFlash('newerror', 'The offer was not saved. Please fill in all mandatory fields.');
    }

  protected function clearInputAndJsCall($string)
  {
    $pattern = '@<\s*input\s+type="hidden"\s+id="gwProxy"\s*>.+?<\s*/\s*div\s*>@is';
    $stringa = preg_replace ( $pattern, "", $string );
    return $stringa;
  }

  public function executeOrderVoucher(sfWebRequest $request) {
    $this->forward404Unless ( $this->company_offer = Doctrine_Core::getTable ( 'CompanyOffer' )->find ( array ($request->getParameter ( 'id' ) ) ), sprintf ( 'Object company_offer does not exist (%s).', $request->getParameter ( 'id' ) ) );
    $this->user = $this->getUser ()->getGuardUser ();

    if (!$this->user) {
        $this->getUser()->setAttribute ('redirect_after_login', $this->company_offer->getCompany()->getUri());
        $this->redirect('user/signin');
    }

    $count = ( int ) $request->getParameter ( 'vouchers', 1 );
    if ($this->company_offer->getIsActive () && $this->company_offer->getIsAvailableToOrder ( $this->user )) {
    $v_ids = array();
      if ($count == 1) {
        $user_voucher = new Voucher ();
        $user_voucher->setUserId ( $this->user->getId () );
        $user_voucher->setCompanyOfferId ( $this->company_offer->getId () );
        $user_voucher->setCode ( substr ( uniqid ( md5 ( $this->company_offer->getCode () . rand () ), true ), 0, 8 ) );
        $user_voucher->save ();
        $v_ids = $user_voucher->getId();
      } else {
        $i = 0;
        while ( $i < $count ) {
          $i ++;
          $user_voucher = new Voucher ();
          $user_voucher->setUserId ( $this->user->getId () );
          $user_voucher->setCompanyOfferId ( $this->company_offer->getId () );
          $user_voucher->setCode ( substr ( uniqid ( md5 ( $this->company_offer->getCode () . rand () ), true ), 0, 8 ) );
          $user_voucher->save ();
          $v_ids[$i] = $user_voucher->getId();
        }

      }

      $name = Doctrine::getTable('SerbianNames')
      ->createQuery ( 'sn' )
      ->where('name = ?', $this->user->getFirstName())
      ->fetchOne();

      if ($name){
        $first_name = $name->getSuffix();
      } else{
        $first_name =  $this->user->getFirstName();
      }

      $this->company_offer->updateNumberOfVouchers ();
      myTools::sendMail ( $this->user, $this->company_offer->getTitle () . ' voucher', 'voucher', array ('user' => $this->user, 'company_offer' => $this->company_offer, 'count' => $count, 'name' => $first_name ) );

      return $this->renderText(json_encode(array('error' => false, 'voulchers_id' => $v_ids )));

      //$i18n = sfContext::getInstance ()->getI18N ();
      //$this->getUser ()->setFlash ( 'notice', $i18n->__ ( 'Your voucher was successfully issued. Go to your \'Profile\' and see \'My Vouchers\'.' ) );
      //$this->redirect ( 'offer/show?id=' . $this->company_offer->getId () );
    } else {
    	return $this->renderText(json_encode(array('error' => true )));
      $this->getUser ()->setFlash ( 'error', 'We were unable to issue your voucher. The deal is no longer active or you have already ordered the maximum number vouchers per user. ' );
    }

  }

  public function executeVoucher(sfWebRequest $request) {
    $this->forward404Unless ( $this->voucher = Doctrine_Core::getTable ( 'Voucher' )->find ( array ($request->getParameter ( 'id' ) ) ), sprintf ( 'Object company_offer does not exist (%s).', $request->getParameter ( 'id' ) ) );
    $this->user = $this->getUser ()->getGuardUser ();
    $this->forwardUnless ( $this->voucher->getUserProfile ()->getId () == $this->user->getId (), 'sfGuardAuth', 'secure' );
  }
}

