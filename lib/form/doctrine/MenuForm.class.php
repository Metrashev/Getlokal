<?php

/**
 * Menu form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class MenuForm extends BaseMenuForm
{ 
  public function configure()
  {
  	$this->widgetSchema['file'] = new sfWidgetFormInputFile(array('label' => 'Upload a new PDF file'));
  	$i18n = sfContext::getInstance()->getI18N();	

  	$this->validatorSchema['file'] = new sfValidatorFile(array(
	  		'required' => true,
	  		'mime_types' => array('application/pdf')
	  ),
  	  array(
        'required'    => 'The field is mandatory',
        'mime_types'  => 'The file you submitted is not in a valid format. Please upload a PFD file',
      )
  	);
	  $this->validatorSchema->setOption('allow_extra_fields', true);
	  // $this->widgetSchema->setNameFormat('menu[%s]');
	  // $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
	 
	$this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
  }
}