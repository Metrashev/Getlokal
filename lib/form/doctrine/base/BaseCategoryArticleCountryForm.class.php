<?php

/**
 * CategoryArticleCountry form base class.
 *
 * @method CategoryArticleCountry getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCategoryArticleCountryForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'category_id' => new sfWidgetFormInputHidden(),
      'country_id'  => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'category_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('category_id')), 'empty_value' => $this->getObject()->get('category_id'), 'required' => false)),
      'country_id'  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('country_id')), 'empty_value' => $this->getObject()->get('country_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('category_article_country[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CategoryArticleCountry';
  }

}
