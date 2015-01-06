<?php

/**
 * CompanyOffer form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CompanyOfferForm extends BaseCompanyOfferForm {

	protected  $languages;
    public function configure()
    {
        $i18n = sfContext::getInstance()->getI18N();
        sfContext::getInstance()->getConfiguration()->loadHelpers("Date");
        $years = range(date('Y') + 1, date('Y'));
        $years_list = array_combine($years, $years);
        $culture = sfContext::getInstance()->getUser()->getCulture();
        $is_getlokal_admin = sfContext::getInstance()->getUser()->isGetlokalAdmin();
        $this->useFields(array(
            'active_from',
            'active_to',
            'valid_from',
            'valid_to',
            'max_vouchers',
            'max_per_user',
        ));
        //var_dump(getlokalPartner::getLanguageClass());exit();
        $partner_id = getlokalPartner::getInstance();
        $lang = getlokalPartner::getDefaultCulture();
        $this->languages = sfConfig::get('app_languages_'.$lang);

        $postValidators = array(
            new sfValidatorCallback(array(
                'callback' => array($this, 'postValidateMe')
            ))
        );
        /*
        foreach($this->languages as $language) {
        	$groups[] = array($language.'[title]', $language.'[content]');
        }
        */
        if ($this->getObject()->isNew() || $this->getObject()->canEdit() || $is_getlokal_admin) {
            $postValidators[] = new sfValidatorRequiredGrouped(array(

                'groups' =>  array(
                    array($lang . '[title]', $lang . '[content]'),
                    array('en[title]', 'en[content]'),
                ) //$groups
            ), array(
                'required' => $i18n->__('The offer title and description (terms) are mandatory for at least one of the two language versions.')
            ));
        	
        }

        if ($this->getObject()->isNew() || $this->getObject()->getCountVoucherCodes() == 0 || $is_getlokal_admin) {
            $this->embedI18n(getlokalPartner::getEmbeddedLanguages());
        }

        if ($this->getObject()->getAdServiceCompany()->getStatus() == 'registered') {
            unset(
                $this['active_from'],
                $this['active_to'],
                $this['valid_from'],
                $this['valid_to']
            );
        } else {
            if ($this->getObject()->getIsStarted(true, false)) {
                unset($this['active_from']);
            } else {
                $this->widgetSchema['active_from'] = new sfWidgetFormDatepicker();

                $this->validatorSchema['active_from'] = new sfValidatorDateTime(array(
                    'required' => true
                ), array(
                    'required' => 'The field is mandatory',
                    'invalid' => 'Invalid Date.'
                ));
            }
            $this->widgetSchema['active_to'] = new sfWidgetFormDatepicker(array('date_format' => 'd.m.Y 23:59:59'));
            $this->validatorSchema['active_to'] = new sfValidatorDateTime(array(
                'required' => true
            ), array(
                'required' => 'The field is mandatory',
                'invalid' => 'Invalid Date.'
            ));

            $this->widgetSchema['valid_from'] = new sfWidgetFormDatepicker();
            $this->validatorSchema['valid_from'] = new sfValidatorDateTime(array(
                'required' => true
            ), array(
                'required' => 'The field is mandatory',
                'invalid' => 'Invalid Date.'
            ));

            $this->widgetSchema['valid_to'] = new sfWidgetFormDatepicker();
            $this->validatorSchema['valid_to'] = new sfValidatorDateTime(array(
                'required' => true
            ), array(
                'required' => 'The field is mandatory',
                'invalid' => 'Invalid Date.'
            ));
        }
        
// BENEFITS START
        $choices = array('1' => 'Price', '2' => 'Discount', '3' => 'Text');
/*        $this->widgetSchema['benefit_choice'] = new sfWidgetFormChoice(array(
        		'multiple' => false,
        		'expanded' => true,
        		'choices'  => $choices,   
*/
          $this->widgetSchema['benefit_choice'] = new sfWidgetFormSelectRadio(array(
          'choices' => $choices,
          'label_separator' => '', 		
        ));
        $this->setDefault('benefit_choice', '1');
        $this->validatorSchema['benefit_choice'] =new sfValidatorChoice ( array(
          	    'choices' =>array_keys($choices),
          	    'required' => true
        ));
        
        $this->widgetSchema['new_price'] = new sfWidgetFormInputText(array(), array(
        		'size' => 5
        ));
        $this->validatorSchema['new_price'] = new sfValidatorInteger(array(
        		'trim' => true,
        		'required' => false,
        ), array()
        );
        
        $this->widgetSchema['old_price'] = new sfWidgetFormInputText(array(), array(
        		'size' => 5
        ));
        $this->validatorSchema['old_price'] = new sfValidatorInteger(array(
        		'trim' => true,
        		'required' => false,
        ), array(
        ));
        
        $this->widgetSchema['discount_pct'] = new sfWidgetFormInputText(array(), array(
        		'size' => 5
        ));
        $this->validatorSchema['discount_pct'] = new sfValidatorInteger(array(
        		'trim' => true,
        		'required' => false,
        ), array(
        ));
        
        $this->widgetSchema['benefit_text'] = new sfWidgetFormInputText ( array (), array () );
        $this->validatorSchema['benefit_text'] = new sfValidatorRegex ( array (
        		'required' => false,
        		'trim' => true,
        		'pattern' => '/^[\p{L}\p{N}]([\p{L}\p{N}\?\s\.\(\)\{\}\[\],%]+)[\p{L}\p{N}]$/u',  
        		),
        	array (
        			'invalid' => 'You can only use alphanumeric characters and ? ( ) [ ] { } %'
        	));
        
// BENEFITS END
        
        $this->widgetSchema['max_vouchers'] = new sfWidgetFormInputText(array(), array(
            'size' => 5
        ));
        $this->validatorSchema['max_vouchers'] = new sfValidatorInteger(array(
            'trim' => true,
            'required' => false,
            'min' => 1,
        ), array(
            'min' => 'This field must be greater or equal to 1.',
        ));

        $this->widgetSchema['max_per_user'] = new sfWidgetFormInputText(array(
            'default' => 1
        ), array(
            'size' => 5
        ));
        $this->validatorSchema['max_per_user'] = new sfValidatorInteger(array(
            'trim' => true,
            'required' => true,
            'min' => 1,
            'max' => 99,
        ), array(
            'required' => 'The field is mandatory',
            'min' => 'This field must be greater or equal to 1.',
            'max' => 'Number of vouchers per user cannot exceed 99.'
        ));

        $this->widgetSchema['file'] = new sfWidgetFormInputFile();
        $this->validatorSchema['file'] = new sfValidatorFile(array(
            'required' => false,
            'max_size' => 4*1024*1024,//'2097152',
            'mime_types' => 'web_images'
        ), array(
            'max_size' => 'File size limit is 4MB.Please reduce file size.',
            'mime_types' => 'The file you submitted is not in a valid format. Please upload a JPG, GIF or PNG image file.'
        ));
        $this->widgetSchema->setLabels(array(
            'active_from' => 'Offer Active From',
            'active_to' => 'Offer Active To',
            'valid_from' => 'Voucher Valid From',
            'valid_to' => 'Voucher Valid To',
            'max_vouchers' => 'Maximum number of vouchers to be issued',
            'max_per_user' => 'Maximum number of vouchers to be issued per user',
            'file' => 'Select a photo from your computer',
        	'new_price' => 'New price',
        	'old_price' => 'Old price',
        	'discount_pct' => 'Discount',
        	'benefit_text' => 'Text',
        	'benefit_choice' => 'Main Offer Benefit'
        ));
        $this->validatorSchema->setOption('allow_extra_fields', true);
        $this->validatorSchema->setOption('filter_extra_fields', false);

        $this->validatorSchema->setPostValidator(new sfValidatorAnd($postValidators));

        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('form');
          
    }

    public function processUploadedFile($field, $filename = null, $values = null)
    {
        return true;
    }	
    
    public function postValidateMe($validator, $values, $errors = array())
    {
        $i18n = sfContext::getInstance()->getI18N();
        $culture = sfContext::getInstance()->getUser()->getCulture();
        $today = date('d.m.Y');
        $companyOffer = $this->getObject();

        // make sure there is always a value for this
        if (empty($values['max_per_user'])) {
            $this->taintedValues['max_per_user'] = 1;
        }

        $product_ordered = $companyOffer->getAdServiceCompany();
        if ($product_ordered->getStatus() != 'registered') {
            if ($companyOffer->getIsStarted()) {
                $values["active_from"] = $companyOffer->getActiveFrom();
            }

            $product_end_date = strtotime('+3 months', strtotime($product_ordered->getActiveFrom()));
            if (isset($values['active_from'])) {
                // validate active_from only if present in the form
                if (strtotime($values["active_to"]) < strtotime($today)) {
                    $errors['active_to'] = new sfValidatorError(
                        $validator,
                         'You cannot select a date earlier than today\'s'
                    );
                } elseif (strtotime($values["active_from"]) > strtotime($values["active_to"])) {
                    $errors['active_from'] = new sfValidatorError(
                        $validator,
                        'The offer end date cannot be earlier than the start date'
                    );
                } elseif (strtotime($values["active_from"]) > $product_end_date) {
                    $errors['active_from'] = new sfValidatorError(
                        $validator,
                            sprintf(
                                $i18n->__('The offer start date can not be later than %s', null, 'form'),
                                date('d.m.Y', $product_end_date)
                            )
                    );
                }
            } else {
                $values['active_from'] = $companyOffer->getActiveFrom();
            }

            $offer_max_end_date = strtotime('+30 days', $product_end_date);
            // validate active_to not bigger than 30 days from active_from
            if (strtotime($values["active_to"]) > strtotime('+30 days', strtotime($values["active_from"]))) {
                $errors['active_to'] = new sfValidatorError(
                    $validator,
                    'The Offer can be active for a maximum period of 30 days.'
                );
            } elseif (strtotime($values["active_to"]) > $offer_max_end_date) {
                $errors['active_to'] = new sfValidatorError(
                    $validator,
                    sprintf(
                        $i18n-> __('The offer end date can not be later than %s'),
                        date('d.m.Y', $offer_max_end_date)
                    )
                );
            }

            if (isset($values['valid_from']) && isset($values['valid_to'])) {
                if (strtotime($values["valid_from"] ) < strtotime($values['active_from'])) {
                    $errors['valid_from'] = new sfValidatorError(
                        $validator,
                        'You cannot select a date earlier than today\'s'
                    );
                } elseif (strtotime($values["valid_from"]) > strtotime($values["valid_to"])) {
                    $errors['valid_from'] = new sfValidatorError(
                        $validator,
                        'The offer end date cannot be earlier than the start date'
                    );
                }

                if (strtotime($values["valid_to"]) < strtotime($values["active_to"])) {
                    $errors['valid_to'] = new sfValidatorError(
                        $validator,
                        'The voucher valid to date cannot be earlier than the offer end date'
                    );
                }
            }

            // check if max_vouchers are set than max_per_user must pe lower or equal
            if (!empty($values['max_vouchers']) && $values['max_per_user'] > $values['max_vouchers']) {
                $errors['max_per_user'] = new sfValidatorError(
                    $validator,
                    'The maximum number of vouchers issued per user cannot exceed the total number of vouchers for the offer'
                );
            }
        }

        if($values['benefit_choice'] == 1) {
            
            $values['discount_pct'] = null;
            $values['benefit_text'] = null;
            
            if (!isset($values['new_price'])) {
                $errors['new_price'] = new sfValidatorError(
                        $validator,
                        'The field is mandatory'
                );
            }
            elseif (isset($values['new_price'])) {
            	if($values['new_price'] < 1) {
            		$errors['new_price'] = new sfValidatorError(
            				$validator,
            				'The price must be equal to or greater than 1.'
            		);
            	}
            }
            if (!isset($values['old_price'])) {
            	$errors['old_price'] = new sfValidatorError(
            			$validator,
            			'The field is mandatory'
            	);
            }            
            elseif (isset($values['old_price'])) {
                if($values['old_price'] < 1) {
            	    $errors['old_price'] = new sfValidatorError(
            			    $validator,
            			    'The price must be equal to or greater than 1.'
            	    );
                }
                elseif($values['old_price'] <= $values['new_price']) {
                	$errors['old_price'] = new sfValidatorError(
                			$validator,
                			'The old price must be greater than the new price.'
                	);
                }
            }
        }
        
        if($values['benefit_choice'] == 2) {
            
            $values['new_price'] = null;
            $values['old_price'] = null;
            $values['benefit_text'] = null;
            
            if (!isset($values['discount_pct'])) {
            	$errors['discount_pct'] = new sfValidatorError(
            			$validator,
            			'The field is mandatory'
            	);
            }            
            elseif (isset($values['discount_pct'])) {
                if($values['discount_pct'] < 1) {
            	    $errors['discount_pct'] = new sfValidatorError(
            			    $validator,
            			    'The discount cannot be lower than 1%'
            	    );
                }
                elseif($values['discount_pct'] > 99) {
            	    $errors['discount_pct'] = new sfValidatorError(
            			    $validator,
            			    'The discount cannot be higher than 99%'
            	    );
                }
            }
        }
        
        if($values['benefit_choice'] == 3) {
        	$min_length = 10;
        	$max_length = 100;
        	
        	$values['new_price'] = null;
        	$values['old_price'] = null;
        	$values['discount_pct'] = null;
        	
            if ($values['benefit_text'] == '') {
            	$errors['benefit_text'] = new sfValidatorError(
            			$validator,
            			'The field is mandatory'
            	);
            }
            elseif(strlen($values['benefit_text']) < $min_length) {
            	$errors['benefit_text'] = new sfValidatorError(
            			$validator,
            			sprintf(
            			$i18n->__('This text must contain at least %s characters.', null, 'form'),$min_length
            			)
            	);
            }
            elseif(strlen($values['benefit_text']) > $max_length) {            	
            	$errors['benefit_text'] = new sfValidatorError(
            			$validator,
            			sprintf(
            				$i18n->__('This text must contain at most %s characters.', null, 'form'),$max_length 
            			)
            	);
            }
        }
        
        if (!empty($errors)) {
            throw new sfValidatorErrorSchema($validator, $errors);
        }

        return $values;
    }
    
    protected function doBind(array $values)
    {
    	$i = 0;

    	$this->I18nFormsIgnored = array();

    	foreach ($this->languages as $lang) {
            if (isset($values[$lang]) && $this->embeddedI18nFormIsEmpty($values[$lang])) {
      	        $this->I18nFormsIgnored[] = $lang;
            }
            else if (isset($this[$lang]) && isset($values[$lang]) == false) {
            	$this->I18nFormsIgnored[] = $lang;
            }
            
            $i++;
    	}
    	
    	if(count($this->I18nFormsIgnored) != $i) {
    		foreach ($this->I18nFormsIgnored as $l) {
    			unset($this[$l]);
    		}
    	}
    	
    	parent::doBind($values);
    }
    
    public function embeddedI18nFormIsEmpty(array $values)
    {
    	if ('' === trim($values['title']) && '' === trim($values['content'])) {
    		return true;
    	}
    	
    	return false;
    }
    
    protected function doUpdateObject($values)
    {
    	parent::doUpdateObject($values);
    
    	foreach ($this->I18nFormsIgnored as $lang)
    	{
    		unset($this->object->Translation[$lang]);
    		unset($values[$lang]);
    	}
    }

}
