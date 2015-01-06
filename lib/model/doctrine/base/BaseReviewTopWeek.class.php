<?php

/**
 * BaseReviewTopWeek
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property date $time_from
 * @property date $time_to
 * @property enum $top_type
 * @property Doctrine_Collection $ReviewTop
 * 
 * @method date                getTimeFrom()       Returns the current record's "time_from" value
 * @method date                getTimeTo()         Returns the current record's "time_to" value
 * @method enum                getTopType()        Returns the current record's "top_type" value
 * @method Doctrine_Collection getReviewTopPrize() Returns the current record's "ReviewTopPrize" collection
 * @method Doctrine_Collection getReviewTop()      Returns the current record's "ReviewTop" collection
 * @method ReviewTopWeek       setTimeFrom()       Sets the current record's "time_from" value
 * @method ReviewTopWeek       setTimeTo()         Sets the current record's "time_to" value
 * @method ReviewTopWeek       setTopType()        Sets the current record's "top_type" value
 * @method ReviewTopWeek       setReviewTopPrize() Sets the current record's "ReviewTopPrize" collection
 * @method ReviewTopWeek       setReviewTop()      Sets the current record's "ReviewTop" collectionPrize
 * @property Doctrine_Collection $ReviewTop
 * 
 * @method date                getTimeFrom()       Returns the current record's "time_from" value
 * @method date                getTimeTo()         Returns the current record's "time_to" value
 * @method enum                getTopType()        Returns the current record's "top_type" value
 * @method Doctrine_Collection getReviewTopPrize() Returns the current record's "ReviewTopPrize" collection
 * @method Doctrine_Collection getReviewTop()      Returns the current record's "ReviewTop" collection
 * @method ReviewTopWeek       setTimeFrom()       Sets the current record's "time_from" value
 * @method ReviewTopWeek       setTimeTo()         Sets the current record's "time_to" value
 * @method ReviewTopWeek       setTopType()        Sets the current record's "top_type" value
 * @method ReviewTopWeek       setReviewTopPrize() Sets the current record's "ReviewTopPrize" collection
 * @method ReviewTopWeek       setReviewTop()      Sets the current record's "ReviewTop" collection
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseReviewTopWeek extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('review_top_week');
        $this->hasColumn('time_from', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('time_to', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('top_type', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'week',
              1 => 'month',
             ),
             ));

        $this->option('symfony', array(
             'form' => false,
             'filter' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('ReviewTopPrize', array(
             'local' => 'id',
             'foreign' => 'week_id'));

        $this->hasMany('ReviewTop', array(
             'local' => 'id',
             'foreign' => 'week_id'));
    }
}