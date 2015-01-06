<?php

  /**
  * event actions.
  *
  * @package    getLokal
  * @subpackage event
  * @author     Get Lokal
  * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
  */
  class eventActions extends sfActions
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
    	$this->executeRecommended($request);
		return;

      $this->categories = Doctrine_Core::getTable('Category')
      ->createQuery('a')
      ->innerJoin('a.Translation')
      ->execute();


      $this->arCalendarFilterAttributes = array();

      $this->form = new sfGuardFormSignin ( );

      $nDay = $request->getParameter('nDay',null);
      $nMonth = $request->getParameter('nMonth',null);
      $nYear = $request->getParameter('nYear',null);
      $sFilterDate = null;
      if(!empty($nDay) && !empty($nMonth) && !empty($nYear)){
        $this->showAll = true;
        $sDay = str_pad($nDay, 2, "0", STR_PAD_LEFT);
        $sMonth = str_pad($nMonth, 2, "0", STR_PAD_LEFT);
        $sYear = str_pad($nYear, 4, "0", STR_PAD_LEFT);
        $sFilterDate = $sYear .'-'. $sMonth .'-'. $sDay;
        $this->arCalendarFilter = array();
        $this->arCalendarFilter[] = 'nDay='. $sDay;
        $this->arCalendarFilter[] = 'nMonth='. $sMonth;
        $this->arCalendarFilter[] = 'nYear='. $sYear;
        $arArguments['EventsFilterDate'] = date('Y-m-d H:i:s',strtotime($sFilterDate));
        $this->arCalendarFilterAttributes['sFilterDate'] = $sFilterDate;

        $this->urlDate ='?'.$this->arCalendarFilter[0].'&'.$this->arCalendarFilter[1].'&'.$this->arCalendarFilter[2];
      }

      if (!$sFilterDate) { $date=date('j-n-Y'); }
      else {$date=$sDay .'-'. $sMonth .'-'. $sYear;}

      $previous_date = explode("-",date('j-n-Y', strtotime($date .' -1 day')));
      $next_date = explode("-",date('j-n-Y', strtotime($date .' +1 day')));

      $this->previous_day = date('l', strtotime($date .' -1 day'));
      $this->next_day = date('l', strtotime($date .' +1 day'));

      $this->previous_day_url='?nDay='.$previous_date[0].'&nMonth='.$previous_date[1].'&nYear='.$previous_date[2];
      $this->next_day_url='?nDay='.$next_date[0].'&nMonth='.$next_date[1].'&nYear='.$next_date[2];

      //setlocale(LC_ALL, 'C');
      $this->titleDate=date('j F Y', strtotime($date));
      //$this->titleDate=explode(" ",date('j F Y', strtotime($date)));
      //$this->titleDate=strftime('%B', strtotime($date));

      if($request->getParameter ( 'category_id' )){
        $this->forward404Unless($this->category = Doctrine::getTable('Category')->find($request->getParameter('category_id')));

        $arArguments['nEventCategoryID'] = $request->getParameter ( 'category_id' );
        $this->arCalendarFilterAttributes['category_id'] = $request->getParameter ( 'category_id' );
        $this->previous_day_url='?category_id='. $request->getParameter ( 'category_id' ).'&nDay='.$previous_date[0].'&nMonth='.$previous_date[1].'&nYear='.$previous_date[2];
        $this->next_day_url='?category_id='. $request->getParameter ( 'category_id' ).'&nDay='.$next_date[0].'&nMonth='.$next_date[1].'&nYear='.$next_date[2];
      }

      if($request->getParameter ( 'tickets' ) ){
        $arArguments['tickets'] = $request->getParameter ( 'tickets' );
        $this->tickets=true;
      }

      if($request->getParameter ( 'city' )=='current'){
        $arArguments['nLocationID'] = $this->getUser()->getCity()->getId();// $request->getParameter ( 'caty_id' );
        $this->city = $this->getUser()->getCity();
      }
      else{
        $arArguments['nLocationID'] = $request->getParameter ( 'city' );
        $this->city = Doctrine_Core::getTable('City')->find(array($request->getParameter('city')));
      }

      breadCrumb::getInstance ()->add ( 'Events', '@event?city='. $this->city->getId() );
      if ($this->category)
      breadCrumb::getInstance ()->add ( $this->category->getTitle() );


      //print_r($this->getUser()->getCity()->getId());exit();
      $this->sCurrentRouting = $this->getController()->genUrl('@event');
      $this->arCalendarFilterAttributes['sEventListURL'] = $this->sCurrentRouting;
      //$this->arCalendarFilterAttributes['sDatesWithEventsJSArray'] = Event::getAllEventsDatesJSArray($request->getParameter ( 'category_id',NULL ), $request->getParameter ( 'caty_id', NULL ));


      $this->pager = Event::getPagerEvents( $request->getParameter ( 'page', 1  ), $arArguments);
      
      //if ($request->getParameter ( 'category_id' ) )
      //	$this->pager = $this->getPagerCityEvents ( '1212', $request->getParameter ( 'page', 1 ), $request->getParameter ( 'category_id' ) );
      //else $this->pager = $this->getPagerCityEvents ( '1212', $request->getParameter ( 'page', 1  ) );
     // $this->user = $this->getUser()->getGuardUser();

    }

    public function executeShow(sfWebRequest $request)
    {
    	$this->regForm = new OldRegisterForm();
    	$this->event = Doctrine_Core::getTable('Event')->find(array($request->getParameter('id')));
        $this->forward404Unless($this->event);
        $this->getResponse()->setTitle($this->event->getTitle());
	    $this->getUser()->setCity($this->event->getCity());
        $meta= $this->event->getTitle(). ' - '. $this->getUser()->getCity()->getLocation();
        $this->getResponse()->addMeta('description', $meta );
        $this->getResponse()->addMeta('keywords', myTools::generateKeywords($meta));
          
        $this->form = new sfGuardFormSignin ( );

        $this->arCalendarFilterAttributes = array();
        //$this->arCalendarFilterAttributes['sFilterDate'] = date('Y-m-d');
        //$this->arCalendarFilterAttributes['nEventCategoryID'] = $this->event->getLocationId();
        $this->arCalendarFilterAttributes['sEventListURL'] = $this->generateUrl ( 'event' )  ;
        //$this->arCalendarFilterAttributes['sDatesWithEventsJSArray'] = Event::getAllEventsDatesJSArray($this->event->getCategoryId(), $this->event->getLocationId());
        //$this->arCalendarFilterAttributes['sDatesWithEventsJSArray'] = Event::getAllEventsDatesJSArray();
/*
        $query = Doctrine::getTable ( 'Image' )->createQuery ( 'i' )->innerJoin ( 'i.EventImage ei' )->where ( 'i.filename IS NOT NULL and ei.event_id = :event' );
        $this->images = $query->execute ( array ('event' => $this->event->getId () ) );
*/
	    breadCrumb::getInstance ()->add ( 'Events', '@event?city=current' );
        breadCrumb::getInstance ()->add ( $this->event->getCategory()->getTitle(),'@event_category?city=current&category_id='.$this->event->getCategory()->getId() );

        $this->form = new sfGuardFormSignin();

	    //$this->getUser ()->setAttribute ( 'redirect_after_login_create_event', 'event/create' );
        $query = Doctrine::getTable('EventUser')->createQuery('i')->where('i.event_id = :event');
        $this->eventUsers = $query->execute(array('event' => $this->event->getId()));
        $this->countEventUsers = count($this->eventUsers);

        //$this->user = $this->getUser()->getGuardUser();
        //print_r($this->sf_user);exit();
        $this->is_current_user=false;
      
        $this->categories = Doctrine_Core::getTable('Category')
		        ->createQuery('a')
		        ->innerJoin('a.Translation')
		        ->execute();
      
        if ($this->user) {
      		$this->is_current_user = ($this->event->getUserId() === $this->user->getId());
        }
      
        $this->attendUser=false;
        
        if ($this->user) {
        	$eventUser = Doctrine_Core::getTable('EventUser')
			        ->createQuery('e')
			        ->where('e.user_id=? and e.event_id=?',array($this->user->getId(),$this->event->getId()))
			        ->execute();
        }
        
        if ($this->user && count($eventUser)) {
        	$this->attendUser=true;
        }

        //Doctrine_Core::getTable('Event')->find(array($request->getParameter('id')));
        //$this->eventLocation =  Doctrine::getTable ( 'City' )->find( array($this->event->getLocationId()) );
        $this->photoTab=false;
      
        
        $this->formImg = new ImageForm();
		if($request->isMethod('post')) {
			$this->photoTab=true;
			
			if ($this->getUser()->getId() != $this->event->getUserId()) {
				$this->contributors = true;
			}
			
        	$params = $request->getParameter ( $this->formImg->getName (), array () );
        	//$params['user_id']=$this->getUser()->getId() ;
        	$file = $request->getFiles($this->formImg->getName());
        	$this->formImg->bind($params, $file);

        	if ($this->formImg->isValid())
        	{
          		if($this->formImg->getValue('file')){
		            $photo = new Image();
		            $photo->setFile($this->formImg->getValue('file'));
		            $photo->setUserId($this->user->getId());
		            $photo->setCaption($this->formImg->getValue('caption'));
		            $photo->save();
		
		            $event_image = new EventImage();
		            $event_image->setImageId($photo->getId());
		            $event_image->setEventId($this->event->getId());
		            $event_image->save();

            		$this->getUser ()->setFlash ( 'form_success', 'The photo was published successfully.' );
          		}
          		$this->formImg = new ImageForm();
        	}
        	else {
        		$this->getUser ()->setFlash ( 'error', $this->formImg['file']->getError() );
        	}
      	}
      	
        $query = Doctrine::getTable('Image')
        		->createQuery('i')
        		->innerJoin('i.EventImage ei')
        		->where('i.filename IS NOT NULL and ei.event_id = :event' );
        
        $this->images = $query->execute(array('event' => $this->event->getId()));
      
		$query = Doctrine::getTable('Image')
		        ->createQuery('i')
		        ->innerJoin('i.EventImage ei')
		        ->where('i.filename IS NOT NULL')
		        ->addWhere('ei.event_id = ?', $this->event->getId());
		
        if (!$request->getParameter('contributors') && !$this->photoTab) {
            $query->addWhere('i.user_id = ?', $this->event->getUserId ());
            $this->contributors=false;
        }
        elseif ($request->getParameter('contributors') && !$this->photoTab) {
            $query->addWhere('i.user_id != ?', $this->event->getUserId ());
            $this->contributors=true;
        }

        $this->photos = $query->execute();
        
        $this->events = Doctrine::getTable('Event')
		        ->createQuery('e')
		        ->innerJoin('e.Translation t')
		        ->leftJoin('e.EventUser u')
		        ->where('e.location_id = ?', $this->getUser()->getCity()->getId())
		        ->addWhere('e.category_id = ?', $this->event->getCategoryId() )
		        ->addWhere ( 'e.image_id IS NOT NULL and e.image_id != "" ')
		        ->addWhere('e.start_at >= ? ', array( date("Y-m-d") ) )
		        ->addWhere('e.id <> ?', $this->event->getId() )
		        ->limit(3)
		        ->groupBy('e.id')
		        ->orderBy('e.start_at DESC, count(u.user_id) DESC')
		        ->execute();

        $this->countEvents=count($this->events);
        $this->similarTitle='You Can Also Visit';
        
        if (count($this->events)==0 || 1) {
        	$query = Doctrine::getTable('Company')
		        ->createQuery('c')
		        ->innerJoin('c.City ct')
		        ->innerJoin('c.Location l')
		        ->innerJoin('c.Classification cl')
		        ->innerJoin('cl.Translation clt WITH clt.lang = ?', $this->getUser()->getCulture())
		        ->innerJoin('c.Sector se')
		        ->leftJoin('se.CategorySector cs WITH cs.category_id=?',$this->event->getCategoryId())
		        ->innerJoin('se.Translation set WITH set.lang = ?', $this->getUser()->getCulture())
		        ->leftJoin('c.AdServiceCompany adc WITH adc.ad_service_id = 11 AND adc.active_from <= '.ProjectConfiguration::nowAlt().' AND adc.status = "active" AND ((adc.active_to is null AND adc.crm_id is not null) OR (adc.active_to >= '.ProjectConfiguration::nowAlt().' AND  adc.crm_id is null))')
		        ->leftJoin('c.Image i')
		        ->leftJoin('c.Review r')
		        ->leftJoin('c.TopReview tr')
		        ->leftJoin('tr.UserProfile up')
		        ->leftJoin('up.sfGuardUser sf')
		        ->innerJoin('c.CompanySearch s')
		        ->addSelect('c.*, l.*, i.*, ct.*, tr.*, adc.*, cl.*, clt.*, se.*, set.*, up.*, sf.*,r.*')
		        ->andWhere('l.longitude IS NOT NULL and l.latitude IS NOT NULL')
		        ->andWhere('c.status = ? ', CompanyTable::VISIBLE)
		        ->andWhere('c.country_id = ?', $this->getUser()->getCountry()->getId())
		        ->andWhere('c.city_id = ?', $this->getUser()->getCity()->getId())
		        ->addWhere('c.image_id IS NOT NULL and c.image_id != ""')
		        ->andWhere('r.id  IS NOT NULL')
		        ->groupBy('c.id')
		        ->limit(3)
		        ->orderBy('RAND(),count(r.id) DESC');

        if( $this->event->getFirstEventPage() && $this->event->getFirstEventPage()->getCompanyPage()->getCompany()->getLocation()->getLatitude() && $this->event->getFirstEventPage()->getCompanyPage()->getCompany()->getLocation()->getLongitude()) {
            $lat = $this->event->getFirstEventPage()->getCompanyPage()->getCompany()->getLocation()->getLatitude() ;
            $lng = $this->event->getFirstEventPage()->getCompanyPage()->getCompany()->getLocation()->getLongitude();
            $sql = "((ACOS(SIN(%s * PI() / 180) * SIN(l.latitude * PI() / 180) + COS(%s * PI() / 180) * COS(l.latitude * PI() / 180) * COS((%s - l.longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as kms";
            $kms = sprintf($sql, $lat, $lat, $lng);
          
            $query->addSelect($kms)
            	->having('kms < 5');
            $this->similarTitle='Places Nearby';
        }

        $this->companies=$query->execute();
      }
    }


    public function executeCreate(sfWebRequest $request)
    {
    	if ($this->is_place_admin_logged)
    	{
    		$this->redirect('event/noAccess?r=create');
    	}
    	$context = $this->getContext();
    	//$country= $this->UriDomain($this->getRequest()->getUri());
    	//if ($country=1 || $country=999 )
    	$form = $this->form = new EventForm();
    	
    	if(myTools::isExceedingMaxPhpSize()){
	    	$this->form['file']->setError(new sfValidatorError($this->form->getValidator("file"),"max_size"));
    	}else{
    		if($request->isMethod(sfRequest::POST)){
    			$this->processForm($request, $this->form);
    		}	
    	}
    	
    	//var_dump($this->form->getErrorSchema()->getErrors());die;
    	$this->setTemplate('new');
    }

    public function executeEdit(sfWebRequest $request)
    {
    	if ($this->is_place_admin_logged)
    	{
    		$this->redirect('event/noAccess?r=edit&id='.$request->getParameter('id'));
    	}
      $this->forward404Unless($event = Doctrine_Core::getTable('Event')->find(array($request->getParameter('id'))), sprintf('Object event does not exist (%s).', $request->getParameter('id')));
    //  $this->user = $this->getUser()->getGuardUser();
      $this->forward404Unless($this->user && $this->user->getId()==$event->getUserId());
      $this->form = new EventForm($event);
      //$this->formImage = new ImageForm();
      if($request->isMethod(sfRequest::POST)){
        $this->processForm($request, $this->form);
      }
      $this->setTemplate('edit');
    }

    public function executeDelete(sfWebRequest $request)
    {
      //$request->checkCSRFProtection();

      $this->forward404Unless($event = Doctrine_Core::getTable('Event')->find(array($request->getParameter('id'))), sprintf('Object event does not exist (%s).', $request->getParameter('id')));
      //$this->user = $this->getUser()->getGuardUser();
      $this->forward404Unless($this->user->getId()==$event->getUserId());
      $event->delete();

      $this->redirect('event/recommended');
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
    	$this->redirect('event/noAccess');
    	}
      $params = $request->getParameter ( $form->getName (), array () );
     // $this->user = $this->getUser()->getGuardUser();
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

      if ($form->isValid() && $errora == false)
      {
        //$this->form->setValue();
        //print_r($this->form->getValue('poster'));exit();

        $event = $this->form->updateObject();
        $event->setUserId($this->user->getId());
        $event->setCountryId($this->getUser()->getCountry()->getId());
        $event->save();

        //if(isset($params['file'])){exit('1');
        if($this->form->getValue('file')){//exit('1');
          $photo = new Image();
          $photo->setFile($this->form->getValue('file'));
          $photo->setCaption($this->form->getValue('caption'));
          $photo->setUserId($this->user->getId());
          if($this->form->getValue('poster')==1) $photo->setType('poster');
          $photo->save();

          $event_image = new EventImage();
          $event_image->setImageId($photo->getId());
          $event_image->setEventId($event->getId());
          $event_image->save();

          if (! $event->getImageId ()) {
            $event->setImageId ( $photo->getId () );
            $event->save ();
          }
        }

        if(!$event->getEndAt()){
          $event->setEndAt($this->form->getValue('start_at'));
          $event->save();
        }

        Doctrine::getTable('EventPage')
        ->createQuery('p')
        ->select('p.page_id')
        ->delete()
        ->where('p.event_id = ?', $event->getId())
        ->execute();


        if ($form->getValue('place_id')){
          foreach ($form->getValue('place_id') as $plase){//print_r('bqbq1');
            $eventPage = new EventPage();
            $eventPage->setPageId($plase);
            $eventPage->setEventId($event->getId());
            $eventPage->save();
          }//exit('ggggg');
        }
        $this->getUser ()->setFlash ( 'notice', 'Event was submitted successfully.' );
        $this->redirect('event/show?id='.$event->getId());
        //}
      }

      if ($errora == true) {
        $this->getUser ()->setFlash ( 'newerror', 'The event title and terms are mandatory for at least one of the two language versions.' );

      } else {
        $this->getUser ()->setFlash ( 'newerror', 'The event was not saved. Please fill in all mandatory fields.' );
      }
    }


    public function executeAddPage(sfWebRequest $request) {

      $this->cityId = $request->getParameter ( 'cityId' );
      $this->placeStr = trim ( $request->getParameter ( 'place', null ) );
      $this->culture = $this->getUser ()->getCulture ();


      if ($request->getParameter ( 'eventId' )){
        $this->eventId = $request->getParameter ( 'eventId' );
        $event = Doctrine_Core::getTable('Event')->find(array($request->getParameter ( 'eventId' )));
      }
      if ( !$request->getParameter ( 'page' )) $page=1;
      $page=$request->getParameter ( 'page' );
      $this->placePager = Page::getPagerForEventSearchByTitle ($this->placeStr, $this->cityId, $page, $eventId=$this->eventId);
      //print_r(count($this->placePager->getResults()));
      //exit();
      //CompanyPeer::getPagerForCompanySearchByTitleAndList($place, $cityID, $page, $event);


      /*$this->company_guid = $request->getParameter ( 'company_guid', null );

      $userId = $request->getParameter ( 'userId', null );

      $cityId = $request->getParameter ( 'nCityID', null );

      $list=NULL;

      if (! empty ( $this->company_guid )) {


      $location = UsersListLocationsPeer::addLocation($cityId,$this->listId);

      if ( !isset($location)){
      $location = new UsersListLocations;
      $location->setCity($cityId);
      $location->setUsersListId($this->listId);
      $location->save();
      }

      $addCompany = new UsersListPlaces();
      $addCompany->setUsersListId($this->listId);
      $addCompany->setCompanyGuid($this->company_guid);
      $addCompany->setUserId($userId);
      $item = $addCompany->save();
      if ($item && !$uList->getIsActive()){ $uList->setIsActive(1);$uList->save();}
      //var_dump($addCompany);exit();
      }
      $addListIds = 	UsersListPlacesPeer::retrieveByListId($this->listId);
      $this->setVar('addListIds', $addListIds, true);
      //print_r($this->addListIds);exit();
      if (strlen ( $this->company ) > 2) {
      $nCityID = $request->getParameter ( 'nCityID' );
      $nPage = $request->getParameter ( 'nPage' );

      if (empty ( $nPage ))
      $nPage = 1;
      $this->sSearchPlace = $this->company;
      $this->cityID = $cityID;
      $this->bShowSearchList = true;
      $this->companyPager = CompanyPeer::getPagerForCompanySearchByTitleAndList($place, $cityID, $pager, $event);
      }else{
      return sfView::NONE;
      }*/

    }
    public function executeAddEventUser(sfWebRequest $request) {
     // $this->user = $this->getUser()->getGuardUser();
      $eventUser= new EventUser();
      $eventUser->setEventId ( $request->getParameter ( 'id' ));
      $eventUser->setUserId ($this->user->getId () );
      $eventUser->save ();
      //$this->redirect('event/show?id='.$request->getParameter ( 'id' ));
      
      $q = Doctrine::getTable ( 'EventUser' )->createQuery ( 'i' )->where ( 'i.event_id = ?', $request->getParameter ( 'id' ));
      $newCountEventUsers = count($q);
      
      return $this->renderText(json_encode(array('error' => false, 'newCountEventUsers' => $newCountEventUsers)));
    }
    
    public function executeDelEventUser(sfWebRequest $request) {
      Doctrine::getTable('EventUser')
      ->createQuery('e')
      ->delete()
      ->where('e.user_id=? and e.event_id=?',array( $request->getParameter ( 'user_id' ), $request->getParameter ( 'event_id' ) ))
      ->execute();
      
      $q = Doctrine::getTable ( 'EventUser' )->createQuery ( 'i' )->where ( 'i.event_id = ?', $request->getParameter ( 'event_id' ));
      $newCountEventUsers = count($q);

      //$this->redirect('event/show?id='.$request->getParameter ( 'event_id' ));
      return $this->renderText(json_encode(array('error' => false, 'newCountEventUsers' => $newCountEventUsers)));
    }

    public function executeSetEvent(sfWebRequest $request) {
     // $this->user = $this->getUser()->getGuardUser();
      $this->event = Doctrine_Core::getTable('Event')->find(array($request->getParameter('event_id')));
      $query = Doctrine::getTable ( 'Image' )->createQuery ( 'i' )->where ( 'i.user_id = ?', $this->user->getId () )->andWhere ( 'i.id = ?', $request->getParameter ( 'id' ) );

      $this->forward404Unless ( $image = $query->fetchOne () );

      $this->event->setImageId ( $image->getId () );
      $this->event->save ();
      $this->getUser ()->setFlash ('notice', 'The event picture was changed successfully.');

      $this->redirect ( $request->getReferer () );
    }

    public function executeDeleteImage(sfWebRequest $request) {
      //$this->user = $this->getUser()->getGuardUser();
      $query = Doctrine::getTable ( 'Image' )->createQuery ( 'i' )
      ->where ( 'i.user_id = ?', $this->user->getId () )
      ->addWhere ( 'i.id = ?', $request->getParameter ( 'id' ) );

      $this->forward404Unless ( $image = $query->fetchOne () );

      $event=Doctrine::getTable('Event')->findOneBy('image_id',$image->getId());

      if($event)
      {
        $event->setImageId(NULL);
        $event->save();
      }


      $image->delete ();

      $this->getUser ()->setFlash ( 'notice', 'The photo was deleted successfully.' );

      $this->redirect ( $request->getReferer () );
    }

    public function executeImages(sfWebRequest $request)
    {
      //$event = $this->event;
      $this->event = Doctrine_Core::getTable('Event')->find(array($request->getParameter('event')));
      //print_r($this->event->getId());exit();
      $page=$request->getParameter('page','1');
      $query = Doctrine::getTable ( 'Image' )
      ->createQuery ( 'i' )
      ->innerJoin ( 'i.EventImage ei' )
      ->where ( 'ei.event_id = ?', $request->getParameter('event') );
      if (!$request->getParameter('contributors')){
        $query->addWhere('i.user_id = ?', $this->event->getUserId ());
      }
      elseif ($request->getParameter('contributors')){
        $query->addWhere('i.user_id != ?', $this->event->getUserId ());
      }
      //$this->images = $query->execute ( array ('event' => $this->event->getId () ) );

      $pager = new sfDoctrinePager ( 'Image', Event::FORM_IMAGES_PER_PAGE );
      //print_r($query->getSqlQuery());exit();
      $pager->setQuery($query);
      $pager->setPage ( $page );
      $pager->init ();

      $this->pager=$pager;
    }
    public function executeComments(sfWebRequest $request)
    {
     // $this->user = $this->getUser ()->getGuardUser ();
      $this->event = Doctrine_Core::getTable('Event')->find(array($request->getParameter('event_id')));
    }
    public function executePhotos(sfWebRequest $request)
    {
 //     $this->user = $this->getUser ()->getGuardUser ();
      $this->formLogin = new sfGuardFormSignin ();
      $this->form = new ImageForm();
      $this->event = Doctrine_Core::getTable('Event')->find(array($request->getParameter('event_id')));
      $this->forward404Unless($this->event);

      $this->form_top_toggle =false;
      if ($request->getParameter('toggle')) 	$this->form_top_toggle =true;
      //print_r($request->getParameter('toggle'));exit();

      $query = Doctrine::getTable ( 'Image' )
      ->createQuery ( 'i' )
      ->innerJoin ( 'i.EventImage ei' )
      ->where ( 'i.filename IS NOT NULL' )
      ->addWhere('ei.event_id = ?', $this->event->getId ());
      if (!$request->getParameter('contributors')){
        $query->addWhere('i.user_id = ?', $this->event->getUserId ());
        $this->contributors=false;
      }
      elseif ($request->getParameter('contributors')){
        $query->addWhere('i.user_id != ?', $this->event->getUserId ());
        $this->contributors=true;
      }

      //$this->images = $query->execute ( array ('event' => $this->event->getId () ) );

      $this->images = $query->execute();
      /*
      $this->pager = new sfDoctrinePager('Image', 60);
      $this->pager->setQuery($query);
      $this->pager->setPage($request->getParameter('page', 1));
      $this->pager->init();
      */
    }
    public function executeRecommended(sfWebRequest $request)
    {
      // $this->user = $this->getUser ()->getGuardUser ();
      //print_r( $this->generateUrl ( 'event' ) );exit();
      $this->form = new sfGuardFormSignin ( );
      $this->arCalendarFilterAttributes = array();
      //$this->arCalendarFilterAttributes['sFilterDate'] = date('Y-m-d');
      //$this->arCalendarFilterAttributes['nEventCategoryID'] = $category_id;
      $this->arCalendarFilterAttributes['sEventListURL'] = $this->generateUrl ( 'event' )  ;
      //$this->arCalendarFilterAttributes['sDatesWithEventsJSArray'] = Event::getAllEventsDatesJSArray();

      $this->categories = Doctrine_Core::getTable('Category')
      ->createQuery('a')
      ->innerJoin('a.Translation')
      ->execute();
		
      if($request->getParameter ( 'city' )=='current'){
        $this->city = $this->getUser()->getCity();
      }
      else{
        $this->city = Doctrine_Core::getTable('City')->find(array($request->getParameter('city')));
      }
      
      breadCrumb::getInstance ()->add ( 'Events', '@event?city='. $this->city->getId() );
      
      $this->_getEventsList($request);
      $isAjax = $request->getParameter("is_ajax", 0);
      if($isAjax){
      	$events = $this->pager->getResults();
		$eventscount = $this->pager->getNbResults();
      	$currentPage = is_numeric($this->currentPage) ? $this->currentPage : 1;
      	
      	return $this->renderPartial( 'eventsList', array('events' => $events, 'eventscount' => $eventscount, 'currentPage' => $currentPage) );
      }
    }
    
    protected function _getEventsList(sfWebRequest $request){
    	$selected_tab = $request->getParameter("selected_tab","active");
    	$date_selected = $request->getParameter("date_selected",date("Y-m-d"));
    	$city_id = $request->getParameter("city_id");
    	if(is_object($this->city) && is_numeric($this->city->getId()) &&  $this->city->getId() > 0){
    		$city_id = $this->city->getId();
    	}
    	$page = $request->getParameter("page",1);
    	//$category_id = $request->getParameter("category_id2",false);
    	$category = $request->getParameter("category",false);
    	if($category == "all_cats"){
    		$category = false;
    	}    
    	$this->pager = EventTable::getListEvents($city_id, $page, $selected_tab, $date_selected, $category);
    	//$this->events = Event::getTabEvents($city_id, $page, $selected_tab, $date_selected, $category_id);
    	//$this->pager = Event::getTabEvents($city_id, $page, $selected_tab, $date_selected, $category_id);
    	$this->selected_tab = $selected_tab;
    	$this->date_selected = $date_selected;
    	$this->city_id = $city_id;
    	$this->category = $category;
    	$this->currentPage = $page;
    }
    
    public function executeRecommendedTabs(sfWebRequest $request)
    {
      breadCrumb::getInstance ()->add ( 'Events', '@event?city='. $request->getParameter ( 'city_id' ) );
      
      $selected_tab = $request->getParameter("selected_tab","active");
      $date_selected = $request->getParameter("date_selected",date("Y-m-d"));
      $city_id = $request->getParameter("city_id");
      $page = $request->getParameter("page",1);
      $category_id = $request->getParameter("category_id",false);
      if($category_id == "all_cats") $category_id = false;
      $this->pager = Event::getTabEvents($city_id, $page, $selected_tab,$date_selected,$category_id);
      
      $this->is_component = 1;
      if($city_id=='current'){
      	$this->city = $this->getUser()->getCity();
      }
      else{
      	$this->city = Doctrine_Core::getTable('City')->find(array($city_id));
      }
      $this->selected_tab = $selected_tab;
      //$this->events = $query->execute();

    }

    public function executePlacesNearby(sfWebRequest $request)
    {
      $this->similarTitle='You Can Also Visit';
      $this->forward404Unless($this->event = Doctrine_Core::getTable('Event')->find(array($request->getParameter('id'))), sprintf('Object event does not exist (%s).', $request->getParameter('id')));
      $this->eventId=$request->getParameter('id');
      $query = Doctrine::getTable('Company')
      ->createQuery('c')
      ->innerJoin('c.City ct')
      ->innerJoin('c.Location l')
      ->innerJoin('c.Classification cl')
      ->innerJoin('cl.Translation clt WITH clt.lang = ?', $this->getUser()->getCulture())
      ->innerJoin('c.Sector se')
      ->leftJoin('se.CategorySector cs WITH cs.category_id=?',$this->event->getCategoryId())
      ->innerJoin('se.Translation set WITH set.lang = ?', $this->getUser()->getCulture())
      ->leftJoin('c.AdServiceCompany adc WITH adc.ad_service_id = 11 AND adc.active_from <= '.ProjectConfiguration::nowAlt().' AND adc.status = "active" AND ((adc.active_to is null AND adc.crm_id is not null) OR (adc.active_to >= '.ProjectConfiguration::nowAlt().' AND  adc.crm_id is null))')
      ->leftJoin('c.Image i')
      ->leftJoin('c.Review r')
      ->leftJoin('c.TopReview tr')
      ->leftJoin('tr.UserProfile up')
      ->leftJoin('up.sfGuardUser sf')
      ->innerJoin('c.CompanySearch s')
      ->addSelect('c.*, l.*, i.*, ct.*, tr.*, adc.*, cl.*, clt.*, se.*, set.*, up.*, sf.*,r.*')
      ->andWhere('l.longitude IS NOT NULL and l.latitude IS NOT NULL')
      ->andWhere('c.status = ? ', CompanyTable::VISIBLE)
      ->andWhere('c.country_id = ?', $this->getUser()->getCountry()->getId())
      ->andWhere('c.city_id = ?', $this->getUser()->getCity()->getId())
      ->addWhere('c.image_id IS NOT NULL and c.image_id != ""')
      ->andWhere('r.id  IS NOT NULL')
      ->groupBy('c.id')
      ->limit(3)
      ->orderBy('RAND(),count(r.id) DESC');

      if( $this->event->getFirstEventPage() && $this->event->getFirstEventPage()->getCompanyPage()->getCompany()->getLocation()->getLatitude() && $this->event->getFirstEventPage()->getCompanyPage()->getCompany()->getLocation()->getLongitude()){
        $lat = $this->event->getFirstEventPage()->getCompanyPage()->getCompany()->getLocation()->getLatitude() ;
        $lng = $this->event->getFirstEventPage()->getCompanyPage()->getCompany()->getLocation()->getLongitude();
        $sql = "((ACOS(SIN(%s * PI() / 180) * SIN(l.latitude * PI() / 180) + COS(%s * PI() / 180) * COS(l.latitude * PI() / 180) * COS((%s - l.longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as kms";
        $kms = sprintf($sql, $lat, $lat, $lng);
        $query->addSelect($kms)
        ->having('kms < 5');
        $this->similarTitle='Places Nearby';
      }

      $this->companies=$query->execute();
    }

    public function executeSimilarEvents(sfWebRequest $request)
    {
      $this->forward404Unless($this->event = Doctrine_Core::getTable('Event')->find(array($request->getParameter('id'))), sprintf('Object event does not exist (%s).', $request->getParameter('id')));
      $this->eventId=$request->getParameter('id');
      $this->events = Doctrine::getTable('Event')
      ->createQuery('e')
      ->innerJoin('e.Translation t')
      ->leftJoin('e.EventUser u')
      ->where('e.location_id = ?', $this->getUser()->getCity()->getId())
      ->addWhere('e.category_id = ?', $this->event->getCategoryId() )
      ->addWhere ( 'e.image_id IS NOT NULL and e.image_id != "" ')
      ->addWhere('e.start_at >= ? ', array( date("Y-m-d") ) )
      ->addWhere('e.id <> ?', $this->event->getId() )
      ->limit(3)
      ->groupBy('e.id')
      ->orderBy('e.start_at DESC, count(u.user_id) DESC')
      ->execute();
    }

    public function executeLastPosts()
    {
      //$this->feed = sfFeedPeer::createFromWeb('http://groups.google.com/group/symfony-users/feed/rss_v2_0_msgs.xml');
      $this->feed = sfFeedPeer::createFromWeb('http://www.cinefish.bg/xml/cinema_program_876_special.xml');
      //$this->feed = sfFeedPeer::createFromWeb('http://www.dnevnik.bg/rssc/?rubrid=1707');
    }
    public function executeRedirectAfterLogin(sfWebRequest $request)
    {
      $this->getUser ()->setAttribute ( 'redirect_after_login', 'event/create' );
      //if ($request->isXmlHttpRequest ()){
      	return true;
      //}
    }
   public function executeNoAccess(sfWebRequest $request) {
	   	$this->r = $request->getParameter('r');
	   	if ($request->getParameter('id')) $this->id = $request->getParameter('id');
    }
  }
