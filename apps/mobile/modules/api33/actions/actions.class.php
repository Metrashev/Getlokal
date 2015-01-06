<?php

//http://itouchmap.com/latlong.html
//http://universimmedia.pagesperso-orange.fr/geo/loc.htm
//http://www.gorissen.info/Pierre/maps/googleMapLocation.php

class api33Actions extends sfActions {
    private
        $visibleSectors = array(
            2,
            4,
            5,
            6,
            7,
            8,
            17,
            18,
            24,
            25,
            27,
        ),

        $visibleClassifications = array(
            4,
            155,
        ),

        $paraziteWords = array(
            'на',
            'за',
            'по',
            'в',
            'във',
            'с',
            'със',
            'под',
            'над',
            'и',
            'от',
            'към',
            'with',
            'to',
            'of',
            'off',
            'in',
            'on',
            'and',
            'АД',
            'ГД',
            'ЕАД',
            'ЕООД',
            'ЕТ',
            'КАД',
            'КД',
            'ООД',
            'СД',
            'ДЗЗД',
            'AD',
            'GD',
            'EAD',
            'EOOD',
            'ЕТ',
            'KAD',
            'KD',
            'OOD',
            'SD',
            'DZZD',
            'ад',
            'гд',
            'еад',
            'еоод',
            'ет',
            'кад',
            'кд',
            'оод',
            'сд',
            'дззд',
            'ad',
            'gd',
            'ead',
            'eood',
            'et',
            'kad',
            'kd',
            'ood',
            'sd',
            'dzzd'
        );

    private function __escapeSphinxQL($string) {
        $from = array('\\', '(', ')', '|', '-', '!', '@', '~', '"', '&', '/', '^', '$', '=', "'", "\x00", "\n", "\r", "\x1a");
        $to = array('\\\\', '\\\(', '\\\)', '\\\|', '\\\-', '\\\!', '\\\@', '\\\~', '\\\"', '\\\&', '\\\/', '\\\^', '\\\$', '\\\=', "\\'", "\\x00", "\\n", "\\r", "\\x1a");

        return str_replace($from, $to, $string);
    }

    private function __getSectorsList($visibleSectors = null) {
        $result = null;

        $query = Doctrine::getTable('Sector')
                ->createQuery('s')
                ->innerJoin('s.Translation t')
                ->where('s.is_active AND t.lang = ?', $this->getUser()->getCulture())
                ->addOrderBy('t.title ASC');

        if ($visibleSectors) {
            $query->andWhereIn('s.id', $visibleSectors);
        }

        $sectors = $query->execute();

        foreach ($sectors as $sector) {
            $result[] = array('identifier' => $sector->getId(), 'title' => $sector->getTitle(), 'icon' => 'marker_' . $sector->getId(), 'cs_type' => 0);
        }

        return $result;
    }

    private function __getClassificationsList($visibleClassifications = null) {
        $result = null;

        $query = Doctrine::getTable('Classification')
                ->createQuery('c')
                ->innerJoin('c.Translation t')
                ->innerJoin('c.PrimarySector s')
                ->where('t.is_active = 0 AND c.status = 1')
                ->andWhere('t.lang = ? ', $this->getUser()->getCulture())
                ->addOrderBy('t.title ASC');

        if ($visibleClassifications) {
            $query->andWhereIn('c.id', $visibleClassifications);
        }

        $classifications = $query->execute();

        foreach ($classifications as $classification) {
            $result[] = array('identifier' => $classification->getId(), 'title' => $classification->getTitle(), 'icon' => 'marker_' . $classification->getSectorId(), 'cs_type' => 1);
        }

        return $result;
    }

    private function __getErrors($form) {
        $errors = array();

        foreach ($form->getErrorSchema()->getErrors() as $key => $error)
            $errors [$key] = '' . $error;

        return $errors;
    }

    private function __checkToken($token) {
        $return = false;
		$i18n = $this->getContext()->getI18N();

        if (!$token || !$login = Doctrine::getTable('ApiLogin')->findOneByToken($token)) {
            $return = array('status' => 'ERROR', 'title' => 'Getlokal', 'error' => $i18n->__('Please login again!'), 'error_code' => 3);
        }

        if (!$return && $login->getDateTimeObject('expires_at')->format('U') < time()) {
            $return = array('status' => 'ERROR', 'title' => 'Getlokal', 'error' => $i18n->__('Please login again!'), 'error_code' => 3);
        }

        if ($return) {
            $this->getResponse()->setContent(json_encode($return));
            $this->setTemplate('false');

            $this->forward('api33', 'stop');
        } else {
            $this->getUser()->setAttribute('user_id', $login->getUserId(), 'sfGuardSecurityUser');
            $this->getUser()->setAttribute('currency', $login->getSfGuardUser()->getUserProfile()->getCity()->getCounty()->getCountry()->getCurrency(), 'sfGuardSecurityUser');
        }

        return true;
    }

    public function preExecute() {
        $request = $this->getRequest();
        $cultures = array('ro', 'en', 'bg', 'mk', 'sr', 'hu', 'fr', 'fi', 'es',
            'pt', 'ru', 'de', 'me', 'ba', 'cz', 'it', 'se', 'sk', 'sl', 'is', 'el');

        $culture = 'en';
        
        if (in_array($request->getParameter('locale', 'en'), $cultures)) {
            $culture = $request->getParameter('locale', 'en');

            if($culture == 'el'){
                $culture = 'gr';
            }
        }
        $this->getUser()->setCulture($culture);
        $country = Doctrine::getTable('Country')->findOneBySlug(
            strtolower($request->getParameter('country', '')));

        if (!$country) {
            $country = new Country();
            $country->setId(1);
            $country->setSlug('bg');
        }

        $this->getUser()->setCountry($country);
    }

    public function executeStop() {
        return sfView::NONE;
    }

    public function forward404Unless($condition, $message = 'No items found.', $code = 4) {
        if (!$condition) {
        	$i18n = $this->getContext()->getI18N();
			
            $return = array(
                'status' => 'ERROR',
                'title' => 'Getlokal',
                'error' => $i18n->__($message),
                'error_code' => $code
            );

            $this->getResponse()->setContent(json_encode($return));
            $this->forward('api33', 'stop');
        }
    }

    private function __debug($msg = '') {
    	$i18n = $this->getContext()->getI18N();
		
        return $this->renderText(json_encode(array('status' => 'ERROR', 'title' => 'Getlokal' ,'error' => $i18n->__($msg), 'error_code' => 99)));
    }

    // ex. http://www.getlokal.com/mobile_dev.php/dev/company?token=eea05e007a12c7b8dee730ab4de98eb2&id=14360&locale=bg
    // http://www.getlokal.com/mobile_dev.php/dev/company?token=eea05e007a12c7b8dee730ab4de98eb2&id=14360&locale=bg&lat=42.681173&long=23.310819
    // http://www.getlokal.com/mobile_dev.php/api201/company?token=eea05e007a12c7b8dee730ab4de98eb2&id=220711&locale=mk&lat=42.681173&long=23.310819
    public function executeCompany(sfWebRequest $request) {
        $this->__checkToken($request->getParameter('token'));

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

        $this->offers = $this->company->getAllOffers();
        
        if ($this->company->getActivePPPService(true)) {
            $this->setTemplate('pppCompany');
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
                    ->where('ep.page_id = ' . $this->company->getCompanyPage()->getId())
                    ->addWhere('e.start_at >= ?', date('Y-m-d') . ' 00:00:00')
                    ->andWhere('e.is_active = 1')
                    ->orderBy('e.start_at ASC')
                    ->execute();
        } else {
            $this->setTemplate('ppCompany');
        }

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
        MobileLog::log('company', $this->company->getId());
    }

    // ex. http://getlokal.com/mobile_dev.php/dev/page/slug/terms-of-use/locale/en
    public function executePage(sfWebRequest $request) {
        $slug = $request->getParameter('slug', null);

        $culture = $this->getUser()->getCulture();

        $this->page = Doctrine::getTable('StaticPage')
                ->createQuery('sp')
                ->innerJoin('sp.Translation spt')
                ->where('spt.slug = ? AND spt.is_active = ? AND spt.lang = ?', array($slug, 1, $culture))
                ->fetchOne();

		if (!$this->page || $this->page->count() == 0) {
          $this->page = Doctrine::getTable('StaticPage')
                  ->createQuery('sp')
                  ->innerJoin('sp.Translation spt')
                  ->where('spt.slug = ? AND spt.is_active = ? AND spt.lang = ?', array($slug, 1, 'en'))
                  ->fetchOne();
        }
		
        $this->forward404Unless($this->page);
    }

