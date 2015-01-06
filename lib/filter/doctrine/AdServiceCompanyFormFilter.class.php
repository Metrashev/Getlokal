<?php

/**
 * AdServiceCompany filter form.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class AdServiceCompanyFormFilter extends BaseAdServiceCompanyFormFilter {
	public function configure() {
		parent::configure ();
		$this->useFields ( array ('status','ad_service_id', 'crm_id', 'created_at', 'updated_at' ) );
		$this->widgetSchema ['company'] = new sfWidgetFormFilterInput ( array ('with_empty' => true ) );
		$this->setValidator ( 'company', new sfValidatorPass ( array ('required' => false ) ) );
		$this->widgetSchema ['sector'] = new sfWidgetFormDoctrineChoice ( array ('model' => 'Sector', 'add_empty' => true ) );
		$this->widgetSchema ['sector']->setOption ( 'query', Doctrine::getTable ( 'Sector' )->createQuery ( 's' )->innerJoin ( 's.Translation' ) );
		
		$this->widgetSchema ['classification'] = new sfWidgetFormDoctrineJQueryAutocompleter ( array ('model' => 'Classification', 'url' => sfContext::getInstance ()->getController ()->genUrl ( array ('module' => 'company', 'action' => 'getClassifiersAutocomplete', 'route' => 'default' ) ), 'config' => ' {
          scrollHeight: 250,
          autoFill: false,
          cacheLength: 1,
          delay: 1,
          max: 10,
          minChars:0
       }' ) );
		$this->setValidator ( 'sector', new sfValidatorDoctrineChoice ( array ('required' => false, 'model' => 'Sector', 'column' => 'id' ) ) );
		$this->setValidator ( 'classification', new sfValidatorDoctrineChoice ( array ('required' => false, 'model' => 'Classification', 'column' => 'id' ) ) );
		$this->widgetSchema ['company_city'] = new sfWidgetFormDoctrineJQueryAutocompleter ( array ('model' => 'City', 'method' => 'getLocation', 'url' => sfContext::getInstance ()->getController ()->genUrl ( array ('module' => 'company', 'action' => 'getCitiesAutocomplete', 'route' => 'default' ) ), 'config' => ' {
          scrollHeight: 250,
          autoFill: false,
          cacheLength: 1,
          delay: 1,
          max: 10,
          minChars:0
       }' ) );
		$this->setValidator ( 'company_city', new sfValidatorDoctrineChoice ( array ('required' => false, 'model' => 'City' ) ) );
	
	}
	
	public function buildQuery(array $values) {
		$query = parent::buildQuery ( $values );
		
		$rootAlias = $query->getRootAlias ();
		
		if ((isset ( $values ['classification'] ) && $values ['classification']) || (isset ( $values ['sector'] ) && $values ['sector'])) {
			$query->innerJoin ( $rootAlias . '.Company c1' )->leftJoin ( 'c1.CompanyClassification cc' )->innerJoin ( 'cc.Classification cs' );
		}
		if (isset ( $values ['classification'] ) && $values ['classification']) {
			$query->addWhere ( 'cs.id = ?', $values ['classification'] );
		}
		if (isset ( $values ['sector'] ) && $values ['sector']) {
			$query->innerJoin ( $rootAlias . '.Company c2' )->leftJoin ( 'cs.ClassificationSector css' )->innerJoin ( 'css.Sector s' )->addWhere ( 's.id = ? ', $values ['sector'] );
		}
		
		return $query;
	}
	public function addCompanyColumnQuery($query, $field, $value) {
		
		if ($value ['text'] != null) {
			$rootAlias = $query->getRootAlias ();
			$query->innerJoin ( $rootAlias . '.Company c3' )->addWhere ( 'c3.title like ? or c3.title_en like ?', array ('%' . $value ['text'] . '%', '%' . $value ['text'] . '%' ) );
		}
	}
	
	public function addCompanyCityColumnQuery($query, $field, $value) {
		
		if ($value ['text'] != null) {
			$rootAlias = $query->getRootAlias ();
			$query->innerJoin ( $rootAlias . '.Company c4')
			->addWhere('c4.city_id = ?',  $value);
		}
	}
  public function getFields()
  {
    $return = parent::getFields();
    $return['type'] = 'Enum';
    
    return $return;
  }
}
