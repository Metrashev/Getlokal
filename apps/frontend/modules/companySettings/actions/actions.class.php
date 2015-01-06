<?php

  /**
  * company actions.
  *
  * @package    getLokal
  * @subpackage company
  * @author     Get Lokal
  * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
  */
  class companySettingsActions extends sfActions {
    /**
    * Executes index action
    *
    * @param sfRequest $request A request object
    */

    public function executeIndex(sfWebRequest $request)
    {
      $this->is_getlokal_admin = (($this->getUser ()->getGuardUser() &&
      in_array($this->getUser ()->getGuardUser()->getId(), sfConfig::get('app_getlokal_power_user',array())))? true :false);

      if (!$this->is_getlokal_admin) {
	      $this->is_getlokal_admin = (($this->getUser ()->getGuardUser() &&
	      		in_array($this->getUser ()->getGuardUser()->getId(), sfConfig::get('app_getlokal_local_power_user',array())))? true :false);
      }
      
      if ($this->getUser ()->getPageAdminUser() && !$request->getParameter('slug')) {
        $this->redirect('companySettings/basic');
      } elseif ($this->is_getlokal_admin && $request->getParameter('slug')) {
        $this->adminuser = $this->getUser()->getPageAdminUser();
        
        $q = Doctrine::getTable('Company')
          ->createQuery('c')
          ->andWhere('c.slug = ?', $request->getParameter('slug'));
        $this->company = $q->fetchOne();
        $this->redirect('companySettings/basic?slug=' . $this->company->getSlug());
      } elseif ($this->getUser()->getPageAdminUser() && $request->getParameter('slug')) {
        $query = Doctrine::getTable('PageAdmin' )
                  ->createQuery ( 'a' )
                  ->innerJoin ( 'a.CompanyPage p' )
                  ->innerJoin ( 'p.Company c' )
                  ->where ( 'a.user_id = ?', $this->getUser ()->getPageAdminUser ()->getUserId () )
                  ->andWhere ( 'a.status = ?', 'approved' )
                  ->andWhere ( 'c.slug = ?', $request->getParameter ( 'slug' ) );

        $my_other_admin = $query->fetchOne();
        $this->forwardUnless($my_other_admin, 'companySettings', 'noAccess');

        if ($my_other_admin->getUsername ()) {
          $this->redirect ( 'companySettings/login?slug=' . $request->getParameter ( 'slug' ) );
        }
        else
        {
          $path1 = 'userSettings/registerPageAdmin?slug='.$request->getParameter('slug').'&id='.$my_other_admin->getId();
          if (!$this->getUser()->getGuardUser())
          {
            $this->getUser ()->setAttribute ( 'redirect_after_login', $path1 );
          }
          $this->redirect($path1);
        }
      }
      elseif ($request->getParameter ( 'slug' )) {
        $this->redirect('companySettings/login?slug='. $request->getParameter ( 'slug' ));
      }
      else {

        $this->redirect('companySettings/login');
      }
    }


    protected function configShow(sfWebRequest $request)
    {
        $sfUser = $this->getUser();
        $this->is_getlokal_admin = $sfUser->isGetLokalAdmin();
        if (!$this->is_getlokal_admin) {
        	$company = Doctrine::getTable('Company')->findOneBySlug($request->getParameter('slug'));
        	$this->is_getlokal_admin = $sfUser->isGetlokalLocalAdmin($company->getCountry()->getSlug());
        }
        
        $this->user_is_admin = false;
        if (
            (!$sfUser->getPageAdminUser() && !$this->is_getlokal_admin) ||
            !$sfUser->getGuardUser()
        ) {
            $redirect = 'companySettings/login';
            if ($request->getParameter('slug')) {
                $redirect .= '?slug=' . $request->getParameter('slug');
            }
            $this->redirect($redirect);
        }
        if ($this->is_getlokal_admin) {
            $this->adminuser = null;
            $this->user = $sfUser->getGuardUser();
        } else {
            $this->adminuser = $sfUser->getPageAdminUser();
            $this->user = $this->adminuser->getUserProfile()->getsfGuardUser();
            $this->user_is_admin = true;
        }

        $query = Doctrine::getTable('Company')->createQuery('c');

        if (!$this->is_getlokal_admin) {
            $query->innerJoin('c.CompanyPage p')
                ->innerJoin('p.PageAdmin a')
                ->where('a.id = ?', $this->adminuser->getId())
                ->andWhere('a.status = ?', 'approved');
        }

        if (!$request->getParameter('slug')) {
            if ($this->adminuser) {
                $query->andWhere('c.slug = ?',
                    $this->adminuser->getCompanyPage()->getCompany()->getSlug());
            } elseif ($this->is_getlokal_admin) {
                if ($request->getParameter('action') == 'offers' || $request->getParameter('action') == 'offerPublish') {
                    $offer = Doctrine::getTable('CompanyOffer')
                        ->findOneById($request->getParameter('id'));

                    if ($offer) {
                        $query->andWhere('c.slug = ?', $offer->getCompany()->getSlug());
                    }
                }
            }
        } else {
            $query->andWhere('c.slug = ?', $request->getParameter('slug'));
        }

        $this->company = $query->fetchOne();

        $this->forwardUnless($this->company, 'userSettings', 'companySettings');
        $this->company->setUser($this->getUser());
        if (!$this->is_getlokal_admin){
            $q = Doctrine::getTable('Company')->createQuery('c')
                ->innerJoin('c.CompanyPage p')
                ->innerJoin('p.PageAdmin a')
                ->where('a.user_id = ?', $this->user->getId())
                ->andWhere('a.status = ?', 'approved');
            $this->companies = $q->execute();
        } else {
            $this->companies = array();
        }

        $this->getResponse()->setSlot('sub_module', 'companySettings');
        $this->getResponse()->setSlot('sub_module_parameters', array(
            'company' => $this->company,
            'companies' => $this->companies,
            'adminuser' => $this->adminuser,
            'is_getlokal_admin' => $this->is_getlokal_admin
        ));
    }

    public function executeContactFollowers(sfWebRequest $request) {
      $this->configShow($request);
      $q = Doctrine::getTable('FollowPage')
           ->createQuery('fp')
           ->where('fp.page_id = ?', $this->company->getCompanyPage()->getId())
           ->andWhere('fp.internal_notification = ?', true);

      $this->all_followers = $q->execute();
      $this->form = new BulkMessageForm();

    if ($request->isMethod ( 'post' )) {
            $params = $request->getParameter ( $this->form->getName () );
            $this->form->bind ( $params );
            if ($this->form->isValid ()) {

                if (is_array ( $params ['to'] )) {

                    foreach ( $params ['to'] as $page_id ) {
                        $message = new Message ();
                        $message->setBody ( $params ['body'] );
                        $conversation = Doctrine::getTable ( 'Conversation' )->getConversation ( $this->company->getCompanyPage()->getId (), $page_id );
                        $message->setPageId ( $this->company->getCompanyPage()->getId () );
                        $conversation->setNewMessage ( $message );
                        $this->dispatcher->notify ( new sfEvent ( $message, 'social.write_message' ) );

                    }

                }
                $this->getUser ()->setFlash ( 'notice', 'Your message was sent successfully' );


                $this->redirect('companySettings/followers?slug='.$this->getUser ()->getPageAdminUser ()->getCompanyPage ()->getCompany()->getSlug());

            }

        }
    }

   public function executeFollowers(sfWebRequest $request) {

      $this->configShow($request);
       $q = Doctrine::getTable ( 'FollowPage' )
       ->createQuery('fp')
       ->innerJoin('fp.UserProfile u')
       ->where('fp.page_id = ?', $this->company->getCompanyPage()->getId());
      $this->pager = new sfDoctrinePager ( 'FollowPage', 8 );
      $this->pager->setPage ( $request->getParameter ( 'page', 1 ) );
      $this->pager->setQuery ( $q );
      $this->pager->init ();
    }

    public function executeBasic(sfWebRequest $request) {
      $this->configShow($request);
      $this->form = new BasicCompanyInfoForm ( $this->company );
      
      $culture = sfContext::getInstance()->getUser()->getCountry()->getSlug();
      $current_culture = sfContext::getInstance()->getUser()->getCulture();
      $partner_class = getlokalPartner::getLanguageClass();
      $cultures = sfConfig::get('app_languages_'.$culture);
      
      if ($request->isMethod ( 'post' )) {
        sfContext::getInstance()->getConfiguration()->loadHelpers('Frontend');
        $params = $request->getParameter ( $this->form->getName () );
        $params [$culture]['title'] = format_company_title ($params [$culture]['title']);
        if (! isset ( $params ['en']['title'] ) or ($params ['en']['title'] == '')) {
          $partner_class = getlokalPartner::getLanguageClass ( $this->company->getCountryId () );
          $params ['en']['title'] = format_company_title (call_user_func(array('Transliterate'.$partner_class, 'toLatin'),$params [$culture]['title']));
        }else
        {
          $params ['en']['title'] = format_company_title ($params ['en']['title']);
        }
        if(count($cultures)>2){
            foreach($cultures as $language){
                if ($culture !='en' && $language != $culture){
                    $current_culture = $language;

                    if (! isset ( $params [$current_culture]['title'] ) || ($params [$current_culture]['title'] == '')) {
                        if(method_exists('Transliterate'.$partner_class, 'to'.$current_culture)){
                            $params [$current_culture]['title'] = format_company_title (call_user_func(array('Transliterate'.$partner_class, 'to'.$current_culture),$params [$culture]['title']));
                        }
                        else{
                            $params [$current_culture]['title'] = format_company_title ($params [$culture]['title']);
                        }
                    }else
                    {
                        $params [$current_culture]['title'] = format_company_title ($params [$current_culture]['title']);
                    }
                }
            }
        }
        
        if (isset ( $params ['twitter_url'] ) && $params ['twitter_url'] != '' && stripos ( $params ['twitter_url'], 'http://twitter.com/' ) !== 0) {
            $params ['twitter_url'] = 'http://twitter.com/' . $params ['twitter_url'];
        }

        $this->form->bind ( $params );

        if ($this->form->isValid ()) {
          $this->form->save ();
          $this->getUser ()->setFlash ('notice','The changes were saved successfully.');
            $msg = array('user'=>(($this->adminuser)? $this->adminuser : $this->user) , 'object'=>'company', 'action'=>'basicInfo', 'object_id' =>$this->company->getId());
            $this->dispatcher->notify(new sfEvent($msg, 'user.write_log'));
          $this->redirect ( 'companySettings/basic?slug=' . $this->company->getSlug () );
        } else {
           $this->getUser ()->setFlash ('error','Please fill in all mandatory fields.');
        }
      }
      if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
                AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            if ($this->form->hasErrors() > 0) {
                
            } else {
                $params = $request->getParameter($this->form->getName(), array());
                $this->form->bind($params);
                return $this->renderText(json_encode(array('html' => '')));
            }
        }
    }

    public function executeHours(sfWebRequest $request) {
      breadCrumb::getInstance()->removeRoot();
      $this->configShow($request);
      $this->form = new CompanyDetailForm ( $this->company->getCompanyDetail () );

      foreach ( array ('mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun' ) as $day ) {
        $fields [] = $day . '_from';
        $fields [] = $day . '_to';
      }
      $this->form->useFields ( $fields );

      if ($request->isMethod ( 'post' )) {

        $params = $request->getParameter ( $this->form->getName () );

        $this->form->bind ( $params );

        if ($this->form->isValid ()) {

          $this->form->save ();
          $this->getUser ()->setFlash ('notice','The information you entered was saved successfully.');

          $this->redirect ( 'companySettings/hours?slug=' . $this->company->getSlug () );
        }
      }
      if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
                AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            if ($this->form->hasErrors() > 0) {
                
            } else {
                $params = $request->getParameter($this->form->getName(), array());
                $this->form->bind($params);
                return $this->renderText(json_encode(array('html' => '')));
            }
        }
    }

    public function executeDetails(sfWebRequest $request) {
         $i18n = sfContext::getInstance()->getI18N();
      $this->configShow($request);
      $this->form = new CompanyDescriptionForm ( $this->company );
         
      if ($request->isMethod ( 'post' )) {
          
        $params = $request->getParameter ( $this->form->getName () );
        if(array_key_exists('indoor_seats', $params) || array_key_exists('indoor_seats', $params)){
            if (isset($params ['outdoor_seats']) && $params ['outdoor_seats']!='' && isset($params['feature_company_list']) && !in_array('7',$params['feature_company_list']) ){
                    $params['feature_company_list'][]='7';
            }elseif ( ( isset($params ['outdoor_seats']) && $params ['outdoor_seats']=='' && isset($params['feature_company_list']) && in_array('7',$params['feature_company_list']) ) 
                            || (!isset($params ['outdoor_seats'])) ){
                unset($params['feature_company_list'][array_search('7',$params['feature_company_list'])]);
            }
            if (isset($params ['indoor_seats']) && $params ['indoor_seats']!='' && isset($params['feature_company_list']) && !in_array('8',$params['feature_company_list']) ){
                $params['feature_company_list'][]='8';
            }elseif ( ( !isset($params ['indoor_seats']) && $params ['indoor_seats']=='' && isset($params['feature_company_list']) && in_array('8',$params['feature_company_list']) )  ){
                unset($params['feature_company_list'][array_search('8',$params['feature_company_list'])]);
            }
        }
        $this->form->bind ( $params );
        if ($this->form->isValid ()) {

          $this->form->save ();
          $this->getUser ()->setFlash ('notice','The information you entered was saved successfully.');

          $this->redirect ( 'companySettings/details?slug=' . $this->company->getSlug () );
        }
       
      }
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
                AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            if ($this->form->hasErrors() > 0) {
                
            } else {
                $params = $request->getParameter($this->form->getName(), array());
                $this->form->bind($params);
                return $this->renderText(json_encode(array('html' => '')));
            }
        }
    }
    public function executeClassification(sfWebRequest $request) {
        $this->configShow($request);
        $this->form = new CompanyClassificationsForm ( null, array ('company' => $this->company ) );

        $company = Doctrine::getTable('Company')->findBy('slug', $this->company->getSlug ());
        $classification = $request->getParameter ( $this->form->getName ());
        $data = $company->getData();
        $new_classification_id = $classification['orderclass'][1]['classification_id'];
        $old_classification_id = $data[0]['_data']['classification_id'];
        
        if ($request->isMethod ( 'post' )) {
            $this->form->bind ( $request->getParameter ( $this->form->getName () ) );

            if ($this->form->isValid ()) {

                $this->form->save ();

                //Update Classification Translation 'number_of_places'
                $lang_array = getlokalPartner::getEmbeddedLanguages();
                foreach ($lang_array as $lang){
                      if($lang !='en'){
                        $count_places_old  =  Doctrine::getTable('Company')
                          ->createQuery('c')
                          ->innerJoin('c.CompanyClassification cc')
                          ->addWhere('country_id = ? AND status = ? ', array($data[0]['_data']['country_id'], CompanyTable::VISIBLE))
                          ->andWhere('cc.classification_id = ? ', $old_classification_id)
                          ->count();
                        
                        $q_old = Doctrine_Query::create()
                          ->update('ClassificationTranslation')
                          ->set('number_of_places', $count_places_old)
                          ->where('id = ?', $old_classification_id)
                          ->andWhere('lang = ?', $lang)
                          ->execute();
                        
                        $count_places_new  =  Doctrine::getTable('Company')
                          ->createQuery('c')
                          ->innerJoin('c.CompanyClassification cc')
                          ->addWhere('country_id = ? AND status = ? ', array($data[0]['_data']['country_id'], CompanyTable::VISIBLE))
                          ->andWhere('cc.classification_id = ? ', $new_classification_id)
                          ->count();

                        $q_new = Doctrine_Query::create()
                          ->update('ClassificationTranslation')
                          ->set('number_of_places', $count_places_new)
                          ->where('id = ?', $new_classification_id)
                          ->andWhere('lang = ?', $lang)->execute();
                      }
                }
                //End Update
                
                
              $this->getUser ()->setFlash ( 'notice', 'The classification information was saved successfully.' );

              $this->redirect ( 'companySettings/classification?slug=' . $this->company->getSlug () );
            }
        }
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
                AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            if ($this->form->hasErrors() > 0) {
                
            } else {
                $params = $request->getParameter($this->form->getName(), array());
                $this->form->bind($params);
                return $this->renderText(json_encode(array('html' => '')));
            }
        }
    }
    public function executeChangeClassification(sfWebRequest $request) {
      $this->configShow($request);
      $this->index = $request->getParameter ( 'embedded_index' );
      $form = new ChangeClassificationForm ( null, array ('company' => $this->company ) );
      return $this->renderPartial ( 'companySettings/selectClassification', array ('form' => $form, 'index' => $this->index ) );
    }

    public function executeAddClassificationForm($request) {
      $this->configShow($request);
      $number = intval ( $request->getParameter ( 'num' ) );

      $form = new CompanyClassificationsForm ( null, array ('company' => $this->company ) );

      $form->addCompanyClassification ( $number );

      return $this->renderPartial ( 'addclassification', array ('form' => $form, 'num' => $number, 'company' => $this->company ) );
    }

    public function executeRemoveClassification(sfWebRequest $request) {
      $this->configShow($request);
      $dql = Doctrine::getTable ( 'CompanyClassification' )->createQuery ( 'i' )->where ( 'i.company_id = ?', $this->company->getId () )->andWhere ( 'i.classification_id = ?', $request->getParameter ( 'classification_id' ) );

      $this->forward404Unless ( $classification = $dql->fetchOne () );

      $classification->delete ();

      $this->getUser ()->setFlash ( 'notice', 'The classification was deleted successfully.' );
      return sfView::NONE;

      // $this->redirect('companySettings/classification?slug='. $this->company->getSlug());
    }

    public function executeLocation(sfWebRequest $request) {
      $this->configShow($request);
      $this->form = new CompanyLocationForm ( $this->company->getLocation () );

      if ($request->isMethod ( 'post' )) {
        $this->form->bind ( $request->getParameter ( $this->form->getName () ) );

        if ($this->form->isValid ()) {
          $object = $this->form->updateObject ();

          $object->save ();

          $this->redirect ( 'company/location?slug=' . $this->company->getSlug () );
        }
      }
    }

    public function executeUpload(sfWebRequest $request) {
      $this->configShow($request);
      $this->form = new ImageForm ();
      $this->is_cover = $request->getParameter('cover',false);
      if ($request->isMethod ( 'post' )) {
        $this->form->bind ( $request->getParameter ( $this->form->getName () ), $request->getFiles ( $this->form->getName () ) );

        if ($this->form->isValid ()) {
          $photo = new Image ();
          $photo->setFile ( $this->form->getValue ( 'file' ) );
          $photo->setCaption ( $this->form->getValue ( 'caption' ) );
          $photo->setUserId ( $this->user->getId () );
          $photo->setStatus('approved');
          $photo->setType('company');
          $photo->save ();

          $company_image = new CompanyImage ();
          $company_image->setImageId ( $photo->getId () );
          $company_image->setCompanyId ( $this->company->getId () );
          $company_image->save ();

          if (! $this->company->getImageId ()) {
            $this->company->setImageId ( $photo->getId () );
            $this->company->save ();
          }


          if ($this->is_cover)
          {
             $this->redirect ( 'crop/placePhoto?image_id='. $photo->getId().'&slug='.$this->company->getSlug() );
          }else {
           $this->getUser ()->setFlash ( 'notice', 'The photo was published successfully.' );
          $this->redirect ( 'companySettings/images?slug=' . $this->company->getSlug () );
          }
          } else{
            if(myTools::isExceedingMaxPhpSize()){
              $this->getUser ()->setFlash ( 'error', 'File size limit is 4MB.Please reduce file size before submitting again.' );
            }
          }
      }
    }



    public function executeSetProfile(sfWebRequest $request) {
      $this->configShow($request);
      $query = Doctrine::getTable ( 'Image' )
      ->createQuery ( 'i' )
      ->innerJoin ( 'i.CompanyImage ci' )
      ->where ( 'ci.company_id = ?', $this->company->getId () )
      ->andWhere ( 'i.id = ?', $request->getParameter ( 'id' ) )
      ->andWhere('i.type != ?', 'video');

      $this->forward404Unless ( $image = $query->fetchOne () );

      $this->company->setImageId ( $image->getId () );
      $this->company->save ();

      $this->redirect ( $request->getReferer () );
    }

    public function executeDeleteImage(sfWebRequest $request) {
      $this->configShow($request);
      $query = Doctrine::getTable ( 'Image' )->createQuery ( 'i' )->innerJoin ( 'i.CompanyImage ci' )->where ( 'ci.company_id = ?', $this->company->getId () )->andWhere ( 'i.id = ?', $request->getParameter ( 'id' ) );

      $this->forward404Unless ( $image = $query->fetchOne () );
      $image->getCompany()->setUser( $this->getUser());

      $image->delete ();

      $this->getUser ()->setFlash ( 'notice', 'The photo was deleted successfully.' );

      $this->redirect ( $request->getReferer () );
    }

    public function executeImages(sfWebRequest $request) {
      $this->configShow($request);
      $query = Doctrine::getTable ( 'Image' )
      ->createQuery ( 'i' )
      ->innerJoin ( 'i.CompanyImage ci' )
      ->where ( 'ci.company_id = ?', $this->company->getId () )
      ->andWhere('i.type != ?', 'video');

      $this->pager = new sfDoctrinePager ( 'Image', 9 );
      $this->pager->setPage ( $request->getParameter ( 'page', 1 ) );
      $this->pager->setQuery ( $query );
      $this->pager->init ();
    }

    public function executeStatistics(sfWebRequest $request) {
      $this->configShow($request);
      $this->month = $request->getParameter ( 'with_month', null );
      if ($request->isMethod('POST'))
      {
        $this->month = $request->getParameter ( 'with_month', null );
        // return $this->renderPartial ( 'companySettings/statistics', array ('company' => $this->company, 'month' => $this->month ) );

      }
    }

  public function executeCoverImages(sfWebRequest $request) {
      $this->configShow($request);
      $query = Doctrine::getTable ( 'CoverImage' )->createQuery ( 'i' )->where ( 'i.company_id = ?', $this->company->getId () )
      ->addOrderBy('i.id');

      $this->pager = new sfDoctrinePager ( 'CoverImage', 8 );
      $this->pager->setPage ( $request->getParameter ( 'page', 1 ) );
      $this->pager->setQuery ( $query );
      $this->pager->init ();
    }

    public function executeNoAccess(sfWebRequest $request) {

    }

    public function executeAdmins(sfWebRequest $request) {
      $this->configShow($request);
      $q = Doctrine::getTable ( 'PageAdmin' )->createQuery ( 'p' )->where ( 'p.page_id = ?', $this->company->getCompanyPage ()->getId () );

      $this->pageAdmins = $q->execute ();
    }

    public function executeSetAdminStatus(sfWebRequest $request) {
      $this->configShow($request);
      $this->admin = Doctrine::getTable ( 'PageAdmin' )
      ->createQuery('pa')
      ->where ('pa.id = ? ',$request->getParameter ( 'pageadmin_id' ))
      ->andWhere('pa.page_id = ? ',$this->company->getCompanyPage()->getId())
      ->fetchOne();

      $status = $request->getParameter ( 'status' );
      $this->forwardUnless ( $this->admin, 'companySettings', 'noAccess' );
      $this->admin->setStatus ( $status );
      if ($status == 'rejected')
      {
        $this->admin->setIsPrimary(false);
      }
      $this->admin->save ();

      if (!$this->company->getPrimaryAdmin()){
          $next_company_place_admin = Doctrine_Core::getTable ( 'PageAdmin' )->createQuery ( 'p' )->innerJoin ( 'p.CompanyPage cp' )->innerJoin ( 'cp.Company c' )->andWhere ( 'c.id = ?', $this->company->getId() )->andWhere('p.status = ?', 'approved')->orderBy('p.created_at')->fetchOne ();
          if ($next_company_place_admin)
          {
            $next_company_place_admin->setIsPrimary(true);
            $next_company_place_admin->save();
          }
        }



      $msg = array('user'=>$this->adminuser, 'object'=>'place_admin', 'action'=>$status, 'object_id'=>$this->admin->getId());
      $this->dispatcher->notify(new sfEvent($msg, 'user.write_log'));

      $this->getUser ()->setFlash ( 'notice', 'Admin status changed successfully.' );

      $this->redirect ( $request->getReferer () );
    }

    public function executeOffers(sfWebRequest $request) {
        $this->configShow($request);
        $this->drafts = (bool) $request->getParameter('drafts');

        $query = CompanyOfferTable::getInstance()->createQuery('co')
            ->where('co.company_id = ?', $this->company->getId())
            ->andWhere('co.is_draft = ?', $this->drafts)
            ->orderBy('co.id DESC');

        $this->pager = new sfDoctrinePager('CompanyOffer', 5);
        $this->pager->setPage($request->getParameter('page', 1));
        $this->pager->setQuery($query);
        $this->pager->init();
    }

    public function executeActivateDetailDescription(sfWebRequest $request) {
        $this->configShow($request);
        $company_detail = $this->company->getCompanyDetail();
        $company_detail->setConfirmed(1);
        $company_detail->save();

        $this->getUser()->setFlash ('notice','The detailed description was activated successfully.');
        $this->redirect('companySettings/details?slug=' . $this->company->getSlug());
    }

    public function executeActivateOffer(sfWebRequest $request) {
        $this->configShow($request);
        $company_offer = Doctrine::getTable('CompanyOffer')
            ->findOneById($request->getParameter('id'));
        if (
            !$company_offer->getIsActive() &&
            $company_offer->getAdServiceCompany()->getStatus() == 'paid'
        ) {
            $product_available = $company_offer->getAdServiceCompany()
                ->getDealServiceToActivate();

            if ($product_available) {
                try {
                    $con = Doctrine::getConnectionByTableName('CompanyOffer');
                    $con->beginTransaction();
                    $company_offer->setIsActive(1);
                    $company_offer->save();
                    $product_available->setActiveFrom($company_offer->getActiveFrom());

                    if ($product_available->getStatus() == 'paid') {
                        $product_available->setStatus('active');
                    }
                    $product_available->save();

                    $activity = Doctrine::getTable('ActivityCompanyOffer')
                        ->getActivity($company_offer->getId());
                    $activity->setText($company_offer->getTitle());
                    $activity->setUserId($company_offer->getCreatedBy());
                    $activity->setPageId( $this->company->getCompanyPage()->getId());
                    $activity->setMediaId($this->company->getImageId());
                    $activity->save();

                    $con->commit();
                } catch (Exception $e) {
                    $con->rollBack();
                    $this->getUser()->setFlash('notice', 'The deal was not activated successfully.');
                }
                $this->getUser()->setFlash('notice', 'The offer was activated successfully..');
            } else {
                $this->getUser()->setFlash('error', 'Invalid or inactive offer' );
            }

        } elseif (
            !$company_offer->getIsActive() &&
            $company_offer->getAdServiceCompany()->getStatus() == 'active'
        ) {
            $company_offer->setIsActive(1);
            $company_offer->save();
        } else {
            $this->getUser()->setFlash('error', 'The offer is already active.');
        }

        $this->redirect('companySettings/offers?slug=' . $this->company->getSlug());
    }

    /**
     * Publish an offer that is in draft mode
     */
    public function executeOfferPublish(sfWebRequest $request)
    {
        $this->configShow($request);
        $id = $request->getParameter('id');
        $this->company_offer = CompanyOfferTable::getInstance()->findOneByIdAndCompanyId(
            $id,
            $this->company->getId()
        );
        $this->forward404Unless($this->company_offer,
            sprintf('Object company_offer does not exists with id: %s', $id));
        $this->company_offer->setIsDraft(0);
        $this->company_offer->save();

        $i18n = sfContext::getInstance()->getI18n();
        $this->getUser()->setFlash('notice', $i18n->__('The offer was published successfully.', null, 'offer'));

        $this->redirect('companySettings/offers?slug=' . $this->company->getSlug());
    }

    public function executeCompanyVouchers(sfWebRequest $request) {
      $this->configShow($request);
      $this->forward404Unless ( $company_offer = Doctrine_Core::getTable ( 'CompanyOffer' )->find ( array ($request->getParameter ( 'id' ) ) ), sprintf ( 'Object company_offer does not exist (%s).', $request->getParameter ( 'id' ) ) );
      $this->forwardUnless ( $company_offer->getCompany ()->getId () == $this->company->getId (), 'sfGuardAuth', 'secure' );

      $this->ordered_vouchers = $company_offer->getVouchersPerOffer ();

      $this->forward404Unless ( count ( $this->ordered_vouchers ) > 0 );
      $this->setlayout ( 'csv' );

      $this->getResponse ()->clearHttpHeaders ();
      $this->getResponse ()->setHttpHeader ( 'Content-Type', 'application/vnd.ms-excel;charset=utf-8' );

      $this->getResponse ()->setHttpHeader ( 'Content-Disposition', 'attachment; filename=vochers_per_' . $company_offer->getId () . '.xls', true );

      $this->setTemplate ( 'csvList' );

      //return sfView::NONE;
    }

    public function executeGetToken(sfWebRequest $request) {
      $generate_youtube_token = intval ( $request->getParameter ( 'generate_youtube_token' ) );
      $status = intval ( $request->getParameter ( 'status' ) );
      $video_id = $request->getParameter ( 'id' );
      if ($generate_youtube_token != 0) {

        /********************************************
        * Here we will generate the YouTube
        * token.
        * Author:
        * Georgi Naumov
        * gonaumov@gmail.com
        * for contacts and suggestions ..
        ********************************************/
        $videotitle = $request->getParameter ( 'videotitle' );
        $videodescription = $request->getParameter ( 'videodescription' );
        $slug = $request->getParameter ( 'slug' );
        //$file_format = $request->getParameter ( 'file_format' );
        //$file_format = preg_replace ( '#.+(?=[a-z]{3}$)#is', '', $file_format );
        /*************************************
        * Save video information in session
        *************************************/
        $this->getUser ()->setAttribute ( 'videoinfo', array ('caption' => $videotitle, 'description' => $videodescription, 'slug' => $this->company->getSlug() ) );

        $tokenArray = $this->getYoutubeUploaderFormUploadToken ( $videotitle, $videodescription );


        $this->getResponse ()->setHttpHeader ( 'Content-type', 'application/json' );
        return $this->renderText ( json_encode ( $tokenArray ) );

        /*******************************************
        * End of youtobe generate token
        *******************************************/
      }

    }


    public function executeVideos(sfWebRequest $request) {
      $this->configShow($request);
      $ad_company = $this->company->getActivePPPService (true);

      if (!$ad_company)
      {
        $this->getUser ()->setFlash ('error', 'No paid service available');
        $this->redirect ( 'companySettings/basic?slug=' . $this->company->getSlug () );
      }

      $generate_youtube_token = intval ( $request->getParameter ( 'generate_youtube_token' ) );
      $status = intval ( $request->getParameter ( 'status' ) );
      $video_id = $request->getParameter ( 'id' );
      if ($generate_youtube_token != 0) {

        /********************************************
        * Here we will generate the YouTube
        * token.
        * Author:
        * Georgi Naumov
        * gonaumov@gmail.com
        * for contacts and suggestions ..
        ********************************************/
        $videotitle = $request->getParameter ( 'videotitle' );
        $videodescription = $request->getParameter ( 'videodescription' );
        $slug = $request->getParameter ( 'slug' );
        //$file_format = $request->getParameter ( 'file_format' );
        //$file_format = preg_replace ( '#.+(?=[a-z]{3}$)#is', '', $file_format );
        /*************************************
        * Save video information in session
        *************************************/
        $this->getUser ()->setAttribute ( 'videoinfo', array ('caption' => $videotitle, 'description' => $videodescription, 'slug' => $this->company->getSlug() ) );

        $tokenArray = $this->getYoutubeUploaderFormUploadToken ( $videotitle, $videodescription );


        $this->getResponse ()->setHttpHeader ( 'Content-type', 'application/json' );
        return $this->renderText ( json_encode ( $tokenArray ) );

        /*******************************************
        * End of youtobe generate token
        *******************************************/
      }
      elseif ($status == 200 && is_array ( $this->getUser ()->getAttribute ( 'videoinfo' ) )) {
        /***************************************************
        * Video is uploaded in youtobe channel we will
        * save information about this video in database.
        ***************************************************/

        //if ($status == 200 ){
         $video_info = $this->getUser ()->getAttribute ( 'videoinfo' );

          $video= new Video ();
          $video->setCompany($this->company);
          $video->setCaption ( $video_info ['caption'] );
          $video->setDescription ( $video_info ['description'] );
          $video->setUserId ( $this->user->getId () );
          $video->setLink ( $video_id );
          $video->setStatus('approved');
          $video->setCountryId($this->company->getId());
          $video->save ();

          $company_video = new CompanyImage ();
          $company_video->setImageId ( $video->getId () );
          $company_video->setCompanyId ( $this->company->getId () );
          $company_video->save ();


        /********************************************************
        * Clear session array
        ********************************************************/
        $this->getUser ()->getAttributeHolder ()->remove ( 'videoinfo' );
        /********************************************************
        * Here we will redirect to all videos page.
        ********************************************************/
       $this->getUser ()->setFlash ('notice','The video was successfully uploaded.');

        $this->redirect ( 'companySettings/videos?slug='.$this->company->getSlug() );
        //  }
      }elseif ($status == 400 || (!$status && $generate_youtube_token == 1)){
        $this->getUser ()->setFlash ('notice','An error ocurred while processing your request. Please try again later.');


      }
      $videoid = $request->getParameter ( 'videoid', 0 );

      if ($videoid == 0) {

        $this->form = new VideoForm ( null, array ('company' => $this->company ) );
      } else {

        $this->forward404Unless ( $video = Doctrine_Core::getTable ( 'Video' )->find ( array ($request->getParameter ( 'videoid' ) ) ), sprintf ( 'Video object does not exist (%s).', $videoid ) );
          $this->form = new VideoForm ($video);

        if ($request->isMethod ( 'post' )) {


          $defaults = $this->form->getDefaults ();
          $parameters = $request->getParameter ( 'video', array () );
          $defaults = array_merge ( $defaults, $parameters );
          $fileUrl = $defaults ['filename'];
          $fileDescription = $defaults ['caption'];
          $title = $defaults ['caption'];

          $this->form->bind ( $defaults );
          if ($this->form->isValid ()) {

            $video = $this->form->save ();
            $this->updateVideoEntry ( $fileUrl, $title, $fileDescription );

          }
        }
      }
      $this->videos= $this->company->getVideos();
    }

    private function initYoutubeData() {

      $partner = getlokalPartner::getInstance();
      if ($partner == getlokalPartner::GETLOKAL_BG){
      $this->developerKey = sfConfig::get ( 'app_youtubeuploader_developer_key_bg', '' );
      $this->username = sfConfig::get ( 'app_youtubeuploader_username_bg', '' );
      $this->password = sfConfig::get ( 'app_youtubeuploader_password_bg', '' );
      }elseif($partner == getlokalPartner::GETLOKAL_RO){
      $this->developerKey = sfConfig::get ( 'app_youtubeuploader_developer_key_ro', '' );
      $this->username = sfConfig::get ( 'app_youtubeuploader_username_ro', '' );
      $this->password = sfConfig::get ( 'app_youtubeuploader_password_ro', '' );
      }elseif ($partner == getlokalPartner::GETLOKAL_MK){
      $this->developerKey = sfConfig::get ( 'app_youtubeuploader_developer_key_mk', '' );
      $this->username = sfConfig::get ( 'app_youtubeuploader_username_mk', '' );
      $this->password = sfConfig::get ( 'app_youtubeuploader_password_mk', '' );
      }elseif ($partner == getlokalPartner::GETLOKAL_RS){
      $this->developerKey = sfConfig::get ( 'app_youtubeuploader_developer_key_rs', '' );
      $this->username = sfConfig::get ( 'app_youtubeuploader_username_rs', '' );
      $this->password = sfConfig::get ( 'app_youtubeuploader_password_rs', '' );
      }

      $this->applicationid = sfConfig::get ( 'app_youtubeuploader_applicationid', '' );
      $this->clientid = sfConfig::get ( 'app_youtubeuploader_clientid', '' );
      $this->authentication_url = sfConfig::get ( 'app_youtubeuploader_authentication_url', '' );
      $this->source = sfConfig::get ( 'app_youtubeuploader_source', '' );
      $this->tokenHandlerUrl = sfConfig::get ( 'app_youtubeuploader_token_handler_url', '' );
    }


    private function getYoutubeUploaderFormUploadToken($video_title, $video_description) {
      $this->initYoutubeData ();
      $httpClient = Zend_Gdata_ClientLogin::getHttpClient ( $this->username, $this->password, 'youtube', null, $this->source, null, null, $this->authentication_url );
      $yt = new Zend_Gdata_YouTube ( $httpClient, $this->applicationid, $this->clientid, $this->developerKey );
      $myVideoEntry = new Zend_Gdata_YouTube_VideoEntry ();
      $myVideoEntry->setVideoTitle ( $video_title );
      $myVideoEntry->setVideoDescription ( $video_description );
      $myVideoEntry->setVideoCategory ( 'People' );
      $tokenArray = $yt->getFormUploadToken ( $myVideoEntry, $this->tokenHandlerUrl );

      return $tokenArray;
    }

    private function deleteVideoEntry($videoid) {
      $this->initYoutubeData ();
      $httpClient = Zend_Gdata_ClientLogin::getHttpClient ( $this->username, $this->password, 'youtube', null, $this->source, null, null, $this->authentication_url );
      $yt = new Zend_Gdata_YouTube ( $httpClient, $this->applicationid, $this->clientid, $this->developerKey );
      $videoEntry = $yt->getFullVideoEntry ( $videoid );
        if ($videoEntry != null) {
            $yt->delete ( $videoEntry );
            return true;
        }
        return false;
    }

    public function executeDeleteVideo(sfWebRequest $request) {
        $this->configShow ( $request );
        $this->forward404Unless ( $video = Doctrine_Core::getTable ( 'Video' )->find ( array ($request->getParameter ( 'videoid' ) ) ), sprintf ( 'Object company_offer does not exist (%s).', $request->getParameter ( 'videoid' ) ) );
        $res = false;

        $res = $this->deleteVideoEntry ( $video->getLink () );
        if ($res == true) {
            $video->delete ();
            $this->getUser ()->setFlash ( 'notice', 'The video was deleted successfully.' );
        } else {
            $this->getUser ()->setFlash ( 'notice', 'An error ocurred while processing your request. Please try again later.');
          }
      $this->redirect ( 'companySettings/videos?slug=' . $this->company->getSlug () );
    }

    public function executeSetFirstVideo(sfWebRequest $request) {
      $this->configShow($request);

      $this->forward404Unless ( $video = Doctrine_Core::getTable ( 'Video' )->find ( array ($request->getParameter ( 'videoid' ) ) ), sprintf ( 'Object company_offer does not exist (%s).', $request->getParameter ( 'videoid' )  ) );
      //$video->updatePriority ();
      $video->setPriority ( 1 );
      $video->save ();
      $this->redirect ( 'companySettings/videos?slug=' . $this->company->getSlug () );

    }

    public function executeEditVideo(sfWebRequest $request) {

      $this->configShow($request);
      $this->forward404Unless ( $video = Doctrine_Core::getTable ( 'Video' )
      ->findOneById ($request->getParameter ( 'videoid' )  ), sprintf ( 'Video object does not exist (%s).', $request->getParameter ( 'videoid' ) ) );

      $this->form = new VideoForm ( $video);
      if ($request->isMethod ( 'post' )) {
        $parameters = $request->getParameter ( 'video', array () );
        $parameters['caption']=$request->getParameter('video_caption');
        $parameters['description']=$request->getParameter('video_description');

        $this->form->bind ( $parameters, $request->getFiles ( $this->form->getName () ) );

        if ($this->form->isValid ()) {

          $res=false;
          $res = $this->updateVideoEntry ( $video->getLink(), $parameters['caption'], $parameters['description'] );
          if($res == true)
          {
              $video = $this->form->save ();
              $this->getUser ()->setFlash ('notice','The changes were saved successfully.');
          }else {
            $this->getUser ()->setFlash ('notice','An error ocurred while processing your request. Please try again later.');

          }
          $this->redirect ( 'companySettings/videos?slug=' . $this->company->getSlug () );
        }

      }
    }

    /*******************************************************
    * Update video description and title in youtobe
    * @author Georgi Naumov
    * gonaumov@gmail.com for contancts and suggestions
    * @param string $videoid
    * @param string $title
    * @param string $description
    *******************************************************/
    public function updateVideoEntry($videoid, $title, $description) {
        $this->initYoutubeData();
        $httpClient = Zend_Gdata_ClientLogin::getHttpClient(
            $this->username,
            $this->password,
            'youtube',
            null,
            $this->source,
            null,
            null,
            $this->authentication_url
        );
        $yt = new Zend_Gdata_YouTube(
            $httpClient,
            $this->applicationid,
            $this->clientid,
            $this->developerKey
        );
        $videoEntry = $yt->getFullVideoEntry($videoid);

        if ($videoEntry != null) {
            $videoEntry->setVideoTitle($title);
            $videoEntry->setVideoDescription($description);
            $yt->updateEntry($videoEntry);
            return true;
        }

        return false;
    }

    public function executeVip(sfWebRequest $request) {
      $this->configShow($request);
      $this->vips = $this->company->getVipAdProduct(false);
      $this->forward404Unless ( (count($this->vips)> 0) , sprintf ( 'No VIP service available'  ) );
      //$this->redirect ( 'companySettings/vip?slug=' . $this->company->getSlug () );
    }

    public function executeReviews(sfWebRequest $request) {
        $this->configShow($request);
        $query = Doctrine::getTable('Review')
            ->createQuery( 'r' )
            ->innerJoin('r.UserProfile p')
            ->innerJoin('p.sfGuardUser sf')
            ->innerJoin('r.ActivityReview a')
            ->leftJoin('a.UserLike l WITH l.user_id = ?', $this->user->getId())
            ->leftJoin('r.Review')
            ->where('r.company_id = ?', $this->company->getId())
            ->andWhere( 'r.parent_id IS NULL')
            ->orderBy('r.created_at DESC');

        $this->pager = new sfDoctrinePager('Review', Review::FRONTEND_REVIEWS_PER_TAB);
        $this->pager->setQuery($query);
        $this->pager->setPage($request->getParameter('page', 1));
        $this->pager->init();
    }



    public function executeLogin(sfWebRequest $request)
    {
        $class = sfConfig::get('app_admins_signin_form', 'SigninPageAdminForm');
        $this->company = null;
        $this->user = $this->getUser()->getGuardUser();
        
        if ($request->getParameter('login',false)){
           $this->getUser()->setAttribute('referer_me',$request->getReferer());
        }
        if ($request->getParameter('slug')) {
            $this->company = Doctrine::getTable('Company')
                ->findOneBySlug($request->getParameter('slug'));

            $pageAdmin = $this->getUser()->getPageAdminUser();
            if (
                $pageAdmin &&
                $this->company &&
                $pageAdmin->getCompanyPage()->getCompany()->getId() == $this->company->getId()
            ) {
                $this->redirect('companySettings/basic?slug=' . $this->company->getSlug());
            }
        }

        $this->form = new $class(null, array('company' => $this->company));

        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('admin'));
            if ($this->form->isValid()) {
                $sfUser = $this->getUser();
                $userProfile = $sfUser->getProfile();

                $values = $this->form->getValues();
                $sfUser->signInPageAdmin(
                    $values['user'],
                    array_key_exists('remember', $values) ? $values['remember'] : false
                );
                // Set city after login
                if ($sfUser->getCountry()->getId() == $userProfile->getCountry()->getId()) {
                    $sfUser->setCity($userProfile->getCity());
                    $sfUser->setAttribute('user.set_city_after_login', true);
                }

                $redirect = $sfUser->getAttribute('referer_me');
                $sfUser->getAttributeHolder()->remove('referer_me');
                if (!$redirect) {
                    $redirect ='companySettings/basic?slug=' .
                        $sfUser->getPageAdminUser()->getCompanyPage()->getCompany()->getSlug();
                }

                $this->redirect($redirect);
            }

            if ($this->company) {
                $this->getUser()->setFlash('formerror', 'with_company');
                $this->redirect('userSettings/companySettings?slug=' . $this->company->getSlug());
            } else {
                $this->getUser()->setFlash('formerror', 'no_company');
                $this->redirect('userSettings/companySettings');
            }
        }
    }

    public function executeLogout()
    {

      $this->getUser()->signOutPageAdmin();
      $redirect = $this->getUser ()->getAttribute ( 'redirect_after_login' );
      $this->getUser ()->getAttributeHolder ()->remove ( 'redirect_after_login' );
      if ($redirect)
      {
        $this->redirect($redirect);
      }
      $this->redirect('@homepage');
    }

    public function executeChangePassword(sfWebRequest $request) {
      $this->configShow($request);
      $this->form = new ChangeAdminPasswordForm ( $this->adminuser);

      if ($request->isMethod ( 'post' )) {
        $this->form->bind ( $request->getParameter ( $this->form->getName () ) );

        if ($this->form->isValid ()) {
          $this->adminuser->setPassword ( $this->form->getValue ( 'new_password' ) );
          $this->adminuser->save ();
          $msg = array('user'=>$this->adminuser, 'object'=>'place_admin', 'action'=>changePassword, 'object_id'=>$this->adminuser->getId());
          $this->dispatcher->notify(new sfEvent($msg, 'user.write_log'));
          $this->getUser ()->setFlash ( 'notice', 'Your password was changed successfully.' );
          $this->redirect ( 'companySettings/changePassword?slug='.$this->company->getSlug() );
        }
      }
      $request->setParameter ( 'no_location', true );
      $this->getResponse ()->setTitle ( 'Change Plase Admin Password' );
    }

    public function executeUploadCover(sfWebRequest $request) {
      $this->configShow($request);
      $this->form = new ImageForm ();

      if ($request->isMethod ( 'post' )) {
        $this->form->bind ( $request->getParameter ( $this->form->getName () ), $request->getFiles ( $this->form->getName () ) );

        if ($this->form->isValid ()) {
          $photo = new Image ();
          $photo->setFile ( $this->form->getValue ( 'file' ) );
          $photo->setCaption ( $this->form->getValue ( 'caption' ) );
          $photo->setUserId ( $this->user->getId () );
          $photo->setStatus('approved');
          $photo->setType('company');
          $photo->save ();

          $company_image = new CompanyImage ();
          $company_image->setImageId ( $photo->getId () );
          $company_image->setCompanyId ( $this->company->getId () );
          $company_image->save ();

          if (! $this->company->getImageId ()) {
            $this->company->setImageId ( $photo->getId () );
            $this->company->save ();
          }

          list($img_width, $img_height) = getimagesize($photo->getFile ()->getDiskPath ());
          if ($img_width == '975' && $img_height=='300')
          {

            $this->redirect ( 'crop/setCoverImage?slug=' . $this->company->getSlug ().'&image_id='.$photo->getId() );
            //}

          }

          $this->redirect ( 'crop/placePhoto?image_id='. $photo->getId().'&slug='.$this->company->getSlug() );

          } else{
            if(myTools::isExceedingMaxPhpSize()){
              $this->getUser ()->setFlash ( 'error', 'File size limit is 4MB.Please reduce file size before submitting again.' );
            }
          }
      }
    }

    public function executeSetCoverPhoto(sfWebRequest $request) {
      $this->configShow($request);
      $query = Doctrine::getTable ( 'CoverImage' )->createQuery ( 'i' )->where ( 'i.company_id = '. $this->company->getId () )->andWhere ( 'i.id = '. $request->getParameter ( 'image_id' ) );

      $this->forward404Unless ( $image = $query->fetchOne () );

      $this->company->setCoverImageId ( $image->getId () );
      $this->company->save ();

      $this->redirect ( $request->getReferer () );
    }

    public function executeDeleteCoverImage(sfWebRequest $request) {
      $this->configShow($request);
      $query = Doctrine::getTable ( 'CoverImage' )->createQuery ( 'i' )->where ( 'i.company_id = ?', $this->company->getId () )->andWhere ( 'i.id = ?', $request->getParameter ( 'id' ) );

      $this->forward404Unless ( $cover_image = $query->fetchOne () );

      $cover_image->getCompany()->setUser( $this->getUser());
      $path_to_image = sfConfig::get('app_cover_photo_dir').$cover_image->getFilename();
      $cover_image->delete ();
      unlink($path_to_image);
      $this->getUser ()->setFlash ( 'notice', 'The photo was deleted successfully.' );

      $this->redirect ( $request->getReferer () );
    }

    public function executeSetLogo(sfWebRequest $request) {
      $this->configShow($request);
      $query = Doctrine::getTable ( 'Image' )->createQuery ( 'i' )->innerJoin ( 'i.CompanyImage ci' )->where ( 'ci.company_id = ?', $this->company->getId () )->andWhere ( 'i.id = ?', $request->getParameter ( 'id' ) );

      $this->forward404Unless ( $image = $query->fetchOne () );

      $this->company->setLogoImageId ( $image->getId () );
      $this->company->save ();

      $this->redirect ( $request->getReferer () );
    }

    public function executeDeleteLogo(sfWebRequest $request) {
      $this->configShow($request);
      $query = Doctrine::getTable ( 'Image' )->createQuery ( 'i' )->innerJoin ( 'i.CompanyImage ci' )->where ( 'ci.company_id = ?', $this->company->getId () )->andWhere ( 'i.id = ?', $request->getParameter ( 'id' ) );

      $this->forward404Unless ( $image = $query->fetchOne () );
      $this->company->setUser( $this->getUser());
      if ($this->company->getLogoImageId() == $image->getId())
      {
        $this->company->setLogoImageId(null);
        $this->company->save();
      }

      $this->getUser ()->setFlash ( 'notice', 'The photo was deleted successfully.' );

      $this->redirect ( $request->getReferer () );
    }

    public function executeConversations(sfWebRequest $request) {
        $this->configShow($request);
        $query = Doctrine::getTable ( 'Conversation' )
        ->createQuery ( 'c' )->innerJoin ( 'c.Message m' )
        ->innerJoin ( 'c.ToPage' )
        ->where ( 'c.page_from = ?',  $this->company->getCompanyPage()->getId () )
        ->orderBy ( 'm.is_read, m.created_at' );

        $this->converstaions = $query->execute ();
    }

    public function executeMenu(sfWebRequest $request) {
    	breadCrumb::getInstance()->removeRoot();
    	$this->configShow($request);
    	
    	$this->form = new MenuForm($this->company->getFirstMenu());

      if ($request->isMethod('post')) {

      	$params = $request->getParameter($this->form->getName()); 
      	// force current company
      	$params['company_id'] = $this->company->getId();


        $this->form->bind($params, $request->getFiles($this->form->getName()));

        if ($this->form->isValid()) {

          $file = $this->form->getValue('file');
          if ($file) {

          	$key = substr(md5(time()), 0, 5);
	        	$filename = 'menu_' .$key . '_' .$file->getOriginalName();

	        	$uploads_path = sfConfig::get('sf_upload_dir') . DIRECTORY_SEPARATOR . 'menus';

	        	if (!is_dir($uploads_path)) {
	        		if (!mkdir($uploads_path)) {
	        			throw new Exception("Could not create uploads directory: " . $uploads_path);
	        		}
	        	}

	        	$file->save($uploads_path . DIRECTORY_SEPARATOR . $filename);
	          
	      		// delete old menu
	      		if ($this->company->getFirstMenu()) {
	      			unlink($this->company->getFirstMenu()->getPath());
	      		}

	      		// save new filename
	          $menu = $this->form->save();
	          $menu->setFilename($filename);
	          $menu->save();
          } else {
          	$this->form->save();
          }

          $this->getUser()->setFlash('notice', 'The changes were saved successfully.');
          
          $this->redirect($request->getReferer());

      	} 
      }
    }
    public function executeDeleteMenu(sfWebRequest $request) {
		$this->menu = Doctrine::getTable ( 'menu' )->find ( $request->getParameter ( 'id' ) );
		$this->menu->delete ();
                unlink($this->menu->getPath());
		$this->getUser()->setFlash('notice', 'The current file has been successfully deleted.');
		$this->redirect($request->getReferer());
	}
}