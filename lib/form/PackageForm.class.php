<?php
class PackageForm extends BaseForm {
	public function configure() {
		sfContext::getInstance ()->getConfiguration ()->loadHelpers ( "Date" );
		$years = range ( date ( 'Y' ) + 5, (date ( 'Y' )- 2) );
		$years_list = array_combine ( $years, $years );
		$culture = sfContext::getInstance ()->getUser ()->getCulture ();
		$this->widgetSchema ['active_from'] = new sfWidgetFormI18nDate ( array ('culture' => $culture, 'month_format' => 'short_name', 'format' => '%day% %month% %year%', 'years' => $years_list ), array () );
		$this->widgetSchema ['active_to'] = new sfWidgetFormI18nDate ( array ('culture' => $culture, 'month_format' => 'short_name', 'format' => '%day% %month% %year%', 'years' => $years_list ), array () );
		$this->widgetSchema ['valid_from'] = new sfWidgetFormI18nDate ( array ('culture' => $culture, 'month_format' => 'short_name', 'format' => '%day% %month% %year%', 'years' => $years_list ), array () );
		$this->widgetSchema ['valid_to'] = new sfWidgetFormI18nDate ( array ('culture' => $culture, 'month_format' => 'short_name', 'format' => '%day% %month% %year%', 'years' => $years_list ), array () );
		$this->widgetSchema->setLabels ( array ('active_from' => 'Package Active From', 'active_to' => 'Package Active To', 'valid_from' => 'Package Valid From', 'valid_to' => 'Package Valid To' )

		 );
		$this->validatorSchema->setOption ( 'allow_extra_fields', true );
		$this->validatorSchema->setOption ( 'filter_extra_fields', false );
		
		$this->widgetSchema->setNameFormat('package[%s]');
		$this->validatorSchema->setPostValidator ( new sfValidatorCallback ( array ('callback' => array ($this, 'postValidateMe' ) ) ) );
	
	}
	
	public function postValidateMe($validator, $values) {
		
		$culture = sfContext::getInstance ()->getUser ()->getCulture ();
		$today = date ( 'Y-m-d' );
		
	
		
		
		//TODO ADD AFTER OLD ORDERS ARE INSERTED
		/* 
      if (strtotime($values ['active_from']) < strtotime($today))
      {
        $error = new sfValidatorError($validator, 'You cannot select a date earlier than today\'s');
        throw new sfValidatorErrorSchema($validator, array('active_from' => $error));
      } 
      if (strtotime($values ['valid_from']) < strtotime($today))
      {
        $error = new sfValidatorError($validator, 'You cannot select a date earlier than today\'s');
        throw new sfValidatorErrorSchema($validator, array('valid_from' => $error));
      }
    
    */
		if (strtotime ( $values ['active_from']  ) > strtotime ( $values ['active_to'])) {
			$error = new sfValidatorError ( $validator, 'The product end date cannot be earlier than the start date' );
			throw new sfValidatorErrorSchema ( $validator, array ('active_from' => $error ) );
		}
		
		if (strtotime (  $values ['valid_from'] ) > strtotime (  $values ['valid_to'])) {
			$error = new sfValidatorError ( $validator, 'The product end date cannot be earlier than the start date' );
			throw new sfValidatorErrorSchema ( $validator, array ('valid_from' => $error ) );
		}
		if (strtotime ( $values ['valid_to'] ) < strtotime ( $values ['active_to'])) {
			$error = new sfValidatorError ( $validator, 'The product valid to date cannot be earlier than the product end date' );
			throw new sfValidatorErrorSchema ( $validator, array ('valid_to' => $error ) );
		}
		
		return $values;
	}
}