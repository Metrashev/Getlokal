<?php

/**
 * sfGuardUser form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sfGuardUserForm extends PluginsfGuardUserForm {
    public function configure() {
        parent::configure();

        $facebook_user_data = $this->getOption('facebook_user_data', null);

        unset(
            $this['last_login'], $this['created_at'], $this['updated_at'], $this['salt'], $this['username'], $this['algorithm'], $this['is_active'], $this['is_super_admin'], $this['groups_list'], $this['permissions_list']
        );

        $this->widgetSchema->setLabels(
            array(
                'first_name' => 'Name',
                'last_name' => 'Surname',
                'email_address' => 'Email',
                'username' => 'Username')
        );

        $this->widgetSchema['password'] = new sfWidgetFormInputPassword();
        $this->validatorSchema['first_name'] = new sfValidatorString(
            array('max_length' => 20, 'required' => true, 'trim' => true),
            array(
                'required' => 'The field is mandatory',
                'max_length' => 'The field cannot contain more than %max_length% characters.'
        ));

        $this->validatorSchema['last_name'] = new sfValidatorString(
            array('max_length' => 20, 'required' => true, 'trim' => true),
            array(
                'required' => 'The field is mandatory',
                'max_length' => 'The field cannot contain more than %max_length% characters.'
        ));

        $this->validatorSchema['email_address'] = new sfValidatorAnd(array(
                new sfValidatorString(array('required' => true, 'max_length' => 100, 'trim' => true)),
                new sfValidatorEmail(array('trim' => true), array('invalid' => 'Invalid email – your email is not in the correct format'))
            ), array('required' => true), array('required' => 'The field is mandatory')
        );

        $this->validatorSchema['password'] = new sfValidatorString(array('required' => true,
            'min_length' => 6,
            'max_length' => 30, 'trim' => true),
                array(
                    'required' => 'The field is mandatory',
                    'min_length' => 'Your password should be at least %min_length% characters long',
                    'max_length' => 'Your password cannot contain more than %max_length% characters'
                )
        );

        // Facebook user
        if ($facebook_user_data) {
            $this->setDefaults(array(
                'first_name' => $facebook_user_data['first_name'],
                'last_name' => $facebook_user_data['last_name'],
                'email_address' => $facebook_user_data['email'],
            ));

            unset($this['password']);
        }


        $this->validatorSchema->setPostValidator(new sfValidatorAnd(array(
            new sfValidatorDoctrineUnique(array('model' => 'sfGuardUser', 'column' => 'email_address'), array('invalid' => 'This email address has already been registered by another user')),
            new sfValidatorDoctrineUnique(array('model' => 'sfGuardUser', 'column' => 'username'), array('invalid' => 'This username has already been registered by another user'))
        )));

        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('form');
    }
}
