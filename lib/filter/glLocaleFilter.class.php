<?php
class glLocaleFilter extends sfFilter
{
  public function execute($filterChain)
  {
        $domain = sfContext::getInstance()->getRequest()->getHost();

        $user = sfContext::getInstance()->getUser();

        $user->setAttribute('country_id', 1);

        /* OLD
        
         * 
         */

        if(!in_array($user->getCulture(), sfConfig::get('app_culture_slugs'))){
            $user->setCulture('en');
        }

        $domain_array = sfConfig::get('app_domain_slugs');

        $found_flag = false;
        
        foreach($domain_array as $dom){
            if(strstr($domain, $dom) !== false){
                 $current_lang_code = sfConfig::get('app_languages_'.sfConfig::get('app_domain_to_culture_'.strtoupper($dom)));
                 if(!in_array($user->getCulture(), $current_lang_code)){
                    $user->setCulture('en');
                }
                $getlokalPartner = 'GETLOKAL_'.strtoupper($dom);
                $reflectionPartnerClass = new ReflectionClass('getlokalPartner');
                $country_id = $reflectionPartnerClass->getConstant($getlokalPartner);

                $_sUrl = 'static.getlokal.'.$dom;
                sfContext::getInstance()->getUser()->setAttribute('country_id', $country_id);
                $found_flag = true;
                break;
            }
       }
       if($found_flag === false  && strstr($domain, '.com') || strstr($domain, '.my')){
            if(!in_array($user->getCulture(), array('bg', 'en'))){
                $user->setCulture('en');
            }

            $_sUrl = 'static.getlokal.com';

            sfContext::getInstance()->getUser()->setAttribute('country_id', 1);
        }
       /*
        *    OLD
        if(!in_array($user->getCulture(), array('ro', 'bg', 'en', 'mk', 'fi', 'ru'))){
          $user->setCulture('bg');
        }

       if(strstr($domain, '.com') || strstr($domain, '.my')){
            if(!in_array($user->getCulture(), array('bg', 'en'))){
                $user->setCulture('en');
            }

            $_sUrl = 'static.getlokal.com';

            sfContext::getInstance()->getUser()->setAttribute('country_id', 1);
        }

        if(strstr($domain, '.ro') or strstr($domain, 'ro.'))
        {
          if(!in_array($user->getCulture(), array('ro', 'en')))
          {
            $user->setCulture('ro');
          }

          sfContext::getInstance()->getUser()->setAttribute('country_id', 2);
        }
        elseif(strstr($domain, '.mk') or strstr($domain, 'mk.'))
        {
          if(!in_array($user->getCulture(), array('mk', 'en')))
          {
            $user->setCulture('mk');
          }

          sfContext::getInstance()->getUser()->setAttribute('country_id', 3);
        }
        elseif((strpos($domain, 'rs') !== false))
        {
          if(!in_array($user->getCulture(), array('sr', 'en')))
          {
            $user->setCulture('sr');
          }

          $_sUrl = 'static.getlokal.rs';

          sfContext::getInstance()->getUser()->setAttribute('country_id', 4);
        }
        elseif((strpos($domain, 'fi') !== false))
        {
          if(!in_array($user->getCulture(), array('fi', 'en', 'ru')))
          {
            $user->setCulture('fi');
          }

          $_sUrl = 'static.getlokal.fi';

          sfContext::getInstance()->getUser()->setAttribute('country_id', 78);
        }
        elseif(strstr($domain, '.com'))
        {
          if(!in_array($user->getCulture(), array('bg', 'en')))
          {
            $user->setCulture('bg');
          }

          sfContext::getInstance()->getUser()->setAttribute('country_id', 1);
        }
         * 
         */



        $filterChain->execute();
  }
}
