<?php
// auto-generated by sfViewConfigHandler
// date: 2014/12/02 10:53:53
$response = $this->context->getResponse();


  $templateName = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_template', $this->actionName);
  $this->setTemplate($templateName.$this->viewName.$this->getExtension());



  if (null !== $layout = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_layout'))
  {
    $this->setDecoratorTemplate(false === $layout ? false : $layout.$this->getExtension());
  }
  else if (null === $this->getDecoratorTemplate() && !$this->context->getRequest()->isXmlHttpRequest())
  {
    $this->setDecoratorTemplate('' == 'layout' ? false : 'layout'.$this->getExtension());
  }
  $response->addHttpMeta('content-type', 'text/html', false);

  $response->addStylesheet('font-awesome.min.css', '', array ());
  $response->addStylesheet('bootstrap.css', '', array ());
  $response->addStylesheet('style.css', '', array ());
  $response->addStylesheet('settings.css', '', array ());
  $response->addStylesheet('style1.css', '', array ());
  $response->addStylesheet('/images/favicon.ico', '', array ());
  $response->addStylesheet('prettyPhoto', '', array ());
  $response->addStylesheet('component', '', array ());


