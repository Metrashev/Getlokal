<?php
/*
 * change v1.1
 * */
class getlokalPartner
{
  CONST GETLOKAL_BG = 1;
  CONST GETLOKAL_RO = 2;
  CONST GETLOKAL_MK = 3;
  CONST GETLOKAL_RS = 4;
  CONST GETLOKAL_FI = 78;
  CONST GETLOKAL_CZ = 63;
  CONST GETLOKAL_SK = 202;
  CONST GETLOKAL_HU = 104;
  CONST GETLOKAL_PT = 180;
  CONST GETLOKAL_ME = 151;
  CONST GETLOKAL_RU = 184;

  public static function getInstance($culture = null)
  {
    if (!$culture)
    {
      $culture = sfContext::getInstance ()->getUser()->getCulture();
    }
    if ($culture == 'bg')
    {
       return self::GETLOKAL_BG;
    }
    elseif ($culture == 'ro')
    {
       return self::GETLOKAL_RO;
    }
    elseif ($culture == 'mk' )
    {
       return self::GETLOKAL_MK;
    }
    elseif ($culture == 'sr' )
    {
       return self::GETLOKAL_RS;
    }
    elseif ($culture == 'fi' )
    {
       return self::GETLOKAL_FI;
    }
    elseif ($culture == 'cs' )
    {
       return self::GETLOKAL_CZ;
    }
    elseif ($culture == 'sk' )
    {
       return self::GETLOKAL_SK;
    }
    elseif ($culture == 'hu' )
    {
       return self::GETLOKAL_HU;
    }
    elseif ($culture == 'pt' )
    {
       return self::GETLOKAL_PT;
    }
    elseif ($culture == 'me' )
    {
       return self::GETLOKAL_ME;
    }
    elseif ($culture == 'ru' )
    {
       return self::GETLOKAL_RU;
    }

    $domain = sfContext::getInstance()->getRequest()->getHost();

    if (strstr($domain, '.ro') or strstr($domain, 'ro.')) return self::GETLOKAL_RO;
    if (strstr($domain, '.mk') or strstr($domain, 'mk.')) return self::GETLOKAL_MK;
    if (strstr($domain, '.rs') or strstr($domain, 'rs.')) return self::GETLOKAL_RS;
    if (strstr($domain, '.fi') or strstr($domain, 'fi.')) return self::GETLOKAL_FI;
    if (strstr($domain, '.cz') or strstr($domain, 'cz.')) return self::GETLOKAL_CZ;
    if (strstr($domain, '.sk') or strstr($domain, 'sk.')) return self::GETLOKAL_SK;
    if (strstr($domain, '.hu') or strstr($domain, 'hu.')) return self::GETLOKAL_HU;
    if (strstr($domain, '.pt') or strstr($domain, 'pt.')) return self::GETLOKAL_PT;
    if (strstr($domain, '.me') or strstr($domain, 'me.')) return self::GETLOKAL_ME;
    if (strstr($domain, '.ru') or strstr($domain, 'ru.')) return self::GETLOKAL_RU;
    if (strstr($domain, '.com')) return self::GETLOKAL_BG;
    if (strstr($domain, '.my')) return self::GETLOKAL_BG;
  }



  public static function getEmbeddedLanguages($getparner = null)
  {
    if (!$getparner)
    {
      $getparner = self::getInstance();
    }
    switch ($getparner){
        case self::GETLOKAL_BG:
            return array('bg', 'en');
            break;
        case self::GETLOKAL_RO:
            return array('ro', 'en');
            break;
        case self::GETLOKAL_MK:
            return array('mk', 'en');
            break;
        case self::GETLOKAL_RS:
            return array('sr', 'en');
            break;
        case self::GETLOKAL_FI:
            return array('fi', 'en', 'ru');
            break;
        case self::GETLOKAL_CZ:
            return array('cs', 'en', 'sk');
            break;
        case self::GETLOKAL_SK:
            return array('sk', 'en', 'cs');
            break;
        case self::GETLOKAL_HU:
            return array('hu', 'en');
            break;
        case self::GETLOKAL_PT:
            return array('pt', 'en');
            break;
        case self::GETLOKAL_ME:
        	return array('me','en');
        	break;
        case self::GETLOKAL_RU:
        	return array('ru','en');
        	break;
    }
    return array('bg', 'en');
  }

  public static function getLanguageClass($getparner = null){
    if (!$getparner)
    {
      $getparner = self::getInstance();
    }
    switch ($getparner){
        case self::GETLOKAL_BG:
            return 'Bg';
            break;
        case self::GETLOKAL_RO:
            return 'Ro';
            break;
        case self::GETLOKAL_MK:
            return 'Mk';
            break;
        case self::GETLOKAL_RS:
            return 'Sr';
            break;
        case self::GETLOKAL_FI:
            return 'Fi';
            break;
        case self::GETLOKAL_CZ:
            return 'Cs';
            break;
        case self::GETLOKAL_SK:
            return 'Sk';
            break;
        case self::GETLOKAL_HU:
            return 'Hu';
            break;
        case self::GETLOKAL_PT:
            return 'Pt';
            break;
        case self::GETLOKAL_ME:
        	return 'Me';
        	break;
        case self::GETLOKAL_RU:
        	return 'Ru';
        	break;
    }
    return 'Bg';
  }

  public static function getEmailAddress($getparner = null)
  {
    if (!$getparner)
    {
      $getparner = self::getInstance();
    }
    switch ($getparner){

        case self::GETLOKAL_BG:
            return 'info@getlokal.com';
            break;
        case self::GETLOKAL_RO:
            return 'romania@getlokal.com';
            break;
        case self::GETLOKAL_MK:
            return 'macedonia@getlokal.com';
            break;
        case self::GETLOKAL_RS:
            return 'serbia@getlokal.com';
            break;
        case self::GETLOKAL_FI:
            return 'finland@getlokal.com';
            break;
        case self::GETLOKAL_CZ:
            return 'czech@getlokal.com';
            break;
        case self::GETLOKAL_SK:
            return 'slovakia@getlokal.com';
            break;
        case self::GETLOKAL_HU:
            return 'hungary@getlokal.com';
            break;
        case self::GETLOKAL_PT:
            return 'portugal@getlokal.com';
            break;
    }
  }

  public static function getInstanceDomain($culture = null)
  {
    $domain = sfContext::getInstance()->getRequest()->getHost();

    if (strstr($domain, '.ro') or strstr($domain, 'ro.')) return self::GETLOKAL_RO;
    if (strstr($domain, '.mk') or strstr($domain, 'mk.')) return self::GETLOKAL_MK;
    if (strstr($domain, '.rs') or strstr($domain, 'rs.')) return self::GETLOKAL_RS;
    if (strstr($domain, '.fi') or strstr($domain, 'fi.')) return self::GETLOKAL_FI;
    if (strstr($domain, '.cz') or strstr($domain, 'cz.')) return self::GETLOKAL_CZ;
    if (strstr($domain, '.sk') or strstr($domain, 'sk.')) return self::GETLOKAL_SK;
    if (strstr($domain, '.hu') or strstr($domain, 'hu.')) return self::GETLOKAL_HU;
    if (strstr($domain, '.pt') or strstr($domain, 'pt.')) return self::GETLOKAL_PT;
    if (strstr($domain, '.me') or strstr($domain, 'me.')) return self::GETLOKAL_ME;
    if (strstr($domain, '.ru') or strstr($domain, 'ru.')) return self::GETLOKAL_RU;
    if (strstr($domain, '.com') or strstr($domain, 'com.')) return self::GETLOKAL_BG;
    if (strstr($domain, '.my') or strstr($domain, 'my.')) return self::GETLOKAL_BG;   
    // this is for localhost
    return self::GETLOKAL_BG;
  }

  public static function getDefaultCulture($getparner = null)
  {
    if (!$getparner)
    {
      $getparner = self::getInstance();
    }
    switch ($getparner){

        case self::GETLOKAL_BG:
            return 'bg';
            break;
        case self::GETLOKAL_RO:
            return 'ro';
            break;
        case self::GETLOKAL_MK:
            return 'mk';
            break;
        case self::GETLOKAL_RS:
            return 'sr';
            break;
        case self::GETLOKAL_FI:
            return 'fi';
            break;
        case self::GETLOKAL_CZ:
            return 'cz';
            break;
        case self::GETLOKAL_SK:
            return 'sk';
            break;
        case self::GETLOKAL_HU:
            return 'hu';
            break;
        case self::GETLOKAL_PT:
            return 'pt';
            break;
        case self::GETLOKAL_ME:
        	return 'me';
        	break;
        case self::GETLOKAL_RU:
        	return 'ru';
        	break;
    }
    return 'bg';
  }


  public static function getDomains()
  {
    return array('.com', '.ro', '.mk', '.rs', '.my', '.fi', '.cz', '.sk', '.hu', '.pt' , '.me' , '.ru');
  }

  /**
   * Returns default city id based on domain
   */
  public static function getDefaultCity()
  {
    $partner = self::getInstanceDomain();

    switch ($partner)
    {
      case self::GETLOKAL_BG: return 3341;
      case self::GETLOKAL_RO: return 4888;
      case self::GETLOKAL_RS: return 50145;
      case self::GETLOKAL_MK: return 50060;
      case self::GETLOKAL_FI: return 54087;

      case self::GETLOKAL_CZ: return 53534;
      case self::GETLOKAL_SK: return 53535;
      case self::GETLOKAL_HU: return 55261;
      case self::GETLOKAL_PT: return 58002;
      case self::GETLOKAL_ME: return 50330;
      case self::GETLOKAL_RU: return 50330;
    }

    // default return BG
    return 3341;
  }
  
  public static function getAllPartners() {
      return array(self::GETLOKAL_BG, self::GETLOKAL_RO, self::GETLOKAL_MK, self::GETLOKAL_RS, self::GETLOKAL_FI, self::GETLOKAL_CZ, self::GETLOKAL_SK, self::GETLOKAL_HU, self::GETLOKAL_PT, self::GETLOKAL_ME, self::GETLOKAL_RU);
  }

}
?>
