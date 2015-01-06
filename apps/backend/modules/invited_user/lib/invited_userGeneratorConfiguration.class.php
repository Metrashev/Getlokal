<?php

/**
 * invited_user module configuration.
 *
 * @package    getLokal
 * @subpackage invited_user
 * @author     Get Lokal
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class invited_userGeneratorConfiguration extends BaseInvited_userGeneratorConfiguration
{
    public function getPagerMaxPerPage() {
        if (sfContext::getInstance()->getRequest()->getParameter('csv')) {
            return 190000;
        }
        else {
            return parent::getPagerMaxPerPage();
        }
    }
}
