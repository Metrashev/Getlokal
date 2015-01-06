<?php

/**
 * ListsTranslation form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ListsTranslationForm extends BaseListsTranslationForm
{
 public function configure()
  {
  	
	$this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'title'       => new sfWidgetFormInputText(),
      'lang'        => new sfWidgetFormInputHidden(),
	  'description' => new sfWidgetFormTextarea(),
    ));
	
    //$this->widgetSchema['description'] = new sfWidgetFormTextareaTinyMCECustom ( array ('width' => 580, 'height' => 300, 'theme' => 'advanced' ), array ('class' => 'tinyMCE' ) );
    /*
    $this->widgetSchema['description'] =  new sfWidgetFormTextareaTinyMCE(
	  array(
	    'width'=>600,
	    'height'=>100,
	    'config'=>'theme_advanced_disable: "anchor,image,cleanup,help"',
	    'theme'   =>  sfConfig::get('app_tinymce_theme','simple'),
	  ),
	  array(
	    'class'   =>  'tiny_mce'
	  )
	);
*/
	$this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'title'       => new sfValidatorString(array('max_length' => 255,'required' => false, 'min_length'=>2, 'trim' => true ),array('max_length' => 'The field cannot contain more than %max_length% characters.')),
      'description' => new sfValidatorString(array('max_length' => 6000,'required' => false, 'trim' => true)),
      'lang'        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('lang')), 'empty_value' => $this->getObject()->get('lang'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('list_translation[%s]');

    	$this->widgetSchema->setLabels(
			array(
				'title' =>  'List Name',// null, 'profile') .'*',
			    'description' => 'List Description',// null, 'profile') .'*',
			)    );
    
   	$this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}
