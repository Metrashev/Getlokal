<?php

/**
 * Lists filter form.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ListsFormFilter extends BaseListsFormFilter
{
public function configure()
  {
  	  $this->setWidget ( 'id', new sfWidgetFormFilterInput ( array ('with_empty' => false ) ) );
	  $this->setValidator ( 'id', new sfValidatorSchemaFilter ( 'text', new sfValidatorNumber ( array ('required' => false ) ) ) );
	
	  $this->widgetSchema ['title'] = new sfWidgetFormFilterInput ( array ('with_empty' => true ) );
	  $this->setValidator ( 'title', new sfValidatorPass ( array ('required' => false ) ) );
	
	  $this->widgetSchema ['first_name'] = new sfWidgetFormFilterInput ( array ('with_empty' => true ) );
	  $this->setValidator ( 'first_name', new sfValidatorPass ( array ('required' => false ) ) );
		  
	  $this->widgetSchema ['last_name'] = new sfWidgetFormFilterInput ( array ('with_empty' => true ) );
	  $this->setValidator ( 'last_name', new sfValidatorPass ( array ('required' => false ) ) );

	  $this->widgetSchema ['company'] = new sfWidgetFormFilterInput ( array ('with_empty' => true ) );
	  $this->setValidator ( 'company', new sfValidatorPass ( array ('required' => false ) ) );
		
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
  
  	public function addTitleColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'Lists' )->applyTitleFilter ( $query, $value );
		}
  	}

  	public function addFirstNameColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'Lists' )->applyFirstNameFilter ( $query, $value );
		}
  	}
  
  	public function addLastNameColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'Lists' )->applyLastNameFilter ( $query, $value );
		}
  	}
  
  	public function addCompanyColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'Lists' )->applyCompanyFilter ( $query, $value );
		}
  	}

  	public function addCityIdColumnQuery($query, $field, $value) {//print_r($value);exit();
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'Lists' )->applyCityFilter ( $query, $value );
		}
  	}	
}
