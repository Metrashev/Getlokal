<?php

/**
 * getWeekend form base class.
 *
 * @method getWeekend getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasegetWeekendForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'title'          => new sfWidgetFormInputText(),
      'title_en'       => new sfWidgetFormInputText(),
      'body'           => new sfWidgetFormTextarea(),
      'body_en'        => new sfWidgetFormTextarea(),
      'embed'          => new sfWidgetFormInputText(),
      'aired_on'       => new sfWidgetFormDate(),
      'country_id'     => new sfWidgetFormInputText(),
      'is_active'      => new sfWidgetFormInputCheckbox(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
      'filename'       => new sfWidgetFormInputText(),
      'companies_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Company')),
      'events_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Event')),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'title'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'title_en'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'body'           => new sfValidatorString(array('required' => false)),
      'body_en'        => new sfValidatorString(array('required' => false)),
      'embed'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'aired_on'       => new sfValidatorDate(array('required' => false)),
      'country_id'     => new sfValidatorInteger(array('required' => false)),
      'is_active'      => new sfValidatorBoolean(array('required' => false)),
      'created_at'     => new sfValidatorDateTime(),
      'updated_at'     => new sfValidatorDateTime(),
      'filename'       => new sfValidatorPass(array('required' => false)),
      'companies_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Company', 'required' => false)),
      'events_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Event', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('get_weekend[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'getWeekend';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['companies_list']))
    {
      $this->setDefault('companies_list', $this->object->Companies->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['events_list']))
    {
      $this->setDefault('events_list', $this->object->Events->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveCompaniesList($con);
    $this->saveEventsList($con);

    parent::doSave($con);
  }

  public function saveCompaniesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['companies_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Companies->getPrimaryKeys();
    $values = $this->getValue('companies_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Companies', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Companies', array_values($link));
    }
  }

  public function saveEventsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['events_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Events->getPrimaryKeys();
    $values = $this->getValue('events_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Events', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Events', array_values($link));
    }
  }

}
