<?php

/**
 * MobileNews form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class MobileNewsForm extends BaseMobileNewsForm
{
  public function configure()
  {
    unset(
      $this['country_id'],
      $this['filename'],
      $this['created_at'],
      $this['updated_at']
    );
    
    $query = Doctrine::getTable('City')
              ->createQuery('c')
              ->innerJoin('c.County co')
              ->where('co.country_id = ?', sfContext::getInstance()->getUser()->getCountry()->getId())
              ->andWhere('c.is_default > 0');
              
    $this->widgetSchema['cities_list']->setOption('query', $query);
    $this->widgetSchema['cities_list']->setAttribute('style', 'height: 100px;width: 300px');
    
    $this->widgetSchema['file'] = new sfWidgetFormInputFileEditable(array(
      'is_image' => true,
      'file_src' => $this->getObject()->getThumb()
    ));
    $this->validatorSchema['file'] = new sfValidatorFile();
    
    if(!$this->getObject()->isNew())
    {
      $this->validatorSchema['file']->setOption('required', false);
    }
    
    $this->validatorSchema['link']    = new sfValidatorUrl(array('required' => false));
    //$this->validatorSchema['link_en'] = new sfValidatorUrl(array('required' => false));
  }
  
  public function doUpdateObject($values)
  {
    parent::doUpdateObject($values);
    
    $this->getObject()->setFile($this->getValue('file'));
    $this->getObject()->setCountryId(sfContext::getInstance()->getUser()->getCountry()->getId());
  }
  
  public function processUploadedFile($field, $filename = null, $values = null)
  {
    return;
    
    parent::processUploadedFile($field, $filename, $values);
  }
}
