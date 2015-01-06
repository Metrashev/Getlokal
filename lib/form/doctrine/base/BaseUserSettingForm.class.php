<?php

/**
 * UserSetting form base class.
 *
 * @method UserSetting getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUserSettingForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'show_profile'       => new sfWidgetFormInputCheckbox(),
      'search_name'        => new sfWidgetFormInputCheckbox(),
      'search_nickname'    => new sfWidgetFormInputCheckbox(),
      'search_email'       => new sfWidgetFormInputCheckbox(),
      'show_age'           => new sfWidgetFormInputCheckbox(),
      'show_gender'        => new sfWidgetFormInputCheckbox(),
      'show_online'        => new sfWidgetFormInputCheckbox(),
      'public_comments'    => new sfWidgetFormInputCheckbox(),
      'auto_comments'      => new sfWidgetFormInputCheckbox(),
      'allow_contact'      => new sfWidgetFormInputCheckbox(),
      'allow_localization' => new sfWidgetFormInputCheckbox(),
      'allow_newsletter'   => new sfWidgetFormInputCheckbox(),
      'allow_b_cmc'        => new sfWidgetFormInputCheckbox(),
      'allow_promo'        => new sfWidgetFormInputCheckbox(),
      'underage'           => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'show_profile'       => new sfValidatorBoolean(array('required' => false)),
      'search_name'        => new sfValidatorBoolean(array('required' => false)),
      'search_nickname'    => new sfValidatorBoolean(array('required' => false)),
      'search_email'       => new sfValidatorBoolean(array('required' => false)),
      'show_age'           => new sfValidatorBoolean(array('required' => false)),
      'show_gender'        => new sfValidatorBoolean(array('required' => false)),
      'show_online'        => new sfValidatorBoolean(array('required' => false)),
      'public_comments'    => new sfValidatorBoolean(array('required' => false)),
      'auto_comments'      => new sfValidatorBoolean(array('required' => false)),
      'allow_contact'      => new sfValidatorBoolean(array('required' => false)),
      'allow_localization' => new sfValidatorBoolean(array('required' => false)),
      'allow_newsletter'   => new sfValidatorBoolean(array('required' => false)),
      'allow_b_cmc'        => new sfValidatorBoolean(array('required' => false)),
      'allow_promo'        => new sfValidatorBoolean(array('required' => false)),
      'underage'           => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_setting[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserSetting';
  }

}
