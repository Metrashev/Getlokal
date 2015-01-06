<?php

/**
 * BadgeRequirement form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BadgeRequirementForm extends BaseBadgeRequirementForm
{
  public function configure()
  {
    $this->widgetSchema['key']    = new sfWidgetFormChoice(array('multiple' => true, 'expanded' => true, 'choices' => array()));
    //$this->validatorSchema['key'] = new sfValidatorDoctrineChoice(array('model' => 'UserStatKey', 'multiple' => true, 'column' => 'key'));
    $this->validatorSchema['key'] = new sfValidatorPass();
    
    $this->widgetSchema['group_no'] = new sfWidgetFormChoice(array('choices' => array(
      1 => 'AND',
      2 => 'OR'
    )));
  }
}
