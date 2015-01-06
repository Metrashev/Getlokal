<?php
class sfWidgetCaptchaGD extends sfWidgetForm
{
  protected function configure($options = array(), $attributes = array())
  {
  }
  
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $context = sfContext::getInstance();
    $url = $context->getRouting()->generate("sf_captchagd");
    $value = $context->getRequest()->getPostParameter('captcha');
    $attributes = array_merge($attributes, array('class' => 'captcha default-input'));
    
    $captcha_GT = new sfCaptchaGD();
    $context->getUser()->setAttribute("captcha", $captcha_GT->simpleRandString($captcha_GT->getCodeLength(), $captcha_GT->getChars()));
//     var_dump($context->getUser()->getAttribute("captcha",null));die;
    return $this->renderTag('input', array_merge(array('type' => 'text', 'name' => $name, 'value' => $value), $attributes)) . "<a href='' onClick='return false' title='".__("Reload image")."'><img src='$url?".time()."' onClick='this.src=\"$url?r=\" + Math.random() + \"&amp;reload=1\"' border='0' class='captcha' /></a>";
  }
}
