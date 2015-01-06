<?php

/**
 * Message form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class MessageForm extends BaseMessageForm
{
 public function configure()
  {
    $this->useFields(array(
      'page_id', 
      'body'
    ));
    
    $this->widgetSchema['page_id'] = new sfWidgetFormInputHidden();
    $this->validatorSchema['body'] = new sfValidatorString(array('max_length' => 1000, 'required' => true), array('required'=>'The field is mandatory'));
  		$this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );	
  }
}
