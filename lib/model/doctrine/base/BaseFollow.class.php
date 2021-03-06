<?php

/**
 * BaseFollow
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $user_id
 * @property integer $page_id
 * @property enum $status
 * @property enum $from
 * @property UserProfile $UserProfile
 * @property Page $Page
 * 
 * @method integer     getUserId()      Returns the current record's "user_id" value
 * @method integer     getPageId()      Returns the current record's "page_id" value
 * @method enum        getStatus()      Returns the current record's "status" value
 * @method enum        getFrom()        Returns the current record's "from" value
 * @method UserProfile getUserProfile() Returns the current record's "UserProfile" value
 * @method Page        getPage()        Returns the current record's "Page" value
 * @method Follow      setUserId()      Sets the current record's "user_id" value
 * @method Follow      setPageId()      Sets the current record's "page_id" value
 * @method Follow      setStatus()      Sets the current record's "status" value
 * @method Follow      setFrom()        Sets the current record's "from" value
 * @method Follow      setUserProfile() Sets the current record's "UserProfile" value
 * @method Follow      setPage()        Sets the current record's "Page" value
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseFollow extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('follow');
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('page_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('status', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'one-way',
              1 => 'two-way',
             ),
             'default' => 'one-way',
             ));
        $this->hasColumn('from_value as from', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'site',
              1 => 'import',
             ),
             'default' => 'site',
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

        $this->hasOne('Page', array(
             'local' => 'page_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}