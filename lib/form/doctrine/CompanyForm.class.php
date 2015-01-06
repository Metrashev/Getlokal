<?php

  /**
  * Company form.
  *
  * @package    getLokal
  * @subpackage form
  * @author     Get Lokal
  * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
  */
  class CompanyForm extends BaseCompanyForm
  {
    public function configure()
    {
      unset($this['id'],$this ['referer'], $this['created_at'],$this['updated_at']);

      $this->widgetSchema['sector_id']        = new sfWidgetFormDoctrineChoice(array('model' => 'Sector', 'add_empty' => true));
      $this->validatorSchema [ 'sector_id' ]  = new sfValidatorDoctrineChoice(
        array('model' => 'Sector', 'required' => true),
        array ('required' => 'The field is mandatory', 'invalid' => 'Invalid Sector' )
      );
/*
      $this->validatorSchema['title'] = new sfValidatorString(
        array('max_length'=>255, 'min_length'=>2, 'required' => true, 'trim' => true ),
        array(
          'required' => 'The field is mandatory',
          'max_length' => 'The field cannot contain more than %max_length% characters.'
      ));


      $this->validatorSchema['title_en'] = new sfValidatorAnd(array(
        new sfValidatorString(array('required'=>false, 'max_length'=>255, 'trim' => true), array(
          'max_length' => 'The field cannot contain more than %max_length% characters.'
        )),
        new sfValidatorRegex(array('pattern' => "/^[a-zA-Z0-9]([a-zA-Z0-9-'()+ ,.!&?;]+)$/"),
          array('invalid' => 'The place name in English has to be written with Latin characters')),

        ),array('required'=> false)
      );
*/
      $choices = $this->getChoices ( $this->object->sector_id);
      $this->widgetSchema['classification_id']   = new sfWidgetFormChoice(array('choices' => array($choices)));
      $this->validatorSchema['classification_id'] =new sfValidatorDoctrineChoice(
        array('model' => 'Classification', 'required' => true),
        array ('required' => 'The field is mandatory', 'invalid' => 'Invalid Classification' )
      );
      $this->widgetSchema->setLabels ( array (
        'company_type'      => 'Select company type',
        'city_id'           => 'Location',
        'sector_id'         => 'Category',
        'classification_id' => 'Classification',
        'website_url'       => 'Website',
        'facebook_url'      => 'Facebook Page',
        'googleplus_url'      => 'Google+ Page',
        'foursquare_url'      => 'Foursquare',
        'twitter_url'      => 'Twitter',
        'email'             => 'E-mail' ,
        'phone'             => 'Phone',
        'phone1'             => 'Phone',
        'phone2'             => 'Phone')
      );


      $this->widgetSchema ['city_id'] = new sfWidgetFormDoctrineJQueryAutocompleter ( array ('model' => 'City', 'method' => 'getLocation', 'url' => sfContext::getInstance ()->getController ()->genUrl ( array ('module' => 'company', 'action' => 'companyCity', 'route' => 'default' ) ), 'config' => ' {
        scrollHeight: 250,
        autoFill: false,
        cacheLength: 1,
        delay: 1,
        max: 10,
        minChars:0
      }' ) );
      $this->validatorSchema['city_id']   = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('City')),
        array ('required' => 'The field is mandatory', 'invalid' => 'Invalid City' ));
      $this->validatorSchema ['phone'] = new sfValidatorAnd ( array (new sfValidatorString ( array ('required' => false, 'min_length' => 3, 'max_length' => 15, 'trim' => true ),
        array (
          'min_length' => 'Invalid Phone Number',
          'max_length' => 'Invalid Phone Number' ) ),
        new sfValidatorRegex ( array ('pattern' => '/^[0-9]([0-9]+)$/' ,
          'required'=>false),
          array ('invalid' => 'Invalid phone number. The correct format to use is 023456789 or for mobile phones 0888888888. Add only the local area code for landlines. Only add digits – any other characters or spaces between characters are not allowed.' ) ) ),
        array ('required' => false ),
        array ('required' => 'The field is mandatory', 'invalid' => 'Invalid Phone Number' ) );

        
        $this->validatorSchema ['phone1'] = new sfValidatorAnd ( array (new sfValidatorString ( array ('required' => false, 'min_length' => 3, 'max_length' => 15, 'trim' => true ),
        array (
          'min_length' => 'Invalid Phone Number',
          'max_length' => 'Invalid Phone Number' ) ),
        new sfValidatorRegex ( array ('pattern' => '/^[0-9]([0-9]+)$/' ,
          'required'=>false),
          array ('invalid' => 'Invalid phone number. The correct format to use is 023456789 or for mobile phones 0888888888. Add only the local area code for landlines. Only add digits – any other characters or spaces between characters are not allowed.' ) ) ),
        array ('required' => false ),
        array ('required' => 'The field is mandatory', 'invalid' => 'Invalid Phone Number' ) );
        
         $this->validatorSchema ['phone2'] = new sfValidatorAnd ( array (new sfValidatorString ( array ('required' => false, 'min_length' => 3, 'max_length' => 15, 'trim' => true ),
        array (
          'min_length' => 'Invalid Phone Number',
          'max_length' => 'Invalid Phone Number' ) ),
        new sfValidatorRegex ( array ('pattern' => '/^[0-9]([0-9]+)$/' ,
          'required'=>false),
          array ('invalid' => 'Invalid phone number. The correct format to use is 023456789 or for mobile phones 0888888888. Add only the local area code for landlines. Only add digits – any other characters or spaces between characters are not allowed.' ) ) ),
        array ('required' => false ),
        array ('required' => 'The field is mandatory', 'invalid' => 'Invalid Phone Number' ) );
      
      /*  
      	$this->validatorSchema ['facebook_url'] = new sfValidatorAnd ( array (new sfValidatorString ( array ('required' => false, 'max_length' => 255 ,'trim' => true), array ('max_length' => 'This field cannot contain more than %max_length% characters' ) ), new sfValidatorRegex ( array ('required' => false, 'pattern' => '/^(http|https?:\/\/+[\w\-]+\.[\w\-]+)/i' ), array ('invalid' => 'Invalid format. E.g. http://www.facebook.com/getlokal' ) ) ), array ('required' => false ) );
        $this->validatorSchema ['website_url'] = new sfValidatorAnd ( array (new sfValidatorString ( array ('required' => false, 'max_length' => 255,'trim' => true ), array ('max_length' => 'This field cannot contain more than %max_length% characters' ) ), new sfValidatorRegex ( array ('required' => false, 'pattern' => '/^(http|https?:\/\/+[\w\-]+\.[\w\-]+)/i' ), array ('invalid' => 'Invalid format. E.g. http://www.getlokal.com' ) ) ) , array ('required' => false ) );
        $this->validatorSchema ['googleplus_url'] = new sfValidatorAnd ( array (new sfValidatorString ( array ('required' => false, 'max_length' => 255 ,'trim' => true), array ('max_length' => 'This field cannot contain more than %max_length% characters' ) ), new sfValidatorRegex ( array ('required' => false, 'pattern' => '/^(http|https?:\/\/+[\w\-]+\.[\w\-]+)/i' ), array ('invalid' => 'Invalid format. E.g. http://www.facebook.com/getlokal' ) ) ), array ('required' => false ) );
        $this->validatorSchema ['foursquare_url'] = new sfValidatorAnd ( array (new sfValidatorString ( array ('required' => false, 'max_length' => 255 ,'trim' => true), array ('max_length' => 'This field cannot contain more than %max_length% characters' ) ), new sfValidatorRegex ( array ('required' => false, 'pattern' => '/^(http|https?:\/\/+[\w\-]+\.[\w\-]+)/i' ), array ('invalid' => 'Invalid format. E.g. http://www.facebook.com/getlokal' ) ) ), array ('required' => false ) );
        $this->validatorSchema ['twitter_url'] = new sfValidatorAnd ( array (new sfValidatorString ( array ('required' => false, 'max_length' => 255 ,'trim' => true), array ('max_length' => 'This field cannot contain more than %max_length% characters' ) ), new sfValidatorRegex ( array ('required' => false, 'pattern' => '/^(http|https?:\/\/+[\w\-]+\.[\w\-]+)/i' ), array ('invalid' => 'Invalid format. E.g. http://www.facebook.com/getlokal' ) ) ), array ('required' => false ) );
      
      */
      
      $this->validatorSchema ['email'] = new sfValidatorEmail(array('trim' => true,'required' => false),array('invalid'=>'Invalid email – your email is not in the correct format'));
         
      $this->validatorSchema ['website_url'] = new sfValidatorAnd ( array (new sfValidatorString ( array ('required' => false, 'max_length' => 255 ,'trim' => true), array ('max_length' => 'This field cannot contain more than %max_length% characters' ) ), new myValidatorUrl(array('required' => false), array ('invalid' => 'Invalid format. E.g. http://www.getlokal.com'  ))), array ('required' => false ) );
      $this->validatorSchema ['facebook_url'] = new sfValidatorAnd ( array (new sfValidatorString ( array ('required' => false, 'max_length' => 255 ,'trim' => true), array ('max_length' => 'This field cannot contain more than %max_length% characters' ) ), new myValidatorUrl(array('required' => false), array ('invalid' => 'Invalid format. E.g. http://www.facebook.com/getlokal'  ))), array ('required' => false ) );
      $this->validatorSchema ['googleplus_url'] = new sfValidatorAnd ( array (new sfValidatorString ( array ('required' => false, 'max_length' => 255 ,'trim' => true), array ('max_length' => 'This field cannot contain more than %max_length% characters' ) ), new myValidatorUrl(array('required' => false), array ('invalid' => 'Invalid format. E.g. https://plus.google.com/') ) ), array ('required' => false ) );
      $this->validatorSchema ['foursquare_url'] = new sfValidatorAnd ( array (new sfValidatorString ( array ('required' => false, 'max_length' => 255 ,'trim' => true), array ('max_length' => 'This field cannot contain more than %max_length% characters' ) ), new myValidatorUrl(array('required' => false), array ('invalid' => 'Invalid format. E.g. https://foursquare.com/'  ))), array ('required' => false ) );
      $this->validatorSchema ['twitter_url'] = new sfValidatorAnd ( array (new sfValidatorString ( array ('required' => false, 'max_length' => 255 ,'trim' => true), array ('max_length' => 'This field cannot contain more than %max_length% characters' ) ), new myValidatorTwitter(array('required' => false), array ('invalid' => 'Invalid format. E.g. @getlokal'  ))), array ('required' => false ) );
      
      
      
      $this->widgetSchema ['registration_no'] = new sfWidgetFormInputText ();
      if (!$this->getObject()->isNew())
      {
        if ($this->getObject()->getCountryId() == getlokalPartner::GETLOKAL_BG){
          $partner =getlokalPartner::GETLOKAL_BG;
        }
        elseif ($this->getObject()->getCountryId() == getlokalPartner::GETLOKAL_RO)
        {
          $partner =getlokalPartner::GETLOKAL_RO;
        }
        elseif ($this->getObject()->getCountryId() == getlokalPartner::GETLOKAL_MK)
        {
          $partner =getlokalPartner::GETLOKAL_MK;
        }
        elseif ($this->getObject()->getCountryId() == getlokalPartner::GETLOKAL_RS)
        {
          $partner =getlokalPartner::GETLOKAL_RS;
        }
        elseif ($this->getObject()->getCountryId() == getlokalPartner::GETLOKAL_FI)
        {
          $partner =getlokalPartner::GETLOKAL_FI;
        }
        elseif ($this->getObject()->getCountryId() == getlokalPartner::GETLOKAL_HU)
        {
          $partner =getlokalPartner::GETLOKAL_HU;
        }

      }else{
        $partner=getlokalPartner::getInstance();
      }
      if ($partner == getlokalPartner::GETLOKAL_BG){
        $this->widgetSchema->setLabel('registration_no' ,  'Enter the Bulstat of your business.');
        $this->setValidator ( 'registration_no', new sfValidatorOr ( array (new sfBulstatValidator ( array ('trim' => true ), array ('required' => 'The field is mandatory', 'invalid' => 'Invalid Bulstat' ) ), new sfEGNValidator ( array ('trim' => true ), array ('required' => 'The field is mandatory', 'invalid' => 'Invalid Bulstat') ) ), array (), array ('invalid' => 'Invalid Bulstat', 'required' => 'The field is mandatory' ) ) );

      }
      elseif($partner ==getlokalPartner::GETLOKAL_RO )
      {
        $this->widgetSchema->setLabel('registration_no' ,  'CUI (Cod Unic de Identificare)');
        $this->setValidator ( 'registration_no', new sfValidatorString ( array ('max_length' => 12, 'required' => true, 'trim' => true ) , array('invalid' =>  'Invalid CUI' ,'required' =>  'The Business\' CUI is mandatory')) );
      }
      elseif($partner ==getlokalPartner::GETLOKAL_MK )
      {
        $this->widgetSchema->setLabel('registration_no' ,  'МБС (матичен број)');
        $this->setValidator ( 'registration_no', new sfValidatorString ( array ('max_length' => 13, 'required' => false, 'trim' => true ) , array('invalid' =>  'Invalid Registration Number')) );
      }elseif($partner ==getlokalPartner::GETLOKAL_RS )
      {
      	$this->widgetSchema->setLabel('registration_no' ,  'Enter the registration number of your business.');
        $this->setValidator ( 'registration_no', new sfValidatorString ( array ('max_length' => 13, 'required' => true, 'trim' => true ) , array('invalid' =>  'Invalid Registration Number' ,'required' =>  'The field is mandatory')) );
     
      }elseif($partner ==getlokalPartner::GETLOKAL_FI )
      {
      	$this->widgetSchema->setLabel('registration_no' ,  'Enter the registration number of your business.');
        $this->setValidator ( 'registration_no', new sfValidatorString ( array ('max_length' => 13, 'required' => true, 'trim' => true ) , array('invalid' =>  'Invalid Registration Number' ,'required' =>  'The field is mandatory')) );
      }
      elseif($partner ==getlokalPartner::GETLOKAL_HU )
      {
      	$this->widgetSchema->setLabel('registration_no' ,  'Enter the registration number of your business.');
        $this->setValidator ( 'registration_no', new sfValidatorString ( array ('max_length' => 13, 'required' => true, 'trim' => true ) , array('invalid' =>  'Invalid Registration Number' ,'required' =>  'The field is mandatory')) );
      }

      $culture = sfContext::getInstance()->getUser()->getCountry()->getSlug();
      $cultures = sfConfig::get('app_languages_'.$culture);

      $this->embedI18n($cultures);

      $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
      $this->widgetSchema->getFormFormatter ()->setTranslationCatalogue ( 'form' );

    }
    protected function getChoices($sector_id=null) {
      $choices = array ();
      if ($sector_id){
        $dql = Doctrine_Query::create ()->select ( 'id, t.title' )->from ( 'Classification c' )
        ->innerJoin ( 'c.Translation t' )->leftJoin( 'c.ClassificationSector cs' )->where ( 'cs.sector_id = ? AND c.status = ? and is_active= ? ', array($sector_id, 1, 0) );
      }else
      {
        $dql = Doctrine_Query::create ()->select ( 'id, t.title' )->from ( 'Classification c' )->innerJoin ( 'c.Translation t' )->where ( 'c.status = 1 and is_active=0 ');
      }
      $this->rows = $dql->execute ();

      if ($this->rows) {
        foreach ( $this->rows as $row ) {
          $choices [$row ['id']] = $row ['title'];

        }
      }
      return $choices;
    }
    
    public function bind(array $taintedValues = null, array $taintedFiles = null){
    	
    	if ($this->isValid() && $taintedValues ['website_url'])  	$taintedValues ['website_url'] = $this->getValidator('website_url')->clean($taintedValues['website_url']);
    	if ($this->isValid() && $taintedValues ['googleplus_url']) 	$taintedValues ['googleplus_url'] = $this->getValidator('googleplus_url')->clean($taintedValues['googleplus_url']);
    	if ($this->isValid() && $taintedValues ['foursquare_url'])  $taintedValues ['foursquare_url'] = $this->getValidator('foursquare_url')->clean($taintedValues['foursquare_url']);
    	if ($this->isValid() && $taintedValues ['facebook_url'])  	$taintedValues ['facebook_url'] = $this->getValidator('facebook_url')->clean($taintedValues['facebook_url']);
    	if ($this->isValid() && $taintedValues ['twitter_url'])  	$taintedValues ['twitter_url'] = $this->getValidator('twitter_url')->clean($taintedValues['twitter_url']) ;

    	parent::bind ( $taintedValues, $taintedFiles );
    }
  }
