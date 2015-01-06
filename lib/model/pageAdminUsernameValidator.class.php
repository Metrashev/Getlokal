<?php

  class PageAdminUsernameValidator extends sfValidatorBase
  {
    public function configure($options = array(), $messages = array())
    {
      $this->addOption('username_field', 'username');
      $this->addOption('password_field', 'password');
      if (isset($options['company'])) $options['company']=null;
      $this->addOption('company', $options['company']);
      $this->addOption('throw_global_error', false);

      $this->setMessage('invalid', 'The username and/or password are invalid');
      parent::configure($options, $messages);
    }

    protected function doClean($values)
    {
      $username = isset($values[$this->getOption('username_field')]) ? $values[$this->getOption('username_field')] : '';
      $password = isset($values[$this->getOption('password_field')]) ? $values[$this->getOption('password_field')] : '';
      $company = $this->getOption('company');


      $query = Doctrine::getTable('PageAdmin')
                ->createQuery('pa')
                ->where('pa.username = ?' ,$username)
                ->addWhere('pa.status = ?' ,'approved');
                
      if($company)
      {
        $query->innerJoin('pa.CompanyPage cp')
              ->addWhere('cp.foreign_id = ? ', $company->getId());
      }
      
      $admin= $query->fetchOne();

      if ($admin)
      {



        if ($admin->checkAdminPassword($password))
        {

          return array_merge($values, array('user' => $admin));

        }

      }


      if ($this->getOption('throw_global_error'))
      {
        throw new sfValidatorError($this, 'invalid');
      }

      throw new sfValidatorErrorSchema($this, array($this->getOption('username_field') => new sfValidatorError($this, 'invalid')));
    }
}