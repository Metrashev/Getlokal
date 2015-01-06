<?php

class CommunicationForm extends UserSettingForm {
    public function configure() {
        $this->useFields(array('allow_contact', 'allow_newsletter', 'allow_b_cmc', 'allow_promo'));

        $this->validatorSchema->setOption('allow_extra_fields', true);
        $this->validatorSchema->setOption('filter_extra_fields', false);

        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('form');
        $this->widgetSchema->setNameFormat('communication_settings[%s]');
    }
}