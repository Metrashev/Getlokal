<?php

/**
 * Lists form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ListsForm extends BaseListsForm
{
public function configure()
  {
  	$i18n = sfContext::getInstance()->getI18N();
  	unset(
      $this['id'],    
      $this['created_at'],
      $this['updated_at'],
      $this['user_id'],
      $this['is_active']
    ); 
    if (!$this->isNew()){
     $this->widgetSchema['location_id']=new sfWidgetFormDoctrineJQueryAutocompleter(array(
      'model' => 'City', 
      'method' =>'getLocation',                 
      'url' => sfContext::getInstance()->getController()->genUrl ( array('module' => 'company', 'action' => 'autocompleteCity') ),          
      'config' => ' {
        scrollHeight: 250,
        autoFill: false,
        cacheLength: 1,
        delay: 1,
        max: 10,
        minChars:0
      }' 
    ));
    
    $this->widgetSchema['place_id'] = new sfWidgetFormDoctrineChoice(array('model' => 'CompanyPage', 'multiple' => true));
   
 
    $this->setValidators(array(
      'location_id' => new sfValidatorInteger(array('required' => true), array('required'=>'The field is mandatory')),
	  'place_id'	=> new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'CompanyPage', 'multiple' => true), array('required'=>'The field is mandatory')),
    ));
    }
    
    $this->widgetSchema['is_open'] = new sfWidgetFormInputCheckbox();
    $this->widgetSchema['caption'] = new sfWidgetFormInputText();
	$this->widgetSchema['file'] = new sfWidgetFormInputFile();
	
    $this->setValidators(array(
	  'is_open'    => new sfValidatorBoolean(array('required' => false)),
      'caption'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
	  'file' 		=> new sfValidatorFile(
	  		array( 
	  			'mime_types' => 'web_images', 
	  			'required' => false,
	  			'max_size' => 4*1024*1024), 
	  		array( 
	  			'mime_types' => $i18n->__('The file you submitted is not in a valid format. Please upload a JPG, GIF or PNG image file.'),
	  			'max_size' => $i18n->__('File size limit is 4MB.Please reduce file size before submitting again.'))),
    ));
    
	$this->validatorSchema->setOption ( 'allow_extra_fields', true );
  	$this->validatorSchema->setOption ( 'filter_extra_fields', true );
	$this->setDefault('location_id', sfContext::getInstance()->getUser()->getCity()->getId());
  	
	$culture = sfContext::getInstance()->getUser()->getCountry()->getSlug();
  	$this->embedI18n(array('en', $culture));

  	$this->widgetSchema->setNameFormat('list[%s]');

	$this->widgetSchema->setLabels(
			array(
				
				'location_id' => 'City/Town',// null, 'profile').'*' ,
				'place_id' => 'Venue name',// null, 'profile'),
				'price' => 'Price',// null, 'profile'),
				'is_open' => 'Open List',
				'file' =>  'Add Photo'
				//'is_public'=> $i18n->__('If you want this event to be visible to registered users only, uncheck the box.', null, 'profile'),
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
