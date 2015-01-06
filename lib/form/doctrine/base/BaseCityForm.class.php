<?php

/**
 * City form base class.
 *
 * @method City getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCityForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'slug'             => new sfWidgetFormInputText(),
      'county_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('County'), 'add_empty' => false)),
      'is_default'       => new sfWidgetFormInputCheckbox(),
      'lat'              => new sfWidgetFormInputText(),
      'lng'              => new sfWidgetFormInputText(),
      'slider_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Slider')),
      'mobile_news_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'MobileNews')),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'slug'             => new sfValidatorString(array('max_length' => 255)),
      'county_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('County'))),
      'is_default'       => new sfValidatorBoolean(array('required' => false)),
      'lat'              => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'lng'              => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'slider_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Slider', 'required' => false)),
      'mobile_news_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'MobileNews', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('city[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'City';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['slider_list']))
    {
      $this->setDefault('slider_list', $this->object->Slider->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['mobile_news_list']))
    {
      $this->setDefault('mobile_news_list', $this->object->MobileNews->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveSliderList($con);
    $this->saveMobileNewsList($con);

    parent::doSave($con);
  }

  public function saveSliderList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['slider_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Slider->getPrimaryKeys();
    $values = $this->getValue('slider_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Slider', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Slider', array_values($link));
    }
  }

  public function saveMobileNewsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['mobile_news_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->MobileNews->getPrimaryKeys();
    $values = $this->getValue('mobile_news_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('MobileNews', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('MobileNews', array_values($link));
    }
  }

}
