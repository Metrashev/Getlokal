<?php

/**
 * Contact form.
 *
 * @package    localcocal
 * @subpackage form
 * @author     Inkata
 */
class ListCompanytForm extends BaseForm {
	
	public function configure() {
		
		$this->widgetSchema['list']=new sfWidgetFormDoctrineJQueryAutocompleter(array(
  			'model' => 'Lists',
  			//'method' =>'getTitle',
  			//'url' => sfContext::getInstance()->getController()->genUrl ( array('module' => 'company', 'action' => 'getListsAutocomplete', 'route' => 'default') ),
				'url' => sfContext::getInstance()->getController()->genUrl ( 'company/getListsAutocomplete?pageId='.$this->getOption('page_id') ),
			'config' => ' {
        scrollHeight: 250,
        autoFill: false,
        cacheLength: 1,
        delay: 1,
        max: 11,
        minChars:0
      }'
  	));
		
		$this->widgetSchema->setNameFormat ( 'list_copany[%s]' );
		
		
		//$this->disableLocalCSRFProtection ();
		$this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
	}
	

	
}
