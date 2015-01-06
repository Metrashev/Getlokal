<?php

/**
 * BaseActivityLogUser
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $object
 * @property string $action
 * @property string $email_address
 * @property string $ip_address
 * @property timestamp $created_at
 * @property integer $object_id
 * 
 * @method string          getObject()        Returns the current record's "object" value
 * @method string          getAction()        Returns the current record's "action" value
 * @method string          getEmailAddress()  Returns the current record's "email_address" value
 * @method string          getIpAddress()     Returns the current record's "ip_address" value
 * @method timestamp       getCreatedAt()     Returns the current record's "created_at" value
 * @method integer         getObjectId()      Returns the current record's "object_id" value
 * @method ActivityLogUser setObject()        Sets the current record's "object" value
 * @method ActivityLogUser setAction()        Sets the current record's "action" value
 * @method ActivityLogUser setEmailAddress()  Sets the current record's "email_address" value
 * @method ActivityLogUser setIpAddress()     Sets the current record's "ip_address" value
 * @method ActivityLogUser setCreatedAt()     Sets the current record's "created_at" value
 * @method ActivityLogUser setObjectId()      Sets the current record's "object_id" value
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseActivityLogUser extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('activity_log_user');
        $this->hasColumn('object', 'string', 30, array(
             'type' => 'string',
             'length' => 30,
             ));
        $this->hasColumn('action', 'string', 30, array(
             'type' => 'string',
             'length' => 30,
             ));
        $this->hasColumn('email_address', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('ip_address', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('created_at', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('object_id', 'integer', null, array(
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
        
    }
}