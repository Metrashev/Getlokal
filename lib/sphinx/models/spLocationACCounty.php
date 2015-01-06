<?php 
if(!class_exists('spLocationACCountry')){
	include_once 'spLocationACCountry.php';
}

class spLocationACCounty extends spLocationACBase
{
	/**
	 * @var $country = new spCountry();
	 */
	public $country;
	
	public static function FromResource($_resource)
  {
    $counties = array();
    while ($row = mysqli_fetch_assoc($_resource)) 
    {
      $cont = new spLocationACCounty();
      $cont->id = $row['contatt_id'];
      $cont->name = $row['name'];
      $cont->nameEn = $row['nameen'];
      
	    $cont->country = new spLocationACCountry();
	    $cont->country->id = $row['country_id'];
	    $cont->country->name = $row['contry_name'];
	    $cont->country->nameEn = $row['contry_name_en'];
	    
	    /*
	    ----- Extra County data in the Index-----
      $row['municipality'];
      $row['region'];
      $row['slug'];
      $row['contry_slug'];
      */
       
      $counties[] = $cont;
    }
    
    return $counties;
  }
  
  public function getName($lang){
  	if($this->country->id == 1){
  		if($lang == "en" || $this->name == ""){
  			$return = $this->nameEn;
  			$return = str_ireplace('Regiunea', '', $return);
  			$return = str_ireplace('Province', '', $return);
  			$return = str_ireplace('County', '', $return);
  			$return = trim($return);
  			$return = $return." County";
  		}else{
  			$return = $this->name;
  			$return = str_ireplace('област', '', $return);
  			$return = trim($return);
  			$return = "Област ".$this->name;
  		}  		
  		return $return;  		
  	}
  	return $this->name;
  }
  
  public function getNameEn($lang){
  	if($this->country->id == 1){
  		if($lang == "en" || $this->name == ""){
  			$return = $this->nameEn;
  			$return = str_ireplace('Regiunea', '', $return);
  			$return = str_ireplace('Province', '', $return);
  			$return = str_ireplace('County', '', $return);
  			$return = trim($return);
  			$return = $return." County";
  		}else{
  			$return = $this->name;
  			$return = str_ireplace('област', '', $return);
  			$return = trim($return);
  			$return = "Област ".$this->name;
  		}  		
  		return $return;  
  	}
  	return $this->nameEn;
  }
}

?>