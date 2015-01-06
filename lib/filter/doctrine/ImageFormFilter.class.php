<?php

/**
 * Image filter form.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ImageFormFilter extends BaseImageFormFilter
{
  public function configure()
  {
    $this->setWidget ( 'id', new sfWidgetFormFilterInput ( array ('with_empty' => false ) ) );
		$this->setValidator ( 'id', new sfValidatorSchemaFilter ( 'text', new sfValidatorNumber ( array ('required' => false ) ) ) );
		
		
		$this->widgetSchema ['first_name'] = new sfWidgetFormFilterInput ( array ('with_empty' => true ) );
		$this->setValidator ( 'first_name', new sfValidatorPass ( array ('required' => false ) ) );
		
		$this->widgetSchema ['last_name'] = new sfWidgetFormFilterInput ( array ('with_empty' => true ) );
		$this->setValidator ( 'last_name', new sfValidatorPass ( array ('required' => false ) ) );
		
		$this->widgetSchema ['company'] = new sfWidgetFormFilterInput ( array ('with_empty' => true ) );
		$this->setValidator ( 'company', new sfValidatorPass ( array ('required' => false ) ) );

		$this->widgetSchema['sector']= new sfWidgetFormDoctrineChoice(array('model' => 'Sector', 'add_empty' => true));
		$this->widgetSchema['sector']->setOption('query', Doctrine::getTable('Sector')->createQuery('s')->innerJoin('s.Translation'));
    
		$this->widgetSchema ['classification'] = new sfWidgetFormDoctrineJQueryAutocompleter ( array ('model' => 'Classification', 'url' => sfContext::getInstance ()->getController ()->genUrl ( array ('module' => 'company', 'action' => 'getClassifiersAutocomplete', 'route' => 'default' ) ), 'config' => ' {
          scrollHeight: 250,
          autoFill: false,
          cacheLength: 1,
          delay: 1,
          max: 10,
          minChars:0
       }' ) );
		
	 $this->setValidator ( 'sector', new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Sector', 'column' => 'id')));
     $this->setValidator ( 'classification', new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'Classification', 'column' => 'id')));
      
    $this->widgetSchema['type'] = new sfWidgetFormChoice(array('choices' => array(''=>'', 'profile' => 'Profile', 'company' => 'Company', 'video' => 'Video')));
		
		$this->widgetSchema['company_city'] = new sfWidgetFormDoctrineJQueryAutocompleter(array(
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
				'company_city',
				new sfValidatorDoctrineChoice(array(
						'required' => false,
						'model' => 'City'
				)
				));
  }

  public function buildQuery(array $values)
  {
    $query = parent::buildQuery($values);
    
    $rootAlias = $query->getRootAlias();

    
    
    if( (isset($values['classification']) && $values['classification']) || (isset($values['sector']) && $values['sector']) )
    {  
    	$query->leftJoin('c.CompanyClassification cc')
    	->innerJoin('cc.Classification cs');
    }
    if( isset($values['classification']) && $values['classification'] )
    { 
      	$query->addWhere('cs.id = ?', $values['classification']);
    }
    if( isset($values['sector']) && $values['sector'] )
    { 
      	$query->leftJoin('cs.ClassificationSector css')
      	->innerJoin('css.Sector s')
      	->addWhere('s.id = ? ', $values['sector']);
    }
   

    return $query;
  }
  
  public function addFirstNameColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
      $query->andWhere('sf.first_name like ?', $value['text'].'%');
		}
	}
  
	public function addLastNameColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
      $query->andWhere('sf.last_name like ?', $value['text'].'%');
		}
	}
	
	public function addCompanyColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {  
    
     $query->innerJoin('c.Translation ct')->addWhere('ct.title like ?', '%'.$value['text'].'%');
    }
  }
  
  public function addCompanyCityColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			$query->addWhere('c.city_id = ?',  $value);
		}
	}
  public function getFields()
  {
    $return = parent::getFields();
    $return['type'] = 'Enum';
    
    return $return;
  }
}