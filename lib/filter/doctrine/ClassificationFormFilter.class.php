<?php

/**
 * Classification filter form.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ClassificationFormFilter extends BaseClassificationFormFilter
{
  public function configure()
  {
  	$this->setWidget ( 'id', new sfWidgetFormFilterInput ( array ('with_empty' => false ) ) );
	  $this->setValidator ( 'id', new sfValidatorSchemaFilter ( 'text', new sfValidatorNumber ( array ('required' => false ) ) ) );
	
	  $this->widgetSchema ['title'] = new sfWidgetFormFilterInput ( array ('with_empty' => true ) );
	  $this->setValidator ( 'title', new sfValidatorPass ( array ('required' => false ) ) );
	
	  $this->widgetSchema ['keyword'] = new sfWidgetFormFilterInput ( array ('with_empty' => true ) );
	  $this->setValidator ( 'keyword', new sfValidatorPass ( array ('required' => false ) ) );			
  }
  
  public function addTitleColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'Classification' )->applyTitleFilter ( $query, $value );
		}
	}
  
  public function addKeywordColumnQuery($query, $field, $value) {
    if ($value ['text'] != null) {
      Doctrine::getTable ( 'Classification' )->applyKeywordFilter ( $query, $value );
    }
    
  }
  
  public function addSectorIdColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
      $alias = $query->getRootAlias();
			$query->innerJoin($alias.'.ClassificationSector cs')
            ->andWhere('cs.sector_id = ?', $value);
		}
	}
  
  public function getFields() {
		$fields = parent::getFields ();
		$fields ['title'] = 'title';
		$fields ['keyword'] = 'keyword';		
		return $fields;
	}
}
