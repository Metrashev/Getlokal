<?php

class myUser extends sfGuardSecurityUser
{
    protected $country = null,
            $city,
            $county,  /** added new for Finland county **/
            $profile;

  public function getId()
  {
    return $this->getAttribute('user_id', null, 'sfGuardSecurityUser');
  }

  public function getProfile()
  {
    if ($this->profile) return $this->profile;

    if (!$this->isAuthenticated() || !($this->profile = Doctrine::getTable('UserProfile')->find($this->getId())))
    {
      $this->profile = new UserProfile();
      $this->profile->setId(0);
    }

    return $this->profile;

  }

  public function getAdminCompanies()
  {
    if(!$this->isAuthenticated()) return array();

   // if($this->getAttribute('companies_admin', false) !== false) return $this->getAttribute('companies_admin');

     $query= Doctrine::getTable('PageAdmin')
                  ->createQuery('p')
                  ->where ( 'p.status = ?', 'approved' );
                    if ($this->getId())
                    {

                          $query->andWhere('p.user_id = ?', $this->getId());

                    }elseif($this->getPageUserId()) {
                          $query->andWhere('p.id = ?', $this->getPageUserId());
                    }

    $pages = $query->execute();
    $ids = array();
    if ($pages){
    foreach($pages as $page)
    {
      $ids[] = $page->getCompanyPage()->getForeignId();
    }
    $this->setAttribute('companies_admin', $ids);
    }
    return $ids;
  }

  public function isAdmin($company_id)
  {
    if($this->isSuperAdmin()) return true;
    return in_array($company_id, $this->getAdminCompanies());
  }

  public function getCountry()
  {
    if($this->country) return $this->country;
    return $this->country = Doctrine::getTable('Country')->find($this->getAttribute('country_id'));
  }

  public function getCity()
  {
    if($this->city) return $this->city;

    if($this->getAttribute('city_id', false))
    {
//       return $this->city = Doctrine::getTable('City')->find($this->getAttribute('city_id'));
		return $this->city = Doctrine::getTable('City')
						->createQuery('c')
						->innerJoin('c.County co')
						->innerJoin('co.Country')
						->where('c.id = ?',$this->getAttribute('city_id'))
						->fetchOne();
    }

    return $this->city = Doctrine::getTable('City')
                      ->createQuery('c')
                      ->innerJoin('c.County co')
                      ->innerJoin('co.Country')
                      ->where('co.country_id = ?', $this->getAttribute('country_id',1))
                      ->orderBy('c.is_default DESC')
                      ->limit(1)
                      ->fetchOne();
  }
  
  public function setCity($city)
  {
  	if ($city && $city instanceof City) {
  		$this->city = $city;
  		$this->setAttribute('city_id', $city->getId());
  	}
  }

/** setCounty() getCounty **/
  public function getCounty()
  {
  	if($this->county) return $this->county;

  	if($this->getAttribute('county_id', false))
  	{
  		return $this->county = Doctrine::getTable('County')->find($this->getAttribute('county_id'));
  	}
  	
  	return $this->county = Doctrine::getTable('County')
  						->createQuery('co')
  						->select('co.*')
  						->innerJoin('co.City c')
  						->where('co.country_id = ?', $this->getAttribute('country_id',1))
  						->orderBy('c.is_default DESC')
  						->limit(1)
  						->fetchOne();
  }
  
  public function setCounty($county) {
  	if ($county && $county instanceof County) {
  		$this->county = $county;
  		$this->setAttribute('county_id', $county->getId());
  	}
  }
/**  **/
  
  public function getFlashKey()
  {
    $request = sfContext::getInstance()->getRequest();
    return 'referer_'.$request->getParameter('module').'_'.$request->getParameter('action');
  }

  public function setReferer($referer)
  {
    if(!$referer) $referer = '@homepage';

    $key = $this->getFlashKey();

    if (!$this->hasAttribute($key))
    {
      $this->setAttribute($key, $referer);
    }
  }

  public function getReferer($default)
  {
    $request = sfContext::getInstance()->getRequest();
    if(!$default) $default = $request->getReferer();
    if(!$default) $default = '@homepage';

    $key = $this->getFlashKey();

    $referer = $this->getAttribute($key, $default);
    $this->getAttributeHolder()->remove($key);

    return $referer;
  }

  public function setLoginReferer($referer)
  {
    if(!$referer) $referer = '@homepage';

    if (!$this->hasAttribute('referer_login'))
    {
      $this->setAttribute('referer_login', $referer);
    }
  }

  public function getLoginReferer($default = null)
  {
    $request = sfContext::getInstance()->getRequest();
    if(!$default) $default = $request->getReferer();
    if(!$default) $default = '@homepage';

    $referer = $this->getAttribute('referer_login', $default);
    $this->getAttributeHolder()->remove('referer_login');

    return $referer;
  }

    public function isGetlokalAdmin()
    {
        $powerUserList = sfConfig::get('app_getlokal_power_user', array());
        return $this->isAuthenticated() && in_array($this->getId(), $powerUserList);
    }

    public function isGetlokalLocalAdmin($company_country_slug)
    {
    	$local_power_users = sfConfig::get('app_getlokal_local_power_user_'.$company_country_slug, array());
    	return $this->isAuthenticated() && in_array($this->getId(), $local_power_users);
    }
    public function getPageAdminUser()
    {
        $this->user = null;
        if ($id = $this->getAttribute('admin_id', null, 'pageAdminSecurityUser')) {
            $this->user = Doctrine::getTable('PageAdmin')->findOneById($id);

            if (!$this->user) {
                // the user does not exist anymore in the database
                $this->signOutPageAdmin();
                throw new sfException('The user does not exist anymore in the database.');
            }
        }

        return $this->user;
    }

    public function getPageUserId() {
        return $this->getAttribute('admin_id', null, 'pageAdminSecurityUser');
    }

  public function signInPageAdmin($pageuser, $remember = false, $con = null)
  {
    // signin
    $this->getAttributeHolder()->removeNamespace('sfGuardSecurityUser');
    $this->user = null;
    $this->setAttribute('admin_id', $pageuser->getId(), 'pageAdminSecurityUser');
    $this->setAuthenticated(true);
    $this->clearCredentials();
    $pageuser->setLastLogin(date('Y-m-d H:i:s'));
    $pageuser->save($con);
    if ($remember)
    {
      $expiration_age = sfConfig::get('app_admins_remember_key_expiration_age', 15 * 24 * 3600);

      // remove old keys
      Doctrine_Core::getTable('AdminRememberKey')->createQuery()
        ->delete()
        ->where('created_at < ?', date('Y-m-d H:i:s', time() - $expiration_age))
        ->execute();

      // remove other keys from this user
      Doctrine_Core::getTable('AdminRememberKey')->createQuery()
        ->delete()
        ->where('page_admin_id = ?', $pageuser->getId())
        ->execute();

      // generate new keys
      $key = $this->generateRandomKey();

      // save key
      $rk = new AdminRememberKey();
      $rk->setRememberKey($key);
      $rk->setPageAdmin($pageuser);
      $rk->setIpAddress($_SERVER['REMOTE_ADDR']);
      $rk->save($con);

      // make key as a cookie
      $remember_cookie = sfConfig::get('app_admins_remember_cookie_name', 'paRemember');
      sfContext::getInstance()->getResponse()->setCookie($remember_cookie, $key, time() + $expiration_age);
    }
  }

  public function signOutPageAdmin()
  {
    $this->getAttributeHolder()->removeNamespace('pageAdminSecurityUser');
    $this->user = null;
    $this->clearCredentials();
    $this->setAuthenticated(false);
    $admin_expiration_age = sfConfig::get('app_admins_remember_key_expiration_age', 15 * 24 * 3600);
    $admin_remember_cookie = sfConfig::get('app_admins_remember_cookie_name', 'paRemember');
    sfContext::getInstance()->getResponse()->setCookie($admin_remember_cookie, '', time() - $admin_expiration_age);

    if ($this->getId())
    {
    $this->user=$this->getGuardUser();
    if ($this->user){
    $this->setAuthenticated(true);
    $this->clearCredentials();
    $this->user->setLastLogin(date('Y-m-d H:i:s'));
    $this->user->save();
    }
    }
  }

  public function getGuardUser()
  {
    if ($this->user && $admin_id = $this->getAttribute('admin_id', null, 'pageAdminSecurityUser'))
    {
     $admin = Doctrine_Core::getTable('PageAdmin')->find($admin_id);
     $this->user = $admin->getUserProfile()->getsfGuardUser();
     $this->setAuthenticated(true);
     $this->setAttribute('user_id', $this->user->getId(), 'sfGuardSecurityUser');
    }elseif (!$this->user && $id = $this->getAttribute('user_id', null, 'sfGuardSecurityUser'))
    {

      $this->user = Doctrine_Core::getTable('sfGuardUser')->find($id);

      if (!$this->user)
      {
        // the user does not exist anymore in the database
        $this->signOut();

        throw new sfException('The user does not exist anymore in the database.');
      }

    }


    return $this->user;
  }

    // Set first name for user
    public function getSpecialFirstName($isPageAdmin = false)
    {
        $realName = '';

        if ($isPageAdmin) {
            $realName = $this->getPageAdminUser()->getUsername();
        }
        else {
            $realName = $this->getGuardUser()->getUserProfile()->getFirstName();
        }

        if ($this->getCountry()->getSlug() == 'sr') {
            if (!$isPageAdmin) {
                $name = Doctrine::getTable('SerbianNames')
                    ->createQuery('sn')
                    ->where('name = ?', $this->getGuardUser()->getUserProfile()->getFirstName())
                    ->fetchOne();
            }
            else {
                $name = Doctrine::getTable('SerbianNames')
                    ->createQuery ( 'sn' )
                    ->where('name = ?', $this->getPageAdminUser()->getUsername())
                    ->fetchOne();
            }

            if ($name) {
                $realName = $name->getSuffix();
            }
        }

        return $realName;
    }
    
    public function getDomain($culture = null)
    {
        $tld = array('' => 'com', 'ro' => 'ro', 'bg' => 'com', 'mk' => 'mk', 'en' => 'com', 'sr' => 'rs', 'fi' => 'fi', 'pt' => 'pt', 'hu' => 'hu');
        if (is_null($culture)) {
          $culture = $this->getCountry()->getSlug();
        }
        if(isset($tld[$culture])) {
            return $tld[$culture];
        }
        else {
            return false;
        }
    }
}
