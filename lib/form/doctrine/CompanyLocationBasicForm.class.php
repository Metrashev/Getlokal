<?php

/**
 * CompanyLocation form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CompanyLocationBasicForm extends CompanyLocationForm
{
  public function configure()
  {
  $this->useFields(array('address_info','latitude','longitude','location_type','street_type_id' ,'building_no', 'street','street_number','sublocation'));
    
    $this->widgetSchema ['address_info'] = new sfWidgetFormTextarea ( array (), array ('maxlength' => 100 ) );
		
     
    	$this->setValidator ( 'address_info', new sfValidatorString ( array ('required' => true, 'min_length' => 2, 'max_length' => 120, 'trim' => true ), array ('min_length' => 'The field must contain at least %min_length% characters', 'max_length' => 'The field cannot contain more than %max_length% characters.', 'required' => 'The field is mandatory') ) );	
    
  
    	$this->widgetSchema['latitude']= new sfWidgetFormInputHidden();
		$this->widgetSchema['longitude']= new sfWidgetFormInputHidden();
        $this->widgetSchema['location_type']= new sfWidgetFormInputHidden();
		$this->widgetSchema['street_type_id']= new sfWidgetFormInputHidden();		
		$this->widgetSchema['building_no']= new sfWidgetFormInputHidden();
		$this->widgetSchema['street']= new sfWidgetFormInputHidden();
		$this->widgetSchema['street_number']= new sfWidgetFormInputHidden();
	    $this->widgetSchema['neighbourhood']= new sfWidgetFormInputHidden();
	    $this->widgetSchema['sublocation']= new sfWidgetFormInputHidden();
     $this->widgetSchema->setLabel ('address_info', 'Address');
	    $this->validatorSchema->setOption ( 'allow_extra_fields', true );
	$this->validatorSchema->setOption ( 'filter_extra_fields', false );
		
    $this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
  }
}
