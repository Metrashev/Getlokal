<?php

/**
 * BaseMobileDevice
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $device_os
 * @property string $app_version
 * @property string $device_uid
 * @property string $device_token
 * @property boolean $is_active
 * @property integer $count_failed
 * @property integer $user_id
 * @property integer $country_id
 * @property integer $city_id
 * @property char $country_gps
 * @property char $locale
 * @property UserProfile $UserProfile
 * @property Country $Country
 * @property City $City
 * 
 * @method string       getDeviceOs()     Returns the current record's "device_os" value
 * @method string       getAppVersion()   Returns the current record's "app_version" value
 * @method string       getDeviceUid()    Returns the current record's "device_uid" value
 * @method string       getDeviceToken()  Returns the current record's "device_token" value
 * @method boolean      getIsActive()     Returns the current record's "is_active" value
 * @method integer      getCountFailed()  Returns the current record's "count_failed" value
 * @method integer      getUserId()       Returns the current record's "user_id" value
 * @method integer      getCountryId()    Returns the current record's "country_id" value
 * @method integer      getCityId()       Returns the current record's "city_id" value
 * @method char         getCountryGps()   Returns the current record's "country_gps" value
 * @method char         getLocale()       Returns the current record's "locale" value
 * @method UserProfile  getUserProfile()  Returns the current record's "UserProfile" value
 * @method Country      getCountry()      Returns the current record's "Country" value
 * @method City         getCity()         Returns the current record's "City" value
 * @method MobileDevice setDeviceOs()     Sets the current record's "device_os" value
 * @method MobileDevice setAppVersion()   Sets the current record's "app_version" value
 * @method MobileDevice setDeviceUid()    Sets the current record's "device_uid" value
 * @method MobileDevice setDeviceToken()  Sets the current record's "device_token" value
 * @method MobileDevice setIsActive()     Sets the current record's "is_active" value
 * @method MobileDevice setCountFailed()  Sets the current record's "count_failed" value
 * @method MobileDevice setUserId()       Sets the current record's "user_id" value
 * @method MobileDevice setCountryId()    Sets the current record's "country_id" value
 * @method MobileDevice setCityId()       Sets the current record's "city_id" value
 * @method MobileDevice setCountryGps()   Sets the current record's "country_gps" value
 * @method MobileDevice setLocale()       Sets the current record's "locale" value
 * @method MobileDevice setUserProfile()  Sets the current record's "UserProfile" value
 * @method MobileDevice setCountry()      Sets the current record's "Country" value
 * @method MobileDevice setCity()         Sets the current record's "City" value
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseMobileDevice extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('mobile_device');
        $this->hasColumn('device_os', 'string', 10, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 10,
             ));
        $this->hasColumn('app_version', 'string', 10, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 10,
             ));
        $this->hasColumn('device_uid', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('device_token', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('is_active', 'boolean', null, array(
             'type' => 'boolean',
             'default' => true,
             ));
        $this->hasColumn('count_failed', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('country_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('city_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('country_gps', 'char', 2, array(
             'type' => 'char',
             'length' => 2,
             ));
        $this->hasColumn('locale', 'char', 2, array(
             'type' => 'char',
             'length' => 2,
             ));


        $this->index('device_data', array(
             'fields' => 
             array(
              0 => 'device_os',
              1 => 'device_uid',
              2 => 'device_token',
             ),
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

        $this->hasOne('Country', array(
             'local' => 'country_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('City', array(
             'local' => 'city_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}