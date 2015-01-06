<?php

/**
 * Event form base class.
 *
 * @method Event getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseEventForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'start_at'         => new sfWidgetFormDateTime(),
      'end_at'           => new sfWidgetFormDateTime(),
      'start_h'          => new sfWidgetFormTime(),
      'end_h'            => new sfWidgetFormTime(),
      'category_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Category'), 'add_empty' => true)),
      'image_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Image'), 'add_empty' => true)),
      'facebook_id'      => new sfWidgetFormInputText(),
      'info_url'         => new sfWidgetFormInputText(),
      'buy_url'          => new sfWidgetFormInputText(),
      'price'            => new sfWidgetFormInputText(),
      'location_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('City'), 'add_empty' => true)),
      'country_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => true)),
      'user_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'add_empty' => true)),
      'is_active'        => new sfWidgetFormInputCheckbox(),
      'recommend'        => new sfWidgetFormInputText(),
      'recommended_at'   => new sfWidgetFormDateTime(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'get_weekend_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'getWeekend')),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'start_at'         => new sfValidatorDateTime(array('required' => false)),
      'end_at'           => new sfValidatorDateTime(array('required' => false)),
      'start_h'          => new sfValidatorTime(array('required' => false)),
      'end_h'            => new sfValidatorTime(array('required' => false)),
      'category_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Category'), 'required' => false)),
      'image_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Image'), 'required' => false)),
      'facebook_id'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'info_url'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'buy_url'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'price'            => new sfValidatorInteger(array('required' => false)),
      'location_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('City'), 'required' => false)),
      'country_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'required' => false)),
      'user_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'required' => false)),
      'is_active'        => new sfValidatorBoolean(array('required' => false)),
      'recommend'        => new sfValidatorInteger(),
      'recommended_at'   => new sfValidatorDateTime(array('required' => false)),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
      'get_weekend_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'getWeekend', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('event[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Event';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['get_weekend_list']))
    {
      $this->setDefault('get_weekend_list', $this->object->getWeekend->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->savegetWeekendList($con);

    parent::doSave($con);
  }

  public function savegetWeekendList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['get_weekend_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->getWeekend->getPrimaryKeys();
    $values = $this->getValue('get_weekend_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('getWeekend', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('getWeekend', array_values($link));
    }
  }

}
