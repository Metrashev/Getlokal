<?php
  class SigninPageAdminForm extends baseForm
  {
    public function configure()
    {
      $this->widgetSchema ['username']= new sfWidgetFormInput();


      $this->validatorSchema ['username']  = new sfValidatorAnd(array(
          new sfValidatorString(
            array('required'=>true,
              'min_length' => 3, 
              'max_length' => 20),
            array('min_length'=> 'Username must contain at least %min_length% characters',
              'max_length' =>'Username cannot contain more than %max_length% characters.'
          )),
          new sfValidatorRegex(
            array('pattern' => '/^[a-zA-Z0-9]([a-zA-Z0-9._-]+)$/'), 
            array('invalid' => 'The username "%value%" contains characters that are not allowed')
          )
        ),
        array('required'=> true),array('required'=>'The field is mandatory'
      ));

      $this->widgetSchema ['password']  = new sfWidgetFormInputPassword();
      $this->validatorSchema ['password']  = new sfValidatorString(
        array(
          'required'=> true,
          'min_length' => 6, 
          'max_length' => 30),
        array(
          'required' => 'The field is mandatory',
          'min_length' =>'Your password should be at least %min_length% characters long',
          'max_length' =>'Your password cannot contain more than %max_length% characters'));
      $company =  (isset($this->options['company']) && $this->options['company'])	? $this->options['company'] : null;
 
      $this->widgetSchema ['remember'] = new sfWidgetFormInputCheckbox();	
      $this->validatorSchema ['remember'] = new sfValidatorPass();
      $this->widgetSchema->setLabel ('remember','Remember me');
      $this->validatorSchema->setPostValidator(new PageAdminUsernameValidator(array('company'=>$company), array('invalid' => 'The username and/or password are invalid or you don\'t have enough credentials')));		
      $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('form');
      $this->widgetSchema->setNameFormat('admin[%s]');
    }

}