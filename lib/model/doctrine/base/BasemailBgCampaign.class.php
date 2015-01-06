<?php

/**
 * BasemailBgCampaign
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $company_id
 * @property integer $city_id
 * @property boolean $is_active
 * @property Company $Company
 * @property City $City
 * 
 * @method integer        getCompanyId()  Returns the current record's "company_id" value
 * @method integer        getCityId()     Returns the current record's "city_id" value
 * @method boolean        getIsActive()   Returns the current record's "is_active" value
 * @method Company        getCompany()    Returns the current record's "Company" value
 * @method City           getCity()       Returns the current record's "City" value
 * @method mailBgCampaign setCompanyId()  Sets the current record's "company_id" value
 * @method mailBgCampaign setCityId()     Sets the current record's "city_id" value
 * @method mailBgCampaign setIsActive()   Sets the current record's "is_active" value
 * @method mailBgCampaign setCompany()    Sets the current record's "Company" value
 * @method mailBgCampaign setCity()       Sets the current record's "City" value
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasemailBgCampaign extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('mail_bg_campaign');
        $this->hasColumn('company_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('city_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('is_active', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));


        $this->index('company_index', array(
             'fields' => 
             array(
              0 => 'company_id',
             ),
             'type' => 'unique',
             ));
        $this->option('type', 'INNODB');
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Company', array(
             'local' => 'company_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('City', array(
             'local' => 'city_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}