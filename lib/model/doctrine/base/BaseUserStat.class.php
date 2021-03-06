<?php

/**
 * BaseUserStat
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $user_id
 * @property string $key
 * @property integer $value
 * @property UserProfile $UserProfile
 * @property BadgeRequirementField $BadgeRequirementField
 * 
 * @method integer               getUserId()                Returns the current record's "user_id" value
 * @method string                getKey()                   Returns the current record's "key" value
 * @method integer               getValue()                 Returns the current record's "value" value
 * @method UserProfile           getUserProfile()           Returns the current record's "UserProfile" value
 * @method BadgeRequirementField getBadgeRequirementField() Returns the current record's "BadgeRequirementField" value
 * @method UserStat              setUserId()                Sets the current record's "user_id" value
 * @method UserStat              setKey()                   Sets the current record's "key" value
 * @method UserStat              setValue()                 Sets the current record's "value" value
 * @method UserStat              setUserProfile()           Sets the current record's "UserProfile" value
 * @method UserStat              setBadgeRequirementField() Sets the current record's "BadgeRequirementField" value
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseUserStat extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('user_stat');
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('keyName as key', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('keyValue as value', 'integer', null, array(
             'type' => 'integer',
             ));

        $this->option('symfony', array(
             'form' => false,
             'filter' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('UserProfile', array(
             'local' => 'user_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('BadgeRequirementField', array(
             'local' => 'key',
             'foreign' => 'key'));
    }
}