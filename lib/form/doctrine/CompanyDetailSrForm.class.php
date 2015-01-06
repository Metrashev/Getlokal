<?php

/**
 * CompanyDetailSr form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CompanyDetailSrForm extends BaseCompanyDetailSrForm
{
	public function configure()
	{
		unset($this['id'],
			  $this ['company_id'], 
			  $this['internal_id']
			);
		$this->widgetSchema['sr_url'] = new sfWidgetFormInputText();
		$this->validatorSchema ['sr_url'] = new sfValidatorAnd ( array (new sfValidatorString ( array ('required' => false, 'max_length' => 255 ,'trim' => true), array ('max_length' => 'This field cannot contain more than %max_length% characters' ) ), new myValidatorUrl(array('required' => false), array ('invalid' => 'Invalid format. E.g. http://www.yellowpages.rs'  ))), array ('required' => false ) );
		$this->widgetSchema->setLabels ( array ('sr_url' => 'Yellow Pages'));
	}
}
