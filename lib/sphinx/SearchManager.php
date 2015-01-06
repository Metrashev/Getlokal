<?php 
require_once('settings/SpinxQLConnectionSettings.php');
require_once('settings/SphinxCompanyRankingSettings.php');

class SearchManager
{
  public $pageSize = 20;
  //Set In config for searched
  public $maxRecords = 1000;
  
  private $_language;
  private $_connectionSettings;
  private $_companyRankingSettings;
  
  private $WEIGHT_FACT = 'weightFactor';
  private $_returnedMatches;
  private $_totalMatches;
  
  public function __construct($pLang, SpinxQLConnectionSettings &$pConnSettings, SphinxCompanyRankingSettings &$pCompanyRankingSettings = null)
	{
    $this->_language = $pLang;
    $this->_connectionSettings = &$pConnSettings;
    $this->_companyRankingSettings = &$pCompanyRankingSettings;
	}
	
	public function getReturnedMatches()
	{
	   return $this->_returnedMatches;
	}
	
	public function getTotalMatches()
	{
	   return $this->_totalMatches;
	}
	
	public function testSearcIndex($pTerm, &$pErrors)
	{
		$pTerm = $this->escapeSpecialChars($pTerm);
	    $query = "SELECT *
	              FROM searchen
	                WHERE
	                    MATCH('
	                        @(title,description,detail_description,review,classification,extra_classification,video,image) {$pTerm}
	                    ')
	                    city_id = 3341";
	
	    $result = $this->execQuery($query, $pErrors);
	    if(!$result)
	      return false;
	      
	    $rowsCount = mysqli_num_rows($result);
	}
	
	public function locationGetACCity($pTerm, &$pErrors)
	{
	  $pTerm = $this->escapeSpecialChars($pTerm);
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
	                MATCH('@(translated_name,slug) {$pTerm}*') 
	              LIMIT 0,{$this->maxRecords}";
	
	    $result = $this->execQuery($query, $pErrors);
	    if(!$result)
	      return false;
	    
	    return spLocationACCity::FromResource($result);
	}
	
  public function locationGetACCounty($pTerm, &$pErrors)
  {
  	  $pTerm = $this->escapeSpecialChars($pTerm);
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
                  MATCH('@(county_name_translated,slug) {$pTerm}*') 
                LIMIT 0,{$this->maxRecords}";

      $result = $this->execQuery($query, $pErrors);
      if(!$result)
        return false;
      
      return spLocationACCounty::FromResource($result);
  }
  
  public function locationGetACCountry($pTerm, &$pErrors)
  {
  	$pTerm = $this->escapeSpecialChars($pTerm);
    $countryIndex = 'iCountry';
    
    $query = "SELECT 
                id_attr,
                name,
                name_en,
                slug,
                currency 
              FROM {$countryIndex}
              WHERE 
                MATCH('@(name,name_en,slug) {$pTerm}*') 
              LIMIT 0,{$this->maxRecords}";

    $result = $this->execQuery($query, $pErrors);
    if(!$result)
      return false;
    
    return spLocationACCountry::FromResource($result);
  }
	
	private function getPageLimit($pPage)
	{
	   $end = $pPage * $this->pageSize;
	   $start = $end - $this->pageSize;
	   
	   return " LIMIT {$start},{$end} ";
	}
	
	private function getOptions($pMaxRecords = null, $pRanker = null)
	{
	  $option = "";
	  if($pMaxRecords != null)
	  {
	    if($option == "")
	     $option .= ", ";
	     
      $option .= "max_matches={$pMaxRecords}";
	  }
	  
	  if($pRanker != null)
	  {
	    if($option == "")
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
	
	private function escapeSpecialChars($pTerm)
	{
		$from = array ( '\\', '(',')','|','-','!','@','~','"','&', '/', '^', '$', '=' );
		$to   = array ( '\\\\\\', '\\\(','\\\)','\\\|','\\\-','\\\!','\\\@','\\\~','\\\"', '\\\&', '\\\/', '\\\^', '\\\$', '\\\=' );
	
		return str_replace ( $from, $to, $pTerm );
	}
}
?>