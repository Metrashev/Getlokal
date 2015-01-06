<?php

/**
 * UserProfile filter form.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class backendUserFormFilter extends UserProfileFormFilter
{
    public function configure()
    {
        parent::configure();
        
        $domain = sfContext::getInstance()->getRequest()->getHost();
        $i18n = sfContext::getInstance()->getI18N();
		
        $this->useFields(array(
            'city_id', 
            //'country_id',
            'birthdate',
            'gender',
            'website', 
            'facebook_url', 
            'blog_url', 
            'twitter_url', 
            'google_url', 
            'created_at'
        ));
        $this->setWidget('id', new sfWidgetFormFilterInput(array('with_empty' => false)));
        $this->setValidator('id', new sfValidatorSchemaFilter(
            'text', 
            new sfValidatorNumber(array('required' => false))
        ));

        $this->widgetSchema['last_name'] = new sfWidgetFormFilterInput();
        $this->widgetSchema['first_name'] = new sfWidgetFormFilterInput();
        $this->widgetSchema['email_address'] = new sfWidgetFormFilterInput();

        $this->validatorSchema['last_name'] = new sfValidatorPass(array('required' => false));
        $this->validatorSchema['first_name'] = new sfValidatorPass(array('required' => false));
        $this->validatorSchema['email_address'] = new sfValidatorPass(array('required' => false));

        $this->widgetSchema->moveField('email_address', sfWidgetFormSchema::FIRST);
        $this->widgetSchema->moveField('last_name', sfWidgetFormSchema::FIRST);
        $this->widgetSchema->moveField('first_name', sfWidgetFormSchema::FIRST);
                
        
        //$this->widgetSchema['city_id_only'] = new sfWidgetFormFilterInput();
        //$this->validatorSchema['city_id_only'] = new sfValidatorPass(array('required' => false));
        $this->setWidget('city_id_only', new sfWidgetFormFilterInput(array('with_empty' => false)));
        $this->setValidator('city_id_only', new sfValidatorSchemaFilter(
        		'text',
        		new sfValidatorNumber(array('required' => false))
        ));

        $this->widgetSchema['city_id'] = new sfWidgetFormDoctrineJQueryAutocompleter(array(
        		'model' => 'City',
        		'method' => 'getLocation',
        		'url' => sfContext::getInstance()
        		    ->getRouting()
        		    ->generate('default', array(
        		    		'module' => 'user_profile',
        		    		'action' => 'autocomplete' ) ),        		        		
        		'config' => ' {
          		  scrollHeight: 250,
         		  autoFill: false,
          		  cacheLength: 0,
        		  delay: 1,
        		  max: 10,
        		  minChars:0
        		}'
        ));
        
        $this->setValidator(
            'city_id', 
            new sfValidatorDoctrineChoice(array(
                'required' => false, 
                'model' => 'City'
            )
        ));

//        
        if (strstr($domain, '.my') || strstr($domain, '.com')) {
        	$this->widgetSchema['country_id'] = new sfWidgetFormDoctrineJQueryAutocompleter(array(
        			'model' => 'Country',
        			'url' => sfContext::getInstance()->getController()->genUrl(array('module' => 'user_profile', 'action' => 'getCountriesAutocomplete', 'route' => 'default')),
        			'config' => ' {
        			scrollHeight: 250,
        			autoFill: false,
        			cacheLength: 1,
        			delay: 1,
        			max: 10,
        			minChars:0
                   }',
        			'method' => 'getCountryNameByCulture'
        	       ));

        	$this->setValidator(
        			'country_id',
        			new sfValidatorDoctrineChoice(array(
        					'required' => false,
        					'model' => 'City'
        			)
        			));
        	
        	$this->setWidget('country_id_only', new sfWidgetFormFilterInput(array('with_empty' => false)));
        	$this->setValidator('country_id_only', new sfValidatorSchemaFilter(
        			'text',
        			new sfValidatorNumber(array('required' => false))
        	));
        }


        $this->setWidget('facebook_connected', new sfWidgetFormChoice(array(
            'choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no')
        )));
        $this->setValidator('facebook_connected', new sfValidatorChoice(array(
            'required' => false,
            'choices' => array('', 1, 0)
        )));

        $this->widgetSchema['is_active'] = new sfWidgetFormChoice(array(
            'choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no')
        ));
        $this->validatorSchema['is_active'] = new sfValidatorChoice(array(
            'required' => false, 
            'choices' => array('', 1, 0)
        ));

        $this->widgetSchema['status'] = new sfWidgetFormChoice(array('choices' => array(
            '' => 'choose...' ,
            1 => 'Only RU',
            2 => 'Only RUPA',
            3 => 'Only APPROVED RUPA'
        )));

        $this->setValidator(
            'status', new sfValidatorChoice(array(
                'required' => false, 
                'choices' => array('', 1, 2, 3))
            )
        );

        /*$this->widgetSchema['country_id'] = new sfWidgetFormChoice(array(
          'choices' => array(
            '' => '',
            1 => $i18n->__('България'),
            2 => $i18n->__('Romania'),
            3 => $i18n->__('Македонија'),
            4 => $i18n->__('Srbija'),
            -1 => $i18n->__('Rest of the world')
          )
        ));
        $this->validatorSchema['country_id'] = new sfValidatorInteger(array(), array(
          'invalid' => $i18n->__('Invalid country selected', array(), 'sf_admin')
        )); */

        $this->widgetSchema['allow_contact'] = new sfWidgetFormChoice(array(
            'choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no')
        ));
        $this->validatorSchema['allow_contact'] = new sfValidatorChoice(array(
            'required' => false, 
            'choices' => array('', 1, 0)
        ));

        $this->widgetSchema['allow_newsletter'] = new sfWidgetFormChoice(array(
            'choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no')
        ));
        $this->validatorSchema['allow_newsletter'] = new sfValidatorChoice(array(
            'required' => false, 
            'choices' => array('', 1, 0)
        ));

        $this->widgetSchema['allow_b_cmc'] = new sfWidgetFormChoice(array(
            'choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no')
        ));
        $this->validatorSchema['allow_b_cmc'] = new sfValidatorChoice(array(
            'required' => false, 
            'choices' => array('', 1, 0)
        ));

        $this->widgetSchema->moveField('email_address', sfWidgetFormSchema::FIRST);
        $this->widgetSchema->moveField('last_name', sfWidgetFormSchema::FIRST);
        $this->widgetSchema->moveField('first_name', sfWidgetFormSchema::FIRST);
        $this->widgetSchema->moveField('id', sfWidgetFormSchema::FIRST);
        $this->widgetSchema->moveField('is_active', sfWidgetFormSchema::FIRST);
    }

    public function addEmailAddressColumnQuery($query, $field, $value) {
        if ($value['text'] != null) {
            Doctrine::getTable('UserProfile')->applyEmailAddressFilter($query, $value);            
        }
    }

    public function addFirstNameColumnQuery($query, $field, $value) {
        if ($value['text'] != null) {        	
            Doctrine::getTable('UserProfile')->applyFirstNameFilter($query, $value);
        }
    }

    public function addLastNameColumnQuery($query, $field, $value) {
        if ($value['text'] != null) {
            Doctrine::getTable('UserProfile')->applyLastNameFilter($query, $value);
        }
    }

    public function addStatusColumnQuery($query, $field, $value) {
        if ($value != null) {
            Doctrine::getTable('UserProfile')->applyStatusFilter($query, $value);
        }
    }

    public function addIsActiveColumnQuery($query, $field, $value)
    {
        if ($value != null) {
            Doctrine::getTable('UserProfile')->applyIsActiveFilter ($query, $value);
        }
    }

    public function addAllowContactColumnQuery($query, $field, $value)
    {
        if ($value != null) {
            Doctrine::getTable('UserProfile')->applyAllowContactFilter($query, $value);
        }
    }

    public function addAllowNewsletterColumnQuery($query, $field, $value)
    {
        if ($value != null) {
            Doctrine::getTable('UserProfile')->applyAllowNewsletterFilter($query, $value);
        }
    }

    public function addAllowBCmcColumnQuery($query, $field, $value) {
        if ($value != null) {
            Doctrine::getTable('UserProfile')->applyAllowBCmcFilter($query, $value);
        }
    }

    public function addFacebookConnectedColumnQuery($query, $field, $value)
    {
        if ($value !== '') {
            Doctrine::getTable('UserProfile')->applyFacebookConnectedFilter($query, $value);
        }
    }

    public function addCountryIdColumnQuery($query, $field, $value)
    {
        if ($value !== '') {
            Doctrine::getTable('UserProfile')->applyCountryIdFilter($query, $value);
        }
    }
    
    public function addCityIdColumnQuery($query, $field, $value) {
    	if ($value != null) {    		
    		Doctrine::getTable ( 'UserProfile' )->applyCityIdFilter ( $query, $value );    		
    	}
    }
    
    public function addCityIdOnlyColumnQuery($query, $field, $value) {
    	if ($value['text'] != '') {
    		Doctrine::getTable ( 'UserProfile' )->applyCityIdFilter ( $query, $value['text'] );
    	}
    }

    public function addCountryIdOnlyColumnQuery($query, $field, $value) {
    	if ($value['text'] != '') {
    		Doctrine::getTable ( 'UserProfile' )->applyCountryIdFilter ( $query, $value['text'] );
    	}
    }

    public function getFields()
    {
        $fields = parent::getFields();
        $fields['username'] = 'username';
        $fields['first_name'] = 'first_name';
        $fields['last_name'] = 'last_name';
        $fields['is_active'] = 'is_active';
        $fields['allow_contact'] = 'allow_contact';
        $fields['allow_newsletter'] = 'allow_newsletter';
        $fields['allow_b_cmc'] = 'allow_b_cmc';
        //$fields['city_id_clean'] ='city_id';
        
        return $fields;
    }

}