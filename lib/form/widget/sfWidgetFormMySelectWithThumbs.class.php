<?php
class sfWidgetFormMySelectWithThumbs extends sfWidgetFormSelectCheckbox {

	public function configure($options = array(), $arguments = array()) {
		parent::configure($options, $arguments);
	}
	
	protected function formatChoices($name, $value, $choices, $attributes)
	{
		$images = array('1' => 'free-parking', '2' => 'pay-parking', '3' => 'pay-with-card', '4' => 'private-party', '5' => 'weddings', '6' => 'self-service',
				'7' => 'place-out', '8' => 'place-in', '9' => 'free-wi-fi', '10' => 'delivery', '11' => 'invalid-place', '12' => 'child-place');
		$inputs = array();
		foreach ($choices as $key => $option)
		{
			$baseAttributes = array(
					'name'  => $name,
					'type'  => 'checkbox',
					'value' => self::escapeOnce($key),
					'id'    => $id = $this->generateId($name, self::escapeOnce($key)),
			);
			$divAttrSelected = array('class'=>'img_feature_company');
			if ((is_array($value) && in_array(strval($key), $value)) || (is_string($value) && strval($key) == strval($value)))
			{
				$baseAttributes['checked'] = 'checked';
				$divAttrSelected['class']  = $divAttrSelected['class'].' selected';
			}
			 
	
			$inputs[$id] = array(
	/*
					'input' => sprintf('%s  %s',
							$this->renderTag('input', array_merge($baseAttributes, $attributes)),
							$this->renderTag('img', array('src' => '/images/gui/rupa_icons/icon-'.$key.'.png'))
					),
	*/
					'input' => $this->renderTag('input', array_merge($baseAttributes, $attributes)),
// 					'img'	=> $this->renderContentTag('div',$this->renderTag('img', array('src' => '/images/gui/rupa_icons/icon-'.$key.'.png', 'alt'=>$option, 'title'=>$option )), $divAttrSelected),
					'img'	=> $this->renderContentTag('div',$this->renderTag('div', array('class' => "features-ppp ".$images[$key] )), $divAttrSelected),
					
			);
			if ($key==7){
				$inputs[$id]['img'] = sprintf('%s  %s', '<span class="number">0</span>', $inputs[$id]['img']);
			}elseif ($key==8){
				$inputs[$id]['img'] = sprintf('%s  %s', '<span class="number">0</span>', $inputs[$id]['img']);
			}elseif ($key==9){
				$inputs[$id]['img'] = sprintf('%s  %s', '<span class="number wifi"></span>', $inputs[$id]['img']);
			}
		}
		
	
		return call_user_func($this->getOption('formatter'), $this, $inputs);
	}
	
	public function formatter($widget, $inputs)
	{
		$rows = array();
		foreach ($inputs as $key => $input)
		{
		$baseAttributes = array();
			if ($key=='descriptions_feature_company_list_7'){
				$baseAttributes['class'] = 'outdoor_seats';
			}elseif ($key=='descriptions_feature_company_list_8'){
				$baseAttributes['class'] = 'indoor_seats';
			}elseif ($key=='descriptions_feature_company_list_9'){
				$baseAttributes['class'] = 'wifi_option';
			}
			    $rows[] = $this->renderContentTag('li', $input['input'].$input['img'],$baseAttributes);
		}
	
// 		return !$rows ? '' : $this->renderContentTag('ul', implode($this->getOption('separator'), $rows), array('class' => 'feature_icons_wrapper'));
		return !$rows ? '' : $this->renderContentTag('ul', implode($this->getOption('separator'), $rows), array('class' => 'features-body feature_icons_wrapper'));
	}

	
}