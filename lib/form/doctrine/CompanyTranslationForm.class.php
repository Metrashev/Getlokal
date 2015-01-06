<?php

/**
 * CompanyTranslation form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CompanyTranslationForm extends BaseCompanyTranslationForm
{
  public function configure()
  {

      $this->validatorSchema['title'] = new sfValidatorString(
        array('max_length'=>255, 'min_length'=>2, 'required' => true, 'trim' => true ),
        array(
          'required' => 'The field is mandatory',
          'max_length' => 'The field cannot contain more than %max_length% characters.'
      ));


        $this->widgetSchema->setLabels(array(
            'title' => 'Place Name',
        ));
        
        $this->validatorSchema->setOption('allow_extra_fields', true);
        $this->validatorSchema->setOption('filter_extra_fields', true);
        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('form');
      
        $this->useFields(array('title'));
      

  }
}
