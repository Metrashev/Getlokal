<?php

/**
 * CompanyStats filter form.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CompanyStatsFormFilter extends BaseCompanyStatsFormFilter
{
  public function configure()
  {
  	parent::configure();
  	$this->widgetSchema ['company_id'] = new sfWidgetFormFilterInput ( array ('with_empty' => true ) );
	$this->setValidator ( 'company_id', new sfValidatorPass ( array ('required' => false ) ) );
    
	$this->widgetSchema ['company'] = new sfWidgetFormFilterInput ( array ('with_empty' => true ) );
	$this->setValidator ( 'company', new sfValidatorPass ( array ('required' => false ) ) );

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

	    
	$this->widgetSchema ['action']= new sfWidgetFormChoice(array('choices' => array('' => 'select...', 13 => 'Views in Category', 1 => 'Views in search', 2 => 'Company Page Visits', 3 => 'Clicks to website', 4 => 'Clicks to FBPage', 5 => 'Sent Emails' )));
    $this->setValidator ('action', new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 2,3,4,5,13))));
  
  $this->widgetSchema ['month']= new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(array('format' => '%day%/%month%/%year%')), 'to_date' => new sfWidgetFormDate(array('format' => '%day%/%month%/%year%'))));
    $this->setValidator ('month', new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))));
  }
  
public function addCompanyColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'CompanyStats' )->applyCompanyFilter ( $query, $value );
		}
	}
	

public function addCompanyCityColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'CompanyStats' )->applyCompanyCityFilter ( $query, $value );
		}
	}
public function addActionColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'CompanyStats' )->applyActionFilter ( $query, $value );
		}
	}
public function addCompanyIdColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'CompanyStats' )->applyCompanyIdFilter ( $query, $value );
		}
	}	
public function getFields() {
		$fields = parent::getFields ();	
		$fields ['company'] = 'company';		
		$fields ['country'] = 'country';
		$fields ['company_city'] = 'company_city';
		$fields ['action'] = 'action';
		return $fields;
	}
}
