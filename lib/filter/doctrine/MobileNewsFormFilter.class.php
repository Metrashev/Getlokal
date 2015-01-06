<?php

/**
 * MobileNews filter form.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class MobileNewsFormFilter extends BaseMobileNewsFormFilter
{
  public function configure()
  {
    $query = Doctrine::getTable('City')
              ->createQuery('c')
              ->innerJoin('c.County co')
              ->where('co.country_id = ?', sfContext::getInstance()->getUser()->getCountry()->getId())
              ->andWhere('c.is_default > 0');
              
    $this->widgetSchema['cities_list'] = new sfWidgetFormDoctrineJQueryAutocompleter(array(
    		'model' => 'City',
    		'method' => 'getLocation',
    		'url' => sfContext::getInstance()
    		->getRouting()
    		->generate('default', array(
    				'module' => 'user_profile',
    				'action' => 'autocomplete' ) ),
    		'config' => ' {
          		  scrollHeight: 250,
         		  autoFill: false,
          		  cacheLength: 0,
        		  delay: 1,
        		  max: 10,
        		  minChars:0
        		}'
    ));
     
    $this->setValidator(
    		'cities_list',
    		new sfValidatorDoctrineChoice(array(
    				'required' => false,
    				'model' => 'City'
    		)
    		));
    
  }
}
