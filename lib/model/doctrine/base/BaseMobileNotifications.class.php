<?php

/**
 * BaseMobileNotifications
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $message_text
 * @property string $device_os
 * @property string $app_version
 * @property integer $country_id
 * @property integer $city_id
 * @property integer $country_gps
 * @property char $locale
 * @property integer $count_ios
 * @property integer $succeded_ios
 * @property integer $failed_ios
 * @property integer $deleted_ios
 * @property integer $count_android
 * @property integer $succeded_android
 * @property integer $failed_android
 * @property integer $deleted_android
 * @property integer $send_from
 * @property UserProfile $UserProfile
 * @property Country $Country
 * @property City $City
 * 
 * @method string              getMessageText()      Returns the current record's "message_text" value
 * @method string              getDeviceOs()         Returns the current record's "device_os" value
 * @method string              getAppVersion()       Returns the current record's "app_version" value
 * @method integer             getCountryId()        Returns the current record's "country_id" value
 * @method integer             getCityId()           Returns the current record's "city_id" value
 * @method integer             getCountryGps()       Returns the current record's "country_gps" value
 * @method char                getLocale()           Returns the current record's "locale" value
 * @method integer             getCountIos()         Returns the current record's "count_ios" value
 * @method integer             getSuccededIos()      Returns the current record's "succeded_ios" value
 * @method integer             getFailedIos()        Returns the current record's "failed_ios" value
 * @method integer             getDeletedIos()       Returns the current record's "deleted_ios" value
 * @method integer             getCountAndroid()     Returns the current record's "count_android" value
 * @method integer             getSuccededAndroid()  Returns the current record's "succeded_android" value
 * @method integer             getFailedAndroid()    Returns the current record's "failed_android" value
 * @method integer             getDeletedAndroid()   Returns the current record's "deleted_android" value
 * @method integer             getSendFrom()         Returns the current record's "send_from" value
 * @method UserProfile         getUserProfile()      Returns the current record's "UserProfile" value
 * @method Country             getCountry()          Returns the current record's "Country" value
 * @method City                getCity()             Returns the current record's "City" value
 * @method MobileNotifications setMessageText()      Sets the current record's "message_text" value
 * @method MobileNotifications setDeviceOs()         Sets the current record's "device_os" value
 * @method MobileNotifications setAppVersion()       Sets the current record's "app_version" value
 * @method MobileNotifications setCountryId()        Sets the current record's "country_id" value
 * @method MobileNotifications setCityId()           Sets the current record's "city_id" value
 * @method MobileNotifications setCountryGps()       Sets the current record's "country_gps" value
 * @method MobileNotifications setLocale()           Sets the current record's "locale" value
 * @method MobileNotifications setCountIos()         Sets the current record's "count_ios" value
 * @method MobileNotifications setSuccededIos()      Sets the current record's "succeded_ios" value
 * @method MobileNotifications setFailedIos()        Sets the current record's "failed_ios" value
 * @method MobileNotifications setDeletedIos()       Sets the current record's "deleted_ios" value
 * @method MobileNotifications setCountAndroid()     Sets the current record's "count_android" value
 * @method MobileNotifications setSuccededAndroid()  Sets the current record's "succeded_android" value
 * @method MobileNotifications setFailedAndroid()    Sets the current record's "failed_android" value
 * @method MobileNotifications setDeletedAndroid()   Sets the current record's "deleted_android" value
 * @method MobileNotifications setSendFrom()         Sets the current record's "send_from" value
 * @method MobileNotifications setUserProfile()      Sets the current record's "UserProfile" value
 * @method MobileNotifications setCountry()          Sets the current record's "Country" value
 * @method MobileNotifications setCity()             Sets the current record's "City" value
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseMobileNotifications extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('mobile_notifications');
        $this->hasColumn('message_text', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('device_os', 'string', 10, array(
             'type' => 'string',
             'length' => 10,
             ));
        $this->hasColumn('app_version', 'string', 10, array(
             'type' => 'string',
             'length' => 10,
             ));
        $this->hasColumn('country_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('city_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('country_gps', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('locale', 'char', 2, array(
             'type' => 'char',
             'length' => 2,
             ));
        $this->hasColumn('count_ios', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('succeded_ios', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('failed_ios', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('deleted_ios', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('count_android', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('succeded_android', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('failed_android', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('deleted_android', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('send_from', 'integer', null, array(
             'type' => 'integer',
             ));

        $this->option('type', 'INNODB');
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('UserProfile', array(
             'local' => 'send_from',
             'foreign' => 'id'));

        $this->hasOne('Country', array(
             'local' => 'country_id',
             'foreign' => 'id'));

        $this->hasOne('City', array(
             'local' => 'city_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}