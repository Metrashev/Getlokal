<?php
class sfWidgetFormChoiceUnordered extends sfWidgetFormChoiceBase
{	
    public function render($name, $value = null, $attributes = array(), $errors = array())
    {  	
        $result = '<select name="'.$name.'" id="'.$name.'">';
        $choices = $this->getChoices();
        foreach ($choices as $choice) {
       //     var_dump($choices);
        	if($attributes['default'] == array_search($choice, $choices)) {
        		if(isset($choice['sec'])) {
                            if(isset($choice['count']) && $choice['count']!=NULL && $choice['count']!= '') {
        			$result .= '<option data-group="'.$choice['cont'].'" data-sectorId="'.$choice['sec'].'" class="category_'.$choice['sec'].'" value="' . array_search($choice, $choices) . '" selected="selected">' . $choice['cont'].'  ('.$choice['count'].')'.'</option>';
                            }
                            else {
                                $result .= '<option data-group="'.$choice['cont'].'" class="category_'.$choice['sec'].'" value="' . array_search($choice, $choices) . '" selected="selected">' . $choice['cont'].'</option>';
                            }
        		}
        		else {
        			$result .= '<option data-group="'.$choice['id'].'" class="category_" value="' . array_search($choice, $choices) . '" selected="selected">' . $choice['value'] .'</option>';
        		}
        	}
        	else { 
        		if(isset($choice['sec'])) {
                           if(isset($choice['count']) && $choice['count']!=NULL && $choice['count']!= '') {
                               $result .= '<option data-title="'.$choice['cont'].'" data-sectorId="'.$choice['sec'].'" class="category_'.$choice['sec'].'" value="' .array_search($choice, $choices). '">' . $choice['cont'] . '  ('.$choice['count'].')' . '</option>';//choice[url][name]    choice[url][class]
                           }
                           else {
                               $result .= '<option data-title="'.$choice['cont'].'" data-sectorId="'.$choice['sec'].'" class="category_'.$choice['sec'].'" value="' .array_search($choice, $choices). '">' . $choice['cont'] . '</option>';//choice[url][name]    choice[url][class]
                           }
        		}
        		
                       elseif(isset($choice['id'])) {
        			$result .= '<option data-filter-value="'.$choice['id'].'" data-group="'.$choice['id'].'"  value="' . array_search($choice, $choices) . '">' . $choice['value'] . '</option>';//choice[url][name]    choice[url][class]
        		}
                        
                        else {
        			$result .= '<option data-title="all sectors" data-sectorId="all-sectors" data-cityId="0" class="category_" value="' . array_search($choice, $choices) . '">' . $choice['cont'] . '</option>';//choice[url][name]    choice[url][class]
        		}
                        
        	}
                
                
        }
       
        return $result .= '</select>';
    }

}
