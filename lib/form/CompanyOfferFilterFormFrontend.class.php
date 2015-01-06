<?php
class CompanyOfferFilterFormFrontend extends BaseForm {

	public function configure()
	{
		$i18n = sfContext::getInstance()->getI18N();
		//$culture = sfContext::getInstance()->getUser()->getCulture();
		$choices = $this->getOption('choices');
		$orderDefault = $this->getOption('orderDefault');
		$this->setWidget('city_id', new sfWidgetFormChoice(array(
				'choices' => $choices['city'],
                                'renderer_class' => 'sfWidgetFormChoiceUnordered'
		),array('default' => $choices['defaults']['city'])));
                
		$this->setValidator('city_id', new sfValidatorChoice(array(
				'required' => false,
				'choices' => $choices['city']
		)));
		$this->setDefault('city_id','sofia');
		$this->setWidget('sector_id', new sfWidgetFormChoice(array(
				'choices' => $choices['sector'],
				'renderer_class' => 'sfWidgetFormChoiceUnordered'
		),array('default' => $choices['defaults']['sector'])));

		$this->setValidator('sector_id', new sfValidatorChoice(array(
				'required' => false,
				'choices' => $choices['sector']
		)));		

		$choices = array('1' => 'Discount low to high', '3' => 'Latest', '2' => 'Discount high to low', '4' => 'Expiring soon');//, '5' => 'Most popular');

		$this->setWidget('order', new sfWidgetFormSelectRadio(array(
				'choices' => $choices,
				'label_separator' => '',
                                'class' => 'sorting_wrap',	
                                'formatter' => array($this, 'radioFormatterCallback')
                             
		)));
		$this->setDefault('order', ($orderDefault ? $orderDefault : '3'));
		$this->setValidator('order', new sfValidatorChoice ( array(
				'choices' =>array_keys($choices),
				'required' => true
                                
		)));
		
		$this->widgetSchema->setLabels(array(
				'sector_id' => 'Select Sector',
				'city_id' =>'Select Locations',
				'order' => 'Sort by:'
		));
		//$this->widgetSchema->getFormFormatter()->setTranslationCatalogue('form');
	}

        public function radioFormatterCallback($widget, $inputs)
            {
              $rows = array();
              foreach ($inputs as $input)
              {
                $rows[] = $widget->renderContentTag('li', $input['input'].$this->getOption('label_separator').$input['label']);
              }
              return !$rows ? 
                '' : 
                $widget->renderContentTag('ul', implode($widget->getOption('separator'), $rows), array('class' => $widget->getOption('class')));
            }
            
        public function selectFormatterCallback($widget, $inputs)
            {
              $rows = array();
              foreach ($inputs as $input)
              {
                $rows[] = $widget->renderContentTag('li', $input['input'].$this->getOption('label_separator').$input['label']);
              }
              return !$rows ? 
                '' : 
                $widget->renderContentTag('ul', implode($widget->getOption('separator'), $rows), array('class' => $widget->getOption('class')));
            }     
        
}
?>