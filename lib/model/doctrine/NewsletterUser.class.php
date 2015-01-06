<?php

/**
 * NewsletterUser
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class NewsletterUser extends BaseNewsletterUser
{
    public function preDelete($event) {
        parent::preDelete($event);

        $userSetting = $this->getUserProfile()->getUserSetting();
        $userSetting->setAllowNewsletter(0);
        $userSetting->save();

        MC::unsubscribe($this->getUserProfile()->getSfGuardUser()->getEmailAddress(), $this->getUserProfile()->getCountry()->getSlug());
    }
}