<?php

/**
 * sfGuardFormSignin for sfGuardAuth signin action
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardFormSignin.class.php 23536 2009-11-02 21:41:21Z Kris.Wallsmith $
 */
class sfGuardFormSignin extends BasesfGuardFormSignin
{
  /**
   * @see sfForm
   */
  public function configure()
  {
  	$this->widgetSchema->setLabels(array(
      'username' => 'E-mail:',
      'password' => 'Password:',
      'remember' => 'Remember me'
    ));
    
     $this->setValidators(array(
      'username' => new sfValidatorEmail(array('trim' => true), array('invalid' => 'Invalid email – your email is not in the correct format', 'required' => 'Email is required')),
      'password' => new sfValidatorString(array('trim' => true), array('required' =>  'Password is mandatory')),
      'remember' => new sfValidatorPass(),
     
    ));
     $this->validatorSchema->setPostValidator(new sfGuardValidatorUser());
     $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('form');
  }
  
public function getAllErrors() {
		$errors = array ();
		$errors ['admin'] ='';
		foreach ( $this as $form_field ) {
			if ($form_field->hasError ()) {
				$err_obj = $form_field->getError ();
			if ($err_obj instanceof sfValidatorError){
					
				$errors ['admin'] .= $err_obj;
				
					
			}
				elseif ($err_obj instanceof sfValidatorErrorSchema) {
					
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
