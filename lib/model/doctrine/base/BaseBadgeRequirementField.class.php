<?php

/**
 * BaseBadgeRequirementField
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $requirement_id
 * @property string $key
 * @property BadgeRequirement $BadgeRequirement
 * @property Doctrine_Collection $UserStat
 * 
 * @method integer               getRequirementId()    Returns the current record's "requirement_id" value
 * @method string                getKey()              Returns the current record's "key" value
 * @method BadgeRequirement      getBadgeRequirement() Returns the current record's "BadgeRequirement" value
 * @method Doctrine_Collection   getUserStat()         Returns the current record's "UserStat" collection
 * @method BadgeRequirementField setRequirementId()    Sets the current record's "requirement_id" value
 * @method BadgeRequirementField setKey()              Sets the current record's "key" value
 * @method BadgeRequirementField setBadgeRequirement() Sets the current record's "BadgeRequirement" value
 * @method BadgeRequirementField setUserStat()         Sets the current record's "UserStat" collection
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseBadgeRequirementField extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('badge_requirement_field');
        $this->hasColumn('requirement_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('keyName as key', 'string', 255, array(
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
        $this->hasOne('BadgeRequirement', array(
             'local' => 'requirement_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('UserStat', array(
             'local' => 'key',
             'foreign' => 'key'));
    }
}