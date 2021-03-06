<?php

/**
 * BaseActivityList
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property Lists $Lists
 * 
 * @method Lists        getLists() Returns the current record's "Lists" value
 * @method ActivityList setLists() Sets the current record's "Lists" value
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseActivityList extends Activity
{
    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Lists', array(
             'local' => 'action_id',
             'foreign' => 'id'));
    }
}