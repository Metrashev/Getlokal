<?php

/**
 * MobileNews form base class.
 *
 * @method MobileNews getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMobileNewsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'title'       => new sfWidgetFormInputText(),
      'line1'       => new sfWidgetFormInputText(),
      'line2'       => new sfWidgetFormInputText(),
      'link'        => new sfWidgetFormInputText(),
      'rank'        => new sfWidgetFormInputText(),
      'country_id'  => new sfWidgetFormInputText(),
      'is_active'   => new sfWidgetFormInputCheckbox(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
      'filename'    => new sfWidgetFormInputText(),
      'cities_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'City')),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'title'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'line1'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'line2'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'link'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'rank'        => new sfValidatorInteger(array('required' => false)),
      'country_id'  => new sfValidatorInteger(array('required' => false)),
      'is_active'   => new sfValidatorBoolean(array('required' => false)),
      'created_at'  => new sfValidatorDateTime(),
      'updated_at'  => new sfValidatorDateTime(),
      'filename'    => new sfValidatorPass(array('required' => false)),
      'cities_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'City', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('mobile_news[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'MobileNews';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['cities_list']))
    {
      $this->setDefault('cities_list', $this->object->Cities->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveCitiesList($con);

    parent::doSave($con);
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
