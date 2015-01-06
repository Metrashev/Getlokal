<?php

class userActions extends sfActions {
    public function executeRegister(sfWebRequest $request) {
        if ($request->getParameter('code', false)) {
            $this->getUser()->setAttribute('code', $request->getParameter('code', false));
        }


        if ($this->getUser()->isAuthenticated()) {
            $isRUPA = (bool) count($this->getUser()->getAdminCompanies());

            $this->redirect($this->generateUrl('default', array('module' => 'home', 'action' => 'index'), true));
            /*if (!$isRUPA) {
                $this->redirect($this->generateUrl('default', array('module' => 'userSettings', 'action' => 'findMyCompany'), true));
            } else {
                $this->redirect($this->generateUrl('default',  array('module' => 'userSettings', 'action' => 'companySettings'), true));
            }*/
        }

        //$this->redirectUnless ( $this->getUser ()->isAnonymous (), 'user/dashboard' );

        $this->form = new OldRegisterForm(null, array('city_is_mandatory' => true));
        $business = $request->getParameter('business', 0);
        if ($business) {
            if (!$this->getUser()->getAttribute('business')) {
                $this->getUser()->setAttribute('business', true);
            }
        }

        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter($this->form->getName()));
            if ($this->form->isValid()) {
                $con = Doctrine::getConnectionByTableName('sfGuardUser');
                $params = $request->getParameter($this->form->getName());
                $formValues = $this->form->getValues();

                $profile = $this->form->updateObject();

                if ($profile->getCountryId() > 4 && $profile->getCountryId() != 78 && $profile->getCountryId() != 151) {
                    $profile->setCityId(NULL);
                }

                $activation_hash = md5(rand(100000, 999999));
                $profile->setHash($activation_hash);
                $user = $this->form->getEmbeddedForm('sf_guard_user')->getObject();
                $user->setUsername(myTools::cleanUrl($user->getFirstName()) . substr(uniqid(md5(rand()), true), 0, 4));
                $user->setIsActive(false);
                $profile->setSfGuardUser($user);

                try {
                    $con->beginTransaction();

                    if (isset($params['gender']) && $params['gender']) {
                        $profile->setGender($params['gender']);
                    }

                    $profile->save();
                    $user_settings = new UserSetting ();
                    $user_settings->setId($profile->getId());

                    if (!isset($params ['allow_contact'])) {
                        $user_settings->setAllowContact(false);
                        $user_settings->setAllowNewsletter(false);
                    } else {
                        $user_settings->setAllowContact(true);
                        $user_settings->setAllowNewsletter(true);
                        $user_settings->setAllowPromo(true);
                    }

                    if (!isset($params ['underage'])) {
                        $user_settings->setUnderage(false);
                    } else {
                        $user_settings->setUnderage(true);
                    }

                    $user_settings->save();

                    $user = $profile->getSfGuardUser();

                    $this->__associatedFriends($profile);
                    $con->commit();
                } catch (Exception $e) {
                    $con->rollback();

                    $this->getUser()->setFlash('error', 'We were unable to send a confirmation request to the email address that you provided. Please check the email you provided is correct.');

                    return sfView::SUCCESS;
                }

                $culture = $this->getUser()->getCulture();
                $i18n = sfContext::getInstance()->getI18N();

                // send welcome email
                try {
                    if ($this->getUser()->getAttribute('business')) {
                        myTools::sendMail($user, 'Welcome to getlokal', 'b_activation', array('user' => $user));
                    } else {
                        myTools::sendMail(
                            $user,
                            $i18n->__('Welcome to getlokal.com', array(), 'user'),
                            'activation',
                            array('user' => $user)
                        );
                    }
                    // sending of email might fail cause of missing template
                } catch (sfRenderException $e) {}



                if ($this->getUser()->getAttribute('newcompany')) {
                    $company = Doctrine::getTable('Company')->findOneById($this->getUser()->getAttribute('newcompany'));

                    if ($company) {
                        if (!$company->getCreatedBy()) {
                            $company->setCreatedBy($user->getId());
                            $company->save();
                        }
                    }

                    $this->getUser()->getAttributeHolder()->remove('newcompany');
                    $this->userStatus = 'company';
                    //$this->getUser()->setFlash('notice', $i18n->__('We just sent a confirmation request to the email address that you provided. Please check your email and click on the link to activate your getlokal account! If you don\'t see the message in your Inbox, please also check your Junk Mail folder. After your account activation you\'ll enter the game'));
                } else {
                    $this->userStatus = 'user';
                    //$this->getUser()->setFlash('notice', $i18n->__('We just sent a confirmation request to the email address that you provided. Please check your email and click on the link to activate your getlokal account! If you don\'t see the message in your Inbox, please also check your Junk Mail folder.'));
                }

                $msg = array('user' => $user, 'object' => 'user', 'action' => 'register');
                $this->dispatcher->notify(new sfEvent($msg, 'user.write_log'));

                //$this->redirect('@sf_guard_signin');
                // $this->setTemplate('thankyouRegister');

                // auto activate users, send only welcome emails
                $request->setParameter('key', $profile->getHash());
                $this->executeActivate($request, false); // activate but don't redirect
                // log user in
                if ($user and $user->getIsActive() && $user instanceof sfGuardUser)
                {
                    $this->getUser()->signIn($user);

                    // if authentication is ok, redirect to home page
                    if ($this->getUser()->isAuthenticated())
                    {
                        if($this->getUser()->hasAttribute('claim.referer') == true){
                            $this->getUser()->setAttribute('home.noticeRUPA', 
                            $i18n->__('<p class="part_one"><span class="greet">Congrats</span> you are our newest registered user.</p><p class="part_two"> Now you can finish claiming your place and update the information about it!</p>',null,'user'));
                        }
                        else{
                            $this->getUser()->setAttribute('home.notice',
                            $i18n->__('<p class="part_one"><span class="greet">Congrats</span> you are our newest registered user.</p><p class="part_two"> Now you can tell everyone about the great places only you know!</p>',null,'user'));
                        }

                        // if the current city is a default one than is ok, otherwise redirect to main city
                        if (!$this->getUser()->getCity()->getIsDefault())
                        {
                            $city = CityTable::getInstance()->createQuery('c')
                                ->where('c.id = ?', getlokalPartner::getDefaultCity())
                                ->fetchOne();
                            if ($city)
                            {
                                $this->redirect($this->generateUrl('home', array(
                                    'city' => $city->getSlug()
                                )));
                            }
                        }

                        if($this->getUser()->hasAttribute('added.companies')){
                            foreach ($this->getUser()->getAttribute('added.companies') as $companyId) {
                                $company = Doctrine::getTable('Company')
                                ->findOneById($companyId);
                                $company->setCreatedBy($this->getUser()->getId());
                                $company->save();
                            }

                        $this->getUser()->getAttributeHolder()->remove('added.companies');
                    }
                
                        $this->authenticationRedirect($request);
                    }
                }

            }
        }
        $i18n = sfContext::getInstance()->getI18N();
        breadCrumb::getInstance()->removeRoot();
        breadCrumb::getInstance()->add($i18n->__ ('Registration', null, 'user'));

        $request->setParameter('no_location', true);
        $this->getResponse()->setTitle('Create new account');
    }
    
    public function executeRegisterSmall(sfWebRequest $request) {
    	if ($request->getParameter('code', false)) {
    		$this->getUser()->setAttribute('code', $request->getParameter('code', false));
    	}
    
    
    	if ($this->getUser()->isAuthenticated()) {
    		$isRUPA = (bool) count($this->getUser()->getAdminCompanies());
    		$this->redirect($this->generateUrl('default', array('module' => 'home', 'action' => 'index'), true));
    		/*if (!$isRUPA) {
    			$this->redirect($this->generateUrl('default', array('module' => 'userSettings', 'action' => 'findMyCompany'), true));
    		} else {
    			$this->redirect($this->generateUrl('default',  array('module' => 'userSettings', 'action' => 'companySettings'), true));
    		}*/
    	}
    
    	//$this->redirectUnless ( $this->getUser ()->isAnonymous (), 'user/dashboard' );
    
    	$this->getUser()->setLoginReferer($request->getReferer());
    	
    	$this->form = new OldRegisterForm(null, array('city_is_mandatory' => true));
    	$business = $request->getParameter('business', 0);
    	if ($business) {
    		if (!$this->getUser()->getAttribute('business')) {
    			$this->getUser()->setAttribute('business', true);
    		}
    	}
    
    	if ($request->isMethod('post')) {
    		if ($trigger_id = $request->getParameter('trigger_id', null)) {
    			$this->getUser()->setAttribute('trigger_id', $trigger_id);
    		}
    		
    		$this->form->bind($request->getParameter($this->form->getName()));
    		if ($this->form->isValid()) {
    			$con = Doctrine::getConnectionByTableName('sfGuardUser');
    			$params = $request->getParameter($this->form->getName());
    			$formValues = $this->form->getValues();
    
    			$profile = $this->form->updateObject();
    
    			if ($profile->getCountryId() > 4 && $profile->getCountryId() != 78 && $profile->getCountryId() != 151) {
    				$profile->setCityId(NULL);
    			}
    
    			$activation_hash = md5(rand(100000, 999999));
    			$profile->setHash($activation_hash);
    			$user = $this->form->getEmbeddedForm('sf_guard_user')->getObject();
    			$user->setUsername(myTools::cleanUrl($user->getFirstName()) . substr(uniqid(md5(rand()), true), 0, 4));
    			$user->setIsActive(false);
    			$profile->setSfGuardUser($user);
    
    			try {
    				$con->beginTransaction();
    
    				if (isset($params['gender']) && $params['gender']) {
    					$profile->setGender($params['gender']);
    				}
    
    				$profile->save();
    				$user_settings = new UserSetting ();
    				$user_settings->setId($profile->getId());
    
    				if (!isset($params ['allow_contact'])) {
    					$user_settings->setAllowContact(false);
    					$user_settings->setAllowNewsletter(false);
    				} else {
    					$user_settings->setAllowContact(true);
    					$user_settings->setAllowNewsletter(true);
    					$user_settings->setAllowPromo(true);
    				}
    
    				if (!isset($params ['underage'])) {
    					$user_settings->setUnderage(false);
    				} else {
    					$user_settings->setUnderage(true);
    				}
    
    				$user_settings->save();
    
    				$user = $profile->getSfGuardUser();
    
    				$this->__associatedFriends($profile);
    				$con->commit();
    			} catch (Exception $e) {
    				$con->rollback();
    
    				$this->getUser()->setFlash('error', 'We were unable to send a confirmation request to the email address that you provided. Please check the email you provided is correct.');
    
    				return sfView::SUCCESS;
    			}
    
    			$culture = $this->getUser()->getCulture();
    			$i18n = sfContext::getInstance()->getI18N();
    
    			// send welcome email
    			try {
    				if ($this->getUser()->getAttribute('business')) {
    					myTools::sendMail($user, 'Welcome to getlokal', 'b_activation', array('user' => $user));
    				} else {
    					myTools::sendMail(
    					$user,
    					$i18n->__('Welcome to getlokal.com', array(), 'user'),
    					'activation',
    					array('user' => $user)
    					);
    				}
    				// sending of email might fail cause of missing template
    			} catch (sfRenderException $e) {}
    
    
    
    			if ($this->getUser()->getAttribute('newcompany')) {
    				$company = Doctrine::getTable('Company')->findOneById($this->getUser()->getAttribute('newcompany'));
    
    				if ($company) {
    					if (!$company->getCreatedBy()) {
    						$company->setCreatedBy($user->getId());
    						$company->save();
    					}
    				}
    
    				$this->getUser()->getAttributeHolder()->remove('newcompany');
    				$this->userStatus = 'company';
    				//$this->getUser()->setFlash('notice', $i18n->__('We just sent a confirmation request to the email address that you provided. Please check your email and click on the link to activate your getlokal account! If you don\'t see the message in your Inbox, please also check your Junk Mail folder. After your account activation you\'ll enter the game'));
    			} else {
    				$this->userStatus = 'user';
    				//$this->getUser()->setFlash('notice', $i18n->__('We just sent a confirmation request to the email address that you provided. Please check your email and click on the link to activate your getlokal account! If you don\'t see the message in your Inbox, please also check your Junk Mail folder.'));
    			}
    
    			$msg = array('user' => $user, 'object' => 'user', 'action' => 'register');
    			$this->dispatcher->notify(new sfEvent($msg, 'user.write_log'));
    
    			//$this->redirect('@sf_guard_signin');
    			$this->setTemplate('thankyouRegister');
    
    			// auto activate users, send only welcome emails
    			$request->setParameter('key', $profile->getHash());
    			$this->executeActivate($request, false); // activate but don't redirect
    			// log user in
    			if ($user and $user->getIsActive() && $user instanceof sfGuardUser)
    			{
    				$this->getUser()->signIn($user);
    
    				// if authentication is ok, redirect to home page
    				if ($this->getUser()->isAuthenticated())
    				{
    					if($this->getUser()->hasAttribute('claim.referer') == true){
    						$this->getUser()->setAttribute('home.noticeRUPA',
    								$i18n->__('<p class="part_one"><span class="greet">Congrats</span> you are our newest registered user.</p><p class="part_two"> Now you can finish claiming your place and update the information about it!</p>',null,'user'));
    					}
    					else{
    						$this->getUser()->setAttribute('home.notice',
    								$i18n->__('<p class="part_one"><span class="greet">Congrats</span> you are our newest registered user.</p><p class="part_two"> Now you can tell everyone about the great places only you know!</p>',null,'user'));
    					}
    
    					// if the current city is a default one than is ok, otherwise redirect to main city
    					if (!$this->getUser()->getCity()->getIsDefault())
    					{
    						$city = CityTable::getInstance()->createQuery('c')
    						->where('c.id = ?', getlokalPartner::getDefaultCity())
    						->fetchOne();
    						if ($city)
    						{
    							$this->redirect($this->generateUrl('home', array(
    									'city' => $city->getSlug()
    							)));
    						}
    					}
    
    					if($this->getUser()->hasAttribute('added.companies')){
    						foreach ($this->getUser()->getAttribute('added.companies') as $companyId) {
    							$company = Doctrine::getTable('Company')
    							->findOneById($companyId);
    							$company->setCreatedBy($this->getUser()->getId());
    							$company->save();
    						}
    
    						$this->getUser()->getAttributeHolder()->remove('added.companies');
    					}
    
    					$this->authenticationRedirect($request);
    				}
    			}
    
    		}
    		else {
    			$this->getUser()->setAttribute('register', $request->getParameter($this->form->getName()));
    			$this->authenticationRedirect($request);
    		}
    	}
    	$i18n = sfContext::getInstance()->getI18N();
    	breadCrumb::getInstance()->removeRoot();
    	breadCrumb::getInstance()->add($i18n->__ ('Registration', null, 'user'));
    
    	$request->setParameter('no_location', true);
    	$this->getResponse()->setTitle('Create new account');
    }

    public function executeSetCountry(sfWebRequest $request) {
        if ($countryName = $request->getPostParameter('countryName', false)) {

            //$countryName = '%' . $countryName . '%';
            //$query = Doctrine_Query::create()->from('Country c')->where('c.name LIKE ? OR c.name_en LIKE ?', array($countryName, $countryName))->limit(20);
            $result = Doctrine_Query::create()->from('Country c')->where('c.name = ? OR c.name_en = ?', array($countryName, $countryName))->fetchOne();

            if ($result) {
                $countryId = $result->getId();
            }
            else {
                $countryId = NULL;
            }

            if ($this->getUser()->getAttribute('registration_profile.countryId', NULL) != $countryId) {
                $reset = true;
            }
            else {
                $reset = false;
            }

            $this->getUser()->setAttribute('registration_profile.countryId', $countryId);

            return $this->renderText(json_encode(array('success' => true, 'resetCity' => $reset, 'countryId' => $countryId)));
        }

        return $this->renderText(json_encode(array('error' => true)));
    }
    
    public function executeSetCity(sfWebRequest $request) {
        $positions = explode(',', $request->getPostParameter('cityName'));
        
        if ($cityName = $positions[0]) {

            $result = Doctrine_Query::create()->from('City c')->innerJoin('c.Translation ct')->where('ct.name = ?', $cityName)->fetchOne();

            if ($result) {
                $cityId = $result->getId();
            }
            else {
                $cityId = NULL;
            }

            if ($this->getUser()->getAttribute('add_company.cityId', NULL) != $cityId) {
                $reset = true;
            }
            else {
                $reset = false;
            }

            $this->getUser()->setAttribute('add_company.cityId', $cityId);

            return $this->renderText(json_encode(array('success' => true, 'cityId' => $cityId)));
        }

        return $this->renderText(json_encode(array('error' => true)));
    }
    
    

    public function executeGetCountriesAutocomplete(sfWebRequest $request) {
        $culture = $this->getUser()->getCulture();
        
        //$culture = sfContext::getInstance()->getUser()->getCulture();
        
        $this->getResponse()->setContentType('application/json');

        $q = "%" . $request->getParameter('term') . "%";

        $limit = $request->getParameter('limit', 20);

        // FIXME: use $limit
        $dql = Doctrine_Query::create()
                ->from('Country c')
                ->where('c.name LIKE ? OR c.name_en LIKE ?', array($q, $q))
                ->andWhere('c.id < 250')
                ->limit($limit);

        $this->rows = $dql->execute();

        $countries = array();
        
        $country = sfContext::getInstance ()->getUser ()->getCountry ()->getId ();
 
        foreach ($this->rows as $row) {
            if ($culture == 'en') {
                $countries [] = array(
                    'id' => $row ['id'],
                    'value' => $row['name_en']
                );
            }
            
            //Country names on english if id of the selected country
            // is different than country of the domain
            elseif($row ['id'] != $country){
                $countries [] = array(
                    'id' => $row ['id'],
                    'value' => $row['name_en']
                );
            }
            else {
                if ($row['name']) {
                    $countries [] = array(
                        'id' => $row ['id'],
                        'value' => $row['name']
                    );
                } else {
                    $countries [] = array(
                        'id' => $row ['id'],
                        'value' => $row['name_en']
                    );
                }
            }
        }

        return $this->renderText(json_encode($countries));
    }

    public function executeGetCitiesAutocomplete(sfWebRequest $request) {
        
        if (!$countryId = $this->getUser()->getAttribute('registration_profile.countryId')) {
            $countryId = null;

        }
        $culture = $this->getUser()->getCulture();
        $this->getResponse()->setContentType('application/json');

        $q = "%" . $request->getParameter('term') . "%";

        $limit = $request->getParameter('limit', 20);

        // FIXME: use $limit
        $dql = Doctrine_Query::create()->from('City c')
                ->innerJoin('c.Translation ctr')
                ->where('ctr.name LIKE ?', $q)
                ->limit($limit);

        if ($countryId) {
            $dql = $dql->innerJoin('c.County cnty')
                        ->innerJoin('cnty.Translation cntytr')
                        ->addWhere('cnty.country_id = ?', $countryId);
        }

        $this->rows = $dql->execute();

        $cities =  array();

        foreach ($this->rows as $row) {
                if ($countryId) {
                        $cities [] = array(
                            'id' => $row ['id'],
                            'value' => mb_convert_case($row->getCityNameByCulture($culture),MB_CASE_TITLE, 'UTF-8'). ', '. mb_convert_case($row->getCounty ()->getCountyNameByCulture($culture), MB_CASE_TITLE, 'UTF-8'));
                }
        }
        

        return $this->renderText(json_encode($cities));
    }

    public function executeFBLogin(sfWebRequest $request) {
        $app_id = "289748011093022";
        $app_secret = "517d65d2648bf350bb303914cb0ec664";

        $my_url = $this->generateUrl('default', array('module' => 'user', 'action' => 'FBLogin'), true);

        // Original
        //$this->getUser()->setLoginReferer($request->getReferer());

        $code = $request->getParameter('code');

        if (empty($code)) {
            $dialog_url = "http://www.facebook.com/dialog/oauth?client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url) . '&scope=user_location,email,user_birthday,offline_access,user_checkins';

            $this->redirect($dialog_url);
        }

        $token_url = "https://graph.facebook.com/oauth/access_token?client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url) . "&client_secret=" . $app_secret . "&code=" . $code;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $token_url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); # required for https urls

        $access_token = curl_exec($ch);

        curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/me?" . $access_token);

        $user_data = json_decode(curl_exec($ch), true);
        curl_close($ch);
        
        if (isset($user_data['id']) && $user_data['id']) {
            $profile = Doctrine::getTable('UserProfile')->findOneByFacebookUid($user_data['id']);
        }

        if (!$profile) {
            if ((!isset($user_data['email']) && !$user_data['email'] = NULL) || !$user = Doctrine::getTable('sfGuardUser')->findOneByEmailAddress($user_data['email'])) {

                if ($this->getUser()->hasAttribute('local.referer')) {
                    $referer = $this->getUser()->getAttribute('local.referer');

                    $this->_clearAllReferers();

                    $this->getUser()->setAttribute('local.redirect', $referer);
                }
                else if ($this->getUser()->hasAttribute('game.referer')) {
                    $redirect = $this->getUser()->getAttribute('game.referer');

                    $this->_clearAllReferers();

                    $this->getUser()->setAttribute('local.redirect', $redirect);
                }
                else if ($this->getUser()->hasFlash('invite.referer')) {
                    $attr = $this->getUser()->getAttribute('invite.referer');

                    $this->_clearAllReferers();

                    $this->getUser()->setAttribute('local.redirect', $attr);
                }
                else if ($this->getUser()->hasAttribute('claim.referer')) {
                    $redirect = $this->getUser()->getAttribute('claim.referer');

                    $this->_clearAllReferers();

                    $this->getUser()->setAttribute('local.redirect', $redirect);
                }
                else if ($referer = $request->getReferer()) {
                    $this->_clearAllReferers();

                    if (strpos($referer, 'register') === false || strpos($referer, 'facebook_confirm_registration') === false) {
                        $this->getUser()->setAttribute('local.redirect', $referer);
                    }
                    else {
                        $this->getUser()->setAttribute('local.redirect', '@homepage');
                    }
                }




                $this->getUser()->setAttribute('facebook_user_data', $user_data);
                $this->getUser()->setAttribute('facebook_access_token', $access_token);
                $this->redirect('@facebook_confirm_registration');
            } else {
                if (!$user->getPassword()) {
                    $password = substr(md5(rand(100000, 999999)), 0, 8);
                    $user->setPassword($password);
                    $user->save();
                }

                $profile = $user->getUserProfile();
            }
        }

        if (!$profile->getFacebookUid())
            $profile->setFacebookUid($user_data ['id']);

        if (!$profile->getCountryId())
            $profile->setCountryId($this->getUser()->getCountry()->getId());

        if (!$profile->getCityId())
            $profile->setCityId($this->getUser()->getCity()->getId());

        $profile->setAccessToken($access_token);
        $profile->save();

        $this->__associatedFriends($profile);
        $this->getUser()->signIn($profile->getSfGuardUser(), true);

        if ($this->getUser()->getCountry()->getId() == $this->getUser()->getProfile()->getCountry()->getId()) {
            $this->getUser()->setCity($this->getUser()->getProfile()->getCity());
            $this->getUser()->setAttribute('user.set_city_after_login', true);
        }


        // Referers
        if ($this->getUser()->hasAttribute('local.referer')) {
            $referer = $this->getUser()->getAttribute('local.referer');

            $this->_clearAllReferers();

            $this->redirect($referer);
        }

        if ($this->getUser()->hasAttribute('game.referer')) {
            $redirect = $this->getUser()->getAttribute('game.referer');

            $this->_clearAllReferers();

            $this->redirect($redirect);
        }

        if ($this->getUser()->hasAttribute('claim.referer')) {
            $redirect = $this->getUser()->getAttribute('claim.referer');

            $this->_clearAllReferers();

            $this->redirect($redirect);
        }

        if ($this->getUser()->hasAttribute('invite.referer')) {
            $attr = $this->getUser()->getAttribute('invite.referer');

            $this->_clearAllReferers();

            $this->redirect($attr);
        }

        if($this->getUser()->hasAttribute('redirect')){
                    $redirect = $this->getUser()->getAttribute('redirect');
                    $this->getUser()->getAttributeHolder()->remove('redirect');
                    $this->redirect($redirect);
        }

        if ($referer = $request->getReferer()) {
            $this->_clearAllReferers();

            if (strpos($referer, 'register') === false || strpos($referer, 'facebook_confirm_registration') === false) {
                $this->redirect($referer);
            }
            else {
                $this->redirect('@homepage');
            }
        }
        else {
            $this->redirect('@homepage');
        }
    }

    private function _clearAllReferers() {
        $this->getUser()->setAttribute('game.referer', NULL);
        $this->getUser()->setAttribute('referer_login', NULL);
        $this->getUser()->setAttribute('local.referer', NULL);
        $this->getUser()->setAttribute('invite.referer', NULL);
        $this->getUser()->setAttribute('referer', NULL);
        $this->getUser()->setAttribute('referer_user_signin', NULL);
        $this->getUser()->setAttribute('redirect_after_login', NULL);
        $this->getUser()->setAttribute('referer_user_facebookConfirmRegistration', NULL);
        $this->getUser()->setAttribute('claim.referer', NULL);
    }

    public function executeFacebookConfirmRegistration(sfWebRequest $request) {
	
        $user_data = $this->getUser()->getAttribute('facebook_user_data', null);
        $access_token = $this->getUser()->getAttribute('facebook_access_token');

        $this->form = new OldRegisterForm(array(), array('facebook_user_data' => $user_data, 'city_is_mandatory' => true));
       
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter($this->form->getName()));
            if ($this->form->isValid()) {
                $values = $this->form->getValues();
                $fbImage = myTools::getResponseData("https://graph.facebook.com/me/picture?type=large&" . $access_token, true);

                $temp_pic = sfConfig::get('sf_upload_dir') . '/' . uniqid('tmp_') . '.jpg';
                file_put_contents($temp_pic, $fbImage);

                $file = new sfValidatedFile(myTools::cleanUrl($user_data['name']) . '.jpg', filetype($temp_pic), $temp_pic, filesize($temp_pic));

                $password = substr(md5(rand(100000, 999999)), 0, 8);

                $user = new sfGuardUser();
                $user->setEmailAddress($values['sf_guard_user']['email_address']);
                $user->setUsername(substr(uniqid(md5(rand()), true), 0, 8));
                $user->setFirstName($values['sf_guard_user']['first_name']);
                $user->setLastName($values['sf_guard_user']['last_name']);
                $user->setPassword($password);
                $user->save();

                $date = DateTime::createFromFormat('m/d/Y', $user_data['birthday']);


                $profile = new UserProfile();
                $profile->setId($user->getId());

                if (isset($values['gender']) && $values['gender']) {
                    $profile->setGender($values['gender']);
                }
                else {
                    $profile->setGender($user_data['gender'] == 'male' ? 'm' : 'f' );
                }

                $profile->setBirthDate($date->format('Y-m-d'));
                $profile->setFacebookUrl($user_data['link']);
                $profile->setFacebookUid($user_data['id']);
                $profile->setAccessToken($access_token);

                // $city = $country = null;
                $country = $values['country_id'];
                $city = $values['city_id'];

                // if ($country > 4) {
                //     $city = NULL;
                // }
                // else {
                // }

                $profile->setCountryId($country);
                $profile->setCityId($city);
                $profile->save();


                $image = new Image();
                $image->setFile($file);
                $image->setUserId($profile->getId());
                $image->setCaption($user_data['name']);
                $image->setType('profile');
                $image->setStatus('approved');
                $image->save();


                $profile->clearRelated();
                $profile->setImageId($image->getId());
                $profile->save();
                @unlink($temp_pic);


                $user_settings = new UserSetting();
                $user_settings->setId($profile->getId());

                if ($profile->getCountryId() > 4 && $profile->getCountryId() !=78 ) {
                    if (!$values['allow_contact']) {
                        $user_settings->setAllowContact(false);
                        $user_settings->setAllowNewsletter(false);
                    }
                    else {
                        $user_settings->setAllowContact(true);
                        $user_settings->setAllowNewsletter(false);
                    }
                }
                else {
                    if (!$values['allow_contact']) {
                        $user_settings->setAllowContact(false);
                        $user_settings->setAllowNewsletter(false);
                    } else {
                        $user_settings->setAllowContact(true);
                        $user_settings->setAllowNewsletter(true);
                        $user_settings->setAllowPromo(true);
                    }
                }

                if (!isset($values['underage'])) {
                    $user_settings->setUnderage(false);
                } else {
                    $user_settings->setUnderage(true);
                }

                if($this->getUser()->hasAttribute('added.companies')){
                    foreach ($this->getUser()->getAttribute('added.companies') as $companyId) {
                        $company = Doctrine::getTable('Company')
                        ->findOneById($companyId);
                        $company->setCreatedBy($this->getUser()->getId());
                        $company->save();
                    }

                    $this->getUser()->getAttributeHolder()->remove('added.companies');
                }

                $user_settings->save();


                // Subscribe to newsletter
                $newsletters = NewsletterTable::retrieveActivePerCountryForUser($profile->getCountryId());
                if ($newsletters) {
                    foreach ($newsletters as $newsletter) {
                        $usernewsletter = new NewsletterUser ();
                        $usernewsletter->setNewsletterId($newsletter->getId());
                        $usernewsletter->setUserId($user->getId());
                        $usernewsletter->setIsActive($values['allow_contact']);
                        $usernewsletter->save();
                    }

                    MC::subscribe_unsubscribe($user);
                }
                
                myTools::sendMail($user, 'Welcome to getlokal', 'fbRegister', array('password' => $password));


                $this->__associatedFriends($profile);
                $this->getUser()->signIn($profile->getSfGuardUser(), true);
                $this->__calculateGamePoints(NULL, $profile->getFacebookUid());

                if ($this->getUser()->getCountry()->getId() == $this->getUser()->getProfile()->getCountry()->getId()) {
                    $this->getUser()->setCity($this->getUser()->getProfile()->getCity());
                    $this->getUser()->setAttribute('user.set_city_after_login', true);
                }

                if ($redirect = $this->getUser()->getAttribute('local.redirect', false)) {
                    $this->getUser()->setAttribute('local.redirect', NULL);

                    $this->redirect($redirect);
                }

                if($this->getUser()->hasAttribute('redirect')){
                    $redirect = $this->getUser()->getAttribute('redirect');
                    $this->getUser()->getAttributeHolder()->remove('redirect');
                    $this->redirect($redirect);
                }

                $this->redirect('@homepage');
            }
        }

        $this->getResponse()->setTitle('Create new account');
    }


    public function executeSignout(sfWebRequest $request) {
        $this->getUser ()->signOut ();
        $this->getUser ()->setAttribute ( 'edit', false );

        $this->redirect ( $request->getReferer () );
    }

    public function executeSignin(sfWebRequest $request) {

        if ($this->getUser()->isAuthenticated()) {
            $isRUPA = (bool) count($this->getUser()->getAdminCompanies());

            if (!$isRUPA) {
                $this->redirect($this->generateUrl('default', array('module' => 'userSettings', 'action' => 'findMyCompany'), true));
            } else {
                $this->redirect($this->generateUrl('default',  array('module' => 'userSettings', 'action' => 'companySettings'), true));
            }
        }


        if ($this->getUser ()->getPageAdminUser ()) {
            $this->getUser ()->signOutPageAdmin ();
        } elseif($this->getUser ()->getGuardUser()) {
            return $this->redirect ( '@homepage' );
        }

        $this->getUser()->setLoginReferer($request->getReferer());

        $this->form = new sfGuardFormSignin ();
        $business = $request->getParameter ( 'business', 0 );
        if ($business) {
            if (! $this->getUser ()->getAttribute ( 'business' )) {
                $this->getUser ()->setAttribute ( 'business', true );
            }
        }
       $redirect_to_company = $request->getParameter ( 'my_company', null );
        if ($redirect_to_company) {
            if (! $this->getUser ()->getAttribute ( 'my_company' )) {
                $this->getUser ()->setAttribute ( 'my_company', true );
            }
        }
        $this->addplace = $request->getParameter ( 'reviewplace', 0 );

        if ($request->getParameter('local_referer'))
        {
            $this->getUser()->setAttribute('local.referer', $request->getParameter('local_referer'));
        }

        if ($request->isMethod ( 'post' ) && $this->getContext ()->getActionStack ()->getSize () <= 1) {
            $this->form->bind ( $request->getParameter ( 'signin' ) );
            if ($this->form->isValid ()) {

                $values = $this->form->getValues ();
                $this->getUser ()->signin ( $values ['user'], array_key_exists ( 'remember', $values ) ? $values ['remember'] : false );

                $vid = $this->getUser()->getAttribute('pilot_id_redirect');

                if($this->getUser()->hasAttribute('added.companies')){

                    foreach ($this->getUser()->getAttribute('added.companies') as $companyId) {
                        $company = Doctrine::getTable('Company')
                        ->findOneById($companyId);

                        if($company != null){
                            $company->setCreatedBy($this->getUser()->getId());
                            $company->save();
                        }
                    }
                    $this->getUser()->getAttributeHolder()->remove('added.companies');
                }

                $this->authenticationRedirect($request);


                                /* OLD
                if (! $redirect) // Trying referer
                                {
                    $redirect = $this->getUser ()->getAttribute ( 'referer', $this->getRequest ()->getReferer () );
                    $this->getUser ()->getAttributeHolder ()->remove ( 'referer' );
                }

                if (! $redirect) // Getting default redirect route
                                {
                    if ($this->getUser ()->getUserProfile ()->isPageAdmin ()) {
                        $redirect = 'userSettings/companySettings';
                    } else {
                        //$redirect = sfConfig::get('app_sf_guard_plugin_success_signin_url', '@homepage');
                        $redirect = 'userSettings/accountSettings';
                    }
                }

                                if ($this->getUser()->hasAttribute('game.referer')) {
                                    $redirect = $this->getUser()->getAttribute('game.referer');
                                    $this->getUser()->setAttribute('game.referer', NULL);
                                }

                $this->redirect ( $redirect );
                                */
            }
        } else {
            if (! $request->isXmlHttpRequest ()) {

                $this->getResponse ()->setStatusCode ( 401 );
            }

            // if we have been forwarded, then the referer is the current URL
            // if not, this is the referer of the current request
            $this->getUser ()->setReferer ( $this->getContext ()->getActionStack ()->getSize () > 1 ? $request->getUri () : $request->getReferer () );

        }
        breadCrumb::getInstance()->removeRoot();
        breadCrumb::getInstance()->add('Login', null, 'user');

        $request->getParameterHolder()->set('bodyId', 'login');

    }
    
    public function executeSigninSmall(sfWebRequest $request) {
    
    	if ($this->getUser()->isAuthenticated()) {
    		$isRUPA = (bool) count($this->getUser()->getAdminCompanies());
    
    		if (!$isRUPA) {
    			$this->redirect($this->generateUrl('default', array('module' => 'userSettings', 'action' => 'findMyCompany'), true));
    		} else {
    			$this->redirect($this->generateUrl('default',  array('module' => 'userSettings', 'action' => 'companySettings'), true));
    		}
    	}
    
    
    	if ($this->getUser ()->getPageAdminUser ()) {
    		$this->getUser ()->signOutPageAdmin ();
    	} elseif($this->getUser ()->getGuardUser()) {
    		return $this->redirect ( '@homepage' );
    	}
    
    	$this->getUser()->setLoginReferer($request->getReferer());
    
    	$this->form = new sfGuardFormSignin ();
    	$business = $request->getParameter ( 'business', 0 );
    	if ($business) {
    		if (! $this->getUser ()->getAttribute ( 'business' )) {
    			$this->getUser ()->setAttribute ( 'business', true );
    		}
    	}
    
    	$redirect_to_company = $request->getParameter ( 'my_company', null );
    	if ($redirect_to_company) {
    		if (! $this->getUser ()->getAttribute ( 'my_company' )) {
    			$this->getUser ()->setAttribute ( 'my_company', true );
    		}
    	}
    	$this->addplace = $request->getParameter ( 'reviewplace', 0 );
    
    	if ($request->getParameter('local_referer'))
    	{
    		$this->getUser()->setAttribute('local.referer', $request->getParameter('local_referer'));
    	}
    
    	if ($request->isMethod ( 'post' ) && $this->getContext ()->getActionStack ()->getSize () <= 1) {
    		if ($trigger_id = $request->getParameter('trigger_id', null)) {
    			$this->getUser()->setAttribute('trigger_id', $trigger_id);
    		}
    		
    		$this->form->bind ( $request->getParameter ( 'signin' ) );
    		if ($this->form->isValid ()) {
    
    			$values = $this->form->getValues ();
    			$this->getUser ()->signin ( $values ['user'], array_key_exists ( 'remember', $values ) ? $values ['remember'] : false );
    
    			$vid = $this->getUser()->getAttribute('pilot_id_redirect');
    
    			if($this->getUser()->hasAttribute('added.companies')){
    
    				foreach ($this->getUser()->getAttribute('added.companies') as $companyId) {
    					$company = Doctrine::getTable('Company')
    					->findOneById($companyId);
    
    					if($company != null){
    						$company->setCreatedBy($this->getUser()->getId());
    						$company->save();
    					}
    				}
    				$this->getUser()->getAttributeHolder()->remove('added.companies');
    			}
    
    			$this->authenticationRedirect($request);
    
    			/* OLD
    			 if (! $redirect) // Trying referer
    			{
    			$redirect = $this->getUser ()->getAttribute ( 'referer', $this->getRequest ()->getReferer () );
    			$this->getUser ()->getAttributeHolder ()->remove ( 'referer' );
    			}
    
    			if (! $redirect) // Getting default redirect route
    			{
    			if ($this->getUser ()->getUserProfile ()->isPageAdmin ()) {
    			$redirect = 'userSettings/companySettings';
    			} else {
    			//$redirect = sfConfig::get('app_sf_guard_plugin_success_signin_url', '@homepage');
    			$redirect = 'userSettings/accountSettings';
    			}
    			}
    
    			if ($this->getUser()->hasAttribute('game.referer')) {
    			$redirect = $this->getUser()->getAttribute('game.referer');
    			$this->getUser()->setAttribute('game.referer', NULL);
    			}
    
    			$this->redirect ( $redirect );
    			*/
    		}
    		else {
    			$this->getUser()->setAttribute('signin', $request->getParameter( 'signin' ));
    			//$request->setParameter('signin', $request->getParameter ( 'signin' ));
    			$this->authenticationRedirect($request);
    		}
    	} else {
    		if (! $request->isXmlHttpRequest ()) {
    			$this->getResponse ()->setStatusCode ( 401 );
    		}
    
    		// if we have been forwarded, then the referer is the current URL
    		// if not, this is the referer of the current request
    		$this->getUser ()->setReferer ( $this->getContext ()->getActionStack ()->getSize () > 1 ? $request->getUri () : $request->getReferer () );
    
    
    	}
    	breadCrumb::getInstance()->removeRoot();
    	breadCrumb::getInstance()->add('Login', null, 'user');
    
    	$request->getParameterHolder()->set('bodyId', 'login');
    
    }

    protected function authenticationRedirect($request)
    {
        $redirect = $this->getUser()->getLoginReferer();

        $this->userStatus = 'user'; // required in thank you register template
        if ($this->getUser()->getAttribute('newcompany')) {
            $company = Doctrine::getTable('Company')
                ->findOneById($this->getUser()->getAttribute('newcompany'));
            if ($company) {
                if (!$company->getCreatedBy()) {
                    $company->setCreatedBy($this->getUser()->getId());
                    $company->save();
                }
            }

            $this->getUser()->getAttributeHolder()->remove('newcompany');
            $this->userStatus = 'company';
        }

        if($this->getUser()->hasAttribute('redirect')){
            $redirect = $this->getUser()->getAttribute('redirect');
            $this->getUser()->getAttributeHolder()->remove('redirect');
            $this->redirect($redirect);
        }

        if ($this->getUser()->getAttribute('business')) {
            $redirect = 'userSettings/findMyCompany';
             $i18n = sfContext::getInstance ()->getI18N ();
            $redirect = 'userSettings/findMyCompany';
            $this->getUser()->setAttribute('home.notice', null);
            // Change the message below when RUPA has registered
//            $this->getUser()->setAttribute('home.noticeRUPA',
//   						$i18n->__('<p class="part_one"><span class="greet">Congrats</span> you are our newest registered user.</p><p class="part_two"> Now you can finish claiming your place and update the information about it!</p>',null,'user'));
            $this->getUser()->getAttributeHolder()->remove('business');
             $this->redirect($redirect);
        }
        if ($this->getUser()->getAttribute('my_company')) {
            $redirect = 'userSettings/companySettings';
            $this->getUser()->getAttributeHolder()->remove('my_company');
             $this->redirect($redirect);
        }

        if ($this->getUser()->getCountry()->getId() == $this->getUser()->getProfile()->getCountry()->getId()) {
            $this->getUser()->setCity($this->getUser()->getProfile()->getCity());
            $this->getUser()->setAttribute('user.set_city_after_login', true);
        }


        // New
        // Referers
        if ($this->getUser()->hasAttribute('local.referer')) {
            $referer = $this->getUser()->getAttribute('local.referer');
            $this->_clearAllReferers();

            $this->redirect($referer);
        }

        if ($this->getUser()->hasAttribute('game.referer')) {
            $redirect = $this->getUser()->getAttribute('game.referer');
            $this->_clearAllReferers();

            $this->redirect($redirect);
        }

        if ($this->getUser()->hasAttribute('claim.referer')) {
            $redirect = $this->getUser()->getAttribute('claim.referer');
//            $i18n = sfContext::getInstance ()->getI18N ();
//            $this->getUser()->setAttribute('home.notice', null);
//            $this->getUser()->setAttribute('home.noticeRUPA', 
//                $i18n->__('<p class="part_one"><span class="greet">Congrats</span> you are our newest registered user.</p><p class="part_two"> Now you can finish claiming your place and update the information about it!</p>',null,'user'));
            $this->_clearAllReferers();

            $this->redirect($redirect);
        }


        if ($this->getUser()->hasAttribute('invite.referer')) {
            $attr = $this->getUser()->getAttribute('invite.referer');

            $this->_clearAllReferers();

            $this->redirect($attr);
        }

        if ($referer = $this->getUser()->getLoginReferer()) {
            $this->_clearAllReferers();

            if (strpos($referer, 'register') === false && strpos($referer, 'login') === false)
            {
                $this->redirect($referer);
            }
            else
            {
                $this->redirect('@homepage');
            }
        }
    }

    public function executeActivate(sfWebRequest $request, $redirect = true)
    {

        /*
         * $this->user and $this->activation has been set in validateActivate()
         */

        if ($this->validateActivate() == false) {
            return sfView::ERROR;
        }
        $i18n = sfContext::getInstance ()->getI18N ();
        $this->user->setIsActive ( true );
        $this->user->save ();
        $newsletters = NewsletterTable::retrieveActivePerCountryForUser ( $this->user->getUserProfile ()->getCountryId () );
        if ($newsletters) {
            foreach ( $newsletters as $newsletter ) {
                $usernewsletter = new NewsletterUser ();
                $usernewsletter->setNewsletterId ( $newsletter->getId () );
                $usernewsletter->setUserId ( $this->user->getId () );
                $usernewsletter->setIsActive ( $this->user->getUserProfile ()->getUserSetting ()->getAllowContact () );
                $usernewsletter->save ();
            }

            MC::subscribe_unsubscribe($this->user);
        }

        $this->__calculateGamePoints($this->user->getEmailAddress());

        // $this->purgePersonRelatedCache($this->user);
        try {
            if ($redirect) {
                $this->getUser()->setFlash('notice', 'Your account has been activated. You can now log in using the email and password you provided at registration time.');
            }

            $msg = array ('user' => $this->user, 'object' => 'user', 'action' => 'activate' );
            $this->dispatcher->notify ( new sfEvent ( $msg, 'user.write_log' ) );

            if ($redirect)
            {
                if (! $this->getUser ()->getAttribute ( 'redirect_after_login' )) {
                    $path = 'home/index';

                    $this->getUser ()->setAttribute ( 'redirect_after_login', $path );
                }
                $this->redirect ( '@sf_guard_signin' );
            }
        } catch ( sfStopException $e ) {
            throw $e;
        } catch ( Exception $e ) {
            $this->getUser ()->setFlash ( 'error', 'An error ocurred while trying to activate your account.' );
            sfContext::getInstance ()->getLogger ()->err ( 'An error ocurred while trying to activate your account.' . $e->getMessage () );
            return sfView::ERROR;
        }
        $request->setParameter ( 'no_location', true );
        $this->getResponse ()->setTitle ( 'Account Activation' );
    }

    protected function validateActivate($business = false) {
        $i18n = sfContext::getInstance ()->getI18N ();
        $this->key = $this->getRequestParameter ( 'key', null );

        $profile = Doctrine::getTable ( 'UserProfile' )->findOneByHash ( $this->key );

        if (! $profile) {
            $this->getUser ()->setFlash ( 'errors', 'Unable to find user to activate' );
            return false;
        }

        $this->user = $profile->getSfGuardUser ();
        if (! $this->user) {
            $this->getRequest ()->setFlash ( 'error', 'Unable to find user to activate' );
            return false;
        }

        if ($this->user->getIsActive ()) {
            if ($business) {
                $this->getUser ()->setAttribute ( 'redirect_after_login', 'userSettings/companySettings' );
            }
            $this->getUser ()->setFlash ( 'error', 'Related account has already been activated' );
            return false;
        }

        return true;
    }

    public function executePlaceAdminActivate(sfWebRequest $request) {
        if ($this->validateActivate ( true ) == false) {
            $this->redirect ( 'user/signin' );
        }

        $i18n = sfContext::getInstance ()->getI18N ();

        $this->form = new PlaceAdminActivateForm ();

        if ($request->isMethod ( 'post' )) {

            $this->form->bind ( $request->getParameter ( $this->form->getName () ) );
            if ($this->form->isValid ()) {
                $values = $this->form->getValues ();

                $allow_b_cmc = false;
                if (isset ( $values ['allow_b_cmc'] )) {
                    $allow_b_cmc = true;
                }



                if ($values ['user']->getId () != $this->user->getId ()) {
                    $this->redirect ( 'user/secure' );
                }

                $this->user->setIsActive ( true );
                $this->user->save ();

                $userSetting = $this->user->getUserProfile ()->getUserSetting ();
                $userSetting->setAllowBCmc ( $allow_b_cmc );
                $userSetting->save ();
                $newsletters = NewsletterTable::retrieveActivePerCountryForBusiness ( $this->user->getUserProfile ()->getCountryId () );
                if ($newsletters) {
                    foreach ( $newsletters as $newsletter ) {
                        $usernewsletter = new NewsletterUser ();
                        $usernewsletter->setNewsletterId ( $newsletter->getId () );
                        $usernewsletter->setUserId ( $this->user->getId () );
                        $usernewsletter->setIsActive ( $allow_b_cmc );
                        $usernewsletter->save ();
                    }
                }
                $this->getUser ()->signin ( $values ['user'], array_key_exists ( 'remember', $values ) ? $values ['remember'] : false );

                                if ($this->getUser()->getCountry()->getId() == $this->getUser()->getProfile()->getCountry()->getId()) {
                                    $this->getUser()->setCity($this->getUser()->getProfile()->getCity());
                                    $this->getUser()->setAttribute('user.set_city_after_login', true);
                                }

                $msg = array ('user' => $this->user, 'object' => 'user', 'action' => 'activate' );
                $this->dispatcher->notify ( new sfEvent ( $msg, 'user.write_log' ) );
                $this->redirect ( 'userSettings/companySettings' );

        // $this->purgePersonRelatedCache($this->user);
            }
        }
        $request->setParameter ( 'no_location', true );
        $this->getResponse ()->setTitle ( 'Account Activation' );
    }

    protected function generatePassword() {
        $salt = "abchefghjkmnpqrstuvwxyz0123456789";
        $pass = '';
        srand ( ( double ) microtime () * 1000000 );
        $i = 0;
        while ( $i <= 7 ) {
            $num = rand () % 33;
            $tmp = substr ( $salt, $num, 1 );
            $pass = $pass . $tmp;
            $i ++;
        }

    }

    public function executeForgotPassword(sfWebRequest $request) {

        if ($this->getUser ()->isAuthenticated ()) {
            $this->redirect ( '@homepage' );
        }
        $this->show_reslend_activation = false;
        $this->form = new ForgotPasswordForm ();

        if ($request->isMethod ( 'post' )) {
            $this->form->bind ( $request->getParameter ( 'forgot_password' ), $request->getFiles ( 'forgot_password'.rand(1, 999) ) );

            if ($this->form->isValid ()) {

                $password = substr ( md5 ( rand ( 100000, 999999 ) ), 0, 8 );
                $params = $request->getParameter ( 'forgot_password', array () );
                $email = mb_strtolower ( $params ['email'] );
                $user = Doctrine::getTable ( 'sfGuardUser' )->findOneByEmailAddress ( $email );

                $con = Doctrine::getConnectionByTableName ( 'sfGuardUser' );
                if (! $user) {
                    $this->getUser ()->setFlash ( 'error', 'There is no registered profile with this email address' );
                    return sfView::SUCCESS;
                } elseif (! $user->getIsActive ()) {
                    $this->show_reslend_activation = true;
                    $i18n = sfContext::getInstance ()->getI18N ();
                    $this->getUser ()->setFlash ( 'error', $i18n->__ ( 'We can\'t send you a new password because your profile hasn\'t been activated yet. Click on \'Resend an activation mail\' and follow the instructions there.' ) );
                    return sfView::SUCCESS;
                }

                else {
                    if (in_array ( $user->getId (), sfConfig::get ( 'app_getlokal_power_user', array () ) )) {
                        $this->redirect ( 'user/secure' );
                    }
                    try {
                        $con->beginTransaction ();
                        $user->setPassword ( $password );
                        $user->save ();
                        $con->commit ();

                    } catch ( Exception $e ) {
                        $con->rollback ();

                        $this->getUser ()->setFlash ( 'error', 'We were unable to send you a new password.' );
                        return sfView::SUCCESS;

                    }

                    myTools::sendMail ( $user, 'Forgotten Password', 'forgotPassword', array ('password' => $password ) );
                    if (! $this->getUser ()->getFlash ( 'error' )) {
                        $this->getUser ()->setFlash ( 'notice', 'The new password was sent successfully to the email you provided.' );
                        $this->redirect ( '@sf_guard_signin' );
                    }
                }
            }
        }

        breadCrumb::getInstance()->removeRoot();
        breadCrumb::getInstance()->add('Forgotten Password', null, 'pagetitle');
        $request->setParameter('no_location', true);
        $this->getResponse()->setTitle('Forgotten Password');
    }

    public function executeSecure($request) {
        $this->getResponse ()->setStatusCode ( 403 );
    }

        public function in_array_r($needle, $haystack, $strict = false) {
        foreach ( $haystack as $item ) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array ( $item ) && $this->in_array_r ( $needle, $item, $strict ))) {
                return true;
            }
        }

        return false;
    }

    public function executeResendActivationEmail(sfWebRequest $request) {

        if ($this->getUser ()->isAuthenticated ()) {
            $this->redirect ( '@homepage' );
        }

        $this->form = new ForgotPasswordForm ();

        if ($request->isMethod ( 'post' )) {
            $this->form->bind ( $request->getParameter ( 'forgot_password' ), $request->getFiles ( 'forgot_password' ) );

            if ($this->form->isValid ()) {
                $i18n = sfContext::getInstance ()->getI18N ();
                $email = mb_strtolower ( $this->form->getValue ( 'email' ) );

                $user = Doctrine_Query::create ()->select ( 'u.*' )->from ( 'sfGuardUser u' )->where ( 'email_address= ? ', $email )->fetchOne ();
                if (! $user) {
                    $this->getUser ()->setFlash ( 'error', 'There is no registered profile with this email address' );
                    return sfView::SUCCESS;
                } elseif ($user->getIsActive ()) {
                    $this->getUser ()->setFlash ( 'error', $i18n->__ ( 'We can\'t send you a new activation email because your profile is already active.' ) );
                    return sfView::SUCCESS;
                } else {
                    if (!$user->getUserProfile()->getHash())
                    {
                      $activation_hash = md5 ( rand ( 100000, 999999 ) );
                      $user->getUserProfile()->setHash ( $activation_hash );
                      $user->getUserProfile()->save();
                    }
                    myTools::sendMail ( $user, 'Getlokal Account Activation', 'activation', array ('user' => $user ) );

                    $this->getUser ()->setFlash ( 'notice', $i18n->__ ( 'We just sent a confirmation request to the email address that you provided. Please check your email and click on the link to activate your Getlokal account! If you don\'t see the message in your Inbox, please also check your Junk Mail folder.' ) );
                    $this->redirect ( '@sf_guard_signin' );

                }
            }
        }
        $request->setParameter ( 'no_location', true );
        $this->getResponse ()->setTitle ( 'Resend activation email' );
    }

    public function executeAddCrmUser(sfWebRequest $request) {
        $this->user = $this->getUser ()->getGuardUser ();

        $this->form = new NewCRMUserForm ( null, array ('user' => $this->user ) );

    }
    public function executeDeactivated(sfWebRequest $request) {

    }

        private function __getPoints($hash = null, $email = null, $facebookUID = null) {
            if (!$hash) return 0;

            $query = Doctrine::getTable('InvitedUser')
                    ->createQuery('iu')
                    ->where('iu.hash = ?', array($hash));

            if ($email) {
                $query->andWhere('iu.email = ?', array($email));
            }
            elseif ($facebookUID) {
                $query->andWhere('iu.email = ?', array($facebookUID));
            }

            $result = $query->fetchOne(array(), Doctrine_Core::HYDRATE_RECORD);
            if ($result) {
                return $result->getPointsToInvited();
            }
        }

        public function __associatedFriends($invitedUser) {
            if ($code = $this->getUser()->getAttribute('code', false)) {
                //$invitedUserTable = Doctrine::getTable('InvitedUser')->findOneByHash($code);

                $email = $invitedUser->getSfGuardUser()->getEmailAddress();
                $facebookUID = $invitedUser->getFacebookUid();
                $invitedUserTable = Doctrine::getTable('InvitedUser')
                        ->createQuery('iu')
                        ->where('iu.hash = ?', $code)
                        ->andWhere('iu.email = ? or iu.facebook_uid = ?', array($email, $facebookUID))
                        ->fetchOne();

                if ($invitedUserTable && $userWhoSentInvite = Doctrine::getTable('UserProfile')->findOneById($invitedUserTable->getUserId())) {
                    $points = $userWhoSentInvite->getPoints() + $invitedUserTable->getPointsToUser();
                    $userWhoSentInvite->setPoints($points);
                    $userWhoSentInvite->save();
                }

                $pointsToInvited = 0;
                if ($invitedUserTable) {
                    $pointsToInvited = $invitedUserTable->getPointsToInvited();
                }

                $points = $invitedUser->getPoints() + $pointsToInvited;
                $invitedUser->setPoints($points);
                $invitedUser->save();

                $friendList = new friendList();
                $friendList->setUserId1($userWhoSentInvite->getId());
                $friendList->setUserId2($invitedUser->getId());

                $friendList->save();

                // Delete current record
                // Deprecated after new specification
                //$invitedUserTable->delete();

                $this->getUser()->setAttribute('code', null);
            }
            else {
                // Set relation by e-mail of fb
                $email = $invitedUser->getSfGuardUser()->getEmailAddress();
                $facebookUID = $invitedUser->getFacebookUid();
                $query = Doctrine::getTable('InvitedUser')
                        ->createQuery('iu')
                        ->where('iu.email = ?', $email)
                        ->orWhere('iu.facebook_uid = ?', $facebookUID);

                if ($friends = $query->execute()) {
                    foreach ($friends as $friend) {
                        $friendList = new friendList();
                        $friendList->setUserId1($invitedUser->getId());
                        $friendList->setUserId2($friend->getUserId());
                        $friendList->save();

                        // Deprecated after new specification
                        //$friend->delete();
                    }
                }
            }
        }

        private function __calculateGamePoints($email = null, $facebookUID = null) {
            $gameCode = null;
            $gameType = null;
            $gameId = null;

            if ($this->getUser()->hasAttribute('luckyTreeCode', false)) {
                $gameCode = $this->getUser()->getAttribute('luckyTreeCode', '');
                $gameType = 'LuckyTree';

                if ($this->getUser()->getCulture() == 'bg') {
                    $gameId = 5;
                }
                elseif ($this->getUser()->getCulture() == 'mk') {
                    $gameId = 6;
                }
                elseif ($this->getUser()->getCulture() == 'sr') {
                    $gameId = 7;
                }
                else {
                    $gameId = 5;
                }
            }
            else {
                if ($this->getUser()->getCulture() == 'bg') {
                    $gameId = 5;
                }
                elseif ($this->getUser()->getCulture() == 'mk') {
                    $gameId = 6;
                }
                elseif ($this->getUser()->getCulture() == 'sr') {
                    $gameId = 7;
                }
                else {
                    $gameId = 5;
                }
            }

            $this->getUser()->setAttribute('luckyTreeCode', NULL);

            if (true || $gameCode) {
                $query = Doctrine::getTable('InvitedUser')
                         ->createQuery('iu');
                         //->where('iu.hash = ?', $gameCode);

                if ($email) {
                    $query->andWhere('iu.email =?', $email);
                }
                elseif ($facebookUID) {
                    $query->andWhere('iu.facebook_uid =?', $facebookUID);
                }

                $query->addGroupBy('iu.user_id');

                $result = $query->execute();

                //if ($result = $query->fetchOne()) {
                foreach ($result as $res) {
                    $sQuery = Doctrine::getTable('FacebookReviewGameUser')
                             ->createQuery('frgu')
                             ->where('frgu.facebook_review_game_id =?', $gameId)
                             ->andWhere('frgu.user_id =?', $res->getUserId());
                             // without a code
                             //->andWhere('frgu.hash =?', $gameCode);

                    if ($sResul = $sQuery->fetchOne()) {
                        $points = $sResul->getPoints() + 1;
                        $sResul->setPoints($points);
                        $sResul->save();
                    }
                }
            }
            else {
                $query = Doctrine::getTable('InvitedUser')
                         ->createQuery('iu');

                if ($email) {
                    $query->andWhere('iu.email =?', $email);
                }
                elseif ($facebookUID) {
                    $query->andWhere('iu.facebook_uid =?', $facebookUID);
                }

                $result = $query->execute();

                foreach ($result as $res) {
                    $sQuery = Doctrine::getTable('FacebookReviewGameUser')
                             ->createQuery('frgu')
                             ->where('frgu.facebook_review_game_id =?', $gameId)
                             ->andWhere('frgu.user_id =?', $res->getUserId());
                             // without a code
                             //->andWhere('frgu.hash =?', $res->getHash());

                    if ($sResul = $sQuery->fetchOne()) {
                        $points = $sResul->getPoints() + 1;
                        $sResul->setPoints($points);
                        $sResul->save();
                    }
                }
            }
        }
}
