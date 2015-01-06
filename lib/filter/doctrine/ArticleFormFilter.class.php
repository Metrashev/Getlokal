<?php

/**
 * Article filter form.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ArticleFormFilter extends BaseArticleFormFilter
{
  public function configure()
  {
  	
  	$this->setWidget ( 'id', new sfWidgetFormFilterInput ( array ('with_empty' => false ) ) );
  	$this->setValidator ( 'id', new sfValidatorSchemaFilter ( 'text', new sfValidatorNumber ( array ('required' => false ) ) ) );
  	
  	$this->widgetSchema ['title'] = new sfWidgetFormFilterInput ( array ('with_empty' => true ) );
  	$this->setValidator ( 'title', new sfValidatorPass ( array ('required' => false ) ) );
  	
  	$this->widgetSchema ['first_name'] = new sfWidgetFormFilterInput ( array ('with_empty' => true ) );
  	$this->setValidator ( 'first_name', new sfValidatorPass ( array ('required' => false ) ) );
  	
  	$this->widgetSchema ['last_name'] = new sfWidgetFormFilterInput ( array ('with_empty' => true ) );
  	$this->setValidator ( 'last_name', new sfValidatorPass ( array ('required' => false ) ) );
  	
  	$this->widgetSchema ['keywords'] = new sfWidgetFormFilterInput ( array ('with_empty' => true ) );
  	$this->setValidator ( 'keywords', new sfValidatorPass ( array ('required' => false ) ) );
  }
  	
  	public function addTitleColumnQuery($query, $field, $value) {
  		if ($value ['text'] != null) {
  			Doctrine::getTable ( 'Article' )->applyTitleFilter ( $query, $value );
  		}
  	}
  	
  	public function addFirstNameColumnQuery($query, $field, $value) {
  		if ($value ['text'] != null) {
  			Doctrine::getTable ( 'Article' )->applyFirstNameFilter ( $query, $value );
  		}
  	}
  	
  	public function addLastNameColumnQuery($query, $field, $value) {
  		if ($value ['text'] != null) {
  			Doctrine::getTable ( 'Article' )->applyLastNameFilter ( $query, $value );
  		}
  	}
  	
  	public function addKeywordsColumnQuery($query, $field, $value) {
  		if ($value ['text'] != null) {
  			Doctrine::getTable ( 'Article' )->applyLastNameFilter ( $query, $value );
  		}
  	}
  	
}
