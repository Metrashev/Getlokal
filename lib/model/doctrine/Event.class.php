<?php

/**
 * Event
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Event extends BaseEvent {

    const FRONTEND_EVENTS_PER_PAGE = 12;
    const COMPANY_EVENTS_PER_PAGE = 6;
    const UNSPECIFIED = 0;
    const FIRST_EVENT_PRICE = 1;
    const SECOND_EVENT_PRICE = 2;
    const THIRD_EVENT_PRICE = 3;
    const FOURTH_EVENT_PRICE = 4;
    const FIFTH_EVENT_PRICE = 5;
    const EVENTS_PER_PAGE = 20;
    const EVENTS_PER_TAB = 12;
    const EVENTS_IN_PROFILE_PAGE = 10;
    const FORM_IMAGES_PER_PAGE = 4;

    /* public static $EventPricesChoises = array(
      self::UNSPECIFIED => 'Choose...'
      , self::FIRST_EVENT_PRICE => 'Free'
      , self::SECOND_EVENT_PRICE => 'Up to 10 leva'
      , self::THIRD_EVENT_PRICE => 'Up to 50 leva'
      , self::FOURTH_EVENT_PRICE => 'Up to 100 leva'
      , self::FIFTH_EVENT_PRICE => 'Over 100 leva'
      );
     */

    public static function getRealPrice($price = NULL) {
        $currency = sfContext::getInstance()->getUser()->getCountry()->getCurrency();
        $i18n = sfContext::getInstance()->getI18N();

        $prices = array(
            self::UNSPECIFIED => $i18n->__('Choose...', null, 'events'),
            self::FIRST_EVENT_PRICE => $i18n->__('Free', null, 'events'),
            self::SECOND_EVENT_PRICE => $i18n->__('Up to 10 ' . $currency, null, 'events'),
            self::THIRD_EVENT_PRICE => $i18n->__('Up to 50 ' . $currency, null, 'events'),
            self::FOURTH_EVENT_PRICE => $i18n->__('Up to 100 ' . $currency, null, 'events'),
            self::FIFTH_EVENT_PRICE => $i18n->__('Over 100 ' . $currency, null, 'events')
        );

        if ($price)
            return $prices[$price];

        return $prices;
    }

    public function getPriceValue($currecyIn = null) {
        $currency = sfContext::getInstance()->getUser()->getCountry()->getCurrency();
        $i18n = sfContext::getInstance()->getI18N();

        if ($currecyIn) {
            $currency = $currecyIn;
        }

        $prices = array(
            self::FIRST_EVENT_PRICE => $i18n->__('Free', null, 'events'),
            self::SECOND_EVENT_PRICE => $i18n->__('Up to 10 %s', array('%s' => $currency)),
            self::THIRD_EVENT_PRICE => $i18n->__('Up to 50 %s', array('%s' => $currency)),
            self::FOURTH_EVENT_PRICE => $i18n->__('Up to 100 %s', array('%s' => $currency)),
            self::FIFTH_EVENT_PRICE => $i18n->__('Over 100 %s', array('%s' => $currency))
        );

        return $prices[$this->getPrice()];
    }

    /*
      public static function EventPricesChoises()
      {
      $currency=sfContext::getInstance()->getUser()->getCountry()->getCurrency();

      return array(
      self::UNSPECIFIED         => 'Choose...',
      self::FIRST_EVENT_PRICE   => 'Free',
      self::SECOND_EVENT_PRICE  => 'Up to 10 '. $currency,
      self::THIRD_EVENT_PRICE   => 'Up to 50 '. $currency,
      self::FOURTH_EVENT_PRICE  => 'Up to 100 '.$currency,
      self::FIFTH_EVENT_PRICE   => 'Over 100 '. $currency
      );
      }


      // Constructor

      // Methods defined here
      public static function getI18NChoices(array $arChoices){
      if (sfConfig::get('sf_i18n')){
      // make confirm a choice (i18n solution is very ugly, is there a better way? TODO)
      $i18n = sfContext::getInstance()->getI18N();
      foreach ($arChoices as $k => $sChoice){
      $i18nChoices[$k] = $i18n->__($sChoice, null, 'events');
      }
      return $i18nChoices;
      }else{
      return $arChoices;
      }
      }

      public static function getEventPriceReference($vEventPriceKey){
      if(empty($vEventPriceKey)){
      return null;
      }
      $sEventPriceReference = null;
      $arEventPricesChoises = self::EventPricesChoises();
      if(isset($arEventPricesChoises[$vEventPriceKey])){
      $arEventPrice = self::getI18NChoices(array($arEventPricesChoises[$vEventPriceKey]));
      $sEventPriceReference = $arEventPrice[0];
      }

      return $sEventPriceReference;
      }

      public static function getEventPriceChoicesList(){
      return self::getI18NChoices(self::EventPricesChoises());
      }


      public static function getPosibleEventPriceChoicesList(){
      $nUnspecifiedKey = self::UNSPECIFIED;
      $arChoices = self::getI18NChoices(self::EventPricesChoises());
      return array_keys($arChoices);
      }
     */

    public function getThumb($size = 1) {
        if (!$this->getImage() || $this->getImage()->isNew()) {
            return 'gui/default_event_' . $this->getCategoryId() . '.jpg';
        }

        return $this->getImage()->getThumb($size);
    }

    public function getUrl() {
        return '@default?module=event&action=show&id=' . $this->getId();
    }

    public function getCategoryUrl() {
        return '@default?module=event&action=index&city=' . $this->getLocationId() . '&category_id=' . $this->getCategoryId();
    }

    public static function getEventCategoryChooseList($sCulture = null) {

        $arEventCategoryName = array();

        $query = Doctrine::getTable('Category')
                ->createQuery('c')
                //->where ( 'c.id > 13 ')
                ->orderBy('c.created_at DESC');

        $arEventCategory = $query->execute();

        foreach ($arEventCategory as $eventCategory) {
            $arEventCategoryName[$eventCategory->getId()] = $eventCategory->getTitle();
            //print_r($eventCategory->getTitle());
        }
        //exit();


        return $arEventCategoryName;
    }

    public static function getEventCategoryPosibleChoises($sCulture = null) {

        $arEventCategoryIDs = array();
        $query = Doctrine::getTable('Category')
                ->createQuery('c')
                //->where ( 'c.id > 13 ' )
                ->orderBy('c.created_at DESC');

        $arEventCategory = $query->execute();

        foreach ($arEventCategory as $eventCategory) {
            $arEventCategoryIDs[$eventCategory->getId()] = $eventCategory->getId();
        }

        return $arEventCategoryIDs;
    }

    public static function EventTimeChoises() {
        $i18n = sfContext::getInstance()->getI18N();

        $return = array(
            '' => $i18n->__('Select Time', null, 'events')
        );

        for ($i = 0; $i < (24 * 60); $i = $i + 15) {
            $key = sprintf('%02d:%02d:00', floor($i / 60), $i % 60);
            $return[$key] = sprintf('%02d:%02d', floor($i / 60), $i % 60);
        }

        return $return;
    }

    protected static function getEventsDatesJSArray($arEventsDates) {
        $nCountEventDates = count($arEventsDates);
        $sDateWithEventJSArray = "new Array(";
        $i = 0;
        foreach ($arEventsDates as $nEventDate) {
            $i++;
            $sDateWithEventJSArray .= "new Date(" . date('Y', $nEventDate) . ", " . date('m', $nEventDate) . " - 1" . ", " . date('d', $nEventDate) . ").toString()";
            if ($i < $nCountEventDates)
                $sDateWithEventJSArray .= ', ';
        }
        $sDateWithEventJSArray .= ");\n";

        return $sDateWithEventJSArray;
    }

    public static function getAllEventsDatesJSArray($nEventCategoryID = null, $nLocationID = null) {
        $arEventsDates = self::getAllEventsDates($nEventCategoryID, $nLocationID);

        return self::getEventsDatesJSArray($arEventsDates);
    }

    public static function getAllEventsDates($nEventCategoryID = null, $nLocationID = null) {

        $query = Doctrine::getTable('Event')
                ->createQuery('e')
                ->select('e.start_at, e.end_at')
                //->where ( 'c.id > 13 ' )
                ->orderBy('e.created_at DESC');

        return self::getCalendarEventsDates($query);
    }

    protected static function getCalendarEventsDates($sQuery) {
        $arEventsDates = array();

        $temp = $sQuery->execute();

        foreach ($temp as $row) {


            $nEventStartDate = strtotime($row['start_at']);
            $nEventEndDate = strtotime($row['end_at']);
            if (empty($nEventEndDate)) {
                $nEventEndDate = $nEventStartDate;
            }

            $nCalculateDate = $nEventStartDate;
            while ($nCalculateDate <= $nEventEndDate) {
                if (!isset($arEventsDates[$nCalculateDate])) {
                    $arEventsDates[$nCalculateDate] = $nCalculateDate;
                }

                $nCalculateDate = $nCalculateDate + 24 * 60 * 60;
            }
        }
        $arEventsDates = array_unique($arEventsDates);

        return $arEventsDates;
    }

    public function getAvailableOfferQuery($is_active = false, $is_valid = true) {
        $today = date('Y-m-d');


        $query = Doctrine::getTable('AdCompany')
                ->createQuery('adc')
                ->innerJoin('adc.Company c')
                ->leftJoin('adc.CompanyProduct cp')
                ->where('c.id = ? ', $this->getId());

        $q3 = $query->createSubquery()->select('ct.ad_company_id')
                ->from('CompanyProductOffer ct')
                ->innerJoin('ct.CompanyOffer co')
                ->where('co.company_id = ', $this->getId());

        $query->where('adc.id NOT IN (' . $q3->getDql() . ')')
                ->andWhere('adc.ad_product_id= ?', AdProductTable::OFFER);
        if ($is_active == true) {
            $query->andWhere('adc.active_from <= ?', $today)
                    ->andWhere('adc.active_to >= ?', $today);
        }
        if ($is_valid == true) {
            // ->andWhere('ad.valid_from <= ?', $today)
            $query->andWhere('adc.valid_to >= ?', $today);
        }
        $query->addOrderBy('adc.id');
        return $query;
    }

    public static function getPagerEvents($page, $arArguments = array()) {

        $query = Doctrine::getTable('Event')
                ->createQuery('e')
                ->innerJoin('e.Translation t')
                ->leftJoin('e.EventPage ep')
                ->leftJoin('ep.CompanyPage cp')
                ->leftJoin('cp.Company')
                ->leftJoin('e.Image')
                ->innerJoin('e.City')
                ->innerJoin('e.Category ec')
                ->innerJoin('ec.Translation')
                ->innerJoin('e.UserProfile p')
                ->innerJoin('p.sfGuardUser sf');

        if (isset($arArguments['nEventCategoryID'])) {
            $query->where('e.category_id = ? ', array($arArguments['nEventCategoryID']));
        }

        if (isset($arArguments['nLocationID']) && !empty($arArguments['nLocationID'])) {
            $query->addWhere('e.location_id = ? ', array($arArguments['nLocationID']));
        }
        if (isset($arArguments['tickets'])) {
            $query->addWhere('e.buy_url IS NOT NULL and e.buy_url != "" ');
        }
        if (isset($arArguments['EventsFilterDate']) && !empty($arArguments['EventsFilterDate'])) {
            $sFilterDate = $arArguments['EventsFilterDate'];
            $date = date('Y-m-d', strtotime($sFilterDate));
            $startDateTime = $date." 00:00:00";
            $endDateTime = $date." 23:59:59";
            $query->addWhere('(DATE(e.end_at) >= ? and DATE(e.start_at) <= ?)', array($date, $date));
        }

        $query->orderBy('e.start_at DESC');
        $pager = new sfDoctrinePager('Event', Event::FRONTEND_EVENTS_PER_PAGE);
//         print_r($query->getSqlQuery());exit();
        $pager->setQuery($query);
        $pager->setPage($page);
        $pager->init();

        return $pager;
    }
    
    public static function getTabEvents($city_id, $page = 1, $selected_tab = "active", $date_selected = false,$category_id = false){
    	$query = Doctrine::getTable('Event')
    	->createQuery('e')
    	->innerJoin('e.Translation t')
    	->leftJoin('e.EventPage ep')
    	->leftJoin('ep.CompanyPage cp')
    	->leftJoin('cp.Company c with c.status = ? ', CompanyTable::VISIBLE)
    	->innerJoin('e.Image')
    	->innerJoin('e.City')
    	->innerJoin('e.Category ec')
    	->innerJoin('ec.Translation')
    	->innerJoin('e.UserProfile p')
    	->innerJoin('p.sfGuardUser sf');
    	
    	$query->addWhere ( 'e.location_id = ? ', $city_id );
    	$query->addWhere('e.is_active = 1');
    	if($category_id){
    		$query->addWhere('ec.id = ?',$category_id);
    	}
    	//$query->addWhere('e.start_at >= ? ', array( date("Y-m-d") ) );
    	//$query->andWhere('c.status = ? ', CompanyTable::VISIBLE);
    	
    	$today = date("Y-m-d");
    	switch($selected_tab){
    		case "active": $query->addWhere("DATE(?) BETWEEN DATE(e.start_at) AND DATE(end_at)",$today);break;
    		case "future": {
    			$query->andWhere("DATE(e.start_at) > DATE(?)",$today);
    			$query->orderBy('e.start_at ASC');
    			break;
    		}
    		case "past"  : {
    			$query->andWhere("DATE(e.end_at) < DATE(?)",$today);
    			$query->addOrderBy("e.start_at DESC");
    			break;
    		}
    		case "date" : {
    			if(!$date_selected){
    				$date_selected = $today;
    			}
    			$query->andWhere("DATE(?) BETWEEN DATE(e.start_at) AND DATE(end_at)",$date_selected);break;
    		}
    		case "tickets" : {
    			$query->addWhere ( 'e.buy_url IS NOT NULL and e.buy_url != "" ');
    			break;
    		}
    	}
    	//       var_dump($action);die;
//     	      var_dump($query->getSqlQuery());die;
    	//$limit = ($page-1) * Event::FRONTEND_EVENTS_PER_PAGE.", ".Event::FRONTEND_EVENTS_PER_PAGE;
    	$limit = Event::FRONTEND_EVENTS_PER_PAGE;
     	$query->limit($limit);
    	
    	//print_r($query->getSqlQuery());exit();
    	
    	$query->orderBy('e.start_at DESC');
    	$pager = new sfDoctrinePager('Event', Event::FRONTEND_EVENTS_PER_PAGE);
    	
    	//                print_r($query->getSql());exit();
    	$pager->setQuery($query);
    	$pager->setPage($page);
    	$pager->init();
    	
    	return $pager;
    }
    
    public function preSave($param){
    	$this->setTitle(strip_tags($this->getTitle()));
    	$this->setDescription(html_entity_decode($this->getDescription()));
    	foreach (getlokalPartner::getEmbeddedLanguages() as $culture) {
    		if ($this->Translation[$culture]->_get('description'))
    			$this->Translation[$culture]->_set('description',html_entity_decode($this->Translation[$culture]->_get('description', $culture)));
    	}
    }

    public function postSave($event) {


        $eventCnt = Doctrine::getTable('Event')
            ->createQuery('e')
            ->where('e.user_id = ?', $this->getUserId())
            ->count();

        $eventCatCnt = Doctrine::getTable('Event')
                ->createQuery('e')
                ->where('e.user_id = ?', $this->getUserId())
                ->andWhere('e.category_id = ?', $this->getCategoryId())
                ->count();

        Doctrine::getTable('UserStat')->updateStat($this->getUserId(), array(
            'events' => $eventCnt,
            'event_category_' . $this->getCategoryId() => $eventCatCnt
        ));
    }


