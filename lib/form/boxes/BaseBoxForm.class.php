<?php

/**
 * Base project form.
 * 
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal 
 * @version    SVN: $Id: BaseForm.class.php 20147 2009-07-13 11:46:57Z FabianLange $
 */
class BaseBoxForm extends BaseForm
{
  public function configure()
  {
    $this->widgetSchema['title']       = new sfWidgetFormInputText();
    
    $this->widgetSchema['type']        = new sfWidgetFormChoice(array(
      'choices' => array(
        'ids'       => 'Choose articles',
        'category'  => 'From category',
        'default'   => 'Default settings'
    )));
    
    $this->widgetSchema['order_by']    = new sfWidgetFormChoice(array(
      'choices' => array(
        'created_at' => 'Date',
        'reviews'    => 'Reviews',
    )));
    
    $this->widgetSchema['limit']       = new sfWidgetFormInputText();
    
    
    $this->setValidators(array(
      'title'       => new sfValidatorString(),
      'type'        => new sfValidatorChoice(array('choices' => array('ids', 'category', 'default'), 'required' => false)),
      'order_by'    => new sfValidatorChoice(array('choices' => array('created_at', 'reviews'), 'required' => false)),
      'limit'       => new sfValidatorInteger(array('required' => false)),
    ));
    
    $this->widgetSchema->setNameFormat('setup[%s]');
    
    $this->disableCSRFProtection();
    
    $this->validatorSchema->setOption('allow_extra_fields', true);
  }
}
