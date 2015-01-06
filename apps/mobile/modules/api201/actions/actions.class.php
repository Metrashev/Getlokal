<?php

//http://itouchmap.com/latlong.html
//http://universimmedia.pagesperso-orange.fr/geo/loc.htm
//http://www.gorissen.info/Pierre/maps/googleMapLocation.php

class api201Actions extends sfActions {
    private $visibleSectors = array(
                //1, // Petrol stations
                2,
                4,
                5,
                6,
                7,
                8,
                //10,
                //11,
                //12,
                16, // ATM`s
                //14,
                17,
                18,
                //20,
                //21,
                24,
                25,
                27,
            );

	public function preExecute() {
		$request = $this->getRequest();
		$cultures = array('ro', 'en', 'bg', 'mk', 'sr');

		$this->getUser()->setCulture(in_array($request->getParameter('locale', 'en'), $cultures) ? $request->getParameter('locale', 'en') : 'en');

		if (!$country = Doctrine::getTable('Country')->findOneBySlug(strtolower($request->getParameter('country', '')))) {
			$country = new Country();
			$country->setId(1);
			$country->setSlug('bg');
		}

        $this->getUser()->setCountry($country);
	}

    // ex. http://www.getlokal.com/mobile_dev.php/api201/company?token=eea05e007a12c7b8dee730ab4de98eb2&id=14360&locale=bg
    // http://www.getlokal.com/mobile_dev.php/api201/company?token=eea05e007a12c7b8dee730ab4de98eb2&id=14360&locale=bg&lat=42.681173&long=23.310819
    // http://www.getlokal.com/mobile_dev.php/api201/company?token=eea05e007a12c7b8dee730ab4de98eb2&id=220711&locale=mk&lat=42.681173&long=23.310819
	public function executeCompany(sfWebRequest $request) {
        $this->checkToken($request->getParameter('token'));

        $con = Doctrine::getConnectionByTableName('Company');
		$lat = $con->quote($request->getParameter('lat'));
		$lng = $con->quote($request->getParameter('long'));

		$this->forward404Unless($lat || $lng);

        $sql = "((ACOS(SIN(%s * PI() / 180) * SIN(l.latitude * PI() / 180) + COS(%s * PI() / 180) * COS(l.latitude * PI() / 180) * COS((%s - l.longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as kms";
        $kms = sprintf($sql, $lat, $lat, $lng);

		$query = Doctrine::getTable('Company')
                ->createQuery('c')
                ->innerJoin('c.Location l')
                ->innerJoin('c.Sector s')
                ->innerjoin('s.Translation st WITH st.lang = ?', $this->getUser()->getCulture())
                ->innerJoin('c.Classification ca')
                ->innerJoin('ca.Translation cat WITH cat.lang = ?', $this->getUser()->getCulture())

                // Add kilometers
                ->addSelect("c.id, c.*, s.*, st.*, ca.*, cat.*, l.*")
                ->addSelect($kms)

                ->where('c.id = ?', $request->getParameter('id'));

		$this->forward404Unless($this->company = $query->fetchOne());

        if ($this->company->getActivePPPService(true)) {
            $this->setTemplate('pppCompany');

            /* Without the distance
            $this->events = Doctrine::getTable('Event')
                            ->createQuery('e')
                            ->innerJoin('e.Translation t')
                            ->innerJoin('e.EventPage ep')
                            ->where('ep.page_id = '. $this->company->getCompanyPage()->getId())
                            ->addWhere('e.start_at >= ?', date('Y-m-d') . ' 00:00:00')
                            ->andWhere('e.is_active = 1')
                            ->orderBy('e.start_at ASC')
                            ->limit(20)
                            ->execute();
            */

            // With the distance
            $this->events = Doctrine::getTable('Event')
                            ->createQuery('e')

                            ->addSelect("e.*, t.*, c.*, ep.*, cp.*, co.*, l.*")
                            ->addSelect($kms)

                            ->innerJoin('e.Translation t')
                            ->innerJoin('e.City c')
                            ->innerJoin('e.EventPage ep')
                            ->leftJoin('ep.CompanyPage cp')
                            ->leftJoin('cp.Company co')
                            ->leftJoin('co.CompanyLocation l')
                            ->where('ep.page_id = '. $this->company->getCompanyPage()->getId())
                            ->addWhere('e.start_at >= ?', date('Y-m-d') . ' 00:00:00')
                            ->andWhere('e.is_active = 1')
                            ->orderBy('e.start_at ASC')
                            //->limit(20)
                            ->execute();
        }
        else {
            $this->setTemplate('ppCompany');
        }

/*
        OLD
		$this->reviews = Doctrine::getTable('Review')
                            ->createQuery('r')
                            ->innerJoin('r.UserProfile p')
                            ->innerJoin('p.sfGuardUser')
                            ->where('r.company_id = ? and r.parent_id = ?', array($this->company->getId(), 'NULL'))
                            ->orderBy('r.created_at DESC')
                            ->limit(20)
                            ->execute();
*/

        $this->reviews = Doctrine::getTable('Review')
                            ->createQuery('r')
                            ->innerJoin('r.Company c WITH c.id = ?', $this->company->getId())
                            ->innerJoin('r.UserProfile p')
                            ->innerJoin('p.sfGuardUser sf')
                            ->leftJoin('p.Image im')
                            //->leftJoin('r.Review rr')
                            ->where('r.is_published = ?', Review::FRONTEND_REVIEWS_IS_PUBLISHED)
                            ->addWhere('r.parent_id IS NULL')
                            ->orderBy('r.created_at DESC')
                            //->limit(20)
                            ->execute();

		$this->is_favorite = Doctrine::getTable('Company')
                            ->createQuery('c')
                            ->innerJoin('c.CompanyPage p')
                            ->innerJoin('p.Follow f')
                            ->where('f.user_id = ?', $this->getUser()->getId())
                            ->andWhere('c.id = ?', $this->company->getId())
                            ->count();

        $this->is_check_in = Doctrine::getTable('CheckInStatus')
                            ->createQuery('ci')
                            ->where('ci.user_id = ? and ci.company_id = ?', array($this->getUser()->getId(), $this->company->getId()))
                            ->count();
        }

    // ex. http://getlokal.com/mobile_dev.php/api201/page/slug/terms-of-use/locale/en
    public function executePage(sfWebRequest $request) {
        $slug = $request->getParameter('slug', null);
/*
        $this->forward404Unless(in_array($slug, array('terms-of-use', 'privacy-policy', 'legal-info')));

        $this->page = Doctrine_Core::getTable('StaticPage')
                        ->findOneBySlug($slug);

        $this->forward404Unless($this->page && $this->page['is_active'] == true);
*/

        $culture = $this->getUser()->getCulture();

        $this->page = Doctrine::getTable('StaticPage')
                        ->createQuery('sp')
                        ->innerJoin('sp.Translation spt')
                        ->where('spt.slug = ? AND spt.is_active = ? AND spt.lang = ?', array($slug, 1, $culture))
                        ->fetchOne();

        $this->forward404Unless($this->page);
    }

    // ex. http://www.getlokal.com/mobile_dev.php/api201/event?token=eea05e007a12c7b8dee730ab4de98eb2&id=8285&locale=bg
    // http://www.getlokal.com/mobile_dev.php/api201/event?token=eea05e007a12c7b8dee730ab4de98eb2&id=8256&locale=bg&lat=42.681173&long=23.310819
	public function executeEvent(sfWebRequest $request) {
		//$this->forward404Unless($this->event = Doctrine::getTable('Event')->find($request->getParameter('id')));

        $con = Doctrine::getConnectionByTableName('Company');
		$lat = $con->quote($request->getParameter('lat'));
		$lng = $con->quote($request->getParameter('long'));

		$this->forward404Unless($lat || $lng);

        $sql = "((ACOS(SIN(%s * PI() / 180) * SIN(cl.latitude * PI() / 180) + COS(%s * PI() / 180) * COS(cl.latitude * PI() / 180) * COS((%s - cl.longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as kms";
        $kms = sprintf($sql, $lat, $lat, $lng);


        $this->event = Doctrine::getTable('Event')
                        ->createQuery('e')
                        ->addSelect('e.*, t.*, ep.*, cp.*, co.*, cl.*')
                        ->addSelect($kms)
                        ->innerJoin('e.Translation t')
                        ->leftJoin ('e.EventPage ep')
                        ->leftJoin('ep.CompanyPage cp')
                        ->leftJoin('cp.Company co')
                        ->leftJoin('co.CompanyLocation cl')
                        ->where('e.id = ?', $request->getParameter('id'))
                        ->fetchOne();

        $this->forward404Unless($this->event);


		$this->comments = Doctrine::getTable('Comment')
                            ->createQuery('c')
                            ->innerJoin('c.UserProfile p')
                            ->innerJoin('p.sfGuardUser')
                            ->innerJoin('c.ActivityComment ac')
                            ->leftJoin('c.Parent')
                            //->where('c.activity_id = ?', $this->event->getEventActivity()->getId())
                            ->orderBy('c.created_at DESC')
                            ->limit(20)->execute();

		$this->no_rspv = Doctrine::getTable('EventUser')
                            ->createQuery('eu')
                            ->andWhere('eu.event_id = ?', $this->event->getId())
                            ->andWhere('eu.confirm = 1')
                            ->count();

        if ($this->event->getFirstCompany()) {
            //http://www.getlokal.com/mobile_dev.php/api201/company?token=eea05e007a12c7b8dee730ab4de98eb2&id=14360&locale=bg&lat=42.681173&long=23.310819
            //getlokal://location?COMPANY_ID, ex. getlokal://location?11223344
            //$this->companyUrl = $this->generateUrl('default', array('module' => 'api201', 'action' => 'company', 'id' => $this->event->getFirstCompany()->getId(), 'token' => $request->getParameter('token'), 'locale' => $this->getUser()->getCulture()), true);
            $this->companyUrl = 'getlokal://location?' . $this->event->getFirstCompany()->getId();
        }
        else {
            $this->companyUrl = '';
        }
	}

	public function executeCheckin(sfWebRequest $request) {
 		$this->checkToken($request->getParameter('token'));
		sfForm::disableCSRFProtection();

		$this->forward404Unless($company = Doctrine::getTable('Company')->find($request->getParameter('identifier')));

        // Remove old checkin status
        $status = Doctrine::getTable('CheckInStatus')
                    ->createQuery('ci')
                    ->where('ci.user_id = ?', $this->getUser()->getId())
                    ->fetchOne();

        if ($status) {
            $status->delete();
        }


        // Add a new checkin status
        $checkInStatus = new CheckInStatus();
		$checkInStatus->setUserId($this->getUser()->getId());
		$checkInStatus->setCompanyId($company->getId());
		$checkInStatus->setLatitude($request->getParameter('lat'));
		$checkInStatus->setLongitude($request->getParameter('long'));
		$checkInStatus->save();


        // Add a new checkin log!!!
		$checkin = new CheckIn();
		$checkin->setUserId($this->getUser()->getId());
		$checkin->setCompanyId($company->getId());
		$checkin->setLatitude($request->getParameter('lat'));
		$checkin->setLongitude($request->getParameter('long'));
		$checkin->save();

		$return = array('status' => 'SUCCESS');

		$this->getResponse ()->setContent(json_encode($return));
		return sfView::NONE;
	}

    // See the user prifile on mobile device
	public function executeCheckinList(sfWebRequest $request) {
		$this->checkToken($request->getParameter('token'));

        $con = Doctrine::getConnectionByTableName('search');
        $lat = $con->quote($request->getParameter('lat'));
        $lng = $con->quote($request->getParameter('long'));

        $this->forward404Unless($lat || $lng);

        $km_sql = "((ACOS(SIN(%s * PI() / 180) * SIN(l.latitude * PI() / 180) + COS(%s * PI() / 180) * COS(l.latitude * PI() / 180) * COS((%s - l.longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as kms";
        $kms = sprintf($km_sql, $lat, $lat, $lng);

        sfContext::getInstance()->getConfiguration()->loadHelpers('Asset');

        $company_query = Doctrine::getTable('Company')
                            ->createQuery('c')
                            ->innerJoin('c.Location l')
                            ->innerJoin('c.CheckIn ci')
                            ->addSelect("c.id, c.*, , l.*, ci.*")
                            ->addSelect($kms)
                            ->where('ci.user_id = ? ', $this->getUser()->getId())->orderBy('kms')
                            ->limit(15);

        foreach ($company_query->execute() as $company) {
            $is_favorite = Doctrine::getTable('Company')
                            ->createQuery('c')
                            ->innerJoin('c.CompanyPage p')
                            ->innerJoin('p.Follow f')
                            ->where('f.user_id = ?', $this->getUser()->getId())->andWhere('c.id = ?', $company->getId())
                            ->count();

            $return[] = array('identifier' => $company->getId(), 'title' => $company->getCompanyTitleByCulture(), 'phone' => $company->getPhoneFormated($company->getPhone(), $this->getUser()->getCulture()), 'address' => $company->getDisplayAddress(), 'ppp' => $company->getActivePPPService(true) ? 1 : 0, 'favourite' => $is_favorite, 'rating' => $company->getAverageRating(), 'reviews' => $company->getNumberOfReviews(), 'lat' => $company->getLocation()->getLatitude(), 'long' => $company->getLocation()->getLongitude(), 'distance' => $company->kms, 'icon' => 'marker_' . $company->getSectorId(), 'picture_url' => image_path($company->getThumb(0, true), true), 'share_url' => 'http://www.getlokal.' . $this->getUser()->getDomain() . '/' . $this->getUser()->getCulture() . '/' . $company->getCity()->getSlug() . '/' . $company->getSlug(), 'content_url' => $this->generateUrl('default', array('module' => 'api201', 'action' => 'company', 'id' => $company->getId(), 'token' => $request->getParameter('token'), 'locale' => $this->getUser()->getCulture()), true));
        }

        $this->getResponse()->setContent(json_encode($return));
        return sfView::NONE;
	}

    // List of news and events...
    public function executeNews(sfWebRequest $request) {
		$con = Doctrine::getConnectionByTableName('search');
        $lat = $con->quote($request->getParameter('lat'));
        $lng = $con->quote($request->getParameter('long'));
        $this->forward404Unless($lat || $lng);

        // For news
        $sql = "((ACOS(SIN(%s * PI() / 180) * SIN(c.lat * PI() / 180) + COS(%s * PI() / 180) * COS(c.lat * PI() / 180) * COS((%s - c.lng) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as kms";
        $kms = sprintf($sql, $lat, $lat, $lng);

        // For events
        $sql2 = "((ACOS(SIN(%s * PI() / 180) * SIN(cl.latitude * PI() / 180) + COS(%s * PI() / 180) * COS(cl.latitude * PI() / 180) * COS((%s - cl.longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as distance";
        $kms2 = sprintf($sql2, $lat, $lat, $lng);

        sfContext::getInstance()->getConfiguration()->loadHelpers('Asset');
        $i18n = $this->getContext()->getI18N();

        $start_date = date('Y-m-d');
        $end_date = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + 30, date('Y')));

        // News
		$items = Doctrine::getTable('MobileNews')
                ->createQuery('n')
                ->addSelect('n.*')
                ->addSelect($kms)
                ->limit($request->getParameter('section', 0) != 0 ? 1 : 9 )
                ->innerJoin('n.MobileNewsCity sc')
                ->innerJoin('sc.City c')
                ->having('kms < 50')
                ->orderBy('n.rank, n.created_at DESC')
                ->where('n.is_active = ?', true)
                ->execute();

        // Events
        $events = Doctrine::getTable('Event')
                ->createQuery('e')
                ->addSelect('e.*, t.*, c.*, ep.*, cp.*, co.*, cl.*, i.*, ca.*')
                ->addSelect($kms)
                ->addSelect($kms2)
                ->innerJoin('e.Category ca')
                ->innerJoin('e.Translation t')
                ->innerJoin('e.City c')
                ->leftJoin('e.EventPage ep')
                ->leftJoin('ep.CompanyPage cp')
                ->leftJoin('cp.Company co')
                ->leftJoin('co.CompanyLocation cl')
                ->leftJoin('e.Image i')
                ->limit(15)
                ->addWhere('e.start_at >= ? and e.start_at <= ?', array($start_date, $end_date))
                ->orderBy('e.start_at')
                ->having('kms < 50')
                ->execute();

		$possitions = $returnItems = array();

        $start = 0;
        $end = count($events);
        foreach ($items as $item) {
            $start = min($item->getRank(), $start);
            $end = max($item->getRank(), $end);

            $possitions[$item->getRank()][] = $item;
        }

        for($i = $start; $i <= $end; $i ++) {
			if (isset($possitions[$i])) {
                foreach ($possitions [$i] as $news_item) {
                    if ($news_item)
                        $returnItems[] = array('identifier' => $news_item->getId(), 'type' => 2, 'internal' => 1, 'title' => $news_item->getTitle(), 'details1' => $news_item->getLine1(), 'details2' => $news_item->getLine2(), 'detauls3' => '', 'picture_url' => $news_item->getThumb(1), 'big_picture_url' => $news_item->getThumb(), 'content_url' => $news_item->getLink());
                }
            }

            if (isset($events[$i])) { //foreach($events as $event)
                $event = $events[$i];

                if ($event->getDateTimeObject('start_at')->format('Y-m-d') == date('Y-m-d')) {
                    $date = $i18n->__('Today') . ' ';
                }
                elseif ($event->getDateTimeObject('start_at')->sub(new DateInterval('P1D'))->format('Y-m-d') == date('Y-m-d')) {
                    $date = $i18n->__('Tomorrow') . ' ';
                }
                else {
                    $date = $i18n->__($event->getDateTimeObject('start_at')->format('l'));
                }

                $date .= ' (' . $event->getDateTimeObject('start_at')->format('d.m.Y') . ')';

                // Calculate event image size
                /*if (!count($returnItems)) {
                    $imageSize = 0;
                }
                else {
                    $imageSize = 1;
                }*/


                // Get an event places
                $places = array();

                if (count($event->getEventPage())) {
                    $eventPages = $event->getEventPage();

                    foreach($eventPages as $eventPage) {
                        $company = $eventPage->getCompanyPage()->getCompany();

                        $places[] = array(
                            'identifier' => $company->getId(),
                            'title' => $company->getCompanyTitleByCulture(),
                            'ppp' => ($company->getActivePPPService(true) ? 1 : 0),
                            'favourite' => $is_favorite = Doctrine::getTable('Company')->createQuery('c')->innerJoin('c.CompanyPage p')->innerJoin('p.Follow f')->where('f.user_id = ?', $this->getUser()->getId())->andWhere('c.id = ?', $company->getId())->count(),
                            'rating' => $company->getAverageRating(),
                            'reviews' => $company->getNumberOfReviews (),
                            'picture_url' => image_path($company->getThumb(0, true), true),
                            'share_url' => 'http://www.getlokal.' . $this->getUser ()->getDomain () . '/' . $this->getUser ()->getCulture () . '/' . $company->getCity ()->getSlug () . '/' . $company->getSlug (),
                            'content_url' => $this->generateUrl('default', array('module' => 'api201', 'action' => 'company', 'id' => $company->getId(), 'token' => $request->getParameter('token'), 'locale' => $this->getUser()->getCulture()), true)
                        );
                    }
                }

                $returnItems[] = array(
                    'identifier' => $event->getId(),
                    'type' => 1,
                    'internal' => 0,
                    'title' => $event->getTitle(),
                    'share_url' => 'http://www.getlokal.' . $this->getUser()->getDomain() . '/' . $this->getUser()->getCulture() . '/d/event/show/id/' . $event->getId(),
                    'details1' => $date,
                    'details2' => $event->getPrice() ? $i18n->__('Ticket: ') . $event->getPriceValue() : '',
                    'details3' => $event->getFirstCompany() ? $event->getFirstCompany()->getTitle() . ' (' . number_format($event->distance, 2) . ' km)' : '',
                    'category' => $event->getCategory(),
                    'picture_url' => image_path($event->getThumb(), true),
                    'big_picture_url' => image_path($event->getThumb(0), true),
                    'content_url' => $this->generateUrl('default', array('module' => 'api201', 'action' => 'event', 'id' => $event->getId(), 'country' => $this->getUser()->getCountry()->getSlug(), 'locale' => $this->getUser()->getCulture()), true),
                    'places' => $places
                );
            }
		}

        $return = array('status' => 'SUCCESS', 'items' => $returnItems);
		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}

    // List of sectors - see search (Explore)
    public function executeSectorslist(sfWebRequest $request) {
        $this->checkToken($request->getParameter('token'));

        $sectors = Doctrine::getTable('Sector')
                    ->createQuery('s')
                    ->innerJoin('s.Translation t')
                    ->where('s.is_active')
                    ->andWhereIn('s.id', $this->visibleSectors)
                    ->addOrderBy('t.title ASC')
                    ->execute();

        $return = null;

        $i18n = $this->getContext ()->getI18N ();

        foreach ($sectors as $sector) {
            if ($sector->getId() == 16) {
                $sectorTitle = $i18n->__('ATMs');
            }
            else {
                $sectorTitle = $sector->getTitle();
            }

            $return[] = array('identifier' => $sector->getId(), 'title' => $sectorTitle, 'icon' => 'marker_' . $sector->getId());
        }

        return $this->renderText(json_encode(array('status' => 'SUCCESS', 'items' => $return)));
    }

    // List of classifications - see add a place
	public function executeClassificationslist(sfWebRequest $request) {
		$this->checkToken($request->getParameter('token'));

        $classifications = Doctrine::getTable('Classification')
                            ->createQuery('c')
                            ->innerJoin('c.Translation t')
                            ->innerJoin('c.PrimarySector s')
                            ->where('t.is_active = 0 AND c.status = 1')
                            ->andWhere('t.lang = ? ', $this->getUser()->getCulture())
                            //->andWhereIn('s.id', $this->visibleSectors)
                            ->addOrderBy('t.title ASC ')
                            ->execute();

        $return = null;

        foreach ($classifications as $classification) {
            // Show only ATM`s from "Money & Finance" sector, id = 16
            /*
            if (in_array(16, $this->visibleSectors) && $classification->getSectorId() == 16 && $classification->getId() != 155) {
                continue;
            }
            */

            $return['classifications'][] = array('identifier' => $classification->getId(), 'title' => $classification->getTitle(), 'icon' => 'marker_' . $classification->getSectorId());
        }

        $this->getResponse()->setContent(json_encode($return));
        return sfView::NONE;
	}

    // Search only in cities DB
	public function executeGetCitiesAutocomplete(sfWebRequest $request) {

        $culture = $this->getUser()->getCulture();
        $this->getResponse()->setContentType('application/json');

        $q = "%" . $request->getParameter('term') . "%";
        $countryId = $request->getParameter('country_id', null);

        $limit = $request->getParameter('limit', 15);

        // FIXME: use $limit
        $dql = Doctrine_Query::create()
                ->from('City c')
                ->innerJoin('c.Translation ct')
                ->where('ct.name LIKE ?', $q)
                ->limit($limit);

        if ($countryId) {
            $dql = $dql->innerJoin('c.County cnty')->addWhere('cnty.country_id = ?', $countryId);
        }

        $this->rows = $dql->execute();

        $cities = array();
        foreach ($this->rows as $row) {
            $value = $row->getLocation($culture) .
                ', ' . $row->getCounty()->getCountyNameByCulture($culture) .
                ', ' . $row->getCounty()->getCountry()->getCountryNameByCulture($culture);
            $cities[] = array('id' => $row['id'], 'value' => $value);

        }

        return $this->renderText(json_encode($cities));

	}

    // Search everywhere (cities, countries)
	public function executeGetLocationAutocomplete(sfWebRequest $request) {
        $this->checkToken($request->getParameter('token'));

		$culture = $this->getUser()->getCulture();
        $this->getResponse()->setContentType('application/json');

        $param = "%" . $request->getParameter('term') . "%";
        $limit = $request->getParameter('limit', 10);
        $result = $cities_names = array();

        // FIXME: use $limit
        $dql = Doctrine_Query::create()
                ->from('City c')
                ->where('c.name LIKE ? OR c.name_en LIKE ?', array($param, $param))
                ->limit($limit);

        $this->rows = $dql->execute();

        $cities_dql = Doctrine_Query::create()
                        ->select('c.name')
                        ->from('City c')
                        ->groupBy('c.name')
                        ->having('COUNT(c.name) > 1')
                        ->andwhere('c.name LIKE ? OR c.name_en LIKE ?', array($param, $param));

        $cities_names = $cities_dql->fetchArray();

        $partner_class = getlokalPartner::getLanguageClass(getlokalPartner::getInstance());

        foreach ($this->rows as $row) {
            if ($this->in_array_r($row->getName(), $cities_names)) {
                if ($culture == 'en') {
                    $result[] = array('identifier' => $row['id'], 'title' => $row->getLocation() . ', ' . mb_convert_case(call_user_func(array('Transliterate' . $partner_class, 'toLatin'), $row->getCounty()->getName()), MB_CASE_TITLE, 'UTF-8') . ', ' . mb_convert_case(call_user_func(array('Transliterate' . $partner_class, 'toLatin'), $row->getCounty()->getCountry()->getName()), MB_CASE_TITLE, 'UTF-8'), 'country' => 0);
                } else {
                    //$cities[] = array('identifier' => $row['id'], 'title' => $row->getLocation() . ', ' . mb_convert_case($row->getCounty()->getName(), MB_CASE_TITLE, 'UTF-8') . ', ' . mb_convert_case(call_user_func(array('Transliterate' . $partner_class, 'toLatin'), $row->getCounty()->getCountry()->getName()), MB_CASE_TITLE, 'UTF-8'));
                    $result[] = array('identifier' => $row['id'], 'title' => $row->getLocation() . ', ' . mb_convert_case($row->getCounty()->getName(), MB_CASE_TITLE, 'UTF-8') . ', ' . mb_convert_case($row->getCounty()->getCountry()->getName(), MB_CASE_TITLE, 'UTF-8'), 'country' => 0);
                }
            } else {
                if ($culture == 'en') {
                    $result[] = array('identifier' => $row['id'], 'title' => $row->getLocation() . ', ' . mb_convert_case(call_user_func(array('Transliterate' . $partner_class, 'toLatin'), $row->getCounty()->getCountry()->getName()), MB_CASE_TITLE, 'UTF-8'), 'country' => 0);
                } else {
                    //$cities[] = array('identifier' => $row['id'], 'title' => $row->getLocation() . ', ' . mb_convert_case(call_user_func(array('Transliterate' . $partner_class, 'toLatin'), $row->getCounty()->getCountry()->getName()), MB_CASE_TITLE, 'UTF-8'));
                    $result[] = array('identifier' => $row['id'], 'title' => $row->getLocation() . ', ' . mb_convert_case($row->getCounty()->getCountry()->getName(), MB_CASE_TITLE, 'UTF-8'), 'country' => 0);
                }
            }
        }


        // Trying to search in countries
        $countriesList = Doctrine::getTable('Country')
                ->createQuery('c')
                ->where('c.name LIKE ? OR c.name_en LIKE ?', array($param, $param))
                ->limit($limit)
                ->execute();

        foreach ($countriesList as $country) {
            if ($culture == 'en') {
                $result[] = array('identifier' => $country->getId(), 'title' => mb_convert_case(call_user_func(array('Transliterate' . $partner_class, 'toLatin'), ($country->getName() ? $country->getName() : $country->getNameEn()) ), MB_CASE_TITLE, 'UTF-8'), 'country' => 1);
            }
            else {
                $result[] = array('identifier' => $country->getId(), 'title' => mb_convert_case(($country->getName() ? $country->getName() : $country->getNameEn()), MB_CASE_TITLE, 'UTF-8'), 'country' => 1);
            }
        }

        $return = array('status' => 'ok', 'items' => $result);
        return $this->renderText(json_encode($return));
	}

    // Search in classification list
    public function executeGetClassificationsAutocomplete(sfWebRequest $request) {
        $this->checkToken($request->getParameter('token'));

		$culture = $this->getUser()->getCulture();
        $this->getResponse()->setContentType('application/json');

        $param = "%" . $request->getParameter('term') . "%";
        $limit = $request->getParameter('limit', 10);

        $query =    "SELECT * FROM classification c
                    INNER JOIN classification_translation c2 ON c.id = c2.id AND (c2.lang = '{$culture}')
                    WHERE c2.title LIKE '{$param}' OR c2.keywords LIKE '{$param}'
                    ORDER BY c2.title
                    LIMIT {$limit}";

        $con = Doctrine::getConnectionByTableName('classification');
        $result = $con->execute($query);

        $return = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
            $return[] = array(
                'identifier' => $row['id'],
                'title' => $row['title'],
                'sector' => $row['sector_id']
            );
        }

        $this->getResponse()->setContent(json_encode(array('status' => 'ok', 'items' => $return)));

        return sfView::NONE;
    }

    // test action
    // ex. http://www.getlokal.com/mobile_dev.php/api201/test
	public function executeTest() {
        //
	}

    //-------------------------------------------------------------------------------------------------------------------------------------//

	public function executeLogin(sfWebRequest $request) {
		sfForm::disableCSRFProtection ();
		$form = new sfGuardFormSignin ();

		$form->bind ( array ('username' => $request->getParameter ( 'username' ), 'password' => $request->getParameter ( 'password' ) ) );

		if ($form->isValid ()) {
			$login = new ApiLogin ();
			$login->setUserId ( $form->getValue ( 'user' )->getId () );
			$login->save ();

			$return = array ('status' => 'SUCCESS', 'token' => $login->getToken () );
		} else {
			$return = array ('status' => 'ERROR', 'error' => array_merge ( $form->getErrorSchema ()->getGlobalErrors (), $form->getErrorSchema ()->getErrors () ) );
		}

		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}

	public function executeRegister(sfWebRequest $request) {
		sfForm::disableCSRFProtection ();

		$access_token = $request->getParameter ( 'access_token', null );
		$accept = ($request->getParameter ( 'accept', 0 ) == 1 ? true : null);

		$city = $country = null;
		if ($access_token) {
			$form = new RegisterMobileForm ( null, array ('fb' => true ) );
			$form->useFields ( array ('email_address', 'first_name', 'last_name', 'allow_contact', 'accept', 'location' ) );
			$form->bind ( array ('email_address' => $request->getParameter ( 'username' ), 'first_name' => $request->getParameter ( 'firstname' ), 'last_name' => $request->getParameter ( 'lastname' ), 'allow_contact' => $request->getParameter ( 'allow_contact', 0 ), 'accept' => $accept, 'location' => $request->getParameter ( 'location' ) ) );

		} else {
			$form = new RegisterMobileForm ();
			$form->useFields ( array ('email_address', 'password', 'first_name', 'last_name', 'allow_contact', 'accept', 'location' ) );
			$form->bind ( array ('email_address' => $request->getParameter ( 'username' ), 'password' => $request->getParameter ( 'password' ), 'first_name' => $request->getParameter ( 'firstname' ), 'last_name' => $request->getParameter ( 'lastname' ), 'allow_contact' => $request->getParameter ( 'allow_contact', 0 ), 'accept' => $accept, 'location' => $request->getParameter ( 'location' ) ) );

		}

		if ($form->isValid ()) {
			if (is_numeric ( $request->getParameter ( 'location' ) )) {

				$city = Doctrine::getTable ( 'City' )->findOneById ( $request->getParameter ( 'location' ) );
				if ($city) {
					$country = $city->getCounty ()->getCountry ();
				} else {
					//todo
				}

			} else {
				if ($request->getParameter ( 'location' ) != '') {

					$location_string = explode ( ',', $request->getParameter ( 'location' ) );
					if (isset ( $location_string [0] ) && isset ( $location_string [1] )) {
						$city_string = trim ( $location_string [0] );
						$country_string = trim ( $location_string [1] );
					} elseif (! isset ( $location_string [1] )) {
						$city_string = trim ( $location_string [0] );
						$country_string = null;
					} else {
						$city_string = trim ( $request->getParameter ( 'location' ) );
					}

					$city = Doctrine::getTable ( 'City' )->createQuery ( 'c' )->where ( 'c.name LIKE ? OR c.name_en LIKE ?', array ($city_string, $city_string ) )->fetchOne ();

					if ($city) {
						if ($country_string) {
							$country = Doctrine::getTable ( 'Country' )->createQuery ( 'c' )->where ( 'c.name LIKE ? OR c.name_en LIKE ?', array ($country_string, $country_string ) )->fetchOne ();
						}
						if (! $country or $country->getId () != $city->getCounty ()->getCountryId ()) {
							$country = $city->getCountry ();

						}

					} else {
						//


						$con = Doctrine::getConnectionByTableName ( 'SfGuardUser' );
						$lat = $con->quote ( $request->getParameter ( 'lat' ) );
						$lng = $con->quote ( $request->getParameter ( 'long' ) );
						$this->forward404Unless ( $lat || $lng );

						$key = "AIzaSyDDZGSZsZTNuGUImUPcFXOEWObG6GX0I08";

						$latlng = urlencode ( $lat . ',' . $lng );

						$url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=" . str_replace ( '\'', '', $lat . ',' . $lng ) . "&sensor=false&language=en";
                        sfContext::getInstance()->getLogger()->emerg('GEOCODE: 7');

						$string = file_get_contents ( $url ); // get json content
						$json_a = json_decode ( $string, true );
						$ch = curl_init ();

						curl_setopt ( $ch, CURLOPT_URL, $url );
						curl_setopt ( $ch, CURLOPT_HEADER, 0 ); //Change this to a 1 to return headers
						curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
						curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );

						$results = curl_exec ( $ch );
						curl_close ( $ch );

						if (isset ( $results [0] ) && isset ( $json_a ['results'] [0] ['address_components'] )) {

							foreach ( $json_a ['results'] [0] ['address_components'] as $key => $val ) {

								if ($val ['types'] [0] == 'locality') {
									$j_City = $val ['long_name'];

									$city = Doctrine::getTable ( 'City' )->createQuery ( 'c' )->where ( 'c.name LIKE ? OR c.name_en LIKE ?', array ($j_City, $j_City ) )->fetchOne ();
									if ($city) {
										$country = $city->getCounty ()->getCountry ();

										foreach ( $json_a ['results'] [0] ['address_components'] as $key1 => $val1 ) {
											if ($val1 ['types'] [0] == 'country') {
												$j_country = $val1 ['long_name'];

                                                // Added c.name in SQL clause
												$jcountry = Doctrine::getTable ( 'Country' )->createQuery ( 'c' )->where ( 'c.name LIKE "%' . $j_country . '%" OR c.name_en LIKE "%' . $j_country . '%"' )->fetchOne ();

												if ($jcountry) {
													if ($jcountry->getId () > 4 or $city->getCounty ()->getCountryId () != $jcountry->getId ()) {
														$city = null;
														$country = $jcountry;
														break;
													}

												}

												break;
											}

										}

									} else

									{

										foreach ( $json_a ['results'] [0] ['address_components'] as $key2 => $val2 ) {
											if ($val2 ['types'] [0] == 'country') {
												$j_country1 = $val2 ['long_name'];

                                                // Added c.name in SQL clause
												$jcountry1 = Doctrine::getTable ( 'Country' )->createQuery ( 'c' )->where ( 'c.name LIKE "%' . $j_country1 . '%" OR c.name_en LIKE "%' . $j_country1 . '%"' )->fetchOne ();

												if ($jcountry1) {

													$country = $jcountry1;

												}

												break;
											}

										}

									}

								}

							}

						}

		//
					}

				} else {

					$con = Doctrine::getConnectionByTableName ( 'SfGuardUser' );
					$lat = $con->quote ( $request->getParameter ( 'lat' ) );
					$lng = $con->quote ( $request->getParameter ( 'long' ) );
					$this->forward404Unless ( $lat || $lng );

					$key = "AIzaSyDDZGSZsZTNuGUImUPcFXOEWObG6GX0I08";

					$latlng = urlencode ( $lat . ',' . $lng );

					$url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=" . str_replace ( '\'', '', $lat . ',' . $lng ) . "&sensor=false&language=en";
                    sfContext::getInstance()->getLogger()->emerg('GEOCODE: 8');

					$string = file_get_contents ( $url ); // get json content
					$json_a = json_decode ( $string, true );
					$ch = curl_init ();

					curl_setopt ( $ch, CURLOPT_URL, $url );
					curl_setopt ( $ch, CURLOPT_HEADER, 0 ); //Change this to a 1 to return headers
					curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
					curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );

					$results = curl_exec ( $ch );
					curl_close ( $ch );

					if (isset ( $results [0] ) && isset ( $json_a ['results'] [0] ['address_components'] )) {

						foreach ( $json_a ['results'] [0] ['address_components'] as $key => $val ) {

							if ($val ['types'] [0] == 'locality') {
								$j_City = $val ['long_name'];

								$city = Doctrine::getTable ( 'City' )->createQuery ( 'c' )->where ( 'c.name LIKE ? OR c.name_en LIKE ?', array ($j_City, $j_City ) )->fetchOne ();
								if ($city) {
									$country = $city->getCounty ()->getCountry ();

									foreach ( $json_a ['results'] [0] ['address_components'] as $key1 => $val1 ) {
										if ($val1 ['types'] [0] == 'country') {
											$j_country = $val1 ['long_name'];

                                            // Added c.name in SQL clause
											$jcountry = Doctrine::getTable ( 'Country' )->createQuery ( 'c' )->where ( 'c.name LIKE "%' . $j_country . '%" OR c.name_en LIKE "%' . $j_country . '%"' )->fetchOne ();

											if ($jcountry) {
												if ($jcountry->getId () > 4 or $city->getCounty ()->getCountryId () != $jcountry->getId ()) {
													$city = null;
													$country = $jcountry;
													break;
												}

											}

											break;
										}

									}

								} else

								{

									foreach ( $json_a ['results'] [0] ['address_components'] as $key2 => $val2 ) {
										if ($val2 ['types'] [0] == 'country') {
											$j_country1 = $val2 ['long_name'];

                                            // Added c.name in SQL clause
											$jcountry1 = Doctrine::getTable ( 'Country' )->createQuery ( 'c' )->where ( 'c.name LIKE "%' . $j_country1 . '%" OR c.name_en LIKE "%' . $j_country1 . '%"' )->fetchOne ();

											if ($jcountry1) {

												$country = $jcountry1;

											}

											break;
										}

									}

								}

							}

						}

					}

				}

			}

			if ($city == null && $country == null) {
				$city = $this->getUser ()->getCity ();
				$country = $this->getUser ()->getCountry ();
			} elseif ($city == null && $country && $country->getId () <= 4) {
				$city = Doctrine::getTable ( 'City' )->createQuery ( 'c' )->innerJoin ( 'c.County co' )->where ( 'co.country_id = ?', $country->getId () )->orderBy ( 'c.is_default DESC' )->limit ( 1 )->fetchOne ();
			}

			$user = new sfGuardUser ();
			$user->fromArray ( $form->getValues () );
			$user->setUsername ( myTools::cleanUrl ( $user->getFirstName () ) . '.' . rand ( 1000, 9999 ) );
			if ($access_token) {
				$password = substr ( md5 ( rand ( 100000, 999999 ) ), 0, 8 );
				$user->setPassword ( $password );
			}
			$user->save ();

			$profile = new UserProfile ();
			$profile->setId ( $user->getId () );
			$profile->setCityId ( $city ? $city->getId () : null );
			$profile->setCountryId ( $country ? $country->getId () : null );

			if ($access_token) {

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

				curl_setopt ( $ch, CURLOPT_URL, "https://graph.facebook.com/me/picture?type=large&" . $access_token );

				$temp_pic = sfConfig::get ( 'sf_upload_dir' ) . '/' . uniqid ( 'tmp_' ) . '.jpg';
				file_put_contents ( $temp_pic, curl_exec ( $ch ) );

				$file = new sfValidatedFile ( myTools::cleanUrl ( $user_data ['name'] ) . '.jpg', filetype ( $temp_pic ), $temp_pic, filesize ( $temp_pic ) );

				$gender = null;
				if (isset ( $user_data ['gender'] ) && $user_data ['gender'] == 'male') {
					$gender = 'm';
				} elseif (isset ( $user_data ['gender'] ) && $user_data ['gender'] == 'female') {
					$gender = 'f';
				}
				$date = DateTime::createFromFormat ( 'm/d/Y', $user_data ['birthday'] );
				$profile->setBirthDate ( $date->format ( 'Y-m-d' ) );
				$profile->setFacebookUrl ( $user_data ['link'] );
				$profile->setFacebookUid ( $user_data ['id'] );
				$profile->setGender ( $gender );
				$profile->setAccessToken ( $access_token );
			}

			$profile->save ();

			$user_settings = new UserSetting ();
			$user_settings->setId ( $profile->getId () );

			if ($request->getParameter ( 'allow_contact' ) == 0) {
				$user_settings->setAllowContact ( false );
				$user_settings->setAllowNewsletter ( false );
			} else {
				$user_settings->setAllowContact ( true );
				$user_settings->setAllowNewsletter ( true );
				$user_settings->setAllowPromo ( true );
			}
			$user_settings->save ();

			$newsletters = NewsletterTable::retrieveActivePerCountryForUser ( $profile->getCountryId () );
			if ($newsletters) {
				foreach ( $newsletters as $newsletter ) {
					$usernewsletter = new NewsletterUser ();
					$usernewsletter->setNewsletterId ( $newsletter->getId () );
					$usernewsletter->setUserId ( $user->getId () );
					$usernewsletter->setIsActive ( $request->getParameter ( 'allow_contact' ) );
					$usernewsletter->save ();
				}

				MC::subscribe_unsubscribe ( $user );
			}

			$login = new ApiLogin ();
			$login->setUserId ( $user->getId () );
			$login->setExpiresAt ( date ( 'Y-m-d H:i:s', time () + (30 * 86400) ) );
			$login->save ();

			//myTools::sendMail ( $user, 'Welcome to getlokal', 'activation', array ('user' => $user ) );

            // Success mail
            //myTools::sendMail($user, 'Welcome to getlokal', 'successRegisteration');

			$return = array ('status' => 'SUCCESS', 'token' => $login->getToken () );
		} else {
			$return = array ('status' => 'ERROR', 'error' => $this->getErrors ( $form ) );
		}

		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;

	}
	/*
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

				myTools::sendMail ( $user, 'Welcome to getlokal', 'fbRegister', array ('password' => $password ) );
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

		$return = array ('status' => 'SUCCESS', 'token' => $login->getToken () );

		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}

	*/

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

	public function executePhotos(sfWebRequest $request) {
        $return = array('status' => 'SUCCESS', 'photos' => array());

        $images = $request->getParameter('type', 0) == 0 ? $this->getCompanyImages() : $this->getEventImages();
        foreach ($images as $image) {
            $return ['photos'] [] = array('url' => $image->getImage()->getThumb('preview', true), 'caption' => ($image->getImage()->getDescription() ? $image->getImage()->getDescription() : $image->getImage()->getCaption()));
        }

        $this->getResponse()->setContent(json_encode($return));
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

	public function executeReview(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );
		$this->forward404Unless ( $company = Doctrine::getTable ( 'Company' )->find ( $request->getParameter ( 'identifier' ) ) );
		sfForm::disableCSRFProtection ();
		$review = null;
		$image_array = $review_array = array ();
		$form = new ReviewImageForm ();
		$form->bind ( array ('rating' => $request->getParameter ( 'rating' ), 'text' => $request->getParameter ( 'review' ), 'file' => $request->getParameter ( 'file' ) ), $request->getFiles () );

		if ($form->isValid ()) {
			if ($request->getParameter ( 'rating' ) && $request->getParameter ( 'review' )) {
				$review = new Review ();
				$review->fromArray ( $form->getValues () );
				$review->setCompanyId ( $company->getId () );
				$review->setUserId ( $this->getUser ()->getId () );
                $this->getResponse()->setCookie('from', MobileLog::getOs());
				$review->save ();
			}
			if ($form->getValue ( 'file' )) {

				$image = new Image ();
				$image->setFile ( $form->getValue ( 'file' ) );
				$image->setUserId ( $this->getUser ()->getId () );
				$image->setStatus ( 'approved' );
				$image->setType ( 'company' );
				$image->save ();

				$company_image = new CompanyImage ();
				$company_image->setCompanyId ( $company->getId () );
				$company_image->setImageId ( $image->getId () );
				$company_image->save ();

				if (! $company->getImageId ()) {
					$company->setImageId ( $image->getId () );
					$company->save ();
				}
				$image_array = array ('identifier' => $image->getId (), 'url' => $image->getThumb ( 'preview', true ), 'caption' => $image->getDescription () );
			}
			if (! empty ( $image_array )) {
				$return = array_merge ( array ('status' => 'SUCCESS' ), $image_array );
			} else {
				$return = array ('status' => 'SUCCESS' );
			}

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
			$return [] = array ('identifier' => $company->getId (), 'title' => $company->getCompanyTitleByCulture (), 'ppp' => ($company->getActivePPPService ( true ) ? 1 : 0), 'phone' => $company->getPhoneFormated($company->getPhone(), $this->getUser()->getCulture()), 'address' => $company->getDisplayAddress (), 'favourite' => 1, 'rating' => $company->getAverageRating (), 'reviews' => $company->getNumberOfReviews (), 'lat' => $company->getLocation ()->getLatitude (), 'long' => $company->getLocation ()->getLongitude (), 'distance' => $company->kms, 'icon' => 'marker_' . $company->getSectorId (), 'picture_url' => image_path ( $company->getThumb ( 0, true ), true ), 'share_url' => 'http://www.getlokal.' . $this->getUser ()->getDomain () . '/' . $this->getUser ()->getCulture () . '/' . $company->getCity ()->getSlug () . '/' . $company->getSlug (), 'content_url' => $this->generateUrl ( 'default', array ('module' => 'api201', 'action' => 'company', 'id' => $company->getId (), 'token' => $request->getParameter ( 'token' ), 'locale' => $this->getUser ()->getCulture () ), true ) );

		}

		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}

	public function executeFavorite(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );
		$company = Doctrine::getTable ( 'Company' )->find ( $request->getParameter ( 'identifier' ) );
		if (! $company) {
			$return = array ('status' => 'ERROR', 'error' => 'Place Not Found' );
			$this->getResponse ()->setContent ( json_encode ( $return ) );
			return sfView::NONE;
		}
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
			$return [] = array ('id' => $company->getId (), 'ppp' => $company->getActivePPPService ( true ) ? 1 : 0, 'title' => $company->getCompanyTitleByCulture (), 'stars' => $company->getAverageRating (), 'review_count' => $company->getNumberOfReviews (), 'distance' => $company->kms, 'latitude' => $company->getLocation ()->getLatitude (), 'longitude' => $company->getLocation ()->getLongitude (), 'icon' => 'marker_' . $company->getSectorId (), 'phone' => $company->getPhoneFormated($company->getPhone(), $this->getUser()->getCulture()), 'address' => $company->getDisplayAddress (),

			'picture_url' => image_path ( $company->getThumb ( 0, true ), true ), 'share_url' => 'http://www.getlokal.' . $this->getUser ()->getDomain () . '/' . $this->getUser ()->getCulture () . '/' . $company->getCity ()->getSlug () . '/' . $company->getSlug (), 'content_url' => $this->generateUrl ( 'default', array ('module' => 'api201', 'action' => 'company', 'id' => $company->getId (), 'token' => $request->getParameter ( 'token' ), 'locale' => $this->getUser ()->getCulture () ), true ) );
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
			$return [] = array ('id' => $company->getId (), 'title' => $company->getCompanyTitleByCulture (), 'stars' => $company->getAverageRating (), 'review_count' => $company->getNumberOfReviews (), 'distance' => $company->kms, 'latitude' => $company->getLocation ()->getLatitude (), 'longitude' => $company->getLocation ()->getLongitude (), 'icon' => image_path ( 'gui/icons/small_marker_' . $company->getSectorId (), true ), 'phone' => $company->getPhoneFormated($company->getPhone(), $this->getUser()->getCulture()), 'address' => $company->getDisplayAddress (), 'picture_url' => image_path ( $company->getThumb ( 0, true ), true ), 'url' => 'http://www.getlokal.ro/ro/' . $company->getCity ()->getSlug () . '/' . $company->getSlug () );
		}

		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}

	public function executeSearchNear(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );
		$con = Doctrine::getConnectionByTableName ( 'search' );
		$lat = $con->quote ( $request->getParameter ( 'lat' ) );
		$lng = $con->quote ( $request->getParameter ( 'long' ) );

		$city = $country = null;
		$use_coords = $keyword_sql = false;
		$keyword = $request->getParameter ( 'keyword', null );
		$where = $request->getParameter ( 'where', null );
		$classification = $request->getParameter ( 'classification', null );
		$start_index = $request->getParameter ( 'start_index', 0 );
		$end_index = $request->getParameter ( 'end_index', 14 );
		$res_count = $end_index - $start_index;
		if (! $where && ! $keyword && ! $classification) {
			$this->forward404Unless ( $lat || $lng );
		}

		if (is_numeric ( $where ) && ($where != - 1)) {

			$city = Doctrine::getTable ( 'City' )->findOneById ( $where );
			if ($city) {
				$country = $city->getCounty ()->getCountry ();

                // Sergo fix
                $new_lat = $city->getLat();
                $new_lng = $city->getLng();
			} else {
				//todo
			}

		} elseif ($where != '' && $where != -1) {

			$location_string = explode ( ',', $where );
			if (isset ( $location_string [0] ) && isset ( $location_string [1] )) {
				$city_string = trim ( $location_string [0] );
				$country_string = trim ( $location_string [1] );
			} elseif (! isset ( $location_string [1] )) {
				$city_string = trim ( $location_string [0] );
				$country_string = null;
			} else {
				$city_string = trim ( $where );
			}

			$city = Doctrine::getTable ( 'City' )->createQuery ( 'c' )->where ( 'c.name LIKE ? OR c.name_en LIKE ?', array ($city_string, $city_string ) )->fetchOne ();

			if ($city) {
				if ($country_string) {
					$country = Doctrine::getTable ( 'Country' )->createQuery ( 'c' )->where ( 'c.name LIKE ? OR c.name_en LIKE ?', array ($country_string, $country_string ) )->fetchOne ();
				}
				if (! $country or $country->getId () != $city->getCounty ()->getCountryId ()) {
					$country = $city->getCountry ();

				}

                // Sergo fix
                $new_lat = $city->getLat();
                $new_lng = $city->getLng();
			} else {
				//


				$con = Doctrine::getConnectionByTableName ( 'CompanyLocation' );

				$this->forward404Unless ( $lat || $lng );

				$key = "AIzaSyDDZGSZsZTNuGUImUPcFXOEWObG6GX0I08";

				$address = urlencode ( $where );

				$url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&sensor=false&language=" . $this->getUser ()->getCulture ();
                sfContext::getInstance()->getLogger()->emerg('GEOCODE: 9');

				$string = file_get_contents ( $url ); // get json content
				$json_a = json_decode ( $string, true );
				$ch = curl_init ();

				curl_setopt ( $ch, CURLOPT_URL, $url );
				curl_setopt ( $ch, CURLOPT_HEADER, 0 ); //Change this to a 1 to return headers
				curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
				curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );

				$results = curl_exec ( $ch );
				curl_close ( $ch );

				if (isset ( $results [0] ) && isset ( $json_a ['results'] [0] ['geometry'] )) {
					if (isset ( $json_a ['results'] [0] ['geometry'] ['location'] ['lat'] ) && isset ( $json_a ['results'] [0] ['geometry'] ['location'] ['lng'] )) {
						$new_lat = $json_a ['results'] [0] ['geometry'] ['location'] ['lat'];
						$new_lng = $json_a ['results'] [0] ['geometry'] ['location'] ['lng'];
						$use_coords = true;
					} else {

						foreach ( $json_a ['results'] [0] ['address_components'] as $key => $val ) {

							if ($val ['types'] [0] == 'locality') {
								$j_City = $val ['long_name'];

								$city = Doctrine::getTable ( 'City' )->createQuery ( 'c' )->where ( 'c.name LIKE ? OR c.name_en LIKE ?', array ($j_City, $j_City ) )->fetchOne ();
								if ($city) {

									$country = $city->getCounty ()->getCountry ();

									foreach ( $json_a ['results'] [0] ['address_components'] as $key1 => $val1 ) {
										if ($val1 ['types'] [0] == 'country') {
											$j_country = $val1 ['long_name'];

											$jcountry = Doctrine::getTable ( 'Country' )->createQuery ( 'c' )->where ( 'c.name_en LIKE "%' . $j_country . '%"' )->fetchOne ();

											if ($jcountry) {
												if ($jcountry->getId () > 4 or $city->getCounty ()->getCountryId () != $jcountry->getId ()) {
													$city = null;
													$country = $jcountry;
													break;
												}

											}

											break;
										}

									}

								} else

								{

									foreach ( $json_a ['results'] [0] ['address_components'] as $key2 => $val2 ) {
										if ($val2 ['types'] [0] == 'country') {
											$j_country1 = $val2 ['long_name'];
											$jcountry1 = Doctrine::getTable ( 'Country' )->createQuery ( 'c' )->where ( 'c.name_en LIKE "%' . $j_country1 . '%"' )->fetchOne ();

											if ($jcountry1) {

												$country = $jcountry1;

											}

											break;
										}

									}

								}

							}

						}
					}

				}

		//
			}

		}

		if (! $use_coords) {
			if (! $city or ! $country or ! $where) {
				$use_coords = true;
			}
		}
		$ids = array (0 );
		$con = mysqli_connect ( sfConfig::get ( 'app_search_host' ), null, null, null, sfConfig::get ( 'app_search_port' ) );
		sfContext::getInstance ()->getConfiguration ()->loadHelpers ( 'Asset' );

		$km_sql = "((ACOS(SIN(%s * PI() / 180) * SIN(l.latitude * PI() / 180) + COS(%s * PI() / 180) * COS(l.latitude * PI() / 180) * COS((%s - l.longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as kms";
		$kms = sprintf ( $km_sql, $lat, $lat, $lng );
		$query_string = null;

		if (isset ( $new_lat ) && isset ( $new_lng )) {
			$lat = $new_lat;
			$lng = $new_lng;
		}

		$lat = str_replace ( '\'', '', $lat );
		$lng = str_replace ( '\'', '', $lng );

		$lat_rad = ( float ) deg2rad ( $lat );
		$lng_rad = ( float ) deg2rad ( $lng );

		if ($classification && is_numeric ( $classification )) {

			$gl_classification = Doctrine::getTable ( 'Classification' )->findOneById ( $classification );
			if ($gl_classification) {
				$sql = "SELECT *, geodist(  $lat, $lng, latitude, longitude)  as distance, score as total_score
              FROM search
              WHERE  classification_id = " . $classification;

			} else {

				$sql = "SELECT *, geodist(  $lat_rad, $lng_rad , lat_rad, lng_rad)  as distance, score as total_score
              FROM search";

			}

			if (! $use_coords) {
				$sql .= " AND city_id = {$city->getId()} ORDER BY total_score DESC ";
			} else {
				$sql .= " ORDER BY distance ASC, total_score DESC";
			}

		//exit($sql);
		} elseif ($keyword or ($classification && ! is_numeric ( $classification ))) {
			if (! $keyword) {
				$keyword = $classification;

			}

			$query_string = $this->_EscapeSphinxQL ( $keyword );
			$sql = "SELECT *, geodist(  $lat_rad, $lng_rad , lat_rad, lng_rad)  as distance, @weight * score as total_score
            FROM search
            WHERE MATCH('{$query_string}')";
			if (! $use_coords) {
				$sql .= " AND city_id = {$city->getId()} ORDER BY total_score DESC ";
			} else {
				$sql .= " ORDER BY distance ASC, total_score DESC";
			}
			$used_sql = $sql;
			$sql .= " OPTION field_weights=( title = 2, description = 2, extra_keywords = 2 , detail_description = 2, review = 1, keywords = 1 )";

			$keyword_sql = true;
		}

		else {

			// $query_string = $this->_EscapeSphinxQL($text);
			//return ($lat_rad. ' ' . $lng_rad); exit();


			$sql = "SELECT *, geodist(  $lat_rad, $lng_rad , lat_rad, lng_rad ) as distance,
			IF(distance <= 1000.00, 1 , IF(distance <= 2000.00, 2 , IF(distance <= 7000.00, 3 , IF(distance <= 15000.00, 4 , IF(distance <= 20000.00, 5 , IF(distance <= 50000.00, 6 , IF(distance <= 100000.00, 7 , 8))))))) as proximity_reg,
			score as total_score
              FROM search
              /*
              OLD
              WHERE sector_id < 11 AND proximity_reg < 7
              */
              WHERE sector_id IN (" . implode(',', $this->visibleSectors) . ") AND proximity_reg < 7
              ORDER BY proximity_reg ASC, total_score DESC ";
		}
		$reg = array ();
		mysqli_query ( $con, "SET NAMES utf8" );

		$results = mysqli_query ( $con, $sql ) or die ( mysqli_error ( $con ) );

		$item_count_array = mysqli_fetch_array($results) ;
		$item_count = count($item_count_array);
		if ($keyword_sql) {
			$sql = $used_sql;
		}
		$sql .= " LIMIT $start_index, $end_index";
		if ($keyword_sql) {
			$sql .= " OPTION field_weights=( title = 2, description = 2, extra_keywords = 2 , detail_description = 2, review = 1, keywords = 1 )";

		}
		$results = mysqli_query ( $con, $sql ) or die ( mysqli_error ( $con ) );

		while ( $row = mysqli_fetch_assoc ( $results ) ) {
			$ids [] = $row ['id'];

		}

		$company_query = Doctrine::getTable ( 'Company' )->createQuery ( 'c' )->innerJoin ( 'c.City ct' )->innerJoin ( 'c.Location l' )->innerJoin ( 'c.Classification cl' )->innerJoin ( 'cl.Translation clt WITH clt.lang = ?', $this->getUser ()->getCulture () )->innerJoin ( 'c.Sector se' )->innerJoin ( 'se.Translation set WITH set.lang = ?', $this->getUser ()->getCulture () )->leftJoin ( 'c.AdServiceCompany adc WITH adc.ad_service_id = 11 AND adc.active_from <= '.ProjectConfiguration::nowAlt().' AND adc.status = "active" AND ((adc.active_to is null AND adc.crm_id is not null) OR (adc.active_to >= '.ProjectConfiguration::nowAlt().' AND  adc.crm_id is null))' )->leftJoin ( 'c.Image i' )->leftJoin ( 'c.TopReview tr' )->leftJoin ( 'tr.UserProfile up' )->leftJoin ( 'up.sfGuardUser sf' )->addSelect ( 'c.*, l.*, i.*, ct.*, tr.*, ac.*, cl.*, clt.*, se.*, set.*, up.*, sf.*' )->addSelect ( $kms )->whereIN ( 'c.id', $ids )->andWhere ( 'c.status = ?', 0 )->orderBy ( 'FIELD(c.id,' . implode ( ',', $ids ) . ')' )->limit ( $res_count );

        $items = null;
		foreach ( $company_query->execute () as $company ) {
			$ppp = $company->getActivePPPService ( true ) ? 1 : 0;
			$is_favorite = Doctrine::getTable ( 'Company' )->createQuery ( 'c' )->innerJoin ( 'c.CompanyPage p' )->innerJoin ( 'p.Follow f' )->where ( 'f.user_id = ?', $this->getUser ()->getId () )->andWhere ( 'c.id = ?', $company->getId () )->count ();
			$items [] = array ('identifier' => $company->getId (), 'score' => $company->getScore (), 'sector' => $company->getSectorId (), 'title' => $company->getCompanyTitleByCulture (), 'phone' => $company->getPhoneFormated($company->getPhone(), $this->getUser()->getCulture()), 'address' => $company->getDisplayAddress (), 'ppp' => $ppp, 'ppp_review_text' => (($ppp == 1 && $company->getTopReview ()) ? $company->getTopReview ()->getText () : null), 'ppp_review_picture' => (($ppp == 1 && ($company->getTopReview () && $company->getTopReview ()->getUserProfile ())) ? image_path ( $company->getTopReview ()->getUserProfile ()->getThumb () ) : null), 'favourite' => $is_favorite, 'rating' => $company->getAverageRating (), 'reviews' => $company->getNumberOfReviews (), 'lat' => $company->getLocation ()->getLatitude (), 'long' => $company->getLocation ()->getLongitude (), 'distance' => $company->kms, 'icon' => 'marker_' . $company->getSectorId (), 'picture_url' => image_path ( $company->getThumb ( 0, true ), true ), 'share_url' => 'http://www.getlokal.' . $this->getUser ()->getDomain () . '/' . $this->getUser ()->getCulture () . '/' . $company->getCity ()->getSlug () . '/' . $company->getSlug (), 'content_url' => $this->generateUrl ( 'default', array ('module' => 'api201', 'action' => 'company', 'id' => $company->getId (), 'token' => $request->getParameter ( 'token' ), 'locale' => $this->getUser ()->getCulture () ), true ) );
		}

		$return = array_merge ( array ('item_count' => $item_count ), array ('items' => $items ) );
		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}

	private function _EscapeSphinxQL($string) {
		$from = array ('\\', '(', ')', '|', '-', '!', '@', '~', '"', '&', '/', '^', '$', '=', "'", "\x00", "\n", "\r", "\x1a" );
		$to = array ('\\\\', '\\\(', '\\\)', '\\\|', '\\\-', '\\\!', '\\\@', '\\\~', '\\\"', '\\\&', '\\\/', '\\\^', '\\\$', '\\\=', "\\'", "\\x00", "\\n", "\\r", "\\x1a" );

		return str_replace ( $from, $to, $string );
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

			$company_image = new CompanyImage ();
			$company_image->setCompanyId ( $company->getId () );
			$company_image->setImageId ( $image->getId () );
			$company_image->save ();

            if (!$company->getImageId()) {
                $company->setImageId($image->getId());
                $company->save();
            }

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

	public function executeValidatephoto(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );
		$image = Doctrine::getTable ( 'Image' )->createQuery ( 'i' )->where ( 'i.id = ? ', $request->getParameter ( 'photoid' ) )->andWhere ( 'i.user_id = ?', $this->getUser ()->getId () )->fetchOne ();

		if (! $image) {
			$return = array ('status' => 'ERROR', 'error' => 'Object Not Found' );
			$this->getResponse ()->setContent ( json_encode ( $return ) );
			return sfView::NONE;
		}

		$image->setCaption ( $request->getParameter ( 'text' ) );
		$image->setStatus ( 'approved' );
		$image->save ();

		$company = $image->getCompany ();
		if ($company && ! $company->getImageId ()) {
			$company->setImageId ( $image->getId () );
			$company->save ();
		}
		$return = array ('status' => 'SUCCESS', 'identifier' => $image->getId (), 'url' => $image->getThumb ( 'preview', true ), 'caption' => $image->getDescription () );

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

			$this->forward ( 'api201', 'stop' );
		} else {
			$this->getUser()->setAttribute('user_id', $login->getUserId(), 'sfGuardSecurityUser');
            $this->getUser()->setAttribute('currency', $login->getSfGuardUser()->getUserProfile()->getCity()->getCounty()->getCountry()->getCurrency(), 'sfGuardSecurityUser');
		}

		return true;
	}

	public function forward404Unless($condition, $message = null) {
		if (! $condition) {
			$return = array ('status' => 'ERROR', 'error' => 'No items found', 'error_code' => 4 );

			$this->getResponse ()->setContent ( json_encode ( $return ) );
			$this->forward ( 'api201', 'stop' );
		}
	}

	private function getErrors($form) {
		$errors = array ();
		foreach ( $form->getErrorSchema ()->getErrors () as $key => $error )
			$errors [$key] = '' . $error;

		return $errors;
	}

	public function executeCompanyoffers(sfWebRequest $request) {

		$this->forward404Unless ( $item = Doctrine::getTable ( 'Company' )->find ( $this->getRequest ()->getParameter ( 'identifier' ) ) );

		$offers = $item->getAllOffers ( true );

		$return = array ('status' => 'SUCCESS', 'offers' => array () );
		if ($offers) {
			foreach ( $offers as $offer ) {
				$return ['offers'] [] = array ('title' => $offer->getDisplayTitle (), 'description' => $offer->getDisplayDescription (), 'image' => $offer->getThumb ( 'preview', true ), 'active_to' => $offer->getActiveTo (), 'valid_from' => $offer->getValidFrom (), 'valid_to' => $offer->getValidTo (), 'max_vouchers' => $offer->getMaxVouchers (), 'max_per_user' => $offer->getMaxPerUser (), 'can_be_claimed' => ($offer->getIsAvailableToOrder () ? 1 : 0) );
			}
		}

		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;

	}

	public function executeMyvouchers(sfWebRequest $request) {

		$this->checkToken ( $request->getParameter ( 'token' ) );
		sfContext::getInstance ()->getConfiguration ()->loadHelpers ( 'Asset' );

		$profile = Doctrine::getTable ( 'UserProfile' )->createQuery ( 'p' )->innerJoin ( 'p.sfGuardUser' )->leftJoin ( 'p.City' )->where ( 'p.id = ?', $this->getUser ()->getId () )->fetchOne ();

		$vouchers = VoucherTable::getVouchers ( $profile, false, false );

		$return = array ('status' => 'SUCCESS', 'vouchers' => array () );
		if ($vouchers) {
			foreach ( $vouchers as $voucher ) {
				$offer = $voucher->getCompanyOffer ();
				$return ['vouchers'] [] = array ('identifier' => $voucher->getCode (), 'offer' => array ('title' => $offer->getDisplayTitle (), 'description' => $offer->getDisplayDescription (), 'image' => $offer->getThumb ( 'preview', true ), 'active_to' => $offer->getActiveTo (), 'valid_from' => $offer->getValidFrom (), 'valid_to' => $offer->getValidTo (), 'max_vouchers' => $offer->getMaxVouchers (), 'max_per_user' => $offer->getMaxPerUser (), 'can_be_claimed' => ($offer->getIsAvailableToOrder () ? 1 : 0) ) );
			}
		}

		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;

	}

	public function executeClaimoffer(sfWebRequest $request) {

		$this->checkToken ( $request->getParameter ( 'token' ) );
		sfContext::getInstance ()->getConfiguration ()->loadHelpers ( 'Asset' );

		$this->forward404Unless ( $item = Doctrine::getTable ( 'CompanyOffer' )->find ( $this->getRequest ()->getParameter ( 'identifier' ) ) );
		$count = $this->getRequest ()->getParameter ( 'count', 1 );
		if ($item->getIsActive () && $item->getIsAvailableToOrder ( $this->getUser ()->getId () )) {
			if ($count == 1) {
				$user_voucher = new Voucher ();
				$user_voucher->setUserId ( $this->getUser ()->getId ()->getId () );
				$user_voucher->setCompanyOfferId ( $item->getId () );
				$user_voucher->setCode ( substr ( uniqid ( md5 ( $item->getCode () . rand () ), true ), 0, 8 ) );
				$user_voucher->save ();
                                
                                MobileLog::log('getvoucher', $item->getId());
			} else {
				$i = 0;
				while ( $i < $count ) {
					$i ++;
					$user_voucher = new Voucher ();
					$user_voucher->setUserId ( $this->getUser ()->getId () );
					$user_voucher->setCompanyOfferId ( $item->getId () );
					$user_voucher->setCode ( substr ( uniqid ( md5 ( $item->getCode () . rand () ), true ), 0, 8 ) );
					$user_voucher->save ();
                                        
                                        MobileLog::log('getvoucher', $item->getId());

				}

			}
			$item->updateNumberOfVouchers ();
			$return = array ('status' => 'SUCCESS', 'voucher' => array ('identifier' => $user_voucher->getCode (), 'offer' => array ('title' => $item->getDisplayTitle (), 'description' => $item->getDisplayDescription (), 'image' => $item->getThumb ( 'preview', true ), 'active_to' => $item->getActiveTo (), 'valid_from' => $item->getValidFrom (), 'valid_to' => $item->getValidTo (), 'max_vouchers' => $item->getMaxVouchers (), 'max_per_user' => $item->getMaxPerUser (), 'can_be_claimed' => ($item->getIsAvailableToOrder () ? 1 : 0) ) ) );
		} else {
			$i18n = $this->getContext ()->getI18N ();
			$return = array ('status' => 'ERROR', 'error' => $i18n->__ ( 'We were unable to issue your voucher. The offer is no longer active or you have already ordered the maximum number vouchers per user.' ) );
		}

		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;

	}
	public function executeReport(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );
		$this->company = Doctrine::getTable ( 'Company' )->findOneById ( $request->getParameter ( 'identifier' ) );
		if (! $this->company) {
			$return = array ('status' => 'ERROR', 'error' => 'Object Not Found' );
			$this->getResponse ()->setContent ( json_encode ( $return ) );
			return sfView::NONE;
		}
		$user = Doctrine::getTable ( 'sfGuardUser' )->findOneById ( $this->getUser ()->getId () );

		$report = new ReportCompany ();
		$report->fromArray ( array ('user_id' => $user->getId (), 'email' => $user->getEmailAddress (), 'name' => $user->getFirstName () . ' ' . $user->getLastName (), 'object_id' => $this->company->getId () ) );

		sfForm::disableCSRFProtection ();

		$form = new ReportMobileForm ( $report );

		$form->bind ( array ('offence' => $request->getParameter ( 'offence' ) ) );
		if ($form->isValid ()) {
			$form->save ();
			$return = array ('status' => 'SUCCESS' );
		} else {
			$return = array ('status' => 'ERROR', 'error' => array_merge ( $form->getErrorSchema ()->getGlobalErrors (), $form->getErrorSchema ()->getErrors () ) );
		}
		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}

	public function executeAddnewplace(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );
		sfForm::disableCSRFProtection ();

		$company = new Company ();
        $company->setStatus(CompanyTable::VISIBLE);
		$company_location = new CompanyLocation ();
		$company_location->setCompany ( $company );
		$company_location->setIsActive ( 1 );

		$form = new CompanyMobileForm ( $company );
		$con = Doctrine::getConnectionByTableName ( 'company' );
		$lat = $con->quote ( $request->getParameter ( 'lat' ) );
		$lng = $con->quote ( $request->getParameter ( 'long' ) );
		$this->forward404Unless ( $lat || $lng );

		$form->bind ( array ('title' => $request->getParameter ( 'title' ), 'location' => $request->getParameter ( 'location' ), 'address' => $request->getParameter ( 'address' ), 'classification_id' => $request->getParameter ( 'classification_id' ), 'phone' => $request->getParameter ( 'phone' ) ) );

		if ($form->isValid ()) {

			$remove = array (',', ';', ':', '"', '„', '”', '“', '(', ')', '№', '&ndash;' );

			$title = trim ( str_replace ( $remove, ' ', $request->getParameter ( 'title' ) ) );

            $partnerClass = getlokalPartner::getLanguageClass();
            $titleEn = call_user_func(array('Transliterate' . $partnerClass, 'toLatin'), $title);

			$classification = Doctrine::getTable ( 'Classification' )->findOneById ( $request->getParameter ( 'classification_id' ) );
			$company->setTitle ( $title );
			$company->setTitleEn ( $titleEn );
			$company->setClassificationId ( $request->getParameter ( 'classification_id' ) );
			$company->setSectorId ( $classification->getPrimarySector ()->getId () );
			$company->setPhone(str_replace('+', '00', $request->getParameter('phone')));
			$company_location->setLatitude ( $request->getParameter ( 'lat' ) );
			$company_location->setLongitude ( $request->getParameter ( 'long' ) );

			$company_classification = new CompanyClassification ();
			$company_classification->setCompany ( $company );
			$company_classification->setClassificationId ( $request->getParameter ( 'classification_id' ) );

			$key = "AIzaSyDDZGSZsZTNuGUImUPcFXOEWObG6GX0I08";

			if ($request->getParameter ( 'address', null ) != '') {
				$address = urlencode ( $request->getParameter ( 'location' ) . ', ' . $request->getParameter ( 'address' ) );

				$url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&sensor=false&language=" . $this->getUser ()->getCulture ();
			} else {
				$url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=" . str_replace ( '\'', '', $lat . ',' . $lng ) . "&sensor=false&language=en";
			}
            sfContext::getInstance()->getLogger()->emerg('GEOCODE: 10');
			$string = file_get_contents ( $url ); // get json content
			$json_a = json_decode ( $string, true );
			$ch = curl_init ();

			curl_setopt ( $ch, CURLOPT_URL, $url );
			curl_setopt ( $ch, CURLOPT_HEADER, 0 ); //Change this to a 1 to return headers
			curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );

			$results = curl_exec ( $ch );
			curl_close ( $ch );

			if (isset ( $results [0] ) && isset ( $json_a ['results'] [0] ['address_components'] )) {

				//TODO


				foreach ( $json_a ['results'] [0] ['address_components'] as $key => $val ) {
					//start
					if ($val ['types'] [0] == 'street_number') {
						$company_location->setStreetNumber ( $val ['long_name'] );

					} elseif ($val ['types'] [0] == 'route') {
						$list_street_types = array ('булевард' => 1, 'улица' => 6, 'площад' => 5, 'шосе' => 17, 'bulevard' => 1, 'ulitsa' => 6, 'ploshtad' => 5,

						'Bulevardul' => 1, 'Cartier' => 2, 'Strada' => 6, 'Calea' => 10, 'Prelungirea' => 12, 'Piata' => 5, 'Drumul' => 14, 'Intrarea' => 7, 'Șoseaua' => 17, 'Aleea' => 18 );

						$list_neighbourhood_types = array ('жк' => 2, 'кв.' => 3, 'м.' => 4, 'п.к.' => 7, 'к-с' => 8 );

						$str_long_name = $val ['long_name'];
						$firstword = explode ( " ", $str_long_name, 2 );

						$term = $firstword [0];
						$str_long_name = trim ( str_replace ( $remove, ' ', $str_long_name ) );
						$rest = trim ( str_replace ( $term, '', $str_long_name ) );

						if (isset ( $list_street_types [$term] )) {
							$company_location->setStreetTypeId ( $list_street_types [$term] );
							$company_location->setSublocation ( $str_long_name );
							$company_location->setStreet ( $rest );
							$company_location->setLocationType ( '' );
							$company_location->setNeighbourhood ( '' );
							$company_location->setBuildingNo ( '' );

						} elseif (isset ( $list_neighbourhood_types [$term] )) {

							$company_location->setStreetTypeId ( '' );
							$company_location->setSublocation ( $str_long_name );
							$company_location->setStreet ( '' );
							$company_location->setLocationType ( $list_neighbourhood_types [$term] );
							$company_location->setNeighbourhood ( $rest );
							$company_location->setBuildingNo ( '' );

						} else {
							$company_location->setStreetTypeId ( '' );
							$company_location->setSublocation ( $str_long_name );
							$company_location->setStreet ( $str_long_name );
							$company_location->setLocationType ( '' );
							$company_location->setNeighbourhood ( '' );
							$company_location->setBuildingNo ( '' );

						}

					} elseif ($val ['types'] [0] == 'locality') {

						$j_City = $val ['long_name'];

						$city = Doctrine::getTable ( 'City' )->createQuery ( 'c' )->where ( 'c.name LIKE ? OR c.name_en LIKE ?', array ($j_City, $j_City ) )->fetchOne ();
						if ($city) {
							$country = $city->getCounty ()->getCountry ();

							foreach ( $json_a ['results'] [0] ['address_components'] as $key1 => $val1 ) {
								if ($val1 ['types'] [0] == 'country') {
									$j_country = $val1 ['long_name'];

									$jcountry = Doctrine::getTable ( 'Country' )->createQuery ( 'c' )->where ( 'c.name_en LIKE "%' . $j_country . '%"' )->fetchOne ();

									if ($jcountry) {
										if ($jcountry->getId () > 4 or $city->getCounty ()->getCountryId () != $jcountry->getId ()) {
											$city = null;
											$country = $jcountry;
											break;
										}

									}

									break;
								}

							}

						} else

						{

							foreach ( $json_a ['results'] [0] ['address_components'] as $key2 => $val2 ) {
								if ($val2 ['types'] [0] == 'country') {
									$j_country1 = $val2 ['long_name'];
									$jcountry1 = Doctrine::getTable ( 'Country' )->createQuery ( 'c' )->where ( 'c.name_en LIKE "%' . $j_country1 . '%"' )->fetchOne ();

									if ($jcountry1) {

										$country = $jcountry1;

									}

									break;
								}

							}

						}
						$company->clearRelated ( 'City' );
						$company->setCityId ( $city->getId () );
						$company->setCountryId ( $country->getId () );

					} //else {
				//return 'bbb';


				//}


				//end
				}

				$company->save ();
				$company_location->save ();
				$company->setLocation ( $company_location );
				$company->save ();
				$company_classification->save ();

			}

			$return = array ('status' => 'SUCCESS', 'indentifier' => $company->getId () );
		} else {
			$return = array ('status' => 'ERROR', 'error' => array_merge ( $form->getErrorSchema ()->getGlobalErrors (), $form->getErrorSchema ()->getErrors () ) );
		}
		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}

	protected function in_array_r($needle, $haystack, $strict = true) {
		foreach ( $haystack as $item ) {
			if (($strict ? $item === $needle : $item == $needle) || (is_array ( $item ) && self::in_array_r ( $needle, $item, $strict ))) {
				return true;
			}
		}

		return false;
	}

	public function executeLoginFb(sfWebRequest $request) {
		$profile = $user = null;
		$access_token = $request->getParameter ( 'access_token' );

		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, "https://graph.facebook.com/me?access_token=" . $access_token );
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

		if (! $profile) {
			if (isset ( $user_data ['email'] )) {
				$user = Doctrine::getTable ( 'sfGuardUser' )->findOneByEmailAddress ( $user_data ['email'] );
			}
			if (! $user) {
				$user_data = json_decode ( curl_exec ( $ch ), true );

				// start location


				if (isset ( $facebook_user_data ['location'] ['name'] ) && $facebook_user_data ['location'] ['name']) {
					$location = explode ( ", ", $facebook_user_data ['location'] ['name'] );

					$country = array_pop ( $location );

					$result = Doctrine_Query::create ()->from ( 'Country c' )->where ( 'c.name = ? OR c.name_en = ?', array ($country, $country ) )->fetchOne ();

					if ($result && $result->getId ()) {

						$tmpCountry = $result;
					} else {

						$tmpCountry = $this->getUser ()->getCountry ();
					}

					if ($location) {
						$founded = false;

						foreach ( $location as $locCity ) {
							$city = $locCity;

							$result = Doctrine_Query::create ()->from ( 'City c' )->innerJoin ( 'c.County co' )->where ( 'co.country_id = ?', $tmpCountry->getId () )->where ( 'c.name = ? OR c.name_en = ?', array ($city, $city ) )->fetchOne ();

							if ($result && $result->getId ()) {
								$founded = true;
								$tmpCity = $result;
								break 1;
							}
						}

						if (! $founded) {
							$city = Doctrine::getTable ( 'City' )->createQuery ( 'c' )->innerJoin ( 'c.County co' )->where ( 'co.country_id = ?', $tmpCountry->getId () )->orderBy ( 'c.is_default DESC' )->limit ( 1 )->fetchOne ();

							if ($city) {
								$tmpCity = $city;

							}
						}
					} else {
						$city = Doctrine::getTable ( 'City' )->createQuery ( 'c' )->innerJoin ( 'c.County co' )->where ( 'co.country_id = ?', $tmpCountry->getId () )->orderBy ( 'c.is_default DESC' )->limit ( 1 )->fetchOne ();

						if ($city) {
							$tmpCity = $city;
						}
					}
				} else {

					$con = Doctrine::getConnectionByTableName ( 'SfGuardUser' );
					$lat = $con->quote ( $request->getParameter ( 'lat' ) );
					$lng = $con->quote ( $request->getParameter ( 'long' ) );
					$this->forward404Unless ( $lat || $lng );

					$key = "AIzaSyDDZGSZsZTNuGUImUPcFXOEWObG6GX0I08";

					$latlng = urlencode ( $lat . ',' . $lng );

					$url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=" . str_replace ( '\'', '', $lat . ',' . $lng ) . "&sensor=false&language=en";
                    sfContext::getInstance()->getLogger()->emerg('GEOCODE: 11');
					$string = file_get_contents ( $url ); // get json content
					$json_a = json_decode ( $string, true );
					$ch = curl_init ();

					curl_setopt ( $ch, CURLOPT_URL, $url );
					curl_setopt ( $ch, CURLOPT_HEADER, 0 ); //Change this to a 1 to return headers
					curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
					curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );

					$results = curl_exec ( $ch );
					curl_close ( $ch );

					if (isset ( $results [0] ) && isset ( $json_a ['results'] [0] ['address_components'] )) {

						foreach ( $json_a ['results'] [0] ['address_components'] as $key => $val ) {

							if ($val ['types'] [0] == 'locality') {
								$j_City = $val ['long_name'];

								$city = Doctrine::getTable ( 'City' )->createQuery ( 'c' )->where ( 'c.name LIKE ? OR c.name_en LIKE ?', array ($j_City, $j_City ) )->fetchOne ();
								if ($city) {
									$country = $city->getCounty ()->getCountry ();

									foreach ( $json_a ['results'] [0] ['address_components'] as $key1 => $val1 ) {
										if ($val1 ['types'] [0] == 'country') {
											$j_country = $val1 ['long_name'];

											$jcountry = Doctrine::getTable ( 'Country' )->createQuery ( 'c' )->where ( 'c.name_en LIKE "%' . $j_country . '%"' )->fetchOne ();

											if ($jcountry) {
												if ($jcountry->getId () > 4 or $city->getCounty ()->getCountryId () != $jcountry->getId ()) {
													$city = null;
													$country = $jcountry;
													break;
												}

											}

											break;
										}

									}

								} else

								{

									foreach ( $json_a ['results'] [0] ['address_components'] as $key2 => $val2 ) {
										if ($val2 ['types'] [0] == 'country') {
											$j_country1 = $val2 ['long_name'];
											$jcountry1 = Doctrine::getTable ( 'Country' )->createQuery ( 'c' )->where ( 'c.name_en LIKE "%' . $j_country1 . '%"' )->fetchOne ();

											if ($jcountry1) {

												$country = $jcountry1;

											}

											break;
										}

									}

								}

							}

						}

					}

					$tmpCountry = $country;
					$tmpCity = $city;

					if ($tmpCity == null && $tmpCountry == null) {
						$tmpCity = $this->getUser ()->getCity ();
						$tmpCountry = $this->getUser ()->getCountry ();
					} elseif ($tmpCity == null && $tmpCountry && $tmpCountry->getId () <= 4) {
						$tmpCity = Doctrine::getTable ( 'City' )->createQuery ( 'c' )->innerJoin ( 'c.County co' )->where ( 'co.country_id = ?', $country->getId () )->orderBy ( 'c.is_default DESC' )->limit ( 1 )->fetchOne ();
					}

		//


				}
				/*
                $user = new MUser();
				$user->setFirstName($user_data['first_name']);
				$user->setLastName($user_data['last_name']);
				$user->setEmailAddress($user_data['email']);
				$user->setCityId($tmpCityId);
				$user->setCountryId($tmpCountryId);
				*/
				$country_name = (('en' == $this->getUser ()->getCulture ()) ? $tmpCountry->getNameEn () : (($tmpCountry->getName () != '' && $tmpCountry->getName () != '') ? $tmpCountry->getName () : $tmpCountry->getNameEn ()));
				$return = array ('status' => 'SUCCESS', 'first_name' => $user_data ['first_name'], 'last_name' => $user_data ['last_name'], 'email_address' => $user_data ['email'], 'location' => $tmpCity->getLocation () . ', ' . $country_name );
				$this->getResponse ()->setContent ( json_encode ( $return ) );
				return sfView::NONE;
			} else {
				if (! $user->getPassword ()) {
					$password = substr ( md5 ( rand ( 100000, 999999 ) ), 0, 8 );
					$user->setPassword ( $password );
					$user->save ();
				}

				$profile = $user->getUserProfile ();

			}
		}

		if (! $profile->getFacebookUid ())
			$profile->setFacebookUid ( $user_data ['id'] );

		if (! $profile->getCountryId ())
			$profile->setCountryId ( $this->getUser ()->getCountry ()->getId () );

		if (! $profile->getCityId ())
			$profile->setCityId ( $this->getUser ()->getCity ()->getId () );

		$profile->setAccessToken ( $access_token );
		$profile->save ();

		$login = new ApiLogin ();
		$login->setUserId ( $profile->getId () );
		$login->setExpiresAt ( date ( 'Y-m-d H:i:s', time () + (30 * 86400) ) );
		$login->save ();

		$return = array ('status' => 'SUCCESS', 'token' => $login->getToken () );

		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;

	}

	public function executeGetCountriesAutocomplete(sfWebRequest $request) {
		$culture = $this->getUser ()->getCulture ();
		$this->getResponse ()->setContentType ( 'application/json' );

		$q = "%" . $request->getParameter ( 'term' ) . "%";

		$limit = $request->getParameter ( 'limit', 20 );

		// FIXME: use $limit
		$dql = Doctrine_Query::create ()->from ( 'Country c' )->where ( 'c.name LIKE ? OR c.name_en LIKE ?', array ($q, $q ) )->limit ( $limit );

		$this->rows = $dql->execute ();

		$countries = array ();

		foreach ( $this->rows as $row ) {
			if ($culture == 'en') {
				$countries [] = array ('id' => $row ['id'], 'value' => $row ['name_en'] );
			} else {
				if ($row ['name']) {
					$countries [] = array ('id' => $row ['id'], 'value' => $row ['name'] );
				} else {
					$countries [] = array ('id' => $row ['id'], 'value' => $row ['name_en'] );
				}
			}
		}

		return $this->renderText ( json_encode ( $countries ) );
	}

	public function executeWherelist(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );

		$con = Doctrine::getConnectionByTableName ( 'search' );
		$lat = $con->quote ( $request->getParameter ( 'lat' ) );
		$lng = $con->quote ( $request->getParameter ( 'long' ) );
		$this->forward404Unless ( $lat || $lng );

		$key = "AIzaSyDDZGSZsZTNuGUImUPcFXOEWObG6GX0I08";

		$address = urlencode ( $request->getParameter ( 'term' ) );

		$url = 'https://maps.googleapis.com/maps/api/place/autocomplete/json?input=' . $address . '&types=establishment&sensor=false&radius=20000&location=' . str_replace ( '\'', '', $lat . ',' . $lng ) . '&language=' . $this->getUser ()->getCulture () . '&key=' . $key;

		$string = file_get_contents ( $url ); // get json content
		$json_a = json_decode ( $string, true );
		$ch = curl_init ();

		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 ); //Change this to a 1 to return headers
		curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );

		$places = array ();

		$results = curl_exec ( $ch );
		curl_close ( $ch );

		if (isset ( $json_a ['predictions'] )) {
			foreach ( $json_a ['predictions'] as $key => $val ) {

				$places [$val ['description']] = $val ['description'];
			}
		}

		$this->getResponse ()->setContentType ( 'application/json' );

		$this->getResponse ()->setContent ( json_encode ( $places ) );
		return sfView::NONE;
	}

}
