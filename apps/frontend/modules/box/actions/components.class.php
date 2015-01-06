<?php

/**
 * box actions.
 *
 * @package    getLokal
 * @subpackage box
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class boxComponents extends sfComponents
{
    public function executeColumn()
    {
        $query = Doctrine::getTable('BoxToZone')
                  ->createQuery('z')
                  ->innerJoin('z.Box b')
                  ->where('z.key = ?', $this->key)
                  ->andWhere('z.col_no = ?', $this->column)
                  ->orderBy('z.weight');

        $this->boxes = $query->execute();
    }

    public function executeSetup()
    {
        $boxes = Doctrine::getTable('Box')->findAll();
        $this->boxes = array();

        foreach($boxes as $box)
        {
            $box_to_zone = new BoxToZone();
            $box_to_zone->setBox($box);
            $this->boxes[] = $box_to_zone;
        }
    }

    public function executeBoxBanner()
    {}

    public function executeBoxWeather()
    {}

    public function executeBoxSlider()
    {
        $company_ids = $this->getRequest()->getAttribute('box_company_ids', array());

        $query =  Doctrine::getTable('Company')
                            ->createQuery('c')
                            ->innerJoin('c.Image')
                            ->innerJoin('c.City')
                            ->where('c.city_id = ?', $this->getUser()->getCity()->getId())
                            ->andWhere('c.status = ?', 0)
                            ->orderBy('c.score DESC')
                            ->addOrderBy('c.average_rating DESC')
                            ->addOrderBy('c.number_of_reviews DESC')
                            ->limit(6);

        if(isset($settings['sector_id'])){
            $query->andWhere('c.sector_id = ?', $settings['sector_id']);
        }

        $this->companies = $query->execute();

        $company_ids = array_merge($company_ids, $this->companies->getPrimaryKeys());

        $this->getRequest()->setAttribute('box_company_ids', $company_ids);
    }

    public function executeBoxSlider2()
    {
        $this->county = sfContext::getInstance()->getRequest()->getParameter('county', false);

        if ($this->county) {
                $query =  Doctrine::getTable('Slider')
                        ->createQuery('s')
                        ->leftJoin('s.SliderCity sc')
                        ->leftJoin('sc.City sci')
                        ->leftJoin('s.SliderSector ss')
                        ->where('((s.country_id = ? AND s.whole_country = 1) OR sci.county_id = ?)', array(
                                $this->getUser()->getCountry()->getId(),
                                $this->getUser()->getCounty()->getId()
                                ))
                        ->addWhere('s.is_active = ?', true)
                        ->orderBy('s.rank ASC')
                        ->limit(9);
        }
        else {
            $query =  Doctrine::getTable('Slider')
                    ->createQuery('s')
                    ->leftJoin('s.SliderCity sc')
                    ->leftJoin('sc.City sci')
                    ->leftJoin('s.SliderSector ss')
                    ->where('((s.country_id = ? AND s.whole_country = 1) OR sc.city_id = ?)', array(
                            $this->getUser()->getCountry()->getId(),
                            $this->getUser()->getCity()->getId()
                            ))
                    ->addWhere('s.is_active = ?', true)
                    ->orderBy('s.rank ASC')
                    ->limit(9);  	            
        }

        if (isset($this->sector) && $this->sector instanceof Doctrine_Record)
        {
          $query->andWhere('ss.sector_id = ?', $this->sector->getId());
        }
        $this->items = $query->execute();
    }

    /** USED **/
    public function executeBoxCategories()
    {
    	if(!isset($this->show_full_list)){
    		$this->show_full_list = false;
    	}
        $partner_class = strtolower(getlokalPartner::getLanguageClass());
        $tmp_array = array();
        $sector_q = Doctrine::getTable('Sector')
                          ->createQuery('s')
                          ->innerJoin('s.Translation st WITH st.lang = ?',sfContext::getInstance()->getUser()->getCulture())
        				  ->orderBy('st.rank ASC');
        
        $sector_q->useResultCache(true,24*3600,"box_categories_sectors2_".serialize($sector_q->getCountQueryParams()));
        
        $this->sectors = $sector_q->execute();

        $countyUser = (getlokalPartner::getInstanceDomain() == 78) ? sfContext::getInstance()->getUser()->getCounty() : false;
        $countyRequest = sfContext::getInstance()->getRequest()->getParameter('county', false);
        
        if ($countyRequest) {
            $this->county = $countyRequest;
        }else{
            if (getlokalPartner::getInstanceDomain() == 78) {
                $this->county = $countyRequest ? $countyRequest : $countyUser;
            } else {
                $this->county = false;
            }
        }        
    }
  
    public function executeBoxCategoriesMenu()
    {
        $partner_class = strtolower(getlokalPartner::getLanguageClass());
        $tmp_array = array();
        $this->sectors = Doctrine::getTable('Sector')
                              ->createQuery('s')
                              ->innerJoin('s.Translation st')
                              ->orderBy('st.rank')
                              ->execute();

        for($i=0; $i<count($this->sectors)-1; $i++){
            for($j=$i+1;$j<count($this->sectors);$j++){
                if($this->sectors[$i]['Translation'][$partner_class]['rank'] > $this->sectors[$j]['Translation'][$partner_class]['rank']){
                     $tmp_array = $this->sectors[$i];
                     $this->sectors[$i] = $this->sectors[$j];
                     $this->sectors[$j] = $tmp_array;
                 }
            }

       }
        $this->county = sfContext::getInstance()->getRequest()->getParameter('county', false);
    }

    public function executeBoxRecommendations()
    {
    	$limit = 5;
        $settings = $this->box->getSettings();
        
        $company_ids = $this->getRequest()->getAttribute('box_company_ids', array());
        $review_ids  = $this->getRequest()->getAttribute('box_review_ids', array());
        $this->county = sfContext::getInstance()->getRequest()->getParameter('county', false);

        $query = Doctrine::getTable('Sector')
        	->createQuery('c')
        	->innerJoin('c.Translation ct')
        	->whereIn('c.id', $settings['ids'])
        	->orderBy('ct.rank')
        	->limit(5);
        
        //$query->useResultCache(true,24*3600,"box_rec_categories_".serialize($query->getCountQueryParams()));
        $this->categories = $query->execute();
        $IDs = array();
        
        $recommend_id = $this->getRequest()->getParameter("recommend_id");
        $this->category = Doctrine::getTable('Sector')->find($recommend_id);
        
        foreach($this->categories as $cat){
        	$IDs[] = $cat->getId();
        	if(sizeof($IDs) == 1 && !$recommend_id || !$this->category) {
        		$this->category = $cat;
        	}
        }
        $culture = sfContext::getInstance()->getUser()->getCulture();
        //========================TOP PLACES=======================================

        $CACHED_OBJ_COUNT = 50;
        $top_places_q = Doctrine::getTable('Company')
        ->createQuery('c')
        ->leftJoin('c.Image i')
        ->innerJoin('c.Translation ctr WITH ctr.lang = ?',$culture)
        ->innerJoin('c.City ci')
        ->innerJoin('c.Classification ca')
        ->innerJoin('ca.Translation clt WITH clt.lang = ?',$culture)
        ->innerJoin('c.Sector s')
        ->innerJoin('s.Translation st WITH st.lang = ?',$culture)
        ->leftJoin('c.Location l')
        ->leftJoin('c.CompanyPage p')
        ->leftJoin('c.TopReview r')
        ->leftJoin('r.UserProfile rup')
        ->leftJoin('rup.sfGuardUser rupgu')
        ->leftJoin('c.AdServiceCompany adc WITH adc.ad_service_id = 11 AND adc.status = "active" AND ((adc.active_to is null AND adc.crm_id is not null) OR (adc.active_to >= '.ProjectConfiguration::nowAlt().' AND  adc.crm_id is null))' )
        ->whereIn('c.sector_id', $IDs)
        ->andWhere('c.status = ?', 0)
        ->andWhereNotIn('c.id', $company_ids)
       	->orderBy('adc.id IS NULL')
       	->addOrderBy('(c.average_rating < 3.00)')
       	->addOrderBy('i.id IS NULL')
       	->addOrderBy('RAND()')
        ->limit($CACHED_OBJ_COUNT);
		
        if($this->county){
        	$top_places_q->andWhere('ci.county_id = ?', $this->getUser()->getCounty()->getId());
        }else{
        	$top_places_q->andWhere('c.city_id = ?', $this->getUser()->getCity()->getId());
        }
        //if a Table has Join and the joined Table has another Join it is required to be described in the relations array
        $relations_array = array(
        		'Company'=>array('Classification','City','Image','Sector','TopReview'),
        		'City'=>array('County'),
        		'Review'=>array('UserProfile')
        	);
         $top_places_q->useResultCache(true,24*60*60,"top_places_3".serialize($top_places_q->getCountQueryParams()),$relations_array);
        //var_dump($IDs, $culture);   
        //echo $top_places_q->getSqlQuery();

         $this->top_places = $top_places_q->execute();
//         var_dump($this->top_places[0]->toArray());return;
        //FILTER 5 RANDOM PLACES FROM THE 100 IN MEMCACHE(APC)
        $DISPLAYED_OBJ_COUNT = getlokalPartner::getInstance() == getlokalPartner::GETLOKAL_RO ? 8 : 5;

        if(is_array($this->top_places->getKeys())){
	        $keys = $this->top_places->getKeys();
	        $random_indexes = array_rand($keys,sizeof($keys) >= $DISPLAYED_OBJ_COUNT ? $DISPLAYED_OBJ_COUNT : sizeof($keys));
	        foreach($this->top_places as $k=>$tp){
	        	if(!in_array($k,$random_indexes)){
	        		$this->top_places->remove($k);
	        	}
	        }
	        // Needed for Image Files caching
	        foreach($this->top_places as $k=>$tp){
	        	if(get_class($this->top_places[$k]->Image) == 'Image'){
// 		        	$this->top_places[$k]->Image->getFile()->setFilename($tp->Image->getFilename());
		        	$this->top_places[$k]->Image->fixCacheFilename();
	        	}
	        }
        }
		
        //=======================REVIEW========================================
        
        $review_q = Doctrine::getTable('Review')
	        ->createQuery('r')
	        ->innerJoin('r.Company c')
	        ->innerJoin('c.City ci')
	        ->innerJoin('c.Sector s')
	        ->innerJoin('s.Translation str WITH str.lang = ?',$culture)
	        ->innerJoin('c.Classification cf')
	        ->innerJoin('cf.Translation cftr WITH cftr.lang = ?',$culture)
	        ->innerJoin('r.UserProfile p')
	        ->innerJoin('p.City')
	        ->innerJoin('p.sfGuardUser sf')
	        ->where('c.sector_id = ?', $this->category->getId())
	        ->andWhere('r.parent_id IS NULL')
	        ->andWhere('c.status = ?', 0)
	        ->andWhereNotIn('r.id', $review_ids)
	        ->orderBy('r.recommended_at DESC')
	        ->limit(1);
        if ($this->county) {
        	$review_q->andWhere('ci.county_id = ?', $this->getUser()->getCounty()->getId());
        }else{
	        $review_q->andWhere('c.city_id = ?', $this->getUser()->getCity()->getId());
        }
        $relations_array = array('Review'=>array('Company','UserProfile'),'Company'=>array('Sector','Classification'));
        $review_q->useResultCache(true,24*60*60,"box_recommended_review2_".serialize($top_places_q->getCountQueryParams()),$relations_array);
        $this->review = $review_q->fetchOne();
        if($this->review){
        	$review_ids[] = $this->review->getId();
        }
//         var_dump($this->review->toArray());return;
        $company_ids = array_merge($company_ids, $this->top_places->getPrimaryKeys());

        $this->getRequest()->setAttribute('box_company_ids', $company_ids);
        $this->getRequest()->setAttribute('box_review_ids', $review_ids);
    }

    public function executeBoxEvents()
    {
        $this->today='?nDay='.date('j').'&nMonth='.date('n').'&nYear='.date('Y');
        $next=date('j-n-Y', strtotime('+1 day'));
        $tom=explode("-", $next);
        $this->tomorrow='?nDay='.$tom[0].'&nMonth='.$tom[1].'&nYear='.$tom[2];
        $this->county = sfContext::getInstance()->getRequest()->getParameter('county', false);

        if ($this->county) {

           $this->events1 = Doctrine::getTable('Event')
                                       ->createQuery('e')
                                       ->innerJoin('e.City ci')
                                       //->innerJoin('e.Translation t WITH t.lang = ?', $this->getUser()->getCulture())
                                       //->leftJoin('e.Image')
                                       ->where('ci.county_id = ?', $this->getUser()->getCounty()->getId())
                                       ->addWhere ('e.image_id IS NOT NULL and e.image_id != "" ')
                                       ->addWhere ('e.recommended_at IS NOT NULL')// AND e.recommended_at IS NULL')
                                       ->addWhere('e.start_at >= ? ', array( date("Y-m-d") ) )
                                       ->limit(3)
                                       ->groupBy('e.id')
                                       ->orderBy('e.start_at ASC')
                                       ->execute();

           if (count($this->events1)<=2) {
                   $this->events2 = Doctrine::getTable('Event')
                                               ->createQuery('e')
                                               ->innerJoin('e.City ci')
                                               //->innerJoin('e.Translation t WITH t.lang = ?', $this->getUser()->getCulture())
                                               //->leftJoin('e.EventUser u')
                                               ->where('ci.county_id = ?', $this->getUser()->getCounty()->getId())
                                               ->addWhere ( 'e.image_id IS NOT NULL and e.image_id != "" ')
                                               ->addWhere('e.start_at >= ? ', array( date("Y-m-d") ) )
                                               ->addWhere ( 'e.recommended_at IS NULL')
                                               ->limit(3-count($this->events1))
                                               //->groupBy('e.id')
                                               ->orderBy('e.start_at ASC')
                                               ->execute();
           }
        }
        else {
           $this->events1 = Doctrine::getTable('Event')
                                       ->createQuery('e')
                                       ->innerJoin('e.Translation t WITH t.lang = ?', $this->getUser()->getCulture())
                                       //->leftJoin('e.Image')
                                       ->where('e.location_id = ?', $this->getUser()->getCity()->getId())
                                       ->addWhere ( 'e.image_id IS NOT NULL and e.image_id != "" ')
                                       ->addWhere ( 'e.recommended_at IS NOT NULL')
                                       ->addWhere('e.start_at >= ? ', array( date("Y-m-d") ) )
                                       ->limit(3)
                                       ->groupBy('e.id')
                                       ->orderBy('e.start_at ASC')
                                       ->execute();

           if (count($this->events1)<=2) {
                   $this->events2 = Doctrine::getTable('Event')
                                               ->createQuery('e')
                                               ->innerJoin('e.Translation t WITH t.lang = ?', $this->getUser()->getCulture())
                                               //->leftJoin('e.EventUser u')
                                               ->where('e.location_id = ?', $this->getUser()->getCity()->getId())
                                               ->addWhere ( 'e.image_id IS NOT NULL and e.image_id != "" ')
                                               ->addWhere('e.start_at >= ? ', array( date("Y-m-d") ) )
                                               ->addWhere ( 'e.recommended_at IS NULL')
                                               ->limit(3-count($this->events1))
                                               //->groupBy('e.id')
                                               ->orderBy('e.start_at ASC')
                                               ->execute();

                   //$this->events = $this->events1+$this->events2;
           }
           
        }
    }

    public function executeBoxEvent()
    {
        $this->county = sfContext::getInstance()->getRequest()->getParameter('county', false);

        if($this->county) {

        }
        else {
            $this->events = Doctrine::getTable('Event')
                            ->createQuery('e')
                            //->innerJoin('e.Translation t WITH t.lang = ?', $this->getUser()->getCulture())
                            ->innerJoin('e.Image')
                            ->where('e.location_id = ?', $this->getUser()->getCity()->getId())
                            ->andWhere('e.start_at > '.ProjectConfiguration::nowAlt().'')
                            ->orderby('e.start_at')
                            ->limit(3)
                            ->execute();
        }
    }
  
    public function executeBoxReviews()
    {
        $settings = $this->box->getSettings();

        $review_ids  = $this->getRequest()->getAttribute('box_review_ids', array());

        $this->county = sfContext::getInstance()->getRequest()->getParameter('county', false);

        $cq = Doctrine_Query::create()
            ->select('r.id')
            ->from('Review r')
            ->innerJoin('r.Company c')
            //->innerJoin('c.Sector s')
            //->innerJoin('s.Translation')
            ->innerJoin('c.Classification cf')
            ->innerJoin('cf.ClassificationSector cs');
            //->innerJoin('cf.Translation')
            //->leftJoin('c.Image i')
            //->innerJoin('r.UserProfile p')
            //->innerJoin('p.City')
            //->innerJoin('p.sfGuardUser sf');        

        if ($this->county) {
            $cq->innerJoin('c.City ci')
            ->andWhere('ci.county_id = ?', $this->getUser()->getCounty()->getId());        
        }
        else {
            $cq->andWhere('c.city_id = ?', $this->getUser()->getCity()->getId());
        }

        if(isset($settings['sector_id']))
        {
          $cq->andWhere('cs.sector_id = ?', $settings['sector_id']);
        }
        $criteriaQuery = $cq
                        ->orderBy('r.recommended_at DESC')
                        ->andWhereNotIn('r.id', $review_ids)
                        ->andWhere('r.parent_id IS NULL')
                        ->andWhere('c.status = ?', 0)
                        ->limit(3)
                        ->groupBy('r.id')
                        ->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR)
                        ->execute();
        
//         var_dump($criteriaQuery);die;

        $reviews_q = Doctrine::getTable('Review')
                        ->createQuery('r')
                        ->whereIn('r.id', $criteriaQuery ? $criteriaQuery : array(0));
        $reviews_q->useResultCache(true,3600,'box_reviews_'.serialize($reviews_q->getCountQueryParams()));
        
        $this->reviews = $reviews_q->execute();
        
//         var_dump($this->reviews->toArray());die;

        $this->getRequest()->setAttribute('box_review_ids', array_merge($review_ids, $this->reviews->getPrimaryKeys()));
    }

     public function executeBoxReview()
    {
        $settings = $this->box->getSettings();

        $review_ids  = $this->getRequest()->getAttribute('box_review_ids', array());

        $this->county = sfContext::getInstance()->getRequest()->getParameter('county', false);    

        $query = Doctrine::getTable('Review')
        ->createQuery('r')
        ->innerJoin('r.Company c')
        ->innerJoin('c.City ci')
        ->innerJoin('c.Sector s')
        ->innerJoin('s.Translation')
        ->innerJoin('c.Classification cf')
        ->innerJoin('cf.ClassificationSector cs')
        ->innerJoin('cf.Translation')
        ->innerJoin('r.UserProfile p')
        ->innerJoin('p.sfGuardUser sf')
        ->andWhere('r.parent_id IS NULL')
        ->andWhereNotIn('r.id', $review_ids)
        ->andWhere('c.status = ?', 0)
        ->orderBy('r.recommended_at DESC')
        ->limit(1);
        if($this->county){
            $query->andWhere('ci.county_id = ?', $this->getUser()->getCounty()->getId());
        }else{
        	$query->andWhere('c.city_id = ?', $this->getUser()->getCity()->getId());
        }
        
        if(isset($settings['sector_id']))
        {
          $query->andWhere('cs.sector_id = ?', $settings['sector_id']);
        }
        
        $relations_array = array('Review'=>array('Company','UserProfile'),'Company'=>array('City','Sector','Classification'));
        $query->useResultCache(true,3600,"box_review_".serialize($query->getCountQueryParams()),$relations_array);

//         var_dump($query->fetchOne()->toArray());die;
        
        if($this->review = $query->fetchOne())
          $review_ids[] = $this->review->getId();

        $this->getRequest()->setAttribute('box_review_ids', $review_ids);
    }

    public function executeBoxOffers()
    {
    	$this->county = sfContext::getInstance()->getRequest()->getParameter('county', false);
    	
    	if(!isset($this->smallerContainer)){
    		$this->smallerContainer = false;
    	}
    	if(!isset($this->inSlider)){
    		$this->inSlider = false;
    	}

        $query = Doctrine::getTable('CompanyOffer')
        ->createQuery('o')
        ->leftJoin('o.Image i')
        ->leftJoin('o.Translation as ot')//WITH ot.lang=?',$this->getUser()->getCulture()
        ->innerJoin('o.Company c')
        ->innerJoin('c.Translation as ct WITH ct.lang=?',$this->getUser()->getCulture())
        ->innerJoin('c.Classification')
        ->innerJoin('c.City ci')
        ->innerJoin('c.AdServiceCompany adc WITH adc.ad_service_id = 13 AND adc.status = "active" and ((adc.active_to is null AND adc.crm_id is not null) OR (adc.active_to >= '.ProjectConfiguration::nowAlt().' AND  adc.crm_id is null)) ')
        ->andWhere('o.active_from < '.ProjectConfiguration::nowAlt().' and o.active_to > '.ProjectConfiguration::nowAlt().' and o.is_active = true and o.is_draft = 0')
        ->andWhere('o.image_id is not null')
        ->addOrderBy('RAND(o.active_from)')
        ->limit(10);
        if($this->county){
        	$query->andWhere('ci.county_id = ?', $this->getUser()->getCounty()->getId());
        }else{
        	$query->andWhere('c.city_id = ?', $this->getUser()->getCity()->getId());
        }

        if(isset($this->sector_id))
        {
        	$query->andWhere('c.sector_id = ?', $this->sector_id);
        }

        $relations_array = array("CompanyOffer"=>"Company");
        $query->useResultCache(true,10*60,'box_offers_'.serialize($query->getCountQueryParams()),$relations_array);
        
      	$this->offers = $query->execute();
//       	var_dump($this->offers->toArray());die;
      	$culture = sfContext::getInstance()->getUser()->getCulture();
      	$domain = getlokalPartner::getDefaultCulture();
      	
      	//E.G for romainan partner if language is en and there is only ro translation, display ro.
      	foreach($this->offers as &$o){
      		if(empty($o->Translation[$culture]) && !empty($o->Translation[$domain])){
      			$o->Translation[$culture] = $o->Translation[$domain];
      		}
      	}unset($o);
      	
//       	var_dump($this->offers->toArray());die;

//     	$this->offers = $query->execute();

    	$query = Doctrine::getTable('Company')
	    	->createQuery('c')
	    	->innerJoin('c.Classification')
	    	->innerJoin('c.City')
	    	->innerJoin('c.AdServiceCompany adc WITH adc.ad_service_id = 11 AND adc.status = "active" and ((adc.active_to is null AND adc.crm_id is not null) OR (adc.active_to >= '.ProjectConfiguration::nowAlt().' AND  adc.crm_id is null)) ')
	    	->innerJoin('adc.CompanyOffer o')
	    	->andWhere('o.active_from < '.ProjectConfiguration::nowAlt().' and o.active_to > '.ProjectConfiguration::nowAlt().' and o.is_active = true and o.is_draft = 0')
	    	->andWhere('c.city_id = ?', $this->getUser()->getCity()->getId())
	    	->addOrderBy('RAND()')
	    	->limit(3);

    	if(isset($this->sector_id))
    	{
    		$query->andWhere('c.sector_id = ?', $this->sector_id);
    	}

    	$this->vips = $query->execute();
    }

  public function executeBoxOffer()
  {
  	if(isset($this->box)) $settings = $this->box->getSettings();
  	
  	$this->county = sfContext::getInstance()->getRequest()->getParameter('county', false);
  	
  	if ($this->county) {
  	    $query = Doctrine::getTable('Company')
  	                ->createQuery('c')
  	                ->innerJoin('c.Classification')
  	                ->innerJoin('c.City ci')
  	                ->innerJoin('c.AdServiceCompany adc WITH adc.ad_service_id = 13')
  	                ->innerJoin('c.CompanyOffer co')
  	                ->andWhere('adc.status = "active"
                              and ((adc.active_to is null AND adc.crm_id is not null)
                              OR (adc.active_to >= '.ProjectConfiguration::nowAlt().' AND  adc.crm_id is null))')
  	                ->andWhere('ci.county_id = ?', $this->getUser()->getCounty()->getId())
  	                ->andWhere('co.active_to >= '.ProjectConfiguration::nowAlt().' AND co.active_from <= '.ProjectConfiguration::nowAlt().' AND co.is_active=true')
  	                ->addOrderBy('RAND()')
  	                ->limit(4);
  	}
  	else {
        $query = Doctrine::getTable('Company')
                    ->createQuery('c')
                    ->innerJoin('c.Classification')
                    ->innerJoin('c.City')
                    ->innerJoin('c.AdServiceCompany adc WITH adc.ad_service_id = 13')
                    ->innerJoin('c.CompanyOffer co')
                    ->andWhere('adc.status = "active"
                              and ((adc.active_to is null AND adc.crm_id is not null)
                              OR (adc.active_to >= '.ProjectConfiguration::nowAlt().' AND  adc.crm_id is null))')
                    ->andWhere('c.city_id = ?', $this->getUser()->getCity()->getId())
                    ->andWhere('co.active_to >= '.ProjectConfiguration::nowAlt().' AND co.active_from <= '.ProjectConfiguration::nowAlt().' AND co.is_active=true')
                    ->addOrderBy('RAND()')
                    ->limit(4);
  	}

        if(isset($settings['sector_id'])){
            $query->andWhere('c.sector_id = ?', $settings['sector_id']);
        }

        $this->vips = $query->execute();
    }

    public function executeBoxVip()
    {
    	if(isset($this->box)) $settings = $this->box->getSettings();

    	$this->county = sfContext::getInstance()->getRequest()->getParameter('county', false);

    	$query = Doctrine::getTable('Company')
	    	->createQuery('c')
	    	->innerJoin('c.Translation as ct WITH ct.lang=?',$this->getUser()->getCulture())
	    	->innerJoin('c.Classification')
	    	->innerJoin('c.City ci')
	    	->innerJoin('c.AdServiceCompany adc')
	    	->where('c.id is not null')
	    	->addWhere('adc.ad_service_id = 11')
	    	->andWhere('adc.status = "active"')
	    	->andWhere('((adc.active_to is null AND adc.crm_id is not null) OR (adc.active_to >= '.ProjectConfiguration::nowAlt().' AND  adc.crm_id is null)) ')
	    	->addOrderBy('RAND()')
	    	->limit(3);
    	if ($this->county) {
    		$query->andWhere('ci.county_id = ?', $this->getUser()->getCounty()->getId());
    	}else{
    		$query->andWhere('c.city_id = ?', $this->getUser()->getCity()->getId());
    	}

    	if(isset($settings['sector_id']))
    	{
    		$query->andWhere('c.sector_id = ?', $settings['sector_id']);
    	}

    	$relations_array = array(
    		"Company"=>array("AdServiceCompany","City")
    	);
    	//5 min cache because of ORDER BY RAND() to work
    	$query->useResultCache(true,5*60,"box_vip3_".serialize($query->getCountQueryParams()),$relations_array);
    	$this->vips = $query->execute();
  }

  public function executeBoxVip2()
    {
    	if(isset($this->box)) $settings = $this->box->getSettings();

    	$this->county = sfContext::getInstance()->getRequest()->getParameter('county', false);


    	$query = Doctrine::getTable('Company')
	    	->createQuery('c')
	    	->innerJoin('c.Classification')
	    	->innerJoin('c.City ci')
	    	->innerJoin('c.AdServiceCompany adc')
	    	->where('c.id is not null')
	    	->addWhere('adc.ad_service_id = 11')
	    	->andWhere('adc.status = "active"')
	    	->andWhere('((adc.active_to is null AND adc.crm_id is not null) OR (adc.active_to >= '.ProjectConfiguration::nowAlt().' AND  adc.crm_id is null)) ')
	    	->addOrderBy('RAND()')
	    	->limit(10);

    	if ($this->county) {
    		$query->andWhere('ci.county_id = ?', $this->getUser()->getCounty()->getId());
    	}else{
    		$query->andWhere('c.city_id = ?', $this->getUser()->getCity()->getId());
    	}

    	if(isset($settings['sector_id']))
    	{
    		$query->andWhere('c.sector_id = ?', $settings['sector_id']);
    	}

    	$this->vips = $query->execute();
  }

  public function executeTest()
  {
        $this->settings = $this->box->getSettings();

        $query = Doctrine::getTable('Company')
                ->createQuery('c')
                ->innerJoin('c.Image i')
                ->limit($this->settings['limit']);

        if(isset($this->city)) $query->orderBy('c.city_id = '.$this->city->getId().' DESC');

        switch($this->settings['type'])
        {
            case 'ids':
              $query->andWhereIn('c.id', $this->settings['ids']);
              break;
            case 'category':
              $query->andWhere('c.category_id = ?', $this->settings['category_id']);
              break;
            case 'default':
              $query->addOrderBy('c.rating DESC');
        }
    }

    public function executeBoxVote(sfWebRequest $request)
    {

        $this->futures = Doctrine::getTable('Feature')
                        ->createQuery('f')
                        ->select('f.*,ft.name as name, pf.voted_yes AS vot_yes, pf.voted_no AS vot_no')
                        ->innerJoin('f.Translation as ft WITH ft.lang=?',$this->getUser()->getCulture())
                        ->innerJoin('f.SectorFeature sf ')
                        ->innerJoin('sf.Sector s ')
                        ->innerJoin('s.ClassificationSector cs ')
                        ->innerJoin('cs.Classification c')
                        ->innerJoin('c.CompanyClassification cc WITH cc.company_id = ?', $this->company->getId() )
                        ->leftJoin('f.PlaceFeature pf WITH pf.feature_id=f.id and pf.page_id = ? ', $this->company->getCompanyPage()->getId() )
                        //->where('pf.page_id = ?', $this->company->getCompanyPage()->getId())
                        ->orderBy('pf.voted_yes DESC')
                        ->execute();

        $this->pageId=$this->company->getCompanyPage()->getId();
    }
    
    public function executeBoxSingleSliderEvents(){
    	//ob_clean();
    	$request = $this->getRequest();
    	$sector = $request->getParameter('sector');
    	$slug = $request->getParameter('slug');
    	$this->events = array();
    	if(!is_null($sector) && $sector != ''){
    		//echo 1;
    		$classification = Doctrine::getTable('Classification')->findOneBySlug($slug);
    		$this->events = EventTable::getSingleSliderEvents('classification', $classification->getId());
    		if(!sizeof($this->events)){
    			//echo 2;
    			$sector = Doctrine::getTable('Sector')->findOneBySlug($sector);
    			$this->events = EventTable::getSingleSliderEvents('sector', $sector->getId());
    		}
    		if(!sizeof($this->events)){
    			//echo 3;
    			$this->events = EventTable::getSingleSliderEvents();
    		}
    	}else{
    		//echo 4;
    		$sector = Doctrine::getTable('Sector')->findOneBySlug($slug);
    		$this->events = EventTable::getSingleSliderEvents('sector', $sector->getId());
    		//var_dump(is_array($this->events), sizeof($this->events), empty($this->events));
    		/*foreach ($this->events as $e){
    			echo $e->getId().'^ ';
    		}*/
    		if(!sizeof($this->events)){
    			//echo 5;
    			$this->events = EventTable::getSingleSliderEvents();
    		}
    	} 
    	//die;   	
    	//$this->events = EventTable::getSingleSliderEvents(24);
    	
    }
    
    public function executeBoxSingleSliderOffers(){
    	$request = $this->getRequest();
    	$this->county = sfContext::getInstance()->getRequest()->getParameter('county', false);

        $query = Doctrine::getTable('CompanyOffer')
        ->createQuery('o')
        ->leftJoin('o.Image i')
        ->innerJoin('o.Translation as ot WITH ot.lang=?',$this->getUser()->getCulture())
        ->innerJoin('o.Company c')
        ->innerJoin('c.Classification')
        ->innerJoin('c.City ci')
        ->innerJoin('c.AdServiceCompany adc WITH adc.ad_service_id = 13 AND adc.status = "active" and ((adc.active_to is null AND adc.crm_id is not null) OR (adc.active_to >= '.ProjectConfiguration::nowAlt().' AND  adc.crm_id is null)) ')
        ->andWhere('o.active_from < '.ProjectConfiguration::nowAlt().' and o.active_to > '.ProjectConfiguration::nowAlt().' and o.is_active = true and o.is_draft = 0')
        ->andWhere('o.image_id is not null')
        ->addOrderBy('RAND(o.active_from)')
        ->limit(10);
        if($this->county){
          $query->andWhere('ci.county_id = ?', $this->getUser()->getCounty()->getId());
        }else{
          $query->andWhere('c.city_id = ?', $this->getUser()->getCity()->getId());
        }

        if(isset($this->sector_id))
        {
          $query->andWhere('c.sector_id = ?', $this->sector_id);
        }

        $relations_array = array("CompanyOffer"=>"Company");
//         $query->useResultCache(true,3600,'box_offers_'.serialize($query->getCountQueryParams()),$relations_array);
        
        $this->offers = $query->execute();
        
//        var_dump($this->offers->toArray());die;

      $this->offers = $query->execute();

      $query = Doctrine::getTable('Company')
        ->createQuery('c')
        ->innerJoin('c.Classification')
        ->innerJoin('c.City')
        ->innerJoin('c.AdServiceCompany adc WITH adc.ad_service_id = 11 AND adc.status = "active" and ((adc.active_to is null AND adc.crm_id is not null) OR (adc.active_to >= '.ProjectConfiguration::nowAlt().' AND  adc.crm_id is null)) ')
        ->innerJoin('adc.CompanyOffer o')
        ->andWhere('o.active_from < '.ProjectConfiguration::nowAlt().' and o.active_to > '.ProjectConfiguration::nowAlt().' and o.is_active = true and o.is_draft = 0')
        ->andWhere('c.city_id = ?', $this->getUser()->getCity()->getId())
        ->addOrderBy('RAND()')
        ->limit(3);

      if(isset($this->sector_id))
      {
        $query->andWhere('c.sector_id = ?', $this->sector_id);
      }

      $this->vips = $query->execute();
    }
}
