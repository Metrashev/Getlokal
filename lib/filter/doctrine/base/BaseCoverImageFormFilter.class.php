<?php

/**
 * CoverImage filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCoverImageFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'company_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'add_empty' => true)),
      'user_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'add_empty' => true)),
      'filename'   => new sfWidgetFormFilterInput(),
      'caption'    => new sfWidgetFormFilterInput(),
      'status'     => new sfWidgetFormChoice(array('choices' => array('' => '', 'approved' => 'approved', 'rejected' => 'rejected', 'pending' => 'pending', 'mobile_upload' => 'mobile_upload'))),
    ));

    $this->setValidators(array(
      'company_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Company'), 'column' => 'id')),
      'user_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UserProfile'), 'column' => 'id')),
      'filename'   => new sfValidatorPass(array('required' => false)),
      'caption'    => new sfValidatorPass(array('required' => false)),
      'status'     => new sfValidatorChoice(array('required' => false, 'choices' => array('approved' => 'approved', 'rejected' => 'rejected', 'pending' => 'pending', 'mobile_upload' => 'mobile_upload'))),
    ));

    $this->widgetSchema->setNameFormat('cover_image_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CoverImage';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'company_id' => 'ForeignKey',
      'user_id'    => 'ForeignKey',
      'filename'   => 'Text',
      'caption'    => 'Text',
      'status'     => 'Enum',
    );
  }
}
