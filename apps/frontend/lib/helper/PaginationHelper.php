<?php
 
function pager_navigation($pager, $uri)
{	
  $navigation = '';
 
  if ($pager->haveToPaginate())
  {  
  	$navigation .= '<div class="wrapper-pager"><div class="ajaxPager paging paging-number">';
  	$uri .= (preg_match('/\?/', $uri) ? '&' : '?').'page=';

  	$uri2 = sfContext::getInstance()->getRequest()->isSecure()? 'https://':'http://';
  	$uri2 .= sfContext::getInstance()->getRequest()->getHost();
 
    
    
    // First and previous page
    
      $navigation .= '<div class="pagerLeft">';
      if ($pager->getPage() != 1)
      {
      	slot('prev', $uri2.$uri.$pager->getPreviousPage());
        $navigation .= link_to('<i class="fa fa-angle-double-left"></i>', $uri.$pager->getPreviousPage(), array('rel'=>'prev'));
      }
    	$navigation .= '</div>';
   
 	
    $navigation .= '<div class="pagerCenter">';

    if ($pager->getPage() > 2 && $pager->getLastPage()>3){
      $navigation .= link_to('1', $uri.$pager->getFirstPage());
    }

    if ($pager->getPage() > 3 && $pager->getLastPage()>4){
      $navigation .=' ... ';                        
    }
    
    // Pages one by one
    $links = array();
    $options=array();
    foreach ($pager->getLinks(3) as $page)
    { 
    	$options=array();
    	
    	if ($pager->getPage() - 1 == $page)
    	{    		
    	  $options = array('rel'=>'prev');
    	}elseif ($pager->getPage() + 1 == $page)
    	{    		
    	  $options = array('rel'=>'next');
    	}elseif($pager->getPage() == $page) {
    		$options = array('class'=>'current');
    	}
      $links[] = link_to($page, $uri.$page, $options);
    }
    $navigation .= join('  ', $links);

    if ($pager->getPage() < $pager->getLastPage()-3){ 
      $navigation .=' ... ';                            
    }
	if ($pager->getPage() < $pager->getLastPage()-1 && $pager->getLastPage()>3){
      $navigation .= link_to($pager->getLastPage(), $uri.$pager->getLastPage());
	}
    
    $navigation .= '</div>';
    
    // Next and last page
   
      $navigation .= '<div class="pagerRight">';
      if ($pager->getPage() != $pager->getLastPage())
      {
      	slot('next',  $uri2.$uri.$pager->getNextPage(),true);
        $navigation .= ' '.link_to('<i class="fa fa-angle-double-right"></i>', $uri.$pager->getNextPage(), array('rel'=>'next'));
      }
      $navigation .= '</div>';
    
 	$navigation .= '</div></div>';
  }
  
  return $navigation;
}

function ajax_pager_navigation($pager, $uri,$is_component = 0)
{
	$navigation = '';

	if ($pager->haveToPaginate())
	{
		$navigation .= '<div class="wrapper-pager"><div class="paging paging-number">';
		//$uri .= (preg_match('/\?/', $uri) ? '&' : '?').'page=';
		$uri = preg_replace("/[\?|\&]page=[0-9]+/","",$uri);

		$uri2 = sfContext::getInstance()->getRequest()->isSecure()? 'https://':'http://';
		$uri2 .= sfContext::getInstance()->getRequest()->getHost();



		// First and previous page

		$navigation .= '<div class="pagerLeft">';
		if ($pager->getPage() != 1)
		{
			slot('prev', $uri2.$uri.$pager->getPreviousPage());
			$navigation .= "<a href='javascript:void(0)' rel='prev' onclick='loadPage(\"$uri\",".$pager->getPreviousPage().",$is_component)'>".__('Previous',null,'pagination')."</a>";
		}
		$navigation .= '</div>';
		 

		$navigation .= '<div class="pagerCenter">';

		if ($pager->getPage() > 2 && $pager->getLastPage()>3){
			$navigation .= "<a href='javascript:void(0)' onclick='loadPage(\"$uri\",".$pager->getFirstPage().",$is_component)'>1</a>";
		}

		if ($pager->getPage() > 3 && $pager->getLastPage()>4){
			$navigation .=' ... ';
		}
		// Pages one by one
		$links = array();
		$options=array();
		foreach ($pager->getLinks(3) as $page)
		{
			$rel = "";			 
			if ($pager->getPage() - 1 == $page)
			{
				$rel='prev';
			}elseif ($pager->getPage() + 1 == $page)
			{
				$rel='next';
			}
			
			$onclick = "";
			if($page == $pager->getPage()){
				$links[] = "$page";
			}else{
				$links[] = "<a href='javascript:void(0)' rel='$rel' onclick='loadPage(\"$uri\",$page,$is_component)' >$page</a>";
			}
// 			$links[] = link_to_unless($page == $pager->getPage(), $page, "javascript:void(0)", $options);
		}
		$navigation .= join('  ', $links);

		if ($pager->getPage() < $pager->getLastPage()-3){
			$navigation .=' ... ';
		}
		if ($pager->getPage() < $pager->getLastPage()-1 && $pager->getLastPage()>3){
// 			$navigation .= link_to($pager->getLastPage(), "#",array('onclick'=>"loadPage('$container',$pager->getLastPage())"));
			$navigation .="<a href='javascript:void(0)' onclick='loadPage(\"$uri\",".$pager->getLastPage().",$is_component)'>".$pager->getLastPage()."</a>";
		}

		$navigation .= '</div>';

		// Next and last page
		 
		$navigation .= '<div class="pagerRight">';
		if ($pager->getPage() != $pager->getLastPage())
		{
			slot('next',  $uri2.$uri.$pager->getNextPage(),true);
// 			$navigation .= ' '.link_to(''.__('Next',null,'pagination').'', "#", array('rel'=>'next',"onclick"=>"loadPage('$container',$pager->getNextPage())"));
			$navigation .= " <a href='javascript:void(0)' rel='next' onclick='loadPage(\"$uri\",".$pager->getNextPage().",$is_component)'>".__('Next',null,'pagination')."</a>";
		}
		$navigation .= '</div>';

		$navigation .= '</div></div>';
	}

	return $navigation;
}