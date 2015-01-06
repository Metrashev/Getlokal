<?php
/**
 * RegisterForm for signup process and requires
 * sfGuardPlugin
 *
 * @author Rajat Pandit
 */
class UserProfileCrmForm extends UserProfileForm {
	
public function configure() {
        parent::configure();
		$this->useFields ( array ('phone_number',  'city_id','gender') );
		//$this->widgetSchema ['gender'] = new sfWidgetFormChoice ( array ('expanded' => false, 'label' => 'Gender', 'choices' => Social::getI18NChoices ( Social::$sexChoicesWEmpty ) ) );
		//$this->validatorSchema ['gender'] = new sfValidatorChoice ( array ('required' => false, 'choices' => array_keys ( Social::$sexChoices ) ), array ('required' => 'The field is mandatory' ) );
		
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
