<?php

/**
 * Company filter form.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CompanyFormFilter extends BaseCompanyFormFilter
{
public function configure() {
	
		$this->setWidget ( 'id', new sfWidgetFormFilterInput ( array ('with_empty' => false ) ) );
		$this->setValidator ( 'id', new sfValidatorSchemaFilter ( 'text', new sfValidatorNumber ( array ('required' => false ) ) ) );

		$this->widgetSchema ['title'] = new sfWidgetFormFilterInput (array('with_empty' => false));
		$this->setValidator ( 'title', new sfValidatorPass ( array ('required' => false ) ) );
		
		$this->widgetSchema ['email_address'] = new sfWidgetFormFilterInput ( array ('with_empty' => true ) );
		$this->setValidator ( 'email_address', new sfValidatorPass ( array ('required' => false ) ) );
		
		$this->widgetSchema ['first_name'] = new sfWidgetFormFilterInput ( array ('with_empty' => true ) );
		$this->setValidator ( 'first_name', new sfValidatorPass ( array ('required' => false ) ) );
		
		$this->widgetSchema ['last_name'] = new sfWidgetFormFilterInput ( array ('with_empty' => true ) );
		$this->setValidator ( 'last_name', new sfValidatorPass ( array ('required' => false ) ) );
		$this->widgetSchema [ 'status'] = new sfWidgetFormChoice(array('choices' => array( 
		 '' => 'choose...' , 
		 CompanyTable::VISIBLE => CompanyTable::VISIBLE.' visible (approved)',
		 CompanyTable::INVISIBLE => CompanyTable::INVISIBLE.' invisible (dnd crm)',
		 CompanyTable::INVISIBLE_NO_CLASS => CompanyTable::INVISIBLE_NO_CLASS.' invisible(NO class)',
		 CompanyTable::NEW_PENDING => CompanyTable::NEW_PENDING.' New (Pending)', 
		 CompanyTable::REJECTED =>  CompanyTable::REJECTED.' Rejected' )));
       
	   
	    $this->setValidator ( 'status', new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0,2,3,4))));
   
        $this->widgetSchema['sector_id']->setOption('query', Doctrine::getTable('Sector')->createQuery('s')->innerJoin('s.Translation'));
      
		$this->widgetSchema['city_id'] = new sfWidgetFormDoctrineJQueryAutocompleter(array(
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
				'city_id',
				new sfValidatorDoctrineChoice(array(
						'required' => false,
						'model' => 'City'
				)
				));
		
		
		$this->widgetSchema ['classification_id'] = new sfWidgetFormDoctrineJQueryAutocompleter ( array ('model' => 'Classification', 'url' => sfContext::getInstance ()->getController ()->genUrl ( array ('module' => 'company', 'action' => 'getClassifiersAutocomplete', 'route' => 'default' ) ), 'config' => ' {
          scrollHeight: 250,
          autoFill: false,
          cacheLength: 1,
          delay: 1,
          max: 10,
          minChars:0
       }' ) );
	 $this->widgetSchema ['is_modified'] = new sfWidgetFormChoice(array('choices' => array('' => '', '1' => 'modified by RUPA')));
     $this->setValidator ('is_modified', new sfValidatorChoice(array('required' => false, 'choices' => array('', 1))));
	 $this->widgetSchema ['bbp'] = new sfWidgetFormChoice(array('choices' => array('' => '', '1' => 'with BBP'))); 
	 $this->setValidator ('bbp', new sfValidatorChoice(array('required' => false, 'choices' => array('', 1))));
	 $this->widgetSchema ['with_order'] = new sfWidgetFormChoice(array('choices' => array('' => '', '1' => 'With Order'))); 
	 $this->setValidator ('with_order', new sfValidatorChoice(array('required' => false, 'choices' => array('', 1))));
	 $this->widgetSchema ['with_w_h'] = new sfWidgetFormChoice(array('choices' => array('' => '', '1' => 'With W Hours'))); 
	 $this->setValidator ('with_w_h', new sfValidatorChoice(array('required' => false, 'choices' => array('', 1))));
	 $this->widgetSchema ['with_w_h'] = new sfWidgetFormChoice(array('choices' => array('' => '', '1' => 'With W Hours'))); 
	 $this->setValidator ('with_w_h', new sfValidatorChoice(array('required' => false, 'choices' => array('', 1))));
	 $this->widgetSchema ['with_pics'] = new sfWidgetFormChoice(array('choices' => array('' => '', '2' => 'With Pics', '1' => 'With Pics All Admins', '3' => 'With Pics Getlokal Admin', '4' => 'With Pics Place Admin'))); 
	 $this->setValidator ('with_pics', new sfValidatorChoice(array('required' => false, 'choices' => array('', 1,2,3,4))));
	 $this->widgetSchema ['with_ans'] = new sfWidgetFormChoice(array('choices' => array('' => '', '1' => 'With Reply'))); 
	 $this->setValidator ('with_ans', new sfValidatorChoice(array('required' => false, 'choices' => array('', 1))));
	 $this->widgetSchema ['claim_status'] = new sfWidgetFormChoice(array('choices' => array('' => '', '1' => 'Page admin status approved', '2' => 'Page admin status pending', '3' => 'Page admin status rejected', '4' => 'All (Pending/ Rejected /Approved)'))); 
	 $this->setValidator ('claim_status', new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 2, 3, 4))));
	 $this->widgetSchema ['with_reviews'] = new sfWidgetFormChoice(array('choices' => array('' => '', '1' => 'With Reviews'))); 
	 $this->setValidator ('with_reviews', new sfValidatorChoice(array('required' => false, 'choices' => array('', 1))));
	
	 
	 
    $this->widgetSchema['referer']  =  new sfWidgetFormChoice(array('choices' => $this->getChoices()));
    $this->validatorSchema['referer']   = new sfValidatorChoice(array('required' => false, 'choices' => array_keys($this->getChoices())));
    
    $options = array('default' => 'default');
    if(getlokalPartner::getInstanceDomain() == getlokalPartner::GETLOKAL_BG){
    	$options['1'] = 'from other country';
    }
   	$this->widgetSchema ['country'] = new sfWidgetFormChoice(array('choices' => $options));
    $this->setValidator ('country', new sfValidatorChoice(array('required' => false, 'choices' => array_keys($options))));
	$this->widgetSchema['country']->setDefault('default');

}
  
	public function addEmailAddressColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'Company' )->applyEmailAddressFilter ( $query, $value );
		}
	}
	public function addFirstNameColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'Company' )->applyFirstNameFilter ( $query, $value );
		}
	}
	public function addLastNameColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'Company' )->applyLastNameFilter ( $query, $value );
		}
	}	
   public function addIsModifiedColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'Company' )->applyIsModifiedFilter ( $query, $value );
		}
	}
	
 public function addBBPColumnQuery($query, $field, $value) {
		if ($value != null) {
			Doctrine::getTable ( 'Company' )->applyBBPFilter ( $query, $value );
		}
	}
	
public function addWithWHColumnQuery($query, $field, $value) {
		if ($value != null) {
			Doctrine::getTable ( 'Company' )->applyWithWHFilter ( $query, $value );
		}
	}
public function addWithPicsColumnQuery($query, $field, $value) {
		if ($value != null) {
			Doctrine::getTable ( 'Company' )->applyWithPicsFilter ( $query, $value );
		}
	}
	
public function addWithAnsColumnQuery($query, $field, $value) {
		if ($value != null) {
			Doctrine::getTable ( 'Company' )->applyWithAnsFilter ( $query, $value );
		}
	}
public function addWithOrderColumnQuery($query, $field, $value) {
		if ($value != null) {
			Doctrine::getTable ( 'Company' )->applyWithOrderFilter ( $query, $value );
		}
	}
public function addClaimStatusColumnQuery($query, $field, $value) {
		if ($value != null) {
			Doctrine::getTable ( 'Company' )->applyClaimStatusFilter ( $query, $value );
		}
	}
	public function addWithReviewsColumnQuery($query, $field, $value) {
		if ($value != null) {
			Doctrine::getTable ( 'Company' )->applyWithReviewsFilter ( $query, $value );
		}
	}
public function addRefererColumnQuery($query, $field, $value) {
		if ($value != null) {
			Doctrine::getTable ( 'Company' )->applyRefererFilter ( $query, $value );
		}
	}

	public function addCountryColumnQuery($query, $field, $value) {
		if ($value != null) {
			Doctrine::getTable ( 'Company' )->applyCountryFilter ( $query, $value );
		}
	}
	public function addTitleColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'Company' )->applyTitleFilter ( $query, $value );
		}
	}
	
  public function getFields() {
		$fields = parent::getFields ();
		$fields ['email_address'] = 'email_address';
		$fields ['first_name'] = 'first_name';
		$fields ['last_name'] = 'last_name';	
		$fields ['is_modified'] = 'is_modified';
		$fields ['bbp'] = 'bbp';	
		$fields ['with_order'] = 'with_order';
		$fields ['with_w_h'] = 'with_w_h';
		$fields ['with_pics'] = 'with_pics';
		$fields ['with_ans'] = 'with_ans';
		$fields ['claim_approved'] = 'claim_approved';
		$fields ['with_reviews'] = 'with_reviews';
		$fields ['country'] = 'country';
		$fields ['title'] = 'title';
		return $fields;
	}
	
protected function getChoices($sector_id=null) {
		$choices = array ();
		
		
			
	$dql = Doctrine_Query::create ()->select ( 'referer' )->from ( 'Company c' )->addGroupBy('c.referer');
	
		
		
		$this->rows = $dql->execute ();
		
		if ($this->rows) {
			foreach ( $this->rows as $row ) {
				$choices [$row ['referer']] = $row ['referer'];
			
			}
		}
		
		return $choices;
	}
}
