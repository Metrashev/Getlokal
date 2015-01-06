<?php
class SearchProviderCompany
{
  public $Id;
  public $Title;
  public $Address;
  public $CountryId;
  public $CountyId;
  public $CityId;
  public $Longitude;
  public $Latitude;
  public $LatRad;
  public $LngRad;
  public $StarRating;
  public $Sector;
  public $SectorId;
  public $Classification;
  public $ClassificationId;
  public $Phone;
  public $Slug;
  public $Overlay;
  public $EventCount = 0;
  public $OffersCount = 0;
  
  public $TotalObjects;
  
  public $Location;
    
  public $ReviewCount;
  public $ReviewText;
  public $Image = null;
  public $ImageCount;
  public $VideoCount;
  public $DescriptionCount;
  public $DetailedDescriptionCount;
  public $IsPPP;
  public $distanceFomUser;
  public $distanceFomSearchCenter;

  
  public $SearchedTitle;
  public $SearchedDescription;
  public $SearchedClassification;
  public $SearchedClassificationKeywords;
  public $SearchedDetailDesct;
  public $SearchedReviews;
  public $SearchedImages;
  public $SearchedVideos;
  
  public $BuiltInWeightAndStart;
  public $MixedWeight;
  public $IsPPPWeight;
  public $RankSettings;
  
  protected $_maxStarsRating = 5;
  
  /*
   * Getters Start
   */
  public function getId() {
      return $this->Id;
  }

  public function getTitle() {
      return $this->Title;
  }
  // function in use
  public function getCompanyTitle() {
  	return $this->Title;
  }

  public function getAddress() {
      return $this->Address;
  }

  public function getCountryId() {
      return $this->CountryId;
  }

  public function getCountyId() {
      return $this->CountyId;
  }

  public function getCity() {
      return $this->city;
  }
  
  public function getCityId() {
  	return $this->CityId;
  }

  public function getLongitude() {
      return $this->Longitude;
  }
  // function in use
  public function getLng() {
  	return $this->Longitude;
  }

  public function getLatitude() {
      return $this->Latitude;
  }
  // function in use
  public function getLat() {
  	return $this->Latitude;
  }

  public function getLatRad() {
      return $this->LatRad;
  }

  public function getLngRad() {
      return $this->LngRad;
  }

  public function getStarRating() {
      return $this->StarRating;
  }
  
  // function in use
  public function getRating() {
  	return round(($this->StarRating / $this->_maxStarsRating) * 100);
  }

  public function getSectorId() {
      return $this->SectorId;
  }

  public function getClassificationId() {
      return $this->ClassificationId;
  }

  public function getReviewsCount() {
      return $this->ReviewCount;
  }
  
  public function getNumberOfReviews() {
      return $this->ReviewCount;
  }

  public function getImageCount() {
      return $this->ImageCount;
  }

  public function getVideoCount() {
      return $this->VideoCount;
  }

  public function getDescriptionCount() {
      return $this->DescriptionCount;
  }

  public function getDetailedDescriptionCount() {
      return $this->DetailedDescriptionCount;
  }

  public function getIsPPP() {
      return $this->IsPPP;
  }
  // function in use
  public function getActivePPPService($flag = null){
	  return $this->IsPPP;
  }

  public function getDistanceFomUser() {
      return $this->distanceFomUser;
  }

  public function getDistanceFomSearchCenter() {
      return $this->distanceFomSearchCenter;
  }
  
  public function getSlug() {
  	return $this->Slug;
  }
  
  public function getPhone() {
  	return $this->Phone;
  }
  
  public function getLocation() {
  	return $this->Location;
  }
  
  public function getReviewsText(){
  	return $this->ReviewText;
  }
  
  public function getOfferCount(){
  	return $this->OffersCount;
  }
  
  public function getIcon(){
  	return 'marker_' . $this->getSectorId();
  }
  
  public function getSmallIcon(){
  	$icon = "small_marker_".$this->getSectorId();
  	if(!$this->getActivePPPService(true)){
  		$icon = "gray_".$icon;
  	}
  	return $icon;
  }
  
  public function getTotalObjects(){
  	return $this->TotalObjects;
  }
  
  public function getImageURL($size = 0){
  	$sizes = array('150x150', '260x195', '45x45', '560x420', '800x0');
  	$directory = '';
  	if(!is_null($this->Image)){
  		if(key_exists($size, $sizes)){
  			$directory = '/uploads/photo_gallery/';
	  		$primes = array(131, 53, 37);
	  		foreach($primes as $prime){
	  			$directory .= $this->md5Hash($this->Image['filename'], $prime). '/';
	  		}
	  		$directory .= $sizes[$size]."/".$this->Image['filename'];
  		}
  	}
  	return $directory;
  }
  
  public function getThumb($size = 0){
  	$sizes = array('150x150', '260x195', '45x45', '560x420', '800x0');
  	$directory = '';
  	if(!is_null($this->Image) && $this->Image != ''){
  		if(key_exists($size, $sizes)){
  			$directory = '/uploads/photo_gallery/';
  			$primes = array(131, 53, 37);
  			foreach($primes as $prime){
  				$directory .= $this->md5Hash($this->Image['filename'], $prime). '/';
  			}
  			$directory .= $sizes[$size]."/".$this->Image['filename'];
  		}
  	}else{
  		return '/images/gui/default-place-image-list_150x100.jpg';
  	}
  	return $directory;
  }
  
  public function getUri()
  {
  	return '@company?slug=' . $this->getSlug () . '&city=' . $this->getCity ()->getSlug ();
  }
  
  public function getClassification()
  {
  	return $this->Classification['title'];
  }

  public function getClassificationUri()
  {
  	return '@classification?slug=' . $this->Classification['slug'] . '&sector=' . $this->Sector['slug'] . '&city=' . $this->getCity ()->getSlug ();
  }
  
  public function getOverlay()
  {
  	return $this->Overlay;
  }
  
  public function getEventCount(){
  	return $this->EventCount;
  }

  private function md5Hash($fileName, $count)
  {
  	$fileNameParts = pathinfo($fileName);
  	$fileName = $fileNameParts['filename'];
  	  	 
  	/*echo $fileName." - $count<br /><br />";
  	echo md5($fileName)."<br />";
  	echo substr(md5($fileName), 0, 8)."<br />";
  	echo (base_convert(substr(md5($fileName), 0, 8), 16, 10))."<br />";
  	echo (base_convert(substr(md5($fileName), 0, 8), 16, 10) % $count)."<br /><br /><br />";*/

  	return base_convert(substr(md5($fileName), 0, 8), 16, 10) % $count;
  }
  
  public function getJSObject($type = 'web'){
  	$return = array('id' => $this->getId(),
  			'title' => $this->getTitle(),
  			'score' => $this->MixedWeight,
  			'kms' => $this->distanceFomSearchCenter,
  			'latitude' => $this->getLat(),
  			'longitude' => $this->getLng(),
  			'icon' => $this->getSmallIcon(),
  			'html' => '',
  			'overlay' => $this->getOverlay(),
  			'is_ppp' => $this->getIsPPP(),
  			'totalObjects' => $this->getTotalObjects() );
  	if($type != 'web'){
	  	// FOR MOBILE 
  		$return['kms'] = $this->distanceFomUser;
  	}
  	return $return;
  }
  
  ///////////////////////////////////////
  
  /*
   * Getters End
   */
    public static function FromResource($_resource, $rankingSet)
  {
    $companies = array();
    while ($row = mysqli_fetch_assoc($_resource)) 
    {    	
      $comp = new SearchProviderCompany();
      $comp->Id = $row['doc_id'];
      $comp->Title = $row['localizedtitle'];
      $comp->Address = $row['address'];
      $comp->CountryId = $row['country_id'];
      $comp->CountyId = $row['county_id'];
      $comp->CityId = $row['city_id'];
      $comp->Longitude = $row['longitude'];
      $comp->Latitude = $row['latitude'];
      $comp->LatRad = $row['lat_rad'];
      $comp->LngRad = $row['lng_rad'];
      $comp->StarRating = $row['star_rating'];
      $comp->SectorId = $row['sector_id'];
      $comp->ClassificationId = $row['classification_id'];
      
      //Formats location objects
      #var_dump($row['locationData']); die;
      $comp->city = is_array($row['locationData']) ? $row['locationData'][0] : $row['locationData'];

      $comp->distanceFomUser = 0;
      $comp->distanceFomSearchCenter = 0;
      if(isset($row['user_distance']))
        $comp->distanceFomUser = $row['user_distance'];

      if(isset($row['distance_from_center']))
        $comp->distanceFomSearchCenter = $row['distance_from_center'];

      $comp->ReviewCount = $row['rev_cnt'];
      //$comp->ReviewText = $row['rev_text'];
      $comp->ImageCount = $row['image_cnt'];
      $comp->VideoCount = $row['video_cnt'];
      $comp->IsPPP = $row['is_ppp_cnt'];
      $comp->DescriptionCount = $row['description_cnt'];
      $comp->DetailedDescriptionCount = $row['detaileddescr_cnt'];


      $comp->SearchedTitle = $row['searchtitle'];
      $comp->BuiltInWeightAndStart = $row['weightfactor'];
      $comp->MixedWeight = $row['mixedweight'];
      $comp->IsPPPWeight = $row['ispppweight'];
      $comp->RankSettings = $rankingSet;
      
      $companies[] = $comp;
    }
    
    return $companies;
  }
  
  public static function FromRow($row, $pRankingSet)
  {
    $comp = new SearchProviderCompany();
    $comp->Id = $row['doc_id'];
    $comp->Title = $row['localizedtitle'];
    $comp->Address = $row['address'];
    $comp->CountryId = $row['country_id'];
    $comp->CountyId = $row['county_id'];
    $comp->CityId = $row['city_id'];
    $comp->Longitude = $row['longitude'];
    $comp->Latitude = $row['latitude'];
    $comp->LatRad = $row['lat_rad'];
    $comp->LngRad = $row['lng_rad'];
    $comp->StarRating = $row['star_rating'];
    $comp->SectorId = $row['sector_id'];
    $comp->ClassificationId = $row['classification_id'];
    $comp->OffersCount = $row['offers_cnt'];
    
    //Formats location objects
    #var_dump($row['locationData']); die;
    $comp->city = is_array($row['locationData']) ? $row['locationData'][0] : $row['locationData'];
    
    
    if(isset($row['rev_cnt']))
      $comp->ReviewCount = $row['rev_cnt'];
    /*if(isset($row['rev_text']))
      $comp->ReviewText = $row['rev_text'];*/
    if(isset($row['image_cnt']))
      $comp->ImageCount = $row['image_cnt'];
    if(isset($row['video_cnt']))
      $comp->VideoCount = $row['video_cnt'];

    $comp->distanceFomUser = 0;
    $comp->distanceFomSearchCenter = 0;
    if(isset($row['user_distance']))
        $comp->distanceFomUser = $row['user_distance'];

    if(isset($row['distance_from_center']))
        $comp->distanceFomSearchCenter = $row['distance_from_center'];
      
    $comp->IsPPP = $row['is_ppp_cnt'];
    $comp->SearchedTitle = $row['searchtitle'];
    
    $comp->BuiltInWeightAndStart = $row['weight_factor'];
    //$comp->MixedWeight = $row['mixedweight'];
    //$comp->IsPPPWeight = $row['ispppweight'];
    $comp->RankSettings = $pRankingSet;
      
    
    return $comp;
  }
  
  
  //functions from Doctrine Company model
  
  public function getDisplayAddress($culture = null)
  {
  	if (! $culture) {
  		$culture = sfContext::getInstance ()->getUser ()->getCulture ();
  	}
  	$partner_class = ucfirst(getlokalPartner::getDefaultCulture ());
  	$method = "getDisplayAddress{$partner_class}";
  	if (method_exists ( $this, $method )) {
  		return $this->$method ( $culture );
  	}
  	else {
  		$address = array ();
  
  		$company_location = $this->getLocation ();
  
  		$address [] .= $this->getCity ()->getCityNameByCulture ( 'en' );
  
  		$street = $company_location->getStreet ();
  		$number = $company_location->getStreetNumber ();
  		if ($number) {
  			$street .= ' ' . $number;
  		}
  
  		$address [] = $street;
  
  		return implode ( ', ', $address );
  	}
  }
  
  public function getDisplayAddressBg($culture = null)
  {
  
  	$add = '';
  	$address = array ();
  	if (is_null ( $culture )) {
  		$culture = sfContext::getInstance ()->getUser ()->getCulture ();
  	}
  	$company_location = $this->getLocation ();
  
  	$locType = $company_location->getLocationType ();
  	$strType = $company_location->getStreetTypeId ();
  	$locTypeList = AddressTypeBg::getInstance ( $culture );
  	$locTypeDispl = ($locType && isset ( $locTypeList [$locType] )) ? $locTypeList [$locType] : '';
  	$strTypeDispl = ($strType && isset ( $locTypeList [$strType] )) ? $locTypeList [$strType] : '';
  
  	$address [] .= $this->getCity ()->getCityNameByCulture ( $culture );
  
  	$street = $company_location->getStreet ();
  	if ($neighbourhood = $company_location->getNeighbourhood ()) {
  		if ('en' == $culture) {
  			$neighbourhood = TransliterateBg::toLatin ( $neighbourhood );
  		}
  		$add = $locTypeDispl . ' ' . ucwords ( $neighbourhood );
  		$number = $company_location->getStreetNumber ();
  		if ($number && empty ( $street )) {
  			$add .= ' ' . $number;
  		}
  
  		$address [] = $add;
  	}
  
  	if ($street) {
  		$add = '';
  		if ('en' != $culture) {
  			$add .= ' ' . $strTypeDispl . ' ';
  		}
  
  		if (empty ( $neighbourhood ) && 'en' != $culture && $locTypeDispl != '' && $strTypeDispl == '') {
  			$add .= ' ' . $locTypeDispl;
  		}
  
  		if ('en' == $culture) {
  			$street = TransliterateBg::toLatin ( $street );
  		}
  		$add .= $street;
  		if ('en' == $culture) {
  			$add .= ' ' . $strTypeDispl;
  		}
  		if (empty ( $neighbourhood ) && 'en' == $culture && $locTypeDispl != '' && $strTypeDispl == '') {
  			$add .= ' ' . $locTypeDispl;
  		}
  		$number = $company_location->getStreetNumber ();
  		if ($number) {
  			$add .= ' ' . $number;
  		}
  		$address [] = $add;
  	}
  	else {
  		$fullAdress = $company_location->getFullAddress ( $culture );
  		if ($fullAdress) {
  			$address [] = $fullAdress;
  		}
  	}
  
  	return implode ( ', ', $address );
  }
  
  public function getDisplayAddressMk($culture = null)
  {
  	$add = '';
  	$address = array ();
  	if (is_null ( $culture )) {
  		$culture = sfContext::getInstance ()->getUser ()->getCulture ();
  	}
  	$company_location = $this->getLocation ();
  
  	if (! $company_location->getStreet () && ($company_location->getFullAddress () || $company_location->getFullAddressEn ())) {
  		return $culture == 'en' ? $company_location->getFullAddressEn () : $company_location->getFullAddress ();
  	}
  
  	$locType = $company_location->getLocationType ();
  	$strType = $company_location->getStreetTypeId ();
  	$locTypeDispl = '';
  	$strTypeDispl = '';
  	$locTypeList = AddressTypeMk::getInstance ( $culture );
  	if ($strType) {
  		$strTypeDispl = ((isset ( $locTypeList [$strType] ) && $strType) ? $locTypeList [$strType] : '');
  	}
  	if ($locType) {
  		$locTypeDispl = ((isset ( $locTypeList [$locType] ) && $locType) ? $locTypeList [$locType] : '');
  	}
  
  	$address [] .= $this->getCity ()->getCityNameByCulture ( $culture );
  
  	$street = $company_location->getStreet ();
  	if ($neighbourhood = $company_location->getNeighbourhood ()) {
  		if ('en' == $culture) {
  			$neighbourhood = TransliterateMk::toLatin ( $neighbourhood );
  		}
  		$add = $locTypeDispl . ' ' . ucwords ( $neighbourhood );
  		$number = $company_location->getStreetNumber ();
  		if ($number && empty ( $street )) {
  			$add .= ' ' . $number;
  		}
  
  		$address [] = $add;
  	}
  
  	if ($street) {
  		$add = '';
  		if ('en' != $culture) {
  			$add .= ' ' . $strTypeDispl . ' ';
  		}
  
  		if (empty ( $neighbourhood ) && 'en' != $culture && $locTypeDispl != '' && $strTypeDispl == '') {
  			$add .= ' ' . $locTypeDispl;
  		}
  
  		if ('en' == $culture) {
  			$street = TransliterateMk::toLatin ( $street );
  		}
  		$add .= $street;
  		if ('en' == $culture) {
  			$add .= ' ' . $strTypeDispl;
  		}
  		if (empty ( $neighbourhood ) && 'en' == $culture && $locTypeDispl != '' && $strTypeDispl == '') {
  			$add .= ' ' . $locTypeDispl;
  		}
  		$number = $company_location->getStreetNumber ();
  		if ($number) {
  			$add .= ' ' . $number;
  		}
  		$address [] = $add;
  	}
  	else {
  		$fullAdress = $company_location->getFullAddress ( $culture );
  		if ($fullAdress) {
  			$address [] = $fullAdress;
  		}
  	}
  
  	return implode ( ', ', $address );
  }
  
