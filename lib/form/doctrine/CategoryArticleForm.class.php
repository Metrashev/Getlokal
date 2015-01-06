<?php

/**
 * CategoryArticle form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CategoryArticleForm extends BaseCategoryArticleForm
{
  public function configure()
  {
  	
  	$query = Doctrine::getTable('Country')
  	->createQuery('c')
  	->where('c.name!=""')
	->andwhere('c.id < 250');
  	
  	$this->setWidgets(array(
  			'status'       => new sfWidgetFormChoice(array('choices' => array('approved' => 'approved', 'pending' => 'pending', 'rejected' => 'rejected'))),
  			'country_list' => new sfWidgetFormDoctrineChoice(array('expanded' => true,'multiple' => true, 'model' => 'Country', 'query'=>$query)),
  			//'classification_list' => new sfWidgetFormDoctrineChoice(array('expanded' => true,'multiple' => true, 'model' => 'Classification')),
  	));
  	$this->setValidators(array(
  			'status'       => new sfValidatorChoice(array('choices' => array(0 => 'approved', 1 => 'pending', 2 => 'rejected'), 'required' => false)),
  			'country_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Country', 'required' => false)),
  			//'classification_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Classification', 'required' => false)),
  	));
  	
  	
  	$culture = sfContext::getInstance()->getUser()->getCountry()->getSlug();
  	$this->embedI18n(array('en', 'bg', 'ro','mk','sr','fi', 'ru', 'hu', 'pt', 'me'));
  	
  	$this->widgetSchema->setNameFormat('category_article[%s]');
  }
  
  
  
}
