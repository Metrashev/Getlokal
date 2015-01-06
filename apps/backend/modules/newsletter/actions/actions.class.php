<?php

require_once dirname(__FILE__) . '/../lib/newsletterGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/newsletterGeneratorHelper.class.php';

/**
 * newsletter actions.
 *
 * @package    getLokal
 * @subpackage newsletter
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class newsletterActions extends autoNewsletterActions {
    public function executeUpdateUsers(sfWebRequest $request) {
        $this->forward404Unless($this->newsletter = Doctrine::getTable('Newsletter')->find($request->getParameter('id')));

        $query = Doctrine_Core::getTable('NewsletterUser')->createQuery('nu')->
                addWhere('nu.newsletter_id = ? ', $this->newsletter->getId())
                ->andWhere('nu.is_active = 1 ');

        $q3 = $query->createSubquery()->select('df.id')
                        ->from('UserProfile df')
                        ->innerJoin('df.UserSetting us')->innerJoin('df.sfGuardUser sf');

        if (in_array($this->newsletter->getUserGroup(), array('Бизнес бюлетини', 'Business newsletters', 'Newsletter business'))) {
            $q3->andWhere('us.allow_b_cmc = 0 OR us.allow_contact = 0 or sf.is_active = 0');
        }
        elseif (in_array($this->newsletter->getUserGroup(), array('Известия за игри и промоции', 'Games and promotions', 'Jocuri si promotii'))) {
            $q3->andWhere('us.allow_promo = 0 OR us.allow_contact = 0 or sf.is_active = 0');
        }
        else {
            $q3->andWhere('us.allow_newsletter = 0 OR us.allow_contact = 0 or sf.is_active = 0');
        }

        $query->andWhere('nu.user_id IN (' . $q3->getDql() . ')');

        $must_unsubscribe = $query->execute();

        if (count($must_unsubscribe) > 0) {
            foreach ($must_unsubscribe as $must) {
                $must->setIsActive(0);
                $must->save();
            }
            $this->getUser()->setFlash('error', count($must_unsubscribe) . ' users removed');
        }

        $query1 = Doctrine_Core::getTable('UserProfile')->
                createQuery('up1')->innerJoin('up1.sfGuardUser sf1')
                ->innerJoin('up1.UserSetting us1')
                ->andWhere('us1.allow_contact = 1 and sf1.is_active = 1')
                ->andWhere('up1.country_id = ?', $this->newsletter->getCountryId());

        if (in_array($this->newsletter->getUserGroup(), array('Бизнес бюлетини', 'Business newsletters', 'Newsletter business'))) {
            $query1->andWhere('us1.allow_b_cmc = 1')
                    ->innerJoin('up1.PageAdmin pa1')
                    ->andWhere('pa1.status = ? ', 'approved')
                    ->andWhere('pa1.created_at > "2012-04-25 00:00:00"');
        }
        elseif (in_array($this->newsletter->getUserGroup(), array('Известия за игри и промоции', 'Games and promotions', 'Jocuri si promotii'))) {
            // !1!
            //$q561 = $query->createSubquery()->select('pa2.user_id')->from('PageAdmin pa2');
            //$query1->/* andWhere ( 'us1.allow_contact = 1')-> */andWhere('up1.id NOT IN (' . $q561->getDql() . ')');

            // !2!
            $query1->andWhere( 'us1.allow_promo = 1');
        } else {
            $query1->andWhere('us1.allow_newsletter = 1');
        }

        $q56 = $query->createSubquery()->select('nu2.user_id')->from('NewsletterUser nu2')->andWhere('nu2.newsletter_id = ' . $this->newsletter->getId());

        $query1->andWhere('up1.id NOT IN (' . $q56->getDql() . ')');

        $query1->addOrderBy('up1.id DESC');

        $must_subscribe = $query1->execute();

        if (count($must_subscribe) > 0) {
            foreach ($must_subscribe as $sub) {
                $subs = new NewsletterUser ();
                $subs->setUserId($sub->getId());
                $subs->setNewsletterId($this->newsletter->getId());
                $subs->setIsActive(1);
                $subs->save();

                // !1!
                /*if (in_array($this->newsletter->getUserGroup(), array('Известия за игри и промоции', 'Games and promotions', 'Jocuri si promotii'))) {
                    $userSetting = $sub->getUserSetting();
                    $userSetting->setAllowPromo(1);
                    $userSetting->save();
                }
                */
                 


                // !2!
                MC::subscribe($sub->getSfGuardUser());
            }

            $this->getUser()->setFlash('notice', count($must_subscribe) . ' users added');
        }

        $this->redirect('@newsletter');
    }

    //http://getlokal.com/backend_dev.php/newsletter/promo
    public function executePromo(sfWebRequest $request) {
        $query = Doctrine::getTable('UserProfile')
                ->createQuery('up')
                ->innerJoin('up.UserSetting us')
                ->innerJoin('up.sfGuardUser sgu')
                ->where('us.allow_contact = 1 and allow_promo != 1')
                ->addOrderBy('up.id DESC');

        $q561 = $query->createSubquery()->select('pa2.user_id')->from('PageAdmin pa2');
        $query->andWhere('up.id NOT IN (' . $q561->getDql() . ')');
//$query->limit(5);
        $must_subscribe = $query->execute();

        if (count($must_subscribe) > 0) {
            foreach ($must_subscribe as $must) {
                $must->getUserSetting()->setAllowPromo('1');
                $must->save();
            }

            $this->getUser()->setFlash('notice', count($must_subscribe) . ' users added');
        }

        $this->redirect('@newsletter');
    }
}