public function postInsert($event) {

		parent::postInsert ( $event );
	    $activity = Doctrine::getTable('ActivityEvent')->getActivity($this->getId());
        $activity->setText($this->getDescription());
        $activity->setCaption($this->getTitle());
        $activity->setUserId($this->getUserId());
        $activity->save();
	}




    public function getFirstCompany() {
        if (count($this->getEventPage()))
            return $this->getEventPage()->getFirst()->getCompanyPage()->getCompany();

        return false;
    }

    public function getFirstEventPage() {
        //return $this->getEventPage()->getFirst();
        $q = Doctrine_Query::create()
                ->select('ep.*')
                ->from('EventPage ep')
                ->innerJoin('ep.CompanyPage cp')
                ->innerJoin('cp.Company c with c.status = ? ', CompanyTable::VISIBLE)
                ->where('ep.event_id = ?', $this->getId())
        		->andWhere('c.status = ? ', CompanyTable::VISIBLE);



        return $q->fetchOne() ? $q->fetchOne() : false;
    }

    public function getAllEventPage() {
        $q = Doctrine_Query::create()
                ->select('ep.*')
                ->from('EventPage ep')
                ->innerJoin('ep.CompanyPage cp')
                ->innerJoin('cp.Company c')
                ->where('ep.event_id = ?', $this->getId())
        		->andWhere('c.status = ? ', CompanyTable::VISIBLE);



        return $q->execute();
    }

    public function getDisplayTitle() {
        if ($this->_get('title'))
        	return $this->_get('title');

        foreach (array('ro', 'bg', 'mk', 'sr' , 'en') as $culture) {
            if ($this->Translation[$culture]->_get('title', $culture))
                return $this->Translation[$culture]->_get('title', $culture);
            
        }
    }

    public function getDisplayDescription() {
        if ($this->_get('description'))
            return $this->_get('description');

        foreach (array('ro', 'bg', 'mk', 'sr', 'en') as $culture) {
            if ($this->Translation[$culture]->_get('description', $culture))
                return $this->Translation[$culture]->_get('description', $culture);
        }
    }

    public function getTitle() {
        if ($this->_get('title'))
            return $this->_get('title');

    	foreach (array('ro', 'bg', 'mk', 'sr', 'en') as $culture) {
    		if ($this->Translation[$culture]->_get('title', $culture))
    			return $this->Translation[$culture]->_get('title', $culture);
    	}
    }

    public function getDescription() {
    	if ($this->_get('description'))
    		return $this->_get('description');

    	foreach (array('ro', 'bg', 'mk', 'sr', 'en') as $culture) {
    		if ($this->Translation[$culture]->_get('description', $culture))
    			return $this->Translation[$culture]->_get('description', $culture);
    	}
    }
    
    public function hasTickets(){
    	$buy_url = $this->_get('buy_url'); 
    	if($buy_url !== NULL && $buy_url !== ""){
    		return 1;
    	}else{
    		return 0;
    	}
    }

    public static function getPagerOfEventsForArticleSearchByTitle($eventName, $page = 1, $articleId, $row = 10, $culture = null){

    	if (empty($culture)){
    		$culture = sfContext::getInstance()->getUser()->getCulture();
    	}
    	$eventName = mb_convert_case($eventName, MB_CASE_TITLE, "UTF-8");

    	$eventName= "%" . $eventName . "%";
    	$query = Doctrine::getTable('Event')
    	->createQuery('e')
    	->innerJoin('e.Translation et')
    	->where ( '(et.title LIKE ?) ', array ($eventName) )
    	->orderBy('e.created_at DESC')
    	->limit(10);

    	$q2 = $query->createSubquery ()->select ( 'ae.event_id' )
    	->from ( 'ArticleEvent ae' )
    	->andWhere('ae.article_id = ?', $articleId);

    	$query->andWhere ( 'e.id NOT IN (' . $q2->getDql () . ')' );

    	$pages = $query->execute();
    	/*
    	 $pager = new sfDoctrinePager ( 'Page', $row );

    	$pager->setQuery($query);


    	$pager->setPage ( $page );
    	$pager->init ();
    	*/
    	return $pages;
    }
 public function getIsAttendedByUser($user)
 {
 	$user_attending = Doctrine::getTable('EventUser')
    	->createQuery('eu')
    	->innerJoin('eu.Event e')
    	->where('e.id = ?', $this->getId())
    	->andWhere('eu.id = ? ', $user->getId());
    	return $user_attending;

 }
}