<?php

/**
 * CompanySearchTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class CompanySearchTable extends SearchTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object CompanySearchTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('CompanySearch');
    }
}