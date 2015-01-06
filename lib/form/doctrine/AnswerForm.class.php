<?php

/**
 * Review form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class AnswerForm extends ReviewForm
{
  public function configure()
  {
  $this->useFields(array('text'));
  $this->widgetSchema['text']= new sfWidgetFormTextarea(array(),array('cols'=>45,'rows'=>8));
  $this->widgetSchema->setLabel('text', 'Type an Answer');
		
	
		
		$this->validatorSchema['text'] =
		new sfValidatorString(array ('required' => true, 'min_length' => 1 ,'trim' => true), array(        
		'min_length' =>'The answer must contain at least %min_length% characters',        
	    'required' =>'Type an Answer'));
		$this->widgetSchema->setNameFormat('answer[%s]');
		$this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
  
  }
}
