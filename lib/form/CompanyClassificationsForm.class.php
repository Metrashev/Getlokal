<?php
class CompanyClassificationsForm extends BaseForm {
	public function configure() {
		
		$company_classifications = $this->options ['company']->getCompanyClassification ();
		$classifications = array ();		
		$newClassifierForm = new BaseForm ();
		$i = 0;
		if (count ( $company_classifications ) > 1) {
			foreach ( $company_classifications as $company_classification ) {
				$i ++;
				$form = new CompanyClassificationForm ( $company_classification, array ('default' => false ) );
				$newClassifierForm->embedForm ( $i, $form );
			
			}
			
		} else {
			
			$company_classification = $company_classifications [0];			
			$newClassifierForm->embedForm ( 1, new CompanyClassificationForm ( $company_classification, array ('default' => true ) ) );
		}
		$this->embedForm ( 'orderclass', $newClassifierForm );
		$this->widgetSchema->setNameFormat ( 'classifications[%s]' );
	}
	
	
public function bind(array $taintedValues = null, array $taintedFiles = null) {

      foreach($this->embeddedForms['orderclass']->getEmbeddedForms() as $key=>$classaddForm)
    {       
       if (!isset($taintedValues['orderclass'][$key]['classification_id']) 
       or is_null($taintedValues['orderclass'][$key]['classification_id']) 
       or strlen($taintedValues['orderclass'][$key]['classification_id']) === 0)
       {
    
         
          $classaddForm->getObject()->delete();
         unset($this->embeddedForms['orderclass']->embeddedForms[$key], $taintedValues['orderclass'][$key]); 
       }
    }
       foreach($taintedValues['orderclass'] as $key=>$newClassifier)
      {
      	if (!isset($this['orderclass'][$key]))
        {
              if ($taintedValues['orderclass'][$key]['classification_id'] &&
              $taintedValues['orderclass'][$key]['classification_id'] != NULL && 
              $taintedValues['orderclass'][$key]['classification_id']!= '') {
              
              $this->addCompanyClassification($key);}
             else 
             { 
                
                unset($this->embeddedForms['orderclass']->embeddedForms[$key], $taintedValues['orderclass'][$key]);
        
          
          }
         
        }
    }
      
	
    
	
		parent::bind ( $taintedValues, $taintedFiles );
	}
	
	/**
	 * Saves embedded form objects.
	 *
	 * @param PropelPDO $con   An optional PropelPDO object
	 * @param array     $forms An array of forms
	 */
	
	public function saveEmbeddedForms($con = null, $forms = null, $taintedValues = null, $taintedFiles = null) {
		
		if (is_null ( $con )) {
			$con = $this->getConnection ();
		}
		
		foreach ( $this->embeddedForms ['orderclass']->getEmbeddedForms () as $classaddForm ) {
			
			if (! $classaddForm->getObject ()->getCompanyId ()) {
				$classaddForm->getObject ()->setCompanyId ( $this->options ['company']->getId () );
			
			}
		}
		
		 parent::saveEmbeddedForms($con, $forms);
	
	}
	
	public function save($con = null) {
		
		$values = $this->getValues ();
		
		foreach ( $this->embeddedForms ['orderclass']->getEmbeddedForms () as $key => $classaddForm ) {
			if ($values ['orderclass'] [$key] ['classification_id']) {	
				if ($key == 1)	
				{
				$this->options ['company']->setSectorId($values ['orderclass'] [1] ['sector_id']);
				$this->options ['company']->setClassificationId($values ['orderclass'] [1] ['classification_id']);	
				
		        if ($this->options ['company']->getStatus() == CompanyTable::INVISIBLE_NO_CLASS){
		        	$this->options ['company']->setStatus(CompanyTable::VISIBLE);
		        }
				$this->options ['company']->save();
				 
				$pageadmin = sfContext::getInstance ()->getUser()->getPageAdminUser();
				
				$msg = array('user'=>($pageadmin ? $pageadmin : sfContext::getInstance ()->getUser()->getGuardUser()) , 'object'=>'company', 'action'=>'classification', 'object_id'=>$this->options ['company']->getId());      
			    sfProjectConfiguration::getActive()->getEventDispatcher()->notify(new sfEvent($msg, 'user.write_log'));
          
				
				}		
				// only save todos that aren't blank
				$classaddForm->updateObject ( $values ['orderclass'] [$key] );
				$classaddForm->getObject ()->setCompanyId ( $this->options ['company']->getId () );
				$classaddForm->getObject ()->save ();
				
				
			} elseif (! $classaddForm->getObject ()->isNew ()) {
				// delete any existing todos that are now blank
				$classaddForm->getObject ()->delete ();
			}
		}
	
	}
public function addCompanyClassification($num) {	
	
		$classification = new CompanyClassification ();
		$classification->setCompanyId ( $this->options ['company']->getId () );		
		$class_form = new CompanyClassificationForm ( $classification, array ('default' => false ) );
		//Embedding the new classifier in the container
		$this->embeddedForms ['orderclass']->embedForm ( $num, $class_form );
		
		$this->embedForm ( 'orderclass', $this->embeddedForms ['orderclass'] );
	}

}
?>