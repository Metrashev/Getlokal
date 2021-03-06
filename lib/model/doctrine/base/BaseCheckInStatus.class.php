<?php

/**
 * BaseCheckInStatus
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $user_id
 * @property integer $company_id
 * @property string $latitude
 * @property string $longitude
 * @property Company $Company
 * 
 * @method integer       getUserId()     Returns the current record's "user_id" value
 * @method integer       getCompanyId()  Returns the current record's "company_id" value
 * @method string        getLatitude()   Returns the current record's "latitude" value
 * @method string        getLongitude()  Returns the current record's "longitude" value
 * @method Company       getCompany()    Returns the current record's "Company" value
 * @method CheckInStatus setUserId()     Sets the current record's "user_id" value
 * @method CheckInStatus setCompanyId()  Sets the current record's "company_id" value
 * @method CheckInStatus setLatitude()   Sets the current record's "latitude" value
 * @method CheckInStatus setLongitude()  Sets the current record's "longitude" value
 * @method CheckInStatus setCompany()    Sets the current record's "Company" value
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCheckInStatus extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('check_in_status');
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('company_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('latitude', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));
        $this->hasColumn('longitude', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             ));

        $this->option('symfony', array(
             'form' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Company', array(
             'local' => 'company_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}