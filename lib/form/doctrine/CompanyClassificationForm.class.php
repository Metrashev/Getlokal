<?php

/**
 * CompanyClassification form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CompanyClassificationForm extends BaseCompanyClassificationForm {
	public function configure() {
		unset ( $this ['id'], $this ['company_id'] );
		
		$this->widgetSchema ['sector_id'] = new sfWidgetFormDoctrineChoice ( array ('model' => 'Sector', 'add_empty' => true) );
		$this->setValidator ( 'sector_id', new sfValidatorDoctrineChoice ( array ('model' => 'Sector', 'required' => false ) ) );
		
		if (! $this->getObject ()->isNew ()) {
			
			
			if ($this->options ['default'] == true) {
				$this->setDefault ( 'sector_id', $this->getObject ()->getCompany ()->getSectorId ());
			    $choices = $this->updateChoices ( $this->getObject ()->getCompany ()->getSectorId () );
			
			} else {
				$this->setDefault ( 'sector_id', $this->getObject ()->getClassification ()->getSectorId ()  );
				$choices = $this->updateChoices ( $this->getObject ()->getClassification ()->getSectorId ()  );
			
			}
			$this->setDefault ( 'classification_id', $this->getObject ()->getCompany ()->getClassificationId () );
		} else {
			$choices = $this->updateChoices ();
		}
		$this->widgetSchema ['classification_id'] = new sfWidgetFormChoice ( array ('choices' => array ($choices ) ) );
		
		$this->widgetSchema->setLabels ( array ('sector_id' => 'Category', 'classification_id' => 'Classification' ) );
		
		$this->validatorSchema->setOption ( 'allow_extra_fields', true );
		$this->validatorSchema->setOption ( 'filter_extra_fields', false );
		$this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
	}
	protected function updateChoices($sector_id=null) {
		$choices = array ();
		
		if ($sector_id) {
			
			$dql = Doctrine_Query::create ()->select ( 'id, t.title' )->from ( 'Classification c' )->innerJoin ( 'c.Translation t' )->leftJoin ( 'c.ClassificationSector cs' )->where ( 'cs.sector_id = ? AND c.status = ?', array ($sector_id, 1 ) );
		} else {
			
			$dql = Doctrine_Query::create ()->select ( 'id, t.title' )->from ( 'Classification c' )->innerJoin ( 'c.Translation t' )->where ( 'c.status = ?', 1 );
		}
		
		
		$this->rows = $dql->execute ();
		
		if ($this->rows) {
			foreach ( $this->rows as $row ) {
				$choices [$row ['id']] = $row ['title'];
			
			}
		}
		
		return $choices;
	}
}

