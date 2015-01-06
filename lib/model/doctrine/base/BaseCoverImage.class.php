<?php

/**
 * BaseCoverImage
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $company_id
 * @property integer $user_id
 * @property string $filename
 * @property string $caption
 * @property enum $status
 * @property Company $Company
 * @property UserProfile $UserProfile
 * 
 * @method integer     getCompanyId()   Returns the current record's "company_id" value
 * @method integer     getUserId()      Returns the current record's "user_id" value
 * @method string      getFilename()    Returns the current record's "filename" value
 * @method string      getCaption()     Returns the current record's "caption" value
 * @method enum        getStatus()      Returns the current record's "status" value
 * @method Company     getCompany()     Returns the current record's "Company" value
 * @method UserProfile getUserProfile() Returns the current record's "UserProfile" value
 * @method CoverImage  setCompanyId()   Sets the current record's "company_id" value
 * @method CoverImage  setUserId()      Sets the current record's "user_id" value
 * @method CoverImage  setFilename()    Sets the current record's "filename" value
 * @method CoverImage  setCaption()     Sets the current record's "caption" value
 * @method CoverImage  setStatus()      Sets the current record's "status" value
 * @method CoverImage  setCompany()     Sets the current record's "Company" value
 * @method CoverImage  setUserProfile() Sets the current record's "UserProfile" value
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCoverImage extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('cover_image');
        $this->hasColumn('company_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('filename', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('caption', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('status', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'approved',
              1 => 'rejected',
              2 => 'pending',
              3 => 'mobile_upload',
             ),
             'default' => 'approved',
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

        $this->hasOne('UserProfile', array(
             'local' => 'user_id',
             'foreign' => 'id',
             'onDelete' => 'SET NULL'));
    }
}