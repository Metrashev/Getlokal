<?php
class articleComponents extends sfComponents
{
    public function executePlaces(sfWebRequest $request)
    {
		$this->culture = $this->getUser ()->getCulture ();
        $article = $this->article;
        
        $query = Doctrine::getTable('ArticlePage')
              ->createQuery('p')
              ->innerJoin('p.CompanyPage cp')
              ->where ( 'p.article_id = ?', array ($article->getId()) );
              //->orderBy('p.id DESC');
        
        $this->places = $query->execute();
    }
    public function executeLists(sfWebRequest $request)
    {
    	$this->culture = $this->getUser ()->getCulture ();
    	$article = $this->article;
    
    	$query = Doctrine::getTable('ArticleList')
    	->createQuery('l')
    	->where ( 'l.article_id = ?', array ($article->getId()) );
    	//->orderBy('p.id DESC');
    
    	$this->articleLists = $query->execute();
    }
    public function executeEvents(sfWebRequest $request)
    {
    	$this->culture = $this->getUser ()->getCulture ();
    	$article = $this->article;
    
    	$query = Doctrine::getTable('ArticleEvent')
    	->createQuery('e')
    	->where ( 'e.article_id = ?', array ($article->getId()) );
    	//->orderBy('p.id DESC');
    
    	$this->articleEvents = $query->execute();
    }
    public function executeCategories(sfWebRequest $request)
    {
    	$this->culture = $this->getUser ()->getCulture ();
    	$article = $this->article;
    
    	$query = Doctrine::getTable('ArticleCategory')
    	->createQuery('c')
    	->where ( 'c.article_id = ?', array ($article->getId()) );
    	//->orderBy('p.id DESC');
    
    	$this->articleCategories = $query->execute();
    }
    
    public function executeEventsIndex(sfWebRequest $request)
    {
    	$this->culture = $this->getUser ()->getCulture ();
    	$articles = $this->articles;
    	
    	$art_id = array();
    	foreach ($articles as $article){
    		$art_id[]=$article->getId();
    	}
    	if (count($art_id)){
	    	$query = Doctrine::getTable('ArticleEvent')
	    	->createQuery('e')
	    	->whereIn('e.article_id',$art_id)
	    	->groupBy('e.event_id')
	    	->limit('3')
	    	->orderBy('RAND()');
	    	$articleEvents = $query->execute();
	    	//ob_clean();
	    	$IDs = array(0);
	    	foreach ($articleEvents as $ae){
	    		$IDs[] = $ae->getEventId();
	    	}
	    	$query = Doctrine::getTable('Event')
	    	->createQuery('e')
	    	->whereIn('id',$IDs);
	    	$this->articleEvents = $query->execute();
    	}else {
    		$this->articleEvents=array();
    	}
    }
    public function executeListsIndex(sfWebRequest $request)
    {
    	$this->culture = $this->getUser ()->getCulture ();
    	$articles = $this->articles;
    	 
    	$art_id = array();
    	foreach ($articles as $article){
    		$art_id[]=$article->getId();
    	}
    	
    	if (count($art_id)){
    	$query = Doctrine::getTable('ArticleList')
    	->createQuery('l')
    	->whereIn('l.article_id',$art_id)
    	->groupBy('l.list_id')
    	->limit('3')
    	->orderBy('RAND()');
    	$this->articleLists = $query->execute();
    	}else {$this->articleLists = array();}
    }
    
    public function executePlacesIndex(sfWebRequest $request)
    {
    	$this->culture = $this->getUser ()->getCulture ();
    	$articles = $this->articles;
    
    	$art_id = array();
    	foreach ($articles as $article){
    		$art_id[]=$article->getId();
    	}
    	if (count($art_id)){
    	$query = Doctrine::getTable('ArticlePage')
    	->createQuery('p')
    	->whereIn('p.article_id',$art_id)
    	->groupBy('p.page_id')
    	->limit('3')
    	->orderBy('RAND()');
    	$this->articlePages = $query->execute();
    	}else {$this->articlePages=array();}
    }
    
    public function executeCategory(sfWebRequest $request)
    {
    
    	//$this->culture = $this->getUser ()->getCulture ();
    	//$this->categories=0;
    	$query2 = Doctrine::getTable('ArticleCategory')
	  	->createQuery('ac')
	  	->select('ac.category_id')
	  	->leftJoin('ac.Article a')
	  	->innerJoin('a.Translation at')
	  	->where('a.status = "approved"')
	  	->addWhere('at.lang = ? ', $this->getUser ()->getCulture ())
	  	->addWhere( 'a.country_id = ?', getlokalPartner::getInstanceDomain())
	  	->groupBy('ac.category_id')
	  	->fetchArray();
    	
    	foreach ($query2 as $q){
    		$cat_id[]=$q['category_id'];
    	}
    	//exit();
    	if (isset($cat_id ) && count($cat_id)>0){
	  	$query = Doctrine::getTable('CategoryArticle')
	  	->createQuery('c')
	  	->leftJoin('c.CategoryArticleCountry cac' )
	  	//->leftJoin('c.ArticleCategory ac')
	  	->where('c.status = "approved"')
	  	->whereIn('c.id', $cat_id)
	  	//->addWhere('ac.category_id in (select id from ArticleCategory GROUP BY category_id HAVING count(id) > 2 ')
	  	->addWhere( 'cac.country_id = ?', getlokalPartner::getInstanceDomain());
    
    	$this->categories = $query->execute();
    	}
    }
    public function executeCategories_for_article(sfWebRequest $request)
    {

    	$this->categories  = Doctrine::getTable('CategoryArticle')
    	->createQuery('c')
    	->leftJoin('c.ArticleCategory ac')
    	->where('c.status = "approved"')
    	->addWhere( 'ac.article_id = ?', $this->article_id)
    	->execute();
    	 
    }
	
	public function executeRelated(sfWebRequest $request)
	{
		$categories  = Doctrine::getTable('CategoryArticle')
                ->createQuery('c')
                ->leftJoin('c.ArticleCategory ac')
                ->where('c.status = "approved"')
                ->addWhere( 'ac.article_id = ?', $this->article_id)
                ->orderBy('ac.id ASC')
                //->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR)
				->execute();
        
        $this->category = $categories[0];
        
        $this->similarArticles = array();
        
        $similarArticles = Doctrine::getTable('Article')
                ->createQuery('a')
                ->innerJoin('a.Translation at')
                ->innerJoin('a.ArticleCategory ac')
                ->innerJoin('a.ArticleSlugLog asl')
                ->where('ac.category_id = ?', $categories[0]->getId())
                ->andWhere('a.id != ?', $this->article_id)
                ->andWhere('asl.lang = ?', $request->getParameter('sf_culture'))
                ->andWhere('at.lang = ?', $request->getParameter('sf_culture'))
				->addWhere('a.status = "approved"')
                ->orderBy('a.created_at DESC')
                ->limit(3)
                ->execute();
        
        if($similarArticles->count() != 0) {
            foreach ($similarArticles as $sA) {
                $this->similarArticles[] = $sA;
            }
        }
        
        $catCount = count($categories);
        $similarArticles2 = null;
        
        if(count($this->similarArticles) && count($this->similarArticles) < 3) {
			for ($i = 1; $i < $catCount; $i++) {
                $similarArticles2 = Doctrine::getTable('Article')
                        ->createQuery('a')
                        ->innerJoin('a.Translation at')
                        ->innerJoin('a.ArticleCategory ac')
                        ->innerJoin('a.ArticleSlugLog asl')
                        ->where('ac.category_id = ?', $categories[$i]->getId())
                        ->andWhere('a.id != ?', $this->article_id)
                        ->andWhere('asl.lang = ?', $request->getParameter('sf_culture'))
                        ->andWhere('at.lang = ?', $request->getParameter('sf_culture'))
                        ->addWhere('a.status = "approved"')
                        ->orderBy('a.created_at DESC')
                        ->limit(3 - count($this->similarArticles))
                        ->execute();
               
                if ($similarArticles2->count() > 0) {
                    foreach ($similarArticles2 as $sA) {
                        $this->similarArticles[] = $sA;
                    }
                   
                $similarArticles2 = null;
                }
               
                if (count($this->similarArticles) >= 3) {
                    break;
                }
           }
        }
        
	}
    
 
}



