<?php

class TextMessageForm extends BaseForm
{

    public function configure()
    {
        $this->setWidget('number', new sfWidgetFormInput(array(), array(
            'placeholder' => '+407XXXXXXXX',
            'label' => false,
            'id' => 'lpage_link'
        )));
    }

    /**
     * Send Sms through nexmo.
     * @return [type] [description]
     */
    public function save()
    {
        $values = $this->getTaintedValues();
        $number = trim($values['number']);
        if (empty($number)) {
            return;
        }
        $nm = new NexmoMessage(sfConfig::get('app_nexmo_key'), sfConfig::get('app_nexmo_secret'));
        $result = $nm->sendText($number, 'Getlokal', 'http://getlok.al/applokal --> Getlokal: fii un lokalnic informat cu aplicatia care nu te lasa sa stai in casa.');
    }

}
