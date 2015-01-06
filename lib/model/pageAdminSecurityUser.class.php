<?php


class PageAdminSecurityUser extends sfBasicSecurityUser
{
  protected
    $user = null;

  public function initialize(sfEventDispatcher $dispatcher, sfStorage $storage, $options = array())
  {
  	
    parent::initialize($dispatcher, $storage, $options);
     
    if (!$this->isAuthenticated() or  $this->getAttribute('sfGuardSecurityUser'))
    {
      // remove user if timeout
      if ($this->getAttribute('sfGuardSecurityUser'))
      {
      	 $this->getAttributeHolder()->removeNamespace('sfGuardSecurityUser');
      }
     
      $this->getAttributeHolder()->removeNamespace('pageAdminSecurityUser');
      $this->user = null;
    }
    
  }

  public function getReferer($default)
  {
    $referer = $this->getAttribute('referer', $default);
    $this->getAttributeHolder()->remove('referer');

    return $referer ? $referer : $default;
  }

  public function setReferer($referer)
  {
    $this->setAttribute('referer', $referer);
  }

  public function hasCredential($credential, $useAnd = true)
  {
    if (empty($credential))
    {
      return true;
    }

    if (!$this->getPageAdminUser())
    {
      return false;
    }

    if ($this->getPageAdminUser()->getIsSuperAdmin())
    {
      return true;
    }

    return parent::hasCredential($credential, $useAnd);
  }

  public function isSuperAdmin()
  {
    return $this->getPageAdminUser() ? $this->getPageAdminUser()->getIsSuperAdmin() : false;
  }

  public function isAnonymous()
  {
    return !$this->isAuthenticated();
  }

  public function signInPageAdmin($user, $remember = false, $con = null)
  {
    // signin
    
    $this->setAttribute('admin_id', $user->getPageUserId(), 'pageAdminSecurityUser');
    $this->setAuthenticated(true);
    $this->clearCredentials();
    $this->addCredentials($user->getPermissionNames());

  }

  protected function generateRandomKey($len = 20)
  {
    $string = '';
    $pool   = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    for ($i = 1; $i <= $len; $i++)
    {
      $string .= substr($pool, rand(0, 61), 1);
    }

    return md5($string);
  }

  public function signOut()
  {
  	 $this->getAttributeHolder()->removeNamespace('pageAdminSecurityUser');
    $this->user = null;
    $this->clearCredentials();
    $this->setAuthenticated(false);
    $expiration_age = sfConfig::get('app_admins_remember_key_expiration_age', 15 * 24 * 3600);
    $remember_cookie = sfConfig::get('app_admins_remember_cookie_name', 'paRemember');
    sfContext::getInstance()->getResponse()->setCookie($remember_cookie, '', time() - $expiration_age);
  }

  public function getPageAdminUser()
  {
    if (!$this->user && $id = $this->getAttribute('admin_id', null, 'PageAdminSecurityUser'))
    {
      $this->user = Doctrine::getTable('PageAdmin')->findOneById($id);
    

      if (!$this->user)
      {
        // the user does not exist anymore in the database
        $this->signOut();

        throw new sfException('The user does not exist anymore in the database.');
      }
    }

    return $this->user;
  }

  // add some proxy method to the sfGuardUser instance

  public function __toString()
  {
    return $this->getPageAdminUser()->__toString();
  }

  public function getUsername()
  {
    return $this->getPageAdminUser()->getUsername();
  }
 

  public function setPassword($password, $con = null)
  {
    $this->getPageAdminUser()->setPassword($password);
    $this->getPageAdminUser()->save($con);
  }

  public function checkPassword($password)
  {
    return $this->getPageAdminUser()->checkPassword($password);
  }
/*
  public function hasGroup($name)
  {
    return $this->getPageAdminUser() ? $this->getPageAdminUser()->hasGroup($name) : false;
  }

  public function getGroups()
  {
    return $this->getPageAdminUser() ? $this->getPageAdminUser()->getGroups() : array();
  }

  public function getGroupNames()
  {
    return $this->getPageAdminUser() ? $this->getPageAdminUser()->getGroupNames() : array();
  }

  public function hasPermission($name)
  {
    return $this->getPageAdminUser() ? $this->getPageAdminUser()->hasPermission($name) : false;
  }

  public function getPermissions()
  {
    return $this->getPageAdminUser()->getPermissions();
  }

  public function getPermissionNames()
  {
    return $this->getPageAdminUser() ? $this->getPageAdminUser()->getPermissionNames() : array();
  }

  public function getAllPermissions()
  {
    return $this->getAdminUser() ? $this->getAdminUser()->getAllPermissions() : array();
  }

  public function getAllPermissionNames()
  {
    return $this->getPageAdminUser() ? $this->getPageAdminUser()->getAllPermissionNames() : array();
  }

  public function getProfile()
  {
    return $this->getPageAdminUser() ? $this->getPageAdminUser()->getProfile() : null;
  }

  public function addGroupByName($name, $con = null)
  {
    return $this->getAdminUser()->addGroupByName($name, $con);
  }

  public function addPermissionByName($name, $con = null)
  {
    return $this->getPageAdminUser()->addPermissionByName($name, $con);
  }
  */
public function getPermissions()
  {
    return $this->getPageAdminUser() ? $this->getPageAdminUser()->getPermissions() : array();
  }
/*public function addPermission($name, $con = null)
  {
    return $this->getGuardUser()->addPermissionByName($name, $con);
  }*/
}