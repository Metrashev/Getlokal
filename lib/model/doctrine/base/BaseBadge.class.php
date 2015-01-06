<?php

/**
 * BaseBadge
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property string $description
 * @property string $long_description
 * @property string $progress_text
 * @property timestamp $start_at
 * @property timestamp $end_at
 * @property integer $requirements
 * @property integer $points
 * @property string $percent
 * @property boolean $is_active
 * @property boolean $is_seasonal
 * @property boolean $is_visible
 * @property boolean $notify_by_email
 * @property boolean $display_message
 * @property Doctrine_Collection $BadgeRequirement
 * @property Doctrine_Collection $UserBadge
 * 
 * @method string              getName()             Returns the current record's "name" value
 * @method string              getDescription()      Returns the current record's "description" value
 * @method string              getLongDescription()  Returns the current record's "long_description" value
 * @method string              getProgressText()     Returns the current record's "progress_text" value
 * @method timestamp           getStartAt()          Returns the current record's "start_at" value
 * @method timestamp           getEndAt()            Returns the current record's "end_at" value
 * @method integer             getRequirements()     Returns the current record's "requirements" value
 * @method integer             getPoints()           Returns the current record's "points" value
 * @method string              getPercent()          Returns the current record's "percent" value
 * @method boolean             getIsActive()         Returns the current record's "is_active" value
 * @method boolean             getIsSeasonal()       Returns the current record's "is_seasonal" value
 * @method boolean             getIsVisible()        Returns the current record's "is_visible" value
 * @method boolean             getNotifyByEmail()    Returns the current record's "notify_by_email" value
 * @method boolean             getDisplayMessage()   Returns the current record's "display_message" value
 * @method Doctrine_Collection getBadgeRequirement() Returns the current record's "BadgeRequirement" collection
 * @method Doctrine_Collection getUserBadge()        Returns the current record's "UserBadge" collection
 * @method Badge               setName()             Sets the current record's "name" value
 * @method Badge               setDescription()      Sets the current record's "description" value
 * @method Badge               setLongDescription()  Sets the current record's "long_description" value
 * @method Badge               setProgressText()     Sets the current record's "progress_text" value
 * @method Badge               setStartAt()          Sets the current record's "start_at" value
 * @method Badge               setEndAt()            Sets the current record's "end_at" value
 * @method Badge               setRequirements()     Sets the current record's "requirements" value
 * @method Badge               setPoints()           Sets the current record's "points" value
 * @method Badge               setPercent()          Sets the current record's "percent" value
 * @method Badge               setIsActive()         Sets the current record's "is_active" value
 * @method Badge               setIsSeasonal()       Sets the current record's "is_seasonal" value
 * @method Badge               setIsVisible()        Sets the current record's "is_visible" value
 * @method Badge               setNotifyByEmail()    Sets the current record's "notify_by_email" value
 * @method Badge               setDisplayMessage()   Sets the current record's "display_message" value
 * @method Badge               setBadgeRequirement() Sets the current record's "BadgeRequirement" collection
 * @method Badge               setUserBadge()        Sets the current record's "UserBadge" collection
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseBadge extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('badge');
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('description', 'string', 1000, array(
             'type' => 'string',
             'length' => 1000,
             ));
        $this->hasColumn('long_description', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('progress_text', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('start_at', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('end_at', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('requirements', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('points', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('percent', 'string', 5, array(
             'type' => 'string',
             'length' => 5,
             ));
        $this->hasColumn('is_active', 'boolean', null, array(
             'type' => 'boolean',
             ));
        $this->hasColumn('is_seasonal', 'boolean', null, array(
             'type' => 'boolean',
             ));
        $this->hasColumn('is_visible', 'boolean', null, array(
             'type' => 'boolean',
             ));
        $this->hasColumn('notify_by_email', 'boolean', null, array(
             'type' => 'boolean',
             ));
        $this->hasColumn('display_message', 'boolean', null, array(
             'type' => 'boolean',
             ));

        $this->option('type', 'INNODB');
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('BadgeRequirement', array(
             'local' => 'id',
             'foreign' => 'badge_id'));

        $this->hasMany('UserBadge', array(
             'local' => 'id',
             'foreign' => 'badge_id'));

        $i18n0 = new Doctrine_Template_I18n(array(
             'fields' => 
             array(
              0 => 'name',
              1 => 'description',
              2 => 'long_description',
              3 => 'notify_text',
              4 => 'progress_text',
             ),
             ));
        $doctrineclusterstorage0 = new DoctrineClusterStorage(array(
             'small_active_image' => 
             array(
              'is_image' => false,
              'prefix' => 'badge',
              'sizefield_name' => false,
             ),
             'active_image' => 
             array(
              'is_image' => false,
              'prefix' => 'badge',
              'sizefield_name' => false,
             ),
             'inactive_image' => 
             array(
              'is_image' => false,
              'prefix' => 'badge',
              'sizefield_name' => false,
             ),
             ));
        $this->actAs($i18n0);
        $this->actAs($doctrineclusterstorage0);
    }
}