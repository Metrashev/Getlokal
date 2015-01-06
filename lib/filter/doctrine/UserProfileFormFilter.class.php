<?php

/**
 * UserProfile filter form.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class UserProfileFormFilter extends BaseUserProfileFormFilter
{
  public function configure()
  {
  	$this->widgetSchema['city_id'] = new sfWidgetFormFilterInput();
  	$this->validatorSchema['city_id'] = new sfValidatorPass(array('required' => false));
  	
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
  }
}
