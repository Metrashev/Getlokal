<?php

/**
 * Category form base class.
 *
 * @method Category getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCategoryForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'status'              => new sfWidgetFormChoice(array('choices' => array('approved' => 'approved', 'pending' => 'pending', 'rejected' => 'rejected'))),
      'model_name'          => new sfWidgetFormInputText(),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
      'root_id'             => new sfWidgetFormInputText(),
      'lft'                 => new sfWidgetFormInputText(),
      'rgt'                 => new sfWidgetFormInputText(),
      'level'               => new sfWidgetFormInputText(),
      'classification_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Classification')),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'status'              => new sfValidatorChoice(array('choices' => array(0 => 'approved', 1 => 'pending', 2 => 'rejected'), 'required' => false)),
      'model_name'          => new sfValidatorString(array('max_length' => 60)),
      'created_at'          => new sfValidatorDateTime(),
      'updated_at'          => new sfValidatorDateTime(),
      'root_id'             => new sfValidatorInteger(array('required' => false)),
      'lft'                 => new sfValidatorInteger(array('required' => false)),
      'rgt'                 => new sfValidatorInteger(array('required' => false)),
      'level'               => new sfValidatorInteger(array('required' => false)),
      'classification_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Classification', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('category[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Category';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['classification_list']))
    {
      $this->setDefault('classification_list', $this->object->Classification->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveClassificationList($con);

    parent::doSave($con);
  }

  public function saveClassificationList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['classification_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Classification->getPrimaryKeys();
    $values = $this->getValue('classification_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Classification', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Classification', array_values($link));
    }
  }

}
