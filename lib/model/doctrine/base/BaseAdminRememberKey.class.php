<?php

/**
 * BaseAdminRememberKey
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $page_admin_id
 * @property string $remember_key
 * @property string $ip_address
 * @property PageAdmin $PageAdmin
 * 
 * @method integer          getPageAdminId()   Returns the current record's "page_admin_id" value
 * @method string           getRememberKey()   Returns the current record's "remember_key" value
 * @method string           getIpAddress()     Returns the current record's "ip_address" value
 * @method PageAdmin        getPageAdmin()     Returns the current record's "PageAdmin" value
 * @method AdminRememberKey setPageAdminId()   Sets the current record's "page_admin_id" value
 * @method AdminRememberKey setRememberKey()   Sets the current record's "remember_key" value
 * @method AdminRememberKey setIpAddress()     Sets the current record's "ip_address" value
 * @method AdminRememberKey setPageAdmin()     Sets the current record's "PageAdmin" value
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseAdminRememberKey extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('admin_remember_key');
        $this->hasColumn('page_admin_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('remember_key', 'string', 32, array(
             'type' => 'string',
             'length' => 32,
             ));
        $this->hasColumn('ip_address', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));

        $this->option('symfony', array(
             'form' => false,
             'filter' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('PageAdmin', array(
             'local' => 'page_admin_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $this->actAs($timestampable0);
    }
}