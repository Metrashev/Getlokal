<?php

/**
* CompanyOfferTranslation form.
*
* @package    getLokal
* @subpackage form
* @author     Get Lokal
* @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
*/
class CompanyOfferTranslationForm extends BaseCompanyOfferTranslationForm
{
    public function configure()
    {
        $this->setWidgets(array(
            'title' => new sfWidgetFormInput(),
            'content' => new sfWidgetFormTextareaTinyMCECustom(array(
                'width' => 580,
                'height' => 300,
                'theme' => 'advanced'
            ), array('class' => 'tinyMCE'))
        ));

        $this->widgetSchema->setLabels(array(
            'title' => 'Offer Title',
            'content' => 'Offer Description'
        ));

        $this->setValidators(array(
            'title' => new sfValidatorRegex(array(
            	'trim' => true,
                'required' => false,
                'min_length' => 5,
                'max_length' => 100,
            	'pattern' => '/^[\p{L}\p{N}]([\p{L}\p{N}\?\s\.\(\)\{\}\[\],%]+)[\p{L}\p{N}]$/u',
            ), array(
                'min_length' => 'Description must contain at least %min_length% characters',
                'max_length' =>'The description cannot contain more than %max_length% characters.',
            	'invalid' => 'You can only use alphanumeric characters and ? ( ) [ ] { } %'
            )),
            'content' => new sfValidatorString(array(
                'required' => false,
                'min_length' => 30,
                'max_length' => 10000
            ), array(
                'min_length' => 'Description must contain at least %min_length% characters',
                'max_length' => 'The description cannot contain more than %max_length% characters.'
            ))
        ));
        $this->validatorSchema->setOption('allow_extra_fields', true);
        $this->validatorSchema->setOption('filter_extra_fields', true);
        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('form');
    }
}
