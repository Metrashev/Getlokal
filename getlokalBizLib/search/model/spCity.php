<?php 
if(!class_exists('spCounty')){
  require_once(__DIR__ .'./spCounty.php');
}

class spCity
{
	public $id;
	public $name;
	public $nameEn;
	public $slug;
	
	/**
	 * @var $county = new spCounty();
	 */
	public $county;
	
	public static function FromResource($_resource)
  {
    $cities = array();
    while ($row = mysqli_fetch_assoc($_resource)) 
    {
      $cit = new spCity();
      $cit->id = $row['att_id'];
      $cit->name = $row['name'];
      $cit->nameEn = $row['nameen'];
      $cit->slug = $row['slug'];
      
      $cit->county = new spCounty();
      $cit->county->id = $row['county_id'];
	    $cit->county->name = $row['county_name'];
	    $cit->county->nameEn = $row['county_nameen'];
	    
	    $cit->county->country = new spCountry();
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
  
  public function getId(){
  	return $this->id;
  }
  
  public function getName($lang = null){
  	if($lang == 'en'){
  		return $this->nameEn;
  	}else{
  		return $this->name;
  	}
  }
  
  public function getSlug(){
  	return $this->slug;
  }
  
  public function getCityNameByCulture( $culture = null ){
  	if($culture == 'en'){
  		return $this->nameEn;
  	}else{
  		return $this->name;
  	}
  }
  
}

?>