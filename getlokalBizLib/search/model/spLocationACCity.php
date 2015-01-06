<?php 
if(!class_exists('spLocationACCounty')){
  require_once(__DIR__ .'./spLocationACCounty.php');
}

class spLocationACCity
{
	public $id;
	public $name;
	public $nameEn;
	
	/**
	 * @var $county = new spCounty();
	 */
	public $county;
	
	public static function FromResource($_resource)
  {
    $cities = array();
    while ($row = mysqli_fetch_assoc($_resource)) 
    {
      $cit = new spLocationACCity();
      $cit->id = $row['att_id'];
      $cit->name = $row['name'];
      $cit->nameEn = $row['nameen'];
      
      $cit->county = new spLocationACCounty();
      $cit->county->id = $row['county_id'];
	    $cit->county->name = $row['county_name'];
	    $cit->county->nameEn = $row['county_nameen'];
	    
	    $cit->county->country = new spLocationACCountry();
	    $cit->county->country->id = $row['country_id'];
	    $cit->county->country->name = $row['country_name'];
	    $cit->county->country->nameEn = $row['country_nameen'];
	    
	    /*
	    ----- Extra City data in the Index-----
      $row['slug']
      $row['municipality']
      $row['region']
      $row['conv_lat']
      $row['conv_lng']
      $row['lat_rad']
      $row['lng_rad']
      $row['is_default']
      */
       
      $cities[] = $cit;
    }
    
    return $cities;
  }
}

?>