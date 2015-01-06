<?php

class sendInviteFBForm extends sfForm {
    public function configure() {
        $this->i18n = sfContext::getInstance()->getI18N();

        $response = $this->getOption('response');

        //sfContext::getInstance()->getUser()->setAttribute('friend_list', $response->data);

        $friendList = array();
        foreach ($response->data as $friend) {
            $friendList[$friend->id] = $friend->name;
        }

        //http://stackoverflow.com/questions/3861971/sfvalidatorchoice-not-working-on-multiple-selection-element
        $this->widgetSchema['friend_lists'] = new sfWidgetFormChoice(array('choices' => $friendList, 'multiple' => true, 'expanded' => true, 'renderer_options' => array('formatter' => array('sendInviteFBForm', 'MyChoiseFormatter'))));

        //$this->widgetSchema['body'] = new sfWidgetFormTextarea();

        $this->validatorSchema ['friend_lists'] = new sfValidatorChoice(array('required' => true, 'multiple' => true, 'choices' => array_keys($friendList)), array('required' => 'The field is mandatory'));
        //$this->validatorSchema['body'] = new sfValidatorString(array('min_length' => 1, 'trim' => true), array('required' => 'The field is mandatory')/*, array('min_length' => 'Body is too short')*/ );

        $this->widgetSchema->setLabels(array('friend_lists' => $this->i18n->__('Your friends', null, 'user'), /*'body' => 'Text'*/));

        //$bodyText = $this->getOption('body');
        //$this->setDefault('body', $bodyText);

        $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('form');
        $this->widgetSchema->setNameFormat('sendInviteFB[%s]');
    }

    public static function MyChoiseFormatter($widget, $inputs) {
        //$param = $widget->getParent()->getFields()['friend_lists']->getOptions();
        //var_dump($param['choices']);
        //exit;

        //$choices = $widget->getChoices();

        $result = '<ul class="checkbox_list">';

        foreach ($inputs as $input) {
            if (preg_match("/value=\"(\d+)\"/ui", $input['input'], $matches) && $matches) {
                $fbId = $matches[1];
                $image = '<img src="https://graph.facebook.com/' . $fbId . '/picture?type=square" width="31" height="31" />';
            }

            $labelTmp = $input['label'];
            $labelTmp = explode('">', $labelTmp);
            $label = $labelTmp[0] . "\"> " . $image . " " . $labelTmp[1];
            
            $result .= '<li>' . $input ['input'] . $label  . '</li>';
        }

        $result .= '</ul>';

        return $result;
    }
}