<?php

/**
 * Report form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ReportForm extends BaseReportForm
{
  public static function Offences($i18n) { 
	
  	
  	return array(
	    1 => $i18n->__('Illegal',null,'user'),
	    2 => $i18n->__('Offensive',null,'user'),
	    3 => $i18n->__('Copyright',null,'user'),
	    4 => $i18n->__('Incorrect',null,'user'),
	    5 => $i18n->__('Other',null,'user')
 	 );
  }
  public function configure()
  {
  	$i18n = sfContext::getInstance()->getI18N();
    unset(
      $this['id'],
      $this['user_id'],
      $this['object_id'],
      $this['status'],
      $this['created_at'],
      $this['updated_at']
    );
    
    $this->widgetSchema['offence'] = new sfWidgetFormChoice(array(
      'choices' => array('' => $i18n->__('Select...',null,'contact')) + self::Offences($i18n),
    ));
    $this->widgetSchema['email'] = new sfWidgetFormInputText();
    $this->widgetSchema['name'] = new sfWidgetFormInputText();
    
    $this->validatorSchema['offence'] = new sfValidatorChoice(
    	array('choices' => array_keys(self::Offences($i18n))),
    	array('required' => 'Abuse type is required.')
    );

    $this->setValidator ( 'email', new sfValidatorAnd ( array (new sfValidatorString ( array ('required' => true, 'max_length' => 255, 'trim' => true  ) ), new sfValidatorEmail ( array ('trim' => true ), array ('invalid' => 'Invalid email – your email is not in the correct format' ) ) ), array ('required' => true ), array ('required' => 'E-mail is required.' ) ) );

    $this->validatorSchema['name'] = new sfValidatorString(
    					array('max_length' => 255, 'required' => true),
    					array('required' => 'Your name is required.')
    					);
    
    $this->widgetSchema->setLabels(array(
			'offence' => $i18n->__('Report content as',null,'report'),
    		'email' => $i18n->__('Your e-mail:',null,'report'),
    		'name' => $i18n->__('Your name:',null,'report'),
    		'body' => $i18n->__('Your message:',null,'report'),
		));
  $this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
  }
}