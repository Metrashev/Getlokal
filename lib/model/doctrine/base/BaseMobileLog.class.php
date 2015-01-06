<?php

/**
 * BaseMobileLog
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $user_id
 * @property enum $device
 * @property string $version
 * @property enum $action
 * @property integer $foreign_id
 * @property string $lat
 * @property string $lng
 * @property UserProfile $UserProfile
 * 
 * @method integer     getUserId()      Returns the current record's "user_id" value
 * @method enum        getDevice()      Returns the current record's "device" value
 * @method string      getVersion()     Returns the current record's "version" value
 * @method enum        getAction()      Returns the current record's "action" value
 * @method integer     getForeignId()   Returns the current record's "foreign_id" value
 * @method string      getLat()         Returns the current record's "lat" value
 * @method string      getLng()         Returns the current record's "lng" value
 * @method UserProfile getUserProfile() Returns the current record's "UserProfile" value
 * @method MobileLog   setUserId()      Sets the current record's "user_id" value
 * @method MobileLog   setDevice()      Sets the current record's "device" value
 * @method MobileLog   setVersion()     Sets the current record's "version" value
 * @method MobileLog   setAction()      Sets the current record's "action" value
 * @method MobileLog   setForeignId()   Sets the current record's "foreign_id" value
 * @method MobileLog   setLat()         Sets the current record's "lat" value
 * @method MobileLog   setLng()         Sets the current record's "lng" value
 * @method MobileLog   setUserProfile() Sets the current record's "UserProfile" value
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseMobileLog extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('mobile_log');
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('device', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'ios',
              1 => 'android',
             ),
             ));
        $this->hasColumn('version', 'string', 80, array(
             'type' => 'string',
             'length' => 80,
             ));
        $this->hasColumn('action', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'login',
              1 => 'register',
              2 => 'company',
              3 => 'review',
              4 => 'upload',
              5 => 'checkin',
              6 => 'follow',
              7 => 'getvoucher',
             ),
             ));
        $this->hasColumn('foreign_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('lat', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('lng', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));

        $this->option('type', 'INNODB');
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('UserProfile', array(
             'local' => 'user_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}