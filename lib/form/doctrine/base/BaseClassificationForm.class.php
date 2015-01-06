<?php

/**
 * Classification form base class.
 *
 * @method Classification getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseClassificationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'external_id'           => new sfWidgetFormInputText(),
      'category_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Category'), 'add_empty' => true)),
      'sector_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('PrimarySector'), 'add_empty' => true)),
      'status'                => new sfWidgetFormChoice(array('choices' => array('pending' => 'pending', 'approved' => 'approved', 'rejected' => 'rejected'))),
      'crm_id'                => new sfWidgetFormInputText(),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
      'category_article_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'CategoryArticle')),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'external_id'           => new sfValidatorString(array('max_length' => 36)),
      'category_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Category'), 'required' => false)),
      'sector_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('PrimarySector'), 'required' => false)),
      'status'                => new sfValidatorChoice(array('choices' => array(0 => 'pending', 1 => 'approved', 2 => 'rejected'), 'required' => false)),
      'crm_id'                => new sfValidatorInteger(array('required' => false)),
      'created_at'            => new sfValidatorDateTime(),
      'updated_at'            => new sfValidatorDateTime(),
      'category_article_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'CategoryArticle', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('classification[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Classification';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['category_article_list']))
    {
      $this->setDefault('category_article_list', $this->object->CategoryArticle->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveCategoryArticleList($con);

    parent::doSave($con);
  }

  public function saveCategoryArticleList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['category_article_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->CategoryArticle->getPrimaryKeys();
    $values = $this->getValue('category_article_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('CategoryArticle', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('CategoryArticle', array_values($link));
    }
  }

}
