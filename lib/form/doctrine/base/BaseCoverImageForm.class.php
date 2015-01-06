<?php

/**
 * CoverImage form base class.
 *
 * @method CoverImage getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCoverImageForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'company_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'add_empty' => true)),
      'user_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'add_empty' => true)),
      'filename'   => new sfWidgetFormInputText(),
      'caption'    => new sfWidgetFormInputText(),
      'status'     => new sfWidgetFormChoice(array('choices' => array('approved' => 'approved', 'rejected' => 'rejected', 'pending' => 'pending', 'mobile_upload' => 'mobile_upload'))),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'company_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Company'), 'required' => false)),
      'user_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'required' => false)),
      'filename'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'caption'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'status'     => new sfValidatorChoice(array('choices' => array(0 => 'approved', 1 => 'rejected', 2 => 'pending', 3 => 'mobile_upload'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cover_image[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CoverImage';
  }

}
