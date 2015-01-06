<?php

/**
 * Event form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EventBgForm extends EventForm
{
  public function configure()
  {
  	$i18n = sfContext::getInstance()->getI18N();
  	unset(
      $this['id'],    
      $this['created_at'],
      $this['updated_at'],
      $this['user_id'],
      $this['country_id']
    ); 
    
  	 
	$this->setWidgets(array(
      'start_at'    => new sfWidgetFormInput(),
      'end_at'      => new sfWidgetFormInputText(),
      'category_id' => new sfWidgetFormChoice(array('choices' => Event::getEventCategoryChooseList() ) ),
      'info_url'    => new sfWidgetFormInputText(),
      'buy_url'     => new sfWidgetFormInputText(),
      //'price'       => new sfWidgetFormInputText(),
      //'location_id' => new sfWidgetFormInputText(),
      //'country_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => true)),
      'type'        => new sfWidgetFormInputText(),
	  'file' =>  new sfWidgetFormInputFile(),
    ));
	
     $this->widgetSchema['location_id']=new sfWidgetFormDoctrineJQueryAutocompleter(array(
      'model' => 'City', 
      'method' =>'getLocation',                 
      'url' => sfContext::getInstance()->getController()->genUrl ( array('module' => 'user', 'action' => 'getCitiesAutocomplete', 'route' => 'default') ),          
      'config' => ' {
        scrollHeight: 250,
        autoFill: false,
        cacheLength: 1,
        delay: 1,
        max: 10,
        minChars:0
      }' 
    ));
    
    $this->widgetSchema['start_at']->setAttribute('class', 'date');
    $this->widgetSchema['start_at']->setAttribute('type', 'date');
    $this->widgetSchema['end_at']->setAttribute('class', 'date');
    $this->widgetSchema['end_at']->setAttribute('type', 'date');

    $this->widgetSchema['place_id'] = new sfWidgetFormDoctrineChoice(array('model' => 'CompanyPage', 'multiple' => true));
	
    
    if (!$this->isNew()){
    	if ($this->getObject()->getStartAt())$this->widgetSchema['start_at']->setAttribute('value', date('d/m/Y',strtotime( $this->getObject()->getStartAt() ) ) );
	    if ($this->getObject()->getEndAt())$this->widgetSchema['end_at']->setAttribute('value', date('d/m/Y',strtotime( $this->getObject()->getEndAt() ) ) );
    }else {
    	$this->widgetSchema['start_at']->setAttribute('value', date('d/m/Y',strtotime( 'now' ) ) );
	    //$this->widgetSchema['end_at']->setAttribute('value', date('d/m/Y',strtotime( 'now' ) ) );
    }
    
    
    
    $this->widgetSchema['price'] = new sfWidgetFormChoice( 
			array (
				'expanded' => false
				, 'choices' => Event::getEventPriceChoicesList()
			) 
	);
	
 
    $this->setValidators(array(
      'start_at'    => new sfValidatorDate(array('date_format' => '~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4})~','required' => false)),
      'end_at'      => new sfValidatorDate(array('date_format' => '~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4})~','required' => false)),
      'category_id' => new sfValidatorChoice(array('required' => false,'choices' => Event::getEventCategoryPosibleChoises() )),
      'info_url'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'buy_url'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'price'       => new sfValidatorChoice( array ('required' => false,'choices' => Event::getPosibleEventPriceChoicesList() ),
														  array ('invalid' => $i18n->__('The field is mandatory', null, 'errors') )
														 ),
      'location_id' => new sfValidatorInteger(array('required' => false)),
      //'country_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'required' => false)),
      'type'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
	  'file' 		=> new sfValidatorFile(array( 'mime_types' => 'web_images', 'required' => false)),
	  'place_id'	=> new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'CompanyPage', 'multiple' => true))
    ));
	$this->validatorSchema->setOption ( 'allow_extra_fields', true );
  	$this->validatorSchema->setOption ( 'filter_extra_fields', true );
  	//$this->setWidget('file', new sfWidgetFormInputFile());
    //$this->setValidator('file', new sfValidatorFile(array(
	//  'mime_types' => 'web_images'
	//)));
	
  	$this->embedI18n(array('en', 'bg'));
    $this->widgetSchema->setNameFormat('event[%s]');
    
   
  }
	protected function getCulture() {
		return isset($this->options['culture']) ? $this->options['culture'] : sfContext::getInstance()->getUser()->getCulture();
	}

	public function processUploadedFile($field, $file = null, $values = null)
    {
      return true;
    }
}
