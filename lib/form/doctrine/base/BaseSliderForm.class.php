<?php

/**
 * Slider form base class.
 *
 * @method Slider getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSliderForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'title'         => new sfWidgetFormInputText(),
      'title_en'      => new sfWidgetFormInputText(),
      'title_ru'      => new sfWidgetFormInputText(),
      'body'          => new sfWidgetFormTextarea(),
      'body_en'       => new sfWidgetFormTextarea(),
      'body_ru'       => new sfWidgetFormTextarea(),
      'link'          => new sfWidgetFormInputText(),
      'link_en'       => new sfWidgetFormInputText(),
      'link_ru'       => new sfWidgetFormInputText(),
      'rank'          => new sfWidgetFormInputText(),
      'country_id'    => new sfWidgetFormInputText(),
      'whole_country' => new sfWidgetFormInputCheckbox(),
      'is_active'     => new sfWidgetFormInputCheckbox(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
      'filename'      => new sfWidgetFormInputText(),
      'sectors_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Sector')),
      'cities_list'   => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'City')),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'title'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'title_en'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'title_ru'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'body'          => new sfValidatorString(array('required' => false)),
      'body_en'       => new sfValidatorString(array('required' => false)),
      'body_ru'       => new sfValidatorString(array('required' => false)),
      'link'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'link_en'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'link_ru'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'rank'          => new sfValidatorInteger(array('required' => false)),
      'country_id'    => new sfValidatorInteger(array('required' => false)),
      'whole_country' => new sfValidatorBoolean(array('required' => false)),
      'is_active'     => new sfValidatorBoolean(array('required' => false)),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
      'filename'      => new sfValidatorPass(array('required' => false)),
      'sectors_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Sector', 'required' => false)),
      'cities_list'   => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'City', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('slider[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Slider';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['sectors_list']))
    {
      $this->setDefault('sectors_list', $this->object->Sectors->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['cities_list']))
    {
      $this->setDefault('cities_list', $this->object->Cities->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveSectorsList($con);
    $this->saveCitiesList($con);

    parent::doSave($con);
  }

  public function saveSectorsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['sectors_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Sectors->getPrimaryKeys();
    $values = $this->getValue('sectors_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Sectors', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Sectors', array_values($link));
    }
  }

  public function saveCitiesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['cities_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Cities->getPrimaryKeys();
    $values = $this->getValue('cities_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Cities', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Cities', array_values($link));
    }
  }

}
