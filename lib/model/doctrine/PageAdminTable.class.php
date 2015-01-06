<?php

/**
 * PageAdminTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class PageAdminTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object PageAdminTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('PageAdmin');
    }

    public function getQueryForAdmin(Doctrine_Query $q)
    {    
    	$rootAlias = $q->getRootAlias();
    
    	$q->innerJoin($rootAlias.'.CompanyPage cp')
        ->innerJoin('cp.Company c')
    	->addWhere('c.country_id = ?',  getlokalPartner::getInstance());

    	return $q;
    }  
    
  static public function applyEmailAddressFilter($query, $value)
  {
    $rootAlias = $query->getRootAlias();
    $query->innerJoin($rootAlias.'.UserProfile f1')
            ->innerJoin('f1.sfGuardUser sf1')
            ->addWhere('sf1.email_address like ? ', $value['text'].'%');	

    return $query;
    
  }
  
static public function applyFirstNameFilter($query, $value)
  {
    $rootAlias = $query->getRootAlias();
    $query->innerJoin($rootAlias.'.UserProfile u2')
            ->innerJoin('u2.sfGuardUser s2')
            ->addWhere('s2.first_name like ?', $value['text'].'%');	

    return $query;
       
      
   
  }
  
static public function applyLastNameFilter($query, $value)
  {
  	
    $rootAlias = $query->getRootAlias();
    $query->innerJoin($rootAlias.'.UserProfile l3')
            ->innerJoin('l3.sfGuardUser sg3')
            ->addWhere('sg3.last_name like ?', $value['text'].'%');	

    return $query;
       
      
   
  }
static public function applyCompanyCityFilter($query, $value)
  {
    $rootAlias = $query->getRootAlias();
      $query->innerJoin($rootAlias.'.CompanyPage cp4')
      ->innerJoin('cp4.Company c4')
      ->addWhere('c4.city_id = ?',  $value);
      
      return $query;
   
  }
static public function applyCompanyFilter($query, $value)
  {
  
     $rootAlias = $query->getRootAlias();
    
     $query->innerJoin($rootAlias.'.CompanyPage cp5')
      ->innerJoin('cp5.Company c5')
      ->innerJoin('c5.Translation ct5')
      ->addWhere('ct5.title like ?', '%'.$value['text'].'%');
      //->addWhere('c5.title like ? or c5.title_en like ?', array( '%'.$value['text'].'%',  '%'.$value['text'].'%'));
      
    return $query;
  
  }
static public function applyPositionFilter($query, $value)
  {
    $rootAlias = $query->getRootAlias();
    $query->addWhere($rootAlias.'.position = ?', $value);	

    return $query;
      
   
  }
 /* 
  static public function applyCountryFilter($query, $value)
  {
    $rootAlias = $query->getRootAlias();
   
     $query->innerJoin($rootAlias.'.CompanyPage cp6')
      ->innerJoin('cp6.Company c6')
      ->addWhere('c6.country_id = ?',  $value);
      
    return $query;
   
  }
  */
static public function applyCompanyStatusFilter($query, $value)
  {
    $rootAlias = $query->getRootAlias();
      $query->innerJoin($rootAlias.'.CompanyPage cp41')
      ->innerJoin('cp41.Company c41')
      ->addWhere('c41.status = ?',  $value);
      
      return $query;
   
  }
  
  static public function applyCityIdFilter($query, $value)
  {
  	$rootAlias = $query->getRootAlias();
  	$query->addWhere('company_city = ?',  intval($value));
  
  	return $query;
  }
}