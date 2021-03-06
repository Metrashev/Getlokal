<?php
// auto-generated by sfViewConfigHandler
// date: 2014/12/02 09:41:29
$response = $this->context->getResponse();

if ($this->actionName.$this->viewName == 'indexSuccess')
{
  $templateName = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_template', $this->actionName);
  $this->setTemplate($templateName.$this->viewName.$this->getExtension());
}
else if ($this->actionName.$this->viewName == 'categorySuccess')
{
  $templateName = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_template', $this->actionName);
  $this->setTemplate($templateName.$this->viewName.$this->getExtension());
}
else if ($this->actionName.$this->viewName == 'businessSuccess')
{
  $templateName = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_template', $this->actionName);
  $this->setTemplate($templateName.$this->viewName.$this->getExtension());
}
else if ($this->actionName.$this->viewName == 'error404Success')
{
  $templateName = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_template', $this->actionName);
  $this->setTemplate($templateName.$this->viewName.$this->getExtension());
}
else
{
  $templateName = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_template', $this->actionName);
  $this->setTemplate($templateName.$this->viewName.$this->getExtension());
}

if ($templateName.$this->viewName == 'indexSuccess')
{
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
  $response->addStylesheet('carousel.css', '', array ());
}
else if ($templateName.$this->viewName == 'categorySuccess')
{
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
  $response->addStylesheet('carousel.css', '', array ());
}
else if ($templateName.$this->viewName == 'businessSuccess')
{
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
  $response->addStylesheet('business.css', '', array ());
}
else if ($templateName.$this->viewName == 'error404Success')
{
  if (null !== $layout = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_layout'))
  {
    $this->setDecoratorTemplate(false === $layout ? false : $layout.$this->getExtension());
  }
  else
  {
    $this->setDecoratorTemplate('' == '' ? false : ''.$this->getExtension());
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
}
else
{
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
}

