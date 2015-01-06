<?php

/**
 * Newsletter form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class NewsletterForm extends BaseNewsletterForm {
    public function configure() {
        unset($this['created_at'], $this['updated_at']);
        
       

        $choices = array('Развлекателни бюлетини' => 'Развлекателни бюлетини', 'Бизнес бюлетини' => 'Бизнес бюлетини', 'Известия за игри и промоции' => 'Известия за игри и промоции', 'Community newsletters' => 'Community newsletters', 'Business newsletters' => 'Business newsletters', 'Games and promotions' => 'Games and promotions', 'Newsletter de comunitate' => 'Newsletter de comunitate', 'Newsletter business' => 'Newsletter business', 'Jocuri si promotii' => 'Jocuri si promotii');
        $this->widgetSchema['user_group'] = new sfWidgetFormChoice(array('choices' => $choices));
        $this->validatorSchema['user_group'] = new sfValidatorChoice(array('choices' => array_keys($choices)));

        $langs = getlokalPartner::getEmbeddedLanguages();
        $partner_id = getlokalPartner::getInstance();
        $this->embedI18n($langs);


        $this->widgetSchema->setLabel(
                'mailchimp_group', 'Mailchimp group name'
        );

        $this->widgetSchema->setHelp('mailchimp_group', 'Use prefix from "User group" field. Ex.: "user_testgroup", where user is the user group name');

        $this->useFields(array_merge(array('user_group', 'mailchimp_group', 'country_id'), $langs, array('is_active')));
    }
}
