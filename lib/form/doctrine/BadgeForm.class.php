<?php

/**
 * Badge form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class BadgeForm extends BaseBadgeForm
{
  public function configure()
  {
    unset(
      $this['percent'], 
      $this['active_image'], 
      $this['small_active_image'], 
      $this['inactive_image'], 
      $this['requirements']
    );
    
    //$this->widgetSchema['start_at'] = new sfWidgetFormJQueryDate();
    //$this->widgetSchema['end_at']   = new sfWidgetFormJQueryDate();
    
    $this->widgetSchema['active_image']    = new sfWidgetFormInputFileEditable(array('is_image' => true, 'file_src' => $this->getObject()->getFile('active_image')->getUrl()));
    $this->validatorSchema['active_image'] = new sfValidatorFile(array('required' => false));
    
    $this->widgetSchema['inactive_image']    = new sfWidgetFormInputFileEditable(array('is_image' => true, 'file_src' => $this->getObject()->getFile('inactive_image')->getUrl()));
    $this->validatorSchema['inactive_image'] = new sfValidatorFile(array('required' => false));
    
    $this->widgetSchema['small_active_image']    = new sfWidgetFormInputFileEditable(array('is_image' => true, 'file_src' => $this->getObject()->getFile('small_active_image')->getUrl()));
    $this->validatorSchema['small_active_image'] = new sfValidatorFile(array('required' => false));
    
    $this->embedI18n(array('en', 'ro', 'bg', 'mk', 'sr', 'fi', 'ru', 'hu', 'pt'));
    
    $this->widgetSchema->moveField('pt', sfWidgetFormSchema::FIRST);
    $this->widgetSchema->moveField('hu', sfWidgetFormSchema::FIRST);
    $this->widgetSchema->moveField('ru', sfWidgetFormSchema::FIRST);
    $this->widgetSchema->moveField('fi', sfWidgetFormSchema::FIRST);
    $this->widgetSchema->moveField('sr', sfWidgetFormSchema::FIRST);
    $this->widgetSchema->moveField('mk', sfWidgetFormSchema::FIRST);
    $this->widgetSchema->moveField('ro', sfWidgetFormSchema::FIRST);
    $this->widgetSchema->moveField('bg', sfWidgetFormSchema::FIRST);
    $this->widgetSchema->moveField('en', sfWidgetFormSchema::FIRST);
    
    
    $this->widgetSchema->moveField('start_at', sfWidgetFormSchema::LAST);
    $this->widgetSchema->moveField('end_at', sfWidgetFormSchema::LAST);
  }
  
/*  public function processUploadedFile($field, $filename = null, $values = null)
  {
    return true;
  }
*/  
  public function updateObject($values = null)
  {
    parent::updateObject($values);
    
    $this->getObject()->setFile($this->getValue('inactive_image'), 'inactive_image');
    $this->getObject()->setFile($this->getValue('small_active_image'), 'small_active_image');
    $this->getObject()->setFile($this->getValue('active_image'), 'active_image');
  }
}
