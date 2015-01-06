<?php

/**
 * ArticleTranslation form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ArticleTranslationForm extends BaseArticleTranslationForm
{
  public function configure()
  {
  	$this->setWidgets(array(
  			'id'          => new sfWidgetFormInputHidden(),
  			'title'       => new sfWidgetFormInputText(),
  			'keywords'       => new sfWidgetFormInputText(),
  			'description' => new sfWidgetFormTextarea(),
  			'quotation' => new sfWidgetFormTextarea(),
  			'lang'        => new sfWidgetFormInputHidden(),
  			'slug'       => new sfWidgetFormInputText(),
  	));
  	
  	
  	$this->widgetSchema['content'] = new sfWidgetFormTextareaTinyMCECustom ( array ('width' => 580, 'height' => 300, 'theme' => 'advanced' ), array ('class' => 'tinyMCE' ) );
  	/*
  	 $this->widgetSchema['description'] =  new sfWidgetFormTextareaTinyMCE(
  	 		array(
  	 				'width'=>600,
  	 				'height'=>100,
  	 				'config'=>'theme_advanced_disable: "anchor,image,cleanup,help"',
  	 				'theme'   =>  sfConfig::get('app_tinymce_theme','simple'),
  	 		),
  	 		array(
  	 				'class'   =>  'tiny_mce'
  	 		)
  	 );
  	*/
  	$this->setValidators(array(
  			'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
  			'title'       => new sfValidatorString(array('max_length' => 255,'required' => false, 'min_length'=>2, 'trim' => true )),
  			'keywords'       => new sfValidatorString(array('max_length' => 255,'required' => false)),
  			'content' => new sfValidatorString(array('required' => false)),
  			'description' => new sfValidatorString(array('max_length' => 6000,'required' => false, 'trim' => true )),
  			'quotation' => new sfValidatorString(array('max_length' => 6000,'required' => false)),
  			'lang'        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('lang')), 'empty_value' => $this->getObject()->get('lang'), 'required' => false)),
  			'slug'       => new sfValidatorRegex(array('max_length' => 255,'required' => false, 'pattern' => '/^[a-zA-Z0-9]([a-zA-Z0-9-]+)$/' ), array('invalid'=>'The slug "%value%" contains characters that are not allowed')),
  	));
  	$this->validatorSchema->setOption ( 'allow_extra_fields', true );
  	$this->validatorSchema->setOption ( 'filter_extra_fields', true );
  	$this->widgetSchema->setNameFormat('article_translation[%s]');
  	
  	$this->widgetSchema->setLabels(
  			array(
  					'title' =>  'Article Title',// null, 'profile') .'*',
  					'content' => 'Article Content',// null, 'profile') .'*',
  					'slug' => 'Slug',
  					'description' => 'Meta Description',
  					'keywords' => 'Meta Keywords',
  					'quotation' => 'Quotation',
  			)    );
  	
  	$this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
  	$this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}
