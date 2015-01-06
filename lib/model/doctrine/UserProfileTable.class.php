<?php

/**
 * UserProfileTable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class UserProfileTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object UserProfileTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('UserProfile');
    }

    public function getQueryForAddPlaceGame(Doctrine_Query $q)
    {
    	$rootAlias = $q->getRootAlias();
    	$q->andWhere($rootAlias.'.country_id = ?',  getlokalPartner::getInstance());

    	return $q;
    }

    public function getQueryForAdmin(Doctrine_Query $q)
    {

    	$rootAlias = $q->getRootAlias();
    	$domain = sfContext::getInstance()->getRequest()->getHost();
    	/*$q->innerJoin($rootAlias.'.City')
    	->where($rootAlias.'.country_id = ?', sfContext::getInstance()->getUser()->getCountry()->getId());*/

    	$q->innerJoin($rootAlias.'.City');
    	if (!(strstr($domain, '.my')) && !(strstr($domain, '.com')))
    	{

    		$q->addWhere($rootAlias.'.country_id = ?', sfContext::getInstance()->getUser()->getCountry()->getId());
    	}

    	return $q;
    }

  static public function applyFirstNameFilter($query, $value)
  {
    $rootAlias = $query->getRootAlias();
    $query->innerJoin($rootAlias.'.sfGuardUser u')
            ->addWhere('u.first_name like ?', '%'.$value['text'].'%');
    return $query;
  }

  static public function applyLastNameFilter($query, $value)
  {
    $rootAlias = $query->getRootAlias();
    $query->innerJoin($rootAlias.'.sfGuardUser u1')
            ->addWhere('u1.last_name like ?', '%'.$value['text'].'%');

    return $query;
  }

  static public function applyEmailAddressFilter($query, $value)
  {
    $rootAlias = $query->getRootAlias();
    $query->innerJoin($rootAlias.'.sfGuardUser u2')
            ->addWhere('u2.email_address like ?', '%'.$value['text'].'%');

    return $query;
  }

  static public function applyIsActiveFilter($query, $value)
  {
    $rootAlias = $query->getRootAlias();
    $query->innerJoin($rootAlias.'.sfGuardUser u4')
            ->addWhere('u4.is_active = ?', $value.'%');

    return $query;
  }

  static public function applyStatusFilter($query, $value)
  {
    $rootAlias = $query->getRootAlias();
    if ($value == 2 ){
      $query->innerJoin($rootAlias.'.PageAdmin u4p');
    }
    elseif ($value == 1 )
    {
      $q3 = $query->createSubquery ()->select ( 'ct.user_id' )
        ->from ( 'PageAdmin ct' );
      $query->andWhere ( $rootAlias.'.id NOT IN (' . $q3->getDql () . ')' );
    }
    elseif ($value == 3 )
    {
      $query->innerJoin($rootAlias.'.PageAdmin pa4')
        ->andWhere('pa4.status = "approved"');
    }

    return $query;
  }

  static public function applyCompanyCreatedAtFilter($query, $values)
  {
    $rootAlias = $query->getRootAlias();
    $query->innerJoin($rootAlias.'.Company p');

    if (null !== $values['from'] && null !== $values['to'])
    {
      $query->andWhere('p.created_at >= ?', $values['from']);
      $query->andWhere('p.created_at <= ?', $values['to']);
    }
    else if (null !== $values['from'])
    {
      $query->andWhere('p.created_at >= ?', $values['from']);
    }
    else if (null !== $values['to'])
    {
      $query->andWhere('p.created_at <= ?', $values['to']);
    }
    return $query;
  }

  static public function applyAllowContactFilter($query, $value)
  {
    $rootAlias = $query->getRootAlias();
    $query->innerJoin($rootAlias.'.UserSetting u41')
            ->addWhere('u41.allow_contact = ?', $value);
    return $query;
  }

  static public function applyAllowNewsletterFilter($query, $value)
  {
    $rootAlias = $query->getRootAlias();
    $query->innerJoin($rootAlias.'.UserSetting u42')
            ->addWhere('u42.allow_newsletter = ?', $value);

    return $query;
  }

  static public function applyAllowBCmcFilter($query, $value)
  {
    $rootAlias = $query->getRootAlias();
    $query->innerJoin($rootAlias.'.UserSetting u43')
            ->addWhere('u43.allow_b_cmc = ?', $value);

    return $query;
  }

  static public function applyReviewCreatedAtFilter($query, $values)
  {
    $rootAlias = $query->getRootAlias();
    $query->innerJoin($rootAlias.'.Review rp');

    if (null !== $values['from'])
    {
      $query->andWhere('rp.created_at >= ?', $values['from']);
    }
    else if (null !== $values['to'])
    {
      $query->andWhere('rp.created_at <= ?', $values['to']);
    }
    return $query;
  }

  static public function applyWeekIdFilter($query, $value)
  {
    $rootAlias = $query->getRootAlias();
    $query->innerJoin($rootAlias.'.ReviewVoucher rv1')
            ->addWhere('rv1.week_id = ?', $value['text']);

    return $query;
  }

  static public function applyFacebookConnectedFilter($query, $value)
  {
    $rootAlias = $query->getRootAlias();
    $condition = $value == 1 ? 'IS NOT NULL' : 'IS NULL';

    $query->addWhere("{$rootAlias}.facebook_uid {$condition}");

    return $query;
  }

  static public function applyCityIdFilter($query, $value)
  {
  	$rootAlias = $query->getRootAlias();
  	$query->addWhere('city_id = ?',  intval($value));

  	return $query;
  }

 /* static public function applyCityIdOnlyFilter($query, $value)
  {
  	$rootAlias = $query->getRootAlias();
  	$query->addWhere('city_id = ?',  intval($value));
  	//var_dump(intval($value));exit();
  	return $query;
  }*/

  static public function applyCountryIdFilter($query, $value)
  {
  	$rootAlias = $query->getRootAlias();
  	$query->addWhere('country_id = ?',  intval($value));

  	return $query;
  }

}