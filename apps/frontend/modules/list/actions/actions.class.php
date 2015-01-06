<?php

/**
 * list actions.
 *
 * @package    getLokal
 * @subpackage list
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class listActions extends sfActions
{
  public function preExecute()
    {

		$this->is_place_admin_logged = false;
		$this->user = $this->getUser ()->getGuardUser ();
		if ($this->getUser ()->getPageAdminUser ()) {
			$this->is_place_admin_logged = true;
		}

    }
  public function executeIndex(sfWebRequest $request)
  {
      if (getlokalPartner::getInstanceDomain() == 78) {
          $query = Doctrine_Core::getTable('Lists')
                      ->createQuery('l')
                      ->innerJoin('l.Translation lt')
                      ->leftJoin('l.ListPage lp')
                      ->leftJoin('l.UserProfile ul')
                      ->leftJoin('lp.CompanyPage cp')
                      ->innerJoin('cp.Company c ')
                      ->innerJoin('c.City ct')
                      ->innerJoin('ct.County cty')
                      //->whereIn($this->getUser()->getCity()->getId(),'(SELECT id FROM city)' )
                      ->where('cty.id = ?', $this->getUser()->getCounty()->getId())
                      ->addWhere('l.status = ?','approved')
                      ->andWhere('c.status = ? ', CompanyTable::VISIBLE)
                      ->addWhere('lp.list_id IN (SELECT id FROM ListPage GROUP BY list_id HAVING count(id) > 2)')
                      ->orderBy('lp.id DESC');
                      //->execute();
      }
      else {
          $query = Doctrine_Core::getTable('Lists')
                      ->createQuery('l')
                      ->innerJoin('l.Translation lt')
                      ->leftJoin('l.ListPage lp')
                      ->leftJoin('l.UserProfile ul')
                      ->leftJoin('lp.CompanyPage cp')
                      ->innerJoin('cp.Company c ')
                      ->innerJoin('c.City ct')
                      //->whereIn($this->getUser()->getCity()->getId(),'(SELECT id FROM city)' )
                      ->where('ct.id = ?', $this->getUser()->getCity()->getId())
                      ->addWhere('l.status = ?','approved')
                      ->andWhere('c.status = ? ', CompanyTable::VISIBLE)
                      ->addWhere('lp.list_id IN (SELECT id FROM ListPage GROUP BY list_id HAVING count(id) > 2)')
                      ->orderBy('lp.id DESC');
                      //->execute();
      }
      
    $this->user = $this->getUser ()->getGuardUser();

   	$this->pager = new sfDoctrinePager ( 'Lists', Review::FRONTEND_REVIEWS_PER_PAGE );
    $this->pager->setQuery($query);
    $this->pager->setPage ( $request->getParameter('page', 1) );
    $this->pager->init ();

    breadCrumb::getInstance ()->add ( 'Lists', 'list/index');

    $this->video = Doctrine::getTable('getWeekend')
    ->createQuery('g')
    ->limit(1)
    ->where('g.country_id = ?', sfContext::getInstance()->getUser()->getCountry()->getId())
    ->orderBy('g.aired_on DESC')
    ->fetchOne();

  }

  public function executeShow(sfWebRequest $request)
  {
  	
    $this->user = $this->getUser()->getGuardUser();
    $listCriteria = Doctrine_Query::create()
            ->select('l.id')
            ->from('Lists l')
            ->innerJoin('l.Translation')
          //  ->leftJoin('l.Image il')
            ->leftJoin('l.ListPage lp')
         /*   ->leftJoin('lp.CompanyPage cp')
            ->leftJoin('cp.Company c ')
            ->leftJoin('c.City ct')
            ->leftJoin('c.CompanyLocation ccl')
            ->leftJoin('c.Location cl')
            ->leftJoin('c.Classification ca')
            ->leftJoin('c.Sector s')
            ->leftJoin('c.Image ic')
            ->leftJoin('s.Translation')
            ->leftJoin('ca.Translation')
            ->leftJoin('c.TopReview tr')
            ->leftJoin('c.Review r WITH r.user_id=l.user_id')
            ->leftJoin('tr.UserProfile utr')
            ->leftJoin('r.UserProfile ur')
            ->leftJoin('lp.UserProfile ulp')
            ->leftJoin('utr.sfGuardUser str')
            ->leftJoin('ur.sfGuardUser sr')
        */    ->where('l.id = ?', $request->getParameter('id'))
            ->addWhere('l.status = ?','approved')
            ->orderBy('lp.rank ASC')
            ->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR)
            ->fetchOne();

    $this->list = Doctrine_Core::getTable('Lists')
      ->createQuery('l')
      ->whereIn('l.id', $listCriteria ? $listCriteria : array(0))
      ->fetchOne();
    
    $this->forward404Unless($this->list);
    $this->getResponse ()->setTitle ($this->list->getTitle());
    $this->form = new ListsForm($this->list);
    $this->login_form = new sfGuardFormSignin ( );
    $this->formRegister = new OldRegisterForm(null, array('city_is_mandatory' => true));
    
    
       
    breadCrumb::getInstance ()->add ( 'Lists', 'list/index');
    breadCrumb::getInstance ()->add ( $this->list->getTitle() );

    
	$this->pager = $this->_getListPager($request);
  }
  
  public function executeGetListPage(sfWebRequest $request){
	$pager = $this->_getListPager($request);
	$user = $this->getUser()->getGuardUser();
	
  	$options = array( //'places' => $pages,
  			'pager' => $pager,
  			'culture'=>sfContext::getInstance()->getUser()->getCulture(),
  			'user'=>$user,
  			'listId'=>$request->getParameter("id"),
  			'is_place_admin_logged'=>$this->is_place_admin_logged
  	);
  	$html = $this->getPartial('places_pager',$options); 
  	echo $html;
    return sfView::NONE;
  }
  
  protected function _getListPager(sfWebRequest $request){
  	$queryCriteria = Doctrine_Query::create()
  	->select('lp.id')
  	->from('ListPage lp')
  	->leftJoin('lp.Lists l')
  	//        ->innerJoin('l.Translation')
  	->leftJoin('lp.CompanyPage cp')
  	->leftJoin('cp.Company c ')
  	/*        ->leftJoin('c.City ct')
  	 ->leftJoin('c.CompanyLocation ccl')
  	->leftJoin('c.Location cl')
  	->leftJoin('c.Classification ca')
  	->leftJoin('c.Sector s')
  	->leftJoin('c.Image ic')
  	->leftJoin('s.Translation')
  	->leftJoin('ca.Translation')
  	->leftJoin('c.TopReview tr')
  	->leftJoin('c.Review r WITH r.user_id=l.user_id')
  	->leftJoin('tr.UserProfile utr')
  	->leftJoin('r.UserProfile ur')
  	->leftJoin('lp.UserProfile ulp')
  	->leftJoin('utr.sfGuardUser str')
  	->leftJoin('ur.sfGuardUser sr')
  	*/      ->where('l.id = ?', $request->getParameter('id'))
  	->addWhere('l.status = ?','approved')
  	->andWhere('c.status = ? ', CompanyTable::VISIBLE)
  	->orderBy('lp.rank ASC')
  	->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR)
  	->execute();
  	
  	$query = Doctrine_Core::getTable('ListPage')
  	->createQuery('lp')
  	->whereIn('lp.id', $queryCriteria ? $queryCriteria : array(0));
  	
  	
  	$pager = new sfDoctrinePager('ListPage', Lists::FRONTEND_LISTS_PER_TAB);
  	$pager->setQuery($query);
  	$pager->setPage($request->getParameter('page', 1));
  	$pager->init();
  	return $pager;
  }


  public function executePlacesPager(sfWebRequest $request)
  {



      $query = Doctrine_Core::getTable('ListPage')
      ->createQuery('lp')
      ->leftJoin('lp.Lists l')
      ->innerJoin('l.Translation')
      //->leftJoin('l.Image il')
      //->leftJoin('l.ListPage lp')
      ->leftJoin('lp.CompanyPage cp')
      ->leftJoin('cp.Company c ')
      ->leftJoin('c.City ct')
      ->leftJoin('c.CompanyLocation ccl')
      ->leftJoin('c.Location cl')
      ->leftJoin('c.Classification ca')
      ->leftJoin('c.Sector s')
      ->leftJoin('c.Image ic')
      ->leftJoin('s.Translation')
      ->leftJoin('ca.Translation')
      ->leftJoin('c.TopReview tr')
      ->leftJoin('c.Review r WITH r.user_id=l.user_id')
      ->leftJoin('tr.UserProfile utr')
      ->leftJoin('r.UserProfile ur')
      ->leftJoin('lp.UserProfile ulp')
      ->leftJoin('utr.sfGuardUser str')
      ->leftJoin('ur.sfGuardUser sr')
      //->leftJoin('ulp.sfGuardUser slp')
      //->leftJoin('ct.County co')
      ->where('l.id = ?', $request->getParameter('id'))
      ->addWhere('l.status = ?','approved')
      ->andWhere('c.status = ? ', CompanyTable::VISIBLE)
      ->orderBy('lp.rank ASC');
	
      $FRONTEND_LISTS_PER_TAB=Lists::FRONTEND_LISTS_PER_TAB;
      if ($request->getParameter('nPages') ) 
      	$FRONTEND_LISTS_PER_TAB=$request->getParameter('nPages');
            
      $this->pager = new sfDoctrinePager('ListPage', $FRONTEND_LISTS_PER_TAB);
	  $this->pager->setQuery($query);
	  $this->pager->setPage($request->getParameter('page', 1));
	  $this->pager->init();

	  $this->listId = $request->getParameter('id');
	  $this->listUserId = $request->getParameter('listUserId');
  }

  public function executeCreate(sfWebRequest $request)
  {

  	if ($this->is_place_admin_logged)
  	{
  		$this->redirect('list/noAccess?r=create');
  	}
  	
    $this->form = new ListsForm();
    if(myTools::isExceedingMaxPhpSize()){
    	$this->form['file']->setError(new sfValidatorError($this->form->getValidator("file"),"max_size"));
    }else{
		if ($request->isMethod(sfRequest::POST)){
	    	$this->processForm($request, $this->form);
		}
    }

    $this->setTemplate('new');
  }

  public function executeAddToNew(sfWebRequest $request)
  {
  	$this->user = $this->getUser()->getGuardUser();
  	
  	$this->company = Doctrine::getTable ( 'Company' )
  		->createQuery ( 'c' )
  		->where ( 'c.id = ?', $request->getParameter ( 'company_id' ) )
  		->fetchOne();
  	
  	
  	$this->form = new ListsForm();
  	if ($request->isMethod(sfRequest::POST)){
  		$this->processForm($request, $this->form);
  	}
  
  	//$this->setTemplate('addToNew');
  }
  public function executeEdit(sfWebRequest $request)
  {
  	//print_r($request->getParameter('id'));exit();
  	if ($this->is_place_admin_logged)
  	{
  		$this->redirect('list/noAccess?r=edit&id='.$request->getParameter('id'));
  	}
  	$this->user = $this->getUser()->getGuardUser();
  	$this->list = Doctrine_Core::getTable('Lists')
      ->createQuery('l')
      ->innerJoin('l.Translation')
      ->leftJoin('l.Image il')
      ->leftJoin('l.ListPage lp')
      ->leftJoin('lp.CompanyPage cp')
      ->leftJoin('cp.Company c ')
      ->leftJoin('c.City ct')
      ->leftJoin('c.CompanyLocation ccl')
      ->leftJoin('c.Location cl')
      ->leftJoin('c.Classification ca')
      ->leftJoin('c.Sector s')
      ->leftJoin('c.Image ic')
      ->leftJoin('s.Translation')
      ->leftJoin('ca.Translation')
      ->leftJoin('c.TopReview tr')
      ->leftJoin('c.Review r WITH r.user_id=l.user_id')
      ->leftJoin('tr.UserProfile utr')
      ->leftJoin('r.UserProfile ur')
      ->leftJoin('lp.UserProfile ulp')
      ->leftJoin('utr.sfGuardUser str')
      ->leftJoin('ur.sfGuardUser sr')
      //->innerJoin('ct.County co')
      ->where('l.id = ?', $request->getParameter('id'))
      //->andWhere('c.status = ? ', CompanyTable::VISIBLE)
      ->orderBy('lp.rank ASC')
      ->fetchOne();


    $this->forward404Unless($this->list , sprintf('Object lists does not exist (%s).', $request->getParameter('id')));
    $this->forward404Unless($this->list->getUserId() == $this->getUser()->getId() , sprintf('Object lists does not exist (%s).', $request->getParameter('id')));
    	$this->form = new ListsForm($this->list);
    if ($request->isMethod(sfRequest::POST)){
    	 $this->processForm($request, $this->form);
    }
  }

  public function executeDelete(sfWebRequest $request)
  {
    //$request->checkCSRFProtection();

    $this->forward404Unless($lists = Doctrine_Core::getTable('Lists')->find(array($request->getParameter('id'))), sprintf('Object lists does not exist (%s).', $request->getParameter('id')));
    $this->forward404Unless($this->user->getId()==$lists->getUserId());
    $lists->delete();

    $this->redirect('list/index');
  }

	protected function clearInputAndJsCall($string) {
      $pattern = '@<\s*input\s+type="hidden"\s+id="gwProxy"\s*>.+?<\s*/\s*div\s*>@is';
      $stringa = preg_replace ( $pattern, "", $string );
      return $stringa;
    }

    protected function processForm(sfWebRequest $request, sfForm $form)
    {
      if ($this->is_place_admin_logged)
      {
    	$this->redirect('list/noAccess');
      }
      $params = $request->getParameter ( $form->getName (), array () );
      $this->user = $this->getUser()->getGuardUser();
      $params['user_id']=$this->user->getId() ;
      $errora = false;

      //$langClass = mb_strtolower ( getlokalPartner::getLanguageClass () );
      $langClass = $this->getUser()->getCountry()->getSlug();
      
      $params [$langClass] ['description']=trim($params [$langClass] ['description']);
      $params ['en'] ['description']= trim($params ['en'] ['description']);
      $params [$langClass] ['title']=trim($params [$langClass] ['title']);
      $params ['en'] ['title']=trim($params ['en'] ['title']);
      
      if (isset ( $params [$langClass] ['description'] )) {
        $params [$langClass] ['description'] = $this->clearInputAndJsCall ( $params [$langClass] ['description'] );
      }
      if (isset ( $params ['en'] ['description'] )) {
        $params ['en'] ['description'] = $this->clearInputAndJsCall ( $params ['en'] ['description'] );
      }
      if (! isset ( $params [$langClass] ['title'] ) or ($params [$langClass] ['title']) == '') {
        if (! isset ( $params ['en'] ['title'] ) or ($params ['en'] ['title']) == '') {

          $errora = true;
        } else {
          if (! isset ( $params ['en'] ['description'] ) or ($params ['en'] ['description']) == '') {

            $errora = true;
          } else {
            if (! isset ( $params [$langClass] ['description'] ) or ($params [$langClass] ['description']) == '') {
              $params [$langClass] ['description'] = $params ['en'] ['description'];
            }
            $params [$langClass] ['title'] = $params ['en'] ['title'];
          }
        }
      } else {
        if (! isset ( $params [$langClass] ['description'] ) or ($params [$langClass] ['description']) == '') {
          $errora = true;

        }else {
          if (! isset ( $params ['en'] ['title'] ) or ($params ['en'] ['title']) == '') {

            $params ['en'] ['title'] = $params [$langClass] ['title'];
          }
          if (! isset ( $params ['en'] ['description'] ) or ($params ['en'] ['description']) == '') {

            $params ['en'] ['description'] = $params [$langClass] ['description'];
          }


        }
      }

      $file = $request->getFiles($form->getName());
      $form->bind($params, $file);
	  //print_r($params);exit();
      if ($form->isValid() && $errora == false)
      {
        //$this->form->setValue();
        //print_r($this->form->getValues());exit();

      	$isNew = true;
      	if (!$form->getObject()->isNew()) $isNew = false;

      	$list = $form->updateObject();
        $list->setUserId($this->user->getId());
        $list->save();
        if($form->getValue('file')){
      		if ( $list->getImageId ()) {

      			$list->setImageId(NULL);
			    $list->save();

      			Doctrine::getTable('Image')
			        ->createQuery('i')
			        ->delete()
			        ->where('i.id = ?', $list->getImageId())
			        ->execute();

      		}
      	  $photo = new Image();
          $photo->setFile($this->form->getValue('file'));
          $photo->setCaption($this->form->getValue('caption'));
          $photo->setUserId($this->user->getId());
          //if($this->form->getValue('poster')==1) $photo->setType('poster');
          $photo->save();
/*
          $list_image = new ListImage();
          $list_image->setImageId($photo->getId());
          $list_image->setListId($list->getId());
          $list_image->save();
*/
          if (! $list->getImageId ()) {
            $list->setImageId ( $photo->getId () );
            $list->save ();
          }
        }
		
        if (isset($params['company_page'])){
        	$listpage= new ListPage();
        	$listpage->setListId($list->getId());
        	$listpage->setPageId($params['company_page']);
        	$listpage->setUserId($this->user->getId());
        	$listpage->save();
        }
        
        $this->getUser ()->setFlash ( 'notice', 'List was successfully created.' );

        if ( !$isNew ) {
        	$this->getUser ()->setFlash ( 'notice', 'Your list was successfully updated!' );
        	$this->redirect('list/show?id='.$list->getId());
        }
        
        
        $empty = Doctrine_Query::create()
                ->delete()
                ->from('ListsTranslation')
                ->Where('id = ?', $list->getId())
                ->andWhere('title IS NULL OR title =""')
                ->andWhere('description IS NULL OR description=""')
                ->execute();

        $this->redirect('list/edit?id='.$list->getId());

      }

      if ($errora == true) {
        $this->getUser ()->setFlash ( 'newerror', 'The list Title and Description are required for at least one of the two language versions.' );

      } else {
        $this->getUser ()->setFlash ( 'newerror', 'The list was not saved. Please fill in all required fields.' );
      }
    }

    public function executeGetPage(sfWebRequest $request) {

      $this->cityId = $request->getParameter ( 'cityId' );
      $this->placeStr = trim ( $request->getParameter ( 'place', null ) );
      $this->culture = $this->getUser ()->getCulture ();

      $this->listId=null;
      if ($request->getParameter ( 'listId' )){
        $this->listId = $request->getParameter ( 'listId' );
        //$event = Doctrine_Core::getTable('Event')->find(array($request->getParameter ( 'eventId' )));
      }
      if ( !$request->getParameter ( 'page' )) $page=1;
      $page=$request->getParameter ( 'page' );
      $this->placePager = Page::getPagerForListSearchByTitle ($this->placeStr, $this->cityId, $page, $listId=$this->listId);

    }

    public function executeAddPageToList(sfWebRequest $request) {

      $this->placeId = $request->getParameter ( 'placeId' );
      $this->listId = $request->getParameter ( 'listId' );
      $this->userId = $this->getUser ()->getId();
      $this->culture = $this->getUser ()->getCulture ();
      //$userId = $request->getParameter ( 'userId', null );

      //if ($this->placeId && $this->listId  && $this->userId) {
	      $addListPage = new ListPage();
	      $addListPage->setListId($this->listId);
	      $addListPage->setPageId($this->placeId);
	      $addListPage->setUserId($this->userId);
	      $addListPage->save();
	      $this->place = $addListPage;
	      //if ($item && !$uList->getIsActive()){ $uList->setIsActive(1);$uList->save();}
      //}
    }
    public function executeAddToList(sfWebRequest $request) {
    	$error = false;

    	$this->place_id = $request->getParameter ( 'page_id' );
    	$this->list_id = $request->getParameter ( 'list_id' );
    	$this->user_id = $this->getUser()->getId();
    	//$this->culture = $this->getUser ()->getCulture ();
    	//$userId = $request->getParameter ( 'userId', null );
    	 
    	if ($this->place_id && $this->list_id  && $this->user_id) {
    		$addListPage = new ListPage();
    		$addListPage->setListId($this->list_id);
    		$addListPage->setPageId($this->place_id);
    		$addListPage->setUserId($this->user_id);
    		$addListPage->save();
    	
    	}

    		
    	if ($error) {
			return $this->renderText(json_encode(array('error' => true)));
    	}
    	else {
    		return $this->renderText(json_encode(array('error' => false)));
    	}
    	
    	die();

    }
	public function executeDelPageFromList(sfWebRequest $request) {

      $listPageId = $request->getParameter ( 'listPageId' );
      Doctrine::getTable('ListPage')
        ->createQuery('lp')
        ->delete()
        ->where('lp.id = ?', $listPageId)
        ->execute();
    }

	public function executeOrder(sfWebRequest $request)
    {
        $ids = $request->getParameter('item', array());
        $i = 0;

        foreach ($ids as $id) {
                $i += 1;
                $item = Doctrine_Core::getTable('ListPage')->find($id);
                $item->setRank($i);
                $item->save(null, false);
        }

        if ($i !== 0)
            return sfView::SUCCESS;
        else
            return sfView::ERROR;
    }


    public function executeRegisterPost(sfWebRequest $request) {
      $this->formRegister = new OldRegisterForm (null, array('city_is_mandatory' => true));
    }
    public function executeLoginPost(sfWebRequest $request) {
      $this->formLogin = new sfGuardFormSignin ( );
    }

    public function executeReview(sfWebRequest $request) {
      $this->form = new ReviewForm ();
      $this->formRegister = new OldRegisterForm(null, array('city_is_mandatory' => true));
      $this->formLogin = new sfGuardFormSignin ();
      $this->placeId = $request->getParameter('place_id');
	  $this->place = Doctrine::getTable('Company')->findOneById( $this->placeId);
	  $this->place->setUser($this->getUser());
	  $this->listId = $request->getParameter('list_id');
     if ($request->isMethod ( 'post' )) {

        $params= $request->getParameter ( $this->formLogin->getName () );
/*
        if ( isset ($params['facebook']) ){
            $this->form->bind ( $request->getParameter ( $this->form->getName () ) );
            if ($this->form->isValid ()) {
                    $review = $this->form->updateObject ();
                    $this->getUser ()->setReferer ( $request->getReferer () );
                    $this->getUser ()->setAttribute ( 'review', $review->getText () );
                    $this->getUser ()->setAttribute ( 'review_rating', $review->getRating () );
                $this->FBlogin($request);
                $this->user = $this->getUser ()->getGuardUser ();
            }else{
                $this->getUser ()->setFlash ( 'error', 'Your review was not published successfully.' );
            }
        }
        else
*/
        if ($request->getParameter ( $this->formLogin->getName () )){
          $this->formLogin->bind ( $request->getParameter ( $this->formLogin->getName () ) );
          if ($this->formLogin->isValid ()) {
            $values = $this->formLogin->getValues ();
            $this->getUser ()->signin ( $values ['user'], array_key_exists ( 'remember', $values ) ? $values ['remember'] : false );

        // Set city after login
        if ($this->getUser()->getCountry()->getId() == $this->getUser()->getProfile()->getCountry()->getId()) {                                    
            $this->getUser()->setCity($this->getUser()->getProfile()->getCity());
            $this->getUser()->setAttribute('user.set_city_after_login', true);
        }

            $this->user = $this->getUser ()->getGuardUser ();
          }
        }elseif ($request->getParameter ( $this->formRegister->getName () )){

          $this->formRegister->bind ( $request->getParameter ( $this->formRegister->getName () ) );

          if ($this->formRegister->isValid ()) {
            $con = Doctrine::getConnectionByTableName ( 'sfGuardUser' );
            $params = $request->getParameter ( $this->formRegister->getName () );

            $profile = $this->formRegister->updateObject ();

            if ($profile->getCountryId() > 4 && $profile->getCountryId() != 78) {
                $profile->setCityId(NULL);
            }

            $activation_hash = md5 ( rand ( 100000, 999999 ) );
            $profile->setHash ( $activation_hash );
            $user_register = $this->formRegister->getEmbeddedForm ( 'sf_guard_user' )->getObject ();
            $user_register->setUsername ( substr ( uniqid ( md5 ( rand () ), true ), 0, 8 ) );
            $user_register->setIsActive ( true );
            $profile->setSfGuardUser ( $user_register );

            try {
              $con->beginTransaction ();
              // OLD
              //$profile->setCountryId(getlokalPartner::getInstance());

              if (isset($params['gender']) && $params['gender']) {
                  $profile->setGender($params['gender']);
              }

              $profile->save ();
              $user_settings = new UserSetting ( );
              $user_settings->setId ( $profile->getId () );

             
              if (!isset($params ['allow_contact'])) {
                  $user_settings->setAllowContact(false);
                  $user_settings->setAllowNewsletter(false);
              } else {
                  $user_settings->setAllowContact(true);
                  $user_settings->setAllowNewsletter(true);
                  $user_settings->setAllowPromo(true);
              }

              if (!isset($params ['underage'])) {
                  $user_settings->setUnderage(false);
              } else {
                  $user_settings->setUnderage(true);
              }

              $user_settings->save ();

            // Subscribe to newsletter
            $newsletters = NewsletterTable::retrieveActivePerCountryForUser($profile->getCountryId());
            if ($newsletters) {
                foreach ($newsletters as $newsletter) {
                    $usernewsletter = new NewsletterUser ();
                    $usernewsletter->setNewsletterId($newsletter->getId());
                    $usernewsletter->setUserId($profile->getId());
                    $usernewsletter->setIsActive($user_settings->getAllowContact());
                    $usernewsletter->save();
                }

//                MC::subscribe_unsubscribe($this->getUser()->getGuardUser()); 
                MC::subscribe_unsubscribe($user_register);
           }

              $user_register = $profile->getSfGuardUser ();
              $this->__associatedFriends($profile);
              
              //$user_register->addDefaultPermissionsAndGroups ( array ('user' ), array () );
              $con->commit ();
            } catch ( Exception $e ) {
              $con->rollback ();

              $this->getUser ()->setFlash ( 'error', 'We were unable to send a confirmation request to the email address that you provided. Please check the email you provided is correct.' );
              return sfView::SUCCESS;
            }

            $this->getUser()->signIn($user_register);
            $this->user = $this->getUser()->getGuardUser();

            $culture = $this->getUser ()->getCulture ();

            myTools::sendMail ( $user_register, 'Welcome to getlokal', 'activation' , array('user' => $user_register));
            $i18n = sfContext::getInstance()->getI18N();
            $this->getUser()->setAttribute('home.notice',
            $i18n->__('<p class="part_one"><span class="greet">Congrats</span> you are our newest registered user.</p><p class="part_two"> Now you can tell everyone about the great places only you know!</p>',null,'user'));
          
            //$this->redirect ( '@sf_guard_signin' );
          }
        }
        //$this->forwardUnless($this->getUser()->isAuthenticated(), 'user', 'signin');

      $this->form->bind ( $request->getParameter ( $this->form->getName () ) );

        if ($this->form->isValid () && ($this->getUser ()->isAuthenticated () || isset ( $user_register ))) {
          if($this->user->getUserProfile()->getIsCompanyAdmin ( $this->place ) ){ 
              $this->getUser ()->setFlash ( 'error', 'You are already an administrator for this place and cannot write reviews for it but only reply to reviews by other users about your place.' );
              $this->redirect ( 'list/show?id='.$this->listId );
          }
          else{
//              if ($this->form->isValid () && ( $this->getUser()->isAuthenticated() || isset($user_register) ) ) {
                  $review = $this->form->updateObject ();
                        
                  if (isset($user_register)){
                    $review->setUserId ( $user_register->getId () );
                  }
                  else {
                      $review->setUserId ( $this->getUser()->getId () );
                  }
                  $review->setCompany ( $this->place );
                  $review->save ();

                  $this->getUser()->setFlash('notice','Your review was published successfully.');
                  $this->redirect ( 'list/show?id='.$this->listId );
//              }
//              $this->getUser()->setFlash('error','Your review was not published successfully.');
//              $this->redirect ( 'list/show?id='.$this->listId );
          }
        }
        else {
          $this->getUser ()->setFlash ( 'error', 'Your review was not published successfully.' );
          $this->redirect ( 'list/show?id='.$this->listId );
        }
      }
    }

/*
 * OLD
    protected function FBLogin(sfWebRequest $request)
    {
      $app_id = "289748011093022";
      $app_secret = "517d65d2648bf350bb303914cb0ec664";
      $my_url = $this->generateUrl ( 'default', array ('module' => 'user', 'action' => 'FBLogin' ), true );

      $code = $request->getParameter ( 'code' );

      if (empty ( $code )) {
        $dialog_url = "http://www.facebook.com/dialog/oauth?client_id=" . $app_id . "&redirect_uri=" . urlencode ( $my_url ) . '&scope=user_location,email,user_birthday,offline_access,user_checkins';

        $this->redirect ( $dialog_url );
      }

      $token_url = "https://graph.facebook.com/oauth/access_token?client_id=" . $app_id . "&redirect_uri=" . urlencode ( $my_url ) . "&client_secret=" . $app_secret . "&code=" . $code;

      $ch = curl_init ();
      curl_setopt ( $ch, CURLOPT_URL, $token_url );
      curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, true );
      curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
      curl_setopt ( $ch, CURLOPT_AUTOREFERER, true );
      curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false ); # required for https urls

      $access_token = curl_exec ( $ch );

      curl_setopt ( $ch, CURLOPT_URL, "https://graph.facebook.com/me?" . $access_token );

      $user_data = json_decode ( curl_exec ( $ch ), true );
      if (isset($user_data ['id']) && $user_data ['id'] )
        {
		  $profile = Doctrine::getTable ( 'UserProfile' )->findOneByFacebookUid ( $user_data ['id'] );
        }

      if (! $profile) {
        if (! $user = Doctrine::getTable ( 'sfGuardUser' )->findOneByEmailAddress ( $user_data ['email'] )) {
          curl_setopt ( $ch, CURLOPT_URL, "https://graph.facebook.com/me/picture?type=large&" . $access_token );

          $temp_pic = sfConfig::get ( 'sf_upload_dir' ) . '/' . uniqid ( 'tmp_' ) . '.jpg';
          file_put_contents ( $temp_pic, curl_exec ( $ch ) );

          $file = new sfValidatedFile ( myTools::cleanUrl ( $user_data ['name'] ) . '.jpg', filetype ( $temp_pic ), $temp_pic, filesize ( $temp_pic ) );

          $password = $this->generatePassword ();

          $user = new sfGuardUser ( );
          $user->setEmailAddress ( $user_data ['email'] );
          $user->setUsername ( substr ( uniqid ( md5 ( rand () ), true ), 0, 8 ) );
          $user->setFirstName ( $user_data ['first_name'] );
          $user->setLastName ( $user_data ['last_name'] );
          $user->setPassword ( $password );
          $user->save ();

          $date = DateTime::createFromFormat ( 'm/d/Y', $user_data ['birthday'] );
          
          $fbUserCity = array_shift(explode(',', $user_data['location']['name']));

          $city = Doctrine::getTable ( 'City' )
                   ->createQuery ( 'c' )
                   ->innerJoin ( 'c.County co' )
                   ->addWhere ( 'co.country_id = ?', getlokalPartner::getInstance() )
                   ->andWhere ( 'c.name LIKE ? or c.slug LIKE ? OR c.name_en', array($fbUserCity, $fbUserCity, $fbUserCity))
                   ->fetchOne ();


          $profile = new UserProfile ( );
          if ($city) {
            $profile->setCityId ( $city->getId () );
            $country_id = $city->getCounty()->getCountryId();
            $profile->setCountryId($country_id);
          }else {
            $profile->setCountryId ( getlokalPartner::getInstance() );
            $city = Doctrine::getTable('City')
              ->createQuery('c')
              ->innerJoin('c.County co')
              ->where('co.country_id = ?', getlokalPartner::getInstance())
              ->orderBy('c.is_default DESC')
              ->limit(1)
              ->fetchOne();
            $profile->setCityId ( $city->getId () );
          }
          $profile->setId ( $user->getId () );
          $profile->setGender ( $user_data ['gender'] == 'male' ? 'm' : 'f' );
          $profile->setBirthDate ( $date->format ( 'Y-m-d' ) );
          $profile->setFacebookUrl ( $user_data ['link'] );
          $profile->save ();

          $image = new Image ( );
          $image->setFile ( $file );
          $image->setUserId ( $profile->getId () );
          $image->setCaption ( $user_data ['name'] );
          $image->save ();

          $profile->clearRelated ();
          $profile->setImageId ( $image->getId () );
          $profile->save ();

          @unlink ( $temp_pic );

          myTools::sendMail ( $user, 'Welcome to getlokal', 'fbRegister' );
        } else {
          $profile = $user->getUserProfile ();
        }
        if(!$profile->getCityId()) $profile->setCityId($this->getUser()->getCity()->getId());
        if(!$profile->getCountryId()) $profile->setCountryId($this->getUser()->getCountry()->getId());
        if(!$profile->getFacebookUid ()) $profile->setFacebookUid ( $user_data ['id'] );
        
        $profile->setAccessToken ( $access_token );
        $profile->save ();
      }

      $this->getUser ()->signIn ( $profile->getSfGuardUser (), true );
      //$this->redirect ( '@homepage' );
    }
*/

    protected function generatePassword() {
      $salt = "abchefghjkmnpqrstuvwxyz0123456789";
      $pass = '';
      srand ( ( double ) microtime () * 1000000 );
      $i = 0;
      while ( $i <= 7 ) {
        $num = rand () % 33;
        $tmp = substr ( $salt, $num, 1 );
        $pass = $pass . $tmp;
        $i ++;
      }

    }

