<?php

class sfBulstatValidator extends sfValidatorBase
{
  private $weights13 = array(
    9  => 2,
    10 => 7,
    11 => 3,
    12 => 5
  );
  
  private $weights13Additional = array(
    9  => 4,
    10 => 9,
    11 => 5,
    12 => 7
  );
  
  private $validLengths = array(
    9 => true,
    13 => true,
  );
  
    protected function doClean($value)
  {
    $result = true;
    
    try
    {
      // validate length
      $length = strlen($value);
      
      if (!isset($this->validLengths[$length]))
      {
      	 throw new sfValidatorError($this, 'invalid', array('value' => $value, 'invalid' => $this->getOption('invalid')));
       
      }
      
      // validate checksum
      $checksum9 = substr($value, 8, 1);
      $sum = 0;
        
      for ($i = 0; $i < 8; $i++)
      {
        $sum += substr($value, $i, 1) * ($i + 1);
      }
      
      $validChecksum9 = $sum % 11;
      
      if ($validChecksum9 == 10)
      {
        $sum = 0;
        
        for ($i = 0; $i < 8; $i++)
        {
          $sum += substr($value, $i, 1) * ($i + 3);
        }
        
        $validChecksum9 = $sum % 11;
      }
      
      if ($validChecksum9 == 10)
      {
        $validChecksum9 = 0;
      }
      
      if ($checksum9 != $validChecksum9)
      {
       // throw new Exception(sprintf('Invalid checksum - expected "' . $checksum9 . '", got "' . $validChecksum9 . '"'));
       throw new sfValidatorError($this, 'invalid', array('value' => $value, 'invalid' => $this->getOption('invalid')));
      }
      
      if (13 == $length)
      {
        $checksum13 = substr($value, 12, 1);
        $sum = 0;
          
        for ($i = 8; $i < 12; $i++)
        {
          echo substr($value, $i, 1) . "\n";
          $sum += substr($value, $i, 1) * $this->weights13[$i];
        }
        
        $validChecksum13 = $sum % 11;
        
        if ($validChecksum13 == 10)
        {
          $sum = 0;
          
          for ($i = 0; $i < 9; $i++)
          {
            $sum += substr($value, $i, 1) * $this->weights13Additional[$i];
          }
          
          $validChecksum13 = $sum % 11;
        }
        
        if ($checksum13 != $validChecksum13)
        {
          // throw new Exception(sprintf('Invalid checksum 13'));
           throw new sfValidatorError($this, 'invalid', array('value' => $value, 'invalid' => $this->getOption('invalid')));
        }
      }
    }
    catch (Exception $e)
    {
      $result = false;
      //$error = $this->getParameter('invalid_error');
       throw new sfValidatorError($this, 'invalid', array('value' => $value, 'invalid' => $this->getOption('invalid')));
    }
    
    return $value;
  }
  
 
public function configure($options = array(), $messages = array())
  {
  	$i18n  = sfContext::getInstance()->getI18N(); 
    $this->addMessage('invalid', $i18n->__('Invalid Bulstat', null,'company')); 

    $this->addOption('invalid');
   
}
  
}
