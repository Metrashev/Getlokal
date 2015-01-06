<?php

/**
 * Report form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ReportMobileForm extends BaseReportCompanyForm
{
  public static function Offences($i18n) { 
	
  	
  	return array(
	    6 => $i18n->__('place closed',null,'user'),
	    7 => $i18n->__('invalid phone',null,'user'),
	    8 => $i18n->__('bad address ',null,'user'),
	    9 => $i18n->__('bad location',null,'user'),
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
      $this['email'],
      $this['name'],
      $this['created_at'],
      $this['updated_at'],
      $this['type']
    );
    
    $this->widgetSchema['offence'] = new sfWidgetFormChoice(array(
      'choices' => array('' => $i18n->__('Select...',null,'contact')) + self::Offences($i18n),
    ));
   
    
    $this->validatorSchema['offence'] = new sfValidatorChoice(
    	array('choices' => array_keys(self::Offences($i18n))),
    	array('required' => 'Abuse type is required.')
    );
 
    
   
  $this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
  }
}
