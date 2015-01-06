<?php

/**
 * Report form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CompanyMobileForm extends CompanyForm {

	public function configure() {
		$this->useFields(array(
			'title',
			'phone',
			'classification_id'
		));

		$this->widgetSchema['address'] = new sfWidgetFormInput();

		$this->validatorSchema['address'] = new sfValidatorString(array('
			max_length' => 255,
			'min_length' => 2,
			'required' => true,
			'trim' => true
		), array(
			'required' => 'The field is mandatory',
			'max_length' => 'The field cannot contain more than %max_length% characters.'
		));

		$this->widgetSchema['location'] = new sfWidgetFormInput();
		$this->validatorSchema['location'] = new sfValidatorString(array(
			'max_length' => 255,
			'min_length' => 2,
			'required' => true,
			'trim' => true
		), array(
			'required' => 'City is mandatory',
			'max_length' => 'The field cannot contain more than %max_length% characters.'
		));

		$this->validatorSchema->setOption('allow_extra_fields', true);
		$this->validatorSchema->setOption('filter_extra_fields', false);

		$this->widgetSchema->getFormFormatter()->setTranslationCatalogue('form');
    }

}
