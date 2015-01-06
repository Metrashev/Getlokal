<?php
class glLocaleFilter extends sfFilter
{
    public function execute($filterChain)
    {
        $domain = sfContext::getInstance()->getRequest()->getHost();

        $user = sfContext::getInstance()->getUser();
        $_sUrl = '';

        if(sfContext::getInstance()->getRequest()->getParameter('from')){
            sfContext::getInstance()->getResponse()->setCookie('from', sfContext::getInstance()->getRequest()->getParameter('from'), time()+60*60*24*30, '/');
        }

        $tld = 'com';

        $user->setAttribute('country_id', 1);

        if(!in_array($user->getCulture(), sfConfig::get('app_culture_slugs'))){
            $user->setCulture('en');
        }
        
        $domain_array = sfConfig::get('app_domain_slugs');
        $found_flag = false;
        foreach($domain_array as $dom){
            if(strstr($domain, $dom) !== false){
                 $current_lang_code = sfConfig::get('app_languages_'.sfConfig::get('app_domain_to_culture_'.strtoupper($dom)));
                 if(!in_array($user->getCulture(), $current_lang_code)){
                  //  $user->setCulture('en');
                      $user->setCulture(sfConfig::get('app_domain_to_culture_'.strtoupper($dom)));
                }
                $getlokalPartner = 'GETLOKAL_'.strtoupper($dom);
                $reflectionPartnerClass = new ReflectionClass('getlokalPartner');
                $country_id = $reflectionPartnerClass->getConstant($getlokalPartner);
                $_sUrl = 'static.getlokal.'.$dom;
                sfContext::getInstance()->getUser()->setAttribute('country_id', $country_id);
                sfContext::getInstance()->getUser()->getCountry();
                $found_flag = true;
                break;
            }
       }
       if($found_flag === false  && strstr($domain, '.com') || strstr($domain, '.my')){
            if(!in_array($user->getCulture(), array('bg', 'en'))){
                $user->setCulture('bg');
            }

            $_sUrl = 'static.getlokal.com';

            sfContext::getInstance()->getUser()->setAttribute('country_id', 1);
        }

       /*
       if(strstr($domain, '.com') || strstr($domain, '.my')){
            if(!in_array($user->getCulture(), array('bg', 'en'))){
                $user->setCulture('en');
            }

            $_sUrl = 'static.getlokal.com';

            sfContext::getInstance()->getUser()->setAttribute('country_id', 1);
        }
        * 
        */
        
        /*   OLD
        if(!in_array($user->getCulture(), array('ro', 'bg', 'en', 'mk', 'sr', 'fi', 'ru'))){
            $user->setCulture('bg');
        }

        if(strstr($domain, '.ro') or strstr($domain, 'ro.')){
            if(!in_array($user->getCulture(), array('ro', 'en'))){
                $user->setCulture('ro');
            }
            $_sUrl = 'static.getlokal.ro';
            sfContext::getInstance()->getUser()->setAttribute('country_id', 2);
        }
        elseif(strstr($domain, '.mk') or strstr($domain, 'mk.')){
            if(!in_array($user->getCulture(), array('mk', 'en'))){
                $user->setCulture('mk');
            }

            $_sUrl = 'static.getlokal.mk';

            sfContext::getInstance()->getUser()->setAttribute('country_id', 3);
        }
        elseif((strpos($domain, 'rs') !== false)){
            if(!in_array($user->getCulture(), array('sr', 'en'))){
                $user->setCulture('sr');
            }

            $_sUrl = 'static.getlokal.rs';

            sfContext::getInstance()->getUser()->setAttribute('country_id', 4);
        }
        elseif((strpos($domain, 'fi') !== false)){
            if(!in_array($user->getCulture(), array('fi', 'en', 'ru')))
            {
                $user->setCulture('fi');
            }

            $_sUrl = 'static.getlokal.fi';

            sfContext::getInstance()->getUser()->setAttribute('country_id', 78);
        }
        elseif(strstr($domain, '.com')){
            if(!in_array($user->getCulture(), array('bg', 'en')))
            {
                $user->setCulture('bg');
            }

            $_sUrl = 'static.getlokal.com';

            sfContext::getInstance()->getUser()->setAttribute('country_id', 1);
        }
        */
        
        sfConfig::set('app_server_static_url', (@$_SERVER['HTTPS'])? 'https://'.$_sUrl:'http://'.$_sUrl);
        //sfConfig::set('app_server_static_url', str_replace('%iso_code%', $tld, sfConfig::get('app_server_static_url')));

        $filterChain->execute();
    }
}
