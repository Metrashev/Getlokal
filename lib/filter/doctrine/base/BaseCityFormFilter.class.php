<?php

/**
 * City filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseCityFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'slug'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'county_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('County'), 'add_empty' => true)),
      'is_default'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'lat'              => new sfWidgetFormFilterInput(),
      'lng'              => new sfWidgetFormFilterInput(),
      'slider_list'      => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Slider')),
      'mobile_news_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'MobileNews')),
    ));

    $this->setValidators(array(
      'slug'             => new sfValidatorPass(array('required' => false)),
      'county_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('County'), 'column' => 'id')),
      'is_default'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'lat'              => new sfValidatorPass(array('required' => false)),
      'lng'              => new sfValidatorPass(array('required' => false)),
      'slider_list'      => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Slider', 'required' => false)),
      'mobile_news_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'MobileNews', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('city_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addSliderListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('SliderCity.slider_id', $values)
    ;
  }

  public function addMobileNewsListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('MobileNewsCity.news_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'City';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'slug'             => 'Text',
      'county_id'        => 'ForeignKey',
      'is_default'       => 'Boolean',
      'lat'              => 'Text',
      'lng'              => 'Text',
      'slider_list'      => 'ManyKey',
      'mobile_news_list' => 'ManyKey',
    );
  }
}
