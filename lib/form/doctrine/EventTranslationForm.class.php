<?php

/**
 * EventTranslation form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EventTranslationForm extends BaseEventTranslationForm
{
  public function configure()
  {
  	
	$this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'title'       => new sfWidgetFormInputText(),
      'lang'        => new sfWidgetFormInputHidden(),
    ));
	
    
    $this->widgetSchema['description'] = new sfWidgetFormTextareaTinyMCECustom ( array ('width' => 1000, 'height' => 300, 'theme' => 'advanced' ), array ('class' => 'tinyMCE' ) );
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
      'title'       => new sfValidatorString(array('max_length' => 255,'required' => false, 'trim' => true)),
      'description' => new sfValidatorString(array('max_length' => 10000,'required' => false, 'trim' => true)),
      'lang'        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('lang')), 'empty_value' => $this->getObject()->get('lang'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('event_translation[%s]');

    	$this->widgetSchema->setLabels(
			array(
				'title' =>  'Event Name',// null, 'profile') .'*',
			    'description' => 'Event Description',// null, 'profile') .'*',
			)    );
    
   	$this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}
