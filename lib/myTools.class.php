<?php

class myTools
{
	public static function getImageSRC($src, $alt){
		$altPictures['user'] = '/images/gui/default_user_150x150.jpg';
		$altPictures['default_tab'] = '/images/gui/default_tab.png';
		if(file_exists($src)){
			return $src;
		}else{
			return $altPictures[$alt];
		}
	}
	
	public static function companyConvertor($company, $type, $culture, $attrs = null, $title = null){
		/*
		 * TYPE: 1-home
		 * 		 2-other
		 * 		 3-search
		 * */
		$result = array();
		if($type == 1){
			$result = array(
				'user_id' => $attrs['tr_user_id'],
				'review_user_name' => $attrs['tr_u_name'],
				'review_username' => $attrs['tr_u_username'],
				'review_text' => $attrs['tr_review']
			);
		}			
		if($type == 1 || $type == 2){
			$result['id'] = $company->getId();
			$result['title'] = $company->getCompanyTitle();
			$result['is_ppp'] = $company->getActivePPPService(true);
			$result['address'] = $company->getDisplayAddress();
			$result['phone'] = $company->getPhoneFormated();
			$result['percent_rating'] = $company->getRating();
			$result['numberOfReviews'] = $company->getNumberOfReviews();
			$result['link-title'] = link_to(($company->getCompanyTitle() != '' ? $company->getCompanyTitle() : $title), $company->getUri(ESC_RAW), 'class=listing_place_img title=' . $company->getCompanyTitle() );
			
			$result['link-image'] = link_to(image_tag($company->getThumb(15), 'alt=' . $company->getCompanyTitle()),
									        $company->getUri(ESC_RAW), 'class=listing_place_img title=' . $company->getCompanyTitle() );
			//$result['link-image'] = str_ireplace('src="', 'src="http://static.getlokal.com', $result['link-image']);
			
			$result['link-classification'] = link_to($company->getClassification(),
										             $company->getClassificationUri(ESC_RAW), array('title=' . $company->getSector(), 'class' => 'category'));

			$company_event_count = $company->getEventCount();
			$result['link-events'] = $company_event_count ? link_to(__('Events'), 'company/events?slug=' . $company->getSlug() . '&city=' . $company->City->getSlug(), array('title' => $company->getCompanyTitle())) : '';
			$result['link-offers'] = $company->getAllOffers(true, false, true) ? link_to(__('Get Voucher'), 'company/showAllOffers?slug=' . $company->getSlug() . '&city=' . $company->City->getSlug(), array('title' => $company->getCompanyTitle())) : '';
			if($type != 1){
				$review_text = $company->getTopReview() ? $company->getTopReview()->getText() : false;
	
				if( is_object($company->getTopReview()) ){
					$result['review'] = $review_text;
					$result['review_text'] = $review_text;
				    $result['review_user_name'] = $review_text ? $company->getTopReview()->getUserProfile() : '';
				    $reviewImageUrl = myTools::getImageSRC($company->getTopReview()->getUserProfile()->getThumb(), 'user');
				    $result['review-user-img'] =  $review_text ? image_tag($reviewImageUrl, array('size'=>'55x55', 'alt'=>'')) : '';
				    $result['hasReviews'] = true;
				}else{
					$result['hasReviews'] = false;
				}
			}
			if($company->getAllOffers()){
				$result['link-offers'] = "/".$culture."/".$company->getCity()->getSlug()."/".$company->getSlug()."?tab=offers";
			}else{
				$result['link-offers'] = '';
			}
			if($company_event_count){
				$result['link-events'] = "/".$culture."/".$company->getCity()->getSlug()."/".$company->getSlug()."?tab=events";
			}else{
				$result['link-events'] = '';
			}			
		    $result['overlay'] = get_partial('search/item_overlay',array('company'=>$company));

		}elseif($type == 3){	
			if($company->Review['total_reviews']){
				$result = array(
						'user_id' => $company->Review['review_id'],
						'review_user_name' => $company->Review['first_name']. " " .$company->Review['last_name'],
						'review_username' => $company->Review['username'],
						'review-user-img' => '',
						'review_text' => $company->Review['text']
				);
				$reviewUserImg =  myTools::getImageSRC($company->Review['profile_image'], 'user');
				$result['review-user-img'] =  image_tag($reviewUserImg, array('size'=>'55x55', 'alt'=>''));
				$result['hasReviews'] = 1;
			}else{
				$result['hasReviews'] = 0;
			}
			$result['id'] = $company->getId();
			$result['title'] = $company->getCompanyTitle();
			$result['is_ppp'] = $company->getActivePPPService(true);
			$result['address'] = $company->getDisplayAddress();
			$result['phone'] = $company->getPhoneFormated();
			$result['percent_rating'] = $company->getRating();
			$result['numberOfReviews'] = $company->Review['total_reviews'];
			$result['link-title'] = '<a class="listing_place_img" title="'.$company->getTitle().'"	href="/'.$culture.'/'.$company->getCity()->getSlug().'/'.$company->getSlug().'">
								    	'.$company->getTitle().'
								    </a>';
			
			$image = image_tag($company->getThumb(0), 'alt=' . $company->getTitle());
			$result['link-image'] = '<a class="listing_place_img" title="'.$company->getTitle().'" 
										href="/'.$culture.'/'.$company->getCity()->getSlug().'/'.$company->getSlug().'">
								    	'.$image.'
								    </a>';
				
			$result['link-classification'] = '<a title="'.$company->Sector['title'].'" class="category" href="/'.$culture.'/'.$company->getCity()->getSlug().'/'.$company->Sector['slug'].'/'.$company->Classification['slug'].'">'.$company->Classification['title'].'</a>';
			if($company->getOfferCount()){
				$result['link-offers'] = "/".$culture."/".$company->getCity()->getSlug()."/".$company->getSlug()."?tab=offers";
			}else{
				$result['link-offers'] = '';
			}
			if($company->getEventCount()){
				$result['link-events'] = "/".$culture."/".$company->getCity()->getSlug()."/".$company->getSlug()."?tab=events";
			}else{
				$result['link-events'] = '';
			}
			$result['overlay'] = $company->getOverlay();
		}
		
		return $result;
	}
	
	public static function getPager($currentPage, $resultCount = null, $pageCount = null,$resultsPerPage = 12){
		$PagerData['pagerLeft'] = '';
		$PagerData['pagerCenter'] = '';
		$PagerData['pagerRight'] = '';
		$left = '';
		$right = '';
		if(is_null($pageCount) || $pageCount == 0){
			$pageCount = ceil($resultCount / $resultsPerPage);
		}
		if($pageCount == 0){
			return $PagerData;
		}
		if($pageCount == 1){
			$PagerData['pagerCenter'] = '<a class="current" value="1" id="page-1" href="javascript:;"><span>1</span></a>';
			return $PagerData;
		}	
		//echo $pageCount;	
		if($currentPage > 1){
			$PagerData['pagerLeft'] = '<a value="'.($currentPage-1).'" href="javascript:;" id="prev"><span><i class="fa fa-angle-double-left"></i></span></a>';
		}
		if($currentPage < $pageCount){
			$PagerData['pagerRight'] = '<a value="'.($currentPage+1).'" href="javascript:;" id="next"><span><i class="fa fa-angle-double-right"></i></span></a>';
		}
		if($currentPage == 1){
			$start = 1;
		}elseif($currentPage == $pageCount){
			$start = $pageCount-3;
		}else{
			$start = $currentPage-1;
		}			
		if($start > 1){
			$left = '<a value="1" id="page-1" href="javascript:;"><span>1</span></a>...';
		}
		if($start < 1){
			$start = 1;
		}
		$end = $start+2;
		if($pageCount - $end > 1){
			$right = '...<a id="page-'.($pageCount).'"  value="'.($pageCount).'" href="javascript:;"><span>'.$pageCount.'</span></a>';
		}
		//echo $end;
		if($end > $pageCount){
			$end = $pageCount;
		}
		//echo $end;
		for($i=$start;$i<=$end;$i++){
			$PagerData['pagerCenter'] .= '<a id="page-'.$i.'" value="'.$i.'" '.($i == $currentPage ? 'class="current"' : '').' href="javascript:;" ><span>'.$i.'</span></a>';
		}
		$PagerData['pagerCenter'] = "$left {$PagerData['pagerCenter']} $right";
		
		return $PagerData;
	}
			
  public static function sendMail($profile=null, $subject, $template, $vars = array() ,$send = false, $locale=null)
  {
        $sfUser = sfContext::getInstance()->getUser();

        $domain = sfContext::getInstance()->getRequest()->getHost();
        $domain_array = sfConfig::get('app_domain_slugs');
        /*
         * OLD
         *
        if (!$sfUser || !($culture = $sfUser->getCulture())) {
          $culture = sfContext::getInstance()->getUser()->getCountry()->getSlug();
        }
         * END
         * 
         */
        $flag = false;
     
        foreach($domain_array as $dom){
            if(strstr($domain, $dom) !== false){
                 $current_lang_code = sfConfig::get('app_domain_to_culture_'.strtoupper($dom));
                 $flag = true;
                 break;
            }
       }

        if($flag === false && (strstr($domain, '.com') || strstr($domain, '.my'))){
            $current_lang_code = 'bg';
            $dom = 'bg';
        }
       
        $subject = sfContext::getInstance()->getI18N()->__($subject, null, 'mailsubject');

        if (!$profile):
            if ($dom == 'bg'):
                $to='info@getlokal.com';
            else:
                $country_name =strtolower(sfConfig::get('app_countries_'.$dom));
              //  preg_replace('/^\s*$/', '_', $country_name);
                $to = str_replace(' ', '_', $country_name).'@getlokal.com';
            endif;
        else:
        if($profile instanceOf UserProfile)   $profile = $profile->getSfGuardUser();

        if($profile instanceOf sfGuardUser)      $to = array($profile->getEmailAddress() => $profile->getFirstName()." ".$profile->getLastName());
        elseif(!is_array($profile))      $to = array($profile);
        else      $to = $profile;
        endif;

         if ($dom == 'bg'):
            $from='info@getlokal.com';
        else:
            $country_name = strtolower(sfConfig::get('app_countries_'.$dom));
            $from = $country_name.'@getlokal.com';
        endif;

        $from = array($from => 'getlokal');
        $context = sfContext::getInstance();
        $context->getConfiguration()->loadHelpers('Partial');

        $moduleName = 'mail';

       // $template = mb_convert_case($culture, MB_CASE_UPPER).'/_'. $template;
        
//        if($dom =='com'){
//            $dom = 'bg';
//        }

        
        if ($locale) {
            $template = strtoupper($locale).'/_'. $template;
        }
        else {
            $template = strtoupper(sfConfig::get('app_domain_to_culture_'.  strtoupper($dom))).'/_'. $template;
        }
        $actionName = $template;

        $class = sfConfig::get('mod_'.strtolower($moduleName).'_partial_view_class', 'sf').'PartialView';
        $view = new $class(sfContext::getInstance(), $moduleName, $actionName, '');

        $view->setPartialVars(true === sfConfig::get('sf_escaping_strategy') ? sfOutputEscaper::unescape($vars) : $vars);

        $bodyHtml  = $view->render();
        $bodyPlain = strip_tags($bodyHtml);

        $message = Swift_Message::newInstance()
                    ->setSubject($subject)
                    ->setFrom($from)
                    ->setTo($to)
                    ->setBody($bodyPlain)
                    ->addPart($bodyHtml, 'text/html');

        try
        {
          sfContext::getInstance()->getMailer()->send($message);
        }
        catch (Exception $e)
        {
          sfContext::getInstance()->getUser()->setFlash('error', 'The email could not be sent.');
        }
  }
  
  public static function sendMailReview($value) {
      $uri = sfContext::getInstance()->getRequest()->getUri();
      $html = '<p>A review that is longer than 1000 characters has been published.</p>
               <p><a href='.$uri.'>'.$uri.'</a></p>
               <p>Review ID = '.$value.'</p>';
  	  $message = Swift_Message::newInstance()
                    ->setSubject('Review with more than 1000 characters')
                    ->setFrom('getlokal@getlokal.com')
                    ->setTo('reviews@getlokal.com')
                    ->setBody(strip_tags($html))
                    ->addPart($html, 'text/html');
  	
  	  try
  	  {
  		  sfContext::getInstance()->getMailer()->send($message);
  	  }
  	  catch (Exception $e)
  	  {
  		  sfContext::getInstance()->getUser()->setFlash('error', 'The email could not be sent.');
  	  }
  }
  
  public static function sendMailInvalidData($values) {
      $valid = true;
      $html = '';
      
      $data = $values['data'];
      $sendTo = $data['sendTo'];
      $sendFrom = $data['sendFrom'];
      $sendSubject = $data['sendSubject'];
      
      $html = '<p><a href="'.$data['urlPlace'].'">'.$data['urlPlace'].'</a></p>';
      
      $htmlData = $values['html'];
      
      foreach ($htmlData as $key => $value) {
          if ($value) {
              $html = $html.'<p style="margin:0 0;padding:0;"><b>'.$key.' = '.$value.'</b></p>';
          }
          else {
              $html = $html.'<p style="margin:0 0;padding:0;">'.$key.' = '.$value.'</p>';
          }
      }
      
      $message = Swift_Message::newInstance()
                ->setSubject($sendSubject)
                ->setFrom($sendFrom)
                ->setTo($sendTo)
                ->setBody(strip_tags($html))
                ->addPart($html, 'text/html');

      try
      {
              sfContext::getInstance()->getMailer()->send($message);
      }
      catch (Exception $e)
      {
              $valid = false;
      }
      
      return $valid;
  }

  public static function curl_get_file($url)
  {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $return = curl_exec($ch);
    curl_close($ch);

    return $return;
  }
  public static function getCopyRegion($ow, $oh, $tw, $th)
  {
    if((($oh / $ow) * $tw) > $th)
    {

      $h = ($th / $tw) * $ow;
      //$w = ($oh / $ow) * $h;

      return array(0, 0, $ow, $h);
    }
    elseif(($oh / $ow * $tw) < $th)
    {
      $w = ($tw / $th) * $oh;
      $h = ($oh / $ow) * $w;

      $x = ($ow - $w) / 2;

      return array($x, 0, $w, $oh);
    }
  }

  public static function strip_only($str, $tags, $stripContent = false) {
    $content = '';
    if(!is_array($tags)) {
        $tags = (strpos($str, '>') !== false ? explode('>', str_replace('<', '', $tags)) : array($tags));
        if(end($tags) == '') array_pop($tags);
    }
    foreach($tags as $tag) {
        if ($stripContent)
             $content = '(.+</'.$tag.'[^>]*>|)';
         $str = preg_replace('#</?'.$tag.'[^>]*>'.$content.'#is', '', $str);
    }
    return $str;
  }

  public static function compute_public_path($source, $dir, $ext, $absolute = false)
  {
    if (strpos($source, '://'))
    {
      return $source;
    }

    $request = sfContext::getInstance()->getRequest();
    $sf_relative_url_root = $request->getRelativeUrlRoot();
    if (0 !== strpos($source, '/'))
    {
      $source = $sf_relative_url_root.'/'.$dir.'/'.$source;
    }

    $query_string = '';
    if (false !== $pos = strpos($source, '?'))
    {
      $query_string = substr($source, $pos);
      $source = substr($source, 0, $pos);
    }

    if (false === strpos(basename($source), '.'))
    {
      $source .= '.'.$ext;
    }

    if ($sf_relative_url_root && 0 !== strpos($source, $sf_relative_url_root))
    {
      $source = $sf_relative_url_root.$source;
    }

    if ($absolute)
    {
      $source = 'http'.($request->isSecure() ? 's' : '').'://'.$request->getHost().$source;
    }
    elseif(sfConfig::get('app_server_enable_static'))
    {
      $source = sfConfig::get('app_server_static_url').$source;
    }

    return $source.$query_string;
  }
    public static function simple_format_text($text, $br = 1, $smallTube = true)
    {
      $text = $text . "\n"; // just to make things a little easier, pad the end
      $text = preg_replace('|<br />\s*<br />|', "\n\n", $text);
      // Space things out a little
      $allblocks = '(?:table|thead|tfoot|caption|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|form|map|area|blockquote|address|math|style|input|p|h[1-6]|hr)';
      $text = preg_replace('!(<' . $allblocks . '[^>]*>)!', "\n$1", $text);
      $text = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $text);
      $text = str_replace(array("\r\n", "\r"), "\n", $text); // cross-platform newlines
      if ( strpos($text, '<object') !== false ) {
        $text = preg_replace('|\s*<param([^>]*)>\s*|', "<param$1>", $text); // no pee inside object/embed
        $text = preg_replace('|\s*</embed>\s*|', '</embed>', $text);
      }
      $text = preg_replace("/\n\n+/", "\n\n", $text); // take care of duplicates
      $text = preg_replace('/\n?(.+?)(?:\n\s*\n|\z)/s', "<p>$1</p>\n", $text); // make paragraphs, including one at the end
      $text = preg_replace('|<p>\s*?</p>|', '', $text); // under certain strange conditions it could create a P of entirely whitespace
      $text = preg_replace('!<p>([^<]+)\s*?(</(?:div|address|form)[^>]*>)!', "<p>$1</p>$2", $text);
      $text = preg_replace( '|<p>|', "$1<p>", $text );
      $text = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $text); // don't pee all over a tag
      $text = preg_replace("|<p>(<li.+?)</p>|", "$1", $text); // problem with nested lists
      $text = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $text);
      $text = str_replace('</blockquote></p>', '</p></blockquote>', $text);
      $text = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', "$1", $text);
      $text = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $text);
      if ($br) {
        $text = preg_replace_callback('/<(script|style).*?<\/\\1>/s', create_function('$matches', 'return str_replace("\n", "<WPPreserveNewline />", $matches[0]);'), $text);
        $text = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $text); // optionally make line breaks
        $text = str_replace('<WPPreserveNewline />', "\n", $text);
      }
      $text = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $text);
      $text = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $text);
      if (strpos($text, '<pre') !== false)
        $text = preg_replace_callback('!(<pre.*?>)(.*?)</pre>!is', 'clean_pre', $text );
      $text = preg_replace( "|\n</p>$|", '</p>', $text );
      //$text = preg_replace('/<p>\s*?(' . get_shortcode_regex() . ')\s*<\/p>/s', '$1', $text); // don't auto-p wrap shortcodes that stand alone

      if($smallTube)
      {
       $text = preg_replace('/\[youtube\]([^\[\]]+)\[\/youtube\]/','<object width="300" height="182"><param name="movie" value="\\$1"></param><param name="wmode" value="transparent"></param><embed src="\\1" type="application/x-shockwave-flash" wmode="transparent" width="300" height="182"></embed></object>',$text);
       $text = preg_replace('/\[img\]([^\[\]]+)\[\/img\]/i','<img width="300" src="$1" />',$text);
      }
      else
       $text = preg_replace('/\[youtube\]([^\[\]]+)\[\/youtube\]/','<object width="560" height="340"><param name="movie" value="\\$1"></param><param name="wmode" value="transparent"></param><embed src="\\1" type="application/x-shockwave-flash" wmode="transparent" width="560" height="340"></embed></object>',$text);

      $text = BBcode::processSmileys($text);
      $text = self::auto_link_urls($text,'all','rel=nofollow');

      return $text;
    }

    public static function auto_link_urls($text, $href_options = array(), $truncate = false, $truncate_len = 40, $pad = '...')
    {
      $href_options = _tag_options($href_options);

      $callback_function = '
        if (preg_match("/<a\s/i", $matches[1]))
        {
          return $matches[0];
        }
        ';

      if ($truncate)
      {
        $callback_function .= '
          else if (strlen($matches[2].$matches[3]) > '.$truncate_len.')
          {
            return $matches[1].\'<a href="\'.($matches[2] == "www." ? "http://www." : $matches[2]).$matches[3].\'"'.$href_options.'>\'.substr($matches[2].$matches[3], 0, '.$truncate_len.').\''.$pad.'</a>\'.$matches[4];
          }
          ';
      }

      $callback_function .= '
        else
        {
          return $matches[1].\'<a href="\'.($matches[2] == "www." ? "http://www." : $matches[2]).$matches[3].\'"'.$href_options.'>\'.$matches[2].$matches[3].\'</a>\'.$matches[4];
        }
        ';

      return preg_replace_callback(
        '~
        (                       # leading text
          <\w+.*?>|             #   leading HTML tag, or
          [^=!:\'"/]|           #   leading punctuation, or
          ^                     #   beginning of line
        )
        (
          (?:https?://)|        # protocol spec, or
          (?:www\.)             # www.*
        )
        (
          [-\w]+                   # subdomain or domain
          (?:\.[-\w]+)*            # remaining subdomains or domain
          (?::\d+)?                # port
          (?:/(?:(?:[\~\w\+%-]|(?:[,.;:][^\s$]))+)?)* # path
          (?:\?[\w\+%&=.;-]+)?     # query string
          (?:\#[\w\-]*)?           # trailing anchor
        )
        ([[:punct:]]|\s|<|$)    # trailing text
       ~x',
        create_function('$matches', $callback_function),
        $text
        );
    }

    public static function neat_trim($str, $n = null, $delim='…') {
        if ($n == null) return $str;

        $len = strlen($str);

        if ($len > $n) {
            preg_match('/(.{' . $n . '}.*?)\b/', $str, $matches);

            return rtrim($matches[1]) . $delim;
        }
        else {
            return $str;
        }
    }

    public static function cleanSpecialChars($v)
    {
        $find_chars = array("À",
        "A",
        "Â",
        "Ã",
        "Ä",
        "Å",
        "Æ",
        "Ç",
        "È",
        "É",
        "Ê",
        "Ë",
        "Ì",
        "I",
        "Î",
        "I",
        "Ñ",
        "Ò",
        "Ó",
        "Ô",
        "Õ",
        "Ö",
        "Ø",
        "Ù",
        "Ú",
        "Û",
        "Ü",
        "U",
        "Ţ",
        "Ş",
        "à",
        "á",
        "â",
        "ã",
        "ä",
        "å",
        "æ",
        "ç",
        "è",
        "é",
        "ê",
        "ë",
        "ì",
        "í",
        "î",
        "ï",
        "ñ",
        "ò",
        "ó",
        "ô",
        "õ",
        "ö",
        "ø",
        "ù",
        "ú",
        "û",
        "ü",
        "ý",
        "ÿ",
        "ţ",
        "ş");

        $replace_chars = array("A",
        "A",
        "A",
        "A",
        "A",
        "AE",
        "C",
        "E",
        "E",
        "E",
        "E",
        "I",
        "I",
        "I",
        "I",
        "N",
        "O",
        "O",
        "O",
        "O",
        "O",
        "O",
        "O",
        "U",
        "U",
        "U",
        "U",
        "Y",
        "T",
        "S",
        "a",
        "a",
        "a",
        "a",
        "a",
        "a",
        "ae",
        "c",
        "e",
        "e",
        "e",
        "e",
        "i",
        "i",
        "i",
        "i",
        "n",
        "o",
        "o",
        "o",
        "o",
        "o",
        "o",
        "u",
        "u",
        "u",
        "u",
        "y",
        "y",
        "t".
        "s");

        if (function_exists("mb_strtolower")) $v = mb_strtolower($v);
        else $v = strtolower($v);

        return str_replace($find_chars, $replace_chars, $v);

    }

    public static function replaceDiacritics($text)
    {
      //if (function_exists("mb_strtolower")) $text = mb_strtolower($text);
      //  else $text = strtolower($text);

      $from = array("Á", "À", "Â", "Ä", "Ă", "Ā", "Ã", "Å", "Ą", "Æ", "Ć", "Ċ", "Ĉ", "Č", "Ç", "Ď", "Đ", "Ð", "É", "È", "Ė", "Ê", "Ë", "Ě", "Ē", "Ę", "Ə", "Ġ", "Ĝ", "Ğ", "Ģ", "á", "à", "â", "ä", "ă", "ā", "ã", "å", "ą", "æ", "ć", "ċ", "ĉ", "č", "ç", "ď", "đ", "ð", "é", "è", "ė", "ê", "ë", "ě", "ē", "ę", "ə", "ġ", "ĝ", "ğ", "ģ", "Ĥ", "Ħ", "I", "Í", "Ì", "İ", "Î", "Ï", "Ī", "Į", "Ĳ", "Ĵ", "Ķ", "Ļ", "Ł", "Ń", "Ň", "Ñ", "Ņ", "Ó", "Ò", "Ô", "Ö", "Õ", "Ő", "Ø", "Ơ", "Œ", "ĥ", "ħ", "ı", "í", "ì", "i", "î", "ï", "ī", "į", "ĳ", "ĵ", "ķ", "ļ", "ł", "ń", "ň", "ñ", "ņ", "ó", "ò", "ô", "ö", "õ", "ő", "ø", "ơ", "œ", "Ŕ", "Ř", "Ś", "Ŝ", "Š", "Ş", "Ť", "Ţ", "Þ", "Ú", "Ù", "Û", "Ü", "Ŭ", "Ū", "Ů", "Ų", "Ű", "Ư", "Ŵ", "Ý", "Ŷ", "Ÿ", "Ź", "Ż", "Ž", "ŕ", "ř", "ś", "ŝ", "š", "ş", "ß", "ť", "ţ", "þ", "ú", "ù", "û", "ü", "ŭ", "ū", "ů", "ų", "ű", "ư", "ŵ", "ý", "ŷ", "ÿ", "ź", "ż", "ž");
      $to = array("A", "A", "A", "A", "A", "A", "A", "A", "A", "AE", "C", "C", "C", "C", "C", "D", "D", "D", "E", "E", "E", "E", "E", "E", "E", "E", "G", "G", "G", "G", "G", "a", "a", "a", "a", "a", "a", "a", "a", "a", "ae", "c", "c", "c", "c", "c", "d", "d", "d", "e", "e", "e", "e", "e", "e", "e", "e", "g", "g", "g", "g", "g", "H", "H", "I", "I", "I", "I", "I", "I", "I", "I", "IJ", "J", "K", "L", "L", "N", "N", "N", "N", "O", "O", "O", "O", "O", "O", "O", "O", "CE", "h", "h", "i", "i", "i", "i", "i", "i", "i", "i", "ij", "j", "k", "l", "l", "n", "n", "n", "n", "o", "o", "o", "o", "o", "o", "o", "o", "o", "R", "R", "S", "S", "S", "S", "T", "T", "T", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "W", "Y", "Y", "Y", "Z", "Z", "Z", "r", "r", "s", "s", "s", "s", "B", "t", "t", "b", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "w", "y", "y", "y", "z", "z", "z");


      $cyr  = array('а','б','в','г','д','е','ж','з','и','й','к','л','м','н','о','п','р','с','т','у',
        'ф','х','ц','ч','ш','щ','ъ','ь', 'ю','я','А','Б','В','Г','Д','Е','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У',
        'Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ь', 'Ю','Я' );

      $lat = array( 'a','b','v','g','d','e','zh','z','i','y','k','l','m','n','o','p','r','s','t','u',
        'f' ,'h' ,'ts' ,'ch','sh' ,'sht' ,'a' ,'y' ,'yu' ,'ya','A','B','V','G','D','E','Zh',
        'Z','I','Y','K','L','M','N','O','P','R','S','T','U',
        'F' ,'H' ,'Ts' ,'Ch','Sh' ,'Sht' ,'A' ,'Y' ,'Yu' ,'Ya' );

      $text = str_replace($from, $to, $text);
      $text = str_replace($cyr, $lat, $text);

      return $text;
    }

    public static function cleanUrl($v)
    {
      //$v = trim($v);
      $v = self::replaceDiacritics($v);
      $v = self::cleanSpecialChars($v);
      $v = preg_replace('/.html$/i', '', $v);
      $v = preg_replace('/([^[a-zA-Z0-9\s_]]*)+/', '', $v);
      $v = preg_replace("/^_+/", "", $v);
      $v = preg_replace("/_+$/", "", $v);
      $v = preg_replace("/\s+/", "-", $v);
      $v = trim($v);

      return $v;
    }

    public static function clearExtension($v)
    {
        $v = preg_replace('/(\.[a-zA-z0-9]{0,4})$/', '', $v);

        return $v;
        //return self::cleanUrl($v);
    }

    public static function stripText($text)
    {
        $text = strtolower($text);

        // strip all non word chars
        $text = preg_replace('/\W/', ' ', $text);

        // replace all white space sections with a dash
        $text = preg_replace('/\ +/', '-', $text);

        // trim dashes
        $text = preg_replace('/\-$/', '', $text);
        $text = preg_replace('/^\-/', '', $text);

        return $text;
    }

    public static function stemPhrase($phrase, $culture)
    {
        // split into words
        $phrase = myTools::replaceDiacritics($phrase);
        $words = str_word_count(mb_strtolower($phrase), 1);

        // ignore stop words
        $words = myTools::removeStopWordsFromArray($words);

        // stem words
        $stemmed_words = array();
        foreach ($words as $word)
        {
            // ignore 1 and 2 letter words
            if (strlen($word) <= 2)
            {
                continue;
            }

            // stem word (stemming is specific for each language)
            $class = 'Stemmer'. ucfirst($culture);

            $words = call_user_func(array($class, 'stem'), $word);
            if(!is_array($words)) $words = array($words);

            foreach($words as $word)
            {
              $stemmed_words[] = $word;
              $stemmed_words[] = trim($word, ' ,.');
            }
        }

        return $stemmed_words;
    }

    public static function removeStopWordsFromArray($words)
    {
        $stop_words = array(
        'i', 'me', 'my', 'myself', 'we', 'our', 'ours', 'ourselves', 'you', 'your', 'yours',
        'yourself', 'yourselves', 'he', 'him', 'his', 'himself', 'she', 'her', 'hers',
        'herself', 'it', 'its', 'itself', 'they', 'them', 'their', 'theirs', 'themselves',
        'what', 'which', 'who', 'whom', 'this', 'that', 'these', 'those', 'am', 'is', 'are',
        'was', 'were', 'be', 'been', 'being', 'have', 'has', 'had', 'having', 'do', 'does',
        'did', 'doing', 'a', 'an', 'the', 'and', 'but', 'if', 'or', 'because', 'as', 'until',
        'while', 'of', 'at', 'by', 'for', 'with', 'about', 'against', 'between', 'into',
        'through', 'during', 'before', 'after', 'above', 'below', 'to', 'from', 'up', 'down',
        'in', 'out', 'on', 'off', 'over', 'under', 'again', 'further', 'then', 'once', 'here',
        'there', 'when', 'where', 'why', 'how', 'all', 'any', 'both', 'each', 'few', 'more',
        'most', 'other', 'some', 'such', 'no', 'nor', 'not', 'only', 'own', 'same', 'so',
        'than', 'too', 'very',

        'a', 'abia', 'acea', 'aceasta', 'aceea', 'aceeasi', 'aceia', 'acel', 'acela', 'acelasi',
        'acelea', 'acest', 'acesta', 'aceste', 'acestea', 'acestei', 'acestia', 'acestui', 'acolo',
        'acum', 'adica', 'ai', 'aia', 'aici', 'aiurea', 'al', 'ala', 'alaturi', 'ale', 'alt', 'alta', 'altceva',
        'alte', 'altfel', 'alti', 'altii', 'altul', 'am', 'anume', 'apoi', 'ar', 'are', 'as', 'asa', 'asemenea',
        'asta', 'astazi', 'astfel', 'asupra', 'atare', 'ati', 'atit', 'atat', 'atata', 'atatea', 'atatia', 'atita',
        'atitea', 'atitia', 'atunci', 'au', 'avea', 'avem', 'avut', 'azi', 'b', 'ba', 'bine', 'c', 'ca', 'cat', 'cam',
        'capat', 'care', 'careia', 'carora', 'caruia', 'catre', 'ce', 'cea', 'ceea', 'cei', 'ceilalti', 'cel', 'cele',
        'celor', 'ceva', 'chiar', 'ci', 'cind', 'cand', 'cine', 'cineva', 'cit', 'cita', 'cite', 'citeva', 'citi', 'citiva',
        'conform', 'cu', 'cui', 'cum', 'cumva', 'd', 'da', 'daca', 'dar', 'dat', 'de', 'deasupra', 'deci', 'decit', 'degraba',
        'deja', 'desi', 'despre', 'din', 'dintr', 'dintre', 'doar', 'dupa', 'e', 'ea', 'ei', 'el', 'ele', 'era', 'este', 'eu',
        'exact', 'f', 'face', 'fara', 'fata', 'fel', 'fi', 'fie', 'foarte', 'fost', 'g', 'geaba', 'h', 'i', 'ia', 'iar', 'ii',
        'il', 'imi', 'in', 'inainte', 'inapoi', 'inca', 'incit', 'insa', 'intr', 'intre', 'isi', 'iti', 'j', 'k', 'l', 'la', 'le',
        'li', 'lor', 'lui', 'm', 'ma', 'mai', 'mare', 'mi', 'mod', 'mult', 'multa', 'multe', 'multi', 'n', 'ne', 'ni', 'nici',
        'niciodata', 'nimeni', 'nimic', 'niste', 'noi', 'nostri', 'nou', 'noua', 'nu', 'numai', 'o', 'or', 'ori', 'orice',
        'oricum', 'p', 'pai', 'parca', 'pe', 'pentru', 'peste', 'pina', 'plus', 'prea', 'prin', 'putini', 'r', 's', 'sa',
        'sai', 'sale', 'sau', 'se', 'si', 'sint', 'sintem', 'sa-ti', 'sa-mi', 'spre', 'sub', 'sus', 'sunt', 'suntem', 't',
        'te', 'ti', 'toata', 'toate', 'tocmai', 'tot', 'toti', 'totul', 'totusi', 'tu', 'tuturor', 'u', 'un', 'una', 'unde',
        'unei', 'unele', 'uneori', 'unii', 'unor', 'unui', 'unul', 'ul', 'ului', 'v', 'va', 'voi', 'vom', 'vor', 'vreo',
        'vreun', 'x', 'z',

        'а', 'аз', 'ако', 'ала', 'бе', 'без', 'беше', 'би', 'бил', 'била', 'били', 'било', 'близо', 'бъдат', 'бъде', 'бяха',
        'в', 'вас', 'ваш', 'ваша', 'вероятно', 'вече', 'взема', 'ви', 'вие', 'винаги', 'все', 'всеки', 'всички', 'всичко',
        'всяка', 'във', 'въпреки', 'върху', 'г', 'ги', 'главно', 'го', 'д', 'да', 'дали', 'до', 'докато', 'докога', 'дори',
        'досега', 'доста', 'е', 'едва', 'един', 'ето', 'за', 'зад', 'заедно', 'заради', 'засега', 'затова', 'защо', 'защото',
        'и', 'из', 'или', 'им', 'има', 'имат', 'иска', 'й', 'каза', 'как', 'каква', 'какво', 'както', 'какъв', 'като', 'кога',
        'когато', 'което', 'които', 'кой', 'който', 'колко', 'която', 'къде', 'където', 'към', 'ли', 'м', 'ме', 'между', 'мен',
        'ми', 'мнозина', 'мога', 'могат', 'може', 'моля', 'момента', 'му', 'н', 'на', 'над', 'назад', 'най', 'направи', 'напред',
        'например', 'нас', 'не', 'него', 'нея', 'ни', 'ние', 'никой', 'нито', 'но', 'някои', 'някой', 'няма', 'обаче', 'около',
        'освен', 'особено', 'от', 'отгоре', 'отново', 'още', 'пак', 'по', 'повече', 'повечето', 'под', 'поне', 'поради', 'после',
        'почти', 'прави', 'пред', 'преди', 'през', 'при', 'пък', 'първо', 'с', 'са', 'само', 'се', 'сега', 'си', 'скоро', 'след',
        'сме', 'според', 'сред', 'срещу', 'сте', 'съм', 'със', 'също', 'т', 'тази', 'така', 'такива', 'такъв', 'там', 'твой', 'те',
        'тези', 'ти', 'тн', 'то', 'това', 'тогава', 'този', 'той', 'толкова', 'точно', 'трябва', 'тук', 'тъй', 'тя', 'тях', 'у',
        'харесва', 'ч', 'че', 'често', 'чрез', 'ще', 'щом', 'я'
        );

        return array_diff($words, $stop_words);
    }

    public static function checkSetup()
    {
        $user = sfContext::getInstance()->getUser();

        if ($user->hasPermision('box_edit') && $user->getAttribute('edit',false))
        {
            $response = sfContext::getInstance()->getResponse();

            $response->addJavascript(sfConfig::get('sf_lightbox_js_dir'). 'lightbox.js','last');
            $response->addStylesheet(sfConfig::get('sf_lightbox_css_dir'). 'lightbox.css','last');


            $response->addJavascript(sfConfig::get('sf_lightbox_js_dir'). 'modalbox.js','last');
            $response->addStylesheet(sfConfig::get('sf_lightbox_css_dir'). 'modalbox.css','last');


            $response->addJavascript('dragdrop_patched','last');
            $response->addJavascript('lists','last');
            $response->addJavascript('listTools','last');

            return true;
        }
        return false;
    }

    public static function cleanWordChars($text) {
        $entities = array(128 => 'euro',
        130 => 'sbquo',
        131 => 'fnof',
        132 => 'bdquo',
        133 => 'hellip',
        134 => 'dagger',
        135 => 'Dagger',
        136 => 'circ',
        137 => 'permil',
        138 => 'Scaron',
        139 => 'lsaquo',
        140 => 'OElig',
        145 => 'lsquo',
        146 => 'rsquo',
        147 => 'ldquo',
        148 => 'rdquo',
        149 => 'bull',
        150 => '#45',
        151 => 'mdash',
        152 => 'tilde',
        153 => 'trade',
        154 => 'scaron',
        155 => 'rsaquo',
        156 => 'oelig',
        159 => 'Yuml'
        );
        $new_text = '';
        for($i = 0; $i < strlen($text); $i++)
        {
            $num = ord($text{$i});

            if (array_key_exists($num, $entities))
            {
                switch ($num)
                {
                    case 150:
                        $new_text .= '-';
                        break;
                    default:
                        $new_text .= '&'.$entities[$num].';';
                }
            }
            elseif($num < 127 || $num > 159)
            $new_text .= $text{$i};
        }

        return $new_text;
    }

    public static function process_post($str)
    {
        require_once("nbbc.php");

    $bbcode = new BBCode;

    $bbcode->SetSmileyURL("/images/emoticons/idieta/");
    $bbcode->SetSmileyDir("../web/images/emoticons/idieta");

    $bbcode->SetEnableSmileys(true);
    $bbcode->SetDetectURLs(true);

        $databaseManager = new sfDatabaseManager();
        $databaseManager->initialize();

        $smilies = EmoticonPeer::doSelect(new Criteria());


        foreach( $smilies as $smiley)
            $bbcode->AddSmiley($smiley->getCode(), $smiley->getUrl());

        return nl2br($bbcode->Parse((htmlspecialchars(trim($str)))));
    }


 static function pgEscapeArrayForIn($list)
  {
    $result = array();
    foreach ($list as $element)
    {
      $result[] = pg_escape_string($element);
    }
    return '\''.implode('\', \'', $result).'\'';
  }

 public static function sendMailToCompany($to_company, $subject, $template, $vars = array() ,$send = false)
  {
   $culture = sfContext::getInstance()->getUser()->getCountry()->getSlug();
   $subject = sfContext::getInstance()->getI18N()->__($subject);

        if ($culture == 'ro'):
           $from_mail='romania@getlokal.com';
        elseif	($culture == 'bg'):
            $from_mail='info@getlokal.com';
       elseif	($culture == 'mk'):
            $from_mail='macedonia@getlokal.com';
        elseif	($culture == 'sr'):
            $from_mail='serbia@getlokal.com';
       endif;

    $to = $to_company->getEmail();


    $from = array( $from_mail => 'getlokal');
    $context = sfContext::getInstance();
    $context->getConfiguration()->loadHelpers('Partial');

    $moduleName = 'mail';
    $culture = sfContext::getInstance()->getUser()->getCountry()->getSlug();

    $template = mb_convert_case($culture, MB_CASE_UPPER).'/_'. $template;

    $actionName = $template;

    $class = sfConfig::get('mod_'.strtolower($moduleName).'_partial_view_class', 'sf').'PartialView';
    $view = new $class(sfContext::getInstance(), $moduleName, $actionName, '');

    $view->setPartialVars(true === sfConfig::get('sf_escaping_strategy') ? sfOutputEscaper::unescape($vars) : $vars);

    $bodyHtml  = $view->render();
    $bodyPlain = strip_tags($bodyHtml);
    $message = Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($vars['user_data']['email'])
                ->setTo($to)
                ->setReplyTo($vars['user_data']['email'])
                ->setBody($bodyPlain)
                ->addPart($bodyHtml, 'text/html');

    try
    {
      sfContext::getInstance()->getMailer()->send($message);
      sfContext::getInstance()->getUser ()->setFlash ( 'notice', 'Your message was sent successfully.' );
    }
    catch (Exception $e)
    {
      sfContext::getInstance()->getUser()->setFlash('error', 'The email message was not sent successfully.');
    }
  }

 public static function sendMailToSmo($to_mail, $subject, $template, $vars = array() ,$send = false)
  {
   $culture = sfContext::getInstance()->getUser()->getCountry()->getSlug();
   $subject = sfContext::getInstance()->getI18N()->__($subject);

        if ($culture == 'ro'):
           $from_mail='romania@getlokal.com';
        elseif	($culture == 'bg'):
            $from_mail='info@getlokal.com';
       elseif	($culture == 'mk'):
            $from_mail='macedonia@getlokal.com';
       elseif	($culture == 'sr'):
            $from_mail='serbia@getlokal.com';
       endif;
     $context = sfContext::getInstance();
    $context->getConfiguration()->loadHelpers('Partial');

    $moduleName = 'mail';
    $culture = sfContext::getInstance()->getUser()->getCountry()->getSlug();

    $template = mb_convert_case($culture, MB_CASE_UPPER).'/_'. $template;

    $actionName = $template;

    $class = sfConfig::get('mod_'.strtolower($moduleName).'_partial_view_class', 'sf').'PartialView';
    $view = new $class(sfContext::getInstance(), $moduleName, $actionName, '');

    $view->setPartialVars(true === sfConfig::get('sf_escaping_strategy') ? sfOutputEscaper::unescape($vars) : $vars);

    $bodyHtml  = $view->render();
    $bodyPlain = strip_tags($bodyHtml);
     $from = array( $from_mail => 'getlokal');
      if (is_array($to_mail)){
    foreach ($to_mail as $key =>$to)
    {



    $message = Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($from)
                ->setTo($to)
                ->setBody($bodyPlain)
                ->addPart($bodyHtml, 'text/html');

    try
    {
      sfContext::getInstance()->getMailer()->send($message);
    }
    catch (Exception $e)
    {
      sfContext::getInstance()->getUser()->setFlash('error', 'The email could not be sent.');
    }

    }

  }
  else
  {


    $message = Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($from)
                ->setTo($to_mail)
                ->setBody($bodyPlain)
                ->addPart($bodyHtml, 'text/html');

    try
    {
      sfContext::getInstance()->getMailer()->send($message);
      sfContext::getInstance()->getUser ()->setFlash ( 'notice', 'Your message was sent successfully.' );
    }
    catch (Exception $e)
    {
      sfContext::getInstance()->getUser()->setFlash('error', 'The email message was not sent successfully.');
    }


  }
  }

  public static function distance($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'Km')
  {
    $theta = $longitude1 - $longitude2;
    $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
    $distance = acos($distance);
    $distance = rad2deg($distance);
    $distance = $distance * 60 * 1.1515;
    switch($unit) {
      case 'Mi': break; case 'Km' : $distance = $distance * 1.609344;
    }
    return round($distance, 2);
  }
  public static function cleanSlugString($slugString)
  {
    $cleanSlug = strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('-', '-', ''), myTools::replaceDiacritics($slugString)));
    return $cleanSlug;
  }

  public static function generateKeywords($string)
  {
        $words = preg_split("/[\s,-.?!@#:]+/", $string);
        for($i=0; $i<=count($words)-1; $i++)
        {
            if(strlen(utf8_decode($words[$i]))<=2)
            {
		unset($words[$i]);
            }
        }
        $keyWords = implode (", ",$words);
        return  mb_convert_case($keyWords, MB_CASE_LOWER, 'UTF-8');
  }
  
  public static function getPostcode($lat, $lng) 
  {
        $found_flag = false;
        $domain = sfContext::getInstance()->getRequest()->getHost();
        foreach(sfConfig::get('app_domain_slugs') as $dom){
            if(strstr($domain, $dom)){
                $dom_ext = $dom;
                $found_flag= true;
                break;
            }
        }

        if($found_flag === false && (strstr($domain, 'com') || strstr($domain, 'my'))){
            $dom_ext = 'bg';
        }

        $default_postal_codes = array(
                    'bg'=> '1000',
                    'ro' => '010011', 
                    'rs' => '11000', 
                    'mk' => '1000', 
                    'fi' => '00100', 
                    'hu' => '1051',  
                    'sk' => '81421',
                    'cz' => '10000',
        			'ru' => '107207'
                    );
      
        $ch = curl_init();
        $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&sensor=false";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);
        $json = json_decode($result, TRUE);
        if (isset($json['results'])) {
            foreach    ($json['results'] as $result) {
                foreach ($result['address_components'] as $address_component) {
                    $types = $address_component['types'];
                    if (in_array('postal_code', $types) && sizeof($types) == 1) {
                       $returnValue = $address_component['short_name'];
                    }
                    else{
                      $returnValue = $default_postal_codes[$dom_ext];
                    }
                }
            }
        }
        if(!isset($returnValue) || $returnValue ==''){
            $returnValue = $default_postal_codes[$dom_ext];
        }
        
        return $returnValue;
  }
  
  public static function getResponseData ($url, $isSSL) {
      $ch = curl_init();
      $timeout = 5;
      curl_setopt($ch,CURLOPT_URL,$url);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_AUTOREFERER, true);
	  if ($isSSL) {
		  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	  }
      curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
	         
      $data = curl_exec($ch);
	  
      curl_close($ch);
      
      return $data;      
  }
	public static function isExceedingMaxPhpSize(){
	  	$content_length = 0;
	  	if(isset($_SERVER["CONTENT_LENGTH"])){
	  		$content_length = $_SERVER["CONTENT_LENGTH"];
	  	}elseif(isset($_SERVER["HTTP_CONTENT_LENGTH"])){
	  		$content_length = $_SERVER["HTTP_CONTENT_LENGTH"];
	  	}else{
	  		$content_length = strlen(file_get_contents('php://input'));
	  	}
	  	
	  	if($content_length && $content_length > ((int)ini_get('post_max_size')*1024*1024)){
	  		return 1;
	  	}else{
	  		return 0;
	  	}
	}
  
    public static function getUserCountry() {
        $ip_check = sfContext::getInstance()->getRequest()->getPathInfoArray();

        if (array_key_exists('REMOTE_ADDR', $ip_check)) {
            $ip_address = sfContext::getInstance()->getRequest()->getRemoteAddress();
        } else {
            $ip_address = '';
        }

//        $host = sfContext::getInstance()->getRequest()->getHost();

        //For test uncomment the following lines
        // $ip_address = '2.63.255.255'; //ip russia ip
        //$ip_address = '37.16.96.0'; //ip finland
        //$ip_address = '5.56.64.0'; //ip moldova

//        if ($ip_address != '127.0.0.1' && $ip_address != '') {
        if ($ip_address != '') {
            $positions = explode('.', $ip_address);

            $integer_ip = ( 16777216 * $positions[0] ) + ( 65536 * $positions[1] ) + ( 256 * $positions[2] ) + $positions[3];

            $countryCheck = Doctrine_Query::create()
                    ->select('gc.country_slugs')
                    ->from('GeoipCountries gc')
                    ->Where('integer_from <=?', $integer_ip)
                    ->andWhere('integer_to >=?', $integer_ip)
                    ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                    ->limit(1)
                    ->execute();
            
            $country = new Country();  
            $culture = '';

            if($countryCheck){
              $culture = strtolower($countryCheck[0]['country_slugs']);
            }
            
            // $countryName = $country->getCountryByCulture($culture);
            // 
            $countryName = Doctrine::getTable('Country')->findBy('slug', $culture);

            $language = '';

            $latin = array('al', 'ad', 'am', 'at', 'be', 'hr', 'cz', 'dk', 'ee', 'fr', 'de', 'is', 'ie', 'it', 'lv', 'li', 'lt', 'lu', 'mt', 'mc', 'me', 'nl', 'no', 'pl', 'sm', 'sk', 'si', 'es', 'se', 'ch', 'tr', 'gb', 'va', 'xk');
            $cyrilic = array('by', 'kz', 'ua', 'az', 'ba', 'md');
            $other = array('am', 'cy', 'ge', 'gr');

            if(in_array($culture, $latin)){
              $language = 'latin';
            }
            elseif(in_array($culture, $cyrilic)){
              $language = 'cyrillic';
            }
            elseif(in_array($culture, $other)){
              $language = 'other';
            }
            
            $data = array('id' => $countryName[0]['id'],
                          'name_en' => $countryName[0]['name_en'], 
                          'slug' => $culture,
                          'language' => $language);

            if ($country) {
                return $data;
            }
        }
        return;
    }
    
    public static function getLocationsFromSearch($doGeocode = true){
    	$request = sfContext::getInstance()->getRequest();
    	$user = sfContext::getInstance()->getUser();
    	$location = $request->getParameter('w', false);
    	$glr = $request->getParameter('glr', false);
    	$acWhere = $request->getParameter('ac_where', false);
    	$acWhereIDs = $request->getParameter('ac_where_ids', false);
    	 
    	$city = null;
    	$county = null;
    	$country = null;
    	 
    	$locationIDs = array();
    	 
    	if(isset($location) && $location!=''){
    		if(($acWhere != $location) && $doGeocode){
    			
    			// BEGIN: Default city is selecetd,typed or just the 'where' fields is left epmty: no need to send to google
    			$whereString = $location;
    			$whereString = mb_strtolower($whereString, 'utf-8');
    			$whereString = trim($whereString);
    			$default = $user->getCountry()->getSlug() != 'fi' ? $user->getCity() : $user->getCity()->getCounty();
    			$defaultEn = $user->getCountry()->getSlug() != 'fi' ? $user->getCity()->getNameEn() : $user->getCity()->getCounty()->getNameEn();    			
    			$options[] = mb_strtolower($default, 'utf-8');
    			$options[] = mb_strtolower($defaultEn, 'utf-8');    			
    			if(in_array($whereString, $options)){
    				$country = $user->getCountry()->getId();
    				$county = $user->getCounty()->getId();
					$city = $user->getCity()->getId();
					return array($city,$county,$country);
    			}
    			// END;
    			if($glr != false ){
    				$glr = str_replace('||', '|', $glr);
    				$en_location = explode('|', $glr);
    				//var_dump($en_location); //die;
    			}else{
	    			$acWhereIDs = "";
	    			$en_location =array();
	    			$location=str_replace(array(', ', ' '),array(',','+'),$location);
	    			$url = 'http://maps.googleapis.com/maps/api/geocode/xml?address='.$location.'&sensor=false&language=en';
	    			$ch = curl_init();
	    			curl_setopt($ch, CURLOPT_URL, $url);
	    			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
	    			$geo_contents = curl_exec($ch);
	    			curl_close($ch);
	    			 
	    			//  $geo_contents = json_decode($geo_contents, true );
	    			 
	    			$geo_contents = simplexml_load_string($geo_contents);
	    
	    
	    			$tmp_city = $tmp_county = $tmp_country='';
	    			 
	    			$found_city = false;
	    			foreach($geo_contents->result[0]->address_component as $address_component){
	    				if($address_component->type[0]!='route' && $address_component->type[0]!='postal_code'){
	    					switch($address_component->type[0]){
	    						case 'locality':
	    						case 'administrative_area_level_3':
	    							if($found_city ===false){
	    								$en_location[]= $address_component->long_name;
	    								$found_city =true;
	    							}
	    							//$tmp_city = $address_component->long_name;
	    							break;
	    						case 'administrative_area_level_1':
	    							$en_location[]= $address_component->long_name;
	    							//$tmp_county = $address_component->long_name;
	    							break;
	    						case 'country':
	    							$en_location[]= $address_component->long_name;
	    							//$tmp_country  = $address_component->long_name;
	    							break;
	    					}
	    				}
	    			}
    			}
    		}else{
    			$acWhere = trim($acWhere);
    			$acWhere = trim($acWhere, ',');
    			$acWhere = trim($acWhere);
    			$en_location = explode(',', $acWhere);    			
    			foreach ($en_location as $key => $value) {
    				$en_location[$key] = trim($value);
    			}
    			if($acWhereIDs != ""){
    				$IDs = explode(',', $acWhereIDs);
    				foreach ($IDs as $id){
    					$where = explode('-', $id);
    					$locationIDs[$where[0]] = $where[1];
    				}
    			}
    		}
    
    		if(count($en_location)>0 && sizeof($locationIDs) < 2){
    			$en_location = implode(', ',$en_location);
    			$request->setParameter('w', $en_location);
    			$request->setParameter('wids', $acWhereIDs);
    			//echo $request->getParameter('w', false); die;
    			if ($en_location && getlokalPartner::getInstanceDomain() == $user->getCountry()->getId()) {
    				$city = CityTable::getByAddress($en_location, $user->getCountry()->getId());
    			}
    			 
    			if (isset($city) ) {
    				$user->setCity($city);
    				if (getlokalPartner::getInstanceDomain() == 78) {
    					$county = CountyTable::getByAddress($en_location);
    					$user->setCounty($county);
    				}
    			}
    			if(isset($locationIDs['countryId'])){
    				$country = $locationIDs['countryId'];
    			}
    		}else{
    			if(isset($locationIDs['countryId'])){
    				$country = $locationIDs['countryId'];
    			}
    			if(isset($locationIDs['countyId'])){
    				$county = $locationIDs['countyId'];
    			}
    			if(isset($locationIDs['cityId'])){
    				$city = $locationIDs['cityId'];
    			}
    		}
    	}
    	if($city != null && $county == null){
    		$county = $city->getCounty();
    	}
    	if($county != null && $country == null){
    		$country = $county->getCountry();
    	}
    	return array($city,$county,$country);
    }

}
?>