public function executeComments(sfWebRequest $request)
    {

      $this->list = Doctrine_Core::getTable('Lists')->find(array($request->getParameter('list_id')));
    }



    private function __getPoints($hash = null, $email = null, $facebookUID = null) {
        if (!$hash) return 0;

        $query = Doctrine::getTable('InvitedUser')
                ->createQuery('iu')
                ->where('iu.hash = ?', array($hash));

        if ($email) {
            $query->andWhere('iu.email = ?', array($email));
        }
        elseif ($facebookUID) {
            $query->andWhere('iu.email = ?', array($facebookUID));
        }

        $result = $query->fetchOne(array(), Doctrine_Core::HYDRATE_RECORD);
        if ($result) {
            return $result->getPointsToInvited();
        }
    }

    public function __associatedFriends($invitedUser) {
        if ($code = $this->getUser()->getAttribute('code', false)) {
            //$invitedUserTable = Doctrine::getTable('InvitedUser')->findOneByHash($code);

            $email = $invitedUser->getSfGuardUser()->getEmailAddress();
            $facebookUID = $invitedUser->getFacebookUid();
            $invitedUserTable = Doctrine::getTable('InvitedUser')
                    ->createQuery('iu')
                    ->where('iu.hash = ?', $code)
                    ->andWhere('iu.email = ? or iu.facebook_uid = ?', array($email, $facebookUID))
                    ->fetchOne();

            if ($invitedUserTable && $userWhoSentInvite = Doctrine::getTable('UserProfile')->findOneById($invitedUserTable->getUserId())) {
                $points = $userWhoSentInvite->getPoints() + $invitedUserTable->getPointsToUser();
                $userWhoSentInvite->setPoints($points);
                $userWhoSentInvite->save();
            }

            $pointsToInvited = 0;
            if ($invitedUserTable) {
                $pointsToInvited = $invitedUserTable->getPointsToInvited();
            }

            $points = $invitedUser->getPoints() + $pointsToInvited;
            $invitedUser->setPoints($points);
            $invitedUser->save();

            $friendList = new friendList();
            $friendList->setUserId1($userWhoSentInvite->getId());
            $friendList->setUserId2($invitedUser->getId());

            $friendList->save();

            // Delete current record
            // Deprecated after new specification
            //$invitedUserTable->delete();

            $this->getUser()->setAttribute('code', null);
        }
        else {
            // Set relation by e-mail of fb
            $email = $invitedUser->getSfGuardUser()->getEmailAddress();
            $facebookUID = $invitedUser->getFacebookUid();
            $query = Doctrine::getTable('InvitedUser')
                    ->createQuery('iu')
                    ->where('iu.email = ?', $email)
                    ->orWhere('iu.facebook_uid = ?', $facebookUID);

            if ($friends = $query->execute()) {
                foreach ($friends as $friend) {
                    $friendList = new friendList();
                    $friendList->setUserId1($invitedUser->getId());
                    $friendList->setUserId2($friend->getUserId());
                    $friendList->save();

                    // Deprecated after new specification
                    //$friend->delete();
                }
            }
        }
    }
    
    public function executeNoAccess(sfWebRequest $request) {
    	$this->r = $request->getParameter('r');
    	if ($request->getParameter('id')) $this->id = $request->getParameter('id');
    }
}
