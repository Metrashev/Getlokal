<?php
/**
 * sfAdminDash base actions.
 *
 * @package    plugins
 * @subpackage sfAdminDash
 * @author     Ivan Tanev aka Crafty_Shadow @ webworld.bg <vankata.t@gmail.com>
 * @version    SVN: $Id: BasesfAdminDashActions.class.php 25203 2009-12-10 16:50:26Z Crafty_Shadow $
 */ 
class BasesfWpAdminActions extends sfActions
{
 
  public function executeLogin(sfWebRequest $request)
  {
    $homepage = sfWpAdmin::getProperty('homepage', '@homepage');
    
    $user = $this->getUser();
    if ($user->isAuthenticated())
    {
      return $this->redirect($homepage);
    }
    
    $login_form_class = sfWpAdmin::getProperty('login_form_class', 'sfGuardFormSignin');

    $this->form = new $login_form_class();

    if ($request->isMethod('post'))
    {
        $this->form->bind($request->getParameter('signin'));
        if ($this->form->isValid())
        {
            $values = $this->form->getValues();

            //Changed 16.12.2013 - backend login by domain and permission
            $user_country_id = $values['user']->getUserProfile()->getCountryId();
            $domain = sfContext::getInstance()->getRequest()->getHost();
            $domain_array = sfConfig::get('app_domain_slugs');

            $found_flag = false;

            foreach($domain_array as $dom){
                if(strstr($domain, $dom) !== false){

                    $getlokalPartner = 'GETLOKAL_'.strtoupper($dom);
                    $reflectionPartnerClass = new ReflectionClass('getlokalPartner');
                    $country_id = $reflectionPartnerClass->getConstant($getlokalPartner);

                    $found_flag = true;
                    break;
                }
            }
            if($found_flag === false  && strstr($domain, 'com') || strstr($domain, 'my')){
                $dom ='bg';
                $country_id = 1;
            }

            $has_dom_premission =false;
            $permission_names =array();
            $group_names = array();

            if ( $values['user'] instanceOf sfGuardUser ){
                foreach ( $values['user']->getGroups() as $group )
                  $group_names[] = $group->name;
                foreach ( $values['user']->getPermissions() as $permission )
                  $permission_names[] = $permission->name;
            }


            foreach($permission_names as $name){
                if(substr(strtolower($name), -2) == sfConfig::get('app_domain_to_culture_'.strtoupper($dom))){
                    $has_dom_premission = true;
                }
            }
            foreach($group_names as $name){
                if(substr(strtolower($name), -2) == sfConfig::get('app_domain_to_culture_'.strtoupper($dom))){
                    $has_dom_premission = true;
                }
            }
            
            if($values['user']->getIsSuperAdmin()===false && empty($permission_names) && empty($group_names)){
                return $this->redirect($homepage);
            }

            if($country_id != $user_country_id && $values['user']->getIsSuperAdmin()===false && $has_dom_premission===false){
                return $this->redirect($homepage);
            }
            if($country_id != $user_country_id && $values['user']->getIsSuperAdmin()===true && $user_country_id!=1 && $has_dom_premission===false){
                return $this->redirect($homepage);
            }

            //END
            
            $this->getUser()->signin($values['user'], array_key_exists('remember', $values) ? $values['remember'] : false);

            return $this->redirect($homepage);
        }
    }
    else{
        if ($request->isXmlHttpRequest())
        {
            $this->getResponse()->setHeaderOnly(true);
            $this->getResponse()->setStatusCode(401);

            return sfView::NONE;
        }

        // if we have been forwarded, then the referer is the current URL
        // if not, this is the referer of the current request
        $user->setReferer($this->getContext()->getActionStack()->getSize() > 1 ? $request->getUri() : $request->getReferer());

        $module = sfConfig::get('sf_login_module');
        if ($this->getModuleName() != $module)
        {
            return $this->redirect($module.'/'.sfConfig::get('sf_login_action'));
        }

        $this->getResponse()->setStatusCode(401);
      }

    $this->setLayout(false);
  }
  
  public function executeLogout(sfWebRequest $request)
  {
    $this->getUser()->signOut();

    $this->redirect(sfWpAdmin::getProperty('login_route'));
  }
}