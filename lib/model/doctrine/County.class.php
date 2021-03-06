<?php

/**
 * County
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class County extends BaseCounty
{
	public function __toString()
	{
		return (string) $this->getLocation();
	}
	
    public function getLocation($culture = null)
    {
        if (is_null($culture)) {
            $culture = sfContext::getInstance()->getUser()->getCulture();
        }
        
        if ($culture == $this->getCountry()->getSlug()) {
            if ($this->Translation[$culture]->_get('name', $culture)) {
                $name =  $this->Translation[$culture]->_get('name', $culture);
            }
            else {
                $county_query = Doctrine::getTable('CountyTranslation')
                                ->createQuery ('c')
                                ->where('c.id = ?', $this->getId())
                                ->andWhere('c.lang = ?', $culture)
                                ->fetchOne();
                
                $name = $county_query['name'];
            }
            
            if (!isset($name) || $name=='' || $name === null ) {
                $county_query = Doctrine::getTable('CountyTranslation')
                                ->createQuery('c')
                                ->where('c.id = ?', $this->getId())
                                ->andWhere('c.lang = ?', 'en')
                                ->fetchOne();
            
                $name = $county_query['name'];
            }
        }
        else {
            if ($this->Translation['en']->_get('name', 'en')) {
                $name = $this->Translation['en']->_get('name', 'en');
            }
            else {
                $county_query = Doctrine::getTable('CountyTranslation')
                                ->createQuery('c')
                                ->where('c.id = ?', $this->getId())
                                ->andWhere('c.lang = ?', 'en')
                                ->fetchOne();
            
                $name = $county_query['name'];
            }
        }
        
        return $name;
    }

    public function getCountyNameByCulture($culture = null)
    {
        if(is_null($culture)){
            $culture = sfContext::getInstance()->getUser()->getCulture();
        }

        if ($this->Translation[$culture]->_get('name', $culture)){
            $name =  $this->Translation[$culture]->_get('name', $culture);
        }
        if(!isset($name) || !$name){
            $name = $this->Translation['en']->_get('name', 'en');
        }
        return $name;
    }
    
    public function getNameEn()
    {
    	$culture = 'en';
    	return $this->Translation[$culture]->_get('name', $culture);    	
    }
    
    public static function getCountyByCountryAndSlug($country_id,$slug){
    	$q = Doctrine::getTable('County')
    		->createQuery('co')
    		->where('co.country_id = ?', $country_id)
    		->andWhere('co.slug = ?', $slug);
    	 
    	$q->useResultCache(true, 3600, "county_by_country_and_slug_".serialize($q->getCountQueryParams()));
    	return $q->fetchOne();
    }
    
    public static function getDefaultCounty($country_id){
    	$county = Doctrine::getTable('County')
    	->createQuery('co')
    	->select('co.*')
    	->innerJoin('co.City c')
    	->where('co.country_id = ?', $country_id)
    	->orderBy('c.is_default DESC')->limit(1)->fetchOne();
    	
    	return $county;
    }
/*
    public function getCountyNameByCulture($culture = null)
    {
        $current_culture = sfContext::getInstance ()->getUser ()->getCulture ();
        if(is_null($culture)){
            $culture = sfContext::getInstance ()->getUser ()->getCulture ();
        }
        $country = sfContext::getInstance ()->getUser ()->getCountry ()->getId ();
    
        if($culture == $this->getCountry()->getSlug() && $country == $this->getCountryId()){
            $county = $this->getName();
        }
    
        if(!isset($county) || $county=='' || $county === null ){
            $county_query = Doctrine::getTable ( 'CountyTranslation' )->createQuery ( 'c' )
            ->where ( 'c.id = ?', $this->getId ())
            ->andWhere ( 'c.lang = ?', $culture  )
            ->fetchOne ();
    
            $county = $county_query['name'];
    
            if(!isset($county) || $county=='' || $county === null ){
                $county_query = Doctrine::getTable ( 'CountyTranslation' )->createQuery ( 'c' )
                ->where ( 'c.id = ?', $this->getId ())
                ->andWhere ( 'c.lang = ?', 'en'  )
                ->fetchOne ();
    
                $county = $county_query['name'];
            }
        }
         
        return $county;
    }
*/

}
