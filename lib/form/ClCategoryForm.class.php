<?php
class ClCategoryForm extends CategoryForm {
        
        public function configure() {
        	$this->setWidgets(array(
        			'sector' => new sfWidgetFormDoctrineChoice(array('expanded' => false,'multiple' => false, 'model' => 'Sector', 'add_empty'=>true )),
        			'classification_list' => new sfWidgetFormDoctrineChoice(array('expanded' => true,'multiple' => true, 'model' => 'Classification')),
        	));
        	$this->setValidators(array(
        			'sector' => new sfValidatorPass(), //sfValidatorDoctrineChoice(array('multiple' => false, 'model' => 'Country', 'required' => false)),
        			'classification_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Classification', 'required' => false)),
        	));
        	
        	$this->validatorSchema->setOption ( 'allow_extra_fields', true );
        	$this->validatorSchema->setOption ( 'filter_extra_fields', true );
        	
        	$this->widgetSchema->setNameFormat('event_article[%s]');
        }
}