<?php

class sfWidgetFormTextareaCustom extends sfWidgetFormTextarea
{

  protected function configure($options = array(), $attributes = array())
  {
     $this->setAttribute('maxlength', 150);
     $this->setAttribute('placeholder','150 characters max');
  }
}

  