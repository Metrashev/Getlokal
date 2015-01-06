<?php 
if(!class_exists('spLocationACCountry')){
	require_once(__DIR__ .'./spLocationACCountry.php');
}

class spLocationACCounty
{
	public $id;
	public $name;
	public $nameEn;
	
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
}

?>