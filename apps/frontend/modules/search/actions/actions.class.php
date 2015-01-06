<?php

/**
 * home actions.
 *
 * @package    getLokal
 * @subpackage search
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class searchActions extends sfActions
{
	protected $_connection = null;

    public function executeIndex(sfWebRequest $request)
    {
    	include sfConfig::get("sf_web_dir").'/../getlokalBizLib/search/model/SearchFilter.php';
    	include sfConfig::get("sf_web_dir").'/../getlokalBizLib/search/model/spLocation.php';
    	include sfConfig::get("sf_web_dir").'/../getlokalBizLib/search/CompanyResultHandler.php';
    	include sfConfig::get("sf_web_dir").'/../getlokalBizLib/search/sphinx/SphinxManager.php';
    	$culture = $this->getUser()->getCulture();
    	
    	$pFilter = new SearchFilter();
    	$SearchProviderRankingSettings= new SearchProviderRankingSettings();
    	$SpinxQLConnectionSettings = new SpinxQLConnectionSettings();
    	$SphinxManager = new SphinxManager($culture, $SpinxQLConnectionSettings, $SearchProviderRankingSettings);
    	
    	list($city, $county, $country) = myTools::getLocationsFromSearch();
    	
    	if (getlokalPartner::getInstanceDomain() != 78) {
	    	if($this->getUser()->getCity()->getId() != $city){
	    		$cityObject = is_numeric($city) ? Doctrine::getTable('City')->findOneById($city) : $city;
	    		if(is_object($cityObject)){
		    		$this->getUser()->setCity($cityObject);
					$this->getUser()->setAttribute('clicked_city', $cityObject->getSlug());
	    		}
	// 			$this->getUser()->setAttribute('clicked_country', $this->getUser()->getCountry()->getId());
	    	}
    	}else{
    		if($this->getUser()->getCounty()->getId() != $county){
    			$countyObject = is_numeric($county) ? Doctrine::getTable('County')->findOneById($county) : $county;
    			if(is_object($countyObject)){
	    			$this->getUser()->setCounty($countyObject);
	    			$this->getUser()->setAttribute('clicked_county', $countyObject->getSlug());
    			}
    			// 			$this->getUser()->setAttribute('clicked_country', $this->getUser()->getCountry()->getId());
    		}	
    	}
    	
    	
    	$whereIDsString = $this->_formatWhereIDs($city, $county, $country);
    	$request->setParameter('ac_where_ids', $whereIDsString);
    	
        $classification_id = $request->getParameter('classification_id', false);
        $sector_id = $request->getParameter('sector_id', false);
        $pFilter->term = $request->getParameter('s', false);
        if(is_numeric($classification_id) && $classification_id>0){
        	$pFilter->classificationId = $classification_id;
        }
        if(is_numeric($sector_id) && $sector_id > 0){
        	$pFilter->sectorId = $sector_id;
        }
        //var_dump($city, $county, $country);
        if(!is_null($city) && $city != false){
        	$results = $SphinxManager->searchCompaniesByCityId(is_object($city) ? $city->getId() : $city, $pErrors, $pFilter);
        }elseif(!is_null($county) && $county != false){
        	$results = $SphinxManager->searchCompaniesByCountyId(is_object($county) ? $county->getId() : $county, $pErrors, $pFilter);
        }elseif(!is_null($country) && $country != false){
        	$results = $SphinxManager->searchCompaniesByCountryId(is_object($country) ? $country->getId() : $country, $pErrors, $pFilter);
        }else{
        	$results = array();
        }
        
        $totalMatches = $SphinxManager->getTotalMatches();
        $this->numberOfResults = $totalMatches;
        $this->noAds = false;
        if($this->numberOfResults){
            $companies = $results;
            foreach ($companies as $company) {
                if($company->getClassificationId() == '66' || $company->getClassificationId() == '127'){
                     $this->noAds = true;
                     break;
                }          
            }
            $CompanyResultHandler = new CompanyResultHandler($results, $culture, $totalMatches);
            $results = $CompanyResultHandler->processData();
        }        
        breadCrumb::getInstance()->clearItems();
        $i18n = sfContext::getInstance()->getI18N();
        $this->getResponse()->setTitle(
            sprintf($i18n->__('Search results for %s'), $request->getParameter('s'))
        );
        //var_dump($results[0]); die;        
        $this->result = $results;
        $this->setTemplate('SearchResult');
    }
    
    protected function _formatWhereIDs($city, $county, $country){
    	$whereIDsString = '';
    	if(!is_null($city)){
    		$whereIDsString .= 'cityId-'.(is_object($city) ? $city->getId() : $city);
    	}
    	if(!is_null($county)){
    		$whereIDsString .= ',countyId-'.(is_object($county) ? $county->getId() : $county);
    	}
    	if(!is_null($country)){
    		$whereIDsString .= ',countryId-'.(is_object($country) ? $country->getId() : $country);
    	}
    	return trim($whereIDsString, ',');
    }
        
    /**
     * Calculate and apply limits to all 4 queries in autocomplete
     */
    protected function calculateLimits($queries, $max = 16) {
        $counts = array_map(function ($q) {
            return $q->count();
        }, $queries);
    	//$counts = array(1,2,3,4,5,6,7,8,9,1,1,2,3,4,5,6);
        $limits = array();
        $left = 0;
        $per = floor($max / count($counts));
        $available = array();

        foreach ($counts as $k => $c) {
            if ($c >= $per) {
                if ($c > $per) {
                    $available[] = $k;
                }
                $c = $per;
            } elseif ($c < $per) {
                $left += $per - $c;
            }
            $limits[$k] = $c;
        }

        if ($left > 0 && count($available) > 0) {
            $left = floor($left / count($available));
            foreach ($available as $k) {
                $limits[$k] += $left;
            }
        }
        foreach ($limits as $k => $l) {
            $queries[$k]->limit($l);
        }
        return $queries;
    }

    public function executeAutocomplete(sfWebRequest $request)
    {
        $query = '%' . $request->getParameter('term') . '%';
        $i18n = $this->getContext()->getI18n();
        $this->getContext()->getConfiguration()->loadHelpers('Text');
        $culture = $this->getUser()->getCulture();
        
        $city_id = $this->getUser()->getCity()->getId();
        $county_id = $this->getUser()->getCounty()->getId();
        if (trim($request->getParameter('w'))) {
        	if($this->getUser()->getCountry()->getId() != 78){
	            $country_id = $this->getUser()->getCountry()->getId();
	            if (strstr($request->getParameter('w'), ',')) {
	                // possibly the country is set in the where then is no need to pass it
	                $country_id = null;
	            }
	            $city = CityTable::getByAddress($request->getParameter('w'), $country_id);
	            if ($city) {
	                $city_id = $city->getId();
	            }
        	}else{
        		$country_id = $this->getUser()->getCountry()->getId();
        		if (strstr($request->getParameter('w'), ',')) {
        			// possibly the country is set in the where then is no need to pass it
        			$country_id = null;
        		}
        		$county = CountyTable::getByAddress($request->getParameter('w'), $country_id);
        		if ($county) {
        			$county_id = $county->getId();
        		}
        	}
        }
        //echo $this->getUser()->getCity()." ".$this->getUser()->getCounty()." $city_id";
        // Places listing
        ////////////////////////////////////////////////////////////////////////////////////////
    	include sfConfig::get("sf_web_dir").'/../getlokalBizLib/search/model/SearchFilter.php';
    	include sfConfig::get("sf_web_dir").'/../getlokalBizLib/search/model/spLocation.php';
    	include sfConfig::get("sf_web_dir").'/../getlokalBizLib/search/CompanyResultHandler.php';
    	include sfConfig::get("sf_web_dir").'/../getlokalBizLib/search/sphinx/SphinxManager.php';
    	$culture = $this->getUser()->getCulture();
    	
    	$pFilter = new SearchFilter();
    	$SearchProviderRankingSettings= new SearchProviderRankingSettings();
    	$SpinxQLConnectionSettings = new SpinxQLConnectionSettings();
    	$SphinxManager = new SphinxManager($culture, $SpinxQLConnectionSettings, $SearchProviderRankingSettings);
    	
    	$classification_id = $request->getParameter('classification_id', false);
        $sector_id = $request->getParameter('sector_id', false);
        $pFilter->term = $request->getParameter('term', false);
        if(is_numeric($classification_id) && $classification_id>0){
        	$pFilter->classificationId = $classification_id;
        }
        if(is_numeric($sector_id) && $sector_id > 0){
        	$pFilter->sectorId = $sector_id;
        }
        if($this->getUser()->getCountry()->getId() != 78){
	        if(is_numeric($city_id)){
	        	$results = $SphinxManager->searchCompaniesByCityId($city_id, $pErrors, $pFilter);
	        }else{
	        	$results = array();
	        }
        }else{
        	if(is_numeric($county_id)){
        		$results = $SphinxManager->searchCompaniesByCountyId($county_id, $pErrors, $pFilter);
        	}else{
        		$results = array();
        	}
        }
        
        $totalMatches = $SphinxManager->getTotalMatches();
        
        $this->numberOfResults = $totalMatches;
        $this->noAds = false;
        if($this->numberOfResults){
            $companies = $results;
            foreach ($companies as $company) {
                if($company->getClassificationId() == '66' || $company->getClassificationId() == '127'){
                     $this->noAds = true;
                     break;
                }          
            }
            $CompanyResultHandler = new CompanyResultHandler($results, $culture, $totalMatches);
            $companies = $CompanyResultHandler->processData();
        }else{
        	$companies = array();
        }
        ////////////////////////////////////////////////////////////////////////////////////////
        $queries = $this->calculateLimits(array(
            'articles' => ArticleTable::getAC($query, $culture, $city_id),
            'events' => EventTable::getAC($query, $culture, $city_id),
            'lists' => ListsTable::getAC($query, $culture, $city_id),
        ));

        //$companies = $queries['companies']->execute();

        //CompanyTable::getInstance()->addCacheAC($cKey, $companies);

        $r_places = array();
        foreach ($companies as $c) {

            $r_places[] = array(
                'label' => $c->getTitle(),
                'title' => $c->getTitle(),
            	'type' => 'place',
                'address' => $c->getDisplayAddress(),
                'link' => $this->generateUrl('company', array(
                    'slug' => $c->getSlug(),
                    'city' => $c->getCity()->getSlug())
                ),
                'icon' => myTools::compute_public_path(
                    'gui/icons/marker_'. $c->getSectorId(). '.png',
                    sfConfig::get('sf_web_images_dir_name', 'images'), 'png'
                ),            		
                'category'  => $i18n->__('Places')
            );
        }
        // Articles listing
        $articles = $queries['articles']->execute();

        $r_articles = array();
        foreach ($articles as $term) {
            $r_articles[] = array(
                'label' => (string) $term,
                'title' => (string) $term,
            	'type' => 'article',
                'address' => truncate_text(strip_tags($term->getContent()), 100),
                'link' => $this->generateUrl('article', array(
                    'slug' => $term->getSlug()
                )),
                'category' => $i18n->__('Articles')
            );
        }

        // Events listing
        $events = $queries['events']->execute();

        $r_events = array();
        foreach ($events as $term) {
            $r_events[] = array(
                'label' => (string) $term,
                'title' => (string) $term,
            	'type' => 'event',
                'address' => truncate_text(strip_tags($term->getDescription()), 100),
                'link' => $this->generateUrl('default', array(
                    'module' => 'event',
                    'action' => 'show',
                    'id' => $term->getId()
                )),
                'category' => $i18n->__('Events'),
            );
        }

        // Lists listing
        $lists = $queries['lists']->execute();

        $r_lists = array();
        foreach ($lists as $term) {
            $r_lists[] = array(
                'label' => (string) $term,
                'title' => (string) $term,
            	'type' => 'list',
                'address' => truncate_text(strip_tags($term->getDescription()), 100),
                'link' => $this->generateUrl('default', array(
                    'module' => 'list',
                    'action' => 'show',
                    'id' => $term->getId()
                )),
            	'category' => $i18n->__('Lists')
            );
        }

        $order = array('r_places', 'r_articles', 'r_events', 'r_lists');
        $key = $this->_getAcInitialList();
        if ($key && in_array($key, $order)) {
            // bring that key forward
            unset($order[array_search($key, $order)]);
            array_unshift($order, $key);
        }
        // merge everything based on order in to $return variable
        $return = array();
        foreach ($order as $o) {
            $return = array_merge($return, $$o);
        }

        $this->getResponse()->setContent(json_encode($return));
        return sfView::NONE;
    }

	protected function _getCountryId(){
		$arDomain = explode('.', $_SERVER['SERVER_NAME']);
		$lastPart = end($arDomain);
		switch ($lastPart){
			case '.com' : return 1;
			case '.ro' : return 2;
			case '.mk' : return 3;
			case '.rs' : return 4;
			case '.fi' : return 78;
			case '.ru' : return 184;
			case '.hu' : return 104;
			case '.me' : return 151;
			default: return 1;
		}
	}
	
	protected function _processSearchResult($arCountries, $arCounties, $arCities, $currentCountryId){
		$result = array();
		$serchResult = array_merge($arCountries, $arCounties, $arCities);
		$return = array();
		$i = 0;
		foreach ($serchResult as $res){
			$i++;			
			if(isset($res->country)){
				$country = $res->country->id;
			}elseif(isset($res->county)){
				$country = $res->county->country->id;
			}else{
				$country = $res->id;
			}
			if($country == $currentCountryId){
				$country = 0;
			}
			$country++;
			$return[$country.str_pad($i, 3, "0", STR_PAD_LEFT)] = $res;
		}
		ksort($return);
		
		return $return;
	}
    
    public function executeAutocompleteLocation(sfWebRequest $request)
    {
    	$location = $request->getParameter('w', false);
    	$term = $request->getParameter('term', false);
    	$culture = $this->getUser()->getCulture();
    	//$countryByDmain = $this->_getCountryId();
    	//echo $culture;
    	//$countryId = $this->_getCountryId();
    	$countryId = getlokalPartner::getInstanceDomain();
    	
    	$pErrors = array();
    	
    	//$result = $this->_getSearchResult();
    	$spinxQLConnectionSettings = new SpinxQLConnectionSettings();
    	$sphinxCompanyRankingSettings = new SphinxCompanyRankingSettings();
    	
    	$searchManager = new SearchManager($culture, $spinxQLConnectionSettings, $sphinxCompanyRankingSettings);
    	
    	$result['countries'] = $searchManager->locationGetACCountry($location, $pErrors);
    	$result['counties'] = $searchManager->locationGetACCounty($location, $pErrors);
    	$result['cities'] = $searchManager->locationGetACCity($location, $pErrors);
    	//var_dump($result);die;
    	$serchResult = $this->_processSearchResult($result['countries'], $result['counties'], $result['cities'], $countryId);
    	//var_dump($serchResult);
    	$return = null;		
		
    	foreach ($serchResult as $item){
    		//var_dump($item);
			$IDs = array();
			$sIDs = '';
			if(!is_null($item->name) && $item->name != ""){				
				if(isset($item->country)){
					if($item->country->id == 3){
						continue;
					}
					$IDs['countyId'] = $item->id;
					$IDs['countryId'] = $item->country->id;
					$countyName = $item->getName($culture);
					$text = "{$countyName}, {$item->country->getCountryName($culture, $countryId)}";
				}elseif(isset($item->county)){
					$IDs['cityId'] = $item->id;
					$IDs['countyId'] = $item->county->id;
					$IDs['countryId'] = $item->county->country->id;					
					$countyName = $item->county->country->id != 3 ? $item->county->getName($culture).", " : "";
					$text = "{$item->name}, {$countyName}{$item->county->country->getCountryName($culture, $countryId)}";
				}else{
					$IDs['countryId'] = $item->id;
					$text = $item->getCountryName($culture, $countryId);
				}
			}else{
				if(isset($item->country)){
					if($item->country->id == 3){
						continue;
					}
					$IDs['countyId'] = $item->id;
					$IDs['countryId'] = $item->country->id;
					$countyName = $item->getNameEn($culture);
					$text = "{$countyName}, {$item->country->getCountryName($culture, $countryId)}";
				}elseif(isset($item->county)){
					$IDs['cityId'] = $item->id;
					$IDs['countyId'] = $item->county->id;
					$IDs['countryId'] = $item->county->country->id;
					$countyName = $item->county->country->id != 3 ? $item->county->getNameEn($culture).", " : "";
					$text = "{$item->nameEn}, {$countyName}{$item->county->country->getCountryName($culture, $countryId)}";
				}else{
					$IDs['countryId'] = $item->id;
					$text = $item->getCountryName($culture, $countryId);
				}				
			}
			$text = str_replace(', ,', ',', $text);
			$text = trim($text, ',');
			$text = trim($text);
			foreach ($IDs as $type => $id){
				$sIDs .= "$type-$id,";
			}
			
			$listItem["description"] = $text;
			$listItem["ids"] = trim($sIDs, ",");
			$listItem['reference'] = $text;
			$return[] = $listItem;
		}
		if(is_null($return)){
			$return = array();
		}
    	$this->getResponse()->setContent(json_encode( array_slice($return, 0, 15) ));
    	return sfView::NONE;
    }
    /**
    * Returns a variable name based on referrr
    */
    protected function _getAcInitialList()
    {
        $_searches = array(
            'r_articles' => '/article',
            'r_events' => '/event',
            'r_lists' => '/list'
        );
        foreach ($_searches as $field => $needle) {
            if (stristr($this->getRequest()->getReferer(), $needle)) {
                return $field;
            }
        }

        return false;
    }

    public function executeSearchNear(sfWebRequest $request)
    {    
    include sfConfig::get("sf_web_dir").'/../getlokalBizLib/search/model/SearchFilter.php';
    	include sfConfig::get("sf_web_dir").'/../getlokalBizLib/search/model/spLocation.php';
    	include sfConfig::get("sf_web_dir").'/../getlokalBizLib/search/CompanyResultHandler.php';
    	include sfConfig::get("sf_web_dir").'/../getlokalBizLib/search/sphinx/SphinxManager.php';
    	$culture = $this->getUser()->getCulture();
    	
    	$pFilter = new SearchFilter();
    	$SearchProviderRankingSettings= new SearchProviderRankingSettings();
    	$SpinxQLConnectionSettings = new SpinxQLConnectionSettings();
    	$SphinxManager = new SphinxManager($culture, $SpinxQLConnectionSettings, $SearchProviderRankingSettings);
    	
    	list($city, $county, $country) = myTools::getLocationsFromSearch(false);
    	//$whereIDsString = $this->_formatWhereIDs($city, $county, $country);
    	//$request->setParameter('ac_where_ids', $whereIDsString);
    	
    	$mapClick = $request->getParameter('mapClick', false);
    	
        $classification_id = $request->getParameter('classification_id', false);
        $sector_id = $request->getParameter('sector_id', false);
        $pFilter->term = $request->getParameter('s', false);
        if(is_numeric($classification_id) && $classification_id>0){
        	$pFilter->classificationId = $classification_id;
        }
        if(is_numeric($sector_id) && $sector_id > 0){
        	$pFilter->sectorId = $sector_id;
        }
        $page = $request->getParameter('page', false);
        if(!is_numeric($page)){
        	$offset = $request->getParameter('offset', false);
        	$page = ($offset / $SphinxManager->getPageSize()) + 1;
        }
        $pFilter->pageNumber = $page;
        
        if(!is_null($city) && !$mapClick){
        	$results = $SphinxManager->searchCompaniesByCityId(is_object($city) ? $city->getId() : $city, $pErrors, $pFilter);
        }elseif(!is_null($county) && !$mapClick){
        	$results = $SphinxManager->searchCompaniesByCountyId(is_object($county) ? $county->getId() : $county, $pErrors, $pFilter);
        }elseif(!is_null($country) && !$mapClick){
        	$results = $SphinxManager->searchCompaniesByCountryId(is_object($country) ? $country->getId() : $country, $pErrors, $pFilter);
        }else{
        	$pSearchCenterLat = $request->getParameter('lat', false);
	    	$pSearchCenterLong = $request->getParameter('lng', false);
	    	$pUserLat = $request->getParameter('lat', false);
	    	$pUserLong = $request->getParameter('lng', false);
	    	$showInKm = true;
  	
	    	$boundries['north_latitude'] = $request->getParameter('Nlat', false);
	    	$boundries['east_longitude'] = $request->getParameter('Elng', false);
	    	$boundries['south_latitude'] = $request->getParameter('Slat', false);
	    	$boundries['west_longitude'] = $request->getParameter('Wlng', false);
	    	
	    	$pFilter->map_boundries = $boundries;
	    	//$pFilter->radius = 10;
	    	$results = $SphinxManager->searchCompaniesByGeoPoint($pSearchCenterLat, $pSearchCenterLong, $pUserLat, $pUserLong, $showInKm, $pErrors, $pFilter);
        }   	
    	$totalMatches = $SphinxManager->getTotalMatches();
    	
    	$CompanyResultHandler = new CompanyResultHandler($results, $culture, $totalMatches);
    	$results = $CompanyResultHandler->processData();
    	
    	foreach ($results as $companyItem) {
    		$item = $companyItem->getJSObject();
    		$item['html'] = $this->getPartial('companyListItem', array('company' => $companyItem,'dataType'=>3));
    		$return[] = $item;
    	}
//     	echo $return[0]['html'];die;
        $this->getResponse()->setContent(json_encode($return));
        
        return sfView::NONE;
    }
    
    public function executeSearchNearOld(sfWebRequest $request)
    {
    	$location = $request->getParameter('w', false);
    	$acWhere = $request->getParameter('ac_where', false);
    	$acWhereIDs = $request->getParameter('ac_where_ids', false);
    	 
    	if(isset($location) && $location!=''){
    		if($acWhere != $location){
    			$acWhereIDs = "";
    		}
    	}
    	$request->setParameter('wids', $acWhereIDs);
    
    	$result = Sph::searchRequest($request);
    	if (!$result) {
    		return sfView::NONE;
    	}
    
    	$matches = $result['matches'];
    
    	$query = CompanyTable::getQuerySearchResults(
    			array_keys($matches),
    			$this->getUser()->getCulture()
    	);
    
    	$rows = $query->execute();
    	$return = array();
    
    
    	foreach ($rows as $company) {
    		$id = $company->getId();
    		$attrs = $matches[$id]['attrs'];
    		$vars = compact('company', 'attrs');
    
    		$return[] = array(
    				'id' => $company->getId(),
    				'title' => $company->getCompanyTitleByCulture(),
    				'score' => $attrs['score'],
    				'kms' => Sph::toKm($attrs['@geodist']),
    				'latitude' => $attrs['latitude'],
    				'longitude' => $attrs['longitude'],
    				'icon' => 'marker_' . $company->getSectorId(),
    				'html' => $this->getPartial('item', $vars),
    				'overlay' => $this->getPartial('item_overlay', $vars),
    				'is_ppp' => $attrs['is_ppp'],
    				'totalObjects' => $result['total_found']
    		);
    
    	}
    
    	$this->getResponse()->setContent(json_encode($return));
    
    	return sfView::NONE;
    }

    // Not finished yet...
    public function executeEvent(sfWebRequest $request)
    {
        $this->numberOfResults = 0;

        $con = Doctrine::getConnectionByTableName('search');
        $searchString = $request->getParameter('s');
        $words = explode(' ', $searchString);
        $junk  = '';

        array_walk($words, 'trim');

        $queryString = $con->quote('+'. implode(' +', $words));

        if ($searchString) {
            $query = Doctrine::getTable('Event')
                ->createQuery('c')
                ->innerJoin('c.EventSearch s')
                ->leftJoin('c.Image')
                ->innerJoin('c.Translation')
                ->innerJoin('c.Category ca')
                ->innerJoin('ca.Translation')
                ->innerJoin('c.City')
                ->leftJoin('c.EventPage ep')
                ->leftJoin('ep.CompanyPage cp')
                ->leftJoin('cp.Company co')
                ->leftJoin('co.City')
                ->andWhere("(MATCH(s.title, s.body, s.keywords)
                    AGAINST ($queryString IN BOOLEAN MODE))");

            $this->pagerEvent = new sfDoctrinePager('Event', 12);
            $this->pagerEvent->setQuery($query);
            $this->pagerEvent->setPage($request->getParameter('page', 1));
            $this->pagerEvent->init();
        }
    }

    // Not finished yet...
    public function executeFeed(sfWebRequest $request)
    {
        $con = Doctrine::getConnectionByTableName('search');
        $lat = $con->quote($request->getParameter('lat'));
        $lng = $con->quote($request->getParameter('lng'));
        $zoom = $request->getParameter('zoom');
        $return = array();

        $sql = "((ACOS(SIN(%s * PI() / 180) * SIN(l.latitude * PI() / 180) +
            COS(%s * PI() / 180) * COS(l.latitude * PI() / 180) *
            COS((%s - l.longitude) * PI() / 180)) * 180 / PI()) *
            60 * 1.1515 * 1.609344) as kms";

        $kms = sprintf($sql, $lat, $lat, $lng);

        $companies = Doctrine::getTable('Company')
            ->createQuery('c')
            ->addSelect('c.*, l.*, ')
            ->innerJoin('c.Location l')
            ->andWhere('c.country_id = ?',
                $this->getUser()->getCountry()->getId())
            ->limit(50)
            ->orderBy('kms ASC')
            ->having('kms < 2')
            ->execute();

        foreach ($companies as $company) {
            $return[] = array(
                'lat' => $company->getLocation()->getLatitude(),
                'lng' => $company->getLocation()->getLongitude(),
            );
        }
    }

    // Not finished yet...
    public function executeSearchByNameAndCity(sfWebRequest $request)
    {
        $pName = $request->getParameter('name');
        $name = str_replace('_', ' ', $pName);
        $cityId = $request->getParameter('city_id');

        $title = '%' . trim($name) . '%';
        $words = explode(' ', trim($name));
        $searchTitleWords = array();

        foreach ($words as $word) {
            $searchTitleWords[] = trim($word) . '%';
        }

        $titleQueryString = '%' . implode($searchTitleWords);

        $this->page = $request->getParameter('page', 1);
        $query = Doctrine::getTable('Company')->createQuery('c')
            ->innerJoin('c.Translation ct')
            ->where('ct.title LIKE "' . $titleQueryString .'"')
           // ->where('c.title LIKE "' . $titleQueryString .
          //  '" OR c.title_en LIKE "' . $titleQueryString . '"')
            ->addWhere('c.status = ? ', CompanyTable::VISIBLE)
            ->andWhere('c.country_id = ?', '78');

        $this->pager = new sfDoctrinePager('Company', 3);
        $this->pager->setQuery($query);
        $this->pager->setPage($this->page);
        $this->pager->init();

        if ($request->isXmlHttpRequest()) {
            return $this->renderPartial('search/items_short',
                array(
                  'pager'   =>  $this->pager,
                  'coutry_id' =>  '78',
                  'name'    =>  trim($pName),
                )
            );
        }
    }

    /**
     * Returns a variable name based on referrer
     */
    protected function getAcInitialList()
    {
        $searches = array(
            'r_articles' => '/article',
            'r_events' => '/events',
            'r_lists' => '/list'
        );

        foreach ($searches as $field => $needle) {
            if (stristr($this->getRequest()->getReferer(), $needle)) {
                return $field;
            }
        }

        return false;
    }

}
