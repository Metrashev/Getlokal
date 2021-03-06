<?php

/**
 * BaseReviewTop
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $review_id
 * @property integer $country_id
 * @property integer $week_id
 * @property integer $count
 * @property Review $Review
 * @property ReviewTopWeek $ReviewTopWeek
 * @property Country $Country
 * 
 * @method integer       getReviewId()      Returns the current record's "review_id" value
 * @method integer       getCountryId()     Returns the current record's "country_id" value
 * @method integer       getWeekId()        Returns the current record's "week_id" value
 * @method integer       getCount()         Returns the current record's "count" value
 * @method Review        getReview()        Returns the current record's "Review" value
 * @method ReviewTopWeek getReviewTopWeek() Returns the current record's "ReviewTopWeek" value
 * @method Country       getCountry()       Returns the current record's "Country" value
 * @method ReviewTop     setReviewId()      Sets the current record's "review_id" value
 * @method ReviewTop     setCountryId()     Sets the current record's "country_id" value
 * @method ReviewTop     setWeekId()        Sets the current record's "week_id" value
 * @method ReviewTop     setCount()         Sets the current record's "count" value
 * @method ReviewTop     setReview()        Sets the current record's "Review" value
 * @method ReviewTop     setReviewTopWeek() Sets the current record's "ReviewTopWeek" value
 * @method ReviewTop     setCountry()       Sets the current record's "Country" value
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseReviewTop extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('review_top');
        $this->hasColumn('review_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('country_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('week_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('count', 'integer', 4, array(
             'type' => 'integer',
             'default' => 0,
             'length' => 4,
             ));

        $this->option('symfony', array(
             'form' => false,
             'filter' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Review', array(
             'local' => 'review_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('ReviewTopWeek', array(
             'local' => 'week_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Country', array(
             'local' => 'country_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}