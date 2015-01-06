<?php
function breadcrumb($links, $options = array())
{


	
  if (isset($options['class']) && strtolower(trim($options['class'])) != 'breadcrumb')
  {
    $options['class'] = 'path' . trim($options['class']);
  }
  else
  {
    $options['class'] = 'path';
  }
  $sep = isset($options['sep']) ? $options['sep'] : ' » '; //»&gt;
  $html = link_to(__('Home', null, 'user'), '@homepage');
  foreach ($links as $link)
  {
    if (is_string($link))
    {
      $html .= $sep . $link;
    }
    elseif (is_array($link))
    {
    
				
				$html .= $sep . link_to($link[0], url_for2($link[1][0],$link[1][1]));
			
      
    }
  }
  return content_tag('div', $html, $options);
}