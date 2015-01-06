<?php

/**
 * CompanyOffer filter form.
 *
 * @package    getLokal
 * @subpackage filter
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CompanyOfferFormFilter extends BaseCompanyOfferFormFilter
{

  public function configure()
  {    
     $this->widgetSchema ['count_voucher_codes'] = new sfWidgetFormChoice(array('choices' => array('' => '', '0' => 'No', '1' => 'Yes' ), 
     	'label' => 'Claimed vouchers'));
     $this->setValidator ('count_voucher_codes', new sfValidatorChoice(array('required' => false, 'choices' => array('', 0, 1))));
  }

	public function addCountVoucherCodesColumnQuery($query, $field, $value) {
		if ($value ['text'] != null) {
			Doctrine::getTable ( 'CompanyOffer' )->applyCountVoucherCodesFilter ( $query, $value );
		}
	}

	public function getFields() {
		$fields = parent::getFields ();
		$fields ['count_voucher_codes'] = 'count_voucher_codes';
		return $fields;
	}
}
