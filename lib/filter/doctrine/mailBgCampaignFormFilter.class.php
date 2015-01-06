<?php

/**
 * mailBgCampaign filter form.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mailBgCampaignFormFilter extends BasemailBgCampaignFormFilter {
	public function configure() {
		parent::configure ();
		unset ( $this ['company_id'] );
		$this->widgetSchema ['city_id'] = new sfWidgetFormDoctrineJQueryAutocompleter ( array ('model' => 'City', 'method' => 'getLocation', 'url' => sfContext::getInstance ()->getController ()->genUrl ( array ('module' => 'company', 'action' => 'getCitiesAutocomplete', 'route' => 'default' ) ), 'config' => ' {
          scrollHeight: 250,
          autoFill: false,
          cacheLength: 1,
          delay: 1,
          max: 10,
          minChars:0
       }' ) );
		
		$this->widgetSchema ['company'] = new sfWidgetFormFilterInput ( array ('with_empty' => true ) );
		$this->setValidator ( 'company', new sfValidatorPass ( array ('required' => false ) ) );
		$this->widgetSchema ['company_status'] = new sfWidgetFormChoice ( array ('choices' => array ('' => 'choose...', CompanyTable::VISIBLE => CompanyTable::VISIBLE . ' visible (approved)', CompanyTable::INVISIBLE => CompanyTable::INVISIBLE . ' invisible (dnd crm)', CompanyTable::INVISIBLE_NO_CLASS => CompanyTable::INVISIBLE_NO_CLASS . ' invisible(NO class)', CompanyTable::NEW_PENDING => CompanyTable::NEW_PENDING . ' New (Pending)', CompanyTable::REJECTED => CompanyTable::REJECTED . ' Rejected' ) ) );
		
		$this->setValidator ( 'company_status', new sfValidatorChoice ( array ('required' => false, 'choices' => array ('', 1, 0, 2, 3, 4 ) ) ) );
		
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
			'company_city',
			new sfValidatorDoctrineChoice(array(
					'required' => false,
					'model' => 'City'
			)
			));
		
	}
	public function addCompanyColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'mailBgCampaign' )->applyCompanyFilter ( $query, $value );
		}
	}
	public function addCompanyStatusColumnQuery($query, $field, $value) {
		if ($value != null) {
			Doctrine::getTable ( 'mailBgCampaign' )->applyCompanyStatusFilter ( $query, $value );
		}
	}
	public function getFields() {		
		$fields ['company'] = 'company';
		$fields ['company_status'] = 'company_status';
		return $fields;
	}
}
