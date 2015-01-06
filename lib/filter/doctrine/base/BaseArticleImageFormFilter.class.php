<?php

/**
 * ArticleImage filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseArticleImageFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'article_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Article'), 'add_empty' => true)),
      'user_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'add_empty' => true)),
      'filename'   => new sfWidgetFormFilterInput(),
      'descrption' => new sfWidgetFormFilterInput(),
      'source'     => new sfWidgetFormFilterInput(),
      'code'       => new sfWidgetFormFilterInput(),
      'rank'       => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'article_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Article'), 'column' => 'id')),
      'user_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UserProfile'), 'column' => 'id')),
      'filename'   => new sfValidatorPass(array('required' => false)),
      'descrption' => new sfValidatorPass(array('required' => false)),
      'source'     => new sfValidatorPass(array('required' => false)),
      'code'       => new sfValidatorPass(array('required' => false)),
      'rank'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('article_image_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ArticleImage';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'article_id' => 'ForeignKey',
      'user_id'    => 'ForeignKey',
      'filename'   => 'Text',
      'descrption' => 'Text',
      'source'     => 'Text',
      'code'       => 'Text',
      'rank'       => 'Number',
    );
  }
}
