<?php

  /**
  * Review form.
  *
  * @package    getLokal
  * @subpackage form
  * @author     Get Lokal
  * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
  */
  class ReviewFBForm extends ReviewForm
  {
    public function configure()
    {
      parent::configure();
      $i18n    = sfContext::getInstance()->getI18N(); 
      $this->useFields(array('rating', 'text'));

     
 /*     $this->validatorSchema['text'] = new sfValidatorAnd(array(
        new sfValidatorString(array(
            'required' => true,
            'trim' => true
          ), array(        
            'min_length' =>$i18n->__('The review must contain at least %min_length% characters', null, 'errors')
        )),
        new sfValidatorBlacklist(array(
            'case_sensitive'=> false, 
            'required' => true,
            'forbidden_values' => array('shit', 'fuck', 'лайно','lajno','laino', 'govno', 'mother fucker','fucker', 'еба', 'ебати')
          ), array(
            'forbidden' => $i18n->__('The review contains forbidden words', null, 'errors')
        ))
      ), array(
        'required' =>true
      ), array(
        'required' =>$i18n->__('Type Review', null, 'errors')
      ));
 */     
      $this->disableLocalCSRFProtection();
      $this->widgetSchema->setNameFormat('review[%s]');
    }
  }
