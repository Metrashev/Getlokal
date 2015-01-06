<?php
class userComponents extends sfComponents
{
	public function executeSigninRegister(sfWebRequest $request)
	{
		$this->form = new sfGuardFormSignin();
		$this->formRegister = new OldRegisterForm();
		
		if (!isset($trigger_id)) {
			$trigger_id = null;
		}
		
		if ($this->getUser()->getAttribute('signin')) {
			$this->form->bind($this->getUser()->getAttribute('signin'));
			$this->form->isValid();
			$this->getUser()->getAttributeHolder()->remove('signin');
		}
		
		if ($this->getUser()->getAttribute('register')) {
			$this->formRegister->bind($this->getUser()->getAttribute('register'));
			$this->formRegister->isValid();
			$this->getUser()->getAttributeHolder()->remove('register');
			
			$this->register = true;
		}
		
		if ($this->trigger = $this->getUser()->getAttribute('trigger_id')) {
			$this->getUser()->getAttributeHolder()->remove('trigger_id');
		}
	}
}