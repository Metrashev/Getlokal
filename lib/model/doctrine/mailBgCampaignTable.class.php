<?php

/**
 * mailBgCampaignTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class mailBgCampaignTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object mailBgCampaignTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('mailBgCampaign');
    }
    
    public function getQueryForMailList(Doctrine_Query $q)
    {
    	$rootAlias = $q->getRootAlias();
    	$q->innerJoin($rootAlias.'.Company c2')
    	  ->addWhere('c2.country_id = ?',  getlokalPartner::getInstance());
    
    	return $q;
    }
    
  static public function applyCompanyFilter($query, $value)
  {
  
     $rootAlias = $query->getRootAlias();
    
     $query->innerJoin($rootAlias.'.Company c')
      ->addWhere('c.title like ? or c.title_en like ?',  array('%'. $value['text'].'%', '%'.$value['text'].'%'));
      
    return $query;
  
  }
  static public function applyCompanyStatusFilter($query, $value)
  {
    $rootAlias = $query->getRootAlias();
      $query->innerJoin($rootAlias.'.Company c1')    
      ->addWhere('c1.status = ?',  $value);
      
      return $query;
   
  } 
  
  static public function applyCityIdFilter($query, $value)
  {
  	$rootAlias = $query->getRootAlias();
  	$query->addWhere('city_id = ?',  intval($value));
  	 
  	return $query;
  
  }
}