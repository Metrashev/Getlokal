<?php

class sfEGNValidator extends sfValidatorBase 
{
  private $weights = array(2,4,8,5,10,9,7,3,6);
  
   protected function doClean($value)
  
  {
    $result = true;
    
    try
    {
      // validate length
      $length = strlen($value);
      if (10 != $length)
      {
        throw new Exception('Invalid length - ' . $length);
      }
      
      // validate date
      $year = substr($value, 0, 2);
      $mon  = substr($value, 2, 2);
      $day  = substr($value, 4, 2);
      
      $validDate = true;
      switch (true)
      {
        case $mon > 40:
          $validDate = checkdate($mon - 40, $day, $year+1900);
          break;
          
        case $mon > 20:
          $validDate = checkdate($mon - 20, $day, $year+1900);
          break;  
          
        default:
          $validDate = checkdate($mon, $day, $year+1900);
          break;  
      }
      
      if (!$validDate)
      {
        throw new Exception('Invalid date');
      }
      
      // validate checksum
      $checksum = substr($value,9,1);
      $egnSum = 0;
      
      for ($i = 0; $i < 9; $i++)
      {
        $egnSum += substr($value, $i, 1) * $this->weights[$i];
      }
      
      $validChecksum = $egnSum % 11;
      if ($validChecksum == 10)
      {
        $validChecksum = 0;
      }
      
      if ($checksum != $validChecksum)
      {
        throw new Exception('Invalid checksum');
      }
    }
    catch (Exception $e)
    {
      $result = false;
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
