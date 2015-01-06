<?php
function link_to_public_profile($profile, $options = array())
{
 if($profile instanceOf sfGuardUser)
      $profile = $profile->getUserProfile();

  return link_to($profile, '@user_page?username='.$profile->getSfGuardUser()->getUsername(), $options);
}

function link_to_company($company, $options = array(), $image_options = '')
{
   if (!isset($options['title']))
   {
      //$options['title'] = sprintf(__('Company %s', null, 'search'),  $company->getCompanyTitle());
       $options['title'] = $company->getCompanyTitle();
   }

   if(isset($options['image_size']) && $options['image_size'] !== false)
   {
     return link_to(image_tag($company->getThumb($options['image_size']), $image_options), $company->getUri(ESC_RAW), $options);
   }
   
  return link_to($options['title'], $company->getUri(ESC_RAW), $options);
}

function link_to_company_with_culture_or_title($company, $culture=null, $title=null)
{
    if(!isset($culture)){
        
        $culture=  sfContext::getInstance()->getUser()->getCulture();
    }
   if (!isset($title))
   {
      //$options['title'] = sprintf(__('Company %s', null, 'search'),  $company->getCompanyTitle());
       $title  = $company->getCompanyTitleByCulture($culture);
   }

  return link_to($title, $company->getUri(ESC_RAW));
}



function include_page_title($returnTitleOnly = false)
{
  $title = sfContext::getInstance()->getResponse()->getTitle();
  $no_location = sfContext::getInstance()->getRequest()->getParameter('no_location', false);
  $page = sfContext::getInstance()->getRequest()->getParameter('page', false);
  $street = sfContext::getInstance()->getRequest()->getParameter('street', false);
  $classification = sfContext::getInstance()->getRequest()->getParameter('classification', false);
  //$i18n  = sfContext::getInstance()->getI18N();
  if (!$title)
  {
    if ($no_location)
    {
      $pagetitle = __('Going Out, Leisure, Health and Beauty, Shopping', null, 'pagetitle');
    }
    else
    { 	
    	if ((sfContext::getInstance()->getRequest()->getParameter('county', false) || getlokalPartner::getInstanceDomain() == 78) && !sfContext::getInstance()->getRequest()->getParameter('city', false)) {
    		$county = sfContext::getInstance()->getUser()->getCounty();
    		$county = sfContext::getInstance()->getRequest()->getParameter('location', $county);
    		$pagetitle = $county->getLocation() . '-'.__('Going Out, Leisure, Health and Beauty, Shopping', null, 'pagetitle');
    	}
    	else {
    		$city = sfContext::getInstance()->getRequest()->getParameter('location', sfContext::getInstance()->getUser()->getCity());
    		$pagetitle = $city->getLocation() . '-'.__('Going Out, Leisure, Health and Beauty, Shopping', null, 'pagetitle');
    	}
    }
  }
  elseif ($no_location)
  {
    $pagetitle = __($title, null, 'pagetitle');
  }
  else
  {
    $city = sfContext::getInstance()->getRequest()->getParameter('location', sfContext::getInstance()->getUser()->getCity());
    $pagetitle = __($title, null, 'pagetitle');

    if ($city && $title)
    {
      if($street)
      {
        $pagetitle = sprintf(__('%s - %s, %s', null, 'pagetitle'), $pagetitle, $street, $city->getLocation());
      }
      else
      {
        $county = sfContext::getInstance()->getUser()->getCounty();
        if ((sfContext::getInstance()->getRequest()->getParameter('county', false) || getlokalPartner::getInstanceDomain() == 78) && !(sfContext::getInstance()->getRequest()->getParameter('city', false))) {
            $pagetitle = sprintf(__('%s in %s', null, 'pagetitle'), $pagetitle, $county->getLocation());
        }
        else {
            $pagetitle = sprintf(__('%s in %s', null, 'pagetitle'), $pagetitle, $city->getDisplayCity());
        }
      }

      sfContext::getInstance()->getResponse()->setTitle($pagetitle);
    }
  }

  if ($page && $page != 1){
    if ($returnTitleOnly) {
      return $pagetitle;
    }
    else
    {
      echo content_tag('title', $pagetitle. ' | getlokal - ' . __('page') .' '.$page)."\n";
    }
  }
  else
  {
    if ($returnTitleOnly) {
      return $pagetitle;
    }
    elseif ($classification){
      echo content_tag('title', $pagetitle.' | '.$classification.' - getlokal')."\n";
    }
    else
    {
    	echo content_tag('title', $pagetitle.' | getlokal')."\n";
    }
  }
}
function getSendEmailLink($company)
{
    $s = sprintf(__('send email to %s', null, 'company'), $company->getCompanyTitle());
      $options = array('title' => $s, 'alt' => $s,'class'=> 'e-mail', 'id'=>'send_mail_company');
      return link_to('<i class="fa fa-envelope"></i>'.__('Send Email', null, 'company'), 'company/sendMailTo?slug=' . $company->getSlug(), $options);
}

function getCompanyWebSite($company)
{

  $url = $company->getWebsiteUrl();
  if (!strpos($url, '://'))
  {
    $url = 'http://' . $url;
  }
  $title =  sprintf(__('Website of %s: %s'), $company->getCompanyTitle(), $url);
  //return link_to(__('Website'), 'company/redirectTo?slug=' . $company->getSlug(), array('title' => $title, 'alt' => $title, 'popup' => true, 'class'=> 'web'));
  return '<a target="_blank" title = "'.$title.'" alt = "'.$title.'" href="'.$url.'" ><i class="fa fa-globe"></i>'.__('Website').'</a>';
  
}


function getCompanyFacebook($company)
{

	$url = $company->getFacebookUrl ();
	
	if (! strpos ( $url, '://' )) {
		$url = 'http://' . $url;
	}
  	$title =  sprintf(__('Facebook page of %s'), $company->getCompanyTitle());

  	//return link_to(__('Facebook'), 'company/redirectToFacebook?slug=' . $company->getSlug(), array('title' => $title, 'alt' => $title, 'popup' => true, 'class'=> 'facebook'));
  	return '<a target="_blank" title = "'.$title.'" alt = "'.$title.'" class="link-facebook" href="'.$url.'" ><i class="fa fa-facebook fa-2x"></i></a></a>';
  	
}
function getCompanyTwitter($company)
{
	$url = $company->getTwitterUrl ();
	
	if (! strpos ( $url, '://' )) {
		$url = 'http://' . $url;
	}
  	$title =  sprintf(__('Twitter page of %s'), $company->getCompanyTitle());

  	//return link_to(__('Twitter'), 'company/redirectToTwitter?slug=' . $company->getSlug(), array('title' => $title, 'alt' => $title, 'popup' => true, 'class'=> 'twitter'));
  	return '<a target="_blank" title = "'.$title.'" alt = "'.$title.'" class="link-twitter" href="'.$url.'" ><i class="fa fa-twitter fa-2x"></i></a>';
  	
}
function getCompanyFoursquare($company)
{
	$url = $company->getFoursquareUrl ();
	
	if (! strpos ( $url, '://' )) {
		$url = 'http://' . $url;
	}
  	$title =  sprintf(__('Foursquare page of %s'), $company->getCompanyTitle());

  	//return link_to(__('Foursquare'), 'company/redirectToFoursquare?slug=' . $company->getSlug(), array('title' => $title, 'alt' => $title, 'popup' => true, 'class'=> 'foursquare'));
  	return '<a target="_blank" title = "'.$title.'" alt = "'.$title.'" class="link-foursquare"  href="'.$url.'" ><i class="fa fa-foursquare fa-2x"></i></a>';
  	
}
function getCompanyGooglePlus($company)
{
	$url = $company->getGoogleplusUrl ();
	
	if (! strpos ( $url, '://' )) {
		$url = 'http://' . $url;
	}
    $title =  sprintf(__('Google+ page of %s'), $company->getCompanyTitle());

  	//return link_to(__('Google+'), 'company/redirectToGooglePlus?slug=' . $company->getSlug(), array('title' => $title, 'alt' => $title, 'popup' => true, 'class'=> 'gplus'));
  	return '<a target="_blank" title = "'.$title.'" alt = "'.$title.'" class="link-googleplus"  href="'.$url.'" ><i class="fa fa-google-plus fa-2x"></i></a>';// class="gplus"
  
}
function getCompanyYellowPagesRS($company)
{
	$url = $company->getCompanyDetailSr()->getSrUrl();
	
	if (! strpos ( $url, '://' )) {
		$url = 'http://' . $url;
	}
	$title =  sprintf(__('%s Yellow Pages profile',null,'company'), $company->getCompanyTitle());
	//return link_to(__('yellowpages.rs'), 'company/redirectToYellowPagesRS?slug=' . $company->getSlug(), array('title' => $title, 'alt' => $title, 'popup' => true, 'class'=> 'goldenpages'));
	return '<a target="_blank" title = "'.$title.'" alt = "'.$title.'" class="goldenpages"  href="'.$url.'" >'.__('yellowpages.rs').'</a>';
	
}
function format_company_title($string)
{
  $output="";
  $remove = array(',', ';',':', '"', '„', '”', '“', '(', ')', '№','&ndash;');
    $seperator = ' ';
   /*$smalls = array("and","with","for","a",
"за", "от","на", "и", "до", "в", "във", "с", "със", "по",
"of", "from", "to", "in", "or", "the", "at","on", "off",
"și","a","ai", "ale", "alor", "de", "dacă", "la", "de", "în", "si", "daca", "in"
  );
  $caps = array(
"СОУ", "ЧСОУ", "ЧОУ", "ДКЦ", "БГ", "ОДЗ", "МБАЛ",  "МЦ", "ПГ", "ЦДГ", "МДКЦ",
"SOU", "OU", "BG","DKTS", "ODZ", "MBAL",  "MTZ", "PG", "TZDG", "MDKTZ",
"SRL", "SA", "SC", "ONG");
  $new_str = str_replace($remove, $seperator, $string);
  $keywords = explode(' ',$new_str);
  foreach ($keywords as $keyword)
  {
    if (in_array($keyword, $smalls)) {
         $keyword = mb_convert_case ( $keyword , MB_CASE_LOWER, "UTF-8" );
    }elseif (in_array(mb_convert_case ( $keyword , MB_CASE_UPPER, "UTF-8" ), $caps))
    {

        $keyword = mb_convert_case ( $keyword , MB_CASE_UPPER, "UTF-8" );
    }else {
    $keyword = mb_convert_case ( $keyword , MB_CASE_TITLE, "UTF-8" );
    }

    $output .= ' '. $keyword;
  }
  $to_replace =array('Основно Училище','Целодневна Детска Градина','Целодневна Детска Градинa','Обединено Детско Заведение',
  'Средно Общообразователно Училище','Професионална Гимназия По','Професионална Гимназия','Медицински Център',
  'Многопрофилна Болница за Активно Лечение','Медицински Диагностично-консултативен Център','Диагностично-консултативен Център',
  'Медицински ДКЦ');

  $replace_to=array('ОУ', 'ЦДГ','ЦДГ','ОДЗ','СОУ','ПГ по','ПГ','МЦ','МБАЛ','МДКЦ','ДКЦ','МДКЦ');
  $output =  str_replace($to_replace, $replace_to, $output);
  */
  $output = str_replace($remove, $seperator, $string);
  return trim($output);
}

 function simple_format_text_review($text, $options = array())
{
  $css = (isset($options['class'])) ? ' class="'.$options['class'].'"' : '';

  $text = sfToolkit::pregtr($text, array("/(\r\n|\r)/"        => "\n",               // lets make them newlines crossplatform
                                         "/\n{2,}/"           => "</p><p$css>"));    // turn two and more newlines into paragraph

  // turn single newline into <br/>
  $text = str_replace("\n", "\n<br />", $text);
  return '<p'.$css.' itemprop="description">'.$text.'</p>'; // wrap the first and last line in paragraphs before we're done
}

 function in_array_r($needle, $haystack, $strict = false) {
    foreach ( $haystack as $item ) {
      if (($strict ? $item === $needle : $item == $needle) || (is_array ( $item ) && in_array_r ( $needle, $item, $strict ))) {
        return true;
      }
    }

    return false;
  }
function link_fb_company($company, $options = array())
{

  return link_to($company->getCompanyTitle(), $company->getUri('ESC_RAW'), $options);

}
?>
