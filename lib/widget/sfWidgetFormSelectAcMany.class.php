<?php

class sfWidgetFormSelectAcMany extends sfWidgetFormSelectMany
{

  // Symfony is retarded
  protected $__choices = null;

  protected function configure($options = array(), $attributes = array())
  {
    $this->addRequiredOption('url');

    if (isset($options['choices']) && $options['choices'] instanceof Doctrine_Collection)
    {
      $choices = array();
      foreach ($options['choices'] as $c)
      {
        $choices[$c->getId()] = (string) $c;
      }
    }

    parent::configure($options, $attributes);

    $this->__choices = $choices;
    $this->setOption('choices', $choices);
    $this->setOption('translate_choices', false);
  }

  public function getChoices()
  {
    return $this->__choices;
  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $ac_input = $this->renderTag('input', array(
      'data-ac-for' => $this->generateId($name),
      'data-url' => $this->getOption('url'),
    ));
    $removeLink = ' <a href="#" class="ac-remove">Remove selected</a>';

    return $ac_input . parent::render($name, $value, $attributes, $errors) . $removeLink;
  }

  public function getJavascripts()
  {
    return array('/js/widget.ac.js');
  }

}
