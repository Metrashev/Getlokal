<?php

/**
 * CompanyOffer form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CompanyOfferEditForm extends CompanyOfferForm {

    public function configure() {
        parent::configure();
        $this->useFields(array('active_to', 'max_vouchers', 'max_per_user', 'file', 'benefit_choice','new_price','old_price', 'discount_pct', 'benefit_text' ));

    }

    public function processUploadedFile($field, $filename = null, $values = null) {
        return true;
    }

    public function postValidateMe($validator, $values, $errors = array()) {
        $product_ordered = $this->getObject()->getAdServiceCompany();
        if (!$product_ordered->getStatus() == "active") {
            $errors[] = new sfValidatorErrorSchema($validator, array(
                'valid_to' => new sfValidatorError($validator, 'Your order is expired')
            ));
        }

        if (!empty($values['max_vouchers']) && $this->getObject()->getCountVoucherCodes() > $values["max_vouchers"]) {
            throw new sfValidatorErrorSchema($validator, array(
                'max_vouchers' => new sfValidatorError($validator, 'The maximum number of vouchers cannot be lower than the total number of vouchers already issued')
            ));
        }

        return parent::postValidateMe($validator, $values, $errors);
    }
 
}
