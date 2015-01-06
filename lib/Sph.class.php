<?php
/* used for local searches */
 //include('D:\Sphinx2.1.6\api\sphinxapi.php');
 //assert_options(ASSERT_ACTIVE, 0);
if( !class_exists('SphinxClient') && stripos($_SERVER['SERVER_NAME'], 'devlokal') !== false ){
	include '/usr/src/search/sphinx-2.1.6-release/api/sphinxapi.php';
	assert_options(ASSERT_ACTIVE, 0);
}

class Sph extends SphinxClient
{
    
    private $pageLimit = 20;

    public $culture = 'en';

    /**
     * Init and set server from config
     * Set default match mode
     */
    public function __contruct($culture = 'en')
    {
        parent::__contruct();

        $this->culture = $culture;

        $this->setServer(sfConfig::get('app_search_host'), sfConfig::get('app_search_port'));
        $this->setMatchMode(SPH_MATCH_EXTENDED);
    }

    public function geodist($lat, $lng) {
        $this->setGeoAnchor('latitude', 'longitude', $lat, $lng);
    }

    public function defaultFieldWeights()
    {
        $this->setFieldWeights(array(
            'title' => 3,
            'detail_description' => 2,
            'description' => 2,
            'extra_keywords' => 2,
            'review' => 1,
            'keywords' => 1
        ));
    }

    public function setPageLimits($page)
    {
        if ($page < 1) {
            $page = 1;
        }
        $offset = $this->pageLimit * ($page - 1);
        $this->setLimits($offset, $this->pageLimit, $this->pageLimit + $offset, 1000);
    }

    public function fullSearch($text, $lat, $lng, $cityId, $countyId, $countryId, $page = 1, $coordinates, $blank)//,$coordinates = array())
    {
        $this->geodist($lat, $lng);
        $this->defaultFieldWeights();
        //$this->setMatchMode(SPH_MATCH_EXTENDED2);

        if ($blank) {
            if ($coordinates['west'] < $coordinates['east']) {
                $this->setFilterFloatRange('latitude', $coordinates['south'], $coordinates['north']);
                $this->setFilterFloatRange('longitude', $coordinates['west'], $coordinates['east']);
            }
            else {
                $this->setFilterFloatRange('latitude', $coordinates['south'], $coordinates['north']);
                $this->setFilterFloatRange('longitude', $coordinates['east'], $coordinates['west'], true);
            }           
        }

        $this->setSelect('*, @weight * score AS total_score');
        $this->setSortMode(SPH_SORT_EXTENDED, 'total_score DESC');

        $this->setPageLimits($page);
        
        if ($cityId && $cityId !==null && !$blank) {
           $this->setFilter('city_id', (array) $cityId);
        }
        elseif ($countyId && $countyId !== null && (!$cityId || $cityId === null) && !$blank) {
           $this->setFilter('county_id', (array) $countyId);
        }
        elseif ($countryId && !$blank && (!$countyId || $countyId === null) && (!$cityId || $cityId === null)) {
           $this->setFilter('country_id', (array) $countryId);
        }
        else {
           // sort like in blank search, if no city or country
           $this->setSortMode(SPH_SORT_EXTENDED, '@geodist ASC, total_score DESC');
        }

        return $this->query($text);
    }

    /**
     * Try to autodetect index
     */
    public function query($query, $index = "*", $comment = "") {
        if ($index == '*') {
            $index = "search{$this->culture}";
        }
        return parent::query($query, $index, $comment);
    }

    public function blankSearch($lat, $lng, $country_id, $page = 1, $coordinates = array(), $sectorClassification, $autoTrigger)
    {
        $this->ResetFilters();
        $this->geodist($lat, $lng);

        if ($coordinates['west'] < $coordinates['east']) {
            $this->setFilterFloatRange('latitude', $coordinates['south'], $coordinates['north']);
            $this->setFilterFloatRange('longitude', $coordinates['west'], $coordinates['east']);
        }
        else {
            $this->setFilterFloatRange('latitude', $coordinates['south'], $coordinates['north']);            
            $this->setFilterFloatRange('longitude', $coordinates['east'], $coordinates['west'], true);
        }

        $this->setSortMode(SPH_SORT_EXTENDED, 'is_ppp DESC, @geodist ASC,  score DESC');

        if ($page !== false) {
            $this->setPageLimits($page);
        }
        
        if ((bool)$autoTrigger) {
            $this->setFilter('country_id', (array) $country_id);
        } 

        if ($sectorClassification['sectorId']) {
            $q = Doctrine_Query::create ()
                ->select ( 'classification_id')
                ->from ( 'ClassificationSector cs')
                ->where('cs.sector_id = '.$sectorClassification['sectorId'])
                ->fetchArray();

            foreach ($q as $classificationId) {
                $classificationIds[] = $classificationId['classification_id'];
            }

            $this->setFilter('classification_id', $classificationIds, false);
        }
        
        if ($sectorClassification['classificationId']) {
            $this->setFilter('classification_id', array(intval($sectorClassification['classificationId'])));
        }

        if (!$sectorClassification['sectorId'] && !$sectorClassification['classificationId']) {
            $this->setFilterRange('sector_id', 1, 11);
        }
        
        return $this->query('');
    }

    public static function toKm($meters)
    {
        return $meters / 1000;
    }

    public static function getByReference($reference)
    {
        // Google places server api key
        $key = 'AIzaSyDE0asQq6qj6DN8UkUXc9uSNabsoBcT_dk';
        $url = 'https://maps.googleapis.com/maps/api/place/details/json?reference=%s&sensor=false&key=%s';
        $url = sprintf($url, $reference, $key);

        
        //$r = json_decode(file_get_contents($url));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); # required for https urls
        curl_setopt($ch, CURLOPT_URL, $url);
        $r = json_decode(curl_exec($ch), true );
        curl_close($ch);

        if ($r && $r['status'] == 'OK') {
            return array(
                $r['result']['geometry']['location']['lat'],
                $r['result']['geometry']['location']['lng'],
            );
        }
        
        
        /*
        $r = json_decode(file_get_contents($url));
        if ($r && $r->status == 'OK') {
            return array(
                $r->result->geometry->location->lat,
                $r->result->geometry->location->lng,
            );
        }
         * 
         */
        return array(false, false);
    }

    public static function getSearchRequestVars(sfWebRequest $request)
    {
        $sfUser = sfContext::getInstance()->getUser();

        // generating caches, retriving clears cache
        $lat = $request->getParameter('lat');
        $lng = $request->getParameter('lng');

        //$s = str_replace(array('_','-', '"', ','), '', $request->getParameter('s'));
        $s = $request->getParameter('s');
        $reference = $request->getParameter('reference', false);

        $coordinates = array(
            'south' => $request->getParameter('Slat', null),
            'north' => $request->getParameter('Nlat', null),
            'west' => $request->getParameter('Wlng', null),
            'east' => $request->getParameter('Elng', null)
        );
        $sectorClassification = array(
            'sectorId' => $request->getParameter('sector_id', 0),
            'classificationId' => $request->getParameter('classification_id', 0)
        );

        // get lat, lng thourgh google place service
        if ($reference) {
            list($rLat, $rLng) = self::getByReference($reference);
            if ($rLat && $rLng) {
                $lat = $rLat;
                $lng = $rLng;
            }
        }

        $blank = $request->getParameter('blank', false);
        $autoTrigger = $request->getParameter('auto', false);

        /*
        $cityId = $countyId = $countryId = null;
        $countryId = $sfUser->getCountry()->getId();
        $city = $sfUser->getCity();
        $county = $sfUser->getCounty();

        if ($city) {
            $cityId = $city->getId();
        }
        if ($county && !$city) {
            $countyId = $county->getId();
        }
         * 
         */

        
        $cityId = $countyId = $countryId = $county= null;
        $location = $request->getParameter('w');
        $locationIds = self::_getLocationIDs($request->getParameter('wids'));
        
    	if(isset($locationIds['cityId'])){
        	$cityId = $locationIds['cityId'];
        }
        if(isset($locationIds['countyId'])){
        	$countyId = $locationIds['countyId'];
        }
        if(isset($locationIds['countryId'])){
        	$countryId = $locationIds['countryId'];
        }
        $tmp = explode(',', $location);
       
        $search_location = trim(array_shift($tmp));
        $search_country = trim(array_pop($tmp));
		if(is_null($cityId) && is_null($countyId) && is_null($countryId)){
        	/*
        	 * if $cityId, $countyId and $countryId are null we don't have IDs from the autocomplete
        	 * */
	        if(count($tmp)== 0 && $search_location !='' && $search_country ==''){
	            $country = Doctrine::getTable('Country')
	                ->createQuery('cty')
	                ->where('cty.name_en = ? OR cty.name = ? ', array($search_location, $search_location))
	                ->fetchOne();
	            if($country){
	                $countryId = $country->getId();
	            }
	            else{
	                $county = Doctrine::getTable('County')
	                    ->createQuery('co')
	                    ->innerJoin('co.Translation cotr')
	                    ->where('cotr.name = ?', $search_location)
	                    ->fetchOne();
	                if($county){
	                    $countyId = $county->getId();
	                }
	                else{
	                    $city = Doctrine::getTable('City')
	                        ->createQuery('c')
	                        ->innerJoin('c.County co')
	                        ->innerJoin('c.Translation ct')
	                        ->where('ct.name = ?', $search_location)
	                        ->fetchOne();
	                    if($city){
	                        $cityId = $city->getId();
	                        $countryId = $city->getCounty()->getCountry()->getId();
	                    }
	                }
	            }
	        }
	        elseif($search_location !=''){
	            $city = Doctrine::getTable('City')
	                    ->createQuery('c')
	                    ->innerJoin('c.County co')
	                    ->innerJoin('co.Country cty')
	                    ->innerJoin('c.Translation ct')
	                    ->where('ct.name = ?', $search_location)
	                    ->andWhere('cty.name_en =?',$search_country)
	                    ->fetchOne();
	
	            if ($city) {
	                $cityId = $city->getId();
	              //  $countyId = $city->getCounty()->getId();
	                $countryId = $city->getCounty()->getCountry()->getId();
	            }
	            else{
	                $county = Doctrine::getTable('County')
	                    ->createQuery('c')
	                    ->innerJoin('c.Translation ct')
	                   // ->innerJoin('c.Country cty')
	                    ->where('ct.name = ?', $search_location)
	                    ->fetchOne();
	                if ($county && !$city) {
	                    $countyId = $county->getId();
	                    $countryId = $county->getCountry()->getId();
	                }
	            }
	        }
	        if(!$cityId && !$countyId && !$countryId){
	            $country = Doctrine::getTable('Country')
	                ->createQuery('cotr')
	                ->where('cotr.name_en = ?', $search_location)
	                ->fetchOne();
	            if($country){
	                $countryId = $country->getId();
	            }
	        }
	        
	        if($cityId =='' &&  $countyId =='' && $countryId==''){
	            $countryId = $sfUser->getCountry()->getId();
	            $city = $sfUser->getCity();
	            $county = $sfUser->getCounty();
	
	            if ($city && $countryId !=78) {
	                $cityId = $city->getId();
	            }
	            elseif($countryId ==78){
	                $cityId ='';
	            }
	            if ($county) {
	                $countyId = $county->getId();
	            }
	        }
        }

        return array($s, $lat, $lng, $cityId, $countyId, $countryId, $coordinates, $sectorClassification, $blank, $autoTrigger);
    }
    
    
    protected static function _getLocationIDs($acWhereIDs){
    	$arIDs = array(); 
    	if($acWhereIDs != ""){
	    	$ids = explode(',', $acWhereIDs);
	    	if(is_array($ids) && sizeof($ids)){
		    	foreach ($ids as $object){
		    		$arObject = explode('-', $object);
			    	$arIDs[$arObject[0]] = $arObject[1];
		    	}
	    	}
    	}
    	return $arIDs;
    }

    /**
     * Returns the cache based on request params
     * @param  sfWebRequest $request
     * @param  boolean      $total   Either to return only total number or all result
     * @return mixed
     */
    public static function searchRequest(sfWebRequest $request, $total = false)
    {
        list($s, $lat, $lng, $cityId, $countyId, $countryId, $coordinates, $sectorClassification, $blank, $autoTrigger) = self::getSearchRequestVars($request);
        $result = null;
        $culture = sfContext::getInstance()->getUser()->getCulture();
        
        $sph = new Sph($culture);
        $sph->culture = $culture;
        $s = $sph->escapeString($s);
        if ($s) {
            $result = $sph->fullSearch($s, $lat, $lng, $cityId, $countyId, $countryId, self::getPage($request), $coordinates, $blank);
        } else {
            // blank search
            $result = $sph->blankSearch($lat, $lng, $countryId, self::getPage($request), $coordinates, $sectorClassification, $autoTrigger);
        }
/*        if($result['attrs']['country_id'] != $countryId && $s ){
            $result = $sph->fullSearch($s, $lat, $lng, null, $countyId, $countryId, self::getPage($request), $coordinates, $blank);
            //var_dump($result);
        }
        
        if($result['attrs']['country_id'] != $countryId && $s ){
            $result = $sph->fullSearch($s, $lat, $lng, null,null, $countryId, self::getPage($request), $coordinates, $blank);
        }
*/
        
        if (!$result) {
//             var_dump($sph->getLastError());
            return false;
        }

        if ($total) {
            return $result['total_found'];
        }
        
        return $result;
    }

    protected static function getPage(sfWebRequest $request)
    {
        $page = 1;
        $offset = $request->getParameter('offset', false);
        if ($offset && $offset > 0) {
            $page = ($offset / 20) + 1;
        }
        return $page;
    }

    public static function getFullCache($key)
    {
        $cache = sfContext::getInstance()->getViewCacheManager()->getCache();
        if ($cache->has($key)) {
            return unserialize($cache->get($key));
        }
        return null;
    }

    public static function setFullCache($key, $data)
    {
        $cache = sfContext::getInstance()->getViewCacheManager()->getCache();
        $cache->set($key, serialize($data), 60 * 60 * 24); // cache 1 day searches
    }
}
