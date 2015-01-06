<?php

/**
 * getWeekendTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class getWeekendTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object getWeekendTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('getWeekend');
    }
    
    public function getQueryForAdmin(Doctrine_Query $q)
  {
    $rootAlias = $q->getRootAlias();

    $q->where($rootAlias.'.country_id = ?', sfContext::getInstance()->getUser()->getCountry()->getId());

    return $q;
  }
}