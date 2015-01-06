<?php

class apiActions extends sfActions {
	public function preExecute() {
		$request = $this->getRequest ();
		$cultures = array ('ro', 'en', 'bg', 'mk' );

		$this->getUser ()->setCulture ( in_array ( $request->getParameter ( 'locale', 'en' ), $cultures ) ? $request->getParameter ( 'locale', 'en' ) : 'en' );

		if (! $country = Doctrine::getTable ( 'Country' )->findOneBySlug ( strtolower ( $request->getParameter ( 'country', '' ) ) )) {
			$country = new Country ();
			$country->setId ( 1 );
			$country->setSlug ( 'bg' );
		}
		$this->getUser ()->setCountry ( $country );
	}

	public function executeTest() {

	}

	public function executeLogin(sfWebRequest $request) {
		sfForm::disableCSRFProtection ();
		$form = new sfGuardFormSignin ();

		$form->bind ( array ('username' => $request->getParameter ( 'username' ), 'password' => $request->getParameter ( 'password' ) ) );

		if ($form->isValid ()) {
			$login = new ApiLogin ();
			$login->setUserId ( $form->getValue ( 'user' )->getId () );
			$login->save ();

			MobileLog::log('login', null, $login->getUserId());

			$return = array ('status' => 'SUCCESS', 'token' => $login->getToken () );
		} else {
			$return = array ('status' => 'ERROR', 'error' => array_merge ( $form->getErrorSchema ()->getGlobalErrors (), $form->getErrorSchema ()->getErrors () ) );
		}

		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}

	public function executeRegister(sfWebRequest $request) {
		sfForm::disableCSRFProtection ();
		$form = new sfGuardRegisterForm ();
		$form->useFields ( array ('email_address', 'password', 'first_name', 'last_name' ) );

		$form->bind ( array ('email_address' => $request->getParameter ( 'username' ), 'password' => $request->getParameter ( 'password' ), 'first_name' => $request->getParameter ( 'firstname' ), 'last_name' => $request->getParameter ( 'lastname' ) ) );

		if ($form->isValid ()) {
			$user = new sfGuardUser ();
			$user->fromArray ( $form->getValues () );
			$user->setUsername ( myTools::cleanUrl ( $user->getFirstName () ) . '.' . rand ( 1000, 9999 ) );
			$user->save ();

			$profile = new UserProfile ();
			$profile->setId ( $user->getId () );
			$profile->setCountryId ( $this->getUser ()->getCountry ()->getId () );
			$profile->save ();

			$login = new ApiLogin ();
			$login->setUserId ( $user->getId () );
			$login->setExpiresAt ( date ( 'Y-m-d H:i:s', time () + (30 * 86400) ) );
			$login->save ();

			MobileLog::log('register', null, $login->getUserId());
			//myTools::sendMail ( $user, 'Welcome to getlokal', 'activation', array ('user' => $user ) );

			$return = array ('status' => 'SUCCESS', 'token' => $login->getToken () );
		} else {
			$return = array ('status' => 'ERROR', 'error' => $this->getErrors ( $form ) );
		}

		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}

	public function executeLoginFb(sfWebRequest $request) {
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, "https://graph.facebook.com/me?access_token=" . $request->getParameter ( 'access_token' ) );
		curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_AUTOREFERER, true );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false ); # required for https urls


		$user_data = json_decode ( curl_exec ( $ch ), true );

		if (isset ( $user_data ['error'] )) {
			$return = array ('status' => 'ERROR', 'error' => $user_data ['error'] ['message'] );

			$this->getResponse ()->setContent ( json_encode ( $return ) );
			return sfView::NONE;
		}
		if (isset ( $user_data ['id'] ) && $user_data ['id']) {
			$profile = Doctrine::getTable ( 'UserProfile' )->findOneByFacebookUid ( $user_data ['id'] );
		}
		$profile = Doctrine::getTable ( 'UserProfile' )->findOneByFacebookUid ( $user_data ['id'] );
		if (! $profile) {
			if (! $user = Doctrine::getTable ( 'sfGuardUser' )->findOneByEmailAddress ( $user_data ['email'] )) {
				curl_setopt ( $ch, CURLOPT_URL, "https://graph.facebook.com/me/picture?type=large&" . $access_token );

				$temp_pic = sfConfig::get ( 'sf_upload_dir' ) . '/' . uniqid ( 'tmp_' ) . '.jpg';
				file_put_contents ( $temp_pic, curl_exec ( $ch ) );

				$file = new sfValidatedFile ( myTools::cleanUrl ( $user_data ['name'] ) . '.jpg', filetype ( $temp_pic ), $temp_pic, filesize ( $temp_pic ) );

				$password = substr ( md5 ( rand ( 100000, 999999 ) ), 0, 8 );

				$user = new sfGuardUser ();
				$user->setEmailAddress ( $user_data ['email'] );
				$user->setUsername ( substr ( uniqid ( md5 ( rand () ), true ), 0, 8 ) );
				$user->setFirstName ( $user_data ['first_name'] );
				$user->setLastName ( $user_data ['last_name'] );
				$user->setPassword ( $password );
				$user->save ();

				$date = DateTime::createFromFormat ( 'm/d/Y', $user_data ['birthday'] );

				$query = Doctrine::getTable ( 'City' )->createQuery ( 'c' )->innerJoin ( 'c.County co' )->where ( 'co.country_id = ?', $this->getUser ()->getCountry ()->getId () );

				$profile = new UserProfile ();

				$fbUserCity = array_shift ( explode ( ',', $user_data ['location'] ['name'] ) );

				$city = Doctrine::getTable ( 'City' )->createQuery ( 'c' )->innerJoin ( 'c.County co' )->addWhere ( 'co.country_id = ?', $this->getUser ()->getCountry ()->getId () )->andWhere ( 'c.name LIKE ? or c.slug LIKE ? OR c.name_en', array ($fbUserCity, $fbUserCity, $fbUserCity ) )->fetchOne ();
				if ($city) {
					$profile->setCityId ( $city->getId () );
					$country_id = $city->getCounty ()->getCountryId ();
					$profile->setCountryId ( $country_id );
				} else {
					$profile->setCountryId ( $this->getUser ()->getCountry ()->getId () );
					$city = Doctrine::getTable ( 'City' )->createQuery ( 'c' )->innerJoin ( 'c.County co' )->where ( 'co.country_id = ?', $this->getUser ()->getCountry ()->getId () )->orderBy ( 'c.is_default DESC' )->limit ( 1 )->fetchOne ();
					$profile->setCityId ( $city->getId () );

				}

				$profile->setId ( $user->getId () );
				$profile->setGender ( $user_data ['gender'] == 'male' ? 'm' : 'f' );
				$profile->setBirthDate ( $date->format ( 'Y-m-d' ) );
				$profile->setFacebookUrl ( $user_data ['link'] );

				$profile->save ();

				$image = new Image ();
				$image->setFile ( $file );
				$image->setUserId ( $profile->getId () );
				$image->setCaption ( $user_data ['name'] );
				$image->setType ( 'profile' );
				$image->setStatus ( 'approved' );
				$image->save ();

				$profile->clearRelated ();
				$profile->setImageId ( $image->getId () );
				$profile->save ();

				@unlink ( $temp_pic );

				myTools::sendMail ( $user, 'Welcome to Getlokal', 'fbRegister', array ('password' => $password ) );
			} else {
				if (! $user->getPassword ()) {
					$password = substr ( md5 ( rand ( 100000, 999999 ) ), 0, 8 );
					$user->setPassword ( $password );
					$user->save ();
				}

				$profile = $user->getUserProfile ();
				if (! $profile->getFacebookUid ()) {
					$profile->setFacebookUid ( $user_data ['id'] );
				}
			}
			if (! $profile->getCityId ())
				$profile->setCityId ( $this->getUser ()->getCity ()->getId () );
			if (! $profile->getCountryId ())
				$profile->setCountryId ( $this->getUser ()->getCountry ()->getId () );
			if (! $profile->getFacebookUid ())
				$profile->setFacebookUid ( $user_data ['id'] );

			$profile->setAccessToken ( $access_token );
			$profile->save ();
		} else {
			if (! $profile->getCityId ())
				$profile->setCityId ( $this->getUser ()->getCity ()->getId () );
			if (! $profile->getCountryId ())
				$profile->setCountryId ( $this->getUser ()->getCountry ()->getId () );
			if (! $profile->getFacebookUid ())
				$profile->setFacebookUid ( $user_data ['id'] );

			$profile->setAccessToken ( $access_token );
			$profile->save ();
		}

		$login = new ApiLogin ();
		$login->setUserId ( $profile->getId () );
		$login->setExpiresAt ( date ( 'Y-m-d H:i:s', time () + (30 * 86400) ) );
		$login->save ();

		MobileLog::log('register', null, $login->getUserId());
		$return = array ('status' => 'SUCCESS', 'token' => $login->getToken () );

		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}

	public function executeRecover(sfWebRequest $request) {
		sfForm::disableCSRFProtection ();
		$form = new ForgotPasswordForm ();

		$form->bind ( array ('email' => $request->getParameter ( 'username' ) ) );

		if ($form->isValid ()) {
			$return = array ('status' => 'SUCCESS' );

			$password = substr ( md5 ( rand ( 100000, 999999 ) ), 0, 8 );

			$user = Doctrine::getTable ( 'sfGuardUser' )->findOneByEmailAddress ( $form->getValue ( 'email' ) );

			$user->setPassword ( $password );
			$user->save ();

			myTools::sendMail ( $user, 'Forgotten Password', 'forgotPassword', array ('password' => $password ) );
		} else {
			$return = array ('status' => 'ERROR', 'error' => $form->getErrorSchema ()->getErrors () );
		}

		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}

	public function executeNews(sfWebRequest $request) {
		$con = Doctrine::getConnectionByTableName ( 'search' );
		$lat = $con->quote ( $request->getParameter ( 'lat' ) );
		$lng = $con->quote ( $request->getParameter ( 'long' ) );
		$this->forward404Unless ( $lat || $lng );

		$sql = "((ACOS(SIN(%s * PI() / 180) * SIN(c.lat * PI() / 180) + COS(%s * PI() / 180) * COS(c.lat * PI() / 180) * COS((%s - c.lng) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as kms";
		$sql2 = "((ACOS(SIN(%s * PI() / 180) * SIN(cl.lat * PI() / 180) + COS(%s * PI() / 180) * COS(cl.lat * PI() / 180) * COS((%s - cl.lng) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as distance";
		$kms = sprintf ( $sql, $lat, $lat, $lng );
		$kms2 = sprintf ( $sql, $lat, $lat, $lng );

		sfContext::getInstance ()->getConfiguration ()->loadHelpers ( 'Asset' );

		$days = 7 - date ( 'N' );
		switch ($request->getParameter ( 'section', 0 )) {
			case 0 :
				$start_date = date ( 'Y-m-d' );
				$end_date = date ( 'Y-m-d' );
				break;
			case 1 :
				$start_date = date ( 'Y-m-d' );
				$end_date = date ( 'Y-m-d', mktime ( 0, 0, 0, date ( 'm' ), date ( 'd' ) + $days, date ( 'Y' ) ) );
				break;
			case 2 :
				$start_date = date ( 'Y-m-d', mktime ( 0, 0, 0, date ( 'm' ), date ( 'd' ) + $days + 1, date ( 'Y' ) ) );
				$end_date = date ( 'Y-m-d', mktime ( 0, 0, 0, date ( 'm' ), date ( 'd' ) + $days + 7, date ( 'Y' ) ) );
				break;
			case 3 :
				$start_date = date ( 'Y-m-d', mktime ( 0, 0, 0, date ( 'm' ), date ( 'd' ) + $days + 7, date ( 'Y' ) ) );
				$end_date = date ( 'Y-m-d', mktime ( 0, 0, 0, date ( 'm' ), date ( 'd' ) + $days + 30, date ( 'Y' ) ) );
				break;
		}

		$items = Doctrine::getTable ( 'MobileNews' )->createQuery ( 'n' )->addSelect ( 'n.*' )->addSelect ( $kms )->limit ( $request->getParameter ( 'section', 0 ) != 0 ? 1 : 9 )->innerJoin ( 'n.MobileNewsCity sc' )->innerJoin ( 'sc.City c' )->having ( 'kms < 50' )->orderBy ( 'n.rank, n.created_at DESC' )->where ( 'n.is_active = ?', true )->execute ();

		$events = Doctrine::getTable ( 'Event' )->createQuery ( 'e' )->addSelect ( 'e.*, t.*, c.*, ep.*, cp.*, co.*, cl.*, i.*, ca.*' )->addSelect ( $kms )->addSelect ( $kms2 )->innerJoin ( 'e.Category ca' )->innerJoin ( 'e.Translation t' )->innerJoin ( 'e.City c' )->leftJoin ( 'e.EventPage ep' )->leftJoin ( 'ep.CompanyPage cp' )->leftJoin ( 'cp.Company co' )->leftJoin ( 'co.CompanyLocation cl' )->leftJoin ( 'e.Image i' )->limit ( 15 )->addWhere ( 'e.start_at >= ? and e.start_at <= ?', array ($start_date, $end_date ) )->orderBy ( 'e.start_at' )->having ( 'kms < 50' )->execute ();

		$return = array ('status' => 'SUCCESS', 'items' => array () );

		$possitions = array ();

		$start = 0;
		$end = count ( $events );
		foreach ( $items as $item ) {
			$start = min ( $item->getRank (), $start );
			$end = max ( $item->getRank (), $end );

			$possitions [$item->getRank ()] [] = $item;
		}

		$i18n = $this->getContext ()->getI18N ();

		for($i = $start; $i <= $end; $i ++) {
			if (isset ( $possitions [$i] )) {
				foreach ( $possitions [$i] as $news_item )
					if ($news_item)
						$return ['items'] [] = array ('identifier' => $news_item->getId (), 'type' => 2, 'internal' => 1, 'title' => $news_item->getTitle (), 'details1' => $news_item->getLine1 (), 'details2' => $news_item->getLine2 (), 'detauls3' => '', 'picture_url' => $news_item->getThumb ( 1 ), 'big_picture_url' => $news_item->getThumb (), 'content_url' => $news_item->getLink () );
			}

			if (isset ( $events [$i] )) //foreach($events as $event)
			{
				$event = $events [$i];

				if ($event->getDateTimeObject ( 'start_at' )->format ( 'Y-m-d' ) == date ( 'Y-m-d' ))
					$date = $i18n->__ ( 'Today' ) . ' ';
				elseif ($event->getDateTimeObject ( 'start_at' )->sub ( new DateInterval ( 'P1D' ) )->format ( 'Y-m-d' ) == date ( 'Y-m-d' ))
					$date = $i18n->__ ( 'Tomorrow' ) . ' ';
				else
					$date = $i18n->__ ( $event->getDateTimeObject ( 'start_at' )->format ( 'l' ) );

				$date .= ' (' . $event->getDateTimeObject ( 'start_at' )->format ( 'd.m.Y' ) . ')';

				$return ['items'] [] = array ('identifier' => $event->getId (), 'type' => 1, 'internal' => 0, 'title' => $event->getTitle (), 'share_url' => 'http://www.getlokal.' . $this->getUser ()->getDomain () . '/' . $this->getUser ()->getCulture () . '/d/event/show/id/' . $event->getId (), 'details1' => $date, 'details2' => $event->getPrice () ? $i18n->__ ( 'Ticket: ' ) . $event->getPriceValue () : '', 'details3' => $event->getFirstCompany () ? $event->getFirstCompany ()->getTitle () . ' (' . number_format ( $event->kms, 2 ) . ' km)' : '', 'category' => $event->getCategory (), 'picture_url' => image_path ( $event->getThumb (), true ), 'content_url' => $this->generateUrl ( 'default', array ('module' => 'api', 'action' => 'event', 'id' => $event->getId (), 'country' => $this->getUser ()->getCountry ()->getSlug (), 'locale' => $this->getUser ()->getCulture () ), true ) );
			}
		}

		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}

	public function executePhotos(sfWebRequest $request) {
		$return = array ('status' => 'SUCCESS', 'photos' => array () );

		$images = $request->getParameter ( 'type', 0 ) == 0 ? $this->getCompanyImages () : $this->getEventImages ();
		foreach ( $images as $image ) {
			$return ['photos'] [] = array ('url' => $image->getImage ()->getThumb ( 'preview', true ), 'caption' => $image->getImage ()->getDescription () );
		}

		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}

	public function getCompanyImages() {
		$this->forward404Unless ( $item = Doctrine::getTable ( 'Company' )->find ( $this->getRequest ()->getParameter ( 'identifier' ) ) );

		return Doctrine::getTable ( 'CompanyImage' )->createQuery ( 'ci' )->innerJoin ( 'ci.Image i' )->where ( 'ci.company_id = ?', $item->getId () )->andWhere ( 'i.status = "approved"' )->limit ( 20 )->execute ();
	}

	public function getEventImages() {
		$this->forward404Unless ( $item = Doctrine::getTable ( 'Event' )->find ( $this->getRequest ()->getParameter ( 'identifier' ) ) );

		return Doctrine::getTable ( 'EventImage' )->createQuery ( 'ci' )->innerJoin ( 'ci.Image i' )->where ( 'ci.event_id = ?', $item->getId () )->andWhere ( 'i.status = "approved"' )->limit ( 20 )->execute ();
	}

	public function executeEvent(sfWebRequest $request) {
		$this->forward404Unless ( $this->event = Doctrine::getTable ( 'Event' )->find ( $request->getParameter ( 'id' ) ) );

		$this->comments = Doctrine::getTable ( 'Comment' )->createQuery ( 'c' )->innerJoin ( 'c.UserProfile p' )->innerJoin ( 'p.sfGuardUser' )->innerJoin ( 'c.ActivityComment ac' )->leftJoin ( 'c.Parent' )->//->where('c.activity_id = ?', $this->event->getEventActivity()->getId())
		orderBy ( 'c.created_at DESC' )->limit ( 20 )->execute ();

		$this->no_rspv = Doctrine::getTable ( 'EventUser' )->createQuery ( 'eu' )->andWhere ( 'eu.event_id = ?', $this->event->getId () )->andWhere ( 'eu.confirm = 1' )->count ();
	}

	public function executeCompany(sfWebRequest $request) {
		$query = Doctrine::getTable ( 'Company' )->createQuery ( 'c' )->innerJoin ( 'c.Sector s' )->innerjoin ( 's.Translation st WITH st.lang = ?', $this->getUser ()->getCulture () )->innerJoin ( 'c.Classification ca' )->innerJoin ( 'ca.Translation cat WITH cat.lang = ?', $this->getUser ()->getCulture () )->where ( 'c.id = ?', $request->getParameter ( 'id' ) );

		$this->checkToken ( $request->getParameter ( 'token' ) );
		$this->forward404Unless ( $this->company = $query->fetchOne () );

		$this->reviews = Doctrine::getTable ( 'Review' )->createQuery ( 'r' )->innerJoin ( 'r.UserProfile p' )->innerJoin ( 'p.sfGuardUser' )->where ( 'r.company_id = ?', $this->company->getId () )->orderBy ( 'r.created_at DESC' )->limit ( 20 )->execute ();

		$this->is_favorite = Doctrine::getTable ( 'Company' )->createQuery ( 'c' )->innerJoin ( 'c.CompanyPage p' )->innerJoin ( 'p.Follow f' )->where ( 'f.user_id = ?', $this->getUser ()->getId () )->andWhere ( 'c.id = ?', $this->company->getId () )->count ();
		MobileLog::log('company', $this->company->getId());
	}

	public function executeReview(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );
		$this->forward404Unless ( $company = Doctrine::getTable ( 'Company' )->find ( $request->getParameter ( 'identifier' ) ) );
		sfForm::disableCSRFProtection ();

		$form = new ReviewForm ();
		$form->bind ( array ('rating' => $request->getParameter ( 'rating' ), 'text' => $request->getParameter ( 'review' ) ) );

		if ($form->isValid ()) {
			$review = new Review ();
			$review->fromArray ( $form->getValues () );
			$review->setCompanyId ( $company->getId () );
			$review->setUserId ( $this->getUser ()->getId () );
			$review->save ();

			MobileLog::log('review', $review->getId());

			$return = array ('status' => 'SUCCESS' );
		} else {
			$return = array ('status' => 'ERROR', 'error' => $this->getErrors ( $form ) );
		}

		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}

	public function executeFavoriteList(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );
		sfContext::getInstance ()->getConfiguration ()->loadHelpers ( 'Asset' );

		$con = Doctrine::getConnectionByTableName ( 'search' );
		$lat = $con->quote ( $request->getParameter ( 'lat' ) );
		$lng = $con->quote ( $request->getParameter ( 'long' ) );
		$this->forward404Unless ( $lat || $lng );

		$sql = "((ACOS(SIN(%s * PI() / 180) * SIN(l.latitude * PI() / 180) + COS(%s * PI() / 180) * COS(l.latitude * PI() / 180) * COS((%s - l.longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as kms";
		$kms = sprintf ( $sql, $lat, $lat, $lng );

		$query = Doctrine::getTable ( 'Company' )->createQuery ( 'c' )->addSelect ( 'c.*, i.*' )->addSelect ( $kms )->innerJoin ( 'c.CompanyLocation l' )->innerJoin ( 'c.CompanyPage p' )->innerJoin ( 'p.Follow f' )->leftJoin ( 'c.Image i' )->where ( 'f.user_id = ?', $this->getUser ()->getId () )->limit ( 20 );

		$return = array ();
		foreach ( $query->execute () as $company ) {
			$return [] = array ('id' => $company->getId (),
							    'title' => $company->getCompanyTitle (),
							    'stars' => $company->getRating (),
							    'review_count' => $company->getNumberOfReviews (),
							    'distance' => $company->kms,
							    'latitude' => $company->getLocation ()->getLatitude (),
							    'longitude' => $company->getLocation ()->getLongitude (),
							    'phone' => $company->getPhone (),
							    'address' => $company->getDisplayAddress (),
							    'icon' => 'marker_' . $company->getSectorId (),
							    'picture_url' => image_path ( $company->getThumb(0,true)),
							    'content_url' => $this->generateUrl ( 'default', array ('module' => 'api', 'action' => 'company', 'id' => $company->getId (),
							    'token' => $request->getParameter ( 'token' ), 'locale' => $this->getUser ()->getCulture () ), true ));
		}

		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}

	public function executeFavorite(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );
		$this->forward404Unless ( $company = Doctrine::getTable ( 'Company' )->find ( $request->getParameter ( 'identifier' ) ) );

		$query = Doctrine::getTable ( 'Follow' )->createQuery ( 'f' )->where ( 'f.user_id = ?', $this->getUser ()->getId () )->andWhere ( 'f.page_id = ?', $company->getCompanyPage ()->getId () );

		if ($follow = $query->fetchOne ()) {
			$follow->delete ();
		} else {
			$follow = new Follow ();
			$follow->setUserId ( $this->getUser ()->getId () );
			$follow->setPageId ( $company->getCompanyPage ()->getId () );
			$follow->save ();
		}

		$return = array ('status' => 'SUCCESS' );

		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}

	public function executeSearch(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );

		$con = Doctrine::getConnectionByTableName ( 'search' );
		$lat = $con->quote ( $request->getParameter ( 'lat' ) );
		$lng = $con->quote ( $request->getParameter ( 'long' ) );
		$this->forward404Unless ( $lat || $lng );

		$km_sql = "((ACOS(SIN(%s * PI() / 180) * SIN(l.latitude * PI() / 180) + COS(%s * PI() / 180) * COS(l.latitude * PI() / 180) * COS((%s - l.longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as kms";
		$kms = sprintf ( $km_sql, $lat, $lat, $lng );

		sfContext::getInstance ()->getConfiguration ()->loadHelpers ( 'Asset' );

		$wlat = $request->getParameter ( 'lat' ) - 0.2;
		$elat = $request->getParameter ( 'lat' ) + 0.2;
		$Nlong = $request->getParameter ( 'long' ) - 0.2;
		$Slong = $request->getParameter ( 'long' ) + 0.2;

		$sql = "SELECT c.id as id, {$kms} FROM company_location l INNER JOIN company c ON c.location_id = l.id
            INNER JOIN sector s ON c.sector_id = s.id AND s.rank < 11
            WHERE (l.latitude > {$wlat} AND l.latitude < {$elat} AND l.longitude > {$Nlong} AND l.longitude < {$Slong})
                  AND c.number_of_reviews > 1
                  AND c.status = 0
            ORDER BY kms * (4 / score) ASC LIMIT 15";

		if ($request->getParameter ( 'text' )) {
			$text = str_replace ( array ('_', '-', "'", '"', ',' ), '', $request->getParameter ( 'text' ) );
			$query_string = $con->quote ( $text );
			$query_text = $con->quote ( '"' . $text . '"' );

			$sql = "SELECT c.id as id, {$kms}, (MATCH(s.title, s.body) AGAINST ($query_string)) as title_weight, (MATCH(s.keywords) AGAINST ($query_string)) as keyword_weight
            FROM company_location l INNER JOIN company c ON c.location_id = l.id INNER JOIN search s ON s.object_id = c.id AND s.model_name = 'Company'
            WHERE (l.latitude > {$wlat} AND l.latitude < {$elat} AND l.longitude > {$Nlong} AND l.longitude < {$Slong})
                  AND c.status = 0
                  AND ((MATCH(s.title, s.body, s.keywords) AGAINST ($query_string IN BOOLEAN MODE)) OR (MATCH(s.title, s.body, s.keywords) AGAINST ($query_text IN BOOLEAN MODE)))
            ORDER BY (3 * kms) * (20 / (if(title_weight=0,0.001,title_weight))) ASC LIMIT 15";
		}

		$ids = array ();
		$result = $con->execute ( $sql );
		while ( $row = $result->fetch ( PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT ) ) {
			$ids [] = $row ['id'];
		}

		if (! $ids)
			return sfView::NONE;

		$lat = $con->quote ( $request->getParameter ( 'lat_current' ) );
		$lng = $con->quote ( $request->getParameter ( 'long_current' ) );
		$this->forward404Unless ( $lat || $lng );
		$kms = sprintf ( $km_sql, $lat, $lat, $lng );

		$company_query = Doctrine::getTable ( 'Company' )->createQuery ( 'c' )->innerJoin ( 'c.Location l' )->innerJoin ( 'c.City ci' )->leftJoin ( 'c.Image i' )->addSelect ( "c.id, c.*, i.*, l.*, ci.*" )->addSelect ( $kms )->whereIN ( 'c.id', $ids )->orderBy ( 'kms' )->limit ( 15 );

		/*usort($companies, function($a,$b) use ($request) {
      return (($a->title_weight*2 + $a->keyword_weight) * $a->getScore()) <= (($b->title_weight*2 + $b->keyword_weight) * $b->getScore())? 1: -1;
    });*/

		$return = array ();
		foreach ( $company_query->execute () as $company ) {
			$return [] = array ('id' => $company->getId (), 'title' => $company->getCompanyTitle (), 'stars' => $company->getRating (), 'review_count' => $company->getNumberOfReviews (), 'distance' => $company->kms, 'latitude' => $company->getLocation ()->getLatitude (), 'longitude' => $company->getLocation ()->getLongitude (), 'icon' => 'marker_' . $company->getSectorId (), 'phone' => $company->getPhone (), 'address' => $company->getDisplayAddress (),

			'picture_url' => image_path ( $company->getThumb ( 0, true ), true ), 'share_url' => 'http://www.getlokal.' . $this->getUser ()->getDomain () . '/' . $this->getUser ()->getCulture () . '/' . $company->getCity ()->getSlug () . '/' . $company->getSlug (), 'content_url' => $this->generateUrl ( 'default', array ('module' => 'api', 'action' => 'company', 'id' => $company->getId (), 'token' => $request->getParameter ( 'token' ), 'locale' => $this->getUser ()->getCulture () ), true ) );
		}

		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}

	public function executeSearchTU(sfWebRequest $request) {
		$con = Doctrine::getConnectionByTableName ( 'search' );
		$lat = $con->quote ( $request->getParameter ( 'lat' ) );
		$lng = $con->quote ( $request->getParameter ( 'long' ) );
		$this->forward404Unless ( $lat || $lng );

		$km_sql = "((ACOS(SIN(%s * PI() / 180) * SIN(l.latitude * PI() / 180) + COS(%s * PI() / 180) * COS(l.latitude * PI() / 180) * COS((%s - l.longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as kms";
		$kms = sprintf ( $km_sql, $lat, $lat, $lng );

		sfContext::getInstance ()->getConfiguration ()->loadHelpers ( 'Asset' );

		$wlat = $request->getParameter ( 'lat' ) - 0.2;
		$elat = $request->getParameter ( 'lat' ) + 0.2;
		$Nlong = $request->getParameter ( 'long' ) - 0.2;
		$Slong = $request->getParameter ( 'long' ) + 0.2;

		$sql = "SELECT c.id as id, {$kms} FROM company_location l INNER JOIN company c ON c.location_id = l.id
            INNER JOIN sector s ON c.sector_id = s.id AND s.rank < 11
            WHERE (l.latitude > {$wlat} AND l.latitude < {$elat} AND l.longitude > {$Nlong} AND l.longitude < {$Slong})
                  AND c.number_of_reviews > 1
                  AND c.status = 0
            ORDER BY kms * (4 / score) ASC LIMIT 10";

		$ids = array ();
		$result = $con->execute ( $sql );
		while ( $row = $result->fetch ( PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT ) ) {
			$ids [] = $row ['id'];
		}

		if (! $ids)
			return sfView::NONE;

		$company_query = Doctrine::getTable ( 'Company' )->createQuery ( 'c' )->innerJoin ( 'c.Location l' )->innerJoin ( 'c.City ci' )->leftJoin ( 'c.Image i' )->addSelect ( "c.id, c.*, i.*, l.*, ci.*" )->addSelect ( $kms )->whereIN ( 'c.id', $ids )->orderBy ( 'kms' )->limit ( 15 );

		/*usort($companies, function($a,$b) use ($request) {
      return (($a->title_weight*2 + $a->keyword_weight) * $a->getScore()) <= (($b->title_weight*2 + $b->keyword_weight) * $b->getScore())? 1: -1;
    });*/

		$return = array ();
		foreach ( $company_query->execute () as $company ) {
			$return [] = array ('id' => $company->getId (), 'title' => $company->getCompanyTitle (), 'stars' => $company->getRating (), 'review_count' => $company->getNumberOfReviews (), 'distance' => $company->kms, 'latitude' => $company->getLocation ()->getLatitude (), 'longitude' => $company->getLocation ()->getLongitude (), 'icon' => image_path ( 'gui/icons/small_marker_' . $company->getSectorId (), true ), 'phone' => $company->getPhone (), 'address' => $company->getDisplayAddress (), 'picture_url' => image_path ( $company->getThumb ( 0, true ), true ), 'url' => 'http://www.getlokal.ro/ro/' . $company->getCity ()->getSlug () . '/' . $company->getSlug () );
		}

		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}

	public function executeStatus(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );
		$this->forward404Unless ( $event = Doctrine::getTable ( 'Event' )->find ( $request->getParameter ( 'identifier' ) ) );

		$query = Doctrine::getTable ( 'EventUser' )->createQuery ( 'eu' )->andWhere ( 'eu.event_id = ?', $event->getId () )->andWhere ( 'eu.user_id = ?', $this->getUser ()->getId () );

		if ($eventUser = $query->fetchOne ()) {
			if ($request->getParameter ( 'rsvp', 0 ) == 0) {
				$eventUser->delete ();
			}
		} elseif ($request->getParameter ( 'rsvp', 0 ) != 0) {
			$eventUser = new EventUser ();
			$eventUser->setEventId ( $event->getId () );
			$eventUser->setConfirm ( 1 );
			$eventUser->setUserId ( $this->getUser ()->getId () );
			$eventUser->save ();
		}

		$return = array ('status' => 'SUCCESS' );

		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}

	public function executeCheckin(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );
		sfForm::disableCSRFProtection ();

		$this->forward404Unless ( $company = Doctrine::getTable ( 'Company' )->find ( $request->getParameter ( 'identifier' ) ) );

		$checkin = new CheckIn ();
		$checkin->setUserId ( $this->getUser ()->getId () );
		$checkin->setCompanyId ( $company->getId () );
		$checkin->setLatitude ( $request->getParameter ( 'lat' ) );
		$checkin->setLongitude ( $request->getParameter ( 'long' ) );
		$checkin->save ();

		$return = array ('status' => 'SUCCESS' );

		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}

	public function executeUpload(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );
		$this->forward404Unless ( $company = Doctrine::getTable ( 'Company' )->find ( $request->getParameter ( 'identifier' ) ) );
		sfForm::disableCSRFProtection ();

		$form = new ImageForm ();
		$form->bind ( array (), $request->getFiles () );

		if ($form->isValid ()) {
			$image = new Image ();
			$image->setFile ( $form->getValue ( 'file' ) );
			$image->setUserId ( $this->getUser ()->getId () );
			$image->setStatus ( 'mobile_upload' );
			$image->setType ( 'company' );
			$image->save ();

			MobileLog::log('upload', $image->getId());

			$company_image = new CompanyImage ();
			$company_image->setCompanyId ( $company->getId () );
			$company_image->setImageId ( $image->getId () );
			$company_image->save ();

			$return = array ('status' => 'SUCCESS', 'identifier' => $image->getId () );
		} else {
			$return = array ('status' => 'ERROR', 'errors' => $this->getErrors ( $form ) );
		}

		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}

	public function executeProfile(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );
		sfContext::getInstance ()->getConfiguration ()->loadHelpers ( 'Asset' );

		$profile = Doctrine::getTable ( 'UserProfile' )->createQuery ( 'p' )->innerJoin ( 'p.sfGuardUser' )->leftJoin ( 'p.City' )->where ( 'p.id = ?', $this->getUser ()->getId () )->fetchOne ();

		$badges = Doctrine::getTable ( 'Badge' )->createQuery ( 'b' )->innerJoin ( 'b.UserBadge ub' )->where ( 'ub.user_id = ?', $profile->getId () )->execute ();

		$activities = Doctrine::getTable ( 'CheckIn' )->createQuery ( 'c' )->innerJoin ( 'c.Company co' )->innerJoin ( 'co.CompanyLocation cl' )->where ( 'c.user_id = ?', $profile->getId () )->orderBy ( 'c.created_at DESC' )->execute ();

		$return = array ('status' => 'success', 'user_name' => $profile->__toString (), 'user_location' => $profile->getCity () . '', 'user_badges' => $profile->getBadges (), 'user_reviews' => $profile->getReviews (), 'user_photos' => $profile->getImages (), 'user_photo_url' => image_path ( $profile->getThumb () ), 'badges' => array (), 'activities' => array () );

		foreach ( $badges as $badge ) {
			$return ['badges'] [] = array ('title' => $badge->getName (), 'details' => $badge->getDescription (), 'picture_url' => $badge->getFile ( 'active_image' )->getUrl () );
		}

		$i18n = $this->getContext ()->getI18N ();

		foreach ( $activities as $activitiy ) {
			$return ['actions'] [] = array ('title' => $i18n->__ ( 'Checked in at %s', array ('%s' => $activitiy->getCompany ()->__toString () ) ), 'details' => $activitiy->getCompany ()->getFullAddress (), 'picture_url' => image_path ( $activitiy->getCompany ()->getThumb () ), 'datetime' => $activitiy->getDateTimeObject ( 'created_at' )->format ( 'c' ) );
		}

		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}

	public function executeProfilephoto(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );
		sfForm::disableCSRFProtection ();

		$form = new ImageForm ();
		$form->bind ( array (), $request->getFiles () );

		if ($form->isValid ()) {
			$image = new Image ();
			$image->setFile ( $form->getValue ( 'file' ) );
			$image->setUserId ( $this->getUser ()->getId () );
			$image->setStatus ( 'mobile_upload' );
			$image->save ();

			$profile = Doctrine::getTable ( 'UserProfile' )->find ( $this->getUser ()->getId () );
			$profile->setImageId ( $image->getId () );
			$profile->save ();

			$return = array ('status' => 'SUCCESS', 'identifier' => $image->getId () );
		} else {
			$return = array ('status' => 'ERROR', 'errors' => $this->getErrors ( $form ) );
		}

		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}

	public function executeValidate(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );
		$this->forward404Unless ( $image = Doctrine::getTable ( 'Image' )->find ( $request->getParameter ( 'identifier' ) ) );

		$image->setCaption ( $request->getParameter ( 'text' ) );
		$image->setStatus ( 'approved' );
		$image->save ();

	    $company = $image->getCompany ();
		if ($company && !$company->getImageId ()) {
			$company->setImageId ( $image->getId () );
			$company->save ();
		}
		$return = array ('status' => 'SUCCESS' );

		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}

	public function executeStop() {
		return sfView::NONE;
	}

	private function checkToken($token) {
		$return = false;
		if (! $token || ! $login = Doctrine::getTable ( 'ApiLogin' )->findOneByToken ( $token )) {
			$return = array ('status' => 'ERROR', 'error' => 'Invalid user token or token expired', 'error_code' => 3 );
		}

		if (! $return && $login->getDateTimeObject ( 'expires_at' )->format ( 'U' ) < time ()) {
			$return = array ('status' => 'ERROR', 'error' => 'Invalid user token or token expired', 'error_code' => 3 );
		}

		if ($return) {
			$this->getResponse ()->setContent ( json_encode ( $return ) );
			$this->setTemplate ( 'false' );

			$this->forward ( 'api', 'stop' );
		} else {
			$this->getUser ()->setAttribute ( 'user_id', $login->getUserId (), 'sfGuardSecurityUser' );
		}

		return true;
	}

	public function forward404Unless($condition, $message = null) {
		if (! $condition) {
			$return = array ('status' => 'ERROR', 'error' => 'No items found', 'error_code' => 4 );

			$this->getResponse ()->setContent ( json_encode ( $return ) );
			$this->forward ( 'api', 'stop' );
		}
	}

	private function getErrors($form) {
		$errors = array ();
		foreach ( $form->getErrorSchema ()->getErrors () as $key => $error )
			$errors [$key] = '' . $error;

		return $errors;
	}

	public function executeSuspendedCoffee(sfWebRequest $request) {
		$con = Doctrine::getConnectionByTableName ( 'Company' );
		// $lat = $con->quote ( $request->getParameter ( 'lat', null ) );
		// $lng = $con->quote ( $request->getParameter ( 'long', null ) );
		// // $this->forward404Unless($lat || $lng);
		// if ($lat && $lng) {
		// 	$sql = "((ACOS(SIN(%s * PI() / 180) * SIN(l.latitude * PI() / 180) + COS(%s * PI() / 180) * COS(l.latitude * PI() / 180) * COS((%s - l.longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as kms";
		// 	$kms = sprintf($sql, $lat, $lat, $lng);
		// }
		sfContext::getInstance()->getConfiguration()->loadHelpers('Asset');

		$companies = $this->return = array();
		#$this->sus_place_link  = array();
		$query = Doctrine::getTable('Company')->createQuery('c')->addSelect('c.*, i.*');

		// if (isset($kms)) {
		// 	$query->addSelect($kms);
		// }

		$query->innerJoin('c.CompanyLocation l')
			  ->innerJoin('c.CompanyPage p')
			  ->innerJoin('p.ListPage lp')
			  ->innerJoin('lp.Lists li')
			  ->leftJoin('c.Image i')->where('lp.list_id= ?', 207 );
		$this->companies = $query->execute();
		/*
		if (count ( $companies ) > 0) {
			foreach ( $companies as $company ) {
				$this->return[] = $company;
				$this->sus_place_link[$company->getId()] = $this->generateUrl('default',
																    array('module' => 'api',
																		  'action' => 'suspendedPlace',
																		  'id' => $company->getId(),
																		  'locale' => $this->getUser()->getCulture()), true);
			}
		}*/

		#$this->locale = $this->getUser()->getCulture();
		$this->is_favorite= 0;
		$this->setTemplate ("SuspendedList");

		#$this->getResponse()->setContent(json_encode($return));
	    #return sfView::NONE;
	}

	public function executeSuspendedPlace(sfWebRequest $request)
	{
		$query = Doctrine::getTable('Company')
						->createQuery('c')
						->innerJoin('c.Sector s')
						->innerjoin('s.Translation st WITH st.lang = ?', $this->getUser()->getCulture())
						->innerJoin('c.Classification ca' )->innerJoin('ca.Translation cat WITH cat.lang = ?', $this->getUser()->getCulture())
						->where('c.id = ?', $request->getParameter('id'));
		$cmp_id = $request->getParameter('id');
		$this->company = $query->fetchOne();
		#$this->checkToken($request->getParameter('token'));
		$this->forward404Unless($this->company);

		$this->reviews = Doctrine::getTable('Review')
								->createQuery('r')
								->innerJoin('r.UserProfile p')
								->innerJoin('p.sfGuardUser')
								->where('r.company_id = ?', $cmp_id)
								->orderBy('r.created_at DESC')
								->limit(20)
								->execute();

		$this->is_favorite = Doctrine::getTable('Company')
									->createQuery('c')
									->innerJoin('c.CompanyPage p')
									->innerJoin('p.Follow f')
									->where('f.user_id = ?', $this->getUser()->getId())
									->andWhere('c.id = ?', $cmp_id)
									->count();

	}

}
