<?php

/**
 * PageAdmin filter form.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PageAdminFormFilter extends BasePageAdminFormFilter {
	public function configure() {
		
		$this->setWidget ( 'id', new sfWidgetFormFilterInput ( array ('with_empty' => false ) ) );
		$this->setValidator ( 'id', new sfValidatorSchemaFilter ( 'text', new sfValidatorNumber ( array ('required' => false ) ) ) );
		
		$this->widgetSchema ['email_address'] = new sfWidgetFormFilterInput ( array ('with_empty' => true ) );
		$this->setValidator ( 'email_address', new sfValidatorPass ( array ('required' => false ) ) );
		
		$this->widgetSchema ['first_name'] = new sfWidgetFormFilterInput ( array ('with_empty' => true ) );
		$this->setValidator ( 'first_name', new sfValidatorPass ( array ('required' => false ) ) );
		
		$this->widgetSchema ['last_name'] = new sfWidgetFormFilterInput ( array ('with_empty' => true ) );
		$this->setValidator ( 'last_name', new sfValidatorPass ( array ('required' => false ) ) );
		
		$this->widgetSchema ['company'] = new sfWidgetFormFilterInput ( array ('with_empty' => true ) );
		$this->setValidator ( 'company', new sfValidatorPass ( array ('required' => false ) ) );
		
		$this->widgetSchema ['position'] = new sfWidgetFormChoice ( array ('choices' => Social::$positionChoicesWEmpty ) );
		$this->setValidator ( 'position', new sfValidatorChoice ( array ('required' => false, 'choices' => array (0, 1, 2, 3, 4, 5 ) ) ) );
		
		$this->widgetSchema['company_city'] = new sfWidgetFormDoctrineJQueryAutocompleter(array(
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
			'company_city',
			new sfValidatorDoctrineChoice(array(
					'required' => false,
					'model' => 'City'
			)
			));
		

	 $this->widgetSchema [ 'company_status'] = new sfWidgetFormChoice(array('choices' => array( 
		 '' => 'choose...' , 
		 CompanyTable::VISIBLE => CompanyTable::VISIBLE.' visible (approved)',
		 CompanyTable::INVISIBLE => CompanyTable::INVISIBLE.' invisible (dnd crm)',
		 CompanyTable::INVISIBLE_NO_CLASS => CompanyTable::INVISIBLE_NO_CLASS.' invisible(NO class)',
		 CompanyTable::NEW_PENDING => CompanyTable::NEW_PENDING.' New (Pending)', 
		 CompanyTable::REJECTED =>  CompanyTable::REJECTED.' Rejected' )));
       
	   
	    $this->setValidator ( 'company_status', new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0,2,3,4))));
      
	    $this->setValidator ( 'company_city', new sfValidatorDoctrineChoice ( array ('required' => false, 'model' => 'City' ) ) );
	
	}
 
   public function addEmailAddressColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'PageAdmin' )->applyEmailAddressFilter ( $query, $value );
		}
	}
	public function addFirstNameColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'PageAdmin' )->applyFirstNameFilter ( $query, $value );
		}
	}
	public function addLastNameColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'PageAdmin' )->applyLastNameFilter ( $query, $value );
		}
	}
	
	public function addCompanyColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'PageAdmin' )->applyCompanyFilter ( $query, $value );
		}
	}
	public function addPositionColumnQuery($query, $field, $value) {
		if ($value != null && $value != 0) {
			Doctrine::getTable ( 'PageAdmin' )->applyPositionFilter ( $query, $value );
		}
	}

public function addCompanyCityColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'PageAdmin' )->applyCompanyCityFilter ( $query, $value );
		}
	}
public function addCompanyStatusColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'PageAdmin' )->applyCompanyStatusFilter ( $query, $value );
		}
	}
	public function getFields() {
		$fields = parent::getFields ();
		$fields ['username'] = 'username';
		$fields ['first_name'] = 'first_name';
		$fields ['last_name'] = 'last_name';
		$fields ['company'] = 'company';
		$fields ['position'] = 'position';
		$fields ['country'] = 'country';
		$fields ['company_city'] = 'company_city';
		$fields ['company_status'] = 'company_status';
		return $fields;
	}
}