    // ex. http://www.getlokal.com/mobile_dev.php/dev/event?token=eea05e007a12c7b8dee730ab4de98eb2&id=8285&locale=bg
    // http://www.getlokal.com/mobile_dev.php/dev/event?token=eea05e007a12c7b8dee730ab4de98eb2&id=8256&locale=bg&lat=42.681173&long=23.310819
    // URL FROM SLIDER TO EVENT https://www.devlokal.com/mobile.php/dev/event/id/2027
    public function executeEvent(sfWebRequest $request) {
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
                ->leftJoin('e.EventPage ep')
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
            //http://www.getlokal.com/mobile_dev.php/dev/company?token=eea05e007a12c7b8dee730ab4de98eb2&id=14360&locale=bg&lat=42.681173&long=23.310819
            //getlokal://location?COMPANY_ID, ex. getlokal://location?11223344
            $this->companyUrl = 'getlokal://location?' . $this->event->getFirstCompany()->getId();
        } else {
            $this->companyUrl = '';
        }
    }

    public function executeCheckin(sfWebRequest $request) {
        $this->__checkToken($request->getParameter('token'));
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

        MobileLog::log('checkin', $company->getId());

        $return = array('status' => 'SUCCESS');

        $this->getResponse()->setContent(json_encode($return));
        return sfView::NONE;
    }

    // See the user prifile on mobile device
    public function executeCheckinList(sfWebRequest $request) {
        $this->__checkToken($request->getParameter('token'));

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
            $culture = $this->getUser()->getCulture();

            $return[] = array(
                'identifier' => $company->getId(),
                'title' => $company->getCompanyTitleByCulture(),
                'phone' => $company->getPhoneFormated($company->getPhone(), $this->getUser()->getCulture()),
                'address' => $company->getDisplayAddress(),
                'ppp' => $company->getActivePPPService(true) ? 1 : 0,
                'favourite' => $is_favorite, 'rating' => $company->getAverageRating(),
                'reviews' => $company->getNumberOfReviews(),
                'lat' => $company->getLocation()->getLatitude(),
                'long' => $company->getLocation()->getLongitude(),
                'distance' => (!is_null($company->kms) ? $company->kms : 0),
                'icon' => 'marker_' . $company->getSectorId(),
                'picture_url' => image_path($company->getThumb(0, true), true),
                'share_url' => 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . '://www.getlokal.' . ($this->getUser()->getDomain($culture) ? $this->getUser()->getDomain($culture). '/' . $culture : 'com/en') . '/' . $company->getCity()->getSlug() . '/' . $company->getSlug(),
                'content_url' => $this->generateUrl('default', array('module' => 'api33', 'action' => 'company', 'id' => $company->getId(), 'token' => $request->getParameter('token'), 'locale' => $this->getUser()->getCulture()), true));
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
        $culture = $this->getUser()->getCulture();
        $filter = $request->getParameter('filter', -1);
        
        // For news
        $sql = "((ACOS(SIN(%s * PI() / 180) * SIN(c.lat * PI() / 180) + COS(%s * PI() / 180) * COS(c.lat * PI() / 180) * COS((%s - c.lng) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as kms";
        $kms = sprintf($sql, $lat, $lat, $lng);

        // For events
        $sql2 = "((ACOS(SIN(%s * PI() / 180) * SIN(cl.latitude * PI() / 180) + COS(%s * PI() / 180) * COS(cl.latitude * PI() / 180) * COS((%s - cl.longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as distance";
        $kms2 = sprintf($sql2, $lat, $lat, $lng);

        $kmsSql = "((ACOS(SIN(%s * PI() / 180) * SIN(l.latitude * PI() / 180) + COS(%s * PI() / 180) * COS(l.latitude * PI() / 180) * COS((%s - l.longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as kms";
        $kmsCompany = sprintf($kmsSql, $lat, $lat, $lng);
        
        sfContext::getInstance()->getConfiguration()->loadHelpers('Asset');
        $i18n = $this->getContext()->getI18N();

        $start_date = date('Y-m-d H:i:s', strtotime('midnight'));
        $end_date = date('Y-m-d H:i:s', strtotime('midnight +7 days -1 minute'));
        switch ($filter) {
            case 1:
                $start_date = date('Y-m-d H:i:s', strtotime('midnight +1 day'));
            case 0:
                $end_date = date('Y-m-d H:i:s', strtotime('midnight +1 day -1 minute', strtotime($start_date)));
                break;
            case 2:
                $start_date = date('Y-m-d H:i:s', strtotime('midnight + 2 days'));
                break;
        }

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
                //->limit(15)
                ->addWhere('e.start_at >= ? and e.start_at <= ?', array($start_date, $end_date))
                ->having("kms < 50" . ($this->getUser()->getCountry()->getId() == 1 ? " OR e.user_id = '166929'" : ''))
                ->orderBy('e.start_at')
		        
		        ->execute();
        
        $possitions = $returnItems = array();

        $start = 0;
        $end = count($events);
        foreach ($items as $item) {
            $start = min($item->getRank(), $start);
            $end = max($item->getRank(), $end);

            $possitions[$item->getRank()][] = $item;            
        }
        for ($i = $start; $i <= $end; $i++) {
            if (isset($possitions[$i])) {
                foreach ($possitions [$i] as $news_item) {
                    $places = array();
                    if ($news_item) {
                        if (strpos($news_item->getLink(),'mobileList') !== false) {
                            $positionId = strpos($news_item->getLink(),'id=');
                            $listId = mb_substr($news_item->getLink(), $positionId+3);
                            $companies = Doctrine::getTable('Company')
                                    ->createQuery('c')
                                    ->addSelect('c.*, i.*')
                                    ->innerJoin('c.CompanyLocation l')
                                    ->innerJoin('c.CompanyPage p')
                                    ->innerJoin('p.ListPage lp')
                                    ->innerJoin('lp.Lists li')
                                    ->leftJoin('c.Image i')
                                    ->addSelect("c.id, c.*, l.*")
                                    ->addSelect($kmsCompany)
                                    ->where('lp.list_id= ?', $listId)
                                    ->execute();
                            if ($companies) {
                                foreach ($companies as $company) {
                                    $ppp = $company->getActivePPPService(true) ? 1 : 0;
                                    $isFavorite = Doctrine::getTable('Company')
                                            ->createQuery('c')
                                            ->innerJoin('c.CompanyPage p')
                                            ->innerJoin('p.Follow f')
                                            ->where('f.user_id = ?', $this->getUser()->getId())
                                            ->andWhere('c.id = ?', $company->getId())
                                            ->count();
                                    $places[] = array(
                                        'identifier' => $company->getId(),
                                        'title' => $company->getCompanyTitleByCulture(),
                                        'phone' => $company->getPhoneFormated($company->getPhone(), $culture),
                                        'address' => $company->getDisplayAddress(),
                                        'ppp' => $ppp,
                                        'ppp_review_id' => (($ppp == 1 && $company->getTopReview()) ? $company->getTopReview()->getId() : null),
                                        'ppp_review_text' => (($ppp == 1 && $company->getTopReview()) ? $company->getTopReview()->getText() : null),
                                        'ppp_review_picture' => (($ppp == 1 && ($company->getTopReview() && $company->getTopReview()->getUserProfile())) ? image_path($company->getTopReview()->getUserProfile()->getThumb(), true) : null),
                                        'favourite' => $isFavorite,
                                        'rating' => $company->getAverageRating(),
                                        'reviews' => $company->getNumberOfReviews(),
                                        'lat' => $company->getLocation()->getLatitude(),
                                        'long' => $company->getLocation()->getLongitude(),
                                        'distance' => (!is_null($company->kms) ? $company->kms : 0),
                                        'icon' => 'marker_' . $company->getSectorId(),
                                        'picture_url' => image_path($company->getThumb(2, true), true),
                                        'share_url' => 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . '://www.getlokal.' . ($this->getUser()->getDomain($culture) ? $this->getUser()->getDomain($culture). '/' . $culture : 'com/en') . '/' . $company->getCity()->getSlug() . '/' . $company->getSlug(),
                                        'content_url' => $this->generateUrl('default', array('module' => 'api33', 'action' => 'company', 'id' => $company->getId(), 'token' => $request->getParameter('token'), 'locale' => $culture), true)                                        
                                    );
                                }
                                
                            }
                        }
                        $returnItems[] = array(
                            'identifier' => $news_item->getId(),
                            'type' => 2,
                            'internal' => 1,
                            'title' => $news_item->getTitle(),
                            'details1' => $news_item->getLine1(),
                            'details2' => $news_item->getLine2(),
                            'detauls3' => '',
                            'picture_url' => image_path($news_item->getThumb(1), true),
                            'big_picture_url' => image_path($news_item->getThumb(), true),
                            'content_url' => $news_item->getLink(),
                            'share_url' => isset($listId) ? 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . '://www.getlokal.' . ($this->getUser()->getDomain($culture) ? $this->getUser()->getDomain($culture). '/' . $culture : 'com/en') . '/d/list/show/id/' . $listId : $news_item->getLink(),
                            'places' => $places);

                    }
                }
            }

            if (isset($events[$i])) { //foreach($events as $event)
            	$event = $events[$i];

                if ($event->getDateTimeObject('start_at')->format('Y-m-d') == date('Y-m-d') ) {
                    $date = $i18n->__('Today') . ' ';
                } elseif ($event->getDateTimeObject('start_at')->format('Y-m-d') == date('Y-m-d', strtotime('midnight + 2 days'))) {
                    $date = $i18n->__('Tomorrow') . ' ';
                } else {
                    $date = $i18n->__($event->getDateTimeObject('start_at')->format('l'));
                }

                $date .= ' (' . $event->getDateTimeObject('start_at')->format('d.m.Y') . ')';

                // Get an event places
                $places = array();

                if (count($event->getEventPage())) {
                    $eventPages = $event->getEventPage();

                    foreach ($eventPages as $eventPage) {
                        $company = $eventPage->getCompanyPage()->getCompany();
                        if(is_object($company)){
                            $companyId = $eventPage->getCompanyPage()->getCompany()->getId();
                            $company = Doctrine::getTable('Company')
                                    ->createQuery('c')
                                    //->addSelect('c.*, i.*')
                                    ->innerJoin('c.CompanyLocation l')
                                    ->innerJoin('c.CompanyPage p')
                                    //->innerJoin('p.ListPage lp')
                                    //->innerJoin('lp.Lists li')
                                    //->leftJoin('c.Image i')
                                    ->addSelect("c.id, c.*, l.*")
                                    ->addSelect($kmsCompany)
                                    ->where('c.id= ?', $companyId)
                                    ->fetchOne();
                         
                            $ppp = $company->getActivePPPService(true) ? 1 : 0;
                            $isFavorite = Doctrine::getTable('Company')
                                    ->createQuery('c')
                                    ->innerJoin('c.CompanyPage p')
                                    ->innerJoin('p.Follow f')
                                    ->where('f.user_id = ?', $this->getUser()->getId())
                                    ->andWhere('c.id = ?', $company->getId())
                                    ->count();

                            $places[] = array(
                                'identifier' => $company->getId(),
                                'title' => $company->getCompanyTitleByCulture(),
                                'phone' => $company->getPhoneFormated($company->getPhone(), $culture),
                                'address' => $company->getDisplayAddress(),
                                'ppp' => $ppp,
                                'ppp_review_id' => (($ppp == 1 && $company->getTopReview()) ? $company->getTopReview()->getId() : null),
                                'ppp_review_text' => (($ppp == 1 && $company->getTopReview()) ? $company->getTopReview()->getText() : null),
                                'ppp_review_picture' => (($ppp == 1 && ($company->getTopReview() && $company->getTopReview()->getUserProfile())) ? image_path($company->getTopReview()->getUserProfile()->getThumb(), true) : null),
                                'favourite' => $isFavorite,
                                'rating' => $company->getAverageRating(),
                                'reviews' => $company->getNumberOfReviews(),
                                'lat' => $company->getLocation()->getLatitude(),
                                'long' => $company->getLocation()->getLongitude(),
                                'distance' => (!is_null($company->kms) ? $company->kms : 0),
                                'icon' => 'marker_' . $company->getSectorId(),
                                'picture_url' => image_path($company->getThumb(2, true), true),
                                'share_url' => 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . '://www.getlokal.' . ($this->getUser()->getDomain($culture) ? $this->getUser()->getDomain($culture). '/' . $culture : 'com/en') . '/' . $company->getCity()->getSlug() . '/' . $company->getSlug(),
                                'content_url' => $this->generateUrl('default', array('module' => 'api33', 'action' => 'company', 'id' => $company->getId(), 'token' => $request->getParameter('token'), 'locale' => $culture), true),

                            );
                        }
                    }
                }

                $returnItems[] = array(
                    'identifier' => $event->getId(),
                    'type' => 1,
                    'internal' => 0,
                    'title' => $event->getTitle(),
                    'share_url' => 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . '://www.getlokal.' . ($this->getUser()->getDomain($culture) ? $this->getUser()->getDomain($culture). '/' . $culture : 'com/en') . '/d/event/show/id/' . $event->getId(),
                    'details1' => $date,
                    'details2' => $event->getPrice() ? $i18n->__('Ticket: ') . $event->getPriceValue() : '',
                    'details3' => $event->getFirstCompany() ? $event->getFirstCompany()->getTitle() . ' (' . number_format($event->distance, 2) . ' km)' : '',
                    //'category' => $event->getCategory(),
                    'picture_url' => image_path($event->getThumb(2), true),
                    'big_picture_url' => image_path($event->getThumb(2), true),
                    'content_url' => $this->generateUrl('default', array('module' => 'api33', 'action' => 'event', 'id' => $event->getId(), 'country' => $this->getUser()->getCountry()->getSlug(), 'locale' => $culture), true),
                    'places' => $places
                );
            }
        }
        
        $return = array('status' => 'SUCCESS', 'items' => $returnItems);
        $this->getResponse()->setContent(json_encode($return));
        return sfView::NONE;
    }

    // List of sectors
    public function executeSectorslist(sfWebRequest $request) {
        $this->__checkToken($request->getParameter('token'));

        $this->getResponse()->setContentType('application/json');

        return $this->renderText(json_encode(array('status' => 'OK', 'items' => $this->__getSectorsList())));
    }

    // List of classifications
    public function executeClassificationslist(sfWebRequest $request) {
        $this->__checkToken($request->getParameter('token'));

        $this->getResponse()->setContentType('application/json');

        return $this->renderText(json_encode(array('status' => 'OK', 'items' => $this->__getClassificationsList())));
    }

    // Search filter - shows sectors and classifications
    public function executeSearchFilter(sfWebRequest $request) {
        $this->getResponse()->setContentType('application/json');

        $results = null;

        $sectors = $this->__getSectorsList($this->visibleSectors);
        $classifications = $this->__getClassificationsList($this->visibleClassifications);
        $i18n = sfContext::getInstance()->getI18N();

        $results = array_merge(array(
            array(
                'identifier' => -1,
                'title' => $i18n->__('Getlokal recommends'),
                'icon' => 'marker_recommended',
                'cs_type' => 0
            ),
            array(
                'identifier' => -2,
                'title' => $i18n->__('Places with Offers'),
                'icon' => 'marker_offers',
                'cs_type' => 0
            )
        ), $classifications, $sectors);

        return $this->renderText(json_encode(array('status' => 'OK', 'items' => $results)));
    }

    // Search in classification list
    public function executeGetClassificationsAutocomplete(sfWebRequest $request) {
        $this->__checkToken($request->getParameter('token'));

        $culture = $this->getUser()->getCulture();
        $this->getResponse()->setContentType('application/json');

        $param = "%" . $request->getParameter('term') . "%";
        $limit = $request->getParameter('limit', 10);

        $query = "SELECT * FROM classification c
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
                'title' => $row['title']
            );
        }

        $this->getResponse()->setContent(json_encode(array('status' => 'ok', 'items' => $return)));

        return sfView::NONE;
    }

    // Will return only city/ies by keyword
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
                ', ' . $row->getCounty()->getLocation($culture) .
                ', ' . $row->getCountry()->getLocation($culture);
            $cities[] = array('id' => $row['id'], 'value' => $value);

        }

        return $this->renderText(json_encode($cities));
    }

    // Search everywhere (cities, countries)
    //http://www.getlokal.com/mobile_dev.php/dev/getLocationAutocomplete?term=%D0%A1%D0%BE%D1%84%D0%B8%D1%8F
    public function executeGetLocationAutocomplete(sfWebRequest $request) {
        //$this->__checkToken($request->getParameter('token'));

        $culture = $this->getUser()->getCulture();
        $this->getResponse()->setContentType('application/json');

        $param = "%" . $request->getParameter('term') . "%";
        $limit = $request->getParameter('limit', 10);
        $result = $cities_names = array();

        // FIXME: use $limit
        $dql = Doctrine::getTable('City')
                ->createQuery('c')
                ->innerJoin('c.Translation ct')
                ->where('ct.name LIKE ?', $param)
                ->limit($limit);

        $this->rows = $dql->execute();

        $cities_dql = Doctrine_Query::create()
                ->select('c.id, ct.name')
                ->from('City c')
                ->innerJoin('c.Translation ct')
                ->groupBy('ct.name')
                ->having('COUNT(ct.name) > 1')
                ->andwhere('ct.name LIKE ?', $param);

        $cities_names = $cities_dql->fetchArray();

        $partner_class = getlokalPartner::getLanguageClass(getlokalPartner::getInstance());

        foreach ($this->rows as $row) {
            if ($this->in_array_r($row->getCityNameByCulture(), $cities_names)) {
                if ($culture == 'en') {
                    //$result[] = array('identifier' => $row['id'], 'title' => $row->getLocation() . ', ' . mb_convert_case(call_user_func(array('Transliterate' . $partner_class, 'toLatin'), $row->getCounty()->getName()), MB_CASE_TITLE, 'UTF-8') . ', ' . mb_convert_case(call_user_func(array('Transliterate' . $partner_class, 'toLatin'), $row->getCounty()->getCountry()->getName()), MB_CASE_TITLE, 'UTF-8'), 'country' => 0);
                    $result[] = array('identifier' => $row['id'], 'title' => $row->getLocation($culture) . ', ' . mb_convert_case($row->getCounty()->getLocation(), MB_CASE_TITLE, 'UTF-8') . ', ' . mb_convert_case(call_user_func(array('Transliterate' . $partner_class, 'toLatin'), $row->getCounty()->getCountry()->getName()), MB_CASE_TITLE, 'UTF-8'), 'country' => 0);
                } else {
                    //$cities[] = array('identifier' => $row['id'], 'title' => $row->getLocation() . ', ' . mb_convert_case($row->getCounty()->getName(), MB_CASE_TITLE, 'UTF-8') . ', ' . mb_convert_case(call_user_func(array('Transliterate' . $partner_class, 'toLatin'), $row->getCounty()->getCountry()->getName()), MB_CASE_TITLE, 'UTF-8'));
                    //$result[] = array('identifier' => $row['id'], 'title' => $row->getLocation() . ', ' . mb_convert_case($row->getCounty()->getName(), MB_CASE_TITLE, 'UTF-8') . ', ' . mb_convert_case($row->getCounty()->getCountry()->getName(), MB_CASE_TITLE, 'UTF-8'), 'country' => 0);
                    $result[] = array('identifier' => $row['id'], 'title' => $row->getLocation($culture) . ', ' . mb_convert_case($row->getCounty()->getLocation(), MB_CASE_TITLE, 'UTF-8') . ', ' . mb_convert_case($row->getCounty()->getCountry()->getName(), MB_CASE_TITLE, 'UTF-8'), 'country' => 0);
                }
            } else {
                if ($culture == 'en') {
                    //$result[] = array('identifier' => $row['id'], 'title' => $row->getLocation() . ', ' . mb_convert_case(call_user_func(array('Transliterate' . $partner_class, 'toLatin'), $row->getCounty()->getCountry()->getName()), MB_CASE_TITLE, 'UTF-8'), 'country' => 0);
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
                $result[] = array('identifier' => $country->getId(), 'title' => mb_convert_case(call_user_func(array('Transliterate' . $partner_class, 'toLatin'), ($country->getName() ? $country->getName() : $country->getNameEn())), MB_CASE_TITLE, 'UTF-8'), 'country' => 1);
            } else {
                $result[] = array('identifier' => $country->getId(), 'title' => mb_convert_case(($country->getName() ? $country->getName() : $country->getNameEn()), MB_CASE_TITLE, 'UTF-8'), 'country' => 1);
            }
        }

        $return = array('status' => 'ok', 'items' => $result);
        return $this->renderText(json_encode($return));
    }

    private function __countResultFromSphinx($con, $sql) {
        $cntSql = $sql . " LIMIT 0, 2000";
        $result = mysqli_query($con, $cntSql) or die(mysqli_error($con));
        $countResult = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $countResult++;
        }

        return $countResult;
    }

    private function __getLocation($where) {
        $locationString = explode(',', $where);
        $lat = $lng = null;

        if (isset($locationString[0]) && isset($locationString[1])) {
            $cityString = trim($locationString[0]);
            $countryString = trim($locationString[1]);
        }
        elseif (!isset($locationString[1])) {
            $cityString = trim($locationString[0]);
            $countryString = null;
        } else {
            $cityString = trim($where);
        }

        $city = Doctrine::getTable('City')
                ->createQuery('c')
                ->innerJoin('c.Translation ct')
                ->where('ct.name LIKE ?', $cityString)
                ->fetchOne();

        if ($city) {
            if ($countryString) {
                $country = Doctrine::getTable('Country')
                            ->createQuery('c')
                            ->where('c.name LIKE ? OR c.name_en LIKE ?', array($countryString, $countryString))
                            ->fetchOne();
            }

            if (!isset($country) || !$country || $country->getId() != $city->getCounty()->getCountryId()) {
                $country = $city->getCountry();
            }

            $lat = $city->getLat();
            $lng = $city->getLng();
        }
        // Use geocode
        else {
            $con = Doctrine::getConnectionByTableName('CompanyLocation');

            //$key = "AIzaSyDDZGSZsZTNuGUImUPcFXOEWObG6GX0I08";

            $address = urlencode($where);
            $url = "http" . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . "://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&sensor=false&language=" . $this->getUser()->getCulture();
            sfContext::getInstance()->getLogger()->emerg('GEOCODE: 19');

            $string = file_get_contents($url);
            $jsonA = json_decode($string, true);
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0); //Change this to a 1 to return headers
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $results = curl_exec($ch);
            curl_close($ch);

            if (isset($results[0]) && isset($jsonA['results'][0]['geometry'])) {
                if (isset($jsonA['results'][0]['geometry']['location']['lat']) && isset($jsonA['results'][0]['geometry']['location']['lng'])) {
                    $lat = $jsonA['results'][0]['geometry']['location']['lat'];
                    $lng = $jsonA['results'][0]['geometry']['location']['lng'];
                } else {
                    foreach($jsonA['results'][0]['address_components'] as $key => $val) {
                        if ($val['types'][0] == 'locality') {
                            $j_city = $val['long_name'];

                            $city = Doctrine::getTable('City')
                                    ->createQuery('c')
                                    ->innerJoin('c.Translation ct')
                                    ->where('ct.name LIKE ?', $j_city)
                                    ->fetchOne();

                            if ($city) {
                                $country = $city->getCounty()->getCountry();

                                foreach ($jsonA['results'][0]['address_components'] as $key1 => $val1) {
                                    if ($val1['types'][0] == 'country') {
                                        $j_country = $val1['long_name'];

                                        $jcountry = Doctrine::getTable('Country')
                                                    ->createQuery('c')
                                                    ->where('c.name LIKE "%' . $j_country . '%" c.name_en LIKE "%' . $j_country . '%"')
                                                    ->fetchOne();

                                        if ($jcountry) {
                                            if ($jcountry->getId() > 4 or $city->getCounty()->getCountryId() != $jcountry->getId()) {
                                                $city = null;
                                                $country = $jcountry;
                                                break;
                                            }
                                            else {
                                                $lat = $city->getLat();
                                                $lng = $city->getLng();
                                            }
                                        }

                                        break;
                                    }
                                }
                            } else {
                                foreach ($jsonA['results'][0]['address_components'] as $key2 => $val2) {
                                    if ($val2['types'][0] == 'country') {
                                        $j_country1 = $val2['long_name'];
                                        $jcountry1 = Doctrine::getTable('Country')
                                                        ->createQuery('c')
                                                        ->where('c.name_en LIKE "%' . $j_country1 . '%"')
                                                        ->fetchOne();

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

        return array('lat' => $lat, 'long' => $lng, 'city' => ((isset($city) && $city) ? $city->getId() : ''), 'country' => ((isset($country) && $country) ? $country->getId() : ''));
    }

    private function __searchByCS($request, $companyIDs) {
    	sfContext::getInstance()->getConfiguration()->loadHelpers('Asset');
    	$culture = $this->getUser()->getCulture();        

    	$lat = $request->getParameter('lat', 1);
    	$lng = $request->getParameter('long', 1);
    	$sLat = $request->getParameter('lat', 1);
    	$sLng = $request->getParameter('long', 1);
    	
        if (count($companyIDs)) {
            // Get companies
            $kmsSql = "((ACOS(SIN(%s * PI() / 180) * SIN(l.latitude * PI() / 180) + COS(%s * PI() / 180) * COS(l.latitude * PI() / 180) * COS((%s - l.longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as kms";
            $kms = sprintf($kmsSql, $sLat, $sLat, $sLng);

            $companies = Doctrine::getTable('Company')
                ->createQuery('c')
                ->innerJoin('c.Location l')
                ->innerJoin('c.Sector s')
                ->innerjoin('s.Translation st WITH st.lang = ?', $culture)
                ->innerJoin('c.Classification ca')
                ->innerJoin('ca.Translation cat WITH cat.lang = ?', $culture)

                // Add kilometers
                ->addSelect("c.id, c.*, s.*, st.*, ca.*, cat.*, l.*")
                ->addSelect($kms)
                ->whereIN('c.id', $companyIDs)
                ->andWhere('c.status = 0')
                ->orderBy('FIELD(c.id,' . implode(',', $companyIDs) . ')')
                //->orderBy('kms')
                ->execute();

            foreach ($companies as $company) {
                $ppp = $company->getActivePPPService(true) ? 1 : 0;
                $isFavorite = Doctrine::getTable('Company')
                                ->createQuery('c')
                                ->innerJoin('c.CompanyPage p')
                                ->innerJoin('p.Follow f')
                                ->where('f.user_id = ?', $this->getUser()->getId())
                                ->andWhere('c.id = ?', $company->getId())
                                ->count();

                $items[] = array(
                    'identifier' => $company->getId(),
                    'title' => $company->getCompanyTitleByCulture(),
                    'phone' => $company->getPhoneFormated($company->getPhone(), $culture),
                    'address' => $company->getDisplayAddress(),
                    'ppp' => $ppp,
                    'ppp_review_id' => (($ppp == 1 && $company->getTopReview()) ? $company->getTopReview()->getId() : null),
                    'ppp_review_text' => (($ppp == 1 && $company->getTopReview()) ? $company->getTopReview()->getText() : null),
                    'ppp_review_picture' => (($ppp == 1 && ($company->getTopReview() && $company->getTopReview()->getUserProfile())) ? image_path($company->getTopReview()->getUserProfile()->getThumb(), true) : null),
                    'favourite' => $isFavorite,
                    'rating' => $company->getAverageRating(),
                    'reviews' => $company->getNumberOfReviews(),
                    'lat' => $company->getLocation()->getLatitude(),
                    'long' => $company->getLocation()->getLongitude(),
                    'distance' => (!is_null($company->kms) ? $company->kms : 0),
                    'icon' => 'marker_' . $company->getSectorId(),
                    'picture_url' => image_path($company->getThumb(0, true), true),
                    'content_url' => $this->generateUrl('default', array('module' => 'api33', 'action' => 'company', 'id' => $company->getId(), 'token' => $request->getParameter('token'), 'locale' => $culture), true),
                    'share_url' => 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . '://www.getlokal.' . ($this->getUser()->getDomain($culture) ? $this->getUser()->getDomain($culture). '/' . $culture : 'com/en') . '/' . $company->getCity()->getSlug() . '/' . $company->getSlug(),
                    'place_type' => $company->getClassification()->getTitle(),
                );
            }
        }

        return $items;
    }

    private function __searchBlank($request, $companyIDs, $offers = false) {
        $culture = $this->getUser()->getCulture();
        $country_id = $this->getUser()->getCountry()->getId();

        sfContext::getInstance()->getConfiguration()->loadHelpers('Asset');

        $lat = $request->getParameter('lat', 1);
        $lng = $request->getParameter('long', 1);
        $sLat = $request->getParameter('lat', 1);
        $sLng = $request->getParameter('long', 1);

        if (count($companyIDs)) {
            // Get companies
            $kmsSql = "((ACOS(SIN(%s * PI() / 180) * SIN(l.latitude * PI() / 180) + COS(%s * PI() / 180) * COS(l.latitude * PI() / 180) * COS((%s - l.longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as kms";
            $kms = sprintf($kmsSql, $sLat, $sLat, $sLng);

            $companies = Doctrine::getTable('Company')
                ->createQuery('c')
                ->innerJoin('c.Location l')
                ->innerJoin('c.Sector s')
                ->innerjoin('s.Translation st WITH st.lang = ?', $culture)
                ->innerJoin('c.Classification ca')
                ->innerJoin('ca.Translation cat WITH cat.lang = ?', $culture)

                // Add kilometers
                ->addSelect("c.id, c.*, s.*, st.*, ca.*, cat.*, l.*")
                ->addSelect($kms)
                ->whereIN('c.id', $companyIDs)
                ->andWhere('c.status = 0')
                ->orderBy('FIELD(c.id,' . implode(',', $companyIDs) . ')')
                //->orderBy('kms')
                ->execute();

            foreach ($companies as $company) {
                $ppp = $company->getActivePPPService(true) ? 1 : 0;
                $isFavorite = Doctrine::getTable('Company')
                                ->createQuery('c')
                                ->innerJoin('c.CompanyPage p')
                                ->innerJoin('p.Follow f')
                                ->where('f.user_id = ?', $this->getUser()->getId())
                                ->andWhere('c.id = ?', $company->getId())
                                ->count();
                $_offers = $this->__getCompanyOffers($company->getId());
                if ($offers && empty($_offers)) {
                    continue;
                }
                $items[] = array(
                    'identifier' => $company->getId(),
                    'title' => $company->getCompanyTitleByCulture(),
                    'phone' => $company->getPhoneFormated($company->getPhone(), $culture),
                    'address' => $company->getDisplayAddress(),
                    'ppp' => $ppp,
                    'ppp_review_id' => (($ppp == 1 && $company->getTopReview()) ? $company->getTopReview()->getId() : null),
                    'ppp_review_text' => (($ppp == 1 && $company->getTopReview()) ? $company->getTopReview()->getText() : null),
                    'ppp_review_picture' => (($ppp == 1 && ($company->getTopReview() && $company->getTopReview()->getUserProfile())) ? image_path($company->getTopReview()->getUserProfile()->getThumb(), true) : null),
                    'favourite' => $isFavorite,
                    'rating' => $company->getAverageRating(),
                    'reviews' => $company->getNumberOfReviews(),
                    'lat' => $company->getLocation()->getLatitude(),
                    'long' => $company->getLocation()->getLongitude(),
                    'distance' => (!is_null($company->kms) ? $company->kms : 0),
                    'icon' => 'marker_' . $company->getSectorId(),
                    'picture_url' => image_path($company->getThumb(0, true), true),
                    'content_url' => $this->generateUrl('default', array('module' => 'api33', 'action' => 'company', 'id' => $company->getId(), 'token' => $request->getParameter('token'), 'locale' => $culture), true),
                    'share_url' => 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . '://www.getlokal.' . ($this->getUser()->getDomain($culture) ? $this->getUser()->getDomain($culture). '/' . $culture : 'com/en') . '/' . $company->getCity()->getSlug() . '/' . $company->getSlug(),
                    'offers' => $_offers,
                    'place_type' => $company->getClassification()->getTitle(),
                );
            }
        }

        return $items;
    }

    private function __searchRecommended($request, $companyIDs) {
        sfContext::getInstance()->getConfiguration()->loadHelpers('Asset');
        $culture = $this->getUser()->getCulture();
        
        $lat = $request->getParameter('lat', 1);
        $lng = $request->getParameter('long', 1);
        $sLat = $request->getParameter('lat', 1);
        $sLng = $request->getParameter('long', 1);
        
        if (count($companyIDs)) {
            // Get companies
            $kmsSql = "((ACOS(SIN(%s * PI() / 180) * SIN(l.latitude * PI() / 180) + COS(%s * PI() / 180) * COS(l.latitude * PI() / 180) * COS((%s - l.longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as kms";
            $kms = sprintf($kmsSql, $sLat, $sLat, $sLng);

            $companies = Doctrine::getTable('Company')
                ->createQuery('c')
                ->innerJoin('c.Location l')
                ->innerJoin('c.Sector s')
                ->innerjoin('s.Translation st WITH st.lang = ?', $culture)
                ->innerJoin('c.Classification ca')
                ->innerJoin('ca.Translation cat WITH cat.lang = ?', $culture)

                // Add kilometers
                ->addSelect("c.id, c.*, s.*, st.*, ca.*, cat.*, l.*")
                ->addSelect($kms)
                ->whereIN('c.id', $companyIDs)
                ->andWhere('c.status = 0')
                ->orderBy('FIELD(c.id,' . implode(',', $companyIDs) . ')')
                //->orderBy('kms')
                ->execute();

            foreach ($companies as $company) {
                $ppp = 1;
                $isFavorite = Doctrine::getTable('Company')
                                ->createQuery('c')
                                ->innerJoin('c.CompanyPage p')
                                ->innerJoin('p.Follow f')
                                ->where('f.user_id = ?', $this->getUser()->getId())
                                ->andWhere('c.id = ?', $company->getId())
                                ->count();

                $items[] = array(
                    'identifier' => $company->getId(),
                    'title' => $company->getCompanyTitleByCulture(),
                    'phone' => $company->getPhoneFormated($company->getPhone(), $culture),
                    'address' => $company->getDisplayAddress(),
                    'ppp' => $ppp,
                    'ppp_review_id' => (($ppp == 1 && $company->getTopReview()) ? $company->getTopReview()->getId() : null),
                    'ppp_review_text' => (($ppp == 1 && $company->getTopReview()) ? $company->getTopReview()->getText() : null),
                    'ppp_review_picture' => (($ppp == 1 && ($company->getTopReview() && $company->getTopReview()->getUserProfile())) ? image_path($company->getTopReview()->getUserProfile()->getThumb(), true) : null),
                    'favourite' => $isFavorite,
                    'rating' => $company->getAverageRating(),
                    'reviews' => $company->getNumberOfReviews(),
                    'lat' => $company->getLocation()->getLatitude(),
                    'long' => $company->getLocation()->getLongitude(),
                    'distance' => (!is_null($company->kms) ? $company->kms : 0),
                    'icon' => 'marker_' . $company->getSectorId(),
                    'picture_url' => image_path($company->getThumb(0, true), true),
                    'content_url' => $this->generateUrl('default', array('module' => 'api33', 'action' => 'company', 'id' => $company->getId(), 'token' => $request->getParameter('token'), 'locale' => $culture), true),
                    'share_url' => 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . '://www.getlokal.' . ($this->getUser()->getDomain($culture) ? $this->getUser()->getDomain($culture). '/' . $culture : 'com/en') . '/' . $company->getCity()->getSlug() . '/' . $company->getSlug(),
                    'offers' => $this->__getCompanyOffers($company->getId()),
                    'events' => $this->__getCompanyEvents($company),
                    'place_type' => $company->getClassification()->getTitle(),
                );
            }
        }

        return $items;
    }

    private function __searchByKeyword($request, $companyIDs) {
    	sfContext::getInstance()->getConfiguration()->loadHelpers('Asset');
        $culture = $this->getUser()->getCulture();        

        $lat = $request->getParameter('lat', 1);
        $lng = $request->getParameter('long', 1);
        $sLat = $request->getParameter('lat', 1);
        $sLng = $request->getParameter('long', 1);
        
        $items = array();
        if (count($companyIDs)) {
            // Get companies
            $kmsSql = "((ACOS(SIN(%s * PI() / 180) * SIN(l.latitude * PI() / 180) + COS(%s * PI() / 180) * COS(l.latitude * PI() / 180) * COS((%s - l.longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as kms";
            $kms = sprintf($kmsSql, $sLat, $sLat, $sLng);

            $query = Doctrine::getTable('Company')
                ->createQuery('c')
                ->innerJoin('c.Location l')
                ->innerJoin('c.Sector s')
                ->innerjoin('s.Translation st WITH st.lang = ?', $culture)
                ->innerJoin('c.Classification ca')
                ->innerJoin('ca.Translation cat WITH cat.lang = ?', $culture)

                // Add kilometers
                ->addSelect("c.id, c.*, s.*, st.*, ca.*, cat.*, l.*")
                ->addSelect($kms)
                ->whereIN('c.id', $companyIDs)
                ->andWhere('c.status = 0')
                //->orderBy('kms')
                ->orderBy('FIELD(c.id,' . implode(',', $companyIDs) . ')')
                ->execute();

            foreach ($query as $c) {
                $ppp = $c->getActivePPPService(true) ? 1 : 0;
                $isFavorite = Doctrine::getTable('Company')
                    ->createQuery('c')
                    ->innerJoin('c.CompanyPage p')
                    ->innerJoin('p.Follow f')
                    ->where('f.user_id = ?', $this->getUser()->getId())
                    ->andWhere('c.id = ?', $c->getId())
                    ->count();

                $items[] = array(
                    'identifier' => $c->getId(),
                    'title' => $c->getCompanyTitleByCulture(),
                    'phone' => $c->getPhoneFormated($c->getPhone(), $culture),
                    'address' => $c->getDisplayAddress(),
                    'ppp' => $ppp,
                    'ppp_review_id' => (($ppp == 1 && $c->getTopReview()) ? $c->getTopReview()->getId() : null),
                    'ppp_review_text' => (($ppp == 1 && $c->getTopReview()) ? $c->getTopReview()->getText() : null),
                    'ppp_review_picture' => (($ppp == 1 && ($c->getTopReview() && $c->getTopReview()->getUserProfile())) ? image_path($c->getTopReview()->getUserProfile()->getThumb(), true) : null),
                    'favourite' => $isFavorite,
                    'rating' => $c->getAverageRating(),
                    'reviews' => $c->getNumberOfReviews(),
                    'lat' => $c->getLocation()->getLatitude(),
                    'long' => $c->getLocation()->getLongitude(),
                    'distance' => (!is_null($c->kms) ? $c->kms : 0),
                    'icon' => 'marker_' . $c->getSectorId(),
                    'picture_url' => image_path($c->getThumb(0, true), true),
                    'content_url' => $this->generateUrl('default', array('module' => 'api33', 'action' => 'company', 'id' => $c->getId(), 'token' => $request->getParameter('token'), 'locale' => $culture), true),
                    'share_url' => 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . '://www.getlokal.' . ($this->getUser()->getDomain($culture) ? $this->getUser()->getDomain($culture). '/' . $culture : 'com/en') . '/' . $c->getCity()->getSlug() . '/' . $c->getSlug(),
                    'offers' => $this->__getCompanyOffers($c->getId()),
                    'events' => $this->__getCompanyEvents($c),
                    'place_type' => $c->getClassification()->getTitle(),
                );
            }
        }

        return $items;
    }

    protected function ArrayElCmp($element1, $element2) {
        if ($element1['rank'] == $element2['rank']) {
            return 0;
        }

        return ($element1['rank'] > $element2['rank']) ? -1 : 1;
    }

    // Changes
    // Type of classification or sector
    public function executeSearchNear(sfWebRequest $request) {
        $this->__checkToken($request->getParameter('token'));

        $this->getResponse()->setContentType('application/json');

        // Params
        $culture = $request->getParameter('locale');
        $country = $request->getParameter('country');

        $lat = $request->getParameter('lat', 1);
        $lng = $request->getParameter('long', 1);
        $sLat = $request->getParameter('search_lat', $lat);
        $sLng = $request->getParameter('search_long', $lng);

        $keyword = trim($request->getParameter('keyword', null));
        $where = trim($request->getParameter('where', null));

        $cs = $request->getParameter('cs', null);
        $csType = $request->getParameter('cs_type', 0);

        $startIndex = $request->getParameter('start_index', 0);
        $endIndex = $request->getParameter('end_index', 14);

        $radius = $request->getParameter('radius', 30);
        $inKM = $request->getParameter('inKM', true);
        
        if ($where && $where == -1) {
            $where = false;
        } elseif ($where && is_numeric($where) && $where != -1) {
            $city = Doctrine::getTable('City')->findOneById($where);

            if ($city) {
                // $country = $city->getCounty()->getCountry();
                $sLat = $city->getLat();
                $sLng = $city->getLng();
            } else {
                $where = false;
            }
        } elseif ($where) {
            $localResult = $this->__getLocation($where);

            if (isset($localResult['lat']) && $localResult['lat'] && isset($localResult['long']) && $localResult['long']) {
                $sLat = $localResult['lat'];
                $sLng = $localResult['long'];
            } else {
                $where = false;
            }
        } else {
            $where = false;
        }

        $this->forward404Unless($lat || $lng);

        include sfConfig::get("sf_web_dir").'/../getlokalBizLib/search/model/SearchFilter.php';
        include sfConfig::get("sf_web_dir").'/../getlokalBizLib/search/model/spLocation.php';
        include sfConfig::get("sf_web_dir").'/../getlokalBizLib/search/CompanyResultHandler.php';
        include sfConfig::get("sf_web_dir").'/../getlokalBizLib/search/sphinx/SphinxManager.php';
        
        
        $connQLSettings = new SpinxQLConnectionSettings();
        $rankSettings = new SearchProviderRankingSettings();
         
/* IMPORTANT !!!
*  Necessary to check if the culture is not supported by sphinx
*  or the index for that culture does not exist.
*/ 
        $index_cultures = array('bg', 'sr', 'ru', 'ro', 'mk', 'fi', 'hu', 'me');
        
        if (!in_array($culture, $index_cultures)) {
        	$lang = 'en';
        }
        else {
        	$lang = $culture;
        }
/* End of index check */
               
        $man = new SphinxManager($lang, $connQLSettings, $rankSettings);
         
        $errors = '';
        $sFilter = new SearchFilter();
        
        $page = $request->getParameter('page', false);
        
        if (!$page) {
        	$page = ((int)($startIndex / 15)) + 1;
        }
        
        $man->SetPageSize(30);
        
        $sFilter->pageNumber = $page;
        $sFilter->offersCount = null;
        $sFilter->sectorId = null;
        $sFilter->classificationId = null;
        $sFilter->isPPP = null;
        $sFilter->term = null;
        $sFilter->radius = $radius;
        
        // SEARCH METHODS
        // by Keyword
        if (isset($keyword) && $keyword) {
        	$keyword = strtolower($keyword);
        	 
        	$pattern = array(';', '.', ',', ':', '!', '?', ' - ',  '\'', '"', '”', '“', '(', ')', '-');
        	$keyword = str_replace($pattern, ' ', $keyword);
        	 
        	$keywordArray = explode(' ', $keyword);
        	 
        	foreach ($keywordArray as $key => $value) {
        		if (in_array($value, $this->paraziteWords)) {
        			unset($keywordArray[$key]);
        		}
        	}
        	 
        	$cleanPhrase = implode(' ', $keywordArray);
        	
        	$sFilter->radius = 1500;
        	$sFilter->term = $cleanPhrase;
        	$sFilter->city_id = $where;
        	$search_method = 'keyword';
        }
        elseif ($cs) {
        	// Recommended
        	if ($cs == -1) {
        		$sFilter->isPPP = true;
        		$sFilter->city_id = $where;
        		$search_method = 'recommended';
        	}
        	// Blank with offers
        	elseif ($cs == -2) {
        		$sFilter->offersCount = true;
        		$sFilter->city_id = $where;
        		$search_method = 'blank_offers';
        	}
        	// by Classification or Sector
        	else {
        		// Classifications
        		if ($cs && $csType == 1) {
        			if (!in_array($cs, $this->visibleClassifications)) {
        				$cs = null;
        				$csType = null;
        			}
        			else {
        				$sFilter->classificationId = $cs;
        				$sqlPart1 = "AND classification_id = " . $cs . " ";
        			}
        		}
        		// Sectors
        		elseif ($cs && $csType == 0) {
        			if (!in_array($cs, $this->visibleSectors)) {
        				$cs = null;
        				$csType = null;
        			}
        			else {
        				$sFilter->sectorId = $cs;
        				$sqlPart1 = "AND sector_id = " . $cs . " ";
        			}
        		}
        
        		$search_method = 'classification';
        	}
        }
        else {
        	if (isset($where) && $where)
        		$sFilter->city_id = $where;
        	
        	$sFilter->visibleSectors = $this->visibleSectors;
        	$search_method = 'blank';
        }
        //var_dump($sLng);exit;
        $companies = $man->searchCompaniesByGeoPoint($sLat, $sLng, $lat, $lng, $inKM, $errors, $sFilter);
        if ($request->getParameter('debug_new_search', null)) {
        	var_dump($errors);exit;
        }
        $companyIDs = null;        
        $pppCompanyIDs = array();
        $ppCompanyIDs = array();
        
        if (count($companies) > 0 && $companies) {
	        foreach ($companies as $company) {
	        	$isPPP = (int) $company->getIsPPP();
	        	if ($isPPP) {
	        		$pppCompanyIDs[] = $company->getId();
	        	}
	        	else {
	        		$ppCompanyIDs[] = $company->getId();
	        	}
	        }
	        
	        $companyIDs = array_merge($pppCompanyIDs, $ppCompanyIDs);
        }
        
        //var_dump($companyIDs);exit;
        $company_count = count($companyIDs);
        $result = null;
        
        if ($company_count != 0) {
        	switch ($search_method) {
        		case 'keyword':
        			$items = $this->__searchByKeyword($request, $companyIDs);
        			break;
        		case 'recommended':
        			$items = $this->__searchRecommended($request, $companyIDs);
        			break;
        		case 'blank_offers':
        			$items = $this->__searchBlank($request, $companyIDs);
        			break;
        		case 'classification':
        			$items = $this->__searchByCS($request, $companyIDs);
        			break;
        		case 'blank':
        			$items = $this->__searchBlank($request, $companyIDs);
        			break;
        		default:
        			$result = array('status' => 'ERROR', 'error' => 'No items found', 'error_code' => 4, 'items' => array());
        	}
        }
        else {
        	$result = array('status' => 'OK', 'item_count' => $company_count, 'items' => array());
        }
        
        //var_dump($items);exit;
         
        if (!$result) {
        	$result = array('status' => 'OK', 'item_count' => $company_count, 'items' => $items);
        }
        /*
        foreach ($items as $i) {
        	var_dump($i['distance'].' * '.$i['title']);
        }exit;
        */
        return $this->renderText(json_encode($result));
    }

    // test action
    // ex. http://www.getlokal.com/mobile_dev.php/dev/test
    public function executeTest() {
        //
    }

    public function executeGetCurrentVersion(sfWebRequest $request) {
        $this->getResponse()->setContentType('application/json');

        // Params
        $culture = $request->getParameter('locale');
        $country = $request->getParameter('country');

        $lat = $request->getParameter('lat');
        $lng = $request->getParameter('long');

        return $this->renderText(json_encode(array('status' => 'OK', 'current_version_ios' => 'iOS(2.1)', 'current_version_android' => 'Android(2.0)', 'current_version_message' => '')));
    }

    public function executeProfile(sfWebRequest $request) {
        $token = $request->getParameter('token');
        $this->__checkToken($request->getParameter('token'));

        $this->getResponse()->setContentType('application/json');

        sfContext::getInstance()->getConfiguration()->loadHelpers('Asset');

        $owner = $request->getParameter('owner', false);
        $picId = $request->getParameter('picture_id', false);
        $reviewId = $request->getParameter('review_id', false);
        $activityId = $request->getParameter('activity_id', false);
        $uId = $request->getParameter('user_id', false);
        //file_put_contents('testtext', 'owner: '.$owner.'*  picId: '.$picId.'*  review: '.$reviewId.'*  activity: '.$activityId.'*  uId: '.$uId);
       
        if ($owner || !($picId || $reviewId || $activityId || $uId)) {
            $userId = $this->getUser()->getId();
            $login = Doctrine::getTable('ApiLogin')->findOneByToken($token);
            
            if ($userId == $login->getUserId()) {
                $owner = true;
            }
            else {
                $owner = false;
            }
        }
        else {
            if ($picId) {
                $img = Doctrine::getTable('Image')->findOneById($picId);
                $userId = $img->getUserId();
            }
            elseif ($reviewId) {
                $rev = Doctrine::getTable('Review')->findOneById($reviewId);
                $userId = $rev->getUserId();
            }
            elseif ($activityId) {
                $act = Doctrine::getTable('CheckIn')->findOneById($activityId);
                $userId = $act->getUserId();
            }
            elseif ($uId) {
                $userId = $uId;
            }
        }
        
        $culture = $request->getParameter('locale', '');
        $profile = Doctrine::getTable('UserProfile')
                ->createQuery('p')
                ->innerJoin('p.sfGuardUser')
                ->leftJoin('p.City')
                ->where('p.id = ?', $userId)
                ->fetchOne();

        $badges = Doctrine::getTable('Badge')
                ->createQuery('b')
                ->innerJoin('b.UserBadge ub')
                ->where('ub.user_id = ?', $profile->getId())
                ->execute();

        $activities = Doctrine::getTable('CheckIn')
                ->createQuery('c')
                ->innerJoin('c.Company co')
                ->innerJoin('co.CompanyLocation cl')
                ->where('c.user_id = ?', $profile->getId())
                ->orderBy('c.created_at DESC')
                ->execute();
        
        $pics =  Doctrine::getTable ( 'Image' )
                ->createQuery ( 'i' )
                ->innerJoin ( 'i.UserProfile p' )
                ->innerJoin ( 'p.sfGuardUser sf' )
                ->leftJoin('i.CompanyImage ci')
                ->where ( 'i.user_id = ?', $profile->getId() )
                ->addSelect('i.*, ci.id, ci.company_id')
                ->orderBy ( 'i.created_at DESC' )
                ->andWhere ( 'i.status = "approved"' )
                //TO DO uncoment for version 3.4 for pictures
                //->execute();
                ->count();
        
        $reviews = Doctrine::getTable('Review')
                ->createQuery('r')
                ->innerJoin('r.Company c')
                ->innerJoin('r.UserProfile p WITH p.id = ?', $profile->getId())
                ->innerJoin('p.sfGuardUser sf')
                ->leftJoin('p.Image im')
                ->where('r.is_published = ?', Review::FRONTEND_REVIEWS_IS_PUBLISHED)
                ->addWhere('r.parent_id IS NULL')
                ->orderBy('r.created_at DESC')
                //TO DO uncoment for version 3.4 for reviews
                //->execute();
                ->count();
        
        //$kmsSql = "((ACOS(SIN(%s * PI() / 180) * SIN(l.latitude * PI() / 180) + COS(%s * PI() / 180) * COS(l.latitude * PI() / 180) * COS((%s - l.longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as kms";
        //$kmsCompany = sprintf($kmsSql, $lat, $lat, $lng);
        
        $places = Doctrine::getTable('Company')
                ->createQuery('c')
                ->innerJoin('c.CompanyLocation l')
                ->addSelect('c.*, l.latitude as lat, l.longitude as long')
                //->addSelect($kmsCompany)
                ->where('c.created_by = ?', $profile->getId())
                //TO DO uncoment for version 3.4 for places
                //->execute();
                ->count();
        
        // TO DO uncomment for ver 3.4
        //$placesCount = $places ? $places->count() : 0;
        
        // ??? Remove this when user_places returns actual places not just count
        // TO DO uncomment for ver 3.4
        
        $return = array(
            'status' => 'success',
            'user_name' => $profile->__toString(),
            'user_location' => $profile->getCity() . '',
            'user_badges' => $profile->getBadges(),
            'user_reviews' => $profile->getReviews(),
            'user_photos' => $profile->getImages(),
            'user_photo_url' => image_path($profile->getThumb(), true),
            'fb_token' => '',
            // ??? Remove this when user_places returns actual places not just count
            'user_places_count' => $places,
            // TO DO uncomment for ver 3.4 when user_places returns actual places not just count
            //'user_places' => $placesCount,
            'badges' => array(),
            //'pictures' => array(),
            //'reviews' => array(),
            'activities' => array(),
            //'places' => array()
            );

        // TO DO uncomment for ver 3.4
        /*
        foreach ($pics as $pic) {
            $isCompanyPic = $pic->getCompanyImage();
            if ($isCompanyPic) {
                $comp = Doctrine::getTable('Company')->findOneById($pic->getCompanyImage()->getCompanyId());
            }
            else {
                $comp = false;
            }
            $return['pictures'][] = array(
                'id' => $pic->getId(),
                'url' => image_path($pic->getThumb('preview'), true),
                'review' => $pic->getCaption(),
                'company' => $comp ? $comp->getCompanyTitleByCulture($culture) : ''
            );
        }
        
        foreach ($reviews as $review) {
            $return['reviews'][] = array(
                'id' => $review->getId(),
                'review' => $review->getText(),
                'rating' => $review->getRating(),
                'company' => $review->getCompany()->getId()
            );
        }
        */
        
        foreach ($badges as $badge) {
            $return ['badges'] [] = array(
                'title' => $badge->getName(),
                'details' => $badge->getDescription(),
                'picture_url' => image_path($badge->getFile('active_image')->getUrl(), true));
        }

        $i18n = $this->getContext()->getI18N();

        foreach ($activities as $activitiy) {
            $return ['actions'] [] = array(
                'id' => $activitiy->getId(),
                'title' => $i18n->__('Checked in at %s', array('%s' => $activitiy->getCompany()->__toString())),
                'details' => $activitiy->getCompany()->getFullAddress(),
                'picture_url' => image_path($activitiy->getCompany()->getThumb(), true),
                'datetime' => $activitiy->getDateTimeObject('created_at')->format('c'));
        }

        // TO DO uncomment for ver 3.4
        /*
        if ($placesCount) {
            foreach ($places as $place) {
                $ppp = $place->getActivePPPService(true) ? 1 : 0;
                $isFavorite = Doctrine::getTable('Company')
                        ->createQuery('c')
                        ->innerJoin('c.CompanyPage p')
                        ->innerJoin('p.Follow f')
                        ->where('f.user_id = ?', $profile->getId())
                        ->andWhere('c.id = ?', $place->getId())
                        ->count();
                
                $return['places'][] = array(
                    'identifier' => $place->getId(),
                    'title' => $place->getCompanyTitleByCulture($culture),                                       
                    'phone' => $place->getPhoneFormated($place->getPhone(), $culture),
                    'address' => $place->getDisplayAddress(),
                    'ppp' => $ppp,
                    'ppp_review_id' => (($ppp == 1 && $place->getTopReview()) ? $place->getTopReview()->getId() : null),
                    'ppp_review_text' => (($ppp == 1 && $place->getTopReview()) ? $place->getTopReview()->getText() : null),
                    'ppp_review_picture' => (($ppp == 1 && ($place->getTopReview() && $place->getTopReview()->getUserProfile())) ? image_path($place->getTopReview()->getUserProfile()->getThumb(), true) : null),
                    'favourite' => $isFavorite,
                    'rating' => $place->getAverageRating(),
                    'reviews' => $place->getNumberOfReviews(),
                    'lat' => $place->getLocation()->getLatitude(),
                    'long' => $place->getLocation()->getLongitude(),
                    //'distance' => (!is_null($place->kms) ? $place->kms : 0),
                    'icon' => 'marker_' . $place->getSectorId(),
                    'picture_url' => image_path($place->getThumb(2, true), true),
                    'share_url' => 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . '://www.getlokal.' . ($this->getUser()->getDomain($culture) ? $this->getUser()->getDomain($culture). '/' . $culture : 'com/en') . '/' . $place->getCity()->getSlug() . '/' . $place->getSlug(),
                    'content_url' => $this->generateUrl('default', array('module' => 'api33', 'action' => 'company', 'id' => $place->getId(), 'token' => $request->getParameter('token'), 'locale' => $culture), true)
                );
            }
        }
        */
        
        if ($owner) {
            $return['fb_token'] = $profile->getAccessToken();
        }
        
        $this->getResponse()->setContent(json_encode($return));
//$this->setTemplate('prof');
        return sfView::NONE;
    }

    //-------------------------------------------------------------------------------------------------------------------------------------//

    public function executeLogin(sfWebRequest $request) {
        sfForm::disableCSRFProtection();
        $form = new sfGuardFormSignin ();

        $form->bind(array('username' => $request->getParameter('username'), 'password' => $request->getParameter('password')));
        
        if ($form->isValid()) {
            $login = new ApiLogin ();
            $login->setUserId($form->getValue('user')->getId());
            $login->save();

            MobileLog::log('login', null, $login->getUserId());

            $return = array('status' => 'SUCCESS', 'token' => $login->getToken());
        } else {
        	$i18n = $this->getContext()->getI18N();
			
        	$errors = $this->__getErrorMessages(array_merge($form->getErrorSchema()->getGlobalErrors(), $form->getErrorSchema()->getErrors()));        	
        	$return = array('status' => 'ERROR', 'title' => 'Getlokal', 'error' => $i18n->__(is_array($errors) ? current($errors) : $errors), 'error_code' => null);
        }

        $this->getResponse()->setContent(json_encode($return));
        return sfView::NONE;
    }
    
    private function __getErrorMessages($form_errors) {
    	$errors = array();
    	foreach ($form_errors as $key => $error) {
    		if (count($error) > 1 && method_exists($error, 'getErrors')) {
    			$errors_arr = $error->getErrors();
    			    			
    			$current = current(is_array($errors_arr) ? $errors_arr : array($error->getMessage()));    			
    		}
    		else {
    			$current = $error;
    		}
    		
 		$template = $current->getMessage();
    		//$parameters = $error->getParameters();
    
    		//foreach($parameters as $var => $value){
    		//	$template = str_replace($var, $value, $template);
    		//}
    
    		$errors[$key] = $template;
    	}
    	
    	return $errors;
    }

    // Testing links
    //
    public function executeRegister(sfWebRequest $request) {
        sfForm::disableCSRFProtection();

        $access_token = $request->getParameter('access_token', null);
        $accept = $request->getParameter('accept', '') == 1;
        //file_put_contents('testtext', $request->getParameter('city_name_en').' * '.$request->getParameter('county_name_en').' * '.$request->getParameter('country_name_en').' * '.$request->getParameter('city_lat').' * '.$request->getParameter('city_long'));
		if (!$accept) {
			$accept= '';
		}
		
        $city = $country = null;
        if ($access_token) {
            $form = new api22RegisterForm(null, array('fb' => true));
            $form->bind(array(
                'email_address' => $request->getParameter('username'),
                'first_name' => $request->getParameter('firstname'),
                'last_name' => $request->getParameter('lastname'),
                'allow_contact' => $request->getParameter('allow_contact', 0),
                'accept' => $accept
            ));
        } else {
            $form = new api22RegisterForm();
            $form->bind(array(
                'email_address' => $request->getParameter('username'),
                'password' => $request->getParameter('password'),
                'first_name' => $request->getParameter('firstname'),
                'last_name' => $request->getParameter('lastname'),
                'allow_contact' => $request->getParameter('allow_contact', 0),
                'accept' => $accept
            ));
        }

        if ($form->isValid()) {
            $cntry = Doctrine::getTable('Country')
                        ->createQuery('cou')
                        ->where('cou.name_en LIKE ?', $request->getParameter('country_name_en'))
                        ->andWhere('cou.slug != ?', '')
                        ->fetchOne();
                  
                    if ($cntry) {
                        $cty = Doctrine::getTable('City')
                            ->createQuery('ci')
                            ->innerJoin('ci.Translation ct')
                            ->innerJoin('ci.County co')
                            ->where('co.country_id = ?', $cntry->getId())
                            ->where('ct.name LIKE ?', $city_name)
                            ->fetchOne();

                        if (!$cty && in_array($cntry->getId(), getlokalPartner::getAllPartners()) && $request->getParameter('city_lat') && $request->getParameter('city_long')) {
                            $url = CityTable::geocodeUrl(
                                    null,
                                    $request->getParameter('city_lat'),
                                    $request->getParameter('city_long'),
                                    false
                            );
                            $geodata = CompanyLocationTable::getGeocodeData($url);
                        
                            $cty = Doctrine::getTable('City')
                                ->createQuery('ci')
                                ->innerJoin('ci.Translation ct')
                                ->innerJoin('ci.County co')
                                ->where('co.country_id = ?', $cntry->getId())
                                ->where('ct.name LIKE ?', $geodata['city'])
                                ->fetchOne();
                        }
                        
                        if(!($city)) {
                            $cityNameEn = $request->getParameter('city_name_en', null);
                            $countyNameEn = $request->getParameter('county_name_en', null);
                            $countryNameEn = $request->getParameter('country_name_en', null);
                            $cityLatitude = $request->getParameter('city_lat', null);
                            $cityLongitude = $request->getParameter('city_long', null);
                            
                            if ($cityNameEn && $countyNameEn && $countryNameEn && $cityLatitude && $cityLongitude) {
                                $geodata = array(
                                        'city_en' => $cityNameEn,
                                        'county_en' => $countyNameEn,
                                        'country_en' => $countryNameEn,
                                        'latitude' => $cityLatitude,
                                        'longitude' => $cityLongitude
                                        );
                                $city = CityTable::createFromGeocode($geodata);
                            }
                        }
                    }

            if ($city) {
                $cityId = $city->getId();
                $countryId = $city->getCountry()->getId();
            } else {
                $cityId = $countryId = null;
            }

            $user = $this->__registerUser($request, $form, $cityId, $countryId, $access_token);

            $login = new ApiLogin();
            $login->setUserId($user->getId());
            $login->setExpiresAt(date('Y-m-d H:i:s', time() + (30 * 86400)));
            $login->save();

            if ($city) {
                $this->getUser()->setCountry($city->getCountry());
            }
            $this->getUser()->setCulture($request->getParameter('locale', 'en'));

            MobileLog::log('register', null, $login->getUserId());

            // Success mail
            try {
                myTools::sendMail($user, 'Welcome to getlokal', 'successRegisteration', $vars = array() ,$send = false, $locale=$request->getParameter('locale', 'en'));
            } catch (Exception $e) {}

            ////////////////
            if ($file = $request->getParameter('file', NULL)) {
                $formImage = new ImageForm ();
                $formImage->bind(array(), $request->getFiles());

                if ($formImage->isValid()) {
                    $image = new Image ();
                    $image->setFile($formImage->getValue('file'));
                    $image->setUserId($this->getUser()->getId());
                    $image->setStatus('mobile_upload');
                    $image->setType('profile');
                    //$image->setStatus('approved');
                    $image->save();

                    MobileLog::log('upload', $image->getId());

                    $profile = $user->getUserProfile();
                    $profile->setImageId($image->getId());
                    $profile->save();

                    $return = array('status' => 'SUCCESS', 'token' => $login->getToken());
                } else {
                	$i18n = $this->getContext()->getI18N();
                	
                    $errors = $this->__getErrors($formImage);
                    $return = array('status' => 'ERROR', 'title' => 'Getlokal', 'error' => $i18n->__(is_array($errors) ? current($errors) : $errors), 'error_code' => null);
                }
            }
        //////////////
            $return = array('status' => 'SUCCESS', 'token' => $login->getToken());
        } else {
            $errors = $this->__getErrors($form);
            $return = array('status' => 'ERROR', 'title' => 'Getlokal', 'error' => (is_array($errors) ? current($errors) : $errors), 'error_code' => null);
        }

        $this->getResponse()->setContent(json_encode($return));
        return sfView::NONE;
    }

    private function __registerUser($request, $form, $cityId, $countryId, $access_token) {
        $user = new sfGuardUser();
        $user->fromArray($form->getValues());

        $user->setUsername(myTools::cleanUrl($user->getFirstName()) . '.' . rand(1000, 9999));
        if ($access_token) {
            $password = substr(md5(rand(100000, 999999)), 0, 8);
            $user->setPassword($password);
        }

        $user->save();

        $profile = new UserProfile();
        $profile->setId($user->getId());
        $profile->setCityId($cityId);
        $profile->setCountryId($countryId);

        if ($access_token) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/me?access_token=" . $request->getParameter('access_token'));
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_AUTOREFERER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); # required for https urls

            $user_data = json_decode(curl_exec($ch), true);

            if (isset($user_data['error'])) {
//                 $return = array('status' => 'ERROR', 'error' => $user_data['error']['message']);
//                 debug($return); die;

                $return = array('status' => 'ERROR', 'title' => 'Getlokal', 'error' => (is_array($user_data['error']['message']) ? current($user_data['error']['message']) : $user_data['error']['message']), 'error_code' => null);
            	$this->getResponse()->setContent(json_encode($return));
            	return sfView::NONE;
            } else {
                curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/me/picture?type=large&" . $access_token);

                $temp_pic = sfConfig::get('sf_upload_dir') . '/' . uniqid('tmp_') . '.jpg';
                file_put_contents($temp_pic, curl_exec($ch));

                $file = new sfValidatedFile(myTools::cleanUrl($user_data['name']) . '.jpg', filetype($temp_pic), $temp_pic, filesize($temp_pic));

                $gender = null;
                if (isset($user_data ['gender']) && $user_data['gender'] == 'male') {
                    $gender = 'm';
                } elseif (isset($user_data ['gender']) && $user_data['gender'] == 'female') {
                    $gender = 'f';
                }
                $date = DateTime::createFromFormat('m/d/Y', $user_data['birthday']);
                if ($date) {
                    $profile->setBirthDate($date->format('Y-m-d'));
                }
                $profile->setFacebookUrl($user_data['link']);
                $profile->setFacebookUid($user_data['id']);
                $profile->setGender($gender);
                $profile->setAccessToken($access_token);
            }
        }

        $profile->save();

        $user_settings = new UserSetting();
        $user_settings->setId($profile->getId());

        if ($request->getParameter('allow_contact') == 0) {
            $user_settings->setAllowContact(false);
            $user_settings->setAllowNewsletter(false);
        } else {
            $user_settings->setAllowContact(true);
            $user_settings->setAllowNewsletter(true);
            $user_settings->setAllowPromo(true);
        }
        $user_settings->save();

        $newsletters = NewsletterTable::retrieveActivePerCountryForUser($profile->getCountryId());
        if ($newsletters) {
            foreach ($newsletters as $newsletter) {
                $usernewsletter = new NewsletterUser();
                $usernewsletter->setNewsletterId($newsletter->getId());
                $usernewsletter->setUserId($user->getId());
                $usernewsletter->setIsActive($request->getParameter('allow_contact'));
                $usernewsletter->save();
            }

            MC::subscribe_unsubscribe($user);
        }

        return $user;
    }

    public function executeRecover(sfWebRequest $request) {
        sfForm::disableCSRFProtection();
        $form = new ForgotPasswordForm();

        $form->bind(array('email' => $request->getParameter('username', '')));

        if ($form->isValid()) {
            $return = array('status' => 'SUCCESS');

            $password = substr(md5(rand(100000, 999999)), 0, 8);

            $user = Doctrine::getTable('sfGuardUser')->findOneByEmailAddress($form->getValue('email'));
            if ($user) {
                $user->setPassword($password);
                $user->save();
                myTools::sendMail($user, 'Forgotten Password', 'forgotPassword', array('password' => $password), $send = false, $request->getParameter('locale', 'en'));
            } else {
                $i18n = $this->getContext()->getI18N();
                $return = array(
                    'status' => 'ERROR',
                    'title' => 'Getlokal',
                    'error' => $i18n->__('The email was not found in our database'),
                	'error_code' => null
                );
            }
        } else {
        	$i18n = $this->getContext()->getI18N();
        	//$this->__getErrorMessages(array_merge($form->getErrorSchema()->getGlobalErrors(), $form->getErrorSchema()->getErrors()));
        	$errors = $this->__getErrorMessages($form->getErrorSchema()->getErrors());
        	$return = array('status' => 'ERROR', 'error' => $i18n->__(is_array($errors) ? current($errors) : $errors), 'error_code' => null);
        }

        $this->getResponse()->setContent(json_encode($return));
        return sfView::NONE;
    }

    public function executePhotos(sfWebRequest $request) {
        $return = array('status' => 'SUCCESS', 'photos' => array());

        sfContext::getInstance()->getConfiguration()->loadHelpers('Asset');
        $images = $request->getParameter('type', 0) == 0 ? $this->getCompanyImages() : $this->getEventImages();
        foreach ($images as $image) {
            $return ['photos'] [] = array('url' => image_path($image->getImage()->getThumb('preview', true), true), 'caption' => ($image->getImage()->getDescription() ? $image->getImage()->getDescription() : $image->getImage()->getCaption()));
        }

        $this->getResponse()->setContent(json_encode($return));
        return sfView::NONE;
    }

    public function getCompanyImages() {
    	$this->forward404Unless($item = Doctrine::getTable('Company')->find($this->getRequest()->getParameter('identifier')));
    	
    	$limit = $this->getRequest()->getParameter('limit', 20);
    	$offset = $this->getRequest()->getParameter('offset', 0);

        $query = Doctrine::getTable('CompanyImage')
        		->createQuery('ci')
		        ->innerJoin('ci.Image i')
		        ->where('ci.company_id = ?', $item->getId())
		        ->andWhere('i.status = "approved" OR i.status = "mobile_upload"')
        		->offset($offset)
        		->limit($limit);
         /*
         if (isset($offset) && $offset) {
         	$query->offset($offset);
         }
         
         if (isset($limit) && $limit) {
         	$query->limit($limit);
         }
         */
		        
		return $query->execute();
    }

    public function getEventImages() {
        $this->forward404Unless($item = Doctrine::getTable('Event')->find($this->getRequest()->getParameter('identifier')));

        return Doctrine::getTable('EventImage')->createQuery('ci')->innerJoin('ci.Image i')->where('ci.event_id = ?', $item->getId())->andWhere('i.status = "approved"')->limit(20)->execute();
    }

    public function executeReview(sfWebRequest $request) {
    	$imageUrl = '';
    	$this->__checkToken($request->getParameter('token'));
        $this->forward404Unless($company = Doctrine::getTable('Company')->find($request->getParameter('identifier')));
        sfForm::disableCSRFProtection();
        $review = null;
        $image_array = $review_array = array();
        $form = new ReviewImageForm();
        $form->bind(array(
            'rating' => $request->getParameter('rating'),
            'text' => $request->getParameter('review'),
            'file' => $request->getParameter('file')
        ), $request->getFiles());
        
        if ($form->isValid()) {
            if ($request->getParameter('rating') && $request->getParameter('review')) {
                $review = new Review();
                $review->fromArray($form->getValues());
                $review->setCompanyId($company->getId());
                $review->setUserId($this->getUser()->getId());
                $review->setReferer(MobileLog::getOs());

                $review->save();

                MobileLog::log('review', $review->getId());
            }
            if ($form->getValue('file')) {
                $image = new Image();
                $image->setFile($form->getValue('file'));
                $image->setUserId($this->getUser()->getId());
                $image->setStatus('approved');
                $image->setType('company');
                $image->save();

                MobileLog::log('upload', $image->getId());

                $company_image = new CompanyImage();
                $company_image->setCompanyId($company->getId());
                $company_image->setImageId($image->getId());
                $company_image->save();

                if (!$company->getImageId()) {
                    $company->setImageId($image->getId());
                    $company->save();
                }
                $image_array = array(
                    'identifier' => $image->getId(),
                    'url' => $image->getThumb('preview', true),
                    'caption' => $image->getDescription()
                );
                $imageUrl = image_path($image->getThumb('preview'));
            }
            if (!empty($image_array)) {
                $return = array_merge(array('status' => 'SUCCESS'), $image_array);
            } else {
                $return = array('status' => 'SUCCESS');
            }
            $shareToFacebook = $request->getParameter('share_to_facebook');
            if($shareToFacebook == true){
            	$return = $this->_shareToFacebook($request, $imageUrl);
            }
        } else {
        	$errors = $this->__getErrors($form);
        	$i18n = $this->getContext()->getI18N();
        	$return = array('status' => 'ERROR', 'title' => 'Getlokal', 'error' => $i18n->__(is_array($errors) ? current($errors) : $errors), 'error_code' => null);
        }

        $this->getResponse()->setContent(json_encode($return));
        return sfView::NONE;
    }
    
    protected function _shareToFacebook($request, $picture) {
    	$f = fopen('reviews.log', 'a+');
    	$test = 0;
    	$access_token = $request->getParameter('facebookAuthToken');
    
    	$company = Doctrine::getTable('Company')->findOneById($request->getParameter('identifier'));
    	$culture = $request->getParameter('locale');
    	$share_url = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . '://www.getlokal.' . ($this->getUser()->getDomain($culture) ? $this->getUser()->getDomain($culture). '/' . $culture : 'com/en') . '/' . $company->getCity()->getSlug() . '/' . $company->getSlug();
    	$link = $share_url;
    
    	$message = $request->getParameter('review');
    
    	if($test){
    		$access_token = "CAAEHhjdGjB4BACsYIlHpqziduuZCGcR2PRtzEBshfRS8D7ZAbwTkU9zA9uVyc0l92KQGgMgyxWZA5jfj4QNA2a9Pg5CZBan59YXfho5CXPbwMekE4KXqsZCcgRXlOazIiTN88oEUehpslfbIunzrSGt9wPX96nohtlgqiSv7VbRBMeJvOnxxSXe8CLvYKDCgZD";
    	}
    	$postData = array (
    			'method=POST'
    	);
    	if(!is_null($picture) && $picture != ''){
    		$postData['picture'] = $picture;
    	}
    	if(!is_null($link) && $link != ''){
    		$postData['link'] = $link;
    	}
    	if(!is_null($message) && $message != ''){
    		$postData['message'] = $message;
    	}
    	$data = http_build_query($postData);
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/me/feed?access_token=" . $access_token);
    	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); # required for https urls
    	$response = json_decode(curl_exec($ch));
    	if(isset($response->error)){
    		$i18n = $this->getContext()->getI18N();
    		$result = array('status' => 'error',
    				'title' => 'Getlokal',
    				'error' => $i18n->__("We are sorry but an error occurred and we couldn't share your review or picture on Facebook"),
    				'error_code' => $response->error->code,
    				'share_url' => $share_url);
    		//echo json_encode($result);
    	}else{
    		$result = array('status' => 'ok',
    				'error_code' => 0,
    				'share_url' => $share_url);
    		//echo json_encode($result);
    	}
    	fwrite($f, 'picture_url: '.$picture.chr(10));
    	fwrite($f, 'result: '.json_encode($result).chr(10));
    	
    	return $result;
    	die;
    }

    public function executeFavoriteList(sfWebRequest $request) {
        $this->__checkToken($request->getParameter('token'));
        sfContext::getInstance()->getConfiguration()->loadHelpers('Asset');

        $con = Doctrine::getConnectionByTableName('search');

        $lat = $con->quote($request->getParameter('lat'));
        $lng = $con->quote($request->getParameter('long'));
        $this->forward404Unless($lat || $lng);

        $limit = $request->getParameter('limit', 20);
        $offset = $request->getParameter('offset', 0);
        
        $sql = "((ACOS(SIN(%s * PI() / 180) * SIN(l.latitude * PI() / 180) + COS(%s * PI() / 180) * COS(l.latitude * PI() / 180) * COS((%s - l.longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as kms";
        $kms = sprintf($sql, $lat, $lat, $lng);

        $query = Doctrine::getTable('Company')
	        ->createQuery('c')
	        ->addSelect('c.*, i.*')
	        ->addSelect($kms)
	        ->innerJoin('c.CompanyLocation l')
	        ->innerJoin('c.CompanyPage p')
	        ->innerJoin('p.Follow f')
	        ->leftJoin('c.Image i')
	        ->where('f.user_id = ?', $this->getUser()->getId())
        	->andWhere('c.status = ?', 0)
        	->orderBy('f.id DESC');
        
        if (isset($offset) && $offset) {
        	$query->offset($offset);
        }
        
        if (isset($limit) && $limit) {
        	$query->limit($limit);
        }

        $return = array();
        $culture = $this->getUser()->getCulture();
        foreach ($query->execute() as $company) {
            $return[] = array(
                'identifier' => $company->getId(),
                'title' => $company->getCompanyTitleByCulture(),
                'ppp' => ($company->getActivePPPService(true) ? 1 : 0),
                'phone' => $company->getPhoneFormated($company->getPhone(), $this->getUser()->getCulture()),
                'address' => $company->getDisplayAddress(),
                'favourite' => 1,
                'rating' => $company->getAverageRating(),
                'reviews' => $company->getNumberOfReviews(),
                'lat' => $company->getLocation()->getLatitude(),
                'long' => $company->getLocation()->getLongitude(),
                'distance' => (!is_null($company->kms) ? $company->kms : 0),
                'icon' => 'marker_' . $company->getSectorId(),
                'picture_url' => image_path($company->getThumb(0, true), true),
                'share_url' => 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . '://www.getlokal.' . ($this->getUser()->getDomain($culture) ? $this->getUser()->getDomain($culture). '/' . $culture : 'com/en') . '/' . $company->getCity()->getSlug() . '/' . $company->getSlug(),
                'content_url' => $this->generateUrl('default', array('module' => 'api33', 'action' => 'company', 'id' => $company->getId(), 'token' => $request->getParameter('token'), 'locale' => $this->getUser()->getCulture()), true),
            	'place_type' => $company->getClassification()->getTitle()
            );
        }

        $this->getResponse()->setContent(json_encode(array(
            'status' => 'ok',
            'items' => $return
        )));
        return sfView::NONE;
    }

    public function executeFavorite(sfWebRequest $request) {
        $this->__checkToken($request->getParameter('token'));
        $company = Doctrine::getTable('Company')->find($request->getParameter('identifier'));
        if (!$company) {
        	$i18n = $this->getContext()->getI18N();
			
            $return = array('status' => 'ERROR', 'title' => 'Getlokal', 'error' => $i18n->__('No places found'), 'error_code' => null);
			
            $this->getResponse()->setContent(json_encode($return));
            return sfView::NONE;
        }
        $query = Doctrine::getTable('Follow')->createQuery('f')->where('f.user_id = ?', $this->getUser()->getId())->andWhere('f.page_id = ?', $company->getCompanyPage()->getId());

        if ($follow = $query->fetchOne()) {
            $follow->delete();
        } else {
            $follow = new Follow ();
            $follow->setUserId($this->getUser()->getId());
            $follow->setPageId($company->getCompanyPage()->getId());
            $follow->save();

            MobileLog::log('follow', $company->getId());
        }

        $return = array('status' => 'SUCCESS');

        $this->getResponse()->setContent(json_encode($return));
        return sfView::NONE;
    }


    public function executeStatus(sfWebRequest $request) {
        $this->__checkToken($request->getParameter('token'));
        $this->forward404Unless($event = Doctrine::getTable('Event')->find($request->getParameter('identifier')));

        $query = Doctrine::getTable('EventUser')->createQuery('eu')->andWhere('eu.event_id = ?', $event->getId())->andWhere('eu.user_id = ?', $this->getUser()->getId());

        if ($eventUser = $query->fetchOne()) {
            if ($request->getParameter('rsvp', 0) == 0) {
                $eventUser->delete();
            }
        } elseif ($request->getParameter('rsvp', 0) != 0) {
            $eventUser = new EventUser ();
            $eventUser->setEventId($event->getId());
            $eventUser->setConfirm(1);
            $eventUser->setUserId($this->getUser()->getId());
            $eventUser->save();
        }

        $return = array('status' => 'SUCCESS');

        $this->getResponse()->setContent(json_encode($return));
        return sfView::NONE;
    }

    public function executeUpload(sfWebRequest $request) {
        $this->__checkToken($request->getParameter('token'));
        $this->forward404Unless($company = Doctrine::getTable('Company')->find($request->getParameter('identifier')));
        sfForm::disableCSRFProtection();

        $form = new ImageForm ();
        $form->bind(array(), $request->getFiles());

        if ($form->isValid()) {
            $image = new Image ();
            $image->setFile($form->getValue('file'));
            $image->setUserId($this->getUser()->getId());
            $image->setStatus('mobile_upload');
            $image->setType('company');
            $image->save();

            MobileLog::log('upload', $image->getId());

            $company_image = new CompanyImage ();
            $company_image->setCompanyId($company->getId());
            $company_image->setImageId($image->getId());
            $company_image->save();

            if (!$company->getImageId()) {
                $company->setImageId($image->getId());
                $company->save();
            }

            $return = array('status' => 'SUCCESS', 'identifier' => $image->getId());
        } else {
        	$i18n = $this->getContext()->getI18N();
			
            $errors = $this->__getErrors($form);
            $return = array('status' => 'ERROR', 'title' => 'Getlokal', 'error' => $i18n->__(is_array($errors) ? current($errors) : $errors), 'error_code' => null);
        }

        $this->getResponse()->setContent(json_encode($return));
        return sfView::NONE;
    }

    public function executeProfilephoto(sfWebRequest $request) {
        $this->__checkToken($request->getParameter('token'));
        sfForm::disableCSRFProtection();

        $form = new ImageForm ();
        $form->bind(array(), $request->getFiles());

        if ($form->isValid()) {
            $image = new Image ();
            $image->setFile($form->getValue('file'));
            $image->setUserId($this->getUser()->getId());
            $image->setStatus('mobile_upload');
            $image->setType('profile');
            $image->save();

            $profile = Doctrine::getTable('UserProfile')->find($this->getUser()->getId());
            $profile->setImageId($image->getId());
            $profile->save();

            $return = array('status' => 'SUCCESS', 'identifier' => $image->getId());
        } else {
        	$i18n = $this->getContext()->getI18N();
			
            $errors = $this->__getErrors($form);
            $return = array('status' => 'ERROR', 'title' => 'Getlokal', 'error' => $i18n->__(is_array($errors) ? current($errors) : $errors), 'error_code' => null);
        }

        $this->getResponse()->setContent(json_encode($return));
        return sfView::NONE;
    }

    public function executeValidatephoto(sfWebRequest $request) {
        $this->__checkToken($request->getParameter('token'));
        $image = Doctrine::getTable('Image')->createQuery('i')->where('i.id = ? ', $request->getParameter('photoid'))->andWhere('i.user_id = ?', $this->getUser()->getId())->fetchOne();

        if (!$image) {
        	$i18n = $this->getContext()->getI18N();
			
            $return = array('status' => 'ERROR', 'title' => 'Getlokal', 'error' => $i18n->__('Right now you can only upload pictures. Video upload will be coming soon.'), 'error_code' => null);
            $this->getResponse()->setContent(json_encode($return));
            return sfView::NONE;
        }

        $image->setCaption($request->getParameter('text'));
        $image->setStatus('approved');
        $image->save();

        $company = $image->getCompany();
        if ($company && !$company->getImageId()) {
            $company->setImageId($image->getId());
            $company->save();
        }
        $return = array('status' => 'SUCCESS', 'identifier' => $image->getId(), 'url' => $image->getThumb('preview', true), 'caption' => $image->getDescription());
        $shareToFacebook = $request->getParameter('share_to_facebook');
        // share picture on FB be aware about the URL of the site
        $f = fopen('reviews.log', 'a+');
        fwrite($f, chr(10)."add a picture: ".chr(10));
        if($shareToFacebook == true || $shareToFacebook == 1){
        	$request->setParameter('review', $request->getParameter('text'));
        
        	$companyImage = $this->page = Doctrine::getTable('CompanyImage')
        	->createQuery('ci')
        	->where('ci.image_id = ?', $request->getParameter('photoid'))
        	->fetchOne();
        
        	$request->setParameter('identifier', $companyImage->getCompanyId());
        
        	$imageUrl = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . '://static.getlokal.com'.$image->getThumb('preview');
        	fwrite($f, chr(10)."going to share picture in FB".chr(10));
        	$return = $this->_shareToFacebook($request, $imageUrl);
        }
        
        $this->getResponse()->setContent(json_encode($return));
        return sfView::NONE;
    }

    public function executeCompanyoffers(sfWebRequest $request) {

        $this->forward404Unless($item = Doctrine::getTable('Company')->find($this->getRequest()->getParameter('identifier')));

        $offers = $item->getAllOffers(true);

        $return = array('status' => 'SUCCESS', 'offers' => array());
        if ($offers) {
            foreach ($offers as $offer) {
                $return ['offers'] [] = array('title' => $offer->getDisplayTitle(), 'description' => $offer->getDisplayDescription(), 'image' => $offer->getThumb('preview', true), 'active_to' => $offer->getActiveTo(), 'valid_from' => $offer->getValidFrom(), 'valid_to' => $offer->getValidTo(), 'max_vouchers' => $offer->getMaxVouchers(), 'max_per_user' => $offer->getMaxPerUser(), 'can_be_claimed' => ($offer->getIsAvailableToOrder() ? 1 : 0));
            }
        }

        $this->getResponse()->setContent(json_encode($return));
        return sfView::NONE;
    }

    public function executeMyVouchers(sfWebRequest $request) {
        $this->__checkToken($request->getParameter('token'));
        // sfContext::getInstance()->getConfiguration()->loadHelpers('Asset');

        $lat = $request->getParameter('lat');
        $lng = $request->getParameter('long');

        $this->forward404Unless($lat || $lng);

        $profile = Doctrine::getTable('UserProfile')->createQuery('p')
            ->innerJoin('p.sfGuardUser')
            ->leftJoin('p.City')
            ->where('p.id = ?', $this->getUser()->getId())->fetchOne();

        $km_sql = "((ACOS(SIN(%s * PI() / 180) * SIN(cl.latitude * PI() / 180) + COS(%s * PI() / 180) * COS(cl.latitude * PI() / 180) * COS((%s - cl.longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as kms";
        $kms = sprintf($km_sql, $lat, $lat, $lng);

        $query = VoucherTable::getVouchersQuery($profile, false, true)
            ->innerJoin('co.Company c')
            ->innerJoin('c.CompanyLocation cl')
            ->select('a.*, c.*, co.*, cl.*')
            ->addSelect($kms);

        $vouchers = $query->execute();
        $return = array('status' => 'SUCCESS', 'vouchers' => array());
        if ($vouchers) {
            foreach ($vouchers as $voucher) {
                $offer = $voucher->getCompanyOffer();

                $return['vouchers'][] = array(
                    'identifier' => $voucher->getCode(),
                    'content_url' => $this->generateUrl('default', array(
                        'module' => 'api33',
                        'action' => 'voucher'
                    ), true) . '?' . http_build_query(array(
                        'token' => $request->getParameter('token'),
                        'voucher_id' => $voucher->getId()
                    )),
                    'share_url' => 'SOON',  # possible doesnt exist
                    'calendar_date' => $offer->getDateTimeObject('valid_to')->format('d/m/Y'),
                    'offer' => $this->__formatOffer($offer, $voucher->kms, true)
                );
            }
        }

        $this->getResponse()->setContent(json_encode($return));
        return sfView::NONE;
    }

    // voucher id: 331
    public function executeVoucher(sfWebRequest $request) {
        $this->__checkToken($request->getParameter('token'));

        $query = VoucherTable::getInstance()->createQuery('v')
            ->innerJoin('v.CompanyOffer o')
            ->innerjoin('o.Company c')
            ->innerjoin('c.CompanyLocation cl')
            ->innerJoin('c.City ci')
            ->where('v.id = ?', $request->getParameter('voucher_id'))
            ->andWhere('v.user_id = ?', $this->getUser()->getId());
        $this->forward404Unless($query->count() > 0);

        $this->voucher = $query->execute()->getFirst();
    }

    public function executeClaimOffer(sfWebRequest $request) {
        $this->__checkToken($request->getParameter('token'));

        $offer = CompanyOfferTable::getInstance()->find($request->getParameter('offer_id'));
        $this->forward404Unless($offer, "We were unable to issue your voucher. The offer is no longer active or you have already ordered the maximum number vouchers per user.", 150);

        if ($offer->getIsActive() && $offer->getIsAvailableToOrder($this->getUser())) {
            $user_voucher = new Voucher();
            $user_voucher->setUserId($this->getUser()->getId());
            $user_voucher->setCompanyOfferId($offer->getId());
            $user_voucher->setCode(substr(uniqid(md5($offer->getCode() . rand()), true), 0, 8));
            $user_voucher->save();

            MobileLog::log('getvoucher', $offer->getId());
            
            $offer->updateNumberOfVouchers();
            $contentUrl = $this->generateUrl('default', array(
                'module' => 'api33',
                'action' => 'voucher',
            ), true) . '?' . http_build_query(array(
                'token' => $request->getParameter('token'),
                'voucher_id' => $user_voucher->getId(),
                'lat' => $request->getParameter('lat', ''),
                'long' => $request->getParameter('long', '')
            ));
            $offerData = $this->__formatOffer($offer);
            $return = array(
                'status' => 'SUCCESS',
                'voucher' => array(
                    'identifier' => $user_voucher->getCode(),
                    'content_url' => $contentUrl,
                    'share_url' => $offerData['share_url'],
                    'calendar_date' => $offer->getDateTimeObject('valid_to')->format('d/m/Y'),
                    'offer' => $offerData
                )
            );
        } else {
            $i18n = $this->getContext()->getI18N();
            $return = array(
                'status' => 'ERROR',
                'title'=>'Getlokal',                
                'error' => $i18n->__('We were unable to issue your voucher. The offer is no longer active or you have already ordered the maximum number vouchers per user.'),
                'error_code' => 51
            );
        }

        $this->getResponse()->setContent(json_encode($return));

        return sfView::NONE;
    }

    public function executeReport(sfWebRequest $request) {
        $this->__checkToken($request->getParameter('token'));
        $this->company = Doctrine::getTable('Company')->findOneById($request->getParameter('identifier'));
        if (!$this->company) {
            $return = array('status' => 'ERROR', 'title' => 'Getlokal', 'error' => 'No places found', 'error_code' => null);
            $this->getResponse()->setContent(json_encode($return));
            return sfView::NONE;
        }
        $user = Doctrine::getTable('sfGuardUser')->findOneById($this->getUser()->getId());

        $report = new ReportCompany ();
        $report->fromArray(array('user_id' => $user->getId(), 'email' => $user->getEmailAddress(), 'name' => $user->getFirstName() . ' ' . $user->getLastName(), 'object_id' => $this->company->getId()));

        sfForm::disableCSRFProtection();

        $form = new ReportMobileForm($report);

        $form->bind(array('offence' => $request->getParameter('offence')));
        if ($form->isValid()) {
            $form->save();
            $return = array('status' => 'SUCCESS');
        } else {
        	$i18n = sfContext::getInstance()->getI18N();
        	
        	$errors = $this->__getErrorMessages(array_merge($form->getErrorSchema()->getGlobalErrors(), $form->getErrorSchema()->getErrors()));
            $return = array('status' => 'ERROR', 'title' => 'Getlokal', 'error' => $i18n->__(is_array($errors) ? current($errors) : $errors), 'error_code' => null);
        }
        $this->getResponse()->setContent(json_encode($return));
        return sfView::NONE;
    }

    public function executeAddnewplace(sfWebRequest $request) {
        
        $this->__checkToken($request->getParameter('token'));
        sfForm::disableCSRFProtection();
        $lat = $request->getParameter('lat');
        $lng = $request->getParameter('long');
        $this->forward404Unless($lat || $lng);

        $lat = $request->getParameter('place_lat');
        $lng = $request->getParameter('place_long');
        $this->forward404Unless($lat || $lng);
        
        $culture = $this->getUser()->getCulture();
        //file_put_contents('testtext', $request->getParameter('address').' * '.$request->getParameter('city_name_en').' * '.$request->getParameter('county_name_en').' * '.$request->getParameter('country_name_en').' * '.$request->getParameter('city_lat').' * '.$request->getParameter('city_long'));
        $city_name = $request->getParameter('city_name_en');
        $country_name = $request->getParameter('country_name_en');
        
        sfContext::getInstance()->getConfiguration()->loadHelpers('Asset');
        
        $company = new Company();

        $form = new api22CompanyMobileForm($company);      

        //only for geocoding tests and request param google_check set to true
        if ($request->getParameter('google_check', false)) {
            $url = CityTable::geocodeUrl(
                    $request->getParameter('location'),
                    $request->getParameter('lat'),
                    $request->getParameter('long'),
                    true
            );
            $geodata = CompanyLocationTable::getGeocodeData($url);
            var_dump($geodata); exit();
        }
        //only for geocoding tests and request param google_results set to true
        if ($request->getParameter('google_results', false)) {
            $url = CityTable::geocodeUrl(
                    $request->getParameter('location'),
                    $request->getParameter('lat'),
                    $request->getParameter('long'),
                    true
            );
            $geodata = CompanyLocationTable::getGeocodeData($url, true, true);
            var_dump($geodata); exit();
        }
        //end of geocoding request test

        $form->bind(array(
            'title' => $request->getParameter('title'),
            'address' => $request->getParameter('address'),
            'classification_id' => $request->getParameter('classification_id'),
            'phone' => $request->getParameter('phone')
        ));
        
        //if($request->getParameter('address')) {
            if(!strstr($request->getParameter('location'), '(null)')) {
                if ($form->isValid()) {
                    $cntry = Doctrine::getTable('Country')
                        ->createQuery('cou')
                        ->where('cou.name_en LIKE ?', $country_name)
                        ->andWhere('cou.slug != ?', '')
                        ->fetchOne();
                    
                    if ($cntry) {
                        $cty = Doctrine::getTable('City')
                        ->createQuery('ci')
                        ->innerJoin('ci.Translation ct')
                        ->innerJoin('ci.County co')
                        ->where('co.country_id = ?', $cntry->getId())
                        ->where('ct.name LIKE ?', $city_name)
                        ->fetchOne();
                        
                        if (!$cty && in_array($cntry->getId(), getlokalPartner::getAllPartners())) {
                            $url = CityTable::geocodeUrl(
                                    null,
                                    $request->getParameter('place_lat'),
                                    $request->getParameter('place_long'),
                                    false
                            );
                            $geodata = CompanyLocationTable::getGeocodeData($url);
                            
                            $cty = Doctrine::getTable('City')
                                ->createQuery('ci')
                                ->innerJoin('ci.Translation ct')
                                ->innerJoin('ci.County co')
                                ->where('co.country_id = ?', $cntry->getId())
                                ->where('ct.name LIKE ?', $geodata['city'])
                                ->fetchOne();
                        }
                        
                        if(!($cty)) {
                            $cityNameEn = $request->getParameter('city_name_en', null);
                            $countyNameEn = $request->getParameter('county_name_en', null);
                            $countryNameEn = $request->getParameter('country_name_en', null);
                            $cityLatitude = $request->getParameter('city_lat', null);
                            $cityLongitude = $request->getParameter('city_long', null);
                            
                            if ($cityNameEn && $countyNameEn && $countryNameEn && $cityLatitude && $cityLongitude) {
                                $geodata = array(
                                        'city_en' => $cityNameEn,
                                        'county_en' => $countyNameEn,
                                        'country_en' => $countryNameEn,
                                        'latitude' => $cityLatitude,
                                        'longitude' => $cityLongitude
                                        );
                                $cty = CityTable::createFromGeocode($geodata);
                                MobileLog::log('city', $cty->getId());
                            }
                        }
                        
                        if ($cty) {
                            $country_slug = $cntry->getSlug();
        
                            $remove = array(',', ';', ':', '"', '„', '”', '“', '(', ')', '№', '&ndash;');
                            $title = trim(str_replace($remove, ' ', $request->getParameter('title')));
                            $partnerInstance = getlokalPartner::getInstance($cntry->getSlug());
                            $partnerClass = getlokalPartner::getLanguageClass($partnerInstance);
                            
                            $titleEn = call_user_func(array('Transliterate' . $partnerClass, 'toLatin'), $title);
                            $address = $request->getParameter('address', '');
                            $street_number = $request->getParameter('street_number');
                           
                           // $address = utf8_encode($address);//iconv(mb_detect_encoding($address), 'UTF-8', $address);
        //var_dump(mb_detect_encoding($address, 'auto'). '  *  ');exit;
                            $classification = Doctrine::getTable('Classification')->findOneById($request->getParameter('classification_id'));
                            $currentCulture = $this->getUser()->getCulture();
                            $this->getUser()->setCulture($country_slug);
                            $company->setTitle($title);
        
                            if ($country_slug == 'fi') {
                                $this->getUser()->setCulture('en');
                                $company->setTitle($titleEn);
                                $this->getUser()->setCulture('ru');
                                $titleRu = call_user_func(array('Transliterate' . $partnerClass, 'toRu'), $title);
                                $company->setTitle($titleRu);
                            }
                            else {
                                $this->getUser()->setCulture('en');
                                $company->setTitle($titleEn);
                            }
                            $this->getUser()->setCulture($currentCulture);
                            $company->setClassificationId($request->getParameter('classification_id'));
                            $company->setSectorId($classification->getPrimarySector()->getId());
                            $company->setPhone(str_replace('+', '00', $request->getParameter('phone')));
                            $company->setReferer(MobileLog::getOs());
                            $company->setCreatedBy($this->getUser()->getId());
 
                            if (!isset($company_location)) {
                                $company_location = new CompanyLocation();
                                $company_location->setIsActive(1);
                                $company_location->setStreet($address);
                                $company_location->setLatitude($request->getParameter('place_lat'));
                                $company_location->setLongitude($request->getParameter('place_long'));
                                $company_location->setFullAddress(trim($address.' '.$street_number));
                            }
        
                            if ($street_number) {
                                $company_location->setStreetNumber($street_number);
                            }
        
                            $company->setCity($cty);
                            $company->setCountry($cntry);
        
                            $company->setStatus(CompanyTable::VISIBLE);
        
                            $company_location->setCompany($company);
                            $company_location->save();
        
                            $company->setLocationId($company_location->getId());
                            $company->save();
       
                            // save company classification
                            $company_classification = new CompanyClassification();
                            $company_classification->setCompany($company);
                            $company_classification->setClassificationId($classification->getId());
                            $company_classification->save();
                            
                            $distance = null;
                            if ($lat && $lng && $company_location->getLatitude() && $company_location->getLongitude()) {
                            	$lat = $request->getParameter('lat');
                            	$lng = $request->getParameter('long');
                            	
                            	$distance = ((acos(sin($lat * pi() / 360) * sin($company_location->getLatitude() * pi() / 360) + cos($lat * pi() / 360) * cos($company_location->getLatitude() * pi() / 360) * cos(($lng - $company_location->getLongitude()) * pi() / 360)) ) * 6371);
                            	/** another method different result!! **/
                            	//$latRad = (float) deg2rad($lat);
                            	//$lngRad = (float) deg2rad($lng);
                            	//$coLatRad = (float) deg2rad($company_location->getLatitude());
                            	//$coLngRad = (float) deg2rad($company_location->getLongitude());
                            	//$distance = ACOS( SIN($latRad)*SIN($coLatRad) + COS($latRad)*COS($coLatRad)*COS($coLngRad-$lngRad) ) * 6371;
                            }
                            
                            /** TO DO 'identifier' to be removed in next version of the api(ver. > api33) **/
                            $return = array('status' => 'SUCCESS', 'indentifier' => $company->getId(), 
                            				'place' => array(
                            						'identifier' => $company->getId(),
                            						'title' => $company->getCompanyTitleByCulture(),
                            						'phone' => $company->getPhoneFormated($company->getPhone(), $culture),
                            						'address' => $company->getDisplayAddress(),
                            						'ppp' => 0,
                            						'ppp_review_id' => null,
                            						'ppp_review_text' => null,
                            						'ppp_review_picture' => null,
                            						'favourite' => 0,
                            						'rating' => $company->getAverageRating(),
                            						'reviews' => $company->getNumberOfReviews(),
                            						'lat' => $company_location->getLatitude(),
                            						'long' => $company_location->getLongitude(),
                            						'distance' => (!is_null($distance) ? $distance : 0),
                            						'icon' => 'marker_' . $company->getSectorId(),
                            						'picture_url' => image_path($company->getThumb(0, true), true),
                            						'content_url' => $this->generateUrl('default', array('module' => 'api33', 'action' => 'company', 'id' => $company->getId(), 'token' => $request->getParameter('token'), 'locale' => $culture), true),
                            						'share_url' => 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . '://www.getlokal.' . ($this->getUser()->getDomain($culture) ? $this->getUser()->getDomain($culture). '/' . $culture : 'com/en') . '/' . $company->getCity()->getSlug() . '/' . $company->getSlug(),
                            						'offers' => null,
                            						'place_type' => $company->getClassification()->getTitle(),
                            						)
                            );
                            
                        }
                        else {
                        	$i18n = sfContext::getInstance()->getI18N();
							
                            $return = array('status' => 'ERROR', 'title' => 'Getlokal', 'error' => $i18n->__("Sorry, we couldn't add your place because the service didn't return information about the town/city/village. Please enter this information manually!"), 'error_code' => null);
                        }
                    }
                    else {
                    	$i18n = sfContext::getInstance()->getI18N();
						
                        $return = array('status' => 'ERROR', 'error' => $i18n->__("Sorry, we couldn't add your place because the service didn't return information about the town/city/village. Please enter this information manually!"), 'error_code' =>null);
                    }
                }
                else {
                	$i18n = sfContext::getInstance()->getI18N();
					
                	$errors = array_merge($form->getErrorSchema()->getGlobalErrors(), $form->getErrorSchema()->getErrors());
                    $return = array('status' => 'ERROR', 'title' => 'Getlokal', 'error' => $i18n->__(is_array($errors) ? current($errors) : $errors), 'error_code' => null);
                }
            }
            else {
            	$i18n = sfContext::getInstance()->getI18N();
				
                $return = array('status' => 'ERROR', 'title' => 'Getlokal', 'error' => $i18n->__("Sorry, we couldn't add your place because the service didn't return information about the town/city/village. Please enter this information manually!"), 'error_code' => null);
            }
        /*
        }
        else {
        	$i18n = sfContext::getInstance()->getI18N();
			
            $return = array('status' => 'ERROR', 'title' => 'Getlokal', 'error' => $i18n->__('Invalid Adress.'), 'error_code' => null);
        }
        */
            
        $this->getResponse()->setContent(json_encode($return));

        return sfView::NONE;
    }

    protected function in_array_r($needle, $haystack, $strict = true) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && self::in_array_r($needle, $item, $strict))) {
                return true;
            }
        }

        return false;
    }

    public function executeLoginFb(sfWebRequest $request) {
        $profile = $user = null;
        $access_token = $request->getParameter('access_token');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/me?access_token=" . $access_token);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); # required for https urls


        $user_data = json_decode(curl_exec($ch), true);

        if (isset($user_data ['error'])) {
            $return = array('status' => 'ERROR', 'title' => 'Getlokal', 'error' => (is_array($user_data['error']['message']) ? current($user_data['error']['message']) : $user_data['error']['message']), 'error_code' => null);

            $this->getResponse()->setContent(json_encode($return));
            return sfView::NONE;
        }

        if (isset($user_data ['id']) && $user_data ['id']) {
            $profile = Doctrine::getTable('UserProfile')->findOneByFacebookUid($user_data ['id']);
        }

        if (!$profile) {
            if (isset($user_data ['email'])) {
                $user = Doctrine::getTable('sfGuardUser')->findOneByEmailAddress($user_data ['email']);
            }
            if (!$user) {
                $user_data = json_decode(curl_exec($ch), true);

                // start location


                if (isset($facebook_user_data ['location'] ['name']) && $facebook_user_data ['location'] ['name']) {
                    $location = explode(", ", $facebook_user_data ['location'] ['name']);

                    $country = array_pop($location);

                    $result = Doctrine_Query::create()->from('Country c')->where('c.name = ? OR c.name_en = ?', array($country, $country))->fetchOne();

                    if ($result && $result->getId()) {

                        $tmpCountry = $result;
                    } else {

                        $tmpCountry = $this->getUser()->getCountry();
                    }

                    if ($location) {
                        $founded = false;

                        foreach ($location as $locCity) {
                            $city = $locCity;

                           /* $result = Doctrine_Query::create()->from('City c')->innerJoin('c.County co')->where('co.country_id = ?', $tmpCountry->getId())->where('c.name = ? OR c.name_en = ?', array($city, $city))->fetchOne();*/
                            $result = Doctrine::getTable('City')
                            ->createQuery('c')
                            ->innerJoin('c.County co')
                            ->innerJoin('c.Translation ct')
                            ->where('co.country_id = ?', $tmpCountry->getId())
                            ->where('ct.name = ?', $city)->fetchOne();

                            if ($result && $result->getId()) {
                                $founded = true;
                                $tmpCity = $result;
                                break 1;
                            }
                        }

                        if (!$founded) {
                            $city = Doctrine::getTable('City')->createQuery('c')->innerJoin('c.County co')->where('co.country_id = ?', $tmpCountry->getId())->orderBy('c.is_default DESC')->limit(1)->fetchOne();

                            if ($city) {
                                $tmpCity = $city;
                            }
                        }
                    } else {
                        $city = Doctrine::getTable('City')->createQuery('c')->innerJoin('c.County co')->where('co.country_id = ?', $tmpCountry->getId())->orderBy('c.is_default DESC')->limit(1)->fetchOne();

                        if ($city) {
                            $tmpCity = $city;
                        }
                    }
                } else {

                    $con = Doctrine::getConnectionByTableName('SfGuardUser');
                    $lat = $con->quote($request->getParameter('lat'));
                    $lng = $con->quote($request->getParameter('long'));
                    $this->forward404Unless($lat || $lng);

                    $key = "AIzaSyDDZGSZsZTNuGUImUPcFXOEWObG6GX0I08";

                    $latlng = urlencode($lat . ',' . $lng);

                    $url = "http" . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . "://maps.googleapis.com/maps/api/geocode/json?latlng=" . str_replace('\'', '', $lat . ',' . $lng) . "&sensor=false&language=en";
                    sfContext::getInstance()->getLogger()->emerg('GEOCODE: 20');

                    $string = file_get_contents($url); // get json content
                    $json_a = json_decode($string, true);
                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_HEADER, 0); //Change this to a 1 to return headers
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                    $results = curl_exec($ch);
                    curl_close($ch);

                    if (isset($results [0]) && isset($json_a ['results'] [0] ['address_components'])) {

                        foreach ($json_a ['results'] [0] ['address_components'] as $key => $val) {

                            if ($val ['types'] [0] == 'locality') {
                                $j_City = $val ['long_name'];

                                $city = Doctrine::getTable('City')
                                        ->createQuery('c')
                                        ->innerJoin('c.Translation ct')
                                        ->where('ct.name LIKE ?',$j_City)
                                        ->fetchOne();
                                if ($city) {
                                    $country = $city->getCounty()->getCountry();

                                    foreach ($json_a ['results'] [0] ['address_components'] as $key1 => $val1) {
                                        if ($val1 ['types'] [0] == 'country') {
                                            $j_country = $val1 ['long_name'];

                                            $jcountry = Doctrine::getTable('Country')->createQuery('c')->where('c.name_en LIKE "%' . $j_country . '%"')->fetchOne();

                                            if ($jcountry) {
                                                if ($jcountry->getId() > 4 or $city->getCounty()->getCountryId() != $jcountry->getId()) {
                                                    $city = null;
                                                    $country = $jcountry;
                                                    break;
                                                }
                                            }

                                            break;
                                        }
                                    }
                                } else {

                                    foreach ($json_a ['results'] [0] ['address_components'] as $key2 => $val2) {
                                        if ($val2 ['types'] [0] == 'country') {
                                            $j_country1 = $val2 ['long_name'];
                                            $jcountry1 = Doctrine::getTable('Country')->createQuery('c')->where('c.name_en LIKE "%' . $j_country1 . '%"')->fetchOne();

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
                        $tmpCity = $this->getUser()->getCity();
                        $tmpCountry = $this->getUser()->getCountry();
                    } elseif ($tmpCity == null && $tmpCountry && $tmpCountry->getId() <= 4) {
                        $tmpCity = Doctrine::getTable('City')->createQuery('c')->innerJoin('c.County co')->where('co.country_id = ?', $country->getId())->orderBy('c.is_default DESC')->limit(1)->fetchOne();
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
                $country_name = (('en' == $this->getUser()->getCulture()) ? $tmpCountry->getNameEn() : (($tmpCountry->getName() != '' && $tmpCountry->getName() != '') ? $tmpCountry->getName() : $tmpCountry->getNameEn()));
                $return = array('status' => 'SUCCESS', 'first_name' => $user_data ['first_name'], 'last_name' => $user_data ['last_name'], 'email_address' => $user_data ['email'], 'location' => $tmpCity->getLocation() . ', ' . $country_name);
                $this->getResponse()->setContent(json_encode($return));
                return sfView::NONE;
            } else {
                if (!$user->getPassword()) {
                    $password = substr(md5(rand(100000, 999999)), 0, 8);
                    $user->setPassword($password);
                    $user->save();
                }

                $profile = $user->getUserProfile();
            }
        }

        if (!$profile->getFacebookUid())
            $profile->setFacebookUid($user_data ['id']);

        if (!$profile->getCountryId())
            $profile->setCountryId($this->getUser()->getCountry()->getId());

        if (!$profile->getCityId())
            $profile->setCityId($this->getUser()->getCity()->getId());

        $profile->setAccessToken($access_token);
        $profile->save();

        $login = new ApiLogin ();
        $login->setUserId($profile->getId());
        $login->setExpiresAt(date('Y-m-d H:i:s', time() + (30 * 86400)));
        $login->save();

        MobileLog::log('register', null, $login->getUserId());

        $return = array('status' => 'SUCCESS', 'token' => $login->getToken());

        $this->getResponse()->setContent(json_encode($return));
        return sfView::NONE;
    }

    public function executeGetCountriesAutocomplete(sfWebRequest $request) {
        $culture = $this->getUser()->getCulture();
        $this->getResponse()->setContentType('application/json');

        $q = "%" . $request->getParameter('term') . "%";

        $limit = $request->getParameter('limit', 20);

        // FIXME: use $limit
        $dql = Doctrine_Query::create()->from('Country c')->where('c.name LIKE ? OR c.name_en LIKE ?', array($q, $q))->limit($limit);

        $this->rows = $dql->execute();

        $countries = array();

        foreach ($this->rows as $row) {
            if ($culture == 'en') {
                $countries [] = array('id' => $row ['id'], 'value' => $row ['name_en']);
            } else {
                if ($row ['name']) {
                    $countries [] = array('id' => $row ['id'], 'value' => $row ['name']);
                } else {
                    $countries [] = array('id' => $row ['id'], 'value' => $row ['name_en']);
                }
            }
        }

        return $this->renderText(json_encode($countries));
    }

    public function executeWherelist(sfWebRequest $request) {
        $this->__checkToken($request->getParameter('token'));

        $con = Doctrine::getConnectionByTableName('search');
        $lat = $con->quote($request->getParameter('lat'));
        $lng = $con->quote($request->getParameter('long'));
        $this->forward404Unless($lat || $lng);

        $key = "AIzaSyDDZGSZsZTNuGUImUPcFXOEWObG6GX0I08";

        $address = urlencode($request->getParameter('term'));

        $url = 'https://maps.googleapis.com/maps/api/place/autocomplete/json?input=' . $address . '&types=establishment&sensor=false&radius=20000&location=' . str_replace('\'', '', $lat . ',' . $lng) . '&language=' . $this->getUser()->getCulture() . '&key=' . $key;

        $string = file_get_contents($url); // get json content
        $json_a = json_decode($string, true);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0); //Change this to a 1 to return headers
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $places = array();

        $results = curl_exec($ch);
        curl_close($ch);

        if (isset($json_a ['predictions'])) {
            foreach ($json_a ['predictions'] as $key => $val) {

                $places [$val ['description']] = $val ['description'];
            }
        }

        $this->getResponse()->setContentType('application/json');

        $this->getResponse()->setContent(json_encode($places));
        return sfView::NONE;
    }

    public function executeOfferFilters(sfWebRequest $request)
    {
        $this->__checkToken($request->getParameter('token'));
        $culture = $this->getUser()->getCulture();
        $country_id = $this->getUser()->getCountry()->getId();

        sfContext::getInstance()->getConfiguration()->loadHelpers('Asset');


        $city_id = $request->getParameter('place_id', -2);

        $query = $this->__getOffersQuery(-1, -2);

        $lat = $request->getParameter('lat');
        $lng = $request->getParameter('long');

        $this->forward404Unless($lat && $lng);

        $km_sql = "((ACOS(SIN(%s * PI() / 180) * SIN(ci.lat * PI() / 180) + COS(%s * PI() / 180) * COS(ci.lat * PI() / 180) * COS((%s - ci.lng) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as kms";
        $kms = sprintf($km_sql, $lat, $lat, $lng);
        // $query ->addSelect($km_sql)
        //
        $query->orderBy('c.country_id');

        $categories = $cities = array();

        $iCoId = null;
        foreach ($query->execute() as $o) {
            $sId = $o->getCompany()->getSector()->getId();
            $cId = $o->getCompany()->getCity()->getId();

            // country
            if ($iCoId !== $o->getCompany()->getCountry()->getId()) {
                $iCoId = $o->getCompany()->getCountry()->getId();

                $cities["c" . $iCoId] = array(
                    'identifier' => "c" . $iCoId,
                    'title' => $o->getCompany()->getCountry()->getLocation(),
                    'group' => 1,
                    'count' => 1
                );
            } else {
                $cities["c" . $iCoId]['count']++;
            }

            if (array_key_exists($cId, $cities)) {
                $cities[$cId]['count']++;
            } else {
                $cities[$cId] = array(
                    'identifier' => $cId,
                    'title' => $o->getCompany()->getCity()->getLocation(),
                    'group' => 0,
                    'count' => 1
                );
            }

            if ($city_id != -2 && $city_id != -1) {
                if (substr($city_id, 0, 1) == 'c') {
                    if (substr($city_id, 1, strlen($city_id)) != $iCoId) {
                        continue;
                    }
                } elseif ($cId != $city_id) {
                    continue;
                }
            }

            if (array_key_exists($sId, $categories)) {
                $categories[$sId]['count']++;
            } else {
                $categories[$sId] = array(
                    'identifier' => $sId,
                    'title' => $o->getCompany()->getSector()->getTitle(),
                    'count' => 1
                );
            }
        }

        // reorder based on country
        $_cities = array();
        $cId = "c" . $country_id;
        foreach ($cities as $k => $c) {
            if (empty($_cities)) {
                if ($c['group'] == 1 && $k == $cId) {
                    $_cities[$k] = $c;
                    unset($cities[$k]);
                }
            } else {
                if ($c['group'] == 1) {
                    break;
                }
                $_cities[$k] = $c;
                unset($cities[$k]);
            }
        }
        foreach ($cities as $k => $c) {
            $_cities[$k] = $c;
        }
        $cities = $_cities;

        $this->getResponse()->setContent(json_encode(array(
            'categories' => array_values($categories),
            'cities' => array_values($cities),
            'status' => 'SUCCESS',
        )));
        return sfView::NONE;
    }

    public function executeOffers(sfWebRequest $request)
    {
        $this->__checkToken($request->getParameter('token'));

        $lat = $request->getParameter('lat');
        $lng = $request->getParameter('long');

        $this->forward404Unless($lat || $lng);

        $km_sql = "((ACOS(SIN(%s * PI() / 180) * SIN(cl.latitude * PI() / 180) + COS(%s * PI() / 180) * COS(cl.latitude * PI() / 180) * COS((%s - cl.longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as kms";
        $kms = sprintf($km_sql, $lat, $lat, $lng);

        $place_id = $request->getParameter('place_id', -2);

        $query = $this->__getOffersQuery(null, $place_id);
        $query
            ->addSelect($kms)
            ->innerJoin('a.Image i')
            ->innerjoin('c.CompanyLocation cl')
            ->orderBy('kms');

        $items = array();

        foreach ($query->execute() as $o) {
            $items[] = $this->__formatOffer($o);
        }

        $this->getResponse()->setContent(json_encode(array(
            'status' => 'SUCCESS',
            'items' => $items
        )));
        return sfView::NONE;
    }

    public function executeOffer(sfWebRequest $request)
    {
        $this->__checkToken($request->getParameter('token'));
        $lat = $request->getParameter('lat');
        $lng = $request->getParameter('long');
        $this->forward404Unless($lat && $lng);

        $km_sql = "((ACOS(SIN(%s * PI() / 180) * SIN(cl.latitude * PI() / 180) + COS(%s * PI() / 180) * COS(cl.latitude * PI() / 180) * COS((%s - cl.longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as kms";
        $kms = sprintf($km_sql, $lat, $lat, $lng);

        $query = CompanyOfferTable::getInstance()->createQuery('o')
            ->leftJoin('o.Company c')
            ->leftJoin('c.CompanyLocation cl')
            ->select('o.*, c.*, cl.*')
            ->addSelect($kms)
            ->where('o.id = ?', $request->getParameter('offer_id'));
        $this->forward404Unless($query->count() > 0);

        $this->offer = $query->execute()->getFirst();
    }

    private function __formatOffer($o, $kms = null, $single_place = false)
    {
        sfContext::getInstance()->getConfiguration()->loadHelpers(array('Text'));

        $pictureUrl = null;
        if ($o->getImage()) {
            $pictureUrl = $this->__imagePath($o->getImage()->getThumb('preview', true));
        }
        $request = $this->getRequest();

        $contentUrl = $this->generateUrl('default', array(
            'module' => 'api33',
            'action' => 'offer',
        ), true) . '?' . http_build_query(array(
            'token' => $request->getParameter('token'),
            'offer_id' => $o->getId(),
            'locale' => $this->getUser()->getCulture(),
            'lat' => $request->getParameter('lat', ''),
            'long' => $request->getParameter('long', ''),
        ));
        $company = $o->getCompany();

        if (is_null($kms)) {
            $kms = isset($o->kms) && !is_null($o->kms) ? $o->kms : 0;
        }
        $culture = $this->getUser()->getCulture();
        $data = array(
            'identifier' => $o->getId(),
            'title' => $o->getDisplayTitle(),
            'description' => truncate_text(strip_tags($o->getDisplayDescription()), 256),
            'distance' => $kms,
            'category' => $o->getCompany()->getSector()->getTitle(),
            'availability' => sprintf("%s - %s",
                $o->getDateTimeObject('valid_from')->format('d/m'),
                $o->getDateTimeObject('valid_to')->format('d/m')),
            'vouchers' => $o->getMaxVouchers() - $o->getCountVoucherCodes(),
            'picture_url' => $pictureUrl,
            'content_url' => $contentUrl,
            'share_url' => 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . '://www.getlokal.' . ($this->getUser()->getDomain($culture) ? $this->getUser()->getDomain($culture). '/' . $culture : 'com/en') . '/d/offer/show/id/' . $o->getId()
        );

        $place = array(
            'identifier' => $company->getId(),
            'title' => $company->getCompanyTitleByCulture(),
            // 'ppp' => $company->getActivePPPService(true) ? 1 : 0,
            // 'favourite' => $is_favorite,
            'rating' => $company->getAverageRating(),
            'reviews' => $company->getNumberOfReviews(),
            'lat' => $company->getLocation()->getLatitude(),
            'long' => $company->getLocation()->getLongitude(),
            'distance' => $kms,
            'picture_url' => $this->__imagePath($company->getThumb(0, true)),
            'share_url' => 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . '://www.getlokal.' . ($this->getUser()->getDomain($culture) ? $this->getUser()->getDomain($culture). '/' . $culture : 'com/en') . '/' . $company->getCity()->getSlug() . '/' . $company->getSlug(),
            'content_url' => $this->generateUrl('default', array(
                'module' => 'api33',
                'action' => 'company',
            ), true) . '?' . http_build_query(array(
                'id' => $company->getId(),
                'token' => $request->getParameter('token'),
                'locale' => $this->getUser()->getCulture(),
                'lat' => $request->getParameter('lat', ''),
                'long' => $request->getParameter('long', ''),
                'random' => 'asd' # this will cancel IOS bug which adds /? after
            ))
        );

        if ($single_place) {
            $data['place'] = $place;
        } else {
            $data['places'] = array( 0 => $place);
        }

        return $data;
    }

    private function __getOffersQuery($category_id = null, $city_id = null)
    {
        if (is_null($category_id)) {
            $category_id = $this->getRequest()->getParameter('category_id', -1);
        }
        if (is_null($city_id)) {
            $city_id = $this->getRequest()->getParameter('city_id', -1);
        }

        $now = date('Y-m-d H:i:s');

        $country_id  = null;
        if ($city_id != -2 && substr($city_id, 0, 1) == 'c') {
            $country_id = substr($city_id, 1, strlen($city_id) - 1);
        }

        if ($category_id == -1) {
            $sector_id = null;
        } else {
            $sector_id = $category_id;
        }

        $culture = $this->getUser()->getCulture();

        $query = CompanyOfferTable::getOnlyActiveOffersQuery(null, $country_id, $sector_id)
            ->innerJoin('c.Sector s')
            ->innerJoin('s.Translation st')
            ->innerJoin('a.Translation at')
            ->innerJoin('c.Country co')
            ->innerJoin('c.City ci')
            ->select('a.*, c.title, c.title_en, s.id, st.title, adc.*');
            // ->andWhere('st.lang = ?', $culture)
            // ->andWhere('at.lang = ?', $culture)

            // ->orderBy('c.country_id');

        if ($city_id > 0 && !is_null($city_id)) {
            $query->andWhere('c.city_id = ?', $city_id);
        }

        if ($sector_id > 0 && !is_null($sector_id)) {
            $query->andWhere('c.sector_id = ?', $sector_id);
        }

        return $query;
    }

    private function __imagePath($url) {
        return 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . '://www.getlokal.com' . $url;
    }

    private function __getCompanyOffers($id)
    {
        $offers = array();
        sfContext::getInstance()->getConfiguration()->loadHelpers('Text');

        $query = $this->__getOffersQuery();
        $query->addWhere('a.company_id = ?', $id);
        $request = $this->getRequest();

        foreach ($query->execute() as $o) {
            $pictureUrl = null;
            if ($o->getImage()) {
                $pictureUrl = $this->__imagePath($o->getImage()->getThumb('preview', true));
            }

            $contentUrl = $this->generateUrl('default', array(
                'module' => 'api33',
                'action' => 'offer',
            ), true) . '?' . http_build_query(array(
                'token' => $request->getParameter('token'),
                'offer_id' => $o->getId(),
                'locale' => $this->getUser()->getCulture(),
                'lat' => $request->getParameter('lat', ''),
                'long' => $request->getParameter('long', '')
            ));
            $culture = $this->getUser()->getCulture();
            $offers[] = array(
                'identifier' => $o->getId(),
                'title' => $o->getDisplayTitle(),
                'description' => truncate_text(strip_tags($o->getDisplayDescription()), 256),
                'category' => $o->getCompany()->getSector()->getTitle(),
                'availability' => sprintf("%s - %s",
                    $o->getDateTimeObject('valid_from')->format('d/m'),
                    $o->getDateTimeObject('valid_to')->format('d/m')),
                'vouchers' => $o->getMaxVouchers() - $o->getCountVoucherCodes(),
                'picture_url' => $pictureUrl,
                'content_url' => $contentUrl,
                'share_url' => 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . '://www.getlokal.' . ($this->getUser()->getDomain($culture) ? $this->getUser()->getDomain($culture). '/' . $culture : 'com/en') . '/d/offer/show/id' . $o->getId()
            );
        }

        return $offers;
    }

    private function __getCompanyEvents($company) {
        $events = Doctrine::getTable('Event')
            ->createQuery('e')
            ->addSelect("e.*, t.*, c.*, ep.*, cp.*, co.*, l.*")
            ->innerJoin('e.Translation t')
            ->innerJoin('e.City c')
            ->innerJoin('e.EventPage ep')
            ->leftJoin('ep.CompanyPage cp')
            ->leftJoin('cp.Company co')
            ->leftJoin('co.CompanyLocation l')
            ->where('ep.page_id = ' . $company->getCompanyPage()->getId())
            ->addWhere('e.start_at >= ?', date('Y-m-d') . ' 00:00:00')
            ->andWhere('e.is_active = 1')
            ->orderBy('e.start_at ASC')
            ->execute();
        $items = array();
        $request = $this->getRequest();
        foreach ($events as $e) {

            $contentUrl = $this->generateUrl('default', array(
                'module' => 'api33',
                'action' => 'offer',
            ), true) . '?' . http_build_query(array(
                'token' => $request->getParameter('token'),
                'id' => $e->getId(),
                'lat' => $request->getParameter('lat', ''),
                'long' => $request->getParameter('long', '')
            ));

            $items[] = array(
                'identifier' => $e->getId(),
                'title' => $e->getDisplayTitle(),
                'description' => $e->getDisplayDescription(),
                'picture_url' => $e->getThumb(),
                'content_url' => '', # to do
                'share_url' => '' #to do
            );
        }
        return $items;
    }

    public function executeMobileList(sfWebRequest $request) {
      $this->forward404Unless($id = $request->getParameter('id'));
      $con = Doctrine::getConnectionByTableName ( 'Company' );
      $lat = $con->quote ( $request->getParameter ( 'lat', null ) );
      $lng = $con->quote ( $request->getParameter ( 'long', null ) );
      // // $this->forward404Unless($lat || $lng);
      // if ($lat && $lng) {
      //  $sql = "((ACOS(SIN(%s * PI() / 180) * SIN(l.latitude * PI() / 180) + COS(%s * PI() / 180) * COS(l.latitude * PI() / 180) * COS((%s - l.longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as kms";
      //  $kms = sprintf($sql, $lat, $lat, $lng);
      // }
      sfContext::getInstance()->getConfiguration()->loadHelpers('Asset');
    
      $this->setTemplate('mobileList');
      
      $companies = $this->return = array();
      #$this->sus_place_link  = array();
      $query = Doctrine::getTable('Company')->createQuery('c')->addSelect('c.*, i.*');

      // if (isset($kms)) {
      //  $query->addSelect($kms);
      // }

      $query->innerJoin('c.CompanyLocation l')
          ->innerJoin('c.CompanyPage p')
          ->innerJoin('p.ListPage lp')
          ->innerJoin('lp.Lists li')
          ->leftJoin('c.Image i')->where('lp.list_id= ?', $id);
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
      //$this->setTemplate ("MobileList");

      #$this->getResponse()->setContent(json_encode($return));
        #return sfView::NONE;
    }
    
    public function executeReportInvalidData(sfWebRequest $request) {
        $this->__checkToken($request->getParameter('token'));
        
        sfForm::disableCSRFProtection();
        
        $this->company = Doctrine::getTable('Company')->findOneById($request->getParameter('identifier'));
        
        if (!$this->company) {
        	$i18n = sfContext::getInstance()->getI18N();
			
            $return = array('status' => 'ERROR', 'title' => 'Getlokal', 'error' => $i18n->__('No places found'), 'error_code' => null);
            $this->getResponse()->setContent(json_encode($return));
            return sfView::NONE;
        }
        
        $companyId = $request->getParameter('identifier', NULL);
        $sendTo = 'm@getlokal.com';
        $sendFrom = $request->getParameter('sendFrom', NULL);
        $sendSubject = $request->getParameter('sendSubject', NULL);
        $urlPlace = $request->getParameter('urlPlace', NULL);
        $name = $request->getParameter('name', NULL);
        $phone = $request->getParameter('phone', NULL);
        $typePlace = $request->getParameter('typePlace', NULL);
        $streetName = $request->getParameter('streetName', NULL);
        $streetNo = $request->getParameter('streetNo', NULL);
        $lat = $request->getParameter('place_lat', NULL);
        $long = $request->getParameter('place_long', NULL);
        $isClosed = $request->getParameter('isClosed', NULL);
        $isDuplicate = $request->getParameter('isDuplicate', NULL);
        $wrongPhone = $request->getParameter('wrongPhone', NULL);
        $hasMoved = $request->getParameter('hasMoved', NULL);
        
        $data = array(
            'sendTo' => $sendTo,
            'sendFrom' => $sendFrom,
            'sendSubject' => $sendSubject,
            'urlPlace' => $urlPlace,
            'identifier' => $request->getParameter('identifier')
        );
        
        $html = array(
            'companyID' => $companyId,
            'name' => $name,
            'phone' => $phone,
            'typePlace' => $typePlace,
            'streetName' => $streetName,
            'streetNo' => $streetNo,
            'lat' => $lat,
            'long' => $long,
        	'location' => '<a href=https://www.google.bg/maps/place/'.$lat.','.$long.'/@'.$lat.','.$long.'>location on map</a>',
            'isClosed' => $isClosed,
            'isDuplicate' => $isDuplicate,
            'wrongPhone' => $wrongPhone,
            'hasMoved' => $hasMoved
        );
        
        $value = array('data' => $data, 'html' => $html);
        $valid = myTools::sendMailInvalidData($value);
        
        if ($valid) {
            $return = array('status' => 'SUCCESS');       
        }
        else {
        	$i18n = sfContext::getInstance()->getI18N();
			
			$return = array('status' => 'ERROR', 'title' => 'Getlokal', 'error' => $i18n->__('We are sorry! There was a problem sending your email. Please try again.'), 'error_code' => null); 
        }
        
        $this->getResponse()->setContent(json_encode($return));
        return sfView::NONE;
    }

    public function executeUpdateUserInfo(sfWebRequest $request) {
        $this->__checkToken($request->getParameter('token'));
        sfForm::disableCSRFProtection();

        $form = new ImageForm ();
        $form->bind(array(), $request->getFiles());

        if ($form->isValid()) {
            $image = new Image ();
            $image->setFile($form->getValue('file'));
            $image->setUserId($this->getUser()->getId());
            $image->setStatus('mobile_upload');
            $image->setType('profile');
            $image->save();

            $profile = $image->getUserProfile();
            $connect = Doctrine::getConnectionByTableName('user_profile');
            $connect->execute("UPDATE `user_profile` SET image_id=".$image->getId ()." WHERE id=".$profile->getId().";");


            $return = array('status' => 'SUCCESS', 'identifier' => $image->getId());
        } else {
        	$i18n = sfContext::getInstance()->getI18N();
			
        	$errors = $this->__getErrors($form);
            $return = array('status' => 'ERROR', 'title' => 'Getlokal', 'errors' => $i18n->__(is_array($errors) ? current($errors) : $errors), 'error_code' => null);
        }

        $this->getResponse()->setContent(json_encode($return));
        return sfView::NONE;
    }
    
    public function executeDeleteUsedInfo(sfWebRequest $request) {
        $this->__checkToken($request->getParameter('token'));
        $this->getResponse()->setContentType('application/json');
        
        $picturesId = $request->getParameter('pictures', false);
        $reviewsId = $request->getParameter('reviews', false);
        $activitiesId = $request->getParameter('activities', false);
        
        if ($picturesId) {
            
        }
        
        if ($reviewsId) {
            
        }
                
        $this->getResponse()->setContent(json_encode($return));
        return sfView::NONE;
    }
    
    /** Method is called when a company is opened */
    /** http://getlokal.com/mobile.php/api33/companyInfo?id=13142&lat=42.693594&long=23.329666&locale=bg&country=BG **/
    public function executeCompanyInfo(sfWebRequest $request) {
    	$this->__checkToken($request->getParameter('token'));
    	$company_id = $request->getParameter('id', 0);
    	sfContext::getInstance()->getConfiguration()->loadHelpers('Asset');
    	$i18n = sfContext::getInstance()->getI18N();
		
    	if ($company_id) {
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
    
    		$this->forward404Unless($company = $query->fetchOne());

    		$full = $request->getParameter('full', null);
    		$place_main_details = null;
    		$culture = $this->getUser()->getCulture();
    		$offers = null;
    		
    		/** SEARCH DEFAULT DATA / PLACE MAIN DETAILS **/
    		if ($full && $full != 0) {	    		
	    		/** title **/
	    		$place_title = $company->getCompanyTitleByCulture();
	    		
	    		/** place latitude and longitude **/
	    		$place_latitude = $company->getLocation()->getLatitude();
	    		$place_longitude = $company->getLocation()->getLongitude();
	    		
	    		/** ppp **/
	    		$ppp = $company->getActivePPPService(true) ? 1 : 0;
	    		
	    		/** phone **/
	    		$place_phone = $company->getPhoneFormated($company->getPhone(), $culture);
	    		
	    		/** address **/
	    		$place_address = $company->getDisplayAddress();
	    		
	    		/** count of place reviews **/
	    		$place_reviews_count = $company->getNumberOfReviews();
	    		
	    		/** distance **/
	    		$distance = (!is_null($company->kms) ? $company->kms : 0);
	    				
	    		/** isFavorite **/
	    		$isFavorite = Doctrine::getTable('Company')
			    		->createQuery('c')
			    		->innerJoin('c.CompanyPage p')
			    		->innerJoin('p.Follow f')
			    		->where('f.user_id = ?', $this->getUser()->getId())
			    		->andWhere('c.id = ?', $company->getId())
			    		->count();
	    		
	    		/** place average rating**/
	    		$place_rating = $company->getAverageRating();
	    		
	    		/** place type **/
	    		$place_type = $company->getClassification()->getTitle();
	    		
	    		/** picture URL **/
	    		$place_picture_url = image_path($company->getThumb(0, true), true);
	    		
	    		/** place share URL **/
	    		$place_share_url = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . '://www.getlokal.' . ($this->getUser()->getDomain($culture) ? $this->getUser()->getDomain($culture). '/' . $culture : 'com/en') . '/' . $company->getCity()->getSlug() . '/' . $company->getSlug();
	    			    		
	    		$place_main_details = array(
	    				'title' => $place_title,
	    				'lat' => $place_latitude,
	    				'long' => $place_longitude,
	    				'ppp' => $ppp,
	    				'phone' => $place_phone,
	    				'address' => $place_address,
	    				'reviews' => $place_reviews_count,
	    				'distance' => $distance,
	    				'favourite' => $isFavorite,
	    				'rating' => $place_rating,
	    				'place_type' => $place_type,
	    				'picture_url' => $place_picture_url,
	    				'share_url' => $place_share_url
	    		);

	    		/** offers **/
	    		$offers = $company->getAllOffers();
	    		
	    		if ($offers) {
	    			$offers = $this->__getCompanyOffers($company_id);
					
					for ($i = 0; $i < count($offers); $i++) {
						if ($offers[$i]['vouchers'] < 0 || $offers[$i]['vouchers'] > 99) {
							$offers[$i]['vouchers'] = 100;
						}
					}
	    		}
	    		else {
	    			$offers = null;
	    		}
    		}
    		/** END SEARCH DEFAULT DATA / PLACE MAIN DETAILS **/
    		
    		
    		/** events **/
    		if ($company->getActivePPPService(true)) {
    			$events_base = Doctrine::getTable('Event')
		    			->createQuery('e')
		    			->addSelect("e.*, t.*, c.*, ep.*, cp.*, co.*, l.*")
		    			->addSelect($kms)
		    			->innerJoin('e.Translation t')
		    			->innerJoin('e.City c')
		    			->innerJoin('e.EventPage ep')
		    			->leftJoin('ep.CompanyPage cp')
		    			->leftJoin('cp.Company co')
		    			->leftJoin('co.CompanyLocation l')
		    			->where('ep.page_id = ' . $company->getCompanyPage()->getId())
		    			->addWhere('e.end_at >= ?', date('Y-m-d') . ' 00:00:00')
		    			->andWhere('e.is_active = 1')
		    			->orderBy('e.start_at ASC')
		    			->execute();
    		}
    
    		/** reviews **/
    		$reviews_base = Doctrine::getTable('Review')
		    		->createQuery('r')
		    		->innerJoin('r.Company c WITH c.id = ?', $company->getId())
		    		->innerJoin('r.UserProfile p')
		    		->innerJoin('p.sfGuardUser sf')
		    		->leftJoin('p.Image im')
		    		->where('r.is_published = ?', Review::FRONTEND_REVIEWS_IS_PUBLISHED)
		    		->addWhere('r.parent_id IS NULL')
		    		->orderBy('r.created_at DESC')
		    		->execute();
    
    		/** if user is checked in **/
    		$is_check_in = Doctrine::getTable('CheckInStatus')
    		->createQuery('ci')
    		->where('ci.user_id = ? and ci.company_id = ?', array($this->getUser()->getId(), $company->getId()))
    		->count();
    
    		/** map image url **/
    		$location = $company->getLocation();
    		$latLng = $location->getLatitude() . ',' . $location->getLongitude();
    		$marker = image_path('gui/icons/marker_'. $company->getSectorId(), true);
    		$params = array(
    				'zoom' => '17',
    				'size' => '600x200',
    				'maptype' => 'roadmap',
    				'markers' => "icon:{$marker}%7Cshadow:false%7C{$latLng}",
    				'sensor' => 'false',
    				'key' => 'AIzaSyDLUVQz9sWCrGaFTGMGniOPG4r7wTMasEc'
    						);
    		$ps = array();
    		foreach ($params as $k => $v) {
    			$ps[] = "{$k}={$v}";
    		}
    		$params = implode('&', $ps);
    		$map_url = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . '://maps.googleapis.com/maps/api/staticmap?'.$params;
    
    		/** created by **/
    		$created_by = null;
    		if(!is_null($company->getCreatedByUser()->getId())) {
    			$created_by['image'] = image_path($company->getCreatedByUser()->getThumb(0), true);
    
    			$created_by['name'] = $company->getCreatedByUser()->getSfGuardUser()->getFirstName() . ' ' . $company->getCreatedByUser()->getSfGuardUser()->getLastName();
    			$created_by['id'] = $company->getCreatedByUser()->getId();
    		}

    		/** phone **/
    		$phone = $company->getPhoneFormated($company->getPhone(), $this->getUser()->getCulture());
    		
    		/** company details **/    		
    		$company_details = null;
    		
    		if ($company->getCompanyDetail() && $company->getCompanyDetail()->getHourFormatCPage('wed')) {
	    		foreach ($company->getCompanyDetail()->getWorkingHours() as $hour) {
	    			$company_details[] = array(
	    					//'time' => $hour['time'] == sfContext::getInstance()->getI18N()->__('Closed', null) ? null : $hour['time'],
	    					'time' => strstr($hour['time'],'-') ? $hour['time'] : null,
	    					'day' => $i18n->__($hour['day'])
	    			);
	    			
	    		}
    		}
    		
    		/** descriptin **/
    		$description = null;
    		
    		if ($company->getCompanyDescriptionByCulture($this->getUser()->getCulture())) {
    			$description = $company->getCompanyDescriptionByCulture($this->getUser()->getCulture()); 
    		}
    		
    		/** image **/
    		if ($company->getActivePPPService(true)) {
    			$image_url_ppp = image_path($company->getThumb(3), true);
    		}
    		else {
    			$image_url_ppp = image_path($company->getThumb(0), true);
    		}
    		
    		/** events **/
    		$events = null;
    		if ($company->getActivePPPService(true)) {
    			if (isset($events_base) && count($events_base)) {
    				foreach ($events_base as $e) {
    					$type = 'preview';
    					
    					if ($e->getImage()->getType() != 'poster') {
    						$type = 2;
    					}
    					
    					$event_image = image_path($e->getThumb($type), true);
    					$ticket = null;
    					
    					if ($e->getPrice()) {
    						$ticket = $e->getPriceValue();
    					}
    					else {
    						$ticket = $i18n->__("FREE");
    					}
    					
    					$creator = $e->getUserProfile()->getSfGuardUser()->getFirstName();
						$date = $e->getDateTimeObject('start_at')->format('d.m.Y');
						$distance = number_format($e->kms) . ' ' . $i18n->__('km');
    					
    					$events[] = array(
    							'id' => $e->getId(),
    							'image_url' => $event_image,
    							'title' => $e->getDisplayTitle(),
    							'ticket' => $ticket,
    							'creator' => $creator,
    							'created_at' => $date,
    							'distance' => $distance,
    							'share_url' => 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . '://www.getlokal.' . ($this->getUser()->getDomain($culture) ? $this->getUser()->getDomain($culture). '/' . $culture : 'com/en') . '/d/event/show/id/' . $e->getId(),
    							'content_url' => $this->generateUrl('default', array('module' => 'api33', 'action' => 'event', 'id' => $e->getId(), 'country' => $this->getUser()->getCountry()->getSlug(), 'locale' => $culture), true),
    					);
    				}
    			}
    		}
    		
    		/** reviews **/
    		$reviews = null;
    		
    		foreach ($reviews_base as $rev) {
    			$id = $rev->getUserId();
    			$image_url = image_path($rev->getUserProfile()->getThumb(0), true);
    			//$profile = $rev->getUserProfile();
    			$profile = $rev->getUserProfile()->getSfGuardUser()->getFirstName() . ' ' . $rev->getUserProfile()->getSfGuardUser()->getLastName();
    			$date = $rev->getDateTimeObject('created_at')->format('d.m.Y');
    			$stars = $rev->getRating();
    			$content = $rev->getText();//ESC_RAW);
    			$answers_base = $rev->getAnswers();
    			$answers = null;
    			
    			if ($answers_base) {
    				foreach ($answers_base as $a) {
    					$image_url_answer = image_path($a->getUserProfile()->getThumb(0), true);
    					$profile_answer = $a->getUserProfile();
    					$date_answer = $a->getDateTimeObject('created_at')->format('d.m.Y');
    					$content_answer = $a->getText();//ESC_RAW);
    					$answers[] = array(
    							'user_id' => $a->getUserId(),
    							'image_url' => $image_url_answer,
    							'profile' => $profile_answer->getSfGuardUser()->getFirstName() . ' ' . $profile_answer->getSfGuardUser()->getLastName(),
    							'date' => $date_answer,
    							'content' => $content_answer
    					);
    				}
    			}
    			
    			$reviews[] = array(
    					'user_id' => $id,
    					'image_url' => $image_url,
    					'profile' => $profile,
    					'date' => $date,
    					'stars' => $stars,
    					'content' => $content,
    					'answers' => $answers  				
    			);
    		}
    		
    		$return = array('status' => 'SUCCESS', 'items' =>array(
    				'main_details' => $place_main_details,
    				'offers' => $offers,
    				'image_url' => $image_url_ppp,
    				'check_in' => $is_check_in,
    				'map_url' => $map_url,
    				'phone' => $phone,
    				'company_details' => $company_details,
    				'description' => $description,
    				'created_by' => $created_by,
    				'events' => $events,
    				'reviews' => $reviews
    		));
    		;
    		MobileLog::log('company', $company->getId());
    	}
    	else {
    		$return = array('status' => 'ERROR', 'title' => 'Getlokal', 'error' => $i18n->__('Invalid or no company ID.'), 'error_code' => null);
    	}
    	 
    	$this->getResponse()->setContent(json_encode($return));
    	return sfView::NONE;
    }
    
    /*
    public function executeRegisterDevice(sfWebRequest $request) {
    	$device_token = $request->getParameter('device_token', null);
    	$device_uid = $request->getParameter('device_uid', null);
    	$user_token = $request->getParameter('user_token', null);

    	$mobile_client = $request->getParameter('mobile-client', null);
    	$user_id = 'NULL';
    	
    	if (!$device_uid) {
    		$device_uid = 'NULL';
    	}
    	
    	if ($device_token && $device_uid) {
    		if ($login = Doctrine::getTable('ApiLogin')->findOneByToken($user_token)) {
    			$user_id = $login->getUser();
    		}

    		$device_check = Doctrine::getTable('MobileDevice')->findOneByDeviceUid($device_uid);
    		
    		$device_data = new MobileDevice();
    		// DB Connection
    		$file = sfConfig::get('sf_config_dir').'/databases.yml';
    		$config = file_exists($file) ? sfYaml::load($file) : array();
    		 
    		$db = isset($config['all']['doctrine']['param']) ? $config['all']['doctrine']['param'] : array();
    		 
    		$tmp = explode (';', $db['dsn']);
    		$server = explode('=', $tmp[0]);
    		$server = $server[1];
    		$database = explode('=', $tmp[1]);
    		$database = $database[1];
    		 
    		//$connection = mysql_connect($server, $db['username'], $db['password'], $database, null, null);
    		$connection = mysql_connect($server, $db['username'], $db['password']);
    		$dbConnect = mysql_select_db($database, $connection);
    		 
    		$query = "INSERT INTO `mobile_device`(`id`, `device_os`, `user_id`, `device_uid`, `device_token`, `is_active`) VALUES (NULL,'{$mobile_client}','{$user_id}','{$device_uid}','{$device_token}','1');";
    		 
    		if (!$result = mysql_query($query)) {
    			die (mysql_error());
    		}
    		
    		$return = array('status' => 'SUCCESS');
    	}
    	else {
    		$return = array('status' => 'ERROR', 'error' => 'Missing device_token parameter.');
    	}
    	
    	
    	
    	$this->getResponse()->setContent(json_encode($return));
    	return sfView::NONE;
    }
    */
    
    public function executeRegisterDevice(sfWebRequest $request) {
    	$device_token = $request->getParameter('device_token', null);
    	$device_uid = $request->getParameter('device_uid', null);
    	$user_token = $request->getParameter('user_token', null);
    	
    	$this->__checkToken($user_token);
    	
    	$mobile_client = $request->getParameter('mobile-client', null);

    	$temp_client = explode('(', $mobile_client);
    	$device_os = $temp_client[0];
    	
    	$temp_client = explode(')', $temp_client[1]);
    	$app_version = $temp_client[0];
    	
    	$user_id = 'NULL';
    	 
    	if (!$device_uid) {
    		$device_uid = NULL;
    	}
    	 
    	if ($device_token && $device_uid && $device_os && strlen($device_os) > 2) {
    		$device_check = Doctrine::getTable('MobileDevice')->findOneByDeviceUid($device_uid);
    
    		//IF UID EXISTS AND TOKEN EXISTS (AND THEY MATCH)
    		if ($device_check && $device_check->getDeviceToken() == $device_token) {
    			$changed = false;
    			
    			if ($device_check->getLocale() != $this->getUser()->getCulture()) {
    				$device_check->setLocale($this->getUser()->getCulture());
    				$changed = true;
    			}
    			
    			if ($login = Doctrine::getTable('ApiLogin')->findOneByToken($user_token)) {
    				$user = Doctrine::getTable('UserProfile')->findOneById($login->getUserId());
    			
	    			if ($user && $device_check->getUserId() != $user->getId()) {
	    				
	    				
	    				if ($user) {
		    				$device_check->setUserId($user->getId());
		    				$device_check->setCountryId($user->getCountryId());
		    				$device_check->setCityId($user->getCityId());
		    				$changed = true;
	    				}
	    			}
    			}
    			
    			if ($device_check->getAppVersion() != $app_version) {
    				$device_check->setAppVersion($app_version);
    				$changed = true;
    			}
    			
    			if ($device_check->getDeviceOs() != $device_os) {
    				$device_check->setDeviceOs($device_os);
    				$changed = true;
    			}
    			
    			if ($device_check->getCountryGps() != $this->getUser()->getCountry()) {
    				$device_check->setCountryGps($this->getUser()->getCountry());
    				$changed = true;
    			}
    			
    			if (!$device_check->getIsActive()) {
    				$device_check->setIsActive(1);
    				$changed = true;
    			}
    			
    			if ($changed) {
    				$device_check->save();
    			}
    			
    			$return = array('status' => 'SUCCESS', 'state' => 'Existing.');
    		}
    		//IF UID EXISTS AND TOKEN NEEDS TO BE UPDATED
    		elseif ($device_check && $device_check->getDeviceToken() != $device_token) {
    			$device_check->setDeviceToken($device_token);
    			
    			if ($device_check->getLocale() != $this->getUser()->getCulture()) {
    				$device_check->setLocale($this->getUser()->getCulture());
    			}
    			
    			if ($login = Doctrine::getTable('ApiLogin')->findOneByToken($user_token)) {
    				$user = Doctrine::getTable('UserProfile')->findOneById($login->getUserId());
    			
	    			if ($device_check->getUserId() != $user->getId()) {
	    				if ($user) {
		    				$device_check->setUserId($user->getId());
		    				$device_check->setCountryId($user->getCountryId());
		    				$device_check->setCityId($user->getCityId());
		    				$changed = true;
	    				}
	    			}
    			}
    			
    			if ($device_check->getAppVersion() != $app_version) {
    				$device_check->setAppVersion($app_version);
    			}
    			
    			if ($device_check->getDeviceOs() != $device_os) {
    				$device_check->setDeviceOs($device_os);
    			}
    			
    			if ($device_check->getCountryGps() != $this->getUser()->getCountry()) {
    				$device_check->setCountryGps($this->getUser()->getCountry());
    			}
    			
    			if (!$device_check->getIsActive()) {
    				$device_check->setIsActive(1);
    			}
    			 
    			$device_check->save();
    			
    			$return = array('status' => 'SUCCESS', 'state' => 'Token changed');
    		}
    		//NEW RECORD IS BEING CREATED
    		else {
    			$device_check = Doctrine::getTable('MobileDevice')->findOneByDeviceToken($device_token);
    			$login = Doctrine::getTable('ApiLogin')->findOneByToken($user_token);
    			
    			//to be removed
    			if ($device_check) {
    				$dc_user = $device_check->getUserId();
    			}
    			//end to be removed
    			
    			$userId = $login->getUserId();
    			if ($device_check && $login && $device_check->getUserId() == $login->getUserId()) {
    				$user = Doctrine::getTable('UserProfile')->findOneById($login->getUserId());
    				
    				$device_check->setDeviceUid($device_uid);
    				 
    				if ($device_check->getLocale() != $this->getUser()->getCulture()) {
    					$device_check->setLocale($this->getUser()->getCulture());
    				}
    				 
    				if ($login = Doctrine::getTable('ApiLogin')->findOneByToken($user_token)) {
    					$user = Doctrine::getTable('UserProfile')->findOneById($login->getUserId());
    					 
    					if ($device_check->getUserId() != $user->getId()) {
    						if ($user) {
    							$device_check->setUserId($user->getId());
    							$device_check->setCountryId($user->getCountryId());
    							$device_check->setCityId($user->getCityId());
    							$changed = true;
    						}
    					}
    				}
    				 
    				if ($device_check->getAppVersion() != $app_version) {
    					$device_check->setAppVersion($app_version);
    				}
    				 
    				if ($device_check->getDeviceOs() != $device_os) {
    					$device_check->setDeviceOs($device_os);
    				}
    				 
    				if ($device_check->getCountryGps() != $this->getUser()->getCountry()) {
    					$device_check->setCountryGps($this->getUser()->getCountry());
    				}
    				 
    				if (!$device_check->getIsActive()) {
    					$device_check->setIsActive(1);
    				}
    				
    				$device_check->save();
    				
    				$return = array('status' => 'SUCCESS', 'state' => 'Existing token. Updated');
    				
    			}
    			else {
    				$device_check_token = Doctrine::getTable('MobileDevice')
	    				->createQuery('md')
	    				->where('md.device_token LIKE ?', $device_token)
	    				->andWhere('md.is_active != ? ', 0)
	    				->execute();
    				
	    			foreach ($device_check_token as $dct) {
		    			if ($dct && $dct->getDeviceUid() != $device_uid) {
			    			if ($dct->getIsActive()) {
			    				$dct->setIsActive(0);
			    				$dct->save();
			    			}
		    			}
	    			}
	    			
	    			if ($login = Doctrine::getTable('ApiLogin')->findOneByToken($user_token)) {
	    				$user = Doctrine::getTable('UserProfile')->findOneById($login->getUserId());
	    			}
	    			 
	    			$device_data = new MobileDevice();
	    			 
	    			$device_data->setUserId($user->getId());
	    			$device_data->setCountryId($user->getCountryId());
	    			$device_data->setCityId($user->getCityId());
	    
	    			$device_data->setCountryGps($this->getUser()->getCountry());
	    			$device_data->setLocale($this->getUser()->getCulture());
	    			$device_data->setCountFailed(0);
	    			 
	    			$device_data->setDeviceUid($device_uid);
	    			$device_data->setDeviceToken($device_token);
	    			$device_data->setDeviceOs($device_os);
	    			$device_data->setAppVersion($app_version);
	    			 
	    			$device_data->setIsActive(1);
	    			$device_data->save();
	    
	    			$return = array('status' => 'SUCCESS', 'state' => 'New device data.');
    			}
    		}
    	}
    	else {
    		$i18n = sfContext::getInstance()->getI18N();
			
    		$return = array('status' => 'ERROR', 'title' => 'Getlokal', 'error' => $i18n->__("We couldn’t access the necessary information from your device and you will not be able to receive notifiications from Getlokal. This might be resolved if you reinstall the Getlokal app."), 'error_code' => null);
    	}
    	 
    	$this->getResponse()->setContent(json_encode($return));
    	return sfView::NONE;
    }
    
}
