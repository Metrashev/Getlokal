<?php

/**
 * CompanyDetail form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CompanyDescriptionForm extends BaseCompanyForm {
	
	public function configure() {
                $i18n = sfContext::getInstance()->getI18N();
		$features = Doctrine_Query::create ()->select ( 'id, t.name' )->from ('FeatureCompany fc')->innerJoin ( 'fc.Translation t' )->execute();
		//var_dump($thumbanils);exit();
		//array('1'=>1,'2'=>1,'3'=>1,'4'=>0,'5'=>0,'6'=>0,'7'=>0,'8'=>0,'9'=>0,'10'=>0,'11'=>0,'12'=>0,);
		
                $culture = sfContext::getInstance()->getUser()->getCountry()->getSlug();
                $cultures = sfConfig::get('app_languages_'.$culture);


		$this->setWidgets ( array (
		'outdoor_seats' => new sfWidgetFormInputText ( array (), array ('maxlength' => 30 ) ),
		'indoor_seats' => new sfWidgetFormInputText ( array (), array ('maxlength' => 30 ) ),
		'wifi_access'      => new sfWidgetFormChoice( array('multiple' => false, 'expanded' => true, 'choices' => array('0'=>$i18n->__('Free'), '1'=>$i18n->__('Paid')) )),
		  ) );

		$this->setDefault('outdoor_seats', $this->getObject()->getCompanyDetail()->getOutdoorSeats());
		$this->setDefault('indoor_seats', $this->getObject()->getCompanyDetail()->getIndoorSeats());
		$this->setDefault('wifi_access', $this->getObject()->getCompanyDetail()->getWifiAccess());
		//$seats = array('outdoor_seats'=>$this->getObject()->getCompanyDetail()->getOutdoorSeats(),'indoor_seats'=>$this->getObject()->getCompanyDetail()->getIndoorSeats());
		
		if($this->getObject()->getActivePPPService(true) || $this->getObject()->getRegisteredPPPService(true)){
			$this->widgetSchema['feature_company_list']  = new sfWidgetFormDoctrineChoice(array(
					'multiple' => true, 
					'expanded' => true, 
					'model' => 'FeatureCompany',
					'renderer_class' => new sfWidgetFormMySelectWithThumbs(array('choices'=> $features,))
					));
		}
		
		$this->setValidators ( array (
		 'outdoor_seats' => new sfValidatorInteger(array('required' => false)),
		 'indoor_seats' => new sfValidatorInteger(array('required' => false)) ) );

                $class = 'CompanyDescriptionTranslationForm';
                foreach ($cultures as $culture)
                {
                    $i18nObject = $this->getObject()->Translation[$culture];

                    $i18n = new $class($i18nObject);

                    if (false === $i18nObject->exists())
                    {
                        unset($i18n[$this->getI18nModelPrimaryKeyName()], $i18n[$this->getI18nModelI18nField()]);
                    }

                    $this->embedForm($culture, $i18n, null);
                }

		$this->validatorSchema->setOption ( 'allow_extra_fields', true );
		$this->validatorSchema->setOption ( 'filter_extra_fields', false );
		$this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );
		$this->widgetSchema->setNameFormat('descriptions[%s]');   
	}
	public function save($con = null) {	
		
	 parent::save();
	 
      $company_detail = $this->getObject()->getCompanyDetail();      
    
     // if ((isset($this->values['content']) && $this->values['content']!='') || (isset($this->values['content_en']) && $this->values['content_en']!='')
      	//	|| (isset($this->values['outdoor_seats']) && $this->values['outdoor_seats']!='') || (isset($this->values['indoor_seats']) && $this->values['indoor_seats']!='')
      if ((isset($this->values['outdoor_seats']) && $this->values['outdoor_seats']!='') || (isset($this->values['indoor_seats']) && $this->values['indoor_seats']!='')
      		|| (isset($this->values['wifi_access']) && $this->values['wifi_access']!=''))
      {
	      //$company_detail->setContent($this->values['content']);
		 // $company_detail->setContentEn($this->values['content_en']);
		  $company_detail->setOutdoorSeats($this->values['outdoor_seats']);
		  $company_detail->setIndoorSeats($this->values['indoor_seats']);
		  $company_detail->setWifiAccess($this->values['wifi_access']);
		  $company_detail->save();
      }

      
	 }
}
