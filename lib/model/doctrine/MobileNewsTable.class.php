<?php

/**
 * MobileNewsTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class MobileNewsTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object MobileNewsTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('MobileNews');
    }
    
    public function getQueryForAdmin(Doctrine_Query $q)
  {
    $rootAlias = $q->getRootAlias();

    $q->where($rootAlias.'.country_id = ?', sfContext::getInstance()->getUser()->getCountry()->getId());

    return $q;
  }
  
  static public function applyCityIdFilter($query, $value)
  {
  	$rootAlias = $query->getRootAlias();
  	$query->addWhere('cities_list = ?',  intval($value));
  
  	return $query;
  }
}