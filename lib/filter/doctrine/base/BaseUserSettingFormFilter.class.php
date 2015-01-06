<?php

/**
 * UserSetting filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseUserSettingFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'show_profile'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'search_name'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'search_nickname'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'search_email'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'show_age'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'show_gender'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'show_online'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'public_comments'    => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'auto_comments'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'allow_contact'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'allow_localization' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'allow_newsletter'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'allow_b_cmc'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'allow_promo'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'underage'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'show_profile'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'search_name'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'search_nickname'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'search_email'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'show_age'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'show_gender'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'show_online'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'public_comments'    => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'auto_comments'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'allow_contact'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'allow_localization' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'allow_newsletter'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'allow_b_cmc'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'allow_promo'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'underage'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('user_setting_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserSetting';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'show_profile'       => 'Boolean',
      'search_name'        => 'Boolean',
      'search_nickname'    => 'Boolean',
      'search_email'       => 'Boolean',
      'show_age'           => 'Boolean',
      'show_gender'        => 'Boolean',
      'show_online'        => 'Boolean',
      'public_comments'    => 'Boolean',
      'auto_comments'      => 'Boolean',
      'allow_contact'      => 'Boolean',
      'allow_localization' => 'Boolean',
      'allow_newsletter'   => 'Boolean',
      'allow_b_cmc'        => 'Boolean',
      'allow_promo'        => 'Boolean',
      'underage'           => 'Boolean',
    );
  }
}
