<?php

/**
 * UserProfile form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class UserProfileForm extends BaseUserProfileForm {
    public function configure() {
        $years = range((date('Y') - 16), 1930);
        $years_list = array_combine($years, $years);

        unset($this ['id'], $this ['hash'], $this ['access_token'], $this ['facebook_uid'], $this ['karma'], $this ['image_id'], $this ['created_at'], $this ['updated_at'], $this ['partner'], $this ['referer']);

        //$this->getWidgetSchema ()->moveField ( 'country_id', sfWidgetFormSchema::BEFORE, 'city_id' );

        /*
        Selectbox
        $this->widgetSchema['country_id'] = new sfWidgetFormDoctrineChoice(array(
            'multiple' => false,
            'expanded' => false,
            //'order_by' => array('name_en', 'ASC'),
            'add_empty' => false,
            'model' => 'Country',
            'table_method' => 'getCountriesForUserForm',
            'method' => 'getCountryNameByCulture'
        ));
        */

        // Autocomplete
        $this->widgetSchema['country_id'] = new sfWidgetFormDoctrineJQueryAutocompleter(array(
            'model' => 'Country',
            'url' => sfContext::getInstance()->getController()->genUrl(array('module' => 'user', 'action' => 'getCountriesAutocomplete', 'route' => 'default')),
            'config' => ' {
                scrollHeight: 250,
                autoFill: false,
                cacheLength: 1,
                delay: 1,
                max: 10,
                minChars:0
            }',
            //'table_method' => 'getCountriesForUserForm',
            'method' => 'getCountryNameByCulture'
        ));

        /*
        $country_id = sfContext::getInstance()->getUser()->getAttribute('country_id', 1); //1
        $this->setDefault('country_id', $country_id);
        */

        $this->validatorSchema ['country_id']->setOption('required', true);
        $this->validatorSchema ['country_id']->setMessage('required', 'This field is mandatory. Please select your country name from the list.');


        $this->widgetSchema ['city_id'] = new sfWidgetFormDoctrineJQueryAutocompleter(array('model' => 'City', 'method' => 'getLocation', 'url' => sfContext::getInstance()->getController()->genUrl(array('module' => 'user', 'action' => 'getCitiesAutocomplete', 'route' => 'default')), 'config' => ' {
            scrollHeight: 250,
            autoFill: false,
            cacheLength: 1,
            delay: 1,
            max: 10,
            minChars:0
        }'));

        $this->validatorSchema ['city_id']->setOption('required', false); //true
        // Use a post validator
        //$this->validatorSchema ['city_id']->setMessage('required', 'This field is mandatory. Please start typing the name of your home location and select from the list.');

        $this->widgetSchema ['birthdate'] = new sfWidgetFormI18nDate(array('culture' => sfContext::getInstance()->getUser()->getCulture(), 'format' => '%day% %month% %year%', 'years' => $years_list), array());
        $this->validatorSchema ['birthdate'] = new sfValidatorDate(array('required' => false), array('invalid' => 'Day, month and year are mandatory fields'));

        $this->widgetSchema ['gender'] = new sfWidgetFormChoice(array('expanded' => false, 'label' => 'Gender', 'choices' => Social::getI18NChoices(Social::$sexChoicesWEmpty)));
        $this->validatorSchema ['gender'] = new sfValidatorChoice(array('required' => false, 'choices' => array_keys(Social::$sexChoices)), array('required' => 'The field is mandatory'));

        $this->validatorSchema ['phone_number'] = new sfValidatorAnd(array(new sfValidatorString(array('required' => true, 'min_length' => 7, 'max_length' => 20), array('min_length' => 'Invalid Phone Number', 'max_length' => 'Invalid Phone Number')), new sfValidatorRegex(array('pattern' => '/^[0-9+]([0-9.-]+)$/'), array('invalid' => 'Invalid Phone Number'))),
                array('required' => false), array('required' => 'The field is mandatory', 'invalid' => 'Invalid Phone Number')
        );


        $this->validatorSchema ['website'] = new sfValidatorAnd(array(
                new sfValidatorString(array('required' => false, 'max_length' => 255), array('max_length' => 'This field cannot contain more than %max_length% characters')),
                new sfValidatorRegex(array('required' => false, 'pattern' => '/^(https?:\/\/+[\w\-]+\.[\w\-]+)/i'), array('invalid' => 'Invalid format. E.g. http://www.getlokal.com'))
                    ),
                    array('required' => false));

        $this->validatorSchema ['twitter_url'] = new sfValidatorAnd(array(
                new sfValidatorString(array('required' => false, 'max_length' => 255), array('max_length' => 'This field cannot contain more than %max_length% characters')),
                new sfValidatorRegex(array('required' => false, 'pattern' => '/^(https?:\/\/+[\w\-]+\.[\w\-]+)/i'),
                        array('invalid' => 'Invalid format. E.g. http://twitter.com/@getlokal'))
                    ), array('required' => false));

        $this->validatorSchema ['google_url'] = new sfValidatorAnd(array(
                new sfValidatorString(array('required' => false, 'max_length' => 255), array('max_length' => 'This field cannot contain more than %max_length% characters')),
                new sfValidatorRegex(array('required' => false, 'pattern' => '/^(https?:\/\/+[\w\-]+\.[\w\-]+)/i'),
                        array('invalid' => 'Invalid format.'))
                    ), array('required' => false));

        $this->validatorSchema ['facebook_url'] = new sfValidatorAnd(array(
                new sfValidatorString(array('required' => false, 'max_length' => 255), array('max_length' => 'This field cannot contain more than %max_length% characters')),
                new sfValidatorRegex(array('required' => false, 'pattern' => '/^(https?:\/\/+[\w\-]+\.[\w\-]+)/i'),
                        array('invalid' => 'Invalid format. E.g. http://www.facebook.com/#!/getlokal'))
                    ), array('required' => false));

        $this->validatorSchema ['blog_url'] = new sfValidatorAnd(array(
                new sfValidatorString(array('required' => false, 'max_length' => 255), array('max_length' => 'This field cannot contain more than %max_length% characters')),
                new sfValidatorRegex(array('required' => false, 'pattern' => '/^(https?:\/\/+[\w\-]+\.[\w\-]+)/i'),
                        array('invalid' => 'Invalid format. E.g. http://blog.getlokal.com'))
                    ), array('required' => false));

        if (getlokalPartner::getInstance() == getlokalPartner::GETLOKAL_RS) {
            //$this->widgetSchema['gender'] = new sfWidgetFormChoice('choices' => array('m' => ));
            $this->validatorSchema['gender']->setOption('required', true);
        }



        $this->widgetSchema->setLabels(array(
            'birthdate' => 'Date of Birth',
            'gender' => 'Gender',
            'country_id' => 'Country',
            'city_id' => 'Location',
            'phone_number' => 'Phone',
            'blog_url' => 'My Blog',
            'facebook_url' => 'My Facebook',
            'twitter_url' => 'My Twitter',
            'website' => 'My Website',
            'google_url' => 'My Google+',
            'summary' => 'About me'
        ));

        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('form');

        if ($this->getOption('city_is_mandatory')) {
            $this->validatorSchema->setPostValidator(
                new sfValidatorCallback(array('callback' => array($this, 'checkIfCityIsNecessary')))
            );
        }
    }

    public function checkIfCityIsNecessary($validator, $values) {
        if ($values['country_id'] <= 4 && !trim($values['city_id'])) {
            // Throw a global form error
            //throw new sfValidatorError($validator, 'Error here...');

            // Throw error for special fied
            $error = new sfValidatorError($validator, 'This field is mandatory. Please start typing the name of your home location and select from the list.');
            throw new sfValidatorErrorSchema($validator, array('city_id' => $error));
        }

        return $values;
    }

    public function doSave($con = null) {
        $values = $this->getValues();

        if ($values['country_id'] > 4) {
            $values['city_id'] = NULL;
        }

        parent::doSave($con);

        $this->getObject()->save();
    }
}