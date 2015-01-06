<?php

/**
 * BaseCompanyStatus
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $user_id
 * @property integer $company_id
 * @property string $text
 * @property string $publish_to
 * @property boolean $is_published
 * @property UserProfile $UserProfile
 * @property Company $Company
 * 
 * @method integer       getUserId()       Returns the current record's "user_id" value
 * @method integer       getCompanyId()    Returns the current record's "company_id" value
 * @method string        getText()         Returns the current record's "text" value
 * @method string        getPublishTo()    Returns the current record's "publish_to" value
 * @method boolean       getIsPublished()  Returns the current record's "is_published" value
 * @method UserProfile   getUserProfile()  Returns the current record's "UserProfile" value
 * @method Company       getCompany()      Returns the current record's "Company" value
 * @method CompanyStatus setUserId()       Sets the current record's "user_id" value
 * @method CompanyStatus setCompanyId()    Sets the current record's "company_id" value
 * @method CompanyStatus setText()         Sets the current record's "text" value
 * @method CompanyStatus setPublishTo()    Sets the current record's "publish_to" value
 * @method CompanyStatus setIsPublished()  Sets the current record's "is_published" value
 * @method CompanyStatus setUserProfile()  Sets the current record's "UserProfile" value
 * @method CompanyStatus setCompany()      Sets the current record's "Company" value
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCompanyStatus extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('company_status');
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('company_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('text', 'string', 5000, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 5000,
             ));
        $this->hasColumn('publish_to', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('is_published', 'boolean', null, array(
             'type' => 'boolean',
             'default' => true,
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
             'onDelete' => 'NO ACTION'));

        $this->hasOne('Company', array(
             'local' => 'company_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}