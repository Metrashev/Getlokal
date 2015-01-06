<?php
class VipForm extends AdCompanyForm {
	public function configure() {
	sfContext::getInstance()->getConfiguration()->loadHelpers("Date");
      $years = range ( date ( 'Y' )+1, date ( 'Y') );
      $years_list = array_combine ( $years, $years );
		$this->useFields ( array ('start_date' ) );
		$this->widgetSchema ['start_date'] = new sfWidgetFormI18nDate ( array ('culture' => sfContext::getInstance ()->getUser ()->getCulture (), 'month_format' => 'short_name', 'format' => '%day% %month% %year%', 'years' => $years_list ), array () );
		$this->widgetSchema ['start_date']->setLabel('VIP Position Start Date');
		$this->validatorSchema->setPostValidator ( new sfValidatorCallback ( array ('callback' => array ($this, 'postValidateMe' ) ) ) );
	    $this->widgetSchema->setNameFormat('vip'.$this->getObject()->getId() .'[%s]');
	    $this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' ); 
	}

	
public function postValidateMe($validator, $values) {
    $today = date('Y-m-d');
	if (strtotime($values["start_date"]) < strtotime($today))
  
		{
			$error = new sfValidatorError ( $validator, 'You cannot select a date earlier than today\'s' );
			throw new sfValidatorErrorSchema ( $validator, array ('start_date' => $error ) );
		}
 if (strtotime($values["start_date"]) > strtotime($this->getObject()->getActiveTo()))
  
		{
			$error = new sfValidatorError ( $validator, 'Тhe end date of your VIP cannot be later than the end date of your advert' );
			throw new sfValidatorErrorSchema ( $validator, array ('start_date' => $error ) );
		}
if (strtotime($values["start_date"]) < strtotime($this->getObject()->getActiveFrom()))
  
		{
			$error = new sfValidatorError ( $validator, 'Тhe end date of your VIP cannot be later than the end date of your advert' );
			throw new sfValidatorErrorSchema ( $validator, array ('start_date' => $error ) );
		}
		return $values;
	
}

}