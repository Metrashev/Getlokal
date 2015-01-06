<?php

/**
 * RegisterForm for signup process and requires
 * sfGuardPlugin
 *
 * @author Rajat Pandit
 */
class RegisterForm extends UserProfileForm
{
    public function configure()
    {
        parent::configure();

        unset(
            $this['birthdate'],
            $this['phone_number'],
            $this['summary'],
            $this['blog_url'],
            $this['facebook_url'],
            $this['twitter_url'],
            $this['country_id'],
            $this['city_id']
        );

        $this->widgetSchema['location'] = new sfWidgetFormInputText();
        $this->validatorSchema['location'] = new sfValidatorString(array(
            'required' => true
        ), array(
            'required' => 'The field is mandatory'
        ));
        $this->validatorSchema->setPostValidator(
            new sfValidatorCallback(array('callback' => array($this, 'validateLocation')))
        );


        $facebook_user_data = $this->getOption('facebook_user_data', null);
        $this->embedForm('sf_guard_user', new sfGuardUserForm(null, array('facebook_user_data' => $facebook_user_data)));

        $this->widgetSchema['allow_contact'] = new sfWidgetFormInputCheckbox(array('default' => 'checked'));
        $this->validatorSchema['allow_contact'] = new sfValidatorBoolean();

        $this->widgetSchema['accept'] = new sfWidgetFormInputCheckbox(array());
        $this->validatorSchema['accept'] = new sfValidatorBoolean(
            array('required' => true),
            array('required' => 'You need to agree to the Terms of Use and the Policy for Use and Protection of the Information on Getlokal')
        );

        $this->widgetSchema['underage'] = new sfWidgetFormInputCheckbox(array());
        $this->validatorSchema['underage'] = new sfValidatorBoolean();

        $this->widgetSchema['gender'] = new sfWidgetFormChoice(array(
            'expanded' => false,
            'label' => 'Gender',
            'choices' => Social::getI18NChoices(Social::$sexChoicesWEmpty)
        ));
        $this->validatorSchema['gender'] = new sfValidatorChoice(array(
            'required' => false,
            'choices' => array_keys(Social::$sexChoices)
        ), array(
            'required' => 'The field is mandatory'
        ));

        if (getlokalPartner::getInstance() == getlokalPartner::GETLOKAL_RS) {
            $this->validatorSchema['gender']->setOption('required', true);

            if ($facebook_user_data) {
                $gender = null;
                if (isset($facebook_user_data['gender']) && $facebook_user_data['gender'] == 'male') {
                    $gender = 'm';
                } elseif (isset($facebook_user_data['gender']) && $facebook_user_data['gender'] == 'female') {
                    $gender = 'f';
                }

                $this->widgetSchema['gender']->setDefault($gender);
            }
        } else {
            unset($this['gender']);
        }

        if ($facebook_user_data) {
            $birthDate = $age = null;

            if ($birthDate = $facebook_user_data['birthday']) {
                $age = $this->_calculateAge($birthDate);
            }

            if ($age && $age >= 14) {
                unset($this['underage']);
            }

            $this->locationFromFB($facebook_user_data);
        }
    }

    public function validateLocation($validator, $values)
    {
        // geocode city_id / country_id
        if (!empty($values['location'])) {
            $data = CompanyLocationTable::getGeocodeData(CityTable::geocodeUrl($values['location']));
            $city = CityTable::createFromGeocode($data);
            if ($city) {
                $values['city_id'] = $city->getId();
                $values['country_id'] = $city->getCountry()->getId();
            } else {
                throw new sfValidatorError($validator, 'City and Country could not be located!');
            }
        }

        return $values;
    }

    //mm/dd/yyyy
    private function _calculateAge($birthDate) {
        $birthDate = explode("/", $birthDate);

        return (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md") ? ((date("Y")-$birthDate[2])-1):(date("Y")-$birthDate[2]));
    }

    private function locationFromFB($facebook_user_data)
    {
        //Set country and city
        if (isset($facebook_user_data['location']['name']) && $facebook_user_data['location']['name']) {
            $this->widget['location']->setDefault($facebook_user_data['location']['name']);
        }
    }

    public function checkIfCityIsNecessary($validator, $values)
    {
        return $values;
    }

    public function doSave($con = null)
    {
        $values = $this->getValues();
        $object = $this->getObject();

        parent::doSave($con);
    }


}
