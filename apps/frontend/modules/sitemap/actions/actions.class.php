<?php

/**
 * sitemap actions.
 *
 * @package    gp
 * @subpackage sitemap
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class sitemapActions extends sfActions {
	public function preExecute() {
		$this->getResponse ()->setContentType ( 'text/xml; charset=utf-8' );
	}
/*
 *
 * OLD SITEMAP
 * 
 */
	public function executeIndex() {
		$query = Doctrine::getTable ( 'Company' )->createQuery ( 'c' )->where ( 'c.country_id = ?', getlokalPartner::getInstance () )->andWhere ( 'c.status = 0 ' );
	
		$this->pager = new sfDoctrinePager ( 'Company', 500 );
		$this->pager->setQuery ( $query );
		$this->pager->init ();
	
		$this->classifications = Doctrine::getTable ( 'Classification' )->createQuery ( 'c' )->innerJoin ( 'c.Translation t' )->innerJoin ( 'c.PrimarySector s' )->innerJoin ( 's.Translation st' )->where ( 't.is_active = 0 AND c.status = 1' )->addOrderBy ( 's.id' )->execute ();
	
		$query = Doctrine::getTable ( 'Event' )->createQuery ( 'e' )->where ( 'e.country_id = ?', $this->getUser ()->getCountry ()->getId () )->andWhere ( 'e.is_active = 1 ' );
	
		$this->pager2 = new sfDoctrinePager ( 'Event', 500 );
		$this->pager2->setQuery ( $query );
		$this->pager2->init ();
	
	
	
		$query =Doctrine_Core::getTable('Article')
		->createQuery('a')
		->innerJoin('a.Translation at')
		->where('a.country_id = ?',$this->getUser()->getCountry()->getId() )
		->addWhere('a.status = "approved"')
		->orderBy('a.created_at DESC');
			
		//Doctrine::getTable ( 'Article' )->createQuery ( 'a' )->where ( 'a.country_id = ?', $this->getUser ()->getCountry ()->getId () )->andWhere ( 'a.status = "approved" ' );
	
		$this->pager3 = new sfDoctrinePager ( 'Article', 500 );
		$this->pager3->setQuery ( $query );
		$this->pager3->init ();
                
                
                $query = CompanyOfferTable::getOnlyActiveOffersQuery(null, $this->getUser ()->getCountry ()->getId ());

		$this->pager4 = new sfDoctrinePager ( 'CompanyOffer', 500 );
		$this->pager4->setQuery ( $query );
		$this->pager4->init ();
		
    ///////TO DO SiteMap Review
		$query = Doctrine::getTable('Review')
		->createQuery('r')
		->innerJoin('r.Company c')
        ->innerJoin('r.ActivityReview a')
        ->innerJoin('r.UserProfile p')
        ->innerJoin('c.City ci')
        ->innerJoin('c.Classification ca')
        ->innerJoin('ca.Translation')
        ->innerJoin('c.Sector s')
        ->innerJoin('s.Translation')
        ->innerJoin('p.sfGuardUser sf')
        ->leftJoin('a.UserLike l WITH l.user_id = ?', $this->getUser()->getId())
		->where('c.country_id = ?', $this->getUser()->getCountry()->getId())
		->addWhere('c.status = ?', 0)
		->orderBy ( 'r.created_at DESC' );
	
		$this->pager5 = new sfDoctrinePager ( 'Review', 500 );
		$this->pager5->setQuery($query);
		$this->pager5->init ();
	////////		
	}
	
	
/*
 *
 *   SITEMAP LOCATION
 *
 */
	public function executeIndexLocation() {
				
		$this->classifications = Doctrine::getTable ( 'Classification' )
		    ->createQuery ( 'c' )
		    ->innerJoin ( 'c.Translation t' )
		    ->innerJoin ( 'c.PrimarySector s' )
		    ->innerJoin ( 's.Translation st' )
		    ->where ( 't.is_active = 0 AND c.status = 1' )
		    ->addOrderBy ( 's.id' )
		    ->execute ();
	
	}
	
	public function executeLocation() {
		$this->slug = str_replace ( 'sitemap_classifier_', '', $this->getRequestParameter ( 'slug' ) );
	
		$q = Doctrine::getTable ( 'Classification' )
			->createQuery ( 'c' )
			->leftJoin  ( 'c.Translation t' )
			->innerJoin ( 'c.PrimarySector s' )
			->innerJoin ( 's.Translation' )
			->where ( 't.slug = ?', $this->slug )
			->andWhere ( 't.is_active = 0 AND c.status = 1' )
			->andWhere ( 't.lang = ?', 'en' );
		
		$this->classification = $q->fetchOne ();
	
		if (! $this->classification) {
			$q = Doctrine::getTable ( 'Classification' )
				->createQuery ( 'c' )
				->leftJoin ( 'c.Translation t' )
				->innerJoin ( 'c.PrimarySector s' )
				->innerJoin ( 's.Translation' )
				->where ( 't.old_slug = ?', $this->slug )
				->andWhere ( 't.is_active = 0 AND c.status = 1' )
				->andWhere ( 't.lang = ?', 'en' );
			
			$this->classification = $q->fetchOne ();
			if ($this->classification) {
	
				$old_slug = $this->classification->Translation ['en']->slug;
					
			}
		}
	
		$this->forward404Unless ( $this->classification );
		$query = Doctrine::getTable ( 'City' )
			->createQuery ( 's' )
			->innerJoin('s.Translation ct')
			->innerJoin ( 's.Company c' )
			->innerJoin ( 'c.CompanyClassification cc' )
			->where ( 'cc.classification_id = ? ', $this->classification->getId () )
			->addWhere ( 'c.status = ? ', CompanyTable::VISIBLE )
			->addWhere ( 'c.country_id = ? ', getlokalPartner::getInstance () )
			->addOrderBy ( 'ct.name' )
			->distinct ();
		
		$this->locations = $query->execute ();
		
		if (isset ( $old_slug )) {
			$this->redirect ( '@sitemap?action=location&slug=sitemap_classifier_' . $old_slug, 301 );
		}
	
	}
	
	public function executeClassification(sfWebRequest $request) {
		//  $this->forward404Unless($this->city = Doctrine::getTable('City')->findOneBySlug($request->getParameter('city')));
	
		$this->classifiers = Doctrine::getTable ( 'Classification' )
		->createQuery ( 'c' )
		->innerJoin ( 'c.Translation t' )
		->innerJoin ( 'c.PrimarySector s' )
		->innerJoin ( 's.Translation' )
		->where ( 't.is_active = 0 AND c.status = 1' )
		->execute ();
	}
	

/*
 *
 *   END SITEMAP LOCATION
 *
 */	

/*
 *
 *   SITEMAP COMPANY
 *
 */	
	
	public function executeIndexCompany() {
	
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		
		
		$conn = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh ();
		$q="SELECT COUNT( * ) FROM company AS c WHERE c.country_id =".getlokalPartner::getInstance ()." AND c.status =0";
		$num_result = $conn->query($q) ;
		
		$result = $num_result->fetch();
		$this->pages = ceil($result[0]/500);
		
		/*
		$query = Doctrine::getTable ( 'Company' )
					->createQuery ( 'c' )
					->where ( 'c.country_id = ?', getlokalPartner::getInstance () )
					->andWhere ( 'c.status = 0 ' )
					->limit ( 10000 );
		
		$query3 = Doctrine::getTable ( 'Sitemaps' )
		->createQuery ( 's' );
		
		$this->last_mod = array();
		*/
		
		/*
		$this->pager = new sfDoctrinePager ( 'Company', 1000 );
		$this->pager->setQuery ( $query );
		$this->pager->init ();
		*/
		
		
		
		/*
		for ($i = 1; $i <= $this->pages; $i ++){
			
			
			$query->offset ( ($i - 1) * 10000 );
	
			
			$companies = $query->execute();

			$query3->where('s.sitemap="company" and s.page=? and s.country_id = ?', array($i, $this->getUser ()->getCountry ()->getId () ));
			$sitemap = $query3->fetchOne();
			
			if ($sitemap){
				if ($companies->getFirst()->getId()!=$sitemap->getFId() || $companies->getLast()->getId()!=$sitemap->getLId() )
				{
					$sitemap->setFId($companies->getFirst()->getId());
					$sitemap->setLId($companies->getLast()->getId());
					$sitemap->setLastMod(date('Y-m-d'));
					$sitemap->save();
				}
			}else{
				$sitemap = new Sitemaps();
				$sitemap->setSitemap('company');
				$sitemap->setPage($i);
				$sitemap->setCountryId($this->getUser ()->getCountry ()->getId ());
				$sitemap->setFId($companies->getFirst()->getId());
				$sitemap->setLId($companies->getLast()->getId());
				$sitemap->setLastMod(date('Y-m-d'));
				$sitemap->save();
			}

			$this->last_mod[$i]=$sitemap->getLastMod();
		}
			*/	
		//exit();
	}

	public function executeCompany(sfWebRequest $request) {
		$query = Doctrine::getTable ( 'Company' )
			->createQuery ( 'c' )
			->where ( 'c.country_id = ?', getlokalPartner::getInstance () )
			->andWhere ( 'c.status = 0 ' )
			->offset ( ($request->getParameter ( 'page' ) - 1) * 500 )
			->orderBy ( 'c.id' )->limit ( 500 );
                $this->culture = $request->getParameter('culture');
		$this->companies = $query->execute ();      
	}
	
/*
 *
 *   END SITEMAP COMPANY
 *
 */
		
/* 
 *   
 *   SITEMAP EVENTS
 *  
 */	
	public function executeIndexEvents() {
		
		$query = Doctrine::getTable ( 'Event' )
			->createQuery ( 'e' )
			->innerJoin ( 'e.Translation t' )
			->where ( 'e.country_id = ?', $this->getUser ()->getCountry ()->getId () )
			->andWhere ( 'e.is_active = 1 ' )
			->orderBy ( 'e.start_at' );
		
		
		
		$query2 = clone $query;
		$query2->limit ( 500 );
		
		$this->pager2 = new sfDoctrinePager ( 'Event', 500 );
		$this->pager2->setQuery ( $query );
		$this->pager2->init ();

		$last_page = $this->pager2->getLastPage();
		
		$query3 = Doctrine::getTable ( 'Sitemaps' )
					->createQuery ( 's' );
		
		$this->last_mod = array();
		
		for ($i = 1; $i <= $last_page; $i ++){
			$query2->offset ( ($i - 1) * 500 );
			$events = $query2->execute();
			
			$query3->where('s.sitemap="event" and s.page=? and s.country_id = ?', array($i, $this->getUser ()->getCountry ()->getId () ) );
			$sitemap = $query3->fetchOne();
			
			if ($sitemap){
				if ($events->getFirst()->getId()!=$sitemap->getFId() || $events->getLast()->getId()!=$sitemap->getLId() )
				{
					$sitemap->setFId($events->getFirst()->getId());
					$sitemap->setLId($events->getLast()->getId());
					$sitemap->setLastMod(date('Y-m-d'));
					$sitemap->save();
				}
			}else{
				$sitemap = new Sitemaps();
				$sitemap->setSitemap('event');
				$sitemap->setPage($i);
				$sitemap->setCountryId($this->getUser ()->getCountry ()->getId ());
				$sitemap->setFId($events->getFirst()->getId());
				$sitemap->setLId($events->getLast()->getId());
				$sitemap->setLastMod(date('Y-m-d'));
				$sitemap->save();
				//exit('2');
			}
			
			$this->last_mod[$i]=$sitemap->getLastMod();
			
		}
		
	}
	
	public function executeEvent(sfWebRequest $request) {
		
		$query = Doctrine::getTable ( 'Event' )
					->createQuery ( 'e' )
					->innerJoin ( 'e.Translation t' )
					->where ( 'e.country_id = ?', $this->getUser ()->getCountry ()->getId () )
					->andWhere ( 'e.is_active = 1 ' )
					->offset ( ($request->getParameter ( 'page' ) - 1) * 500 )
					->orderBy ( 'e.start_at' )->limit ( 500 );
	
		$this->events = $query->execute ();
		
	}
/*
 *
 *  END SITEMAP EVENTS
 *
 */	

/*
 *
 *   SITEMAP ARTICLES
 *
 */
	
	public function executeIndexArticles() {
		
		$query =Doctrine_Core::getTable('Article')
					->createQuery('a')
					->innerJoin('a.Translation at')
					->where('a.country_id = ?',$this->getUser()->getCountry()->getId() )
					->addWhere('a.status = "approved"')
					->orderBy('a.created_at ASC');
		
		$query2 = clone $query;
		$query2->limit ( 500 );
		
		$this->pager3 = new sfDoctrinePager ( 'Article', 500 );
		$this->pager3->setQuery ( $query );
		$this->pager3->init ();	

		$last_page = $this->pager3->getLastPage();
		
		$query3 = Doctrine::getTable ( 'Sitemaps' )
					  ->createQuery ( 's' );
		
		$this->last_mod = array();
		
		for ($i = 1; $i <= $last_page; $i ++){
			$query2->offset ( ($i - 1) * 500 );
			$articles = $query2->execute();

			
			$query3->where('s.sitemap="article" and s.page=? and s.country_id = ?', array($i, $this->getUser ()->getCountry ()->getId () ) );
			$sitemap = $query3->fetchOne();
				
			if ($sitemap){
				if ($articles->getFirst()->getId()!=$sitemap->getFId() || $articles->getLast()->getId()!=$sitemap->getLId() )
				{
					$sitemap->setFId($articles->getFirst()->getId());
					$sitemap->setLId($articles->getLast()->getId());
					$sitemap->setLastMod(date('Y-m-d'));
					$sitemap->save();
				}
			}else{
				$sitemap = new Sitemaps();
				$sitemap->setSitemap('article');
				$sitemap->setPage($i);
				$sitemap->setCountryId($this->getUser ()->getCountry ()->getId ());
				$sitemap->setFId($articles->getFirst()->getId());
				$sitemap->setLId($articles->getLast()->getId());
				$sitemap->setLastMod(date('Y-m-d'));
				$sitemap->save();
				//exit('2');
			}
			
			$this->last_mod[$i]=$sitemap->getLastMod();
				
		}
		
	}

	public function executeArticle(sfWebRequest $request) {
		
		$query =Doctrine_Core::getTable('Article')
					->createQuery('a')
					->leftJoin('a.Translation at')
					->where('a.country_id = ?',$this->getUser()->getCountry()->getId() )
					->addWhere('a.status = "approved"')
					->offset ( ($request->getParameter ( 'page' ) - 1) * 500 )
					->orderBy('a.created_at ASC')
					->limit ( 500 );
	
		$this->articles =  $query->execute ();
	
	}

	
/*
 *
 *   SITEMAP ARTICLES
 *
 */	
	
	public function executeCategories() {
	
	}
	

	
	
	public function executeClassifierslocations(sfWebRequest $request) {
		//  $this->forward404Unless($this->city = Doctrine::getTable('City')->findOneBySlug($request->getParameter('city')));
		

		$this->classifiers_lists = $this->classifiers_locations = array ();
		$this->classifiers = Doctrine::getTable ( 'Classification' )->createQuery ( 'c' )->innerJoin ( 'c.Translation t' )->innerJoin ( 'c.PrimarySector s' )->innerJoin ( 's.Translation' )->where ( 't.is_active = 0 AND c.status = 1' )->orderBy ( 'c.id' )->execute ();
		$i = 0;
		foreach ( $this->classifiers as $classifier ) {
			
			$cities = Doctrine_Query::create ()
			->select ( 's.slug' )->from ( 'City s, s.Company c' )
			->innerJoin ( 'c.CompanyClassification cc' )
			->innerJoin( 'cc.Classification cl' )
			->where ( 'cc.classification_id = ? ', $classifier->getId () )
			->andWhere('cl.status = 1')
			->andWhere ( 'c.status = ? ', CompanyTable::VISIBLE )
			->andWhere ( 'c.country_id = ? ', getlokalPartner::getInstance () )
			->addOrderBy ( 'cc.id' )->distinct ()->fetchArray ();
			
			foreach ( getlokalPartner::getEmbeddedLanguages () as $lang ) {
			if ($classifier->Translation[$this->getUser()->getCountry()->getSlug()]->number_of_places > 0) {
			$classification_slug = $classifier->Translation [$lang]->slug;
			$sector_slug = $classifier->getPrimarySector ()->Translation [$lang]->slug;
			$this->classifiers_lists [] = $lang  . ',' . $sector_slug. ',' . $classification_slug;
			
				foreach ( $cities as $key => $val ) {
					
					//$key = $classifier->Translation [$lang]->slug . ',' . $classifier->getPrimarySector ()->Translation [$lang]->slug . ',' . $lang;
					$key = $lang . ',' . $val ['slug']  . ',' . $sector_slug . ',' . $classification_slug;
					$this->classifiers_locations [] = $key;
				}
			
			}
			}
		
		}
	
	}
        
 /*
  * 
  * SITEMAP OFFER
  * 
  */
	
    public function executeIndexOffer() {

	    $query = CompanyOfferTable::getOnlyActiveOffersQuery(null, $this->getUser ()->getCountry ()->getId ());
		
	    $query2 = clone $query;
	    $query2->limit ( 500 );
		
	    $this->pager4 = new sfDoctrinePager ( 'CompanyOffer', 500 );
	    $this->pager4->setQuery ( $query );
	    $this->pager4->init ();

	    
	}
	public function executeOffer(sfWebRequest $request) {
            $query = CompanyOfferTable::getOnlyActiveOffersQuery(null, $this->getUser ()->getCountry ()->getId ());
	    $query->offset ( ($request->getParameter ( 'page' ) - 1) * 500 );
            $this->offers = $query->execute ();

	}
 /*
  * 
  * END SITEMAP OFFER
  * 
  */

 /*
  * 
  * SITEMAP REVIEW
  *
  */
	
	public function executeIndexReviews() {
		
		ini_set('memory_limit', '1024M');
		set_time_limit(0);
		
		$query = Doctrine::getTable ( 'Review' )
              ->createQuery ( 'r' )
              ->innerJoin('r.Company c')
              ->innerJoin('r.ActivityReview a')
              ->innerJoin('r.UserProfile p')
              ->innerJoin('c.City ci')
              ->innerJoin('c.Classification ca')
              ->innerJoin('ca.Translation')
              ->innerJoin('c.Sector s')
              ->innerJoin('s.Translation')
              ->innerJoin('p.sfGuardUser sf')
              ->leftJoin('a.UserLike l WITH l.user_id = ?', $this->getUser()->getId())
              ->where ( 'r.is_published = ?', Review::FRONTEND_REVIEWS_IS_PUBLISHED )
              ->addWhere( 'r.parent_id IS NULL')
              ->addWhere('c.country_id = ?', $this->getUser()->getCountry()->getId())
              ->addWhere('c.status = ?', 0)
              ->orderBy ( 'r.created_at DESC' );
		
		$cnt = $query->count();		
		$this->pages = ceil(ceil($cnt/10)/500);
		
	}
	
	public function executeReviews(sfWebRequest $request) {

		$query = Doctrine::getTable ( 'Review' )
              ->createQuery ( 'r' )
              ->innerJoin('r.Company c')
              ->innerJoin('r.ActivityReview a')
              ->innerJoin('r.UserProfile p')
              ->innerJoin('c.City ci')
              ->innerJoin('c.Classification ca')
              ->innerJoin('ca.Translation')
              ->innerJoin('c.Sector s')
              ->innerJoin('s.Translation')
              ->innerJoin('p.sfGuardUser sf')
              ->leftJoin('a.UserLike l WITH l.user_id = ?', $this->getUser()->getId())
              ->where ( 'r.is_published = ?', Review::FRONTEND_REVIEWS_IS_PUBLISHED )
              ->addWhere( 'r.parent_id IS NULL')
              ->addWhere('c.country_id = ?', $this->getUser()->getCountry()->getId())
              ->addWhere('c.status = ?', 0)
              ->orderBy ( 'r.created_at DESC' );
	    
		$cnt = $query->count();
		$pgs = ceil($cnt/10);
		
		$this->start = ($request->getParameter ( 'page' ) - 1) * 500 + 1;
		if((($request->getParameter ( 'page' ) ) * 500) < $pgs) {
			$this->end = (($request->getParameter ( 'page' ) ) * 500 ) + 1;
			
		}
		else {
			$this->end = $pgs + 1;
			
		}
	}
}
