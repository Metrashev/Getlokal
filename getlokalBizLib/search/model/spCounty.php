<?php 
if(!class_exists('spCountry')){
	require_once(__DIR__ .'./spCountry.php');
}

class spCounty
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
      $cont = new spCounty();
      $cont->id = $row['contatt_id'];
      $cont->name = $row['name'];
      $cont->nameEn = $row['nameen'];
      
	    $cont->country = new spCountry();
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