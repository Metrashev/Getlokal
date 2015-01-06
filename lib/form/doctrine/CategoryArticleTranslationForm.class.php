<?php

/**
 * CategoryArticleTranslation form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CategoryArticleTranslationForm extends BaseCategoryArticleTranslationForm
{
  public function configure()
  {
  	$this->setWidgets(array(
  			'title'     => new sfWidgetFormInputText(),
  			'is_active' => new sfWidgetFormInputCheckbox(),
  			'slug'      => new sfWidgetFormInputText(),
  	));
  	
  	$this->setValidators(array(
  			'title'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
  			'is_active' => new sfValidatorBoolean(array('required' => false)),
  			'slug'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
  	));
  }
}
