<?php

class api22CompanyMobileForm extends CompanyForm {

    public function configure() {
      
        $this->useFields(array(
            //'title',
            'phone',
            'classification_id'
        ));
       
        $this->validatorSchema['title'] = new sfValidatorString(
                array('min_length'=>2, 'max_length'=>255, 'required' => true, 'trim' => true ),
                array(
                        'required' => 'The field is mandatory',
                        'max_length' => 'The field cannot contain more than %max_length% characters.'
                ));
        
        $this->validatorSchema ['phone'] = new sfValidatorAnd ( array (new sfValidatorString ( array ('required' => false, 'min_length' => 3, 'max_length' => 15, 'trim' => true ),
                array (
                        'min_length' => 'Invalid Phone Number',
                        'max_length' => 'Invalid Phone Number' ) ),
                new sfValidatorRegex ( array ('pattern' => '/^[0-9]([0-9]+)$/' ,
                        'required'=>false),
                        array ('invalid' => 'Invalid phone number. The correct format to use is 023456789 or for mobile phones 0888888888. Add only the local area code for landlines. Only add digits – any other characters or spaces between characters are not allowed.' ) ) ),
                array ('required' => false ),
                array ('required' => 'The field is mandatory', 'invalid' => 'Invalid Phone Number' ) );
               
        // $this->widgetSchema['address'] = new sfWidgetFormInput();

        // $this->validatorSchema['address'] = new sfValidatorString(array(
        //     'max_length' => 255,
        //     'min_length' => 2,
        //     'required' => true,
        //     'trim' => true
        // ), array(
        //     'required' => 'The field is mandatory',
        //     'max_length' => 'The field cannot contain more than %max_length% characters.'
        // ));

        // $this->widgetSchema['location'] = new sfWidgetFormInput();
        // $this->validatorSchema['location'] = new sfValidatorString(array(
        //     'min_length' => 2,
        //     'max_length' => 255,
        //     'required' => true,
        //     'trim' => true
        // ), array(
        //     'required' => 'City is mandatory',
        //     'max_length' => 'The field cannot contain more than %max_length% characters.'
        // ));

        $this->validatorSchema->setOption('allow_extra_fields', true);
        $this->validatorSchema->setOption('filter_extra_fields', true);

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('form');
    }

}
