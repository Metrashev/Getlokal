<?php
class spLocationACCountry
{
	public $id;
	public $name;
	public $nameEn;
	
	public static function FromResource($_resource)
  {
    $countries = array();
    while ($row = mysqli_fetch_assoc($_resource)) 
    {
      $co = new spLocationACCountry();
    
	    $co->country = new spLocationACCountry();
	    $co->id = $row['id_attr'];
	    $co->name = $row['name'];
	    $co->nameEn = $row['name_en'];
	    
	    /*
	    ----- Extra County data in the Index-----
      $row['slug'];
      $row['currency'];
      */
       
      $countries[] = $co;
    }
    
    return $countries;
  }
}

?>