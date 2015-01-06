<?php
require_once(__DIR__.'/../settings/SpinxQLConnectionSettings.php');
require_once(__DIR__.'/../settings/SearchProviderRankingSettings.php');
require_once(__DIR__.'/../model/spCity.php');
require_once(__DIR__.'/../iSearchProvider.php');


class SphinxManager implements iSearchProvider
{
    private $_pageSize = 20;
    //Set In config for searched
    private $_maxRecords = 1000;
    private $_ranker = 'proximity';//"expr('sum(word_count*user_weight)')";//'proximity';
    private $_logger = '';

    private $_language;
    private $_connectionSettings;
    private $_companyRankingSettings;

    private $WEIGHT_FACT = 'weight_factor';
    private $_returnedMatches;
    private $_totalMatches;
  
    public function __construct($pLang, SpinxQLConnectionSettings &$pConnSettings, SearchProviderRankingSettings &$pCompanyRankingSettings = null)
    {
        $this->_language = $pLang;
        $this->_connectionSettings = &$pConnSettings;
        $this->_companyRankingSettings = &$pCompanyRankingSettings;
	}

    public function SetPageSize($pPageSize)
    {
        $this->_pageSize = $pPageSize;
    }
    
    public function getPageSize()
    {
    	return $this->_pageSize;
    }

	public function getReturnedMatches()
	{
	   return $this->_returnedMatches;
	}
	
	public function getTotalMatches()
	{
	   return $this->_returnedMatches;
	}

    public function getLog()
    {
        return $this->_logger;
    }

    public function getLanguage()
    {
        return $this->_language;
    }

    public function locationGetACCity($pTerm, &$pErrors, $pLimit=null)
    {
        $limit = "LIMIT 0,{$this->_maxRecords}";
        if(isset($pLimit))
            $limit = "LIMIT 0,{$pLimit}";

        $cityIndex = $this->getLangDependentIndex('iCity');
        $pTerm = $this->escapeSpecialChars($pTerm);

        $query = "SELECT
                    att_id,
                    name,
                    nameen,
                    slug,
                    county_name,
                    county_nameen,
                    country_name,
                    country_nameen,
                    municipality,
                    region,
                    conv_lat,
                    conv_lng,
                    lat_rad,
                    lng_rad,
                    is_default,
                    county_id,
                    country_id
                  FROM {$cityIndex}
                  WHERE
                    MATCH('@(translated_name,slug) {$pTerm}*')
                  {$limit}";

        $result = $this->execQuery($query, $pErrors);
        if(!$result)
            return false;

        return spLocationACCity::FromResource($result);
    }
    
    public function locationGetCityById($id, &$pErrors, $pLimit=null)
    {
    	$limit = "LIMIT 0,{$this->_maxRecords}";
    	if(isset($pLimit))
    		$limit = "LIMIT 0,{$pLimit}";
    
    	$cityIndex = $this->getLangDependentIndex('iCity');
    	    
    	$query = "SELECT
				    	att_id,
				    	name,
				    	nameen,
				    	slug,
				    	county_name,
				    	county_nameen,
				    	country_name,
				    	country_nameen,
				    	municipality,
				    	region,
				    	conv_lat,
				    	conv_lng,
				    	lat_rad,
				    	lng_rad,
				    	is_default,
				    	county_id,
				    	country_id
				    	FROM {$cityIndex}
				    	WHERE
				    	id=$id
				    	{$limit}";
    
    	$result = $this->execQuery($query, $pErrors);
    	if(!$result)
    	return false;
    
    	return spCity::FromResource($result);
    }

    public function locationGetACCounty($pTerm, &$pErrors, $pLimit=null)
    {
        $limit = "LIMIT 0,{$this->_maxRecords}";
        if(isset($pLimit))
            $limit = "LIMIT 0,{$pLimit}";

        $countyIndex = $this->getLangDependentIndex('iCounty');
        $pTerm = $this->escapeSpecialChars($pTerm);

        $query = "SELECT
                  contatt_id,
                  name,
                  nameen,
                  municipality,
                  region,
                  country_id,
                  slug,
                  contry_name,
                  contry_name_en,
                  contry_slug
                FROM {$countyIndex}
                WHERE
                  MATCH('@(county_name_translated,slug) {$pTerm}*')
                {$limit}";

        $result = $this->execQuery($query, $pErrors);
        if(!$result)
            return false;

        return spLocationACCounty::FromResource($result);
    }
    
    public function locationGetCountyById($id, &$pErrors, $pLimit=null)
    {
    	$limit = "LIMIT 0,{$this->_maxRecords}";
    	if(isset($pLimit))
    		$limit = "LIMIT 0,{$pLimit}";
    
    	$countyIndex = $this->getLangDependentIndex('iCounty');
    	
    	$query = "SELECT
			    	contatt_id,
			    	name,
			    	nameen,
			    	municipality,
			    	region,
			    	country_id,
			    	slug,
			    	contry_name,
			    	contry_name_en,
			    	contry_slug
			    FROM {$countyIndex}
			    WHERE
			    	id=$id
			    {$limit}";
    
    	$result = $this->execQuery($query, $pErrors);
    	if(!$result)
    	return false;
    
    	return spCounty::FromResource($result);
    }

    public function locationGetACCountry($pTerm, &$pErrors, $pLimit=null)
    {
        $limit = "LIMIT 0,{$this->_maxRecords}";
        if(isset($pLimit))
            $limit = "LIMIT 0,{$pLimit}";

        $countryIndex = 'iCountry';
        $pTerm = $this->escapeSpecialChars($pTerm);

        $query = "SELECT
                id_attr,
                name,
                name_en,
                slug,
                currency
              FROM {$countryIndex}
              WHERE
                MATCH('@(name,name_en,slug) {$pTerm}*')
              {$limit}";

        $result = $this->execQuery($query, $pErrors);
        if(!$result)
            return false;

        return spLocationACCountry::FromResource($result);
    }

    /**
     * Searches by geo points.
     * First point - represented by $pSearchCenterLang, $pSearchCenterLong is the search center
     * Second point - represented by $pUserLang, $pUserLong is the user's center
     * First point = Second point when the user is in the center of search or user's coordinates are not provided by the device.
     * First point differs from Second point when the user searches in other locations then their current.
     *      In that case the center of the map is given as First Point.
     *
     * NOTE: Objects are oredered by keyword weight and the distance from the user's location (Second point).
     * Shown distance(km/mi) is calculated regarding Second point.
     */
    public function searchCompaniesByGeoPoint($pSearchCenterLat, $pSearchCenterLong, $pUserLat, $pUserLong,
                                              $showInKm, &$pErrors, SearchFilter &$pFilter)
    {
        $kmConstant = 1000;
        if(!$showInKm)
            $kmConstant = 1609.344;

        $centerLatRad = (float) deg2rad($pSearchCenterLat);
        $centerLngRad = (float) deg2rad($pSearchCenterLong);

        $userLatRad = (float) deg2rad($pUserLat);
        $userLngRad = (float) deg2rad($pUserLong);

        $companyIndex = $this->getLangDependentIndex('iCompany');
        $companyIndexS = $this->getLangDependentIndex('iCompanyReview');
        $companyIndexS .= ', '.$this->getLangDependentIndex('iCompanyImage');
        $companyIndexS .= ', '.$this->getLangDependentIndex('iComapnyVideo');

        $geodist = ",
                    geodist({$userLatRad}, {$userLngRad} , lat_rad, lng_rad)/{$kmConstant} as user_distance,
                    geodist({$centerLatRad}, {$centerLngRad}, lat_rad, lng_rad)/{$kmConstant} as distance_from_center
                    ";

        $weightFactor = $this->getCompanyWeightFactor();
        $weightFactorS = $this->getCompanyWeightFactorSingles();

        $orderClause = "ORDER BY distance_from_center ASC, user_distance ASC, {$this->WEIGHT_FACT} DESC";

        $hasTerm = false; $whereClauses = ''; $currPage = '';
        $this->extractFilterData($pFilter, $hasTerm, $whereClauses, $currPage);

        $query = $this->getCompanySearchQuery(
            $hasTerm,
            $companyIndex,
            $weightFactor.$geodist,
            $whereClauses,
            $orderClause);        

        $queryN = $this->getCompanySinglesQuery(
            $hasTerm,
            $companyIndexS,
            $weightFactorS.$geodist,
            $whereClauses,
            $orderClause);
        
        $term = $pFilter->term.'*';
        if(!$hasTerm)
            $term = null;

        $res = $this->getCompaniesPagedResponse($term, 'doc_id', $query, $queryN, $pErrors, $currPage, $this->_ranker, array("SearchProviderCompany", "FromRow"));
        return $res;
    }

	public function searchCompaniesByCityId($pCityId, &$pErrors, SearchFilter &$pFilter)
	{
        return  $this->doLocationSearch('city', $pCityId, $pErrors, $pFilter);
	}
	
	public function searchCompaniesByCountyId($pContId, &$pErrors, SearchFilter &$pFilter)
	{
        return  $this->doLocationSearch('county', $pContId, $pErrors, $pFilter);
	}
	
	public function searchCompaniesByCountryId($pCntrId, &$pErrors, SearchFilter &$pFilter)
	{
        return  $this->doLocationSearch('country', $pCntrId, $pErrors, $pFilter);
	}

    private function doLocationSearch($pLocationType, $pLocationId, &$pErrors, SearchFilter &$pFilter)
    {
        if(!$this->checkCompanySettings($pErrors))
            return false;

        $hasTerm =''; $whereClauses = ''; $currPage = '';
        $this->extractFilterData($pFilter, $hasTerm, $whereClauses, $currPage);

        $locationWhere = "";
        switch($pLocationType)
        {
            case 'city':
                $locationWhere = " city_id = {$pLocationId} ";
                break;
            case 'county':
                $locationWhere = " county_id = {$pLocationId} ";
                break;
            case 'country':
                $locationWhere = " country_id = {$pLocationId} ";
                break;
            default:
                throw new Exception('SphinxManager::doLocationSearch - $pLocationType argument point to uknown location.');
                break;
        }

        $term = $pFilter->term.'*';
        if(!$hasTerm)
            $term = null;

        if($whereClauses != '')
            $whereClauses = ' AND '.$whereClauses;

        $whereClauses = $locationWhere.$whereClauses;

        $companyIndex = $this->getLangDependentIndex('iCompany');
        $companyIndexS = $this->getLangDependentIndex('iCompanyReview');
        $companyIndexS .= ', '.$this->getLangDependentIndex('iCompanyImage');
        $companyIndexS .= ', '.$this->getLangDependentIndex('iComapnyVideo');

        $weightFactor = $this->getCompanyWeightFactor();

        $query = $this->getCompanySearchQuery(
            $hasTerm,
            $companyIndex,
            $weightFactor,
            $whereClauses,
            "ORDER BY {$this->WEIGHT_FACT} DESC");

        $weightFactorS = $this->getCompanyWeightFactorSingles();

        $queryN = $this->getCompanySinglesQuery(
            $hasTerm,
            $companyIndexS,
            $weightFactorS,
            $whereClauses,
            "ORDER BY {$this->WEIGHT_FACT} DESC");

        $res = $this->getCompaniesPagedResponse($term, 'doc_id', $query, $queryN, $pErrors, $currPage, $this->_ranker, array("SearchProviderCompany", "FromRow"));

        if($hasTerm && $this->_returnedMatches == 0 && substr($pFilter->term, -1) == ' ')
            $res = $this->getCompaniesPagedResponse(rtrim($pFilter->term).'*', 'doc_id', $query, $queryN, $pErrors, $currPage, $this->_ranker, array("SearchProviderCompany", "FromRow"));

        return $res;
    }

    private function extractFilterData(SearchFilter &$pFilter, &$pHasTerm, &$pWhereClauses, &$pCurrPage)
    {
        $pHasTerm = isset($pFilter->term) && $pFilter->term != "";
        $pCurrPage = $pFilter->pageNumber;
        
        $sectorId = (isset($pFilter->sectorId) && $pFilter->sectorId != '') ? $pFilter->sectorId : null;
        $classificationId = (isset($pFilter->classificationId) && $pFilter->classificationId != '') ? $pFilter->classificationId : null;
        $offersCount = (isset($pFilter->offersCount) && $pFilter->offersCount != '') ? true : null;        
        $isPPP = (isset($pFilter->isPPP) && $pFilter->isPPP != '') ? true : null;
        
        $city_id = (isset($pFilter->city_id) && $pFilter->city_id != '') ? $pFilter->city_id : null;
        $county_id = (isset($pFilter->county_id) && $pFilter->county_id != '') ? $pFilter->county_id : null;        
        $country_id = (isset($pFilter->country_id) && $pFilter->country_id != '') ? $pFilter->country_id : null;
        
        $radius = (isset($pFilter->radius) && $pFilter->radius != '') ? $pFilter->radius : null;
        $boundries = (isset($pFilter->map_boundries) && $pFilter->map_boundries != '') ? $pFilter->map_boundries : null;
        $visibleSectors = (isset($pFilter->visibleSectors) && $pFilter->visibleSectors != '') ? $pFilter->visibleSectors : null;
        
        if (isset($boundries) && $boundries) {
        	$north_latitude = $boundries['north_latitude'];
        	$south_latitude = $boundries['south_latitude'];
        	$west_longitude = $boundries['west_longitude'];
        	$east_longitude = $boundries['east_longitude'];
        }
        
        $pWhereClauses = '';

        if(isset($sectorId) && $sectorId)
        {
            if($pWhereClauses != '')
                $pWhereClauses .= ' AND ';

            $pWhereClauses .= "sector_id = {$pFilter->sectorId}";
        }
        
        if (isset($visibleSectors) && $visibleSectors) {
        	if ($pWhereClauses != '')
        		$pWhereClauses.= ' AND ';
        	
        	$pWhereClauses .= "sector_id IN (" . implode(',', $pFilter->visibleSectors) . ")";
        }
        
        if(isset($classificationId) && $classificationId)
        {
            if($pWhereClauses != '')
                $pWhereClauses .= ' AND ';

            $pWhereClauses .= "classification_id = {$pFilter->classificationId}";
        }

        if(isset($offersCount) && $offersCount)
        {
            if($pWhereClauses != '')
                $pWhereClauses .= ' AND ';

            $pWhereClauses .= "offers_cnt > 0";// {$pFilter->offersCount}";
        }

        if(isset($isPPP) && $isPPP)
        {
            if($pWhereClauses != '')
                $pWhereClauses .= ' AND ';

            $pWhereClauses .= "is_ppp_cnt = 1";
        }
        
        if (isset($city_id) && $city_id) {
        	if($pWhereClauses != '')
        		$pWhereClauses .= ' AND ';
        	
        	$pWhereClauses .= "city_id = {$pFilter->city_id}";
        }
        
        if (isset($county_id) && $county_id) {
        	if($pWhereClauses != '')
        		$pWhereClauses .= ' AND ';
        	 
        	$pWhereClauses .= "county_id = {$pFilter->county_id}";
        }
        
        if (isset($country_id) && $country_id) {
        	if($pWhereClauses != '')
        		$pWhereClauses .= ' AND ';
        
        	$pWhereClauses .= "country_id = {$pFilter->country_id}";
        }
        
        if (isset($radius) && $radius) {
        	if($pWhereClauses != '')
        		$pWhereClauses .= ' AND ';
        	
        		$radius = floatval($pFilter->radius);
        		$pWhereClauses .= "distance_from_center <= {$radius}";
        }
        elseif (isset($boundries) && $boundries) {
        	if($pWhereClauses != '')
        		$pWhereClauses .= ' AND ';
        	
        	$pWhereClauses .= "latitude < {$north_latitude}";
        	$pWhereClauses .= " AND latitude > {$south_latitude}";
        	
        	if ($west_longitude < $east_longitude) {
	        	$pWhereClauses .= " AND longitude < {$east_longitude}";
	        	$pWhereClauses .= " AND longitude > {$west_longitude}";
        	}
        	else {
        		$pWhereClauses .= " AND longitude > {$east_longitude}";
        		$pWhereClauses .= " AND longitude < {$west_longitude}";
        	}        	
        }

     //   if($pWhereClauses != '')
     //       $pWhereClauses = ' AND '.$pWhereClauses;
    }
	
	
	private function checkCompanySettings(&$pErrors)
	{
        if($this->_companyRankingSettings == null)
        {
            $pErrors = "Company Rank Settings should be set befor search companies";
            return false;
        }

        return true;
	}
	
	private function escapeSpecialChars($pTerm)
	{
        /*$from = array ( '\\', '(',')','|','-','!','@','~','"','&', '/', '^', '$', '=', '\'' );
        $to   = array ( '\\\\\\', '\\\(','\\\)','\\\|','\\\-','\\\!','\\\@','\\\~','\\\"', '\\\&', '\\\/', '\\\^', '\\\$', '\\\=', '\\\'' );
        */
        $from = array ( '\\', '(',')','|','-','!','@','~','"','&', '/', '^', '$', '=', "'", "\x00", "\n", "\r", "\x1a" );
        $to   = array ( '\\\\\\', '\\\(','\\\)','\\\|','\\\-','\\\!','\\\@','\\\~','\\\"', '\\\&', '\\\/', '\\\^', '\\\$', '\\\=', '\\\\\\\'', "\\x00", "\\n", "\\r", "\\x1a" );

        return str_replace ( $from, $to, $pTerm );
	}
	
	/**
	 * @var $pCompanyIndex - current language dependent Index
	 * @var $pWeightFactor - company weight factor use function getCompanyWeightFactor() if one is needed
	 * @var $pExtraWhere - add more clauses to WHERE use leading AND e.g. AND city_id = XXX AND XXXXX
	 * @var $pOrderClause - order clause if needed
	 */
	private function getCompanySearchQuery($pHasTerm, $pCompanyIndex, $pWeightFactor, $pExtraWhere, $pOrderClause)
	{
	   if($pWeightFactor != '')
	     $pWeightFactor = ', '.$pWeightFactor;

       $termSearchClause = "MATCH('@(searchTitle,description,detail_description,classification,classification_keywords) %s')";
       if(!$pHasTerm)
           $termSearchClause = "";

       if($termSearchClause != "" && $pExtraWhere != "")
           $pExtraWhere = " AND ".$pExtraWhere;

	   return  "SELECT 
	                %s
                  doc_id, 
                  country_id,  
                  county_id, 
                  city_id, 
                  longitude, 
                  latitude, 
                  lat_rad, 
                  lng_rad, 
                  star_rating, 
                  sector_id, 
                  classification_id,
                  localizedtitle,
                  address,
                  searchTitle,
                  is_ppp as is_ppp_cnt,
                  offer_count as offers_cnt
                  {$pWeightFactor}
              FROM {$pCompanyIndex} 
              WHERE
                {$termSearchClause}
                {$pExtraWhere} %s
              {$pOrderClause} 
              ";
	}

	private function getCompanySinglesQuery($pHasTerm, $pCompanyIndex, $pWeightFactor, $pExtraWhere, $pOrderClause)
	{
	    if($pWeightFactor != '')
	        $pWeightFactor = ', '.$pWeightFactor;

        $termSearchClause = "MATCH('@(reviewText,videoText,imageText) %s')";
        if(!$pHasTerm)
            $termSearchClause = "";

        if($termSearchClause != "" && $pExtraWhere != "")
            $pExtraWhere = " AND ".$pExtraWhere;

	   return  "SELECT 
	                %s
                  doc_id, 
                  country_id,  
                  county_id, 
                  city_id, 
                  longitude, 
                  latitude, 
                  lat_rad, 
                  lng_rad, 
                  star_rating, 
                  sector_id, 
                  classification_id,
                  localizedtitle,
                  address,
                  searchTitle,
                  SUM(reviewsCount) as rev_cnt,
                  SUM(imageCount) as image_cnt,
                  SUM(videoCount) as video_cnt,
                  is_ppp as is_ppp_cnt,
                  offer_count as offers_cnt
                  {$pWeightFactor}
              FROM {$pCompanyIndex} 
              WHERE
                {$termSearchClause}
                {$pExtraWhere} %s
              GROUP BY doc_id 
              WITHIN GROUP ORDER BY att_id ASC 
              {$pOrderClause} 
              ";
	}
	
	private function getCompaniesPagedResponse($pTerm, $pIdColumnName, $pQuery, $pQuerySingles, &$pErrors, $pCurrPage, $pRanker, $pConverter)
	{
        $skipDocs = ''; $skipWhere = '';
        //$pageLimit = $this->getPageLimit($pCurrPage);
        $pageLimit = $this->getLimit(0, 1000);

        $phrase = "";
        if($pTerm != '')
        {
            $pTerm = $this->escapeSpecialChars($pTerm);
            $phrase = "\"{$pTerm}\"/1";
        }

        $weightOptions = $this->getCompanyWeightOption(null, $pRanker);
        $query = '';
        if($phrase != "")
            $query = sprintf($pQuery, $skipDocs, $phrase, $skipWhere).$pageLimit.$weightOptions;
        else
            $query = sprintf($pQuery, $skipDocs, $skipWhere).$pageLimit.$weightOptions;
        
        $weightOptionsSing = $this->getCompanyWeightOption(null, "expr('sum(word_count*user_weight)')");
        $querySingles = '';
        
        if($phrase != "")
            $querySingles = sprintf($pQuerySingles, $skipDocs, $phrase, $skipWhere).$pageLimit.$weightOptionsSing;
        else
            $querySingles = sprintf($pQuerySingles, $skipDocs, $skipWhere).$pageLimit.$weightOptionsSing;

        $curTime = microtime(true);

        $this->_logger = $query;
        
        $result = $this->execQuery($query, $pErrors);
        if(!$result)
          return false;

        $this->_logger = "First search = ".round(microtime(true) - $curTime,3)*1000;
        
        
        $compRows = array();
        $compWeights = array();
        $companyDistance = array();
        $companyDistanceFromCenter = array();
        while($row = mysqli_fetch_assoc($result))
        {
          $cId = $row["{$pIdColumnName}"];
          $compRows[$cId] = $row;
          $compWeights[$cId] = $row["{$this->WEIGHT_FACT}"];

          if(isset($row["user_distance"]))
            $companyDistance[$cId] = floatval($row["user_distance"]);
          else
            $companyDistance[$cId] = 0.00;
          
          if(isset($row["distance_from_center"]))
          	$companyDistanceFromCenter[$cId] = floatval($row["distance_from_center"]);
          else
          	$companyDistanceFromCenter[$cId] = 0.00;          
        }

        $curTime = microtime(true);

        $result = $this->execQuery($querySingles, $pErrors);
        if(!$result)
          return false;

        $this->_logger .= "; Second search = ".round(microtime(true) - $curTime,3)*1000;

        while($row = mysqli_fetch_assoc($result))
        {
            $cId = $row["{$pIdColumnName}"];
            if(isset($compRows[$cId]))
            {
                $compRows[$cId]["rev_cnt"] = $row["rev_cnt"];
                $compRows[$cId]["image_cnt"] = $row["image_cnt"];
                $compRows[$cId]["video_cnt"] = $row["video_cnt"];
                $compRows[$cId]["{$this->WEIGHT_FACT}"] += $row["{$this->WEIGHT_FACT}"];
                $compWeights[$cId] += $row["{$this->WEIGHT_FACT}"];
            }
            else
            {
                $compRows[$cId] = $row;
                $compWeights[$cId] = $row["{$this->WEIGHT_FACT}"];

                if(isset($row["user_distance"]))
                    $companyDistance[$cId] = floatval($row["user_distance"]);
                else
                    $companyDistance[$cId] = 0.00;
                
                if(isset($row["distance_from_center"]))
                	$companyDistanceFromCenter[$cId] = floatval($row["distance_from_center"]);
                else
                	$companyDistanceFromCenter[$cId] = 0.00;
            }
        }

        array_multisort($companyDistanceFromCenter, $companyDistance, SORT_ASC, $compWeights, SORT_DESC, $compRows);

       // arsort($compWeights);

        $pageEnd = $pCurrPage * $this->_pageSize;
        $pageStart = $pageEnd - $this->_pageSize;
        $pageEnd -= 1;
        
        $result = array(); $current = 0;


        foreach($compWeights as $key=>$val)
        {
            if($current >= $pageStart && $current <= $pageEnd)
            {
                $row = $compRows[$key];
                $row['locationData'] = $this->locationGetCityById($row['city_id'], $pErrors);
                //$row['locationDataCounty'] = $this->locationGetCountyById($row['locationData'][0]->county->id, $pErrors);
                
                //var_dump($row['locationDataCounty']);
                $result[] = call_user_func_array($pConverter, array($row, $this->_companyRankingSettings));
            }

            $current++;
            if($current > $pageEnd)
                break;
        }

        $resSize = count($compWeights);
        $this->_returnedMatches = $resSize > $this->_maxRecords ? $this->_maxRecords : $resSize;
		//var_dump($result[0]); die;
        return $result;
	}

	private function getPageLimit($pPage)
	{
	   $end = $pPage * $this->_pageSize;
	   $start = $end - $this->_pageSize;
	   
	   return " LIMIT {$start},{$end} ";
	}
	
	private function getLimit($pLimStart, $pLimEnd)
	{
	   return " LIMIT {$pLimStart},{$pLimEnd} ";
	}
	
	private function getCompanyWeightFactor()
	{  
    return
    " weight() + star_rating*{$this->_companyRankingSettings->PlaceRatingCoef} + is_ppp*{$this->_companyRankingSettings->PPPMatch} AS {$this->WEIGHT_FACT}";
	}
	
	private function getCompanyWeightFactorSingles()
	{
	
	  return "SUM(weight()) AS {$this->WEIGHT_FACT}";
  }
	
  private function getCompanyWeightOption($pMaxRecords = null, $pRanker = null)
	{
	  $options = $this->getOptions($pMaxRecords, $pRanker);
	  
	  $option = "OPTION ";
	  if($options != "")
	   $option .= $options.", ";

	  return $option .
      " field_weights=(searchTitle={$this->_companyRankingSettings->TitleMatch}, videoText={$this->_companyRankingSettings->VideoMatch}, imageText={$this->_companyRankingSettings->PhotoMatch}, reviewText={$this->_companyRankingSettings->ReviewMatch}, description={$this->_companyRankingSettings->DescriptionMatch}, detail_description={$this->_companyRankingSettings->DetailedDescriptionMatch}, classification={$this->_companyRankingSettings->ClassificationMatch}, classification_keywords={$this->_companyRankingSettings->ClassificationThesaurusMatch})";
	}
	
	private function getOptions($pMaxRecords = null, $pRanker = null)
	{
	  $option = "";
	  if($pMaxRecords != null)
	  {
	    if($option != "")
	     $option .= ", ";
	     
      $option .= "max_matches={$pMaxRecords}";
	  }
	  
	  if($pRanker != null)
	  {
	    if($option != "")
	     $option .= ", ";
	     
      $option .= "ranker={$pRanker}";
	  }
    
	  return $option;
	}
	
	private function getLangDependentIndex($pIndexName)
	{
        return $pIndexName.$this->_language;
	}
	
	private function connect(&$pErrors)
	{
	  //$link = mysqli_connect ( "127.0.0.1", "root", "", "", 9306 );
	  //var_dump($this->_connectionSettings->Host, $this->_connectionSettings->User, "", "", $this->_connectionSettings->Prot);
        $link = mysqli_connect ( $this->_connectionSettings->Host, $this->_connectionSettings->User, "", "", $this->_connectionSettings->Prot);
        if ( mysqli_connect_errno() )
        {
          $pErrors = "Connect error: " . mysqli_connect_error();
          return false;
        }
    
        return $link;
	}
	
	private function execQuery($pQuery, &$pErrors)
	{
        $link = $this->connect($pErrors);
        if(!$link)
        return false;
	  
        $result = mysqli_query($link, $pQuery);
        if (!$result)
        {
          $pErrors = "Query error: " . mysqli_error($link);
          return false;
        }

        $metaRes = mysqli_query($link, "SHOW META LIKE 'total%';");
        while ($row = mysqli_fetch_assoc($metaRes))
        {
          if($row['Variable_name'] == 'total')
            $this->_returnedMatches = $row['Value'];

          if($row['Variable_name'] == 'total_found')
            $this->_totalMatches = $row['Value'];
        }

        return $result;
	}
}

/*
	private function getPagedResponse($pTerm, $pIdColumnName, $pQuery, &$pErrors, $pCurrPage, $pRanker, $pConverter)
	{
    $skipDocs = ''; $skipWhere = '';
    $pTerm = $this->escapeSpecialChars($pTerm);
    $pageLimit = $this->getPageLimit($pCurrPage);
    $weightOptions = $this->getCompanyWeightOption(null, $pRanker);
    
    $query = sprintf($pQuery, $skipDocs, "\"{$pTerm}\"/1", $skipWhere).$pageLimit.$weightOptions;
    $result = $this->execQuery($query, $pErrors);
    if(!$result)
      return false;
    
    return call_user_func_array($pConverter, array($result, $this->_companyRankingSettings));
	}
	
	private function getPagedResponse($pTerm, $pIdColumnName, $pQuery, &$pErrors, $pCurrPage, $pRanker, $pConverter)
	{
     $totalMatches = 0;
     $returnedMatches = 0;
	   
	   $asterix = "";
	   if(substr($pTerm, -1) == '*')
	   {
	     $asterix = '*';
	     $pTerm = substr($pTerm, 0, -1);
	   }
	   
	   $pTerm = $this->escapeSpecialChars($pTerm);
	   $splitTerm = explode(' ', $pTerm);
	   $wordsCount = count($splitTerm);
	   
	   $pageEnd = $pCurrPage * $this->pageSize;
	   $pageStart = $pageEnd - $this->pageSize;
	    
	   $countersArray = array();
	   $phrasesVisibleOnPage = array();
	   
	   
	   $resultPage = array();
	   $returnedIds = '';
	   
	   for($i=$wordsCount; $i>0; $i--)
	   {
	     $query = ''; $skipDocs = ''; $skipWhere = '';
	     
	     if($returnedIds != '')
	     {
	       $skipDocs = " IN({$pIdColumnName}, {$returnedIds}) as cutDocs, ";
	       $skipWhere = " AND cutDocs = 0 ";
	     }
	     
	     $resultPageSize = count($resultPage);
	   
	     $pageLimit = '';
	     $weightOptions = $this->getCompanyWeightOption(null, $pRanker);
	     
	     $phrase = '';
	     if($i > 1 || $wordsCount == 1)
	     {  
	       $phrase = implode(' ', array_slice($splitTerm, 0, $i));
	       $phrase = "\"{$phrase}{$asterix}\"";
	       $query = sprintf($pQuery, $skipDocs, $phrase, $skipWhere).$pageLimit.$weightOptions;
	     }
	     else
	     {
	       $phrase = "\"{$pTerm}{$asterix}\"/1";  
	       $query = sprintf($pQuery, $skipDocs, $phrase, $skipWhere).$pageLimit.$weightOptions;
	     }
	     
	     $result = $this->execQuery($query, $pErrors);
       if(!$result)
        return false;
        
        $resultPage = call_user_func_array($pConverter, array($result, $this->_companyRankingSettings));
	     return  $resultPage;
       
       $newReturnedIds = '';
       while($row = mysqli_fetch_assoc($result)) 
       {
        if($newReturnedIds != '')
          $newReturnedIds .= ',';
        
        $newReturnedIds .= $row["{$pIdColumnName}"];
       }
       
       $windowStart = $totalMatches;
       $windowEnd = $totalMatches + $this->_totalMatches;
       
       $ls = 0; $le = 0;
       
       if($windowStart <= $pageStart && $pageEnd <= $windowEnd ) //WS<=PS && WE >= PE Page is in that window
       {
        $ls = $pageStart - $windowStart;
        $le = $pageEnd;
       }
       else if($windowStart <= $pageStart && $windowEnd > $pageStart && $pageEnd <= $windowEnd ) //WS<=PS && WE > PS && WE <= PE  Page start gets end of that window
       {
        $ls = $pageStart - $windowStart;
        $le = $windowEnd - $pageStart;
       }
       else if($windowStart >= $pageStart && $windowStart < $pageEnd && $windowEnd > $pageEnd ) //WS>=PS && WS < PE && WE > PE  Page end gets begining of that window
       {
        $ls = 0;
        $le = $pageEnd - $resultPageSize;
       }
       else if($windowStart >= $pageStart && $windowStart < $pageEnd && $windowEnd <= $pageEnd ) //WS>=PS && WS < PE && WE <= PE  Page contains that window
       {
        $ls = 0;
        $le = $this->_totalMatches;
       }
       
       if($returnedIds == '')
        $returnedIds = $newReturnedIds;
       else if($newReturnedIds != '')
        $returnedIds = $returnedIds.','.$newReturnedIds;
       
       $totalMatches += $this->_totalMatches;
       
       if($ls != 0 || $le != 0)
       {
        $pageLimit = $this->getLimit($ls, $le);
        $weightOptions = $this->getCompanyWeightOption(null, $pRanker);
        
        $query = sprintf($pQuery, $skipDocs, $phrase, $skipWhere).$pageLimit.$weightOptions;
        $result = $this->execQuery($query, $pErrors);
        if(!$result)
          return false;
        
        $resObj = call_user_func_array($pConverter, array($result, $this->_companyRankingSettings));
        $resultPage = array_merge($resultPage, $resObj);
       }
	   }
	  
	   $returnedMatches = $totalMatches; 
	   if($returnedMatches > $this->maxRecords)
	     $returnedMatches = $this->maxRecords;
	   
	   $this->_returnedMatches = $returnedMatches;
     $this->_totalMatches = $totalMatches;
     
     return $resultPage;
	}
	*/


 /*
    return
    "SUM(reviewsCount*{$this->_companyRankingSettings->ReviewMatch}) AS revweight, 
     SUM(imageCount*{$this->_companyRankingSettings->PhotoMatch}) AS imgweight,
     SUM(videoCount*{$this->_companyRankingSettings->VideoMatch}) AS videoweight,
     SUM(descriptionCount*{$this->_companyRankingSettings->DescriptionMatch}) AS descriptionweight,
     SUM(detail_descriptionCount*{$this->_companyRankingSettings->DetailedDescriptionMatch}) AS detail_descriptionweight,
     (is_ppp*{$this->_companyRankingSettings->PPPMatch}) AS ispppweight,
     weight()+star_rating*{$this->_companyRankingSettings->PlaceRatingCoef} as {$this->WEIGHT_FACT} ";
     */
