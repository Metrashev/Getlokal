<?php

/**
 * Base project form.
 * 
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal 
 * @version    SVN: $Id: BaseForm.class.php 20147 2009-07-13 11:46:57Z FabianLange $
 */
class RecommendationsBoxForm extends BaseBoxForm
{
  public function configure()
  {
    parent::configure();
    unset($this['title']);
    
    $this->widgetSchema['ids'] = new sfWidgetFormDoctrineChoice(array(
      'model' => 'Sector',
      'expanded' => true,
      'multiple' => true
    ));
    
    $this->validatorSchema['ids']= new sfValidatorPass();
  }
}
