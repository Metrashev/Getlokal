<?php

/**
 * Company form base class.
 *
 * @method Company getObject() Returns the current form's model object
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCompanyForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'external_id'           => new sfWidgetFormInputText(),
      'email'                 => new sfWidgetFormInputText(),
      'phone'                 => new sfWidgetFormInputText(),
      'phone1'                => new sfWidgetFormInputText(),
      'phone2'                => new sfWidgetFormInputText(),
      'website_url'           => new sfWidgetFormInputText(),
      'googleplus_url'        => new sfWidgetFormInputText(),
      'foursquare_url'        => new sfWidgetFormInputText(),
      'twitter_url'           => new sfWidgetFormInputText(),
      'facebook_url'          => new sfWidgetFormInputText(),
      'facebook_id'           => new sfWidgetFormInputText(),
      'city_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('City'), 'add_empty' => false)),
      'location_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Location'), 'add_empty' => true)),
      'image_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Image'), 'add_empty' => true)),
      'sector_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sector'), 'add_empty' => true)),
      'classification_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Classification'), 'add_empty' => true)),
      'review_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TopReview'), 'add_empty' => true)),
      'company_type'          => new sfWidgetFormInputText(),
      'company_number'        => new sfWidgetFormInputText(),
      'parent_external_id'    => new sfWidgetFormInputText(),
      'is_validated'          => new sfWidgetFormChoice(array('choices' => array('not_validated' => 'not_validated', 'validation_started' => 'validation_started', 'awaiting_approval' => 'awaiting_approval', 'validated' => 'validated'))),
      'status'                => new sfWidgetFormChoice(array('choices' => array('approved' => 'approved', 'rejected' => 'rejected', 'pending' => 'pending', 'invisible' => 'invisible'))),
      'number_of_reviews'     => new sfWidgetFormInputText(),
      'average_rating'        => new sfWidgetFormInputText(),
      'is_address_modified'   => new sfWidgetFormInputCheckbox(),
      'registration_no'       => new sfWidgetFormInputText(),
      'updated_crm'           => new sfWidgetFormDateTime(),
      'date_mod_crm'          => new sfWidgetFormDateTime(),
      'created_by'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CreatedByUser'), 'add_empty' => true)),
      'score'                 => new sfWidgetFormInputText(),
      'country_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => true)),
      'last_modified_by'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'add_empty' => true)),
      'date_last_modified_by' => new sfWidgetFormDateTime(),
      'referer'               => new sfWidgetFormInputText(),
      'old_slug'              => new sfWidgetFormInputText(),
      'cover_image_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CoverImage'), 'add_empty' => true)),
      'logo_image_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LogoImage'), 'add_empty' => true)),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
      'slug'                  => new sfWidgetFormInputText(),
      'get_weekend_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'getWeekend')),
      'feature_company_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'FeatureCompany')),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'external_id'           => new sfValidatorString(array('max_length' => 36)),
      'email'                 => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'phone'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'phone1'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'phone2'                => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'website_url'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'googleplus_url'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'foursquare_url'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'twitter_url'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'facebook_url'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'facebook_id'           => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'city_id'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('City'))),
      'location_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Location'), 'required' => false)),
      'image_id'              => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Image'), 'required' => false)),
      'sector_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Sector'), 'required' => false)),
      'classification_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Classification'), 'required' => false)),
      'review_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('TopReview'), 'required' => false)),
      'company_type'          => new sfValidatorInteger(array('required' => false)),
      'company_number'        => new sfValidatorInteger(array('required' => false)),
      'parent_external_id'    => new sfValidatorString(array('max_length' => 36, 'required' => false)),
      'is_validated'          => new sfValidatorChoice(array('choices' => array(0 => 'not_validated', 1 => 'validation_started', 2 => 'awaiting_approval', 3 => 'validated'), 'required' => false)),
      'status'                => new sfValidatorChoice(array('choices' => array(0 => 'approved', 1 => 'rejected', 2 => 'pending', 3 => 'invisible'), 'required' => false)),
      'number_of_reviews'     => new sfValidatorInteger(array('required' => false)),
      'average_rating'        => new sfValidatorNumber(array('required' => false)),
      'is_address_modified'   => new sfValidatorBoolean(array('required' => false)),
      'registration_no'       => new sfValidatorString(array('max_length' => 14, 'required' => false)),
      'updated_crm'           => new sfValidatorDateTime(array('required' => false)),
      'date_mod_crm'          => new sfValidatorDateTime(array('required' => false)),
      'created_by'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CreatedByUser'), 'required' => false)),
      'score'                 => new sfValidatorNumber(array('required' => false)),
      'country_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'required' => false)),
      'last_modified_by'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'required' => false)),
      'date_last_modified_by' => new sfValidatorDateTime(array('required' => false)),
      'referer'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'old_slug'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'cover_image_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CoverImage'), 'required' => false)),
      'logo_image_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('LogoImage'), 'required' => false)),
      'created_at'            => new sfValidatorDateTime(),
      'updated_at'            => new sfValidatorDateTime(),
      'slug'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'get_weekend_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'getWeekend', 'required' => false)),
      'feature_company_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'FeatureCompany', 'required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Company', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('company[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Company';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['get_weekend_list']))
    {
      $this->setDefault('get_weekend_list', $this->object->getWeekend->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['feature_company_list']))
    {
      $this->setDefault('feature_company_list', $this->object->FeatureCompany->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->savegetWeekendList($con);
    $this->saveFeatureCompanyList($con);

    parent::doSave($con);
  }

  public function savegetWeekendList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['get_weekend_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->getWeekend->getPrimaryKeys();
    $values = $this->getValue('get_weekend_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('getWeekend', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('getWeekend', array_values($link));
    }
  }

  public function saveFeatureCompanyList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['feature_company_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->FeatureCompany->getPrimaryKeys();
    $values = $this->getValue('feature_company_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('FeatureCompany', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('FeatureCompany', array_values($link));
    }
  }

}
