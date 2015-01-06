<?php

class AbuseType
{
    // Properties and constants
	const UNSPECIFIED = 0;
    const ILLEGAL = 1;
    const OFFENSIVE = 2;
    const COPYRIGHT = 3;
    const INCORRECT = 4;
	const OTHER = 5;
    
    const REVIEW = 'review';
    const PICTURE = 'picture';
    
	
	public static $AbuseTypeChoices = array(
		self::UNSPECIFIED => 'Choose... '
		, self::ILLEGAL => 'Illegal'
		, self::OFFENSIVE => 'Offensive'
		, self::COPYRIGHT => 'Copyright'
		, self::INCORRECT => 'Incorrect'
		, self::OTHER => 'Other'
	);
	
	public static $ReportAbuseMailTitles = array(
		self::REVIEW => 'Report inappropriate content!'
		, self::PICTURE => 'Report inappropriate photo!'
	);
    
    // Constructor
    
    // Methods defined here
	public static function getI18NChoices(array $arChoices){
		if (sfConfig::get('sf_i18n')){
			// make confirm a choice (i18n solution is very ugly, is there a better way? TODO)
			$i18n = sfContext::getInstance()->getI18N();
			foreach ($arChoices as $k => $sChoice){
				$i18nChoices[$k] = $i18n->__($sChoice, null, 'contactus');
			}
			return $i18nChoices;
		}else{
			return $arChoices;
		}
	}
	
	public static function GetAbuseTypeChoicesList(){
		return self::getI18NChoices(self::$AbuseTypeChoices);
	}
	
	public static function GetPosibleAbuseTypeChoiseList(){
		$nUnspecifiedKey = self::UNSPECIFIED;
		$arChoices = self::getI18NChoices(self::$AbuseTypeChoices);
		if(isset($arChoices[$nUnspecifiedKey])){
			unset($arChoices[$nUnspecifiedKey]);
		}
		
		return array_keys($arChoices);
	}
	
	public static function GetReportAbuseMailTitle($sObjectCode){
		$arMailTitle = self::$ReportAbuseMailTitles;
		if(isset($arMailTitle[$sObjectCode]))
			return $arMailTitle[$sObjectCode];
		
		return 'Report abuse!';
	}
	
	public static function GetCurrentAbuseTypeIDReference($nAbuseTypeID){
		$arAbuseTypes = self::$AbuseTypeChoices;
		if(isset($arAbuseTypes[$nAbuseTypeID])){
			return $arAbuseTypes[$nAbuseTypeID];
		}
		
		return false;
	}
}

?>
