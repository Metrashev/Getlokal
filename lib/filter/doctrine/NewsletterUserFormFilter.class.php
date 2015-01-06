<?php

/**
 * NewsletterUser filter form.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class NewsletterUserFormFilter extends BaseNewsletterUserFormFilter
{
	
  public function configure()
  {
  	$this->useFields(array('newsletter_id', 'is_active'));
  	$this->setWidget ( 'id', new sfWidgetFormFilterInput ( array ('with_empty' => false ) ) );
		$this->setValidator ( 'id', new sfValidatorSchemaFilter ( 'text', new sfValidatorNumber ( array ('required' => false ) ) ) );
		
		$this->widgetSchema ['email_address'] = new sfWidgetFormFilterInput ( array ('with_empty' => true ) );
		$this->setValidator ( 'email_address', new sfValidatorPass ( array ('required' => false ) ) );
		
		$this->widgetSchema ['first_name'] = new sfWidgetFormFilterInput ( array ('with_empty' => true ) );
		$this->setValidator ( 'first_name', new sfValidatorPass ( array ('required' => false ) ) );
		
		$this->widgetSchema ['last_name'] = new sfWidgetFormFilterInput ( array ('with_empty' => true ) );
		$this->setValidator ( 'last_name', new sfValidatorPass ( array ('required' => false ) ) );
		
		
		$this->widgetSchema ['country'] = new sfWidgetFormDoctrineChoice(array('model'=>'Country', 'add_empty'=>true));
		$this->setValidator ( 'country', new sfValidatorDoctrineChoice( array ('required' => false, 'model'=>'Country' ) ) );
		
		$this->widgetSchema['user_city'] = new sfWidgetFormDoctrineJQueryAutocompleter(array(
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
			'user_city',
			new sfValidatorDoctrineChoice(array(
					'required' => false,
					'model' => 'City'
			)
			));
  }
public function addEmailAddressColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'NewsletterUser' )->applyEmailAddressFilter ( $query, $value );
		}
	}
	public function addFirstNameColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'NewsletterUser' )->applyFirstNameFilter ( $query, $value );
		}
	}
	public function addLastNameColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'NewsletterUser' )->applyLastNameFilter ( $query, $value );
		}
	}	
	
	
public function addCountryColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'NewsletterUser' )->applyCountryFilter ( $query, $value );
		}
	}
public function addUserCityColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'NewsletterUser' )->applyUserCityFilter ( $query, $value );
		}
	}
	
public function addIsActiveColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'NewsletterUser' )->applyIsActiveFilter ( $query, $value );
		}
	}
	
	public function getFields() {
		$fields = parent::getFields ();
		$fields ['email_address'] = 'email_address';
		$fields ['first_name'] = 'first_name';
		$fields ['last_name'] = 'last_name';
		$fields ['country'] = 'country';
		$fields ['user_city'] = 'user_city';
		return $fields;
	}
}
