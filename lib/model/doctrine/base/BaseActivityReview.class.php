<?php

/**
 * BaseActivityReview
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property Review $Review
 * @property Activity $Activity
 * 
 * @method Review         getReview()   Returns the current record's "Review" value
 * @method Activity       getActivity() Returns the current record's "Activity" value
 * @method ActivityReview setReview()   Sets the current record's "Review" value
 * @method ActivityReview setActivity() Sets the current record's "Activity" value
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseActivityReview extends Activity
{
    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Review', array(
             'local' => 'action_id',
             'foreign' => 'id'));

        $this->hasOne('Activity', array(
             'local' => 'activity_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}