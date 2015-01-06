<?php 

/**
 * Adds datepicker class to inputs and cleans the value to be remove time values
 */
class sfWidgetFormDatepicker extends sfWidgetFormInput 
{

  public function configure($options = array(), $attributes = array())
  {
    $this->addOption('date_format', 'd.m.Y');

    if (!isset($attributes['class'])) {
      $attributes['class'] = 'datepicker';
    }

    parent::configure($options, $attributes);
  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    return parent::render($name, $this->clean($value), $attributes, $errors);
  }

  protected function clean($value)
  {
    if ($value) {
      return date($this->getOption('date_format'), strtotime($value));
    }
    return $value;
  }

}
