<?php

/**
 * UserProfile filter form.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class backendAddPlaceGameFilter extends UserProfileFormFilter
{
  public function configure()
  {
   $this->useFields(array('city_id', 'birthdate','gender','created_at'));
    	$this->setWidget ( 'id', new sfWidgetFormFilterInput ( array ('with_empty' => false ) ) );
		$this->setValidator ( 'id', new sfValidatorSchemaFilter ( 'text', new sfValidatorNumber ( array ('required' => false ) ) ) );
		
		
		
    $this->widgetSchema['last_name']      = new sfWidgetFormFilterInput();
    $this->widgetSchema['first_name']     = new sfWidgetFormFilterInput();
    $this->widgetSchema['email_address']  = new sfWidgetFormFilterInput();
    
    $this->validatorSchema['last_name']     = new sfValidatorPass(array('required' => false));
    $this->validatorSchema['first_name']    = new sfValidatorPass(array('required' => false));
    $this->validatorSchema['email_address'] = new sfValidatorPass(array('required' => false));
    
    $this->widgetSchema->moveField('email_address', sfWidgetFormSchema::FIRST);
    $this->widgetSchema->moveField('last_name', sfWidgetFormSchema::FIRST);
    $this->widgetSchema->moveField('first_name', sfWidgetFormSchema::FIRST);
  
    $this->widgetSchema['is_active']  =  new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no')));
    $this->validatorSchema['is_active']   = new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0)));
    
    $this->widgetSchema [ 'status'] = new sfWidgetFormChoice(array('choices' => array( 
		 '' => 'choose...' , 		
		 1 => 'Only RU',
		 2 => 'Only RUPA',
		 3 => 'Only APPROVED RUPA'
		 )));
       
	   
	    $this->setValidator ( 'status', new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 2, 3))));

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
	    
	    $this->widgetSchema ['company_created_at' ]  = new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDateTime(), 'to_date' => new sfWidgetFormDateTime(), 'with_empty' => false));
		$this->setValidator('company_created_at' , new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d h:i:s')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d h:i:s')))));
    
	
    $this->widgetSchema->moveField('email_address', sfWidgetFormSchema::FIRST);
    $this->widgetSchema->moveField('last_name', sfWidgetFormSchema::FIRST);
    $this->widgetSchema->moveField('first_name', sfWidgetFormSchema::FIRST);
    $this->widgetSchema->moveField('id', sfWidgetFormSchema::FIRST);
    $this->widgetSchema->moveField('is_active', sfWidgetFormSchema::FIRST);
  
  }
  
 public function addEmailAddressColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'UserProfile' )->applyEmailAddressFilter ( $query, $value );
		}
	}
	public function addFirstNameColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'UserProfile' )->applyFirstNameFilter ( $query, $value );
		}
	}
	public function addLastNameColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'UserProfile' )->applyLastNameFilter ( $query, $value );
		}
	}
	
public function addStatusColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'UserProfile' )->applyStatusFilter ( $query, $value );
		}
	}
	 


public function addIsActiveColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'UserProfile' )->applyIsActiveFilter ( $query, $value );
		}
	}
	
public function addCompanyCreatedAtColumnQuery($query, $field, $value) {
	
			Doctrine::getTable ( 'UserProfile' )->applyCompanyCreatedAtFilter ( $query, $value );
	
	}
	
	public function getFields() {
		$fields = parent::getFields ();
		$fields ['username'] = 'username';
		$fields ['first_name'] = 'first_name';
		$fields ['last_name'] = 'last_name';
		$fields ['is_active'] = 'is_active';
		$fields ['company_created_at'] = 'company_created_at';
		return $fields;
	}
}