/*
	function GetSomething($term)
	{
	  $link = mysqli_connect ( "127.0.0.1", "root", "", "", 9306 );
    if ( mysqli_connect_errno() )
        die ( "connect failed: " . mysqli_connect_error() );
    
    $query = "SELECT id, name, name_en, slug, currency FROM iCountry WHERE
                    MATCH('@(name,name_en) {$term}*')";
    
    $result = mysqli_query($link, $query);
    if ( !$result )
         die(mysqli_error($link));
	
    $contries = array();
    while ($row = mysqli_fetch_assoc($result)) 
    {
        $contries[] = array(
            'label' => $row['name'].'('.$row['name_en'].')',
            'value' => $row['id']
        );
    }
    return $contries;
	}
	*/
	
	
	 
   /*
   
   weight() as newWeight, SUM(reviewsCount), SUM(imageCount), SUM(videoCount) 
   detail_description,
   
   
    ORDER BY @weight DESC OPTION field_weights=(title=10,
artist=10, description=5, search_words=5),
index_weights=(content_stemmer=7,content_soundex=3,content_metaphone=10), ranker=bm25;


ORDER BY @weight DESC 
              OPTION field_weights=(title=10, classification=10, classification_keywords=5, detail_description=5)


SELECT *, @weight+IF(fieldcrc==$querycrc,1000,0) AS myweight ...
ORDER BY myweight DESC
    */
   /* $query = "SELECT doc_id
              FROM iCompanyen
              WHERE MATCH('@(title) {$term}*')
              ";
    */

	/*
	
	public function searchCompaniesByCityIdS($pTerm, $pCityId, &$pErrors, $pCurrPage=1)
	{
	  
	  if($this->_companyRankingSettings == null)
	  {
	     $pErrors = "Company Rank Settings should be set befor search companies";
	     return false;
	  }
	  
    $companyIndex = $this->getLangDependentIndex('iCompanyS');
    
    $weightFactor = $this->getCompanyWeightFactor();
    //$weightOptions = $this->getCompanyWeightOption(null, 'matchany');
    //$weightOptions = $this->getCompanyWeightOption();
    $weightOptions = $this->getCompanyWeightOption(null, 'proximity');
    $pageLimit = $this->getPageLimit($pCurrPage);
    
    $query = "SELECT 
                  doc_id, 
                  country_id,  
                  county_id, 
                  city_id, 
                  longitude, 
                  latitude, 
                  lat_rad, 
                  lng_rad, 
                  star_rating, 
                  sector_id, 
                  classification_id,
                  localizedtitle,
                  address,
                  SUM(reviewsCount) as rev_cnt,
                  SUM(imageCount) as image_cnt,
                  SUM(videoCount) as video_cnt,
                  SUM(is_ppp) as is_ppp_cnt,
                  {$weightFactor}
              FROM {$companyIndex}, iCompanyReviewS, iCompanyImageS, iComapnyVideoS 
              WHERE 
                MATCH('@(title,description,detail_description,classification,classification_keywords,reviewText,videoText,imageText) \"{$pTerm}*\"/1')
                AND 
                city_id = {$pCityId}
              GROUP BY doc_id 
              WITHIN GROUP ORDER BY id ASC 
              ORDER BY {$this->WEIGHT_FACT} DESC, revweight DESC, imgweight DESC, videoweight DESC, ispppweight DESC 
              {$pageLimit}
              {$weightOptions}";
    
   
    
    $result = $this->execQuery($query, $pErrors);
    if(!$result)
      return false;
    
    return SphinxCompany::FromResource($result);
	}
	
	
		private function getPagedResponse($pTerm, $pIdColumnName, $pQuery, &$pErrors, $pCurrPage, $pRanker, $pConverter)
	{
     $totalMatches = 0;
     $returnedMatches = 0;
	   $splitTerm = explode(' ', $pTerm);
	   $wordsCount = count($splitTerm);
	   
	   $pageEnd = $pCurrPage * $this->pageSize;
	   $pageStart = $pageEnd - $this->pageSize;
	    
	   $countersArray = array();
	   $phrasesVisibleOnPage = array();
	   
	   
	   $resultPage = array();
	   $resultPageHash = array();
	   $returnedIds = '';
	   
	   for($i=$wordsCount; $i>0; $i--)
	   {
	     $query = ''; $skipDocs = ''; $skipWhere = '';
	     
	     if($returnedIds != '')
	     {
	       $skipDocs = " IN({$pIdColumnName}, {$returnedIds}) as cutDocs, ";
	       $skipWhere = " AND cutDocs = 0 ";
	     }
	     
	     $resultPageSize = count($resultPage);
	   
	     //For counting all possible records
	     //Use 1 page of each phrase and set max_records to 1 for RAM saving and performance  
	     //$pageLimit = $this->getLimit(0,1);
	     //$weightOptions = $this->getCompanyWeightOption(1, $pRanker);
	     
	     $pageLimit = '';
	     $weightOptions = $this->getCompanyWeightOption(null, $pRanker);
	     
	     $phrase = '';
	     if($i > 1)
	     {  
	       $phrase = implode(' ', array_slice($splitTerm, 0, $i));
	       $phrase = "\"{$phrase}\"";
	       $query = sprintf($pQuery, $skipDocs, $phrase, $skipWhere).$pageLimit.$weightOptions;
	     }
	     else
	     {
	       $phrase = "\"{$pTerm}\"/1";  
	       $query = sprintf($pQuery, $skipDocs, $phrase, $skipWhere).$pageLimit.$weightOptions;
	     }
	     
	     $result = $this->execQuery($query, $pErrors);
       if(!$result)
        return false;
       
       $newReturnedIds = '';
       while($row = mysqli_fetch_assoc($result)) 
       {
        if($newReturnedIds != '')
          $newReturnedIds .= ',';
        
        $newReturnedIds .= $row["{$pIdColumnName}"];
       }
      
       $windowStart = $totalMatches;
       $windowEnd = $totalMatches + $this->_totalMatches;
       
       $ls = 0; $le = 0;
       
       if($windowStart <= $pageStart && $pageEnd <= $windowEnd ) //WS<=PS && WE >= PE Page is in that window
       {
        $ls = $pageStart - $windowStart; //0;//$pageStart - $windowStart; - start from zero because of potential duplicates
        $le = $pageEnd;// + $resultPageSize; //add $resultPageSize $resultPageSize because of potential duplicates
       }
       else if($windowStart <= $pageStart && $windowEnd > $pageStart && $pageEnd <= $windowEnd ) //WS<=PS && WE > PS && WE <= PE  Page start gets end of that window
       {
        $ls = $pageStart - $windowStart;//0;//$pageStart - $windowStart; - start from zero because of potential duplicates
        $le = $windowEnd - $pageStart + $resultPageSize; //add $resultPageSize $resultPageSize because of potential duplicates
       }
       else if($windowStart >= $pageStart && $windowStart < $pageEnd && $windowEnd > $pageEnd ) //WS>=PS && WS < PE && WE > PE  Page end gets begining of that window
       {
        $ls = 0;
        $le = $pageEnd - $resultPageSize;//$pageEnd; //$pageEnd - $resultPageSize, but we remove $resultPageSize because of potential duplicates
       }
       else if($windowStart >= $pageStart && $windowStart < $pageEnd && $windowEnd <= $pageEnd ) //WS>=PS && WS < PE && WE <= PE  Page contains that window
       {
        $ls = 0;
        $le = $this->_totalMatches;
       }
       
       if($ls != 0 || $le != 0)
       {
        $pageLimit = $this->getLimit($ls, $le);
        $weightOptions = $this->getCompanyWeightOption(null, $pRanker);
        
        $query = sprintf($pQuery, $skipDocs, $phrase, $skipWhere).$pageLimit.$weightOptions;
        $result = $this->execQuery($query, $pErrors);
        if(!$result)
          return false;
        
        $resObj = call_user_func_array($pConverter, array($result));
        $resultPage = array_merge($resultPage, $resObj);
        
//      foreach($resObj as $cmp)
//        {
//          //if(array_key_exists($cmp->Id, $resultPageHash))
//          //  continue;
//            
//          //if(count($resultPageHash) >= $this->pageSize)
//          //  break;
//          
//          $resultPage[] = $cmp;
//          $resultPageHash[$cmp->Id] = $cmp->Id;
//          
//          if($returnedIds != '')
//            $returnedIds .= ',';
//          
//          $returnedIds .= $cmp->Id;
//        }
        
       }
       
       if($returnedIds == '')
        $returnedIds = $newReturnedIds;
       else if($newReturnedIds != '')
        $returnedIds = $returnedIds.','.$newReturnedIds;
       
       $totalMatches += $this->_totalMatches;
	   }
	   
	   $returnedMatches = $totalMatches; 
	   if($returnedMatches > $this->maxRecords)
	     $returnedMatches = $this->maxRecords;
	   
	   $this->_returnedMatches = $returnedMatches;
     $this->_totalMatches = $totalMatches;
     
     return $resultPage;
	}
	
	private function getPagedResponse($pTerm, $pQuery, &$pErrors, $pCurrPage, $converter)
	{
     $totalMatches = 0;
     $returnedMatches = 0;
	   $splitTerm = explode(' ', $pTerm);
	   $wordsCount = count($splitTerm);
	   
	   $end = $pCurrPage * $this->pageSize;
	   $start = $end - $this->pageSize;
	   
	   $resultPage = array();
	   $processCurrPage = $pCurrPage;
	   
	   
	   for($i=$wordsCount; $i>0; $i--)
	   {
	     $objectsOnPage = count($resultPage);
	     
	     $pageLimit = $this->getPageLimit($processCurrPage);
	     
	     $query = '';
	     if($i > 1)
	     {  
	       $phrase = implode(' ', array_slice($splitTerm, 0, $i));
	       $query = sprintf($pQuery, "\"{$phrase}\"", $pageLimit);
	     }
	     else
	       $query = sprintf($pQuery, "\"{$pTerm}\"/1", $pageLimit);
	     
	     $result = $this->execQuery($phraseQuery, $pErrors);
       if(!$result)
        return false;
       
       $totalMatches += $this->_totalMatches;
       
       if($returnedMatches < $this->maxRecords)
       {
          $rowsCount = mysqli_num_rows($result);
          if($returnedMatches + $rowsCount >= $start && $end <= $returnedMatches + $rowsCount)
          {
            $objects = $converter($result);
            $resultPage = array_merge($resultPage, array_slice($objects, 0, $this->pageSize - count($resultPage)));
          }
       
          $returnedMatches += $this->_returnedMatches;
          if($returnedMatches > $this->maxRecords)
            $returnedMatches = $this->maxRecords;
            
          if($returnedMatches >= $start)
            $processCurrPage = 1;
       }
	   }
	   
	   $this->_returnedMatches = $returnedMatches;
     $this->_totalMatches = $totalMatches;
     
     return $resultPage;
	}
	*/


?>