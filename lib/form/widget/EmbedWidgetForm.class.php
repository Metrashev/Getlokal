<?php

class EmbedWidgetForm extends sfFormSymfony
{

  public function configure()
  {
    $this->setWidgets(array(
      'background' => new sfWidgetFormSelect(array(
        'choices' => array(
          'white' => __('Light'),
          'black' => __('Dark')
        )
      )),
      'width' => new sfWidgetFormInput(array(
        'type' => 'number',
        'default' => '300',
        'label' => __('Widget Width')
      )),
      'code' => new sfWidgetFormTextarea(array(
        'label' => __('Copy to Clipboard')
      ))
    ));

    if ($this->options['embed'] == 'events') {
      unset($this['width']);
      $this->setWidget('category', new sfWidgetFormSelect(array(
        'multiple' => true,
        'choices' => array_merge(array(
          '' => __('Toate categoriile'),
        ), Event::getEventCategoryChooseList())
      )));
      $this->setWidget('height', new sfWidgetFormInput(array(
        'type' => 'number',
        'default' => '480',
        'label' => __('Widget Height')
      )));

      $this->setWidget('location', new sfWidgetFormInputHidden(array(
        'default' => sfContext::getInstance()->getUser()->getCity()->getId()
      )));
    }
  }

  public function renderPropFields()
  {
    $allowed = array('location');
    $out = '';

    foreach ($this as $name => $field) {
      if (!in_array($name, $allowed) && ($name == 'code' || $field->isHidden()))
      {
        continue;
      }
      if ($field->isHidden()) {
        $out .= $field->render();
      } else {
        $out .= '<div class="input">' . $field->renderRow() . '</div>';
      }
    }

    return $out;
  }

}
