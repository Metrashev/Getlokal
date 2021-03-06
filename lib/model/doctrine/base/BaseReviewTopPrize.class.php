<?php

/**
 * BaseReviewTopPrize
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property string $name_en
 * @property string $description
 * @property string $description_en
 * @property integer $place
 * @property integer $country_id
 * @property integer $week_id
 * @property ReviewTopWeek $ReviewTopWeek
 * @property Country $Country
 * 
 * @method string         getName()           Returns the current record's "name" value
 * @method string         getNameEn()         Returns the current record's "name_en" value
 * @method string         getDescription()    Returns the current record's "description" value
 * @method string         getDescriptionEn()  Returns the current record's "description_en" value
 * @method integer        getPlace()          Returns the current record's "place" value
 * @method integer        getCountryId()      Returns the current record's "country_id" value
 * @method integer        getWeekId()         Returns the current record's "week_id" value
 * @method ReviewTopWeek  getReviewTopWeek()  Returns the current record's "ReviewTopWeek" value
 * @method Country        getCountry()        Returns the current record's "Country" value
 * @method ReviewTopPrize setName()           Sets the current record's "name" value
 * @method ReviewTopPrize setNameEn()         Sets the current record's "name_en" value
 * @method ReviewTopPrize setDescription()    Sets the current record's "description" value
 * @method ReviewTopPrize setDescriptionEn()  Sets the current record's "description_en" value
 * @method ReviewTopPrize setPlace()          Sets the current record's "place" value
 * @method ReviewTopPrize setCountryId()      Sets the current record's "country_id" value
 * @method ReviewTopPrize setWeekId()         Sets the current record's "week_id" value
 * @method ReviewTopPrize setReviewTopWeek()  Sets the current record's "ReviewTopWeek" value
 * @method ReviewTopPrize setCountry()        Sets the current record's "Country" value
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseReviewTopPrize extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('review_top_prize');
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('name_en', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('description', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('description_en', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('place', 'integer', 1, array(
             'type' => 'integer',
             'default' => 1,
             'length' => 1,
             ));
        $this->hasColumn('country_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('week_id', 'integer', null, array(
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
        $this->hasOne('ReviewTopWeek', array(
             'local' => 'week_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Country', array(
             'local' => 'country_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $doctrineclusterstorage0 = new DoctrineClusterStorage(array(
             'filename' => 
             array(
              'is_image' => true,
              'sizes' => 
              array(
              0 => '295x170',
              1 => '63x63',
              ),
              'prefix' => 'review_prize',
              'sizefield_name' => false,
             ),
             ));
        $this->actAs($doctrineclusterstorage0);
    }
}