<?php

/**
 * Company filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCompanyFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'external_id'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email'                 => new sfWidgetFormFilterInput(),
      'phone'                 => new sfWidgetFormFilterInput(),
      'phone1'                => new sfWidgetFormFilterInput(),
      'phone2'                => new sfWidgetFormFilterInput(),
      'website_url'           => new sfWidgetFormFilterInput(),
      'googleplus_url'        => new sfWidgetFormFilterInput(),
      'foursquare_url'        => new sfWidgetFormFilterInput(),
      'twitter_url'           => new sfWidgetFormFilterInput(),
      'facebook_url'          => new sfWidgetFormFilterInput(),
      'facebook_id'           => new sfWidgetFormFilterInput(),
      'city_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('City'), 'add_empty' => true)),
      'location_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Location'), 'add_empty' => true)),
      'image_id'              => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Image'), 'add_empty' => true)),
      'sector_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Sector'), 'add_empty' => true)),
      'classification_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Classification'), 'add_empty' => true)),
      'review_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('TopReview'), 'add_empty' => true)),
      'company_type'          => new sfWidgetFormFilterInput(),
      'company_number'        => new sfWidgetFormFilterInput(),
      'parent_external_id'    => new sfWidgetFormFilterInput(),
      'is_validated'          => new sfWidgetFormChoice(array('choices' => array('' => '', 'not_validated' => 'not_validated', 'validation_started' => 'validation_started', 'awaiting_approval' => 'awaiting_approval', 'validated' => 'validated'))),
      'status'                => new sfWidgetFormChoice(array('choices' => array('' => '', 'approved' => 'approved', 'rejected' => 'rejected', 'pending' => 'pending', 'invisible' => 'invisible'))),
      'number_of_reviews'     => new sfWidgetFormFilterInput(),
      'average_rating'        => new sfWidgetFormFilterInput(),
      'is_address_modified'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'registration_no'       => new sfWidgetFormFilterInput(),
      'updated_crm'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'date_mod_crm'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'created_by'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CreatedByUser'), 'add_empty' => true)),
      'score'                 => new sfWidgetFormFilterInput(),
      'country_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => true)),
      'last_modified_by'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'add_empty' => true)),
      'date_last_modified_by' => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'referer'               => new sfWidgetFormFilterInput(),
      'old_slug'              => new sfWidgetFormFilterInput(),
      'cover_image_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CoverImage'), 'add_empty' => true)),
      'logo_image_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('LogoImage'), 'add_empty' => true)),
      'created_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'            => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'slug'                  => new sfWidgetFormFilterInput(),
      'get_weekend_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'getWeekend')),
      'feature_company_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'FeatureCompany')),
    ));

    $this->setValidators(array(
      'external_id'           => new sfValidatorPass(array('required' => false)),
      'email'                 => new sfValidatorPass(array('required' => false)),
      'phone'                 => new sfValidatorPass(array('required' => false)),
      'phone1'                => new sfValidatorPass(array('required' => false)),
      'phone2'                => new sfValidatorPass(array('required' => false)),
      'website_url'           => new sfValidatorPass(array('required' => false)),
      'googleplus_url'        => new sfValidatorPass(array('required' => false)),
      'foursquare_url'        => new sfValidatorPass(array('required' => false)),
      'twitter_url'           => new sfValidatorPass(array('required' => false)),
      'facebook_url'          => new sfValidatorPass(array('required' => false)),
      'facebook_id'           => new sfValidatorPass(array('required' => false)),
      'city_id'               => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('City'), 'column' => 'id')),
      'location_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Location'), 'column' => 'id')),
      'image_id'              => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Image'), 'column' => 'id')),
      'sector_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Sector'), 'column' => 'id')),
      'classification_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Classification'), 'column' => 'id')),
      'review_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('TopReview'), 'column' => 'id')),
      'company_type'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'company_number'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'parent_external_id'    => new sfValidatorPass(array('required' => false)),
      'is_validated'          => new sfValidatorChoice(array('required' => false, 'choices' => array('not_validated' => 'not_validated', 'validation_started' => 'validation_started', 'awaiting_approval' => 'awaiting_approval', 'validated' => 'validated'))),
      'status'                => new sfValidatorChoice(array('required' => false, 'choices' => array('approved' => 'approved', 'rejected' => 'rejected', 'pending' => 'pending', 'invisible' => 'invisible'))),
      'number_of_reviews'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'average_rating'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'is_address_modified'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'registration_no'       => new sfValidatorPass(array('required' => false)),
      'updated_crm'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'date_mod_crm'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'created_by'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CreatedByUser'), 'column' => 'id')),
      'score'                 => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'country_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Country'), 'column' => 'id')),
      'last_modified_by'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UserProfile'), 'column' => 'id')),
      'date_last_modified_by' => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'referer'               => new sfValidatorPass(array('required' => false)),
      'old_slug'              => new sfValidatorPass(array('required' => false)),
      'cover_image_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CoverImage'), 'column' => 'id')),
      'logo_image_id'         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('LogoImage'), 'column' => 'id')),
      'created_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'            => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'slug'                  => new sfValidatorPass(array('required' => false)),
      'get_weekend_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'getWeekend', 'required' => false)),
      'feature_company_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'FeatureCompany', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('company_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addGetWeekendListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.getWeekendCompany getWeekendCompany')
      ->andWhereIn('getWeekendCompany.parent_id', $values)
    ;
  }

  public function addFeatureCompanyListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.CompanyFeatureCompany CompanyFeatureCompany')
      ->andWhereIn('CompanyFeatureCompany.feature_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Company';
  }

  public function getFields()
  {
    return array(
      'id'                    => 'Number',
      'external_id'           => 'Text',
      'email'                 => 'Text',
      'phone'                 => 'Text',
      'phone1'                => 'Text',
      'phone2'                => 'Text',
      'website_url'           => 'Text',
      'googleplus_url'        => 'Text',
      'foursquare_url'        => 'Text',
      'twitter_url'           => 'Text',
      'facebook_url'          => 'Text',
      'facebook_id'           => 'Text',
      'city_id'               => 'ForeignKey',
      'location_id'           => 'ForeignKey',
      'image_id'              => 'ForeignKey',
      'sector_id'             => 'ForeignKey',
      'classification_id'     => 'ForeignKey',
      'review_id'             => 'ForeignKey',
      'company_type'          => 'Number',
      'company_number'        => 'Number',
      'parent_external_id'    => 'Text',
      'is_validated'          => 'Enum',
      'status'                => 'Enum',
      'number_of_reviews'     => 'Number',
      'average_rating'        => 'Number',
      'is_address_modified'   => 'Boolean',
      'registration_no'       => 'Text',
      'updated_crm'           => 'Date',
      'date_mod_crm'          => 'Date',
      'created_by'            => 'ForeignKey',
      'score'                 => 'Number',
      'country_id'            => 'ForeignKey',
      'last_modified_by'      => 'ForeignKey',
      'date_last_modified_by' => 'Date',
      'referer'               => 'Text',
      'old_slug'              => 'Text',
      'cover_image_id'        => 'ForeignKey',
      'logo_image_id'         => 'ForeignKey',
      'created_at'            => 'Date',
      'updated_at'            => 'Date',
      'slug'                  => 'Text',
      'get_weekend_list'      => 'ManyKey',
      'feature_company_list'  => 'ManyKey',
    );
  }
}
