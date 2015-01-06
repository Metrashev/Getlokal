<?php

// Export file fields: E-mail, First Name, Last Name, Group (ex.: user, user_weeklynewsletter, business), City, County

/*
 * MYSQL VIEW FOR EXPORT
DROP view newsletter_user_view;

CREATE VIEW newsletter_user_view AS
SELECT sgu.email_address AS EMAIL, sgu.first_name AS FNAME, sgu.last_name AS LNAME, c.slug AS CITY
FROM sf_guard_user AS sgu
INNER JOIN user_profile AS up ON (sgu.id = up.id)
INNER JOIN city AS c ON (up.city_id = c.id)
INNER JOIN newsletter_user AS nu ON (sgu.id = nu.user_id)
WHERE nu.is_active = 1 AND nu.newsletter_id = 1
ORDER BY sgu.id DESC


SELECT SELECT sgu.email_address AS EMAIL, sgu.first_name AS FNAME, sgu.last_name AS LNAME, c.slug AS CITY
FROM newsletter_user n
INNER JOIN user_profile u ON n.user_id = u.id
INNER JOIN user_setting u2 ON u.id = u2.id
INNER JOIN user_profile u3 ON n.user_id = u3.id
INNER JOIN sf_guard_user AS sgu ON (u.id = sgu.id)
LEFT JOIN city AS c ON (u.city_id = c.id)
WHERE (n.newsletter_id = '1' AND n.is_active = '1' AND (u2.allow_contact = 1 AND allow_newsletter = 1) AND u3.country_id = '1%') ORDER BY n.id desc


OPTIIZED
CREATE VIEW newsletter_export_user AS
SELECT sgu.email_address AS EMAIL, sgu.first_name AS FNAME, sgu.last_name AS LNAME, c.slug AS CITY
FROM sf_guard_user AS sgu
INNER JOIN user_profile AS up ON (sgu.id = up.id)
LEFT JOIN city AS c ON (up.city_id = c.id)
INNER JOIN newsletter_user AS nu ON (sgu.id = nu.user_id)
INNER JOIN user_setting AS us ON (us.id = up.id)
WHERE nu.is_active = 1 AND nu.newsletter_id = 1 AND us.allow_contact = 1 AND us.allow_newsletter = 1 AND up.country_id = '1'
ORDER BY sgu.id DESC


ONLY ALLOW CONTACTS
CREATE VIEW newsletter_export_user_general_com_only AS
SELECT sgu.email_address AS EMAIL, sgu.first_name AS FNAME, sgu.last_name AS LNAME
FROM sf_guard_user AS sgu
LEFT JOIN user_profile AS up ON (sgu.id = up.id)
LEFT JOIN user_setting AS us ON (us.id = up.id)
WHERE us.allow_contact = 1 AND up.country_id = '1'
ORDER BY sgu.id DESC
 */

/*
 * Macedonian
CREATE VIEW macedonian_newsletter_users AS
SELECT sfg.first_name AS 'FIRST NAME', sfg.last_name AS 'LAST NAME', sfg.email_address AS 'EMAIL ADDRESS', cc.name AS 'CITY' FROM `user_profile` as up
LEFT JOIN `user_setting` as us ON (up.id = us.id)
LEFT JOIN `sf_guard_user` as sfg ON (sfg.id = us.id)
LEFT JOIN `city` as cc ON (up.city_id = cc.id)
WHERE country_id = 3 AND us.allow_contact = 1
*/


/*
 * ROMANIAN REPORT
SELECT sgu.email_address AS EMAIL, sgu.first_name AS FIRST_NAME, sgu.last_name AS LAST_NAME, sgu.username AS USERNAME, sgu.last_login AS LAST_LOGIN, sgu.is_active AS IS_ACTIVE, c.name AS LOCATION
FROM sf_guard_user AS sgu
LEFT JOIN user_profile AS up ON (sgu.id = up.id)
LEFT JOIN user_setting AS us ON (us.id = up.id)
LEFT JOIN city AS c ON (c.id = up.city_id)
WHERE us.allow_contact = 1 AND up.country_id = '2'
ORDER BY sgu.id DESC
 */


/*
 * MailChimp lists:
 * - GetLokal (fields: Email Address, First Name, Last Name, City AS *|CITY|*, County AS *|COUNTY|*, Year AS *|YEAR|*)
 * - UnregisteredUsers (fields: Email Address, First Name, Last Name, Country AS *|COUNTRY|*)
 *
 * MailChimp "Getlokal newsletter list":
 * - Развлекателни бюлетини | Community newsletters | Newsletter de comunitate
 * - Бизнес бюлетини | Business newsletters | Newsletter business
 * - Известия за игри и промоции | Games and promotions | Jocuri si promotii
 * - Седмичен бюлетин | Weekly newsletter | Newsletter săptămânal
 *
 */


final class MC extends MCAPI {
    public static function getEmailStatus($user, $group = null) {
        $email = $user->getSfGuardUser()->getEmailAddress();
        $userCountry = $user->getCountry()->getSlug();

        $ip = $_SERVER['REMOTE_ADDR'];
        if(strpos(sfContext::getInstance()->getRequest()->getHost(), 'devlokal.com') !== false || $ip == '127.0.0.1') {
            return false;
        }
        elseif ($McApiKey = sfConfig::get('app_mail_chimp_api_key_' . $userCountry)) {
            $MChimp = new MCAPI($McApiKey);
        }
        else {
            return false;
        }

        $listsResponse = $MChimp->lists(array('list_name' => sfConfig::get('app_mail_chimp_list_name_' . $userCountry)));

        if ($MChimp->errorCode) {
            return false;
        } else {
            if (isset($listsResponse['data'][0]) && $listId = $listsResponse['data'][0]['id']) {
                $response = $MChimp->listMemberInfo($listId, $email);

                if ($MChimp->errorCode || $response['errors'] || $response['data'][0]['status'] == 'unsubscribed') {
                    foreach ($user->getNewsletterUser() as $newsletterUser) {
                        $newsletterUser->setIsActive(0);
                        $newsletterUser->save();
                    }

                    $user->getUserSetting()->setAllowContact(0);
                    $user->getUserSetting()->setAllowNewsletter(0);
                    $user->getUserSetting()->setAllowBCmc(0);
                    $user->getUserSetting()->setAllowPromo(0);
                    $user->getUserSetting()->save();

                    return false;
                }

                if ($response['success'] || $response['data'][0]['status'] == 'subscribed') {
                    //$user->getProfile()->getNewsletter()->getMailchimpGroup();

                    $MCGroups = $response['data'][0]['merges']['GROUPINGS'][0]['groups'];
                    $MCGroups = $tmpMCGroups = explode(', ', $MCGroups);

                    $isSubscribe = false;

                    if (in_array('Развлекателни бюлетини', $MCGroups) || in_array('Newsletter de comunitate', $MCGroups) || in_array('Community newsletters', $MCGroups)) {
                        $isSubscribe = true;
                        $user->getUserSetting()->setAllowNewsletter(1);
                    }
                    else {
                        $user->getUserSetting()->setAllowNewsletter(0);
                    }

                    if (in_array('Бизнес бюлетини', $MCGroups) || in_array('Newsletter business', $MCGroups) || in_array('Business newsletters', $MCGroups)) {
                        $isSubscribe = true;
                        $user->getUserSetting()->setAllowBCmc(1);
                    }
                    else {
                        $user->getUserSetting()->setAllowBCmc(0);
                    }

                    if (in_array('Известия за игри и промоции', $MCGroups) || in_array('Jocuri si promotii', $MCGroups) || in_array('Games and promotions', $MCGroups)) {
                        $isSubscribe = true;
                        $user->getUserSetting()->setAllowPromo(1);
                    }
                    else {
                        $user->getUserSetting()->setAllowPromo(0);
                    }


                    $user->getUserSetting()->save();


                    if ((($key = array_search('Развлекателни бюлетини', $MCGroups)) !== false) || (($key = array_search('Newsletter de comunitate', $MCGroups)) !== false) || (($key = array_search('Community newsletters', $MCGroups)) !== false)) {
                        unset($MCGroups[$key]);
                    }

                    if ((($key = array_search('Бизнес бюлетини', $MCGroups)) !== false) || (($key = array_search('Newsletter business', $MCGroups)) !== false) || (($key = array_search('Business newsletters', $MCGroups)) !== false)) {
                        unset($MCGroups[$key]);
                    }

                    if ((($key = array_search('Известия за игри и промоции', $MCGroups)) !== false) || (($key = array_search('Jocuri si promotii', $MCGroups)) !== false) || (($key = array_search('Games and promotions', $MCGroups)) !== false)) {
                        unset($MCGroups[$key]);
                    }

                    //unset($MCGroups['user'], $MCGroups['business'], $MCGroups['promo']);

                    foreach ($user->getNewsletterUser() as $newsletterUser) {
                        if (in_array($newsletterUser->getNewsletter()->getMailchimpGroup(), $MCGroups))
                        {
                            $newsletterUser->setIsActive(1);

                            if (($key = array_search($newsletterUser->getNewsletter()->getMailchimpGroup(), $MCGroups)) !== false) {
                                unset($MCGroups[$key]);
                            }
                        }
                        else {
                            $newsletterUser->setIsActive(0);
                        }

                        $newsletterUser->save();
                    }


                    if (count($MCGroups)) {
                        foreach ($MCGroups as $MCGroup) {
                            $result = Doctrine::getTable('Newsletter')->findOneBy('mailchimp_group', $MCGroup);
                            if ($result && $result->getIsActive()) {
                                $nuser = new NewsletterUser();
                                $nuser->setUserId($user->getId());
                                $nuser->setNewsletter($result);
                                $nuser->setIsActive(1);
                                $nuser->save();
                            }
                        }
                    }


                    if (!$isSubscribe) {
                        foreach ($user->getNewsletterUser() as $newsletterUser) {
                            $newsletterUser->setIsActive(0);
                            $newsletterUser->save();
                        }

                        $user->getUserSetting()->setAllowNewsletter(0);
                        $user->getUserSetting()->setAllowBCmc(0);
                        $user->getUserSetting()->setAllowPromo(0);
                        $user->getUserSetting()->save();
                    }

                    if ($group && in_array($group, $tmpMCGroups)) {
                        return true;
                    }
                    else {
                        return false;
                    }
                }
            }
        }
    }

    public static function unsubscribe($email, $userCountry, $group = NULL) {

        $ip = $_SERVER['REMOTE_ADDR'];
        if(strpos(sfContext::getInstance()->getRequest()->getHost(), 'devlokal.com') !== false || $ip == '127.0.0.1') {
            return false;
        }
        elseif ($McApiKey = sfConfig::get('app_mail_chimp_api_key_' . $userCountry)) {
            $MChimp = new MCAPI($McApiKey);
        }
        else {
            return false;
        }

        $listsResponse = $MChimp->lists(array('list_name' => $group));

        if ($MChimp->errorCode) {
            if (sfConfig::get('sf_logging_enabled')) {
                //sfContext::getInstance()->getLogger()->info('test');
                sfContext::getInstance()->getLogger()->err('Unable to load lists(): ' . $MChimp->errorCode . "\n" . $MChimp->errorMessage);
            }
        } else {
            if ($listId = $listsResponse['data'][0]['id']) {
                $unsubscribeResponse = $MChimp->listUnsubscribe($listId, $email, false, false, false);
            }
        }

        if ($MChimp->errorCode && sfConfig::get('sf_logging_enabled')) {
            sfContext::getInstance()->getLogger()->err('Unable to subscribe the user: ' . $MChimp->errorCode . "\n" . $MChimp->errorMessage);
        }
    }

    public static function subscribe($user = null) {
        $firstName = $lastName = $email = $userCountry = $userCity = null;

        $firstName  = $user->getFirstName();
        $lastName = $user->getLastName();
        $email = $user->getEmailAddress();
        $userCountry = $user->getUserProfile()->getCountry()->getSlug();
        $userCity = $user->getUserProfile()->getCity()->getName();
        $userCounty = $user->getUserProfile()->getCity()->getCounty()->getName();
        $userYear = strtotime($user->getUserProfile()->getBirthdate());

        if ($userYear && $userYear != NULL) {
            $userYear = date('Y', $userYear);
        }
        else {
            $userYear = 'unknown';
        }


        if (MC::checkInList($email, $user->getUserProfile()->getCountryId(), 'UnregisteredUsers') === true) {
            $unregUser = Doctrine::getTable('UnregisteredNewsletterUser')->findBy('email_address', $email);
            if ($unregUser) {
                MC::unsubscribe($email, $userCountry, 'UnregisteredUsers');

                $unregUser->delete();
            }
        }

        $ip = $_SERVER['REMOTE_ADDR'];
        if(strpos(sfContext::getInstance()->getRequest()->getHost(), 'devlokal.com') !== false || $ip == '127.0.0.1') {
            return false;
        }
        elseif ($McApiKey = sfConfig::get('app_mail_chimp_api_key_' . $userCountry)) {
            $MChimp = new MCAPI($McApiKey);
        }
        else {
            return false;
        }

        $listsResponse = $MChimp->lists(array('list_name' => sfConfig::get('app_mail_chimp_list_name_' . $userCountry)));

        if ($MChimp->errorCode) {
            if (sfConfig::get('sf_logging_enabled')) {
                //sfContext::getInstance()->getLogger()->info('test');
                sfContext::getInstance()->getLogger()->err('Unable to load lists(): ' . $MChimp->errorCode . "\n" . $MChimp->errorMessage);
            }
        } else {
            if ($listId = $listsResponse['data'][0]['id']) {
                $subscribeTo = array();

                if ($user->getUserProfile()->getUserSetting()->getAllowNewsletter()) {
                    if ($userCountry == 'bg') {
                        $subscribeTo[] = 'Развлекателни бюлетини';
                    }
                    elseif ($userCountry == 'ro') {
                        $subscribeTo[] = 'Newsletter de comunitate';
                    }
                    else {
                        $subscribeTo[] = 'Community newsletters';
                    }
                }

                if ($user->getUserProfile()->getUserSetting()->getAllowBCmc()) {
                    if ($userCountry == 'bg') {
                        $subscribeTo[] = 'Бизнес бюлетини';
                    }
                    elseif ($userCountry == 'ro') {
                        $subscribeTo[] = 'Newsletter business';
                    }
                    else {
                        $subscribeTo[] = 'Business newsletters';
                    }
                }

                if ($user->getUserProfile()->getUserSetting()->getAllowPromo()) {
                    if ($userCountry == 'bg') {
                        $subscribeTo[] = 'Известия за игри и промоции';
                    }
                    elseif ($userCountry == 'ro') {
                        $subscribeTo[] = 'Jocuri si promotii';
                    }
                    else {
                        $subscribeTo[] = 'Games and promotions';
                    }
                }
/*
                foreach ($user->getUserProfile()->getNewsletterUser() as $newsletterObject) {
                    if ($newsletterObject->getIsActive() && $newsletterObject->getNewsletter()->getIsActive()) {
                        $subscribeTo[] = $newsletterObject->getNewsletter()->getUserGroup();
                    }
                }
*/
                foreach ($user->getUserProfile()->getNewsletterUser() as $newsletterObject) {
                    if ($newsletterObject->getIsActive() && $newsletterObject->getNewsletter()->getIsActive()) {
                        $subscribeTo[] = $newsletterObject->getNewsletter()->getMailchimpGroup();
                        $subscribeTo[] = $newsletterObject->getNewsletter()->getUserGroup();
                    }
                }


                // Get first list group
                $groups = $MChimp->listInterestGroupings($listId);

                $subscribeTo = array_unique($subscribeTo);

                $subscribeToGroups = implode(',', $subscribeTo);

                $mergeVars = array('FNAME' => $firstName, 'LNAME' => $lastName, 'CITY' => $userCity, 'COUNTY' => $userCounty, 'YEAR' => $userYear,
                    'GROUPINGS' => array(
                        'groups' => array('name' => $groups[0]['name'], 'groups' => $subscribeToGroups)
                    )
                );

                // Subscribe
                if (count($subscribeTo) /*|| $user->getUserProfile()->getUserSetting()->getAllowNewsletter()*/) {
                    $subscribeResponse = $MChimp->listSubscribe($listId, $email, $mergeVars, 'html', false, true);
                }

                if ($MChimp->errorCode && sfConfig::get('sf_logging_enabled')) {
                    sfContext::getInstance()->getLogger()->err('Unable to subscribe the user: ' . $MChimp->errorCode . "\n" . $MChimp->errorMessage);
                }
            }
        }
    }

    public static function subscribe_unsubscribe($user = null, $fromBackend = false) {
        $firstName = $lastName = $email = $userCountry = $userCity = $userCounty = null;

        if ($user) {
            $firstName  = $user->getFirstName();
            $lastName = $user->getLastName();
            $email = $user->getEmailAddress();
            $userCountry = $user->getUserProfile()->getCountry()->getSlug();
            $userCountryId = $user->getUserProfile()->getCountry()->getId();
            $userCity = $user->getUserProfile()->getCity()->getName();
            $userCounty = $user->getUserProfile()->getCity()->getCounty()->getName();

            $userYear = strtotime($user->getUserProfile()->getBirthdate());

            if ($userYear && $userYear != NULL) {
                $userYear = date('Y', $userYear);
            }
            else {
                $userYear = 'unknown';
            }
        }
        else {
            $user = sfContext::getInstance()->getUser();

            $firstName  = $user->getGuardUser()->getFirstName();
            $lastName = $user->getGuardUser()->getLastName();
            $email = $user->getGuardUser()->getEmailAddress();
            $userCountry = $user->getProfile()->getCountry()->getSlug(); //$user->getCountry()->getSlug();
            $userCountryId = $user->getProfile()->getCountryId(); //$user->getCountry()->getId();
            $userCity = $user->getProfile()->getCity()->getName(); //$user->getCity()->getNameEn();
            $userCounty = $user->getProfile()->getCity()->getCounty()->getName(); //$user->getCity()->getCounty()->getName();

            $userYear = strtotime($user->getProfile()->getBirthdate());

            if ($userYear && $userYear != NULL) {
                $userYear = date('Y', $userYear);
            }
            else {
                $userYear = 'unknown';
            }
        }

        if (MC::checkInList($email, $userCountryId, 'UnregisteredUsers') === true) {
            $unregUser = Doctrine::getTable('UnregisteredNewsletterUser')->findBy('email_address', $email);
            if ($unregUser) {
                MC::unsubscribe($email, $userCountry, 'UnregisteredUsers');

                $unregUser->delete();
            }
        }

        $ip = $_SERVER['REMOTE_ADDR'];
        if(strpos(sfContext::getInstance()->getRequest()->getHost(), 'devlokal.com') !== false || $ip == '127.0.0.1') {
            return false;
        }
        elseif ($McApiKey = sfConfig::get('app_mail_chimp_api_key_' . $userCountry)) {
            $MChimp = new MCAPI($McApiKey);
        }
        else {
            return false;
        }

        $listsResponse = $MChimp->lists(array('list_name' => sfConfig::get('app_mail_chimp_list_name_' . $userCountry)));

        if ($MChimp->errorCode) {
            if (sfConfig::get('sf_logging_enabled')) {
                //sfContext::getInstance()->getLogger()->info('test');
                sfContext::getInstance()->getLogger()->err('Unable to load lists(): ' . $MChimp->errorCode . "\n" . $MChimp->errorMessage);
            }
        } else {
            if ($listId = $listsResponse['data'][0]['id']) {
                $subscribeTo = array();

                // Subscribe
                if (get_class($user) != 'sfGuardUser') {
                    if (!$fromBackend) {
                        if ($user->getProfile()->getUserSetting()->getAllowNewsletter()) {
                            if ($userCountry == 'bg') {
                                $subscribeTo[] = 'Развлекателни бюлетини';
                            }
                            elseif ($userCountry == 'ro') {
                                $subscribeTo[] = 'Newsletter de comunitate';
                            }
                            else {
                                $subscribeTo[] = 'Community newsletters';
                            }
                        }

                        if ($user->getProfile()->getUserSetting()->getAllowBCmc()) {
                            if ($userCountry == 'bg') {
                                $subscribeTo[] = 'Бизнес бюлетини';
                            }
                            elseif ($userCountry == 'ro') {
                                $subscribeTo[] = 'Newsletter business';
                            }
                            else {
                                $subscribeTo[] = 'Business newsletters';
                            }
                        }

                        if ($user->getProfile()->getUserSetting()->getAllowPromo()) {
                            if ($userCountry == 'bg') {
                                $subscribeTo[] = 'Известия за игри и промоции';
                            }
                            elseif ($userCountry == 'ro') {
                                $subscribeTo[] = 'Jocuri si promotii';
                            }
                            else {
                                $subscribeTo[] = 'Games and promotions';
                            }
                        }
                    }

                    //foreach ($user->getProfile()->getNewsletterUser() as $newsletterObject) {
                    $newsletterObjects = Doctrine::getTable('NewsletterUser')->findBy('user_id', $user->getId());
                    foreach ($newsletterObjects as $newsletterObject) {
                        if ($newsletterObject->getIsActive() && $newsletterObject->getNewsletter()->getIsActive()) {
                            $subscribeTo[] = $newsletterObject->getNewsletter()->getMailchimpGroup();
                            $subscribeTo[] = $newsletterObject->getNewsletter()->getUserGroup();
                        }
                    }
                }
                elseif (get_class($user) == 'sfGuardUser') {
                    if (!$fromBackend) {
                        if ($user->getUserProfile()->getUserSetting()->getAllowNewsletter()) {
                            if ($userCountry == 'bg') {
                                $subscribeTo[] = 'Развлекателни бюлетини';
                            }
                            elseif ($userCountry == 'ro') {
                                $subscribeTo[] = 'Newsletter de comunitate';
                            }
                            else {
                                $subscribeTo[] = 'Community newsletters';
                            }
                        }

                        if ($user->getUserProfile()->getUserSetting()->getAllowBCmc()) {
                            if ($userCountry == 'bg') {
                                $subscribeTo[] = 'Бизнес бюлетини';
                            }
                            elseif ($userCountry == 'ro') {
                                $subscribeTo[] = 'Newsletter business';
                            }
                            else {
                                $subscribeTo[] = 'Business newsletters';
                            }
                        }

                        if ($user->getUserProfile()->getUserSetting()->getAllowPromo()) {
                            if ($userCountry == 'bg') {
                                $subscribeTo[] = 'Известия за игри и промоции';
                            }
                            elseif ($userCountry == 'ro') {
                                $subscribeTo[] = 'Jocuri si promotii';
                            }
                            else {
                                $subscribeTo[] = 'Games and promotions';
                            }
                        }
                    }

                    //foreach ($user->getUserProfile()->getNewsletterUser() as $newsletterObject) {
                    $newsletterObjects = Doctrine::getTable('NewsletterUser')->findBy('user_id', $user->getId());
                    foreach ($newsletterObjects as $newsletterObject) {
                        //echo $newsletterObject->getId();
                        if ($newsletterObject->getIsActive() && $newsletterObject->getNewsletter()->getIsActive()) {
                            $subscribeTo[] = $newsletterObject->getNewsletter()->getMailchimpGroup();
                            $subscribeTo[] = $newsletterObject->getNewsletter()->getUserGroup();
                        }
                    }
                }

                // Get first list group
                $groups = $MChimp->listInterestGroupings($listId);

                $subscribeTo = array_unique($subscribeTo);

                $subscribeToGroups = implode(',', $subscribeTo);

                $mergeVars = array('FNAME' => $firstName, 'LNAME' => $lastName, 'CITY' => $userCity, 'COUNTY' => $userCounty, 'YEAR' => $userYear,
                    'GROUPINGS' => array(
                        'groups' => array('name' => $groups[0]['name'], 'groups' => $subscribeToGroups)
                    )
                );

                if (get_class($user) != 'sfGuardUser') {
                    // Subscribe
                    if (count($subscribeTo) || $user->getProfile()->getUserSetting()->getAllowContact()) {
                        $subscribeResponse = $MChimp->listSubscribe($listId, $email, $mergeVars, 'html', false, true);
                    }
                    // Unsubscribe
                    elseif (!count($subscribeTo) || !$user->getProfile()->getUserSetting()->getAllowContact()) {
                        if (!$user->getProfile()->getUserSetting()->getAllowContact()) {
                            if (!$fromBackend) {
                                // totally unsibscribe
                                $unsubscribeResponse = $MChimp->listUnsubscribe($listId, $email, false, false, false);
                            }
                            else {
                                // clear groups
                                $subscribeResponse = $MChimp->listSubscribe($listId, $email, $mergeVars, 'html', false, true);
                            }
                        }
                    }
                }
                else {
                    // Subscribe
                    if (count($subscribeTo) || $user->getUserProfile()->getUserSetting()->getAllowContact()) {
                        $subscribeResponse = $MChimp->listSubscribe($listId, $email, $mergeVars, 'html', false, true);
                    }
                    // Unsubscribe
                    elseif (!count($subscribeTo) || !$user->getUserProfile()->getUserSetting()->getAllowContact()) {
                        if (!$user->getUserProfile()->getUserSetting()->getAllowContact()) {
                            if (!$fromBackend) {
                                // totally unsibscribe
                                $unsubscribeResponse = $MChimp->listUnsubscribe($listId, $email, false, false, false);
                            }
                            else {
                                // clear groups
                                $subscribeResponse = $MChimp->listSubscribe($listId, $email, $mergeVars, 'html', false, true);
                            }
                        }
                    }
                }

                if ($MChimp->errorCode && sfConfig::get('sf_logging_enabled')) {
                    sfContext::getInstance()->getLogger()->err('Unable to subscribe the user: ' . $MChimp->errorCode . "\n" . $MChimp->errorMessage);
                }
            }
        }
    }

    public static function checkInList($email, $countryId, $listName = NULL) {
        if (!$email || !$countryId || !$listName) return 'email_error';

        $country = Doctrine::getTable('Country')->find($countryId);

        $ip = $_SERVER['REMOTE_ADDR'];
        if(strpos(sfContext::getInstance()->getRequest()->getHost(), 'devlokal.com') !== false || $ip == '127.0.0.1') {
            return false;
        }
        elseif ($McApiKey = sfConfig::get('app_mail_chimp_api_key_' . $country->getSlug())) {
            $MChimp = new MCAPI($McApiKey);
        }
        else {
            return false;
        }

        $listsResponse = $MChimp->lists(array('list_name' => $listName));

        if ($MChimp->errorCode) {
            return 'mc_error';
        } else {
            if ($listId = $listsResponse['data'][0]['id']) {
                $response = $MChimp->listMemberInfo($listId, $email);

                if ($MChimp->errorCode || $response['errors'] || $response['data'][0]['status'] == 'unsubscribed') {
                    return false;
                }

                if ($response['data'][0]['status'] == 'subscribed') {
                    return true;
                }
            }
            else {
                return 'list_error';
            }
        }
    }

    public static function onlySubscribe($email, $countryId, $firstName = null, $lastName = null, $listName = NULL) {
        if (!$email || !$listName) return 'email_error';

        $country = Doctrine::getTable('Country')->find($countryId);

        $ip = $_SERVER['REMOTE_ADDR'];
        if(strpos($this->getContext()->getRequest()->getHost(), 'devlokal.com') !== false || $ip == '127.0.0.1') {
            return false;
        }
        elseif ($McApiKey = sfConfig::get('app_mail_chimp_api_key_' . $country->getSlug())) {
            $MChimp = new MCAPI($McApiKey);
        }
        else {
            return false;
        }

        $listsResponse = $MChimp->lists(array('list_name' => $listName));

        if ($MChimp->errorCode) {
            return 'mc_error';
        } else {
            if ($listId = $listsResponse['data'][0]['id']) {
                $mergeVars = array('FNAME' => $firstName, 'LNAME' => $lastName, 'COUNTRY' => $country->getNameEn());

                $subscribeResponse = $MChimp->listSubscribe($listId, $email, $mergeVars, 'html', false, true);

                return true;
            }
            else {
                return 'list_error';
            }
        }
    }
}