  public function getDisplayAddressRo($culture = null)
  {
  	$add = '';
  	$address = array ();
  	$i18n = sfContext::getInstance()->getI18N();
  	if (is_null ( $culture )) {
  		$culture = sfContext::getInstance ()->getUser ()->getCulture ();
  	}
  	$company_location = $this->getLocation ();
  
  	$locType = $company_location->getLocationType ();
  	$strType = $company_location->getStreetTypeId ();
  	$locTypeList = AddressTypeRo::getInstance ( $culture );
  
  	$locTypeDispl = ($locType && isset ( $locTypeList [$locType] )) ? $locTypeList [$locType] : '';
  	$strTypeDispl = ($strType && isset ( $locTypeList [$strType] )) ? $locTypeList [$strType] : '';
  
  	$street = $company_location->getStreet ();
  
  	if ($neighbourhood = $company_location->getNeighbourhood ()) {
  		$add = $i18n->__(' - Neighbourhood ', null, 'company') . ucwords ( $neighbourhood );
  		$number = $company_location->getStreetNumber ();
  		if ($number && empty ( $street )) {
  			$add .= ' ' . $number;
  		}
  	}
  	$address [] = $this->getCity ()->getCityNameByCulture ( $culture ) . $add;
  	$add = '';
  
  	if ($street) {
  		$add = '';
  		if ('en' != $culture) {
  			$add .= ' ' . $strTypeDispl . ' ';
  		}
  		if (empty ( $neighbourhood ) && 'en' != $culture) {
  			$add .= ' ';
  		}
  		$add .= $street;
  		if ('en' == $culture) {
  			$add .= ' ' . $strTypeDispl;
  		}
  		$number = $company_location->getStreetNumber ();
  		if ($number) {
  			$add .= ' ' . $number;
  		}
  		$address [] = $add;
  	}
  	else {
  		$fullAdress = $company_location->getFullAddress ( $culture );
  		if ($fullAdress) {
  			$address [] = $fullAdress;
  		}
  	}
  
  	return implode ( ', ', $address );
  
  }
  public function getDisplayAddressFi($culture = null)
  {
  	$add = '';
  	$address = array ();
  	if (is_null ( $culture )) {
  		$culture = sfContext::getInstance ()->getUser ()->getCulture ();
  	}
  	$company_location = $this->getLocation ();
  
  	$locType = $company_location->getLocationType ();
  	$strType = $company_location->getStreetTypeId ();
  	$locTypeList = AddressTypeFi::getInstance ( $culture );
  
  	$locTypeDispl = ($locType && isset ( $locTypeList [$locType] )) ? $locTypeList [$locType] : '';
  	$strTypeDispl = ($strType && isset ( $locTypeList [$strType] )) ? $locTypeList [$strType] : '';
  
  
  	if($culture == 'ru'){
  		$street = TransliterateFi::toRu($company_location->getStreet ());
  	}
  	elseif($culture == 'en'){
  		$street = TransliterateFi::toLatin($company_location->getStreet ());
  	}
  	else{
  		$street = $company_location->getStreet ();
  	}
  
  	if ($neighbourhood = $company_location->getNeighbourhood ()) {
  		$add = ' - Sector ' . ucwords ( $neighbourhood );
  		$number = $company_location->getStreetNumber ();
  		if ($number && empty ( $street )) {
  			$add .= ' ' . $number;
  		}
  	}
  	$address [] = $this->getCity ()->getCityNameByCulture ( $culture ) . $add;
  	$add = '';
  
  	if ($street) {
  		$add = '';
  		if ('ru' == $culture) {
  			$add .= ' ' . $strTypeDispl . ' ';
  		}
  		if (empty ( $neighbourhood ) && 'ru' == $culture) {
  			$add .= ' ';
  		}
  		$add .= $street;
  		if ('ru' != $culture) {
  			$add .= ' ' . $strTypeDispl;
  		}
  		$number = $company_location->getStreetNumber ();
  		if ($number) {
  			$add .= ' ' . $number;
  		}
  		$address [] = $add;
  	}
  
  
  	if($culture == 'ru'){
  		$fullAdress = TransliterateFi::toRu($company_location->getFullAddress());
  	}
  	elseif($culture == 'en'){
  		if($company_location->getFullAddressEn() !=''){
  			$fullAdress = $company_location->getFullAddressEn();
  		}
  		else{
  			$fullAdress = TransliterateFi::toLatin($company_location->getFullAddress());
  		}
  	}
  	else{
  		$fullAdress = $company_location->getFullAddress();
  	}
  
  	//$fullAdress = $company_location->getFullAddress ($culture);
  	if (!$street and $fullAdress) {
  		$address [] = $fullAdress;
  	}
  
  	return implode ( ', ', $address );
  
  }
  public function getDisplayAddressCs($culture = null)
  {
  	$add = '';
  	$address = array ();
  	if (is_null ( $culture )) {
  		$culture = sfContext::getInstance ()->getUser ()->getCulture ();
  	}
  	$company_location = $this->getLocation ();
  
  	$locType = $company_location->getLocationType ();
  	$strType = $company_location->getStreetTypeId ();
  	$locTypeList = AddressTypeCs::getInstance ( $culture );
  
  	$locTypeDispl = ($locType && isset ( $locTypeList [$locType] )) ? $locTypeList [$locType] : '';
  	$strTypeDispl = ($strType && isset ( $locTypeList [$strType] )) ? $locTypeList [$strType] : '';
  
  
  	if($culture == 'ru'){
  		$street = TransliterateCs::toRu($company_location->getStreet ());
  	}
  	elseif($culture == 'en'){
  		$street = TransliterateCs::toLatin($company_location->getStreet ());
  	}
  	else{
  		$street = $company_location->getStreet ();
  	}
  
  	if ($neighbourhood = $company_location->getNeighbourhood ()) {
  		$add = ' - Sector ' . ucwords ( $neighbourhood );
  		$number = $company_location->getStreetNumber ();
  		if ($number && empty ( $street )) {
  			$add .= ' ' . $number;
  		}
  	}
  	$address [] = $this->getCity ()->getCityNameByCulture ( $culture ) . $add;
  	$add = '';
  
  	if ($street) {
  		$add = '';
  		if ('ru' == $culture) {
  			$add .= ' ' . $strTypeDispl . ' ';
  		}
  		if (empty ( $neighbourhood ) && 'ru' == $culture) {
  			$add .= ' ';
  		}
  		$add .= $street;
  		if ('ru' != $culture) {
  			$add .= ' ' . $strTypeDispl;
  		}
  		$number = $company_location->getStreetNumber ();
  		if ($number) {
  			$add .= ' ' . $number;
  		}
  		$address [] = $add;
  	}
  	else {
  		$fullAdress = $company_location->getFullAddress ( $culture );
  		if ($fullAdress) {
  			$address [] = $fullAdress;
  		}
  	}
  
  	return implode ( ', ', $address );
  
  }
  
