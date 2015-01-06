<?php

/**
 * BaseMobileNewsCity
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $news_id
 * @property integer $city_id
 * @property MobileNews $MobileNews
 * @property City $City
 * 
 * @method integer        getNewsId()     Returns the current record's "news_id" value
 * @method integer        getCityId()     Returns the current record's "city_id" value
 * @method MobileNews     getMobileNews() Returns the current record's "MobileNews" value
 * @method City           getCity()       Returns the current record's "City" value
 * @method MobileNewsCity setNewsId()     Sets the current record's "news_id" value
 * @method MobileNewsCity setCityId()     Sets the current record's "city_id" value
 * @method MobileNewsCity setMobileNews() Sets the current record's "MobileNews" value
 * @method MobileNewsCity setCity()       Sets the current record's "City" value
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseMobileNewsCity extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('mobile_news_city');
        $this->hasColumn('news_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('city_id', 'integer', null, array(
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
        $this->hasOne('MobileNews', array(
             'local' => 'news_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('City', array(
             'local' => 'city_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}