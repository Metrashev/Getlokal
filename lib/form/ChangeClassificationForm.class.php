<?php
class ChangeClassificationForm extends BaseForm {
	public function configure() {
		if (sfContext::getInstance ()->getRequest ()->isXmlHttpRequest ()) {
			$index = sfContext::getInstance ()->getRequest ()->getParameter ( 'embedded_index' );
			$name = "classifications[orderclass][".$index."][classification_id]";
						
			$choices = $this->updateChoices ( sfContext::getInstance ()->getRequest ()->getParameter ( 'sector_id' ) );
			$this->disableLocalCSRFProtection();
			$this->widgetSchema [$name] = new sfWidgetFormChoice ( array ('choices' => $choices ) );
			$this->widgetSchema->setLabels ( array ( $name => 'Classification' ) );
		
			$this->validatorSchema [$name] = new sfValidatorChoice ( array ('choices' => array_keys ( $choices ) ) );
		    $this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
		}
	}
	protected function updateChoices($sector_id) {
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