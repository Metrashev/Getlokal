<?php

/**
 * Country form base class.
 *
 * @method Country getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCountryForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'name'                  => new sfWidgetFormInputText(),
      'name_en'               => new sfWidgetFormInputText(),
      'slug'                  => new sfWidgetFormInputText(),
      'currency'              => new sfWidgetFormInputText(),
      'category_article_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'CategoryArticle')),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'                  => new sfValidatorString(array('max_length' => 255)),
      'name_en'               => new sfValidatorString(array('max_length' => 255)),
      'slug'                  => new sfValidatorString(array('max_length' => 255)),
      'currency'              => new sfValidatorString(array('max_length' => 3)),
      'category_article_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'CategoryArticle', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('country[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Country';
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
