<?php

/**
 * Slider filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseSliderFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'         => new sfWidgetFormFilterInput(),
      'title_en'      => new sfWidgetFormFilterInput(),
      'title_ru'      => new sfWidgetFormFilterInput(),
      'body'          => new sfWidgetFormFilterInput(),
      'body_en'       => new sfWidgetFormFilterInput(),
      'body_ru'       => new sfWidgetFormFilterInput(),
      'link'          => new sfWidgetFormFilterInput(),
      'link_en'       => new sfWidgetFormFilterInput(),
      'link_ru'       => new sfWidgetFormFilterInput(),
      'rank'          => new sfWidgetFormFilterInput(),
      'country_id'    => new sfWidgetFormFilterInput(),
      'whole_country' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_active'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'filename'      => new sfWidgetFormFilterInput(),
      'sectors_list'  => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Sector')),
      'cities_list'   => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'City')),
    ));

    $this->setValidators(array(
      'title'         => new sfValidatorPass(array('required' => false)),
      'title_en'      => new sfValidatorPass(array('required' => false)),
      'title_ru'      => new sfValidatorPass(array('required' => false)),
      'body'          => new sfValidatorPass(array('required' => false)),
      'body_en'       => new sfValidatorPass(array('required' => false)),
      'body_ru'       => new sfValidatorPass(array('required' => false)),
      'link'          => new sfValidatorPass(array('required' => false)),
      'link_en'       => new sfValidatorPass(array('required' => false)),
      'link_ru'       => new sfValidatorPass(array('required' => false)),
      'rank'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'country_id'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'whole_country' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_active'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'filename'      => new sfValidatorPass(array('required' => false)),
      'sectors_list'  => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Sector', 'required' => false)),
      'cities_list'   => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'City', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('slider_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addSectorsListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->leftJoin($query->getRootAlias().'.SliderSector SliderSector')
      ->andWhereIn('SliderSector.sector_id', $values)
    ;
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
      ->leftJoin($query->getRootAlias().'.SliderCity SliderCity')
      ->andWhereIn('SliderCity.city_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'Slider';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'title'         => 'Text',
      'title_en'      => 'Text',
      'title_ru'      => 'Text',
      'body'          => 'Text',
      'body_en'       => 'Text',
      'body_ru'       => 'Text',
      'link'          => 'Text',
      'link_en'       => 'Text',
      'link_ru'       => 'Text',
      'rank'          => 'Number',
      'country_id'    => 'Number',
      'whole_country' => 'Boolean',
      'is_active'     => 'Boolean',
      'created_at'    => 'Date',
      'updated_at'    => 'Date',
      'filename'      => 'Text',
      'sectors_list'  => 'ManyKey',
      'cities_list'   => 'ManyKey',
    );
  }
}
