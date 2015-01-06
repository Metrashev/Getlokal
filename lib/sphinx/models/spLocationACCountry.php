<?php 
if(!class_exists('spLocationACBase')){
	include_once 'base/spLocationACBase.php';
}

class spLocationACCountry extends spLocationACBase
{
	public static function FromResource($_resource)
	  {
	    $countries = array();
	    while ($row = mysqli_fetch_assoc($_resource)) 
	    {
	      $co = new spLocationACCountry();
	    
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
	  
	public function getCountryName($lang, $countryId){
		if($lang != 'en' && $countryId == $this->id){
			if($lang == 'ru' && $this->id == 78){
				return 'Финляндия';
			}else{
				if($this->name != ""){
					return $this->name;
				}else{
					return $this->nameEn;
				}
			}
		}else{
			return $this->nameEn;
		}
	}
}

?>