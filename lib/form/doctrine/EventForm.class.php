<?php

/**
 * Event form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class EventForm extends BaseEventForm
{
public function configure()
  {
  	$i18n = sfContext::getInstance()->getI18N();
  	unset(
      $this['id'],
      $this['created_at'],
      $this['updated_at'],
      $this['user_id']
    );


	$this->setWidgets(array(
      'start_at'    => new sfWidgetFormInput(),
      'end_at'      => new sfWidgetFormInputText(),
	  'start_h'        => new sfWidgetFormChoice(array('choices' => Event::EventTimeChoises() ) ),
      'category_id' => new sfWidgetFormChoice(array('choices' => Event::getEventCategoryChooseList())),
      'info_url'    => new sfWidgetFormInputText(),
      'buy_url'     => new sfWidgetFormInputText(),
      //'price'       => new sfWidgetFormInputText(),
      //'location_id' => new sfWidgetFormInputText(),
      'country_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'add_empty' => true)),
      'type'        => new sfWidgetFormInputText(),
	  'caption'        => new sfWidgetFormInputText(),
	  'file' =>  new sfWidgetFormInputFile(),
	  'poster' =>  new sfWidgetFormInputCheckbox(),

	));

     $this->widgetSchema['location_id']=new sfWidgetFormDoctrineJQueryAutocompleter(array(
      'model' => 'City',
      'method' =>'getLocation',
      'url' => sfContext::getInstance()->getController()->genUrl ( array('module' => 'company', 'action' => 'autocompleteCity') ),
      'config' => ' {
        scrollHeight: 250,
        autoFill: false,
        cacheLength: 1,
        delay: 1,
        max: 11,
        minChars:0
      }'
    ));

    //$this->widgetSchema['start_h']->addOption('minutes', array('0,15,45') );
    $this->widgetSchema['start_at']->setAttribute('class', 'date');
    //$this->widgetSchema['start_at']->setAttribute('type', 'date');
    $this->widgetSchema['end_at']->setAttribute('class', 'date');
    //$this->widgetSchema['end_at']->setAttribute('type', 'date');

    $this->widgetSchema['place_id'] = new sfWidgetFormDoctrineChoice(array('model' => 'CompanyPage', 'multiple' => true));


    if (!$this->isNew()){
    	if ($this->getObject()->getStartAt())$this->widgetSchema['start_at']->setAttribute('value', date('d/m/Y',strtotime( $this->getObject()->getStartAt() ) ) );
	    if ($this->getObject()->getEndAt())$this->widgetSchema['end_at']->setAttribute('value', date('d/m/Y',strtotime( $this->getObject()->getEndAt() ) ) );

    }else {
    	$this->widgetSchema['start_at']->setAttribute('value', date('d/m/Y',strtotime( 'now' ) ) );
//	    $this->widgetSchema['end_at']->setAttribute('value', date('d/m/Y',strtotime( 'now' ) ) );
    }



    $this->widgetSchema['price'] = new sfWidgetFormChoice(
			array (
				'expanded' => false
				, 'choices' => Event::getRealPrice()
			)
	);


    $this->setValidators(array(
      'start_at'    => new sfValidatorDate(array('date_format' => '~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4})~','required' => true), array('required'=>'The field is mandatory') ),
      'end_at'      => new sfValidatorDate(array('date_format' => '~(?P<day>\d{2})/(?P<month>\d{2})/(?P<year>\d{4})~','required' => false)),
      'start_h'     => new sfValidatorTime(array('required' => false)),
      'category_id' => new sfValidatorChoice(array('required' => true,'choices' => Event::getEventCategoryPosibleChoises() ), array('required'=>'The field is mandatory')),
      'info_url'    => new sfValidatorUrl(array('max_length' => 255, 'required' => false), array('invalid' => 'Invalid format.')),
      'buy_url'     => new sfValidatorUrl(array('max_length' => 255, 'required' => false), array('invalid' => 'Invalid format.')),
      'price'       => new sfValidatorChoice( array ('required' => false,'choices' => array_keys(Event::getRealPrice()) ),
														  array ('invalid' => $i18n->__('The field is mandatory', null, 'errors') )
														 ),
      'location_id' => new sfValidatorInteger(array('required' => true), array('required'=>'The field is mandatory')),
      'country_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Country'), 'required' => false)),
      'type'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
	  'caption'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
	  'file' 		=> new sfValidatorFile(
	  				array( 'mime_types' => 'web_images', 'required' => false, 'max_size' => '2097152'), 
	  				array( 'max_size' => 'File size limit is 2MB.Please reduce file size.','mime_types' => 'The file you submitted is not in a valid format. Please upload a JPG, GIF or PNG image file.')	  		
	  		),
	  'place_id'	=> new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'CompanyPage', 'multiple' => true), array('required'=>'The field is mandatory')),
      'poster' => new sfValidatorBoolean(),
	));
	$this->validatorSchema->setOption ( 'allow_extra_fields', true );
  	$this->validatorSchema->setOption ( 'filter_extra_fields', true );
  	//$this->setWidget('file', new sfWidgetFormInputFile());
    //$this->setValidator('file', new sfValidatorFile(array(
	//  'mime_types' => 'web_images'
	//)));
	 $this->setDefault('location_id', sfContext::getInstance()->getUser()->getCity()->getId());

	$culture = sfContext::getInstance()->getUser()->getCountry()->getSlug();
  	$this->embedI18n(array('en', $culture));
  	//$this->getEmbeddedForm('en')->getValidator('title')->setOption('required', false);
  	//$this->getEmbeddedForm('en')->getValidator('description')->setOption('required', false);
    $this->widgetSchema->setNameFormat('event[%s]');

	$this->widgetSchema->setLabels(
			array(
				//'title' =>  $i18n->__('Event Name', null, 'profile') .'*',
			    //'description' => $i18n->__('Event Description', null, 'profile') .'*',
				'start_at' => 'When',// null, 'events') .'*',
				'end_at' => 'End Date',// null, 'profile'),
			    'start_h' => 'Start Time',// null, 'events') .'*',
				'location_id' => 'City/Town',// null, 'profile').'*' ,
				'place_id' => 'Venue name',// null, 'profile'),
				'info_url' => 'More Info (add link)',// null, 'profile'),
				'buy_url' => 'Buy ticket/book (add link)',// null, 'profile'),
				'price' => 'Price',// null, 'profile'),
				'category_id' => 'Event Type',// null, 'profile') .' *',
				//'is_public'=> $i18n->__('If you want this event to be visible to registered users only, uncheck the box.', null, 'profile'),
				'file' =>  'Add Photo',// null, 'reviews'),
				'caption' => 'Photo caption',
				'poster' => 'Poster size',
			)    );

   	$this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
  }
	protected function getCulture() {
		return isset($this->options['culture']) ? $this->options['culture'] : sfContext::getInstance()->getUser()->getCulture();
	}

	public function processUploadedFile($field, $file = null, $values = null)
    {
      return true;
    }
}
