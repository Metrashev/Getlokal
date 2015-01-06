<?php

/**
 * FollowPage form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class FollowPageForm extends BaseFollowPageForm
{
  public function configure()
  {
  	parent::configure();
  	$this->useFields(array('email_notification', 'internal_notification','newsfeed','weekly_update' ));
   
  }
}
