<?php

/**
 * City
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class City extends BaseCity {
	
	private $location = array();

	public function __toString()
    {
    	return (string) $this->getLocation();
    }

  public function getI18nName($culture = null) {

        $name = $this->getName();
        /*
        $name_en = $this->getNameEn();
        $city_country = $this->getCounty()->getCountry()->getSlug();

        if (!$culture) {
            $culture = sfContext::getInstance()->getUser()->getCulture();
        }
        if ($culture == 'en') {
            return $name_en;
        }
        if ($culture == $city_country && !empty($name)) {
            return $name;
        }

         *
         */
        $country = sfContext::getInstance ()->getUser ()->getCountry ()->getId ();

        if($country && $this->getCounty()->getCountryId() != $country && $culture != 'en'){
             $name = $this->getCityNameByCulture('en');
        }
        else{
             $name = $this->getName ();
        }



        return $name;
    }

  public function getLocation($culture = null)
  {
      if(is_null($culture)) {
          $culture = sfContext::getInstance()->getUser()->getCulture();
      }
      
      if(!empty($this->location[$culture]))return $this->location[$culture];
      
      if ($culture == $this->getCounty()->getCountry()->getSlug()) {
          if ($this->Translation[$culture]->_get('name', $culture)) {
              $name =  $this->Translation[$culture]->_get('name', $culture);
          }
          else {
              $city_query = Doctrine::getTable('CityTranslation')
                    ->createQuery('c')
                    ->where('c.id = ?', $this->getId())
                    ->andWhere('c.lang = ?',$culture)
                    ->fetchOne();

              $name = $city_query['name'];
          }
      
          if (!isset($name) || $name=='' || $name === null ) {
              $city_query = Doctrine::getTable ('CityTranslation')
                        ->createQuery('c')
                        ->where('c.id = ?', $this->getId())
                        ->andWhere('c.lang = ?', 'en')
                        ->fetchOne();

              $name = $city_query['name'];
          }
      }
      else {
          if ($this->Translation['en']->_get('name', 'en')) {
              $name = $this->Translation['en']->_get('name', 'en');
          }
          else {
              $city_query = Doctrine::getTable('CityTranslation')
                        ->createQuery('c')
                        ->where('c.id = ?', $this->getId())
                        ->andWhere('c.lang = ?', 'en')
                        ->fetchOne();

              $name = $city_query['name'];
          }
      }
      $this->location[$culture] = $name;
      return $name;
  }

  public function getCountry()
  {
    return $this->getCounty()->getCountry();
  }

  public function getDisplayCity()
  {
    $culture = sfContext::getInstance()->getUser()->getCulture();

    if ($this->getCountry()->getSlug() == 'sr' && $this->getSerbianCities()->getFirst() && $culture == 'sr')
    {
      return $this->getSerbianCities()->getFirst();//$city[0]->getCityChange();
    }


        $country = sfContext::getInstance ()->getUser ()->getCountry ()->getId ();

        if($country && $this->getCounty()->getCountryId() != $country && $culture != 'en'){
             $city = $this->getCityNameByCulture('en');
        }
        else{
             $city = $this->getName ();
        }

    return $city;
  }

   public function getCityNameByCulture($culture = null)
  {
        $country = sfContext::getInstance ()->getUser ()->getCountry ()->getId ();
        if(is_null($culture)){
            $culture = sfContext::getInstance()->getUser()->getCulture();
        }

        if($culture == $this->getCountry()->getSlug() && $country == $this->getCounty()->getCountryId()){
          $city = $this->getName();
        }

        if(!isset($city) || $city=='' || $city === null ){

        //delete the if statement when add company campaign is over
          if(!in_array($culture, array('it', 'se', 'si'))){
            $culture = sfContext::getInstance ()->getUser ()->getCulture ();
          }

        //AND uncomment next line
        //$culture = sfContext::getInstance ()->getUser ()->getCulture ();
            
            $city_query = Doctrine::getTable ( 'CityTranslation' )
                    ->createQuery ( 'c' )
                    ->where ( 'c.id = ?', $this->getId ())
                    ->andWhere ( 'c.lang = ?',$culture  )
                    ->fetchOne ();

            $city = $city_query['name'];

            if(!isset($city) || $city=='' || $city === null ){

                $city_query = Doctrine::getTable ( 'CityTranslation' )
                        ->createQuery ( 'c' )
                        ->where ( 'c.id = ?', $this->getId ())
                        ->andWhere ( 'c.lang = ?', 'en'  )
                        ->fetchOne ();

                $city = $city_query['name'];

            }

        }

        return $city;
  }
  
  public function getNameEn(){
  		$culture = 'en';
    	return $this->Translation[$culture]->_get('name', $culture);    
  }

  public function getCityNameByIdAndCulture($culture = null, $id)
  {
       if(is_null($culture)){
           $culture = sfContext::getInstance()->getUser()->getCulture();
       }

       $city = Doctrine::getTable ( 'CityTranslation' )->createQuery ( 'c' )
                    ->where ( 'c.id = ?', $id)
                    ->andWhere ( 'c.lang = ?', $culture  )
                    ->fetchOne ();


        return $city['name'];
  }
  
  public function getDefaultCities($culture) {
      $cities = Doctrine::getTable('City')
              ->createQuery('c')
              ->innerJoin('c.Translation ct')
              ->where('c.is_default = 1')
              ->andWhere('ct.lang = ?', $culture)
//              ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
              ->execute();
      
      if($cities){
          return $cities;
      }
      return;
      
  }
  
  public static function getCityByCountryAndSlug($country_id,$slug){
  	$q = Doctrine::getTable('City')
  		->createQuery('c')
  	//                                 ->select('c.*')
  		->innerJoin('c.County co')
  		->where('c.slug = ?', $slug)
  		->andWhere('co.country_id = ?', $country_id);
  	
  	$q->useResultCache(true, 3600, "city_by_country_and_slug_".serialize($q->getCountQueryParams()));
  	return $q->fetchOne();
  }
  
  public static function getDefaultCity($country_id){
  	$city = Doctrine::getTable('City')
  	->createQuery('c')
  	->innerJoin('c.County co')
  	->where('co.country_id = ?', $country_id)
  	->orderBy('c.is_default DESC')->limit(1)->fetchOne();
  	return $city;
  }
  
}
