<?php

/**
 * BadgeTranslation filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseBadgeTranslationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'             => new sfWidgetFormFilterInput(),
      'description'      => new sfWidgetFormFilterInput(),
      'long_description' => new sfWidgetFormFilterInput(),
      'progress_text'    => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'             => new sfValidatorPass(array('required' => false)),
      'description'      => new sfValidatorPass(array('required' => false)),
      'long_description' => new sfValidatorPass(array('required' => false)),
      'progress_text'    => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('badge_translation_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'BadgeTranslation';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'name'             => 'Text',
      'description'      => 'Text',
      'long_description' => 'Text',
      'progress_text'    => 'Text',
      'lang'             => 'Text',
    );
  }
}
