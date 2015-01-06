<?php

/**
 * BaseCounty
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property string $municipality
 * @property string $region
 * @property integer $country_id
 * @property string $slug
 * @property Country $Country
 * @property Doctrine_Collection $City
 * 
 * @method string              getName()         Returns the current record's "name" value
 * @method string              getMunicipality() Returns the current record's "municipality" value
 * @method string              getRegion()       Returns the current record's "region" value
 * @method integer             getCountryId()    Returns the current record's "country_id" value
 * @method string              getSlug()         Returns the current record's "slug" value
 * @method Country             getCountry()      Returns the current record's "Country" value
 * @method Doctrine_Collection getCity()         Returns the current record's "City" collection
 * @method County              setName()         Sets the current record's "name" value
 * @method County              setMunicipality() Sets the current record's "municipality" value
 * @method County              setRegion()       Sets the current record's "region" value
 * @method County              setCountryId()    Sets the current record's "country_id" value
 * @method County              setSlug()         Sets the current record's "slug" value
 * @method County              setCountry()      Sets the current record's "Country" value
 * @method County              setCity()         Sets the current record's "City" collection
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCounty extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('county');
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('municipality', 'string', 60, array(
             'type' => 'string',
             'length' => 60,
             ));
        $this->hasColumn('region', 'string', 60, array(
             'type' => 'string',
             'length' => 60,
             ));
        $this->hasColumn('country_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('slug', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));

        $this->option('type', 'INNODB');
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Country', array(
             'local' => 'country_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('City', array(
             'local' => 'id',
             'foreign' => 'county_id'));

        $i18n0 = new Doctrine_Template_I18n(array(
             'fields' => 
             array(
              0 => 'name',
             ),
             ));
        $this->actAs($i18n0);
    }
}