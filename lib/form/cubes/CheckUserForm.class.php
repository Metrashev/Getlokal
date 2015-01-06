<?php
class CheckUserForm extends sfForm {
	
	public function configure() {
		
		$this->setWidget ( 'email', new sfWidgetFormInput () );
		$this->validatorSchema['email']  =  new sfValidatorAnd(array(
        new sfValidatorString(array('required'=>true,'max_length' => 120, 'trim' => true )),
        new sfValidatorEmail(array('trim' => true),array('invalid'=>'Invalid email – your email is not in the correct format'))
      ),array('required'=> true),array('required'=>'The field is mandatory'));
		$this->widgetSchema->setLabel ( 'email', 'Email' );
		$this->widgetSchema->setNameFormat ( 'user[%s]' );
		$this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
	
	}
    public function getAllErrors() {
		$errors = array ();
		$errors ['user'] = '';
		foreach ( $this as $form_field ) {
			if ($form_field->hasError ()) {
				$err_obj = $form_field->getError ();
				if ($err_obj instanceof sfValidatorError) {
					
					$errors ['user'] .= $err_obj;
				
				} elseif ($err_obj instanceof sfValidatorErrorSchema) {
					
					foreach ( $err_obj->getErrors () as $err ) {
						$errors [$form_field->getName ()] = $err->getMessage ();
					}
				}
			}
		}
		
		// global err
		foreach ( $this->getGlobalErrors () as $validator_err ) {
			$errors [] = $validator_err->getMessage ();
		}
		return $errors;
	}
}