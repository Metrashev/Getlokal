<?php

/**
 * NewsletterTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class NewsletterTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object NewsletterTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Newsletter');
    }
    

    
static public function retrieveActivePerCountry($country_id=null, $type = null)
 {
  if (!$country_id)
    {
	  $country_id =  sfContext::getInstance()->getUser()->getCountry()->getId();
	
    }
	$query = Doctrine_Core::getTable('Newsletter')
    ->createQuery('q')
    ->innerJoin('q.Translation t')
    ->where('q.is_active = ?', true)
    ->addWhere('q.country_id = ?', $country_id);
    if ($type)
    { 
    	$query->addWhere('q.user_group = ?', $type);    	
    }
    $query->orderBy('q.user_group, t.name');
    $result = $query->execute();
    if (count($result) > 0 )
    {
    	return $result;
    }

    return false;
  }
      public function getQueryForAdmin(Doctrine_Query $q)
    {
    	$rootAlias = $q->getRootAlias();    
    	$q->addwhere($rootAlias.'.country_id = ?', getlokalPartner::getInstance());
    
    	return $q;
    }
static public function retrieveActivePerCountryForUser($country_id=null)
 {
  if (!$country_id)
    {
	  $country_id =  sfContext::getInstance()->getUser()->getCountry()->getId();
	
    }
	$query = Doctrine_Core::getTable('Newsletter')
    ->createQuery('q')
    ->innerJoin('q.Translation t')
    ->where('q.is_active = ?', true)
    ->addWhere('q.country_id = ?', $country_id)
    ->addWhere('q.user_group != ?', 'business')
    ->orderBy('t.name ASC');
    $result = $query->execute();
    if (count($result) > 0 )
    {
    	return $result;
    }

    return false;
  }
static public function retrieveActivePerCountryForBusiness($country_id=null)
 {
  if (!$country_id)
    {
	  $country_id =  sfContext::getInstance()->getUser()->getCountry()->getId();
	
    }
	$query = Doctrine_Core::getTable('Newsletter')
    ->createQuery('q')
    ->innerJoin('q.Translation t')
    ->where('q.is_active = ?', true)
    ->addWhere('q.country_id = ?', $country_id)
    ->addWhere('q.user_group = ?', 'business')
    ->orderBy('t.name ASC');
    $result = $query->execute();
    if (count($result) > 0 )
    {
    	return $result;
    }

    return false;
  }
}