<?php

/**
 * promo actions.
 *
 * @package    getLokal
 * @subpackage promo
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class promoActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  	if (getlokalPartner::getInstanceDomain() == getlokalPartner::GETLOKAL_BG)
  	{
  		$this->setTemplate('reviewManiaX3');
  	}
  	elseif (getlokalPartner::getInstanceDomain() == getlokalPartner::GETLOKAL_MK)
  	{
  		$this->setTemplate('reviewPlaceMk');
  	}
  	elseif (getlokalPartner::getInstanceDomain() == getlokalPartner::GETLOKAL_RO)
  	{
  		$this->redirect('@home?city='.$this->getUser()->getCity()->getSlug());
  	}
  	else{
  		$this->redirect('@home?city='.$this->getUser()->getCity()->getSlug());
  	}
  }
  
public function executeAddPlace(sfWebRequest $request)
  {
  
     $this->redirect('@home?city='.$this->getUser()->getCity()->getSlug());
     $this->user= $this->getUser()->getGuardUser();    
   
  
       $this->form = new AddPlaceForm();
        if ($request->isMethod ( 'post' )) {
        sfContext::getInstance()->getConfiguration()->loadHelpers('Frontend');
        
        $params = $request->getParameter ( $this->form->getName () );
        $params ['title'] = format_company_title ( $params ['title']);
        
        if (! isset ( $params ['title_en'] ) or ($params ['title_en'] == '')) {
          $partner_class = getlokalPartner::getLanguageClass();
          $params ['title_en'] = format_company_title (call_user_func(array('Transliterate'.$partner_class, 'toLatin'),$params ['title']));
        }
        else 
        {
          $params ['title_en'] = format_company_title ($params ['title_en']);	
        }
        $cityname = $params['city'];
        $city = Doctrine::getTable('City')->createQuery('l')->where('l.name = ? OR l.slug= ?', array($cityname,$cityname))
        ->fetchOne();
        if($city)
        {
        	if($city->getId() !=$params['city_id'])
        	{
        	$params['city_id']=$city->getId();
        	}
        }
        
        
        if (!preg_match ( '/^[0-9+]([0-9.-]+)$/', $params['more'] )) {
        if (stripos($params['more'], 'http://') !== 0) {
                $params['more'] = 'http://' . $params['more'];
              }
		}
       
        $this->form->bind ( $params );

        if ($this->form->isValid ()) 
        {
          $company = $this->form->save();
        
           if ($this->user){
            $this->redirect ( 'promo/place' );
           }else {
           	 //$this->getUser ()->setFlash ( 'notice', 'to win the prize please register' );
           	 $this->getUser()->setAttribute('newcompany', $company->getId());   
           	 $this->getUser ()->setAttribute ( 'redirect_after_login', 'promo/place'  );        	 
           	 $this->redirect ( '@sf_guard_signin?addplace=1' );
           	 
           }
          
        }else {
        	$this->lat = $params['company_location']['latitude'];
        	$this->long = $params['company_location']['longitude'];
        }
        

      }
  }
  public function executePlace(sfWebRequest $request)
  {
  	
  }
  public function executeReviewPlaceOld(sfWebRequest $request)
  {
  	 
  }
  
  public function executeReviewMania(sfWebRequest $request)
  {
  	 
  }
  
  public function executeReviewManiaX3(sfWebRequest $request)
  {
  	 
  }
  
  public function executeAmbassador(sfWebRequest $request)
  {
  	 
  }
  
  public function executeReviewPlace(sfWebRequest $request)
  {

  	if (getlokalPartner::getInstanceDomain() == getlokalPartner::GETLOKAL_MK)
  	{
  		$this->setTemplate('reviewPlaceMk');
  	}
  }
public function executeAddPlaceGame(sfWebRequest $request)
  {
     
     $this->user= $this->getUser()->getGuardUser();    
   
  
       $this->form = new AddPlaceForm();
        if ($request->isMethod ( 'post' )) {
        sfContext::getInstance()->getConfiguration()->loadHelpers('Frontend');
        
        $params = $request->getParameter ( $this->form->getName () );
        $params ['title'] = format_company_title ( $params ['title']);
        
        if (! isset ( $params ['title_en'] ) or ($params ['title_en'] == '')) {
          $partner_class = getlokalPartner::getLanguageClass();
          $params ['title_en'] = format_company_title (call_user_func(array('Transliterate'.$partner_class, 'toLatin'),$params ['title']));
        }
        else 
        {
          $params ['title_en'] = format_company_title ($params ['title_en']);	
        }
        $cityname = $params['city'];
        $city = Doctrine::getTable('City')->createQuery('l')->where('l.name = ? OR l.slug= ?', array($cityname,$cityname))
        ->fetchOne();
        if($city)
        {
        	if($city->getId() !=$params['city_id'])
        	{
        	$params['city_id']=$city->getId();
        	}
        }
        
        
        if (!preg_match ( '/^[0-9+]([0-9.-]+)$/', $params['more'] )) {
        if (stripos($params['more'], 'http://') !== 0) {
                $params['more'] = 'http://' . $params['more'];
              }
		}
       
        $this->form->bind ( $params );

        if ($this->form->isValid ()) 
        {
          $company = $this->form->save();
        
           if ($this->user){
            $this->redirect ( 'promo/place' );
           }else {
           	 //$this->getUser ()->setFlash ( 'notice', 'to win the prize please register' );
           	 $this->getUser()->setAttribute('newcompany', $company->getId());   
           	 $this->getUser ()->setAttribute ( 'redirect_after_login', 'promo/place'  );        	 
           	 $this->redirect ( '@sf_guard_signin?addplace=1' );
           	 
           }
          
        }else {
        	$this->lat = $params['company_location']['latitude'];
        	$this->long = $params['company_location']['longitude'];
        }
        

      }
      $this->setTemplate('addPlace');
  }
}