  public function getDisplayAddressSk($culture = null)
  {
  	$add = '';
  	$address = array ();
  	if (is_null ( $culture )) {
  		$culture = sfContext::getInstance ()->getUser ()->getCulture ();
  	}
  	$company_location = $this->getLocation ();
  
  	$locType = $company_location->getLocationType ();
  	$strType = $company_location->getStreetTypeId ();
  	$locTypeList = AddressTypeSk::getInstance ( $culture );
  
  	$locTypeDispl = ($locType && isset ( $locTypeList [$locType] )) ? $locTypeList [$locType] : '';
  	$strTypeDispl = ($strType && isset ( $locTypeList [$strType] )) ? $locTypeList [$strType] : '';
  
  
  	if($culture == 'ru'){
  		$street = TransliterateSk::toRu($company_location->getStreet ());
  	}
  	elseif($culture == 'en'){
  		$street = TransliterateSk::toLatin($company_location->getStreet ());
  	}
  	else{
  		$street = $company_location->getStreet ();
  	}
  
  	if ($neighbourhood = $company_location->getNeighbourhood ()) {
  		$add = ' - Sector ' . ucwords ( $neighbourhood );
  		$number = $company_location->getStreetNumber ();
  		if ($number && empty ( $street )) {
  			$add .= ' ' . $number;
  		}
  	}
  	$address [] = $this->getCity ()->getCityNameByCulture ( $culture ) . $add;
  	$add = '';
  
  	if ($street) {
  		$add = '';
  		if ('ru' == $culture) {
  			$add .= ' ' . $strTypeDispl . ' ';
  		}
  		if (empty ( $neighbourhood ) && 'ru' == $culture) {
  			$add .= ' ';
  		}
  		$add .= $street;
  		if ('ru' != $culture) {
  			$add .= ' ' . $strTypeDispl;
  		}
  		$number = $company_location->getStreetNumber ();
  		if ($number) {
  			$add .= ' ' . $number;
  		}
  		$address [] = $add;
  	}
  	else {
  		$fullAdress = $company_location->getFullAddress ( $culture );
  		if ($fullAdress) {
  			$address [] = $fullAdress;
  		}
  	}
  
  	return implode ( ', ', $address );
  
  }
  public function getDisplayAddressHu($culture = null)
  {
  
  
  	$add = '';
  	$address = array ();
  	if (is_null ( $culture )) {
  		$culture = sfContext::getInstance ()->getUser ()->getCulture ();
  	}
  	$company_location = $this->getLocation ();
  
  	$fullAddress = $company_location->getFullAddress ( $culture );
  	if ($fullAddress) {
  		$address [] = $fullAddress;
  	}
  
  	return implode ( ', ', $address );
  }
    
  //////////////////////////////////////////////////////////////////////////////////////////
  
  public function getPhoneFormated($pnone = null, $culture = null)
  {  	
  	if (!$culture){
  		$culture = sfContext::getInstance()->getUser()->getCulture();
  	}
  	$partner_class = ucfirst(getlokalPartner::getDefaultCulture ());
  	$method = "getPhoneFormated{$partner_class}";
  	if (method_exists($this, $method) && $method != "getPhoneFormated"){
  		return $this->$method($pnone);
  	}
  
  	$purephone = (($pnone) ? $pnone : $this->getPhone());
  	$purephone = preg_replace('/[^0-9]/', '', $purephone);
  
  	return $purephone;
  }
  

  public function getPhoneFormatedBg($pnone = null)
  {
  	$purephone = (($pnone) ? $pnone : $this->getPhone());
  	$purephone = preg_replace('/[^0-9]/', '', $purephone);
  
  	if (preg_match ( '/^02/', $purephone )) {
  
  		$purephone = substr ( $purephone, 2 );
  		$purephone = '02 ' . $purephone;
  	}
  	$purephone =  substr($purephone, 1);
  	$purephone = '+359 ' .substr ( $purephone, 0, 2 ) . ' ' . substr ( $purephone, 2, 3 ) . ' ' . substr ( $purephone, 5 );
  
  	//$phone = $purephone;
  	return $purephone;
  
  }
  
  
  public function getPhoneFormatedRo($pnone = null)
  {
  	$purephone = (($pnone) ? $pnone : $this->getPhone ());
  	$purephone = preg_replace ( '/[^0-9]/', '', $purephone );
  	$purephone =  substr($purephone, 1);
  	if (preg_match ( '/^7/', $purephone )) {
  		$purephone = '+40 ' . substr ( $purephone, 0, 3 ) . ' ' . substr ( $purephone, 3, 3 ) . ' ' . substr ( $purephone, 6 );
  	} else {
  		$purephone = '+40 ' . substr ( $purephone, 0, 2 ) . ' ' . substr ( $purephone, 2, 3 ) . ' ' . substr ( $purephone, 5 );
  	}
  	//$phone = $purephone;
  	return $purephone;
  
  }
  
  public function getPhoneFormatedMk($pnone = null)
  {
  	$purephone = (($pnone) ? $pnone : $this->getPhone ());
  
  	$purephone = preg_replace ( '/[^0-9]/', '', $purephone );
  	if (! preg_match ( '/^0/', $purephone )) {
  		$purephone = '0' . $purephone;
  	}
  
  	if (preg_match ( '/^02/', $purephone )) {
  
  		$purephone = substr ( $purephone, 2 );
  		$purephone = '02 ' . $purephone;
  	}
  
  	$purephone =  substr($purephone, 1);
  	$purephone = '+389 ' .substr ( $purephone, 0, 2 ) . ' ' . substr ( $purephone, 2, 3 ) . ' ' . substr ( $purephone, 5 );
  
  	return $purephone;
  
  }
  
  public function getPhoneFormatedFi($pnone = null)
  {
  	$purephone = (($pnone) ? $pnone : $this->getPhone ());
  	$purephone = preg_replace ( '/[^0-9]/', '', $purephone );
  
  	$purephone =  substr($purephone, 1);
  	$purephone =  substr( $purephone, 0, 2 ) . ' ' . substr ( $purephone, 2 );
  	$purephone = '+358 ' .substr ( $purephone, 0, 2 ) . ' ' . substr ( $purephone, 2, 3 ) . ' ' . substr ( $purephone, 5 );
  	//$phone = $purephone;
  	return $purephone;
  }
  
}
?>