<?php

/**
 * ArticleImage form base class.
 *
 * @method ArticleImage getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseArticleImageForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'article_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Article'), 'add_empty' => true)),
      'user_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'add_empty' => true)),
      'filename'   => new sfWidgetFormInputText(),
      'descrption' => new sfWidgetFormInputText(),
      'source'     => new sfWidgetFormInputText(),
      'code'       => new sfWidgetFormInputText(),
      'rank'       => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'article_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Article'), 'required' => false)),
      'user_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'required' => false)),
      'filename'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'descrption' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'source'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'code'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'rank'       => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('article_image[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ArticleImage';
  }

}
