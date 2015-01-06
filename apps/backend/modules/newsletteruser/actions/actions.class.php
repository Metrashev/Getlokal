<?php

require_once dirname(__FILE__) . '/../lib/newsletteruserGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/newsletteruserGeneratorHelper.class.php';

/**
 * newsletteruser actions.
 *
 * @package    getLokal
 * @subpackage newsletteruser
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class newsletteruserActions extends autoNewsletteruserActions {

    public function executeBatchSubscribe(sfWebRequest $request) {
        if (!$ids = $request->getParameter('ids')) {
            $this->getUser()->setFlash('error', 'You must at least select one item.');

            $this->redirect('@newsletter_user');
        }

        foreach ($ids as $id) {
            $this->forward404Unless($nuser = Doctrine::getTable('NewsletterUser')->find($id));

            $nuser->setIsActive(true);
            $nuser->save();
            
            MC::subscribe($nuser->getUserProfile()->getSfGuardUser());

            $this->getUser()->setFlash('notice', 'The selected users have been subscribed successfully.');
        }

        $this->redirect('@newsletter_user');
    }

    public function executeBatchUnsubscribe(sfWebRequest $request) {
        if (!$ids = $request->getParameter('ids')) {
            $this->getUser()->setFlash('error', 'You must at least select one item.');

            $this->redirect('@newsletter_user');
        }

        foreach ($ids as $id) {
            $this->forward404Unless($nuser = Doctrine::getTable('NewsletterUser')->find($id));
            $nuser->setIsActive(false);
            $nuser->save();

            //MC::unsubscribe($nuser->getUserProfile()->getSfGuardUser()->getEmailAddress(), $nuser->getUserProfile()->getCountry()->getSlug());
            //MC::subscribe_unsubscribe($nuser->getUserProfile()->getSfGuardUser(), true);
            MC::subscribe_unsubscribe($nuser->getUserProfile()->getSfGuardUser());

            $this->getUser()->setFlash('notice', 'The selected users have been unsubscribed successfully.');
        }

        $this->redirect('@newsletter_user');
    }

    public function executeBatchDelete(sfWebRequest $request) {
        if (!$ids = $request->getParameter('ids')) {
            $this->getUser()->setFlash('error', 'You must at least select one item.');

            $this->redirect('@newsletter_user');
        }

        foreach ($ids as $id) {
            $nuser = Doctrine::getTable('NewsletterUser')->find($id);
            
            if ($nuser) {
                $user = $nuser->getUserProfile()->getSfGuardUser();
                $userSetting = $nuser->getUserProfile()->getUserSetting();
                $country = $nuser->getUserProfile()->getCountry()->getSlug();

                $userSetting->setAllowContact(0);
                $userSetting->setAllowNewsletter(0);
                $userSetting->setAllowBCmc(0);
                $userSetting->setAllowPromo(0);
                $userSetting->save();

                $newsletters = Doctrine::getTable('NewsletterUser')->findBy('user_id', $user->getId());

                foreach ($newsletters as $newsletter) {
                    $newsletter->delete();
                }

                // totally unsubscribe
                MC::unsubscribe($user->getEmailAddress(), $country, sfConfig::get('app_mail_chimp_list_name_' . $country));

                $this->getUser()->setFlash('notice', 'The selected users have been unsubscribed successfully.');
            }
        }

        $this->redirect('@newsletter_user');        
    }

    public function executeSetStatus(sfWebRequest $request) {
        $this->newsletter_user = $this->getRoute()->getObject();

        $userSetting = $this->newsletter_user->getUserProfile()->getUserSetting();
        $status = $request->getParameter('status', 0);

        $this->newsletter_user->setIsActive($status);
        $this->newsletter_user->save();

/*
        $userSetting->setAllowContact($status);
        $userSetting->setAllowNewsletter($status);
        $userSetting->save();
*/
        $user = $this->newsletter_user->getUserProfile()->getSfGuardUser();

        if ($status == 0) {
            if ($mcgroup = $request->getParameter('mcgroup', null)) {
                // unsubscribe from group
                //MC::subscribe_unsubscribe($user, true);
                MC::subscribe_unsubscribe($user);
            }
        }
        else {
            //MC::subscribe_unsubscribe($user, true);
            MC::subscribe_unsubscribe($user);
        }

        $this->getUser()->setFlash('notice', 'Successfully Changed');
        $this->redirect('@newsletter_user');
    }

    public function executeDelete(sfWebRequest $request) {
        $this->newsletter_user = $this->getRoute()->getObject();

        $userSetting = $this->newsletter_user->getUserProfile()->getUserSetting();
        $user = $this->newsletter_user->getUserProfile()->getSfGuardUser();

        $userSetting->setAllowContact(0);
        $userSetting->setAllowNewsletter(0);
        $userSetting->setAllowBCmc(0);
        $userSetting->setAllowPromo(0);
        $userSetting->save();

        $newsletters = Doctrine::getTable('NewsletterUser')->findBy('UserId', $user->getId());

        foreach ($newsletters as $newsletter) {
            //$newsletter->setIsActive(0);
            //$newsletter->save();
            $newsletter->delete();
        }

        // totally unsubscribe
        MC::unsubscribe($user->getEmailAddress(), $this->newsletter_user->getUserProfile()->getCountry()->getSlug(), sfConfig::get('app_mail_chimp_list_name_' . $this->newsletter_user->getUserProfile()->getCountry()->getSlug()));
        $this->redirect('newsletter_user');
    }
    
    //http://getlokal.com/backend_dev.php/newsletteruser/ExportToTxt
    public function executeExportToTxt(sfWebRequest $request) {
        ini_set('max_execution_time', 6000);
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        // TXT
        $this->getResponse()->clearHttpHeaders();
        $this->getResponse()->setHttpHeader('Pragma-Type', 'public');
        $this->getResponse()->setHttpHeader('Expires', '0');
        $this->getResponse()->setHttpHeader('Content-Type', 'text/txt');
        $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename=newsletter_export.txt');
        $this->getResponse()->setHttpHeader('Content-Transfer-Encoding', 'binary');

        $query = Doctrine::getTable('UserProfile')
                ->createQuery('up')
                ->innerJoin('up.UserSetting us')
                ->innerJoin('up.sfGuardUser sgu')
                ->where('sgu.is_active = 1')
                ->andWhere('us.allow_newsletter = 1 or us.allow_b_cmc = 1 or us.allow_promo = 1')

                // България
                ->andWhere('up.country_id = 2')

                ->addOrderBy('up.id DESC');

        $query->offset(0);  //9000      12000
        $query->limit(3000);   //12000     15000
//echo $query->getSqlQuery();
//exit;

        $csvText = '';

        foreach ($query->execute() as $resItem) {
            $groups = array();
            $isOk = false;

            if ($resItem->getUserSetting()->getAllowNewsletter()) {
                if ($resItem->getCountry()->getSlug() == 'bg') {
                    $groups[] = 'Развлекателни бюлетини';
                }
                elseif ($resItem->getCountry()->getSlug() == 'ro') {
                    $groups[] = 'Newsletter de comunitate';
                }
                else {
                    $groups[] = 'Community newsletters';
                }
                
                $isOk = true;
            }

            if ($resItem->getUserSetting()->getAllowBCmc()) {
                if ($resItem->getCountry()->getSlug() == 'bg') {
                    $groups[] = 'Бизнес бюлетини';
                }
                elseif ($resItem->getCountry()->getSlug() == 'ro') {
                    $groups[] = 'Newsletter business';
                }
                else {
                    $groups[] = 'Business newsletters';
                }

                $isOk = true;
            }

            if ($resItem->getUserSetting()->getAllowPromo()) {
                if ($resItem->getCountry()->getSlug() == 'bg') {
                    $groups[] = 'Известия за игри и промоции';
                }
                elseif ($resItem->getCountry()->getSlug() == 'ro') {
                    $groups[] = 'Jocuri si promotii';
                }
                else {
                    $groups[] = 'Games and promotions';
                }

                $isOk = true;
            }

            if (!$isOk) continue;

            //$userNewsletters = $resItem->getNewsletterUser('is_active = 1'); // <-- doesn`t work
            $query = Doctrine::getTable('NewsletterUser')
                ->createQuery('nu')
                ->where('nu.user_id = ?', $resItem->getId())
                ->andWhere('nu.is_active = 1');

            //foreach ($userNewsletters as $userNewsletter) {
            foreach ($query->execute() as $userNewsletter) {
                $groups[] = $userNewsletter->getNewsletter()->getMailchimpGroup();
            }

            $groups = array_unique($groups);
            $groups = implode(', ', $groups);

            $csvText .= $resItem->getsfGuardUser()->getEmailAddress() . "\t";
            $csvText .= $resItem->getsfGuardUser()->getFirstName() . "\t";
            $csvText .= $resItem->getsfGuardUser()->getLastName() . "\t";
            $csvText .= $groups . "\t";

            $date = strtotime($resItem->getBirthdate());

            if ($date && $date != NULL) {
                $date = date('Y', $date);
                $csvText .= $date . "\t";
            }
            else {
                $csvText .= 'unknown' . "\t";
            }

            if ($resItem->getCityId() && $city = $resItem->getCity()) {
                $csvText .= $resItem->getCity()->getName() . "\t";
            }
            else {
                $csvText .= 'unknown' . "\t";
            }

            if ($resItem->getCityId() && $city = $resItem->getCity()) {
                $csvText .= $resItem->getCity()->getCounty()->getName() . "\r\n";
            }
            else {
                $csvText .= 'unknown' . "\r\n";
            }
        }

        return $this->renderText($csvText);
    }
    
    public function executeFilter(sfWebRequest $request) {
        $this->setPage(1);

        if ($request->hasParameter('_reset')) {
            $this->setFilters($this->configuration->getFilterDefaults());

            $this->redirect('@newsletter_user');
        }

        $this->filters = $this->configuration->getFilterForm($this->getFilters());

        $this->filters->bind($request->getParameter($this->filters->getName()));
        if ($this->filters->isValid()) {
            $this->setFilters($this->filters->getValues());
            if ($request->getParameter('csv') == 'true') {
                ini_set('max_execution_time', 6000);
                set_time_limit(0);
                ini_set('memory_limit', '1024M');
                $this->getResponse()->clearHttpHeaders();
                $this->getResponse()->setHttpHeader('Pragma-Type', 'public');
                $this->getResponse()->setHttpHeader('Expires', '0');
// XLS
//                $this->getResponse()->setHttpHeader('Content-Type', 'application/vnd.ms-excel;charset:UTF-8');
//                $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename=NewsletterlistExport.xls');

// CSV
                $this->getResponse()->setHttpHeader('Content-Type', 'application/CSV'); // text/csv
                $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename=newsletter_export.csv');

                $this->getResponse()->setHttpHeader('Content-Transfer-Encoding', 'binary');
                $this->setLayout('csv');
            } else {

                $this->redirect('@newsletter_user');
            }
        }

        $this->pager = $this->getPager();
        $this->sort = $this->getSort();
        if ($request->getParameter('csv') == 'true') {

            $this->setTemplate('csvList');
        } else {
            $this->setTemplate('index');
        }
    }

}
