<?php

/**
 * BaseCompanyExtra
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $company_id
 * @property string $establishment_date
 * @property string $registration_date
 * @property string $company_form
 * @property string $business_type
 * @property string $nace_code
 * @property string $personal_abount
 * @property string $personal_year
 * @property string $turnover
 * @property string $turnover_year
 * @property string $tax_reg
 * @property string $financial_risk
 * @property string $source
 * @property Company $Company
 * 
 * @method integer      getCompanyId()          Returns the current record's "company_id" value
 * @method string       getEstablishmentDate()  Returns the current record's "establishment_date" value
 * @method string       getRegistrationDate()   Returns the current record's "registration_date" value
 * @method string       getCompanyForm()        Returns the current record's "company_form" value
 * @method string       getBusinessType()       Returns the current record's "business_type" value
 * @method string       getNaceCode()           Returns the current record's "nace_code" value
 * @method string       getPersonalAbount()     Returns the current record's "personal_abount" value
 * @method string       getPersonalYear()       Returns the current record's "personal_year" value
 * @method string       getTurnover()           Returns the current record's "turnover" value
 * @method string       getTurnoverYear()       Returns the current record's "turnover_year" value
 * @method string       getTaxReg()             Returns the current record's "tax_reg" value
 * @method string       getFinancialRisk()      Returns the current record's "financial_risk" value
 * @method string       getSource()             Returns the current record's "source" value
 * @method Company      getCompany()            Returns the current record's "Company" value
 * @method CompanyExtra setCompanyId()          Sets the current record's "company_id" value
 * @method CompanyExtra setEstablishmentDate()  Sets the current record's "establishment_date" value
 * @method CompanyExtra setRegistrationDate()   Sets the current record's "registration_date" value
 * @method CompanyExtra setCompanyForm()        Sets the current record's "company_form" value
 * @method CompanyExtra setBusinessType()       Sets the current record's "business_type" value
 * @method CompanyExtra setNaceCode()           Sets the current record's "nace_code" value
 * @method CompanyExtra setPersonalAbount()     Sets the current record's "personal_abount" value
 * @method CompanyExtra setPersonalYear()       Sets the current record's "personal_year" value
 * @method CompanyExtra setTurnover()           Sets the current record's "turnover" value
 * @method CompanyExtra setTurnoverYear()       Sets the current record's "turnover_year" value
 * @method CompanyExtra setTaxReg()             Sets the current record's "tax_reg" value
 * @method CompanyExtra setFinancialRisk()      Sets the current record's "financial_risk" value
 * @method CompanyExtra setSource()             Sets the current record's "source" value
 * @method CompanyExtra setCompany()            Sets the current record's "Company" value
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCompanyExtra extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('company_extra');
        $this->hasColumn('company_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('establishment_date', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('registration_date', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('company_form', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('business_type', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('nace_code', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('personal_abount', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('personal_year', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('turnover', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('turnover_year', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('tax_reg', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('financial_risk', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('source', 'string', 255, array(
             'type' => 'string',
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
        $this->hasOne('Company', array(
             'local' => 'company_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));
    }
}