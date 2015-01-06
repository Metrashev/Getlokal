<?php

/**
 * Lists
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
    class Lists extends BaseLists
    {
        const FRONTEND_LISTS_PER_TAB = 20;
        const COMPANY_LISTS_PER_PAGE = 4;
 
        public function preSave($param){
        	$this->setTitle(strip_tags($this->getTitle()));
        	$this->setDescription(strip_tags($this->getDescription()));
        }
        
        public function getAllListPage($limit = null)
        {
            $q =  Doctrine_Query::create()
              ->select('lp.*,cp.*,c.*,ct.*,cl.id as cl_id, cl.latitude as lat, cl.longitude as lon')
              ->from('ListPage lp')
              ->innerJoin('lp.CompanyPage cp')
              ->innerJoin('cp.Company c')
              ->innerJoin('c.City ct')
              ->innerJoin('c.CompanyLocation cl')
              ->where('lp.list_id = ?', $this->getId() )
              ->andWhere('c.status = ? ', CompanyTable::VISIBLE)
              //->orderBy('lp.rank ASC');  
              ->orderBy('field(ct.id,'.sfContext::getInstance()->getUser()->getCity()->getId().') DESC, field(c.country_id,'.sfContext::getInstance()->getUser()->getCountry()->getId().') DESC, lp.rank ASC') ;
            if ($limit){
                $q->limit($limit);
            }

            return $q->execute();
        }
        
        public function getThumb($size = 1)
        {
            if (! $this->getImage () || $this->getImage ()->isNew ()) {
                $image = new Image ();
		$sizes = $image->getFile ()->getOption ( 'sizes' );

                return 'gui/default_place_' . $sizes [$size] . '.jpg';
            }
     
            return $this->getImage ()->getThumb ( $size );
        } 
 
        public function postInsert($event) 
        {
            parent::postInsert ( $event );
		
	    $activity = Doctrine::getTable('ActivityList')->getActivity($this->getId());
            $activity->setText($this->getDescription());
            $activity->setCaption($this->getTitle());
            $activity->setUserId($this->getUserId());

            $activity->save();
	}

        public static function getPagerOfListsForArticleSearchByTitle($listName, $page = 1, $articleId, $row = 10, $culture = null)
        {
            if (empty($culture)){
                $culture = sfContext::getInstance()->getUser()->getCulture();
            }
            
            $listName = mb_convert_case($listName, MB_CASE_TITLE, "UTF-8");
            $listName= "%" . $listName . "%";
            //print_r($listName);exit();
            $query = Doctrine::getTable('Lists')
                ->createQuery('l')
                ->innerJoin('l.Translation lt')
                ->leftJoin('l.ListPage lp')
                ->where ( '(lt.title LIKE ?) ', array ($listName) )
                ->addWhere('l.status = ?','approved')
                ->addWhere('lp.list_id IN (SELECT id FROM ListPage GROUP BY list_id HAVING count(id) > 2)')
                ->orderBy('l.created_at DESC')
                ->limit(10);

            $q2 = $query->createSubquery ()->select ( 'al.list_id' )
                ->from ( 'ArticleList al' )
                ->andWhere('al.article_id = ?', $articleId);

            $query->andWhere ( 'l.id NOT IN (' . $q2->getDql () . ')' );

            //print_r($query->getSqlQuery());exit();
            $pages = $query->execute();
            /*
             $pager = new sfDoctrinePager ( 'Page', $row );
            $pager->setQuery($query);
            $pager->setPage ( $page );
            $pager->init ();
            */
            return $pages;
        }
  
        public function getTitle($culture = null) 
        {
            if(is_null($culture)){
                $culture = sfContext::getInstance()->getUser()->getCulture();
            }
            
            if ($this->Translation[$culture]->_get('title', $culture)){
                $title =  $this->Translation[$culture]->_get('title', $culture);
            }
         //   if(!isset($title) || $title=='' || $title===null){
         //       $title = $this->Translation['en']->_get('title', 'en');
         //   }
            if(!isset($title) || $title=='' || $title===null){
                $list_query = Doctrine::getTable ( 'ListsTranslation' )
                    ->createQuery ( 'lt' )
                    ->where ( 'lt.id = ?', $this->getId ())
                    ->andWhere ( 'lt.lang = ?', 'en'  )
                    ->fetchOne ();

                $title = $list_query['title'];
            }
            
            
            
            return $title;
        }
  
        public function getPlaces($count = false) 
        {
            $query = Doctrine::getTable('Company')
                ->createQuery('c')
                ->innerJoin('c.CompanyPage cp')
                ->innerJoin('cp.ListPage lp')
                ->innerJoin('lp.Lists l')
                ->where('l.id = ?', $this->getId())
                ->andWhere('c.status = ?', CompanyTable::VISIBLE);
            if ($count == true)
            {
                return $query->count();
            }else{
                return $query->execute();
            }
        }
    }