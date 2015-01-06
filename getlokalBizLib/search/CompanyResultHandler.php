<?php 
	sfContext::getInstance()->getConfiguration()->loadHelpers('Partial');
	class CompanyResultHandler
	{
		protected $_connection = null; 
		
		protected $_totalMatches = 0;
		
		protected $_results;
		
		protected $_culture;
		
		function __construct($data, $culture, $totalMatches, $connection = null){
			if(!is_array($data) || !sizeof($data)){
				return array();
			}else{
				$this->_results = $data;
			}
			if($culture == ''){
				die('Culture is required');
			}else{
				$this->_culture = $culture;
			}
			if(is_null($connection)){				
				$this->_databaseManager = new sfDatabaseManager ( new ProjectConfiguration() );
				$this->_connection = $this->_databaseManager->getDatabase ( 'doctrine' )->getConnection ();
			}else{
				$this->_connection = $connection;
			}			
			$this->_totalMatches = $totalMatches;
		}	
		
		public function setResult($results){
			$this->_resutls = $results;
		}
		
		public function setCulture($culture){
			$this->_culture = $culture;
		}

		public function processData(){
			$results = $this->_results;
			$culture = $this->_culture;
			
			$companyIDs = array();
			$classificationIDs = array();
			$sectorIDs = array();
			$companiesWithReviews = array();
			$companiesWithImages = array();
			
			foreach ((array)$results as $company){
				$companyIDs[] = $company->getId();
				$classificationIDs[] = $company->getClassificationId();
				$sectorIDs[] = $company->getSectorId();
				 
				if( $company->getReviewsCount() || 1){
					$companiesWithReviews[] = $company->getId();
				}
				if( $company->getImageCount() || 1 ){
					$companiesWithImages[] = $company->getId();
				}
			}
			$companyIDs = array_unique($companyIDs);
			$classificationIDs = array_unique($classificationIDs);
			$sectorIDs = array_unique($sectorIDs);
			$companiesWithReviews = array_unique($companiesWithReviews);
			$companiesWithImages = array_unique($companiesWithImages);
			
			$companyAI = $this->_getCompanyInfo($companyIDs, $culture);
			$companyLocationAI = $this->_getCompanyLocationInfo($companyIDs, $culture);
			$classificationsAI = $this->_getClassificationInfo($classificationIDs, $culture);
			$sectorAI = $this->_getSectorInfo($sectorIDs, $culture);
			$companiesWithReviewsAI = $this->_getReviewsInfo($companiesWithReviews);
			$companiesWithImagesAI = $this->_getImagesInfo($companiesWithImages);
			$eventsAI = $this->_getEventsInfo($companyIDs);
			
			foreach ($results as $key => $company){
				if( !isset($companyAI[$company->getId()]) ){
					unset($results[$key]);
					continue;
				}
				$results[$key]->Slug = $companyAI[$company->getId()]['slug'];
				$results[$key]->Phone = $companyAI[$company->getId()]['phone'];
				$results[$key]->Classification = $classificationsAI[$company->getClassificationId()];
				$results[$key]->Sector = $sectorAI[$company->getSectorId()];
				$results[$key]->Location = $companyLocationAI[$company->getId()]['location'];				
				$results[$key]->EventCount = isset($eventsAI[$company->getId()]) ? $eventsAI[$company->getId()]['EventCount'] : 0;
				
				if( $company->getReviewsCount()  || isset($companiesWithReviewsAI[$company->getId()]) ){
					$results[$key]->Review = $companiesWithReviewsAI[$company->getId()];
				}
				if( $company->getImageCount() || isset($companiesWithImagesAI[$company->getId()]) ){
					$results[$key]->Image = $companiesWithImagesAI[$company->getId()];
				}
				$results[$key]->TotalObjects = $this->_totalMatches;
				
				$vars = array('company'=>$results[$key]);
				$results[$key]->Overlay = get_partial('item_marker_overlay',$vars);
			}
			return $results;
		}
		
		protected function _getEventsInfo($IDs, $lang = false){
			// slug, address_en, phone
			$return = array();
			if(sizeof($IDs)){
				$sql = "SELECT
							COUNT(ep.id) AS eventCount
							,p.foreign_id AS id
					FROM event_page ep
					JOIN page p
					ON p.id=ep.page_id
					WHERE p.foreign_id IN (".implode($IDs, ',').") AND p.`type`=2 
					GROUP BY p.foreign_id";
				$stmt = $this->_connection->query($sql);
				while ($row = $stmt->fetch()) {
					$return[$row['id']]  = array('EventCount' => $row['eventCount']);
				}
			}
			return $return;
		}
		
		protected function _getCompanyInfo($IDs, $lang){
			// slug, address_en, phone
			$return = array();
			if(sizeof($IDs)){
				$sql = "SELECT
							c.id,
							c.phone,
							c.slug
					FROM company c
					WHERE c.id IN (".implode($IDs, ',').") ";
				$stmt = $this->_connection->query($sql);
				while ($row = $stmt->fetch()) {
					$return[$row['id']]  = array('phone' => $row['phone'], 'slug' => $row['slug']);
				}
			}
			return $return;
		}

		protected function _getCompanyLocationInfo($IDs, $lang){
			// slug, address_en, phone
			$return = array();
			if(sizeof($IDs)){
				$sql = "SELECT
							cl.company_id AS id,
							cl.full_address,
							cl.location_type,
							cl.street_type_id,
							cl.street_number,
							cl.street,
							cl.neighbourhood,
							cl.building_no,
							cl.entrance,
							cl.floor,
							cl.appartment
					FROM company_location cl
					WHERE cl.company_id IN (".implode($IDs, ',').") ";
				$stmt = $this->_connection->query($sql);
				while ($row = $stmt->fetch()) {
					$location = new spLocation();
		
					$location->location_type = $row['location_type'];
					$location->street_type_id = $row['street_type_id'];
					$location->street_number = $row['street_number'];
					$location->street = $row['street'];
					$location->neighbourhood = $row['neighbourhood'];
					$location->building_no = $row['building_no'];
					$location->entrance = $row['entrance'];
					$location->floor = $row['floor'];
					$location->appartment = $row['appartment'];
		
					$return[$row['id']]['location'] = $location;
				}
			}
			return $return;
		}
		
		protected function _getImagesInfo($IDs){
			$return = array();
			if(sizeof($IDs)){
				$sql = "SELECT
						ci.company_id AS id,
						filename
					FROM `company_image` ci
					JOIN image i
					ON i.id=ci.image_id
					WHERE ci.company_id IN (".implode($IDs, ',').")
					AND i.status='approved'
					GROUP BY company_id";
				$stmt = $this->_connection->query($sql);
				while ($row = $stmt->fetch()) {
					$return[$row['id']] = array('id' => $row['id'], 'filename' => $row['filename']);
				}
			}
			return $return;
		}
		
		protected function _getReviewsInfo($IDs){
			$return = array();
			if(sizeof($IDs)){
				$sql = "SELECT r.id AS review_id
								, r.company_id AS id
								, r.text
								, sgu.username
								, sgu.first_name
								, sgu.last_name
								, i.filename
								, COUNT(r.id) AS total_reviews
						FROM `review` r
						JOIN sf_guard_user sgu ON sgu.id = r.user_id
						JOIN user_profile up ON up.id = sgu.id
						LEFT JOIN image i ON i.id = up.image_id
						WHERE r.company_id IN (".implode($IDs, ',').")
						GROUP BY r.company_id
						ORDER BY r.created_at DESC";
				$stmt = $this->_connection->query($sql);
				while ($row = $stmt->fetch()) {
					$return[$row['id']] = array('review_id' => $row['review_id'], 'text' => $row['text'], 'username' => $row['username'], 'first_name' => $row['first_name'], 'last_name' => $row['last_name'], 'profile_image' => $row['filename'], 'total_reviews' => $row['total_reviews']);
				}
			}
			return $return;
		}
		
		protected function _getClassificationInfo($IDs, $lang){
			$return = array();
			if(sizeof($IDs)){
				$sql = "SELECT id, slug, title FROM classification_translation WHERE id IN (".implode($IDs, ',').") AND lang='$lang' ";
				$stmt = $this->_connection->query($sql);
				while ($row = $stmt->fetch()) {
					$return[$row['id']] = array('id' => $row['id'], 'title' => $row['title'], 'slug' => $row['slug']);
				}
			}
			return $return;
		}
		
		protected function _getSectorInfo($IDs, $lang){
			$return = array();
			if(sizeof($IDs)){
				$sql = "SELECT id, slug, title FROM sector_translation WHERE id IN (".implode($IDs, ',').") AND lang='$lang' ";
				$stmt = $this->_connection->query($sql);
				while ($row = $stmt->fetch()) {
					$return[$row['id']] = array('id' => $row['id'], 'title' => $row['title'], 'slug' => $row['slug']);
				}
			}
			return $return;
		}
		
	}
?>