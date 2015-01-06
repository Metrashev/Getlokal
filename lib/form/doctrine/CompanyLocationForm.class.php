<?php

/**
 * CompanyLocation form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CompanyLocationForm extends BaseCompanyLocationForm
{
  public function configure()
  {
    unset(
      $this['id'],      
      $this['company_id'],
      $this['user_id'],
      $this['zoom'],
      $this['created_at'],
      $this['updated_at'],
      $this['accuracy'],
      $this['is_active']    
    );
   
    if ($this->getObject()->getCompany())
    {
    $lang_class = getlokalPartner::getLanguageClass($this->getObject()->getCompany()->getCountryId());
    
    }else {
    $lang_class= getlokalPartner::getLanguageClass();
    }
    $class='AddressType'. $lang_class;    
    if ($lang_class == 'Bg' or $lang_class == 'Sr')
    {
    	$this->widgetSchema['location_type'] = new sfWidgetFormChoice(array(
      'choices' => call_user_func(array($class, 'getStreetNeiInstance'),'neighbourhood')
    ));    	
    $this->setDefault('location_type',2);
    }else {
    unset($this['location_type']);
    
    }

    $this->widgetSchema['street_type_id'] = new sfWidgetFormChoice(array(
      'choices' => call_user_func(array($class, 'getStreetNeiInstance'),'street')
    ));
      $this->setDefault('street_type_id',6);
     $this->widgetSchema ['address_info'] = new sfWidgetFormTextarea ( array (), array ('maxlength' => 100 ) );
		$this->widgetSchema ['address_info_en'] = new sfWidgetFormTextarea ( array (), array ('maxlength' => 100 ) );
		
		$this->setValidator ( 'address_info', new sfValidatorString ( array ('required' => false, 'min_length' => 2, 'max_length' => 100, 'trim' => true ), array ('min_length' => 'Description must contain at least %min_length% characters', 'max_length' => 'The description cannot contain more than %max_length% characters.' ) ) );
		$this->setValidator ( 'address_info_en', new sfValidatorString ( array ('required' => false, 'min_length' => 2, 'max_length' => 100, 'trim' => true ), array ('min_length' => 'Description must contain at least %min_length% characters', 'max_length' => 'The description cannot contain more than %max_length% characters.' ) ) );
		
        $this->widgetSchema['sublocation']= new sfWidgetFormInputHidden();
    	$this->widgetSchema['latitude']= new sfWidgetFormInputHidden();
	$this->widgetSchema['longitude']= new sfWidgetFormInputHidden();
        $this->setValidator ('latitude', new sfValidatorString (array ('required' => true ) ) );
        $this->setValidator ( 'longitude', new sfValidatorString (array ('required' => true ) ) );
     
	$this->widgetSchema->setLabels(array(
                'street_type_id' =>'Street',
		'street' =>'', 
		'street_number' => 'Number',       
		'location_type' => 'Neighbourhood',   
		'building_no' =>'Bl.', 
		'entrance' =>  'Ent.', 
		'floor' =>'Fl.', 
		'appartment' =>  'Ap.',
    'address_info' => 'More address info'
    ));
    $this->validatorSchema->setOption ( 'allow_extra_fields', true );
	$this->validatorSchema->setOption ( 'filter_extra_fields', false );
		
    $this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
  }
}
