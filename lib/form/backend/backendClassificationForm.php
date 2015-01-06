<?php

/**
 * Company form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class backendClassificationForm extends BaseClassificationForm
{
  public function configure()
  {
 
  	unset(
      $this['id'],
      $this['category_id'],
      $this['classification_id'],
      $this['sector_id'],
      $this['created_at'],
      $this['updated_at']
      );
      $this->setWidget ( 'status',new sfWidgetFormChoice(array('choices' => array('1' => 'approved', '0' => 'pending', '2' => 'rejected'))));
	  $this->setValidator ( 'status', new sfValidatorChoice(array('choices' => array(1, 0 , 2), 'required' => true)));
		
	//  $classification_sectors_form = new ClassificationSectorsForm(null, array('classification'=>$this->getObject()));
	//  $this->embedForm('classification_sectors', $classification_sectors_form);
  	  
	  
	   $classification_sectors = $this->getObject()->getClassificationSector ();
		$newClassifierSectorForm = new BaseForm ();
		$i = 0;
		if (count ( $classification_sectors ) > 1) {
			foreach ( $classification_sectors as $classification_sector ) {
				$i ++;
				$form = new ClassificationSectorForm ( $classification_sector, array ('default' => false ) );
				$newClassifierSectorForm->embedForm ( $i, $form );
			
			}
		
		} elseif (count ( $classification_sectors ) == 1) {
			
			$classification_sector = $classification_sectors [0];
			$newClassifierSectorForm->embedForm ( 1, new ClassificationSectorForm ( $classification_sector, array ('default' => true ) ) );
		}else {
			$classification_sector = new ClassificationSector();
			$form = new ClassificationSectorForm ( $classification_sector, array ('default' => false ) );
			$newClassifierSectorForm->embedForm ( 1, $form );
			
		}
		$this->embedForm ( 'sectors', $newClassifierSectorForm );
		
		
	  
	  $this->embedI18n(array('bg', 'ro', 'mk', 'en', 'sr', 'fi', 'ru', 'hu', 'pt', 'fr', 'de', 'es', 'me'));
  	  
  
  }
  

public function bind(array $taintedValues = null, array $taintedFiles = null) {
		
		foreach ( $this->embeddedForms ['sectors']->getEmbeddedForms () as $key => $classaddForm ) {
			if (! isset ( $taintedValues ['sectors'] [$key] ['sector_id'] ) or is_null ( $taintedValues ['sectors'] [$key] ['sector_id'] ) or strlen ( $taintedValues ['sectors'] [$key] ['sector_id'] ) === 0) {
				
				$classaddForm->getObject ()->delete ();
				unset ( $this->embeddedForms ['sectors']->embeddedForms [$key], $taintedValues ['sectors'] [$key] );
			}
		}
		foreach ( $taintedValues ['sectors'] as $key => $newClassifier ) {
			if (! isset ( $this ['sectors'] [$key] )) {
				if ($taintedValues ['sectors'] [$key] ['sector_id'] && $taintedValues ['sectors'] [$key] ['sector_id'] != NULL && $taintedValues ['sectors'] [$key] ['sector_id'] != '') {
					
					$this->addClassificationSector ( $key );
				} else {
					
					unset ( $this->embeddedForms ['sectors']->embeddedForms [$key], $taintedValues ['sectors'] [$key] );
				
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
		
		foreach ( $this->embeddedForms ['sectors']->getEmbeddedForms () as $classaddForm ) {
			
			if (! $classaddForm->getObject ()->getClassificationId ()) {
				$classaddForm->getObject ()->setClassificationId ($this->getObject()->getId () );
			
			}
		}
		
		parent::saveEmbeddedForms ( $con, $forms );
	
	}
	
	public function save($con = null) {
		
		$values = $this->getValues ();
		
		foreach ( $this->embeddedForms ['sectors']->getEmbeddedForms () as $key => $classaddForm ) {
		
			if ($values ['sectors'] [$key] ['sector_id']) {
				if ($key == 1) {
					
					
					$this->getObject()->setSectorId ( $values ['sectors'] [1] ['sector_id'] );
					
					
				
				}
				// only save todos that aren't blank
				$classaddForm->updateObject ( $values ['sectors'] [$key] );
				$classaddForm->getObject ()->setClassificationId ($this->getObject()->getId () );
				$classaddForm->getObject ()->save ();
			
			} elseif (! $classaddForm->getObject ()->isNew ()) {
				// delete any existing todos that are now blank
				
				$classaddForm->getObject ()->delete ();
			}
		}
		parent::save();	
	return $this->getObject();
	}
	public function addClassificationSector($num) {
		
		$classification = new ClassificationSector ();
		$classification->setClassificationId ( $this->getObject()->getId () );
		$class_form = new ClassificationSectorForm ( $classification, array ('default' => false ) );
		//Embedding the new classifier in the container
		$this->embeddedForms ['sectors']->embedForm ( $num, $class_form );
		
		$this->embedForm ( 'sectors', $this->embeddedForms ['sectors'] );
	} 
}
