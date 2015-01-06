<?php

/**
 * MobileNews filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseMobileNewsFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'       => new sfWidgetFormFilterInput(),
      'line1'       => new sfWidgetFormFilterInput(),
      'line2'       => new sfWidgetFormFilterInput(),
      'link'        => new sfWidgetFormFilterInput(),
      'rank'        => new sfWidgetFormFilterInput(),
      'country_id'  => new sfWidgetFormFilterInput(),
      'is_active'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'filename'    => new sfWidgetFormFilterInput(),
      'cities_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'City')),
    ));

    $this->setValidators(array(
      'title'       => new sfValidatorPass(array('required' => false)),
      'line1'       => new sfValidatorPass(array('required' => false)),
      'line2'       => new sfValidatorPass(array('required' => false)),
      'link'        => new sfValidatorPass(array('required' => false)),
      'rank'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'country_id'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_active'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'filename'    => new sfValidatorPass(array('required' => false)),
      'cities_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'City', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('mobile_news_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addCitiesListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.MobileNewsCity MobileNewsCity')
      ->andWhereIn('MobileNewsCity.city_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'MobileNews';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'title'       => 'Text',
      'line1'       => 'Text',
      'line2'       => 'Text',
      'link'        => 'Text',
      'rank'        => 'Number',
      'country_id'  => 'Number',
      'is_active'   => 'Boolean',
      'created_at'  => 'Date',
      'updated_at'  => 'Date',
      'filename'    => 'Text',
      'cities_list' => 'ManyKey',
    );
  }
}
