<?php

/**
 * BaseClassificationSector
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $classification_id
 * @property integer $sector_id
 * @property Classification $Classification
 * @property Sector $Sector
 * 
 * @method integer              getClassificationId()  Returns the current record's "classification_id" value
 * @method integer              getSectorId()          Returns the current record's "sector_id" value
 * @method Classification       getClassification()    Returns the current record's "Classification" value
 * @method Sector               getSector()            Returns the current record's "Sector" value
 * @method ClassificationSector setClassificationId()  Sets the current record's "classification_id" value
 * @method ClassificationSector setSectorId()          Sets the current record's "sector_id" value
 * @method ClassificationSector setClassification()    Sets the current record's "Classification" value
 * @method ClassificationSector setSector()            Sets the current record's "Sector" value
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseClassificationSector extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('classification_sector');
        $this->hasColumn('classification_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('sector_id', 'integer', null, array(
             'type' => 'integer',
             ));

        $this->option('type', 'INNODB');
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Classification', array(
             'local' => 'classification_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Sector', array(
             'local' => 'sector_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}