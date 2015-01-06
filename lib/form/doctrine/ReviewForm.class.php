<?php

  /**
  * Review form.
  *
  * @package    getLokal
  * @subpackage form
  * @author     Get Lokal
  * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
  */
  class ReviewForm extends BaseReviewForm
  {
    public function configure()
    {
      parent::configure();
      $i18n    = sfContext::getInstance()->getI18N(); 
      $this->useFields(array('rating', 'text'));

      $this->widgetSchema['rating'] = new sfWidgetFormSelectRadio(array('choices' => array('1'=>'','2'=>'','3'=>'','4'=>'','5'=>'')));
      
      $this->widgetSchema->setLabel('rating', $i18n->__('Rate', null, 'reviews'));
      
      $this->validatorSchema['rating'] = new sfValidatorChoice(
        array('choices' =>array( 1, 2, 3, 4, 5 ), 'required' => true),
        array(
          'required' => $i18n->__('Please rate this company', null, 'form'),
          'invalid' =>  $i18n->__('Please rate this company', null, 'form')
        )
      );

      $this->widgetSchema['text']= new sfWidgetFormTextarea(array(),array('cols'=>45,'rows'=>8));

      $this->validatorSchema['text'] = new sfValidatorAnd(array(
        new sfValidatorString(array(
            'required' => true, 
            'min_length' => 5 ,
            'max_length' => 1000,
            'trim' => true
          ), array(        
            'min_length' =>$i18n->__('The review must contain at least %min_length% characters', null, 'errors'),
            'max_length' =>$i18n->__('The review cannot contain more than %max_length% characters. Shorten your review.', null, 'errors')
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

//	  $this->disableLocalCSRFProtection();
      $this->widgetSchema->setNameFormat('review[%s]');
    }

  }
