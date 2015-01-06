<?php

/**
 * BaseGeoipCountries
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $ip_from
 * @property string $ip_to
 * @property integer $integer_from
 * @property integer $integer_to
 * @property string $country_slugs
 * @property string $country_names
 * 
 * @method string         getIpFrom()        Returns the current record's "ip_from" value
 * @method string         getIpTo()          Returns the current record's "ip_to" value
 * @method integer        getIntegerFrom()   Returns the current record's "integer_from" value
 * @method integer        getIntegerTo()     Returns the current record's "integer_to" value
 * @method string         getCountrySlugs()  Returns the current record's "country_slugs" value
 * @method string         getCountryNames()  Returns the current record's "country_names" value
 * @method GeoipCountries setIpFrom()        Sets the current record's "ip_from" value
 * @method GeoipCountries setIpTo()          Sets the current record's "ip_to" value
 * @method GeoipCountries setIntegerFrom()   Sets the current record's "integer_from" value
 * @method GeoipCountries setIntegerTo()     Sets the current record's "integer_to" value
 * @method GeoipCountries setCountrySlugs()  Sets the current record's "country_slugs" value
 * @method GeoipCountries setCountryNames()  Sets the current record's "country_names" value
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseGeoipCountries extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('geoip_countries');
        $this->hasColumn('ip_from', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('ip_to', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('integer_from', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('integer_to', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('country_slugs', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('country_names', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
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