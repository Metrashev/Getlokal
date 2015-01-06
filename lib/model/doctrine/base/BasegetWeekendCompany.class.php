<?php

/**
 * BasegetWeekendCompany
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $parent_id
 * @property integer $company_id
 * @property Company $Company
 * @property getWeekend $getWeekend
 * 
 * @method integer           getParentId()   Returns the current record's "parent_id" value
 * @method integer           getCompanyId()  Returns the current record's "company_id" value
 * @method Company           getCompany()    Returns the current record's "Company" value
 * @method getWeekend        getGetWeekend() Returns the current record's "getWeekend" value
 * @method getWeekendCompany setParentId()   Sets the current record's "parent_id" value
 * @method getWeekendCompany setCompanyId()  Sets the current record's "company_id" value
 * @method getWeekendCompany setCompany()    Sets the current record's "Company" value
 * @method getWeekendCompany setGetWeekend() Sets the current record's "getWeekend" value
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasegetWeekendCompany extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('get_weekend_company');
        $this->hasColumn('parent_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('company_id', 'integer', null, array(
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
        $this->hasOne('Company', array(
             'local' => 'company_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('getWeekend', array(
             'local' => 'parent_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}