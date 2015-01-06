<?php
class eventComponents extends sfComponents
{
    public function executePlaces(sfWebRequest $request)
    {
        $this->culture = $this->getUser()->getCulture();
        $event = $this->event;

        $query = Doctrine::getTable('EventPage')
            ->createQuery('p')
            ->where('p.event_id = ?', array($event->getId()));

        $this->places = $query->execute();
    }

    public function executeImages(sfWebRequest $request)
    {
        $page=$request->getParameter('page','1');

        $query = Doctrine::getTable ( 'Image' )
            ->createQuery ( 'i' )
            ->innerJoin ( 'i.EventImage ei' )
            ->where ( 'ei.event_id = ?', $this->event->getId () );

        $pager = new sfDoctrinePager ( 'Image', Event::FORM_IMAGES_PER_PAGE );
        $pager->setQuery($query);
        $pager->setPage ( $page );
        $pager->init ();

        $this->pager=$pager;
    }

    public function executeRecommended(sfWebRequest $request)
    {

		$city_id = $this->city->getId();
        $page = $request->getParameter('page','1');
        $selected_tab = $request->getParameter("selected_tab","active");
        $date_selected = $request->getParameter("date_selected",date("Y-m-d"));
        $category_id = $request->getParameter("category_id",false);
        if($category_id == "all_cats") $category_id = false;
        $this->pager = Event::getTabEvents($city_id, $page, $selected_tab,$date_selected,$category_id);

        $this->is_component = 0; //setting behaviour for ajax pagination

    }

    public function executeSliderEvents()
    {
    	$culture = $this->getUser()->getCulture();
    	
        $this->events = EventTable::getRecommended();
    }

    public function executeSliderPastEvents()
    {
        $this->images = Doctrine::getTable('Image')
            ->createQuery('i')
            ->select('i.*, ei.event_id, e.id AS event_id, ec.id AS event_category_id, e.start_at AS start_at, t.title as title, ect.title AS category_title')
            ->innerJoin('i.EventImage ei')
            ->leftJoin('ei.Event e WITH ei.event_id=e.id')
            ->innerJoin('e.Translation t')
            ->innerJoin('e.Category ec')
            ->innerJoin('ec.Translation ect WITH ect.lang=?',$this->getUser()->getCulture())
            ->where('e.location_id = ?', $this->getUser()->getCity()->getId())
            ->addWhere('i.filename IS NOT NULL and i.filename != "" ')
            ->addWhere('e.start_at < ? ', array(date("Y-m-d")))
            ->addWhere('t.lang = ?', $this->getUser()->getCulture())
            ->limit(9)
            ->orderBy('RAND(),e.start_at DESC')
            ->execute();

        if (count($this->images) > 0) {
            return $this->images;
        }

        return false;
    }
    
    public function executeArticles(sfWebRequest $request)
    {
    	$this->culture = $this->getUser ()->getCulture ();
    	$events = $this->events;
    	 
    	$ev_id = array();
    	foreach ($events as $event){
    		$ev_id[]=$event->getId();
    	}
    	if (count($ev_id)){
    		$query = Doctrine::getTable('ArticleEvent')
    		->createQuery('e')
    		->whereIn('e.event_id',$ev_id)
    		->groupBy('e.article_id')
    		->limit('3')
    		->orderBy('RAND()');
    		$this->articles = $query->execute();
    	}else {$this->articles=array();}
    }
    
    public function executeRelatedPlaces(sfWebRequest $request)
    {
    	
    	$this->culture = $this->getUser ()->getCulture ();
    	$events = $this->events;
        $countryId = $this->getUser()->getCountry()->getId();

    	$ev_id = array();
    	foreach ($events as $event){
    		$ev_id[]=$event->getId();
    	}
    	//var_dump($ev_id);
    	if (count($ev_id)){
    		$query = Doctrine::getTable('EventPage')
    		->createQuery('e')
    		->innerJoin('e.CompanyPage cp')
    		->innerJoin('cp.Company c')
    		->andWhere('c.status =?', 0)
            ->andWhere('c.country_id = ?', $countryId)
    		->groupBy('c.id')
    		->limit('3')
    		->orderBy('RAND()');
    		$this->eventPages = $query->execute();
    	}else {$this->eventPages=array();}
    }
    				//		->leftJoin('cp.Company c with c.status = ? ', CompanyTable::VISIBLE)
}
