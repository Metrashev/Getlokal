<?php

/**
 * BaseNewsletterUser
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $user_id
 * @property integer $newsletter_id
 * @property boolean $is_active
 * @property Newsletter $Newsletter
 * @property UserProfile $UserProfile
 * 
 * @method integer        getUserId()        Returns the current record's "user_id" value
 * @method integer        getNewsletterId()  Returns the current record's "newsletter_id" value
 * @method boolean        getIsActive()      Returns the current record's "is_active" value
 * @method Newsletter     getNewsletter()    Returns the current record's "Newsletter" value
 * @method UserProfile    getUserProfile()   Returns the current record's "UserProfile" value
 * @method NewsletterUser setUserId()        Sets the current record's "user_id" value
 * @method NewsletterUser setNewsletterId()  Sets the current record's "newsletter_id" value
 * @method NewsletterUser setIsActive()      Sets the current record's "is_active" value
 * @method NewsletterUser setNewsletter()    Sets the current record's "Newsletter" value
 * @method NewsletterUser setUserProfile()   Sets the current record's "UserProfile" value
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseNewsletterUser extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('newsletter_user');
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('newsletter_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('is_active', 'boolean', null, array(
             'type' => 'boolean',
             'default' => true,
             ));

        $this->option('type', 'INNODB');
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Newsletter', array(
             'local' => 'newsletter_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('UserProfile', array(
             'local' => 'user_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}