<?php

/**
 * Lists form.
 *
 * @package    getLokal
 * @subpackage form
 * @author     Get Lokal
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class FacebookGame2Form extends sfForm
{
    public function configure() {
        $i18n = sfContext::getInstance()->getI18N();

        $this->widgetSchema['location_id'] = new sfWidgetFormDoctrineJQueryAutocompleter(array(
            'model' => 'City', 
            'method' =>'getLocation',                 
            'url' => sfContext::getInstance()->getController()->genUrl(array('module' => 'user', 'action' => 'getCitiesAutocomplete', 'route' => 'default')),          
            'config' => ' {
                scrollHeight: 250,
                autoFill: false,
                cacheLength: 1,
                delay: 1,
                max: 10,
                minChars:0
            }'
        ));

        $this->widgetSchema['place_id'] = new sfWidgetFormDoctrineChoice(array('model' => 'CompanyPage', 'multiple' => true));

        $this->setValidators(array(
            'location_id' => new sfValidatorInteger(array('required' => true), array('required'=>'The field is mandatory')),
            'place_id'	=> new sfValidatorDoctrineChoice(array('required' => false, 'model' => 'CompanyPage', 'multiple' => true), array('required'=>'The field is mandatory')),
        ));

        $this->setDefault('location_id', sfContext::getInstance()->getUser()->getCity()->getId());

        $this->widgetSchema->setNameFormat('facebookGame2[%s]');

	$this->widgetSchema->setLabels(array('location_id' => 'City/Town', 'place_id' => 'Venue name'));
        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('form');
    }
}