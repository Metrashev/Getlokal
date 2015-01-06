<?php

/**
 * UserProfile form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class backendUserForm extends UserProfileForm
{
  public function configure()
  {
    parent::configure();
    
    $domain = sfContext::getInstance()->getRequest()->getHost();
    $i18n = sfContext::getInstance()->getI18N();
    
    if(!(strstr($domain, '.my')) && !(strstr($domain, '.com'))) {
    	unset($this ['country_id']);
    }
    
    if (strstr($domain, '.my') || strstr($domain, '.com')) {
    
    	$this->widgetSchema['country_id'] = new sfWidgetFormDoctrineJQueryAutocompleter(array(
    			'model' => 'Country',
    			'url' => sfContext::getInstance()->getController()->genUrl(array('module' => 'user_profile', 'action' => 'getCountriesAutocomplete', 'route' => 'default')),
    			'config' => ' {
        			scrollHeight: 250,
        			autoFill: false,
        			cacheLength: 1,
        			delay: 1,
        			max: 10,
        			minChars:0
                  }',
    			//'table_method' => 'getCountriesForUserForm',
    			'method' => 'getCountryNameByCulture'
    	));
    
    	/*
    	 $country_id = sfContext::getInstance()->getUser()->getAttribute('country_id', 1); //1
    	$this->setDefault('country_id', $country_id);
    	*/
    
    	$this->validatorSchema ['country_id']->setOption('required', true);
    	$this->validatorSchema ['country_id']->setMessage('required', 'This field is mandatory. Please select your country name from the list.');
    }
    
    $this->widgetSchema['city_id'] = new sfWidgetFormDoctrineJQueryAutocompleter(array(
    		'model' => 'City',
    		'method' => 'getLocation',
    		'url' => sfContext::getInstance()
    		->getRouting()
    		->generate('default', array(
    				'module' => 'user_profile',
    				'action' => 'autocomplete' ) ),
    		'config' => ' {
          		  scrollHeight: 250,
         		  autoFill: false,
          		  cacheLength: 0,
        		  delay: 1,
        		  max: 10,
        		  minChars:0
        		}'
    ));
     
    $this->setValidator(
    		'city_id',
    		new sfValidatorDoctrineChoice(array(
    				'required' => false,
    				'model' => 'City'
    		)
    		));   
    

    $this->embedForm('sfGuardUser', new BasesfGuardUserAdminForm($this->getObject()->getSfGuardUser()));
  }

}
