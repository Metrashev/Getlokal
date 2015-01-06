<?php

/**
 * CategoryArticle form base class.
 *
 * @method CategoryArticle getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCategoryArticleForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'status'              => new sfWidgetFormChoice(array('choices' => array('approved' => 'approved', 'pending' => 'pending', 'rejected' => 'rejected'))),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
      'country_list'        => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Country')),
      'classification_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Classification')),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'status'              => new sfValidatorChoice(array('choices' => array(0 => 'approved', 1 => 'pending', 2 => 'rejected'), 'required' => false)),
      'created_at'          => new sfValidatorDateTime(),
      'updated_at'          => new sfValidatorDateTime(),
      'country_list'        => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Country', 'required' => false)),
      'classification_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Classification', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('category_article[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CategoryArticle';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['country_list']))
    {
      $this->setDefault('country_list', $this->object->Country->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['classification_list']))
    {
      $this->setDefault('classification_list', $this->object->Classification->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveCountryList($con);
    $this->saveClassificationList($con);

    parent::doSave($con);
  }

  public function saveCountryList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['country_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Country->getPrimaryKeys();
    $values = $this->getValue('country_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Country', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Country', array_values($link));
    }
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
