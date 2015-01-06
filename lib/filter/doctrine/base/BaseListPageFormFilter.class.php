<?php

/**
 * ListPage filter form base class.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseListPageFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'list_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Lists'), 'add_empty' => true)),
      'page_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CompanyPage'), 'add_empty' => true)),
      'user_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('UserProfile'), 'add_empty' => true)),
      'status'  => new sfWidgetFormChoice(array('choices' => array('' => '', 'approved' => 'approved', 'pending' => 'pending', 'rejected' => 'rejected'))),
    ));

    $this->setValidators(array(
      'list_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Lists'), 'column' => 'id')),
      'page_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('CompanyPage'), 'column' => 'id')),
      'user_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('UserProfile'), 'column' => 'id')),
      'status'  => new sfValidatorChoice(array('required' => false, 'choices' => array('approved' => 'approved', 'pending' => 'pending', 'rejected' => 'rejected'))),
    ));

    $this->widgetSchema->setNameFormat('list_page_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ListPage';
  }

  public function getFields()
  {
    return array(
      'id'      => 'Number',
      'list_id' => 'ForeignKey',
      'page_id' => 'ForeignKey',
      'user_id' => 'ForeignKey',
      'status'  => 'Enum',
    );
  }
}
