<?php

/**
 * Video form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class VideoForm extends BaseVideoForm {

    /**
     * @see ImageForm
     */
    public function configure() {

        $this->useFields(array('filename', 'caption', 'description'));
        if ($this->getObject()->isNew()) {

            $this->widgetSchema['filename'] = new sfWidgetFormInputFile();
            $this->validatorSchema['filename'] = new sfValidatorFile(
              array(
                'required' => true,
                'max_size' => '5971520'), 
              array(
                'required' => 'The field is mandatory')
            );
        }

        $this->setValidator('caption', new sfValidatorAnd(array(
            new sfValidatorString(
              array(
                'required' => true,
                'min_length' => 8,
                'max_length' => 99), 
              array(
                'min_length' => 'Video Title must contain at least %min_length% characters',
                'max_length' => 'The video title cannot contain more than %max_length% characters.')
            ),
            new sfValidatorBlacklist(
              array(
                'case_sensitive' => false,
                'required' => true,
                'forbidden_values' => array()), 
              array(
                 'forbidden' => 'Description "%value%" contains forbidden words'))
          ), 
          array('required' => true), array('required' => 'The field is mandatory')));

        $this->widgetSchema['description'] = new sfWidgetFormTextarea(array(), array('maxlength' => 240));
        $this->setValidator('description', new sfValidatorString(
          array(
            'required' => true, 
            'min_length' => 20, 
            'max_length' => 240), 
          array(
            'min_length' => 'Description must contain at least %min_length% characters',
            'max_length' => 'The description cannot contain more than %max_length% characters.',
            'required' => 'The field is mandatory')
        ));




        $this->widgetSchema->setLabels(
          array(
            'caption' => 'Caption ',
            'description' => 'Description',
            'filename' => 'Select file')
        );

        $this->validatorSchema->setOption('allow_extra_fields', true);
        $this->validatorSchema->setOption('filter_extra_fields', false);
        $this->widgetSchema->setNameFormat('video[%s]');
        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('form');
    }

}
