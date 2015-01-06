<?php

/**
 * CompanyClassification form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CompanyFormClassification extends BaseCompanyClassificationForm {
	public function configure() {
		unset ( $this ['id'], $this ['company_id'] );
		
		$this->widgetSchema ['classification_id'] = new sfWidgetFormDoctrineJQueryAutocompleter ( array ('model' => 'Classification', 'url' => sfContext::getInstance ()->getController ()->genUrl ( array ('module' => 'company', 'action' => 'getClassifiersAutocomplete', 'route' => 'default' ) ), 'config' => ' {
          scrollHeight: 250,
          autoFill: false,
          cacheLength: 1,
          delay: 0,
          max: 10,
          minChars:1
        }' ) );
		$this->validatorSchema ['classification_id'] = new sfValidatorDoctrineChoice ( array ('model' => $this->getRelatedModelName ( 'Classification' ) ), array ('required' => 'The field is mandatory', 'invalid' => 'Invalid Classification' ) );
		
		$this->widgetSchema->setLabels ( array ('classification_id' => 'Classification' ) );
		
		$this->validatorSchema->setOption ( 'allow_extra_fields', true );
		$this->validatorSchema->setOption ( 'filter_extra_fields', false );
		$this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
	}
	
}

