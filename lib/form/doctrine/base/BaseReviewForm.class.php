<?php

/**
 * Review form base class.
 *
 * @method Review getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseReviewForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'user_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'add_empty' => true)),
      'company_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'add_empty' => true)),
      'text'           => new sfWidgetFormTextarea(),
      'recommend'      => new sfWidgetFormInputText(),
      'rating'         => new sfWidgetFormInputText(),
      'badwords'       => new sfWidgetFormInputCheckbox(),
      'is_published'   => new sfWidgetFormInputCheckbox(),
      'slug'           => new sfWidgetFormInputText(),
      'ip'             => new sfWidgetFormInputText(),
      'promo_source'   => new sfWidgetFormInputText(),
      'parent_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Answer'), 'add_empty' => true)),
      'recommended_at' => new sfWidgetFormDateTime(),
      'referer'        => new sfWidgetFormInputText(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'user_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'required' => false)),
      'company_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'required' => false)),
      'text'           => new sfValidatorString(array('max_length' => 5000)),
      'recommend'      => new sfValidatorInteger(),
      'rating'         => new sfValidatorInteger(),
      'badwords'       => new sfValidatorBoolean(array('required' => false)),
      'is_published'   => new sfValidatorBoolean(array('required' => false)),
      'slug'           => new sfValidatorString(array('max_length' => 255)),
      'ip'             => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'promo_source'   => new sfValidatorInteger(array('required' => false)),
      'parent_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Answer'), 'required' => false)),
      'recommended_at' => new sfValidatorDateTime(array('required' => false)),
      'referer'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'     => new sfValidatorDateTime(),
      'updated_at'     => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('review[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Review';
  }

}
