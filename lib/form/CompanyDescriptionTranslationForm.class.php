<?php

/**
 * CompanyTranslation form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CompanyDescriptionTranslationForm extends BaseCompanyTranslationForm
{
  public function configure()
  {
      unset(
              $this['title']
         );
      $this->widgetSchema->setNameFormat('description_translation[%s]');

      $this->widgetSchema->setNameFormat('description_translation[%s]');
      
            $this->setWidgets(array(
                'content' => new sfWidgetFormTextareaTinyMCECustom(array(
                'width' => 580, 
                'height' => 300, 
                'theme' => 'advanced'
            ), array('class' => 'tinyMCE')),
                
          'description' => new sfWidgetFormTextarea ( array (), array ('maxlength' => 500 ) )
                 
                 
        ));


        $this->widgetSchema->setLabels(array(
            'description' => 'Description',
            'content' => 'Detailed Description',
        ));

        $this->setValidators(array(
            'content' => new sfValidatorString ( array (
                'required' => false, 
                'min_length' => 30, 
                'max_length' => 20000 , 
                'trim' => true 
                ) , array (
                    'min_length' => 'Description must contain at least %min_length% characters', 
                    'max_length' => 'The description cannot contain more than %max_length% characters.' 
                )),
            'description' => new sfValidatorString(array(
                'required' => false, 
                'min_length' => 30, 
                'max_length' => 10000
            ), array(
                'min_length' => 'Description must contain at least %min_length% characters', 
                'max_length' => 'The description cannot contain more than %max_length% characters.'
            )),
        ));
        $this->validatorSchema->setOption('allow_extra_fields', true);
        $this->validatorSchema->setOption('filter_extra_fields', true);
        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('form');
      
      
      
  }
}
