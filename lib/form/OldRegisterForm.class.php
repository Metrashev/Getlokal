<?php

/**
 * RegisterForm for signup process and requires
 * sfGuardPlugin
 *
 * @author Rajat Pandit
 */
class OldRegisterForm extends UserProfileForm {
    public function configure() {
        parent::configure();

        unset(
            $this['birthdate'], $this['phone_number'], $this['summary'], $this['blog_url'], $this['facebook_url'], $this['twitter_url']
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

        $this->widgetSchema ['gender'] = new sfWidgetFormChoice(array('expanded' => false, 'label' => 'Gender', 'choices' => Social::getI18NChoices(Social::$sexChoicesWEmpty)));
        $this->validatorSchema ['gender'] = new sfValidatorChoice(array('required' => false, 'choices' => array_keys(Social::$sexChoices)), array('required' => 'The field is mandatory'));

        if (getlokalPartner::getInstance() == getlokalPartner::GETLOKAL_RS) {
            //$this->widgetSchema['gender'] = new sfWidgetFormChoice('choices' => array('m' => ));
            $this->validatorSchema['gender']->setOption('required', true);

            if ($facebook_user_data) {
                $gender = null;

                if (isset($facebook_user_data['gender']) && $facebook_user_data['gender'] == 'male') {
                    $gender = 'm';
                }
                elseif (isset($facebook_user_data['gender']) && $facebook_user_data['gender'] == 'female') {
                    $gender = 'f';
                }

                $this->widgetSchema['gender']->setDefault($gender);
            }
        }
        else {
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

            //Set country and city
            if (isset($facebook_user_data['location']['name']) && $facebook_user_data['location']['name']) {
                $location = explode(", ", $facebook_user_data['location']['name']);

                $country = array_pop($location);

                $result = Doctrine_Query::create()
                        ->from('Country c')
                        ->where('c.name = ? OR c.name_en = ?', array($country, $country))
                        ->fetchOne();

                if ($result && $result->getId()) {
                    $this->widgetSchema['country_id']->setDefault($result->getId());
                    $tmpCountryId = $result->getId();
                }
                else {
                    $this->widgetSchema['country_id']->setDefault(getlokalPartner::getInstance());
                    $tmpCountryId = getlokalPartner::getInstance();
                }

                if ($location) {
                    $founded = false;

                    foreach ($location as $locCity) {
                        $city = $locCity;

                        $result = Doctrine_Query::create()
                                ->from('City c')
                                ->innerJoin('c.County co')
                                ->innerJoin('co.Translation cotr')
                                ->innerJoin('c.Translation ctr')
                                ->where('co.country_id = ?', $tmpCountryId)
                                ->where('ctr.name = ?',  $city)
                                ->fetchOne();

                        if ($result && $result->getId()) {
                            $founded = true;

                            $this->widgetSchema['city_id']->setDefault($result->getId());
                            break 1;
                        }
                    }

                    if (!$founded) {
                        $city = Doctrine::getTable('City')
                                ->createQuery('c')
                                ->innerJoin('c.County co')
                                ->innerJoin('co.Translation cotr')
                                ->innerJoin('c.Translation ctr')
                                ->where('co.country_id = ?', $tmpCountryId)
                                ->orderBy('c.is_default DESC')->limit(1)->fetchOne();

                        if ($city) {
                            $this->widgetSchema['city_id']->setDefault($city->getId());
                        }
                    }
                }
                else {
                    $city = Doctrine::getTable('City')
                            ->createQuery('c')
                            ->innerJoin('c.County co')
                            ->innerJoin('co.Translation cotr')
                            ->innerJoin('c.Translation ctr')
                            ->where('co.country_id = ?', $tmpCountryId)
                            ->orderBy('c.is_default DESC')
                            ->limit(1)
                            ->fetchOne();

                    if ($city) {
                        $this->widgetSchema['city_id']->setDefault($city->getId());
                    }
                }
            }
            else {
                $this->widgetSchema['country_id']->setDefault(getlokalPartner::getInstance());

                $city = Doctrine::getTable('City')
                        ->createQuery('c')
                        ->innerJoin('c.County co')
                        ->innerJoin('co.Translation cotr')
                        ->innerJoin('c.Translation ctr')
                        ->where('co.country_id = ?', getlokalPartner::getInstance())
                        ->orderBy('c.is_default DESC')
                        ->limit(1)
                        ->fetchOne();
                if ($city) {
                    $this->widgetSchema['city_id']->setDefault($city->getId());
                }
            }
        }
        else {
            //$country_id = sfContext::getInstance()->getUser()->getAttribute(1); //1
            //$this->widgetSchema['country_id']->setDefault(1);
			$city = Doctrine::getTable('City')
			->createQuery('c')
			->innerJoin('c.County co')
// 			->innerJoin('co.Translation cotr')
// 			->innerJoin('c.Translation ctr')
			->where('co.country_id = ?', getlokalPartner::getInstance())
			->orderBy('c.is_default DESC')
			->limit(1)
			->fetchOne();
			if ($city) {
				$this->widgetSchema['city_id']->setDefault($city->getId());
			}

            $this->widgetSchema['country_id']->setDefault(getlokalPartner::getInstance());
/*
            $city = Doctrine::getTable('City')->createQuery('c')->innerJoin('c.County co')->where('co.country_id = ?', getlokalPartner::getInstance())->orderBy('c.is_default DESC')->limit(1)->fetchOne();
            if ($city) {
                $this->widgetSchema['city_id']->setDefault($city->getId());
            }
 */
        }
    }

    //mm/dd/yyyy
    private function _calculateAge($birthDate) {
        $birthDate = explode("/", $birthDate);

        return (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md") ? ((date("Y")-$birthDate[2])-1):(date("Y")-$birthDate[2]));
    }
}
