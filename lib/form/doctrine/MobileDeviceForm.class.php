<?php

/**
 * MobileDevice form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class MobileDeviceForm extends BaseMobileDeviceForm
{
  public function configure()
  {
  	parent::configure();
  	
  	unset($this['device_uid']);
  	unset($this['device_token']);
  	unset($this['created_at']);
  	unset($this['updated_at']);
  	
  	$temp_choice = $this->getOption('ver_choices');
  	if (is_array($temp_choice)) {
  		$ver_choices = array_merge(array('' => 'All'), $temp_choice);
  	}
  	else {
  		$ver_choices = array('' => 'All');
  	}
  	
  	$temp_choice = $this->getOption('locale_choices');
  	if (is_array($temp_choice)) {
  		$loc_choices = array_merge(array('' => 'All'), $temp_choice);
  	}
  	else {
  		$loc_choices = array('' => 'All');
  	}
  	
  	$domain = sfContext::getInstance()->getRequest()->getHost();
  	$i18n = sfContext::getInstance()->getI18N();
  	
  	if(!(strstr($domain, '.my')) && !(strstr($domain, '.com'))) {
  		unset($this ['country_id']);
  		unset($this ['country_gps']);
  	}
  	
  	if (strstr($domain, '.my') || strstr($domain, '.com')) {
  	
  		$this->widgetSchema['message'] = new sfWidgetFormTextarea(array(),array('cols'=>42,'rows'=>6));
  		$this->validatorSchema['message'] = new sfValidatorString(
  				array('max_length'=>255, 'min_length'=>2, 'required' => true, 'trim' => true ),
  				array(
  						'required' => 'The field is mandatory',
  						'max_length' => 'The field cannot contain more than %max_length% characters.'
  				));
  		
  		$this->widgetSchema ['device_os'] = new sfWidgetFormChoice(array('choices' => array('' => 'All', 'iOS' => 'iOS', 'Android' => 'Android')));
  		$this->validatorSchema ['device_os'] = new sfValidatorChoice(array('choices' => array(0 => 'All', 1 => 'iOS', 2 => 'Android'), 'required' => false));
  		
  		$this->widgetSchema ['app_version'] = new sfWidgetFormChoice(array('choices' => $ver_choices));
  		$this->validatorSchema ['app_version'] = new sfValidatorChoice(array('choices' => $ver_choices, 'required' => false));
  		
  		$this->widgetSchema ['locale'] = new sfWidgetFormChoice(array('choices' => $loc_choices));
  		$this->validatorSchema ['locale'] = new sfValidatorChoice(array('choices' => $loc_choices, 'required' => false));
  		
  		$this->widgetSchema['country_id'] = new sfWidgetFormDoctrineJQueryAutocompleter(array(
  				'model' => 'Country',
  				'url' => sfContext::getInstance()->getController()->genUrl(array('module' => 'push_notification', 'action' => 'getCountriesAutocomplete', 'route' => 'default')),
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
  	
  		$this->validatorSchema ['country_id']->setOption('required', false);
  		
  		$this->widgetSchema['country_gps'] = new sfWidgetFormDoctrineJQueryAutocompleter(array(
  				'model' => 'Country',
  				'url' => sfContext::getInstance()->getController()->genUrl(array('module' => 'push_notification', 'action' => 'getCountriesAutocomplete', 'route' => 'default')),
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
  		 
  		$this->validatorSchema ['country_gps']->setOption('required', false);  		
  	}
  	
  	$this->widgetSchema['city_id'] = new sfWidgetFormDoctrineJQueryAutocompleter(array(
  			'model' => 'City',
  			'method' => 'getLocation',
  			'url' => sfContext::getInstance()
  			->getRouting()
  			->generate('default', array(
  					'module' => 'push_notification',
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
  	
  	$this->widgetSchema->setLabels ( array (
  			'message'		=> 'Message/Notification',
  			'device_os'		=> 'Device OS',
  			'app_version'	=> 'Application version',
  			'country_id'    => 'Country from user_profile',
  			'city_id'       => 'City from user_profile',
  			'country_gps'   => 'Country from GPS location',
  			)
  	);
  	 
  }
}
