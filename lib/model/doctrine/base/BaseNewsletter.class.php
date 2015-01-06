<?php

/**
 * BaseNewsletter
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property string $description
 * @property boolean $is_active
 * @property string $mailchimp_group
 * @property integer $country_id
 * @property string $user_group
 * @property Country $Country
 * @property Doctrine_Collection $NewsletterUser
 * 
 * @method string              getName()            Returns the current record's "name" value
 * @method string              getDescription()     Returns the current record's "description" value
 * @method boolean             getIsActive()        Returns the current record's "is_active" value
 * @method string              getMailchimpGroup()  Returns the current record's "mailchimp_group" value
 * @method integer             getCountryId()       Returns the current record's "country_id" value
 * @method string              getUserGroup()       Returns the current record's "user_group" value
 * @method Country             getCountry()         Returns the current record's "Country" value
 * @method Doctrine_Collection getNewsletterUser()  Returns the current record's "NewsletterUser" collection
 * @method Newsletter          setName()            Sets the current record's "name" value
 * @method Newsletter          setDescription()     Sets the current record's "description" value
 * @method Newsletter          setIsActive()        Sets the current record's "is_active" value
 * @method Newsletter          setMailchimpGroup()  Sets the current record's "mailchimp_group" value
 * @method Newsletter          setCountryId()       Sets the current record's "country_id" value
 * @method Newsletter          setUserGroup()       Sets the current record's "user_group" value
 * @method Newsletter          setCountry()         Sets the current record's "Country" value
 * @method Newsletter          setNewsletterUser()  Sets the current record's "NewsletterUser" collection
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseNewsletter extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('newsletter');
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('description', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('is_active', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('mailchimp_group', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('country_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('user_group', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));

        $this->option('type', 'INNODB');
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Country', array(
             'local' => 'country_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('NewsletterUser', array(
             'local' => 'id',
             'foreign' => 'newsletter_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $i18n0 = new Doctrine_Template_I18n(array(
             'fields' => 
             array(
              0 => 'name',
              1 => 'description',
             ),
             ));
        $this->actAs($timestampable0);
        $this->actAs($i18n0);
    }
}