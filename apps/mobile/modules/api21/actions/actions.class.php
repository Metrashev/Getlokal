<?php

//http://itouchmap.com/latlong.html
//http://universimmedia.pagesperso-orange.fr/geo/loc.htm
//http://www.gorissen.info/Pierre/maps/googleMapLocation.php

class api21Actions extends sfActions {
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

        if (!$token || !$login = Doctrine::getTable('ApiLogin')->findOneByToken($token)) {
            $return = array('status' => 'ERROR', 'error' => 'Invalid user token or token expired', 'error_code' => 3);
        }

        if (!$return && $login->getDateTimeObject('expires_at')->format('U') < time()) {
            $return = array('status' => 'ERROR', 'error' => 'Invalid user token or token expired', 'error_code' => 3);
        }

        if ($return) {
            $this->getResponse()->setContent(json_encode($return));
            $this->setTemplate('false');

            $this->forward('api21', 'stop');
        } else {
            $this->getUser()->setAttribute('user_id', $login->getUserId(), 'sfGuardSecurityUser');
            $this->getUser()->setAttribute('currency', $login->getSfGuardUser()->getUserProfile()->getCity()->getCounty()->getCountry()->getCurrency(), 'sfGuardSecurityUser');
        }

        return true;
    }

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

    public function executeStop() {
        return sfView::NONE;
    }

    public function forward404Unless($condition, $message = null) {
        if (!$condition) {
            $return = array('status' => 'ERROR', 'error' => 'No items found', 'error_code' => 4);

            $this->getResponse()->setContent(json_encode($return));
            $this->forward('api21', 'stop');
        }
    }

    private function __debug($msg = '') {
        return $this->renderText(json_encode(array('status' => 'ERROR', 'error' => $msg, 'error_code' => 99)));
    }

    // ex. http://www.getlokal.com/mobile_dev.php/api21/company?token=eea05e007a12c7b8dee730ab4de98eb2&id=14360&locale=bg
    // http://www.getlokal.com/mobile_dev.php/api21/company?token=eea05e007a12c7b8dee730ab4de98eb2&id=14360&locale=bg&lat=42.681173&long=23.310819
    // http://www.getlokal.com/mobile_dev.php/api21/company?token=eea05e007a12c7b8dee730ab4de98eb2&id=220711&locale=mk&lat=42.681173&long=23.310819
    public function executeCompany(sfWebRequest $request) {
        $this->__checkToken($request->getParameter('token'));

        $con = Doctrine::getConnectionByTableName('Company');
        $lat = $con->quote($request->getParameter('lat'));
        $lng = $con->quote($request->getParameter('long'));


        //return $this->__debug($this->getUser()->getCulture()); exit;

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

    // ex. http://getlokal.com/mobile_dev.php/api21/page/slug/terms-of-use/locale/en
    public function executePage(sfWebRequest $request) {
        $slug = $request->getParameter('slug', null);

        $culture = $this->getUser()->getCulture();

        $this->page = Doctrine::getTable('StaticPage')
                ->createQuery('sp')
                ->innerJoin('sp.Translation spt')
                ->where('spt.slug = ? AND spt.is_active = ? AND spt.lang = ?', array($slug, 1, $culture))
                ->fetchOne();

        $this->forward404Unless($this->page);
    }

    // ex. http://www.getlokal.com/mobile_dev.php/api21/event?token=eea05e007a12c7b8dee730ab4de98eb2&id=8285&locale=bg
    // http://www.getlokal.com/mobile_dev.php/api21/event?token=eea05e007a12c7b8dee730ab4de98eb2&id=8256&locale=bg&lat=42.681173&long=23.310819
    // URL FROM SLIDER TO EVENT https://www.devlokal.com/mobile.php/api21/event/id/2027
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
            //http://www.getlokal.com/mobile_dev.php/api21/company?token=eea05e007a12c7b8dee730ab4de98eb2&id=14360&locale=bg&lat=42.681173&long=23.310819
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

            $return[] = array('identifier' => $company->getId(), 'title' => $company->getCompanyTitleByCulture(null, null, true), 'phone' => $company->getPhoneFormated($company->getPhone(), $this->getUser()->getCulture()), 'address' => $company->getDisplayAddress(), 'ppp' => $company->getActivePPPService(true) ? 1 : 0, 'favourite' => $is_favorite, 'rating' => $company->getAverageRating(), 'reviews' => $company->getNumberOfReviews(), 'lat' => $company->getLocation()->getLatitude(), 'long' => $company->getLocation()->getLongitude(), 'distance' => (!is_null($company->kms) ? $company->kms : 0), 'icon' => 'marker_' . $company->getSectorId(), 'picture_url' => image_path($company->getThumb(0, true), true), 'share_url' => 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . '://www.getlokal.' . $this->getUser()->getDomain() . '/' . $this->getUser()->getCulture() . '/' . $company->getCity()->getSlug() . '/' . $company->getSlug(), 'content_url' => $this->generateUrl('default', array('module' => 'api21', 'action' => 'company', 'id' => $company->getId(), 'token' => $request->getParameter('token'), 'locale' => $this->getUser()->getCulture()), true));
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
                //->limit(15)
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

        for ($i = $start; $i <= $end; $i++) {
            if (isset($possitions[$i])) {
                foreach ($possitions [$i] as $news_item) {
                    if ($news_item)
                        $returnItems[] = array('identifier' => $news_item->getId(), 'type' => 2, 'internal' => 1, 'title' => $news_item->getTitle(), 'details1' => $news_item->getLine1(), 'details2' => $news_item->getLine2(), 'detauls3' => '', 'picture_url' => image_path($news_item->getThumb(1), true), 'big_picture_url' => image_path($news_item->getThumb(), true), 'content_url' => $news_item->getLink());
                }
            }

            if (isset($events[$i])) { //foreach($events as $event)
                $event = $events[$i];

                if ($event->getDateTimeObject('start_at')->format('Y-m-d') == date('Y-m-d')) {
                    $date = $i18n->__('Today') . ' ';
                } elseif ($event->getDateTimeObject('start_at')->sub(new DateInterval('P1D'))->format('Y-m-d') == date('Y-m-d')) {
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

                        $places[] = array(
                            'identifier' => $company->getId(),
                            'title' => $company->getCompanyTitleByCulture(null, null, true),
                            'ppp' => ($company->getActivePPPService(true) ? 1 : 0),
                            'favourite' => $is_favorite = Doctrine::getTable('Company')->createQuery('c')->innerJoin('c.CompanyPage p')->innerJoin('p.Follow f')->where('f.user_id = ?', $this->getUser()->getId())->andWhere('c.id = ?', $company->getId())->count(),
                            'rating' => $company->getAverageRating(),
                            'reviews' => $company->getNumberOfReviews(),
                            'picture_url' => image_path($company->getThumb(0, true), true),
                            'share_url' => 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . '://www.getlokal.' . $this->getUser()->getDomain() . '/' . $this->getUser()->getCulture() . '/' . $company->getCity()->getSlug() . '/' . $company->getSlug(),
                            'content_url' => $this->generateUrl('default', array('module' => 'api21', 'action' => 'company', 'id' => $company->getId(), 'token' => $request->getParameter('token'), 'locale' => $this->getUser()->getCulture()), true)
                        );
                    }
                }

                $returnItems[] = array(
                    'identifier' => $event->getId(),
                    'type' => 1,
                    'internal' => 0,
                    'title' => $event->getTitle(),
                    'share_url' => 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . '://www.getlokal.' . $this->getUser()->getDomain() . '/' . $this->getUser()->getCulture() . '/d/event/show/id/' . $event->getId(),
                    'details1' => $date,
                    'details2' => $event->getPrice() ? $i18n->__('Ticket: ') . $event->getPriceValue() : '',
                    'details3' => $event->getFirstCompany() ? $event->getFirstCompany()->getTitle() . ' (' . number_format($event->distance, 2) . ' km)' : '',
                    'category' => $event->getCategory(),
                    'picture_url' => image_path($event->getThumb(), true),
                    'big_picture_url' => image_path($event->getThumb(0), true),
                    'content_url' => $this->generateUrl('default', array('module' => 'api21', 'action' => 'event', 'id' => $event->getId(), 'country' => $this->getUser()->getCountry()->getSlug(), 'locale' => $this->getUser()->getCulture()), true),
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

        $results = array_merge($classifications, $sectors);

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
                ', ' . $row->getCounty()->getCountyNameByCulture($culture) .
                ', ' . $row->getCounty()->getCountry()->getCountryNameByCulture($culture);
            $cities[] = array('id' => $row['id'], 'value' => $value);

        }

        return $this->renderText(json_encode($cities));
    }

    // Search everywhere (cities, countries)
    //http://www.getlokal.com/mobile_dev.php/api21/getLocationAutocomplete?term=%D0%A1%D0%BE%D1%84%D0%B8%D1%8F
    public function executeGetLocationAutocomplete(sfWebRequest $request) {
        //$this->__checkToken($request->getParameter('token'));

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
                $result[] = array('identifier' => $country->getId(), 'title' => mb_convert_case(call_user_func(array('Transliterate' . $partner_class, 'toLatin'), ($country->getName() ? $country->getName() : $country->getNameEn())), MB_CASE_TITLE, 'UTF-8'), 'country' => 1);
            } else {
                $result[] = array('identifier' => $country->getId(), 'title' => mb_convert_case(($country->getName() ? $country->getName() : $country->getNameEn()), MB_CASE_TITLE, 'UTF-8'), 'country' => 1);
            }
        }

        $return = array('status' => 'ok', 'items' => $result);
        return $this->renderText(json_encode($return));
    }

    private function __countResultFromSphinx($con, $sql) {
        // Do count - DOESN`T WORK
        //$result = mysqli_query($con, $sql) or die(mysqli_error($con));
        //$countResult = count(mysqli_fetch_array($result));

        // Sphinx count https://groups.google.com/forum/?fromgroups#!topic/thinking-sphinx/tWvIeojViSE
        // http://pat.github.io/thinking-sphinx/advanced_config.html
        $cntSql = $sql . " LIMIT 0, 2000";
        $result = mysqli_query($con, $cntSql) or die(mysqli_error($con));
        $countResult = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $countResult++;
            //echo $row['id'], ' - ' . $countResult . '<br />';
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
                ->where('c.name LIKE ? OR c.name_en LIKE ?', array($cityString, $cityString))
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
            sfContext::getInstance()->getLogger()->emerg('GEOCODE: 12');

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
                                    ->where('c.name LIKE ? OR c.name_en LIKE ?', array($j_city, $j_city))
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

    private function __searchByCS($request, $lat, $lng, $startIndex = 0, $endIndex = 14, $cs = null, $csType = 0) {
        $con = mysqli_connect(sfConfig::get('app_search_host'), null, null, null, sfConfig::get('app_search_port'));
        mysqli_query($con, "SET NAMES utf8");

        sfContext::getInstance()->getConfiguration()->loadHelpers('Asset');

        // Convert deg. to rad.
        $latRad = (float) deg2rad($lat);
        $lngRad = (float) deg2rad($lng);

        $items = array();
        $countResult = 0;
        $sqlPart1 = "";

        // Classifications
        if ($cs && $csType == 1) {
            if (!in_array($cs, $this->visibleClassifications)) {
                $cs = null;
                $csType = null;
            }
            else {
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
                $sqlPart1 = "AND sector_id = " . $cs . " ";
            }
        }

        $sql = "SELECT id, geodist({$latRad}, {$lngRad} , lat_rad, lng_rad) as distance,
                    IF (distance <= 30.00, 1,
                    IF (distance <= 50.00, 2,
                    IF (distance <= 100.00, 3,
                    IF (distance <= 150.00, 4,
                    IF (distance <= 200.00, 5,
                    IF (distance <= 300.00, 6,
                    IF (distance <= 400.00, 7,
                    IF (distance <= 600.00, 8,
                    IF (distance <= 800.00, 9,
                    IF (distance <= 1000.00, 10,
                    IF (distance <= 1300.00, 11,
                    IF (distance <= 1600.00, 12,
                    IF (distance <= 2000.00, 13,
                    IF (distance <= 2500.00, 14,
                    IF (distance <= 3000.00, 15,
                    IF (distance <= 4000.00, 16,
                    IF (distance <= 5000.00, 17,
                    IF (distance <= 7000.00, 18,
                    IF (distance <= 9000.00, 19,
                    IF (distance <= 12000.00, 20,
                    IF (distance <= 16000.00, 21,
                    IF (distance <= 21000.00, 22,
                    IF (distance <= 27000.00, 23,
                    IF (distance <= 30000.00, 24,
                    25)))))))))))))))))))))))) as proximity_reg,
                    score as total_score

                FROM search
                WHERE proximity_reg <= 24 " . $sqlPart1 . "
                ORDER BY proximity_reg ASC, distance ASC, score DESC ";

        $countResult = $this->__countResultFromSphinx($con, $sql);

        // Limit results
        $sql .= "LIMIT {$startIndex}, {$endIndex}";
        $result = mysqli_query($con, $sql) or die(mysqli_error($con));

        $companiyIds = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $companiyIds[] = $row['id'];
            //echo $row['id'], ' - ', $row['distance'], ' <br /> ';
        }

        if (count($companiyIds)) {
            // Get companies
            $kmsSql = "((ACOS(SIN(%s * PI() / 180) * SIN(l.latitude * PI() / 180) + COS(%s * PI() / 180) * COS(l.latitude * PI() / 180) * COS((%s - l.longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as kms";
            $kms = sprintf($kmsSql, $lat, $lat, $lng);

            $companies = Doctrine::getTable('Company')
                ->createQuery('c')
                ->innerJoin('c.Location l')
                ->innerJoin('c.Sector s')
                ->innerjoin('s.Translation st WITH st.lang = ?', $this->getUser()->getCulture())
                ->innerJoin('c.Classification ca')
                ->innerJoin('ca.Translation cat WITH cat.lang = ?', $this->getUser()->getCulture())

                // Add kilometers
                ->addSelect("c.id, c.*, s.*, st.*, ca.*, cat.*, l.*")
                ->addSelect($kms)
                ->whereIN('c.id', $companiyIds)
                ->orderBy('FIELD(c.id,' . implode(',', $companiyIds) . ')')
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
                    'title' => $company->getCompanyTitleByCulture(null, null, true),
                    'phone' => $company->getPhoneFormated($company->getPhone(), $this->getUser()->getCulture()),
                    'address' => $company->getDisplayAddress(),
                    'ppp' => $ppp,
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
                    'content_url' => $this->generateUrl('default', array('module' => 'api21', 'action' => 'company', 'id' => $company->getId(), 'token' => $request->getParameter('token'), 'locale' => $this->getUser()->getCulture()), true),
                    'share_url' => 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . '://www.getlokal.' . $this->getUser()->getDomain() . '/' . $this->getUser()->getCulture() . '/' . $company->getCity()->getSlug() . '/' . $company->getSlug(),
                );

                // Debug
                //$ttl[] = $company->getCompanyTitleByCulture(null, null, true) . ' - ' . $company->kms . ' - ' . $company->score . ' - ' . $company->getSectorId();
            }

            // Debug
            if (isset($ttl) && count($ttl)) {
                file_put_contents('tst.txt', implode("\n", $ttl));
            }
        }

        return array('item_count' => $countResult, 'items' => $items);
    }

    private function __searchBlank($request, $lat, $lng, $startIndex = 0, $endIndex = 14) {
        $con = mysqli_connect(sfConfig::get('app_search_host'), null, null, null, sfConfig::get('app_search_port'));
        mysqli_query($con, "SET NAMES utf8");

        sfContext::getInstance()->getConfiguration()->loadHelpers('Asset');

        // Convert deg. to rad.
        $latRad = (float) deg2rad($lat);
        $lngRad = (float) deg2rad($lng);

        $items = array();
        $countResult = 0;

        $sql = "SELECT id, geodist({$latRad}, {$lngRad} , lat_rad, lng_rad) as distance,
                    IF (distance <= 30.00, 1,
                    IF (distance <= 50.00, 2,
                    IF (distance <= 100.00, 3,
                    IF (distance <= 150.00, 4,
                    IF (distance <= 200.00, 5,
                    IF (distance <= 300.00, 6,
                    IF (distance <= 400.00, 7,
                    IF (distance <= 600.00, 8,
                    IF (distance <= 800.00, 9,
                    IF (distance <= 1000.00, 10,
                    IF (distance <= 1300.00, 11,
                    IF (distance <= 1600.00, 12,
                    IF (distance <= 2000.00, 13,
                    IF (distance <= 2500.00, 14,
                    IF (distance <= 3000.00, 15,
                    IF (distance <= 4000.00, 16,
                    IF (distance <= 5000.00, 17,
                    IF (distance <= 7000.00, 18,
                    IF (distance <= 9000.00, 19,
                    IF (distance <= 12000.00, 20,
                    IF (distance <= 16000.00, 21,
                    IF (distance <= 21000.00, 22,
                    IF (distance <= 27000.00, 23,
                    IF (distance <= 30000.00, 24,
                    25)))))))))))))))))))))))) as proximity_reg,
                    score as total_score

                FROM search
                WHERE proximity_reg <= 24 AND sector_id IN (" . implode(',', $this->visibleSectors) . ")
                ORDER BY proximity_reg ASC, distance ASC, score DESC ";

        $countResult = $this->__countResultFromSphinx($con, $sql);

        // Limit results
        $sql .= "LIMIT {$startIndex}, {$endIndex}";
        $result = mysqli_query($con, $sql) or die(mysqli_error($con));

        $companiyIds = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $companiyIds[] = $row['id'];
            //echo $row['id'], ' - ', $row['distance'], ' <br /> ';
        }

        if (count($companiyIds)) {
            // Get companies
            $kmsSql = "((ACOS(SIN(%s * PI() / 180) * SIN(l.latitude * PI() / 180) + COS(%s * PI() / 180) * COS(l.latitude * PI() / 180) * COS((%s - l.longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as kms";
            $kms = sprintf($kmsSql, $lat, $lat, $lng);

            $companies = Doctrine::getTable('Company')
                ->createQuery('c')
                ->innerJoin('c.Location l')
                ->innerJoin('c.Sector s')
                ->innerjoin('s.Translation st WITH st.lang = ?', $this->getUser()->getCulture())
                ->innerJoin('c.Classification ca')
                ->innerJoin('ca.Translation cat WITH cat.lang = ?', $this->getUser()->getCulture())

                // Add kilometers
                ->addSelect("c.id, c.*, s.*, st.*, ca.*, cat.*, l.*")
                ->addSelect($kms)
                ->whereIN('c.id', $companiyIds)
                ->orderBy('FIELD(c.id,' . implode(',', $companiyIds) . ')')
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
                    'title' => $company->getCompanyTitleByCulture(null, null, true),
                    'phone' => $company->getPhoneFormated($company->getPhone(), $this->getUser()->getCulture()),
                    'address' => $company->getDisplayAddress(),
                    'ppp' => $ppp,
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
                    'content_url' => $this->generateUrl('default', array('module' => 'api21', 'action' => 'company', 'id' => $company->getId(), 'token' => $request->getParameter('token'), 'locale' => $this->getUser()->getCulture()), true),
                    'share_url' => 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . '://www.getlokal.' . $this->getUser()->getDomain() . '/' . $this->getUser()->getCulture() . '/' . $company->getCity()->getSlug() . '/' . $company->getSlug(),
                );

                // Debug
                //$ttl[] = $company->getCompanyTitleByCulture(null, null, true) . ' - ' . $company->kms . ' - ' . $company->score . ' - ' . $company->getSectorId();
            }

            // Debug
            if (isset($ttl) && count($ttl)) {
                file_put_contents('tst.txt', implode("\n", $ttl));
            }
        }

        return array('item_count' => $countResult, 'items' => $items);
    }

    private function __searchRecommended($request, $lat, $lng, $startIndex, $endIndex) {
        $con = mysqli_connect(sfConfig::get('app_search_host'), null, null, null, sfConfig::get('app_search_port'));
        mysqli_query($con, "SET NAMES utf8");

        sfContext::getInstance()->getConfiguration()->loadHelpers('Asset');

        // Convert deg. to rad.
        $latRad = (float) deg2rad($lat);
        $lngRad = (float) deg2rad($lng);

        $items = array();
        $countResult = 0;

        $sql = "SELECT id, geodist({$latRad}, {$lngRad} , lat_rad, lng_rad) as distance,
                    IF (distance <= 30.00, 1,
                    IF (distance <= 50.00, 2,
                    IF (distance <= 100.00, 3,
                    IF (distance <= 150.00, 4,
                    IF (distance <= 200.00, 5,
                    IF (distance <= 300.00, 6,
                    IF (distance <= 400.00, 7,
                    IF (distance <= 600.00, 8,
                    IF (distance <= 800.00, 9,
                    IF (distance <= 1000.00, 10,
                    IF (distance <= 1300.00, 11,
                    IF (distance <= 1600.00, 12,
                    IF (distance <= 2000.00, 13,
                    IF (distance <= 2500.00, 14,
                    IF (distance <= 3000.00, 15,
                    IF (distance <= 4000.00, 16,
                    IF (distance <= 5000.00, 17,
                    IF (distance <= 7000.00, 18,
                    IF (distance <= 9000.00, 19,
                    IF (distance <= 12000.00, 20,
                    IF (distance <= 16000.00, 21,
                    IF (distance <= 21000.00, 22,
                    IF (distance <= 27000.00, 23,
                    IF (distance <= 30000.00, 24,
                    25)))))))))))))))))))))))) as proximity_reg,
                    score as total_score

                FROM search
                WHERE proximity_reg <= 24 AND is_ppp = 1
                ORDER BY proximity_reg ASC, distance ASC ";

        $countResult = $this->__countResultFromSphinx($con, $sql);

        // Limit results
        $sql .= "LIMIT {$startIndex}, {$endIndex}";
        $result = mysqli_query($con, $sql) or die(mysqli_error($con));

        $companiyIds = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $companiyIds[] = $row['id'];
            //echo $row['id'], ' - ', $row['distance'], ' <br /> ';
        }

        if (count($companiyIds)) {
            // Get companies
            $kmsSql = "((ACOS(SIN(%s * PI() / 180) * SIN(l.latitude * PI() / 180) + COS(%s * PI() / 180) * COS(l.latitude * PI() / 180) * COS((%s - l.longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as kms";
            $kms = sprintf($kmsSql, $lat, $lat, $lng);

            $companies = Doctrine::getTable('Company')
                ->createQuery('c')
                ->innerJoin('c.Location l')
                ->innerJoin('c.Sector s')
                ->innerjoin('s.Translation st WITH st.lang = ?', $this->getUser()->getCulture())
                ->innerJoin('c.Classification ca')
                ->innerJoin('ca.Translation cat WITH cat.lang = ?', $this->getUser()->getCulture())

                // Add kilometers
                ->addSelect("c.id, c.*, s.*, st.*, ca.*, cat.*, l.*")
                ->addSelect($kms)
                ->whereIN('c.id', $companiyIds)
                ->orderBy('FIELD(c.id,' . implode(',', $companiyIds) . ')')
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
                    'title' => $company->getCompanyTitleByCulture(null, null, true),
                    'phone' => $company->getPhoneFormated($company->getPhone(), $this->getUser()->getCulture()),
                    'address' => $company->getDisplayAddress(),
                    'ppp' => $ppp,
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
                    'content_url' => $this->generateUrl('default', array('module' => 'api21', 'action' => 'company', 'id' => $company->getId(), 'token' => $request->getParameter('token'), 'locale' => $this->getUser()->getCulture()), true),
                    'share_url' => 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . '://www.getlokal.' . $this->getUser()->getDomain() . '/' . $this->getUser()->getCulture() . '/' . $company->getCity()->getSlug() . '/' . $company->getSlug(),
                );

                // Debug
                //$ttl[] = $company->getCompanyTitleByCulture(null, null, true) . ' - ' . $company->kms . ' - ' . $company->score . ' - ' . $company->getSectorId();
            }

            // Debug
            if (isset($ttl) && count($ttl)) {
                file_put_contents('tst.txt', implode("\n", $ttl));
            }
        }

        return array('item_count' => $countResult, 'items' => $items);
    }

    private function __searchByKeyword($request, $lat, $lng, $startIndex, $endIndex, $keyword) {
        $con = mysqli_connect(sfConfig::get('app_search_host'), null, null, null, sfConfig::get('app_search_port'));
        mysqli_query($con, "SET NAMES utf8");

        sfContext::getInstance()->getConfiguration()->loadHelpers('Asset');

        // Convert deg. to rad.
        $latRad = (float) deg2rad($lat);
        $lngRad = (float) deg2rad($lng);

        $items = array();
        $countResult = 0;

        // keywords
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

        // Explode words
        /*
        $pattern = array(';', '.', ',', ':', '!', '?', ' - ', ' ', '\'', '"', '”', '“', '(', ')', '-');
        $keywordsArray = explode('|', str_replace($pattern, '|', $keyword));
        */

        //http://sphinxsearch.com/docs/current.html#weighting
        $sql = "SELECT id, active_order, geodist({$latRad}, {$lngRad} , lat_rad, lng_rad) as distance,
                    IF (distance <= 30.00, 1,
                    IF (distance <= 50.00, 2,
                    IF (distance <= 100.00, 3,
                    IF (distance <= 150.00, 4,
                    IF (distance <= 200.00, 5,
                    IF (distance <= 300.00, 6,
                    IF (distance <= 400.00, 7,
                    IF (distance <= 600.00, 8,
                    IF (distance <= 800.00, 9,
                    IF (distance <= 1000.00, 10,
                    IF (distance <= 1300.00, 11,
                    IF (distance <= 1600.00, 12,
                    IF (distance <= 2000.00, 13,
                    IF (distance <= 2500.00, 14,
                    IF (distance <= 3000.00, 15,
                    IF (distance <= 4000.00, 16,
                    IF (distance <= 5000.00, 17,
                    IF (distance <= 7000.00, 18,
                    IF (distance <= 9000.00, 19,
                    IF (distance <= 12000.00, 20,
                    IF (distance <= 16000.00, 21,
                    IF (distance <= 21000.00, 22,
                    IF (distance <= 27000.00, 23,
                    IF (distance <= 30000.00, 24,
                    25)))))))))))))))))))))))) as proximity_reg,
                    score as total_score, star_rating

                FROM search
                WHERE /*proximity_reg <= 24 AND */
                    MATCH('
                        @(title,description,detail_description,review,classification,extra_classification,video,image) {$cleanPhrase}
                    ')

                ORDER BY proximity_reg ASC, distance ASC
                LIMIT 0, 1000
                /*OPTION max_matches=3000*/
                /*OPTION index_weights=(title=1), ranker=expr('sum(user_weight)')*/";

        $result = mysqli_query($con, $sql) or die(mysqli_error($con));

        $companies = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $companies[$row['id']] = array('distance' => (!is_null($row['distance']) ? $row['distance'] : 0), 'proximity_reg' => $row['proximity_reg'], 'star_rating' => $row['star_rating'], 'ppp' => (int)(bool)$row['active_order'], 'rank' => 0);
        }

        $countResult = count($companies);

        // ! USE SPHINX IF IT IS POSSIBLE !
        if ($countResult) {
            $implodedCompanyIds = implode(',', array_keys($companies));

            $con = Doctrine::getConnectionByTableName('company');

            // =================================================================================================================================== //

            $query = "SELECT id FROM company WHERE id IN ({$implodedCompanyIds}) AND LOWER(CONCAT(title, ' ', title_en)) LIKE '%{$cleanPhrase}%'
                        GROUP BY id";
            $result = $con->execute($query);

            while ($row = $result->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
                $companies[$row['id']]['rank'] += 1;
                $test[$row['id']]['title'] = 1;
            }

            // =================================================================================================================================== //

            $query = "SELECT id FROM company WHERE id IN ({$implodedCompanyIds}) AND LOWER(CONCAT(description, ' ', description_en)) LIKE '%{$cleanPhrase}%'
                        GROUP BY id";
            $result = $con->execute($query);

            while ($row = $result->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
                $companies[$row['id']]['rank'] += 0.5;
                $test[$row['id']]['description'] = 0.5;
            }

            // =================================================================================================================================== //

            $query = "SELECT COUNT(id) * 0.05 AS rank, company_id FROM `review` WHERE company_id IN ({$implodedCompanyIds}) AND is_published = 1 AND parent_id IS NULL AND text LIKE '%{$cleanPhrase}%' GROUP BY company_id";
            $result = $con->execute($query);

            while ($row = $result->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
                $companies[$row['company_id']]['rank'] += $row['rank'];
                $test[$row['company_id']]['review'] = $row['rank'];
            }

            // =================================================================================================================================== //

            $query = "SELECT COUNT(img.id) * 0.1 AS rank, ci.company_id FROM image AS img
                        INNER JOIN company_image AS ci ON (ci.image_id = img.id)
                        WHERE ci.company_id IN ({$implodedCompanyIds}) AND img.status = 'approved' AND img.type = 'company' AND caption LIKE '%{$cleanPhrase}%'
                        GROUP BY ci.company_id";

            $result = $con->execute($query);

            while ($row = $result->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
                 $companies[$row['company_id']]['rank'] += $row['rank'];
                 $test[$row['company_id']]['imgs'] = $row['rank'];
            }

            // =================================================================================================================================== //

            $query = "SELECT COUNT(i.id) * 0.1 AS rank, ci.company_id FROM image AS i
                        INNER JOIN company_image AS ci ON (ci.image_id = i.id)
                        WHERE ci.company_id IN ({$implodedCompanyIds}) AND i.status = 'approved' AND i.type = 'video' AND LOWER(CONCAT(i.caption, ' ', i.description)) LIKE '%{$cleanPhrase}%'
                        GROUP BY ci.company_id";

            $result = $con->execute($query);

            while ($row = $result->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
                $companies[$row['company_id']]['rank'] += $row['rank'];
                $test[$row['company_id']]['videos'] = $row['rank'];
            }

            // =================================================================================================================================== //

            $query = "SELECT cc.company_id FROM classification_translation AS ct
                        INNER JOIN company_classification AS cc ON (cc.classification_id = ct.id)
                        WHERE cc.company_id IN ({$implodedCompanyIds}) AND LOWER(CONCAT(ct.title, ' ', ct.short_title)) LIKE '%{$cleanPhrase}%'
                        GROUP BY cc.company_id";

            $result = $con->execute($query);

            while ($row = $result->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
                $companies[$row['company_id']]['rank'] += 1;
                $test[$row['company_id']]['classif_title'] = 1;
            }

            // =================================================================================================================================== //


            $query = "SELECT cck.company_id FROM classification AS ck
                        LEFT JOIN classification_translation AS ctk ON (ck.id = ctk.id)
                        INNER JOIN company_classification AS cck ON (cck.classification_id = ctk.id)
                        WHERE cck.company_id IN ({$implodedCompanyIds}) AND LOWER(CONCAT(ctk.keywords, ' ', ck.keywords)) LIKE '%{$cleanPhrase}%'
                        GROUP BY cck.company_id";

            $result = $con->execute($query);

            while ($row = $result->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)) {
                $companies[$row['company_id']]['rank'] += 0.5;
                $test[$row['company_id']]['classif_descr'] = 0.5;
            }

            // =================================================================================================================================== //

            // PPP, Place rating and Distance
            foreach($companies as $key => $value) {
                if ($value['ppp']) {
                    $companies[$key]['rank'] += 0.5;
                    $test[$key]['ppp'] = 0.5;
                }

                $companies[$key]['rank'] += ($value['star_rating'] * 0.05);
                $test[$key]['rank'] = ($value['star_rating'] * 0.05);

                if ($value['distance'] <= 1000) {
                    $companies[$key]['rank'] = $companies[$key]['rank'] * 20;
                }
                elseif ($value['distance'] > 1000 && $value['distance'] <= 3000) {
                    $companies[$key]['rank'] = $companies[$key]['rank'] * 15;
                }
                elseif ($value['distance'] > 3000 && $value['distance'] <= 5000) {
                    $companies[$key]['rank'] = $companies[$key]['rank'] * 10;
                }
                elseif ($value['distance'] > 5000 && $value['distance'] <= 10000) {
                    $companies[$key]['rank'] = $companies[$key]['rank'] * 5;
                }
            }

            // Sort array by rank
            uasort($companies, array($this, 'ArrayElCmp'));

            $companies = array_keys($companies);

            if ($endIndex > (count($companies))) {
                $endIndex = count($companies);
            }

            if ($startIndex >= (count($companies))) {
                $startIndex = 0;
            }
//echo $startIndex;
//exit;
            $limitedCompanyIds = array_slice($companies, $startIndex, $endIndex);
        }

//print_r($companies); exit();

        if ($countResult) {
            // Get companies
            $kmsSql = "((ACOS(SIN(%s * PI() / 180) * SIN(l.latitude * PI() / 180) + COS(%s * PI() / 180) * COS(l.latitude * PI() / 180) * COS((%s - l.longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as kms";
            $kms = sprintf($kmsSql, $lat, $lat, $lng);

            $companies = Doctrine::getTable('Company')
                ->createQuery('c')
                ->innerJoin('c.Location l')
                ->innerJoin('c.Sector s')
                ->innerjoin('s.Translation st WITH st.lang = ?', $this->getUser()->getCulture())
                ->innerJoin('c.Classification ca')
                ->innerJoin('ca.Translation cat WITH cat.lang = ?', $this->getUser()->getCulture())

                // Add kilometers
                ->addSelect("c.id, c.*, s.*, st.*, ca.*, cat.*, l.*")
                ->addSelect($kms)
                ->whereIN('c.id', $limitedCompanyIds)
                //->orderBy('kms')
                ->orderBy('FIELD(c.id,' . implode(',', $limitedCompanyIds) . ')')
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
                    'title' => $company->getCompanyTitleByCulture(null, null, true),
                    'phone' => $company->getPhoneFormated($company->getPhone(), $this->getUser()->getCulture()),
                    'address' => $company->getDisplayAddress(),
                    'ppp' => $ppp,
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
                    'content_url' => $this->generateUrl('default', array('module' => 'api21', 'action' => 'company', 'id' => $company->getId(), 'token' => $request->getParameter('token'), 'locale' => $this->getUser()->getCulture()), true),
                    'share_url' => 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . '://www.getlokal.' . $this->getUser()->getDomain() . '/' . $this->getUser()->getCulture() . '/' . $company->getCity()->getSlug() . '/' . $company->getSlug(),
                );

                // Debug
                //$ttl[] = $company->getCompanyTitleByCulture(null, null, true) . ' - ' . $company->kms . ' - ' . $company->score . ' - ' . $company->getSectorId();
            }

            // Debug
            if (isset($ttl) && count($ttl)) {
                file_put_contents('tst.txt', implode("\n", $ttl));
            }
        }

        /*
        foreach ($test as $key => $value) {
            $test[$key]['total'] = array_sum($value);
        }

        print_r($test); exit;
        */

        return array('item_count' => $countResult, 'items' => $items);
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
//return $this->__debug('test'); exit;
        $this->__checkToken($request->getParameter('token'));

        $this->getResponse()->setContentType('application/json');

        // Params
        $culture = $request->getParameter('locale');
        $country = $request->getParameter('country');

        $lat = $request->getParameter('lat');
        $lng = $request->getParameter('long');

        $keyword = trim($request->getParameter('keyword', null));
        $where = trim($request->getParameter('where', null));

        $cs = $request->getParameter('cs', null);
        $csType = $request->getParameter('cs_type', 0);

        $startIndex = $request->getParameter('start_index', 0);
        $endIndex = $request->getParameter('end_index', 14);

        if ($where && $where == -1) {
            // Nothing to do, just will use current lang & lat...
        }
        elseif ($where && is_numeric($where) && $where != -1) {
            $city = Doctrine::getTable('City')
                    ->findOneById($where);

            if ($city) {
                $country = $city->getCounty()->getCountry();

                $lat = $city->getLat();
                $lng = $city->getLng();
            }
        }
        elseif ($where) {
            $localResult = $this->__getLocation($where);

            if (isset($localResult['lat']) && $localResult['lat'] && isset($localResult['long']) && $localResult['long']) {
                $lat = $localResult['lat'];
                $lng = $localResult['long'];
            }
        }

        $this->forward404Unless($lat || $lng);

        // Search methods...
        if (isset($keyword) && $keyword) {
            if ($result = $this->__searchByKeyword($request, $lat, $lng, $startIndex, $endIndex, $keyword)) {
                return $this->renderText(json_encode(array_merge(array('status' => 'OK'), $result)));
            }
        }
        elseif ($cs) {
            // Recommended
            if ($cs == -1) {
                if ($result = $this->__searchRecommended($request, $lat, $lng, $startIndex, $endIndex)) {
                    return $this->renderText(json_encode(array_merge(array('status' => 'OK'), $result)));
                }
            }
            else {
                if ($result = $this->__searchByCS($request, $lat, $lng, $startIndex, $endIndex, $cs, $csType)) {
                    return $this->renderText(json_encode(array_merge(array('status' => 'OK'), $result)));
                }
            }
        }
        // Blank or NearBy
        else {
            if ($result = $this->__searchBlank($request, $lat, $lng, $startIndex, $endIndex, $where)) {
                return $this->renderText(json_encode(array_merge(array('status' => 'OK'), $result)));
            }
        }

        return $this->renderText(json_encode(array('status' => 'ERROR', 'error' => 'No items found', 'error_code' => 4, 'items' => array())));
    }

    // test action
    // ex. http://www.getlokal.com/mobile_dev.php/api21/test
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
        $this->__checkToken($request->getParameter('token'));

        $this->getResponse()->setContentType('application/json');

        sfContext::getInstance()->getConfiguration()->loadHelpers('Asset');

        $profile = Doctrine::getTable('UserProfile')->createQuery('p')->innerJoin('p.sfGuardUser')->leftJoin('p.City')->where('p.id = ?', $this->getUser()->getId())->fetchOne();

        $badges = Doctrine::getTable('Badge')->createQuery('b')->innerJoin('b.UserBadge ub')->where('ub.user_id = ?', $profile->getId())->execute();

        $activities = Doctrine::getTable('CheckIn')->createQuery('c')->innerJoin('c.Company co')->innerJoin('co.CompanyLocation cl')->where('c.user_id = ?', $profile->getId())->orderBy('c.created_at DESC')->execute();

        $return = array('status' => 'success', 'user_name' => $profile->__toString(), 'user_location' => $profile->getCity() . '', 'user_badges' => $profile->getBadges(), 'user_reviews' => $profile->getReviews(), 'user_photos' => $profile->getImages(), 'user_photo_url' => image_path($profile->getThumb(), true), 'badges' => array(), 'activities' => array());

        foreach ($badges as $badge) {
            $return ['badges'] [] = array('title' => $badge->getName(), 'details' => $badge->getDescription(), 'picture_url' => image_path($badge->getFile('active_image')->getUrl(), true));
        }

        $i18n = $this->getContext()->getI18N();

        foreach ($activities as $activitiy) {
            $return ['actions'] [] = array('title' => $i18n->__('Checked in at %s', array('%s' => $activitiy->getCompany()->__toString())), 'details' => $activitiy->getCompany()->getFullAddress(), 'picture_url' => image_path($activitiy->getCompany()->getThumb(), true), 'datetime' => $activitiy->getDateTimeObject('created_at')->format('c'));
        }

        $this->getResponse()->setContent(json_encode($return));

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
            $return = array('status' => 'ERROR', 'error' => array_merge($form->getErrorSchema()->getGlobalErrors(), $form->getErrorSchema()->getErrors()));
        }

        $this->getResponse()->setContent(json_encode($return));
        return sfView::NONE;
    }

    public function executeRegister(sfWebRequest $request) {
        sfForm::disableCSRFProtection();

        $access_token = $request->getParameter('access_token', null);
        $accept = ($request->getParameter('accept', 0) == 1 ? true : null);

        $city = $country = null;
        if ($access_token) {
            $form = new RegisterMobileForm(null, array('fb' => true));
            $form->useFields(array('email_address', 'first_name', 'last_name', 'allow_contact', 'accept', 'location'));
            $form->bind(array('email_address' => $request->getParameter('username'), 'first_name' => $request->getParameter('firstname'), 'last_name' => $request->getParameter('lastname'), 'allow_contact' => $request->getParameter('allow_contact', 0), 'accept' => $accept, 'location' => $request->getParameter('location')));
        } else {
            $form = new RegisterMobileForm ();
            $form->useFields(array('email_address', 'password', 'first_name', 'last_name', 'allow_contact', 'accept', 'location'));
            $form->bind(array('email_address' => $request->getParameter('username'), 'password' => $request->getParameter('password'), 'first_name' => $request->getParameter('firstname'), 'last_name' => $request->getParameter('lastname'), 'allow_contact' => $request->getParameter('allow_contact', 0), 'accept' => $accept, 'location' => $request->getParameter('location')));
        }

        if ($form->isValid()) {
            if (is_numeric($request->getParameter('location'))) {

                $city = Doctrine::getTable('City')->findOneById($request->getParameter('location'));
                if ($city) {
                    $country = $city->getCounty()->getCountry();
                } else {
                    //todo
                }
            } else {
                if ($request->getParameter('location') != '') {

                    $location_string = explode(',', $request->getParameter('location'));
                    if (isset($location_string [0]) && isset($location_string [1])) {
                        $city_string = trim($location_string [0]);
                        $country_string = trim($location_string [1]);
                    } elseif (!isset($location_string [1])) {
                        $city_string = trim($location_string [0]);
                        $country_string = null;
                    } else {
                        $city_string = trim($request->getParameter('location'));
                    }

                    $city = Doctrine::getTable('City')->createQuery('c')->where('c.name LIKE ? OR c.name_en LIKE ?', array($city_string, $city_string))->fetchOne();

                    if ($city) {
                        if ($country_string) {
                            $country = Doctrine::getTable('Country')->createQuery('c')->where('c.name LIKE ? OR c.name_en LIKE ?', array($country_string, $country_string))->fetchOne();
                        }
                        if (!$country or $country->getId() != $city->getCounty()->getCountryId()) {
                            $country = $city->getCountry();
                        }
                    } else {
                        //


                        $con = Doctrine::getConnectionByTableName('SfGuardUser');
                        $lat = $con->quote($request->getParameter('lat'));
                        $lng = $con->quote($request->getParameter('long'));
                        $this->forward404Unless($lat || $lng);

                        $key = "AIzaSyDDZGSZsZTNuGUImUPcFXOEWObG6GX0I08";

                        $latlng = urlencode($lat . ',' . $lng);

                        $url = "http" . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . "://maps.googleapis.com/maps/api/geocode/json?latlng=" . str_replace('\'', '', $lat . ',' . $lng) . "&sensor=false&language=en";
                        sfContext::getInstance()->getLogger()->emerg('GEOCODE: 13');
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

                                    $city = Doctrine::getTable('City')->createQuery('c')->where('c.name LIKE ? OR c.name_en LIKE ?', array($j_City, $j_City))->fetchOne();
                                    if ($city) {
                                        $country = $city->getCounty()->getCountry();

                                        foreach ($json_a ['results'] [0] ['address_components'] as $key1 => $val1) {
                                            if ($val1 ['types'] [0] == 'country') {
                                                $j_country = $val1 ['long_name'];

                                                // Added c.name in SQL clause
                                                $jcountry = Doctrine::getTable('Country')->createQuery('c')->where('c.name LIKE "%' . $j_country . '%" OR c.name_en LIKE "%' . $j_country . '%"')->fetchOne();

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

                                                // Added c.name in SQL clause
                                                $jcountry1 = Doctrine::getTable('Country')->createQuery('c')->where('c.name LIKE "%' . $j_country1 . '%" OR c.name_en LIKE "%' . $j_country1 . '%"')->fetchOne();

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

                    $con = Doctrine::getConnectionByTableName('SfGuardUser');
                    $lat = $con->quote($request->getParameter('lat'));
                    $lng = $con->quote($request->getParameter('long'));
                    $this->forward404Unless($lat || $lng);

                    $key = "AIzaSyDDZGSZsZTNuGUImUPcFXOEWObG6GX0I08";

                    $latlng = urlencode($lat . ',' . $lng);

                    $url = "http" . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . "://maps.googleapis.com/maps/api/geocode/json?latlng=" . str_replace('\'', '', $lat . ',' . $lng) . "&sensor=false&language=en";
                    sfContext::getInstance()->getLogger()->emerg('GEOCODE: 14');

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

                                $city = Doctrine::getTable('City')->createQuery('c')->where('c.name LIKE ? OR c.name_en LIKE ?', array($j_City, $j_City))->fetchOne();
                                if ($city) {
                                    $country = $city->getCounty()->getCountry();

                                    foreach ($json_a ['results'] [0] ['address_components'] as $key1 => $val1) {
                                        if ($val1 ['types'] [0] == 'country') {
                                            $j_country = $val1 ['long_name'];

                                            // Added c.name in SQL clause
                                            $jcountry = Doctrine::getTable('Country')->createQuery('c')->where('c.name LIKE "%' . $j_country . '%" OR c.name_en LIKE "%' . $j_country . '%"')->fetchOne();

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

                                            // Added c.name in SQL clause
                                            $jcountry1 = Doctrine::getTable('Country')->createQuery('c')->where('c.name LIKE "%' . $j_country1 . '%" OR c.name_en LIKE "%' . $j_country1 . '%"')->fetchOne();

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
                $city = $this->getUser()->getCity();
                $country = $this->getUser()->getCountry();
            } elseif ($city == null && $country && $country->getId() <= 4) {
                $city = Doctrine::getTable('City')->createQuery('c')->innerJoin('c.County co')->where('co.country_id = ?', $country->getId())->orderBy('c.is_default DESC')->limit(1)->fetchOne();
            }

            $user = new sfGuardUser ();
            $user->fromArray($form->getValues());
            $user->setUsername(myTools::cleanUrl($user->getFirstName()) . '.' . rand(1000, 9999));
            if ($access_token) {
                $password = substr(md5(rand(100000, 999999)), 0, 8);
                $user->setPassword($password);
            }
            $user->save();

            $profile = new UserProfile ();
            $profile->setId($user->getId());
            $profile->setCityId($city ? $city->getId() : null );
            $profile->setCountryId($country ? $country->getId() : null );

            if ($access_token) {

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/me?access_token=" . $request->getParameter('access_token'));
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_AUTOREFERER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); # required for https urls


                $user_data = json_decode(curl_exec($ch), true);

                if (isset($user_data ['error'])) {
                    $return = array('status' => 'ERROR', 'error' => $user_data ['error'] ['message']);

                    $this->getResponse()->setContent(json_encode($return));
                    return sfView::NONE;
                }

                curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/me/picture?type=large&" . $access_token);

                $temp_pic = sfConfig::get('sf_upload_dir') . '/' . uniqid('tmp_') . '.jpg';
                file_put_contents($temp_pic, curl_exec($ch));

                $file = new sfValidatedFile(myTools::cleanUrl($user_data ['name']) . '.jpg', filetype($temp_pic), $temp_pic, filesize($temp_pic));

                $gender = null;
                if (isset($user_data ['gender']) && $user_data ['gender'] == 'male') {
                    $gender = 'm';
                } elseif (isset($user_data ['gender']) && $user_data ['gender'] == 'female') {
                    $gender = 'f';
                }
                $date = DateTime::createFromFormat('m/d/Y', $user_data ['birthday']);
                $profile->setBirthDate($date->format('Y-m-d'));
                $profile->setFacebookUrl($user_data ['link']);
                $profile->setFacebookUid($user_data ['id']);
                $profile->setGender($gender);
                $profile->setAccessToken($access_token);
            }

            $profile->save();

            $user_settings = new UserSetting ();
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
                    $usernewsletter = new NewsletterUser ();
                    $usernewsletter->setNewsletterId($newsletter->getId());
                    $usernewsletter->setUserId($user->getId());
                    $usernewsletter->setIsActive($request->getParameter('allow_contact'));
                    $usernewsletter->save();
                }

                MC::subscribe_unsubscribe($user);
            }

            $login = new ApiLogin ();
            $login->setUserId($user->getId());
            $login->setExpiresAt(date('Y-m-d H:i:s', time() + (30 * 86400)));
            $login->save();

            $this->getUser()->setCountry($profile->getCountry());
            $this->getUser()->setCulture($profile->getCountry()->getSlug());

            MobileLog::log('register', null, $login->getUserId());

            //myTools::sendMail ( $user, 'Welcome to getlokal', 'activation', array ('user' => $user ) );
            // Success mail
            myTools::sendMail($user, 'Welcome to Getlokal', 'successRegisteration');

            $return = array('status' => 'SUCCESS', 'token' => $login->getToken());
        } else {
            $return = array('status' => 'ERROR', 'error' => $this->__getErrors($form));
        }

        $this->getResponse()->setContent(json_encode($return));
        return sfView::NONE;
    }

    public function executeRecover(sfWebRequest $request) {
        sfForm::disableCSRFProtection();
        $form = new ForgotPasswordForm ();

        $form->bind(array('email' => $request->getParameter('username')));

        if ($form->isValid()) {
            $return = array('status' => 'SUCCESS');

            $password = substr(md5(rand(100000, 999999)), 0, 8);

            $user = Doctrine::getTable('sfGuardUser')->findOneByEmailAddress($form->getValue('email'));

            $user->setPassword($password);
            $user->save();

            myTools::sendMail($user, 'Forgotten Password', 'forgotPassword', array('password' => $password));
        } else {
            $return = array('status' => 'ERROR', 'error' => $form->getErrorSchema()->getErrors());
        }

        $this->getResponse()->setContent(json_encode($return));
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

        $this->forward404Unless($item = Doctrine::getTable('Company')->find($this->getRequest()->getParameter('identifier')));

        return Doctrine::getTable('CompanyImage')->createQuery('ci')->innerJoin('ci.Image i')->where('ci.company_id = ?', $item->getId())->andWhere('i.status = "approved"')->limit(20)->execute();
    }

    public function getEventImages() {
        $this->forward404Unless($item = Doctrine::getTable('Event')->find($this->getRequest()->getParameter('identifier')));

        return Doctrine::getTable('EventImage')->createQuery('ci')->innerJoin('ci.Image i')->where('ci.event_id = ?', $item->getId())->andWhere('i.status = "approved"')->limit(20)->execute();
    }

    public function executeReview(sfWebRequest $request) {
        $this->__checkToken($request->getParameter('token'));
        $this->forward404Unless($company = Doctrine::getTable('Company')->find($request->getParameter('identifier')));
        sfForm::disableCSRFProtection();
        $review = null;
        $image_array = $review_array = array();
        $form = new ReviewImageForm ();
        $form->bind(array('rating' => $request->getParameter('rating'), 'text' => $request->getParameter('review'), 'file' => $request->getParameter('file')), $request->getFiles());

        if ($form->isValid()) {
            if ($request->getParameter('rating') && $request->getParameter('review')) {
                $review = new Review ();
                $review->fromArray($form->getValues());
                $review->setCompanyId($company->getId());
                $review->setUserId($this->getUser()->getId());
                $this->getResponse()->setCookie('from', MobileLog::getOs());
                $review->save();

                MobileLog::log('review', $review->getId());
            }
            if ($form->getValue('file')) {

                $image = new Image ();
                $image->setFile($form->getValue('file'));
                $image->setUserId($this->getUser()->getId());
                $image->setStatus('approved');
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
                $image_array = array('identifier' => $image->getId(), 'url' => $image->getThumb('preview', true), 'caption' => $image->getDescription());
            }
            if (!empty($image_array)) {
                $return = array_merge(array('status' => 'SUCCESS'), $image_array);
            } else {
                $return = array('status' => 'SUCCESS');
            }
        } else {
            $return = array('status' => 'ERROR', 'error' => $this->__getErrors($form));
        }

        $this->getResponse()->setContent(json_encode($return));
        return sfView::NONE;
    }

    public function executeFavoriteList(sfWebRequest $request) {
        $this->__checkToken($request->getParameter('token'));
        sfContext::getInstance()->getConfiguration()->loadHelpers('Asset');

        $con = Doctrine::getConnectionByTableName('search');

        $lat = $con->quote($request->getParameter('lat'));
        $lng = $con->quote($request->getParameter('long'));
        $this->forward404Unless($lat || $lng);

        $sql = "((ACOS(SIN(%s * PI() / 180) * SIN(l.latitude * PI() / 180) + COS(%s * PI() / 180) * COS(l.latitude * PI() / 180) * COS((%s - l.longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515 * 1.609344) as kms";
        $kms = sprintf($sql, $lat, $lat, $lng);

        $query = Doctrine::getTable('Company')->createQuery('c')->addSelect('c.*, i.*')->addSelect($kms)->innerJoin('c.CompanyLocation l')->innerJoin('c.CompanyPage p')->innerJoin('p.Follow f')->leftJoin('c.Image i')->where('f.user_id = ?', $this->getUser()->getId())->limit(20);

        $return = array();
        foreach ($query->execute() as $company) {
            $return [] = array('identifier' => $company->getId(), 'title' => $company->getCompanyTitleByCulture(null, null, true), 'ppp' => ($company->getActivePPPService(true) ? 1 : 0), 'phone' => $company->getPhoneFormated($company->getPhone(), $this->getUser()->getCulture()), 'address' => $company->getDisplayAddress(), 'favourite' => 1, 'rating' => $company->getAverageRating(), 'reviews' => $company->getNumberOfReviews(), 'lat' => $company->getLocation()->getLatitude(), 'long' => $company->getLocation()->getLongitude(), 'distance' => (!is_null($company->kms) ? $company->kms : 0), 'icon' => 'marker_' . $company->getSectorId(), 'picture_url' => image_path($company->getThumb(0, true), true), 'share_url' => 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . '://www.getlokal.' . $this->getUser()->getDomain() . '/' . $this->getUser()->getCulture() . '/' . $company->getCity()->getSlug() . '/' . $company->getSlug(), 'content_url' => $this->generateUrl('default', array('module' => 'api21', 'action' => 'company', 'id' => $company->getId(), 'token' => $request->getParameter('token'), 'locale' => $this->getUser()->getCulture()), true));
        }

        $this->getResponse()->setContent(json_encode($return));
        return sfView::NONE;
    }

    public function executeFavorite(sfWebRequest $request) {
        $this->__checkToken($request->getParameter('token'));
        $company = Doctrine::getTable('Company')->find($request->getParameter('identifier'));
        if (!$company) {
            $return = array('status' => 'ERROR', 'error' => 'Place Not Found');
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
            $return = array('status' => 'ERROR', 'errors' => $this->__getErrors($form));
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
            $image->save();

            $profile = Doctrine::getTable('UserProfile')->find($this->getUser()->getId());
            $profile->setImageId($image->getId());
            $profile->save();

            $return = array('status' => 'SUCCESS', 'identifier' => $image->getId());
        } else {
            $return = array('status' => 'ERROR', 'errors' => $this->__getErrors($form));
        }

        $this->getResponse()->setContent(json_encode($return));
        return sfView::NONE;
    }

    public function executeValidatephoto(sfWebRequest $request) {
        $this->__checkToken($request->getParameter('token'));
        $image = Doctrine::getTable('Image')->createQuery('i')->where('i.id = ? ', $request->getParameter('photoid'))->andWhere('i.user_id = ?', $this->getUser()->getId())->fetchOne();

        if (!$image) {
            $return = array('status' => 'ERROR', 'error' => 'Object Not Found');
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

    public function executeMyvouchers(sfWebRequest $request) {

        $this->__checkToken($request->getParameter('token'));
        sfContext::getInstance()->getConfiguration()->loadHelpers('Asset');

        $profile = Doctrine::getTable('UserProfile')->createQuery('p')->innerJoin('p.sfGuardUser')->leftJoin('p.City')->where('p.id = ?', $this->getUser()->getId())->fetchOne();

        $vouchers = VoucherTable::getVouchers($profile, false, false);

        $return = array('status' => 'SUCCESS', 'vouchers' => array());
        if ($vouchers) {
            foreach ($vouchers as $voucher) {
                $offer = $voucher->getCompanyOffer();
                $return ['vouchers'] [] = array('identifier' => $voucher->getCode(), 'offer' => array('title' => $offer->getDisplayTitle(), 'description' => $offer->getDisplayDescription(), 'image' => $offer->getThumb('preview', true), 'active_to' => $offer->getActiveTo(), 'valid_from' => $offer->getValidFrom(), 'valid_to' => $offer->getValidTo(), 'max_vouchers' => $offer->getMaxVouchers(), 'max_per_user' => $offer->getMaxPerUser(), 'can_be_claimed' => ($offer->getIsAvailableToOrder() ? 1 : 0)));
            }
        }

        $this->getResponse()->setContent(json_encode($return));
        return sfView::NONE;
    }

    public function executeClaimoffer(sfWebRequest $request) {

        $this->__checkToken($request->getParameter('token'));
        sfContext::getInstance()->getConfiguration()->loadHelpers('Asset');

        $this->forward404Unless($item = Doctrine::getTable('CompanyOffer')->find($this->getRequest()->getParameter('identifier')));
        $count = $this->getRequest()->getParameter('count', 1);
        if ($item->getIsActive() && $item->getIsAvailableToOrder($this->getUser()->getId())) {
            if ($count == 1) {
                $user_voucher = new Voucher ();
                $user_voucher->setUserId($this->getUser()->getId()->getId());
                $user_voucher->setCompanyOfferId($item->getId());
                $user_voucher->setCode(substr(uniqid(md5($item->getCode() . rand()), true), 0, 8));
                $user_voucher->save();
                
                MobileLog::log('getvoucher', $item->getId());
                
            } else {
                $i = 0;
                while ($i < $count) {
                    $i++;
                    $user_voucher = new Voucher ();
                    $user_voucher->setUserId($this->getUser()->getId());
                    $user_voucher->setCompanyOfferId($item->getId());
                    $user_voucher->setCode(substr(uniqid(md5($item->getCode() . rand()), true), 0, 8));
                    $user_voucher->save();
                    
                    MobileLog::log('getvoucher', $item->getId());
                }
            }
            $item->updateNumberOfVouchers();
            $return = array('status' => 'SUCCESS', 'voucher' => array('identifier' => $user_voucher->getCode(), 'offer' => array('title' => $item->getDisplayTitle(), 'description' => $item->getDisplayDescription(), 'image' => $item->getThumb('preview', true), 'active_to' => $item->getActiveTo(), 'valid_from' => $item->getValidFrom(), 'valid_to' => $item->getValidTo(), 'max_vouchers' => $item->getMaxVouchers(), 'max_per_user' => $item->getMaxPerUser(), 'can_be_claimed' => ($item->getIsAvailableToOrder() ? 1 : 0))));
        } else {
            $i18n = $this->getContext()->getI18N();
            $return = array('status' => 'ERROR', 'error' => $i18n->__('We were unable to issue your voucher. The offer is no longer active or you have already ordered the maximum number vouchers per user.'));
        }

        $this->getResponse()->setContent(json_encode($return));
        return sfView::NONE;
    }

    public function executeReport(sfWebRequest $request) {
        $this->__checkToken($request->getParameter('token'));
        $this->company = Doctrine::getTable('Company')->findOneById($request->getParameter('identifier'));
        if (!$this->company) {
            $return = array('status' => 'ERROR', 'error' => 'Object Not Found');
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
            $return = array('status' => 'ERROR', 'error' => array_merge($form->getErrorSchema()->getGlobalErrors(), $form->getErrorSchema()->getErrors()));
        }
        $this->getResponse()->setContent(json_encode($return));
        return sfView::NONE;
    }

    public function executeAddnewplace(sfWebRequest $request) {
        $this->__checkToken($request->getParameter('token'));
        sfForm::disableCSRFProtection();

        $company = new Company ();
        $company->setStatus(CompanyTable::VISIBLE);
        $company_location = new CompanyLocation();
        $company_location->setCompany($company);
        $company_location->setIsActive(1);

        $form = new CompanyMobileForm($company);
        $con = Doctrine::getConnectionByTableName('company');
        $lat = $con->quote($request->getParameter('lat'));
        $lng = $con->quote($request->getParameter('long'));
        $this->forward404Unless($lat || $lng);

        $form->bind(array('title' => $request->getParameter('title'), 'location' => $request->getParameter('location_id'), 'address' => $request->getParameter('address'), 'classification_id' => $request->getParameter('classification_id'), 'phone' => $request->getParameter('phone')));

        if ($form->isValid()) {
            $remove = array(',', ';', ':', '"', '„', '”', '“', '(', ')', '№', '&ndash;');

            $title = trim(str_replace($remove, ' ', $request->getParameter('title')));

            $partnerClass = getlokalPartner::getLanguageClass();
            $titleEn = call_user_func(array('Transliterate' . $partnerClass, 'toLatin'), $title);

            $classification = Doctrine::getTable('Classification')->findOneById($request->getParameter('classification_id'));
            $company->setTitle($title);
            $company->setTitleEn($titleEn);
            $company->setClassificationId($request->getParameter('classification_id'));
            $company->setSectorId($classification->getPrimarySector()->getId());
            $company->setPhone(str_replace('+', '00', $request->getParameter('phone')));
            $company_location->setLatitude($request->getParameter('lat'));
            $company_location->setLongitude($request->getParameter('long'));

            $company_classification = new CompanyClassification ();
            $company_classification->setCompany($company);
            $company_classification->setClassificationId($request->getParameter('classification_id'));

            $key = "AIzaSyDDZGSZsZTNuGUImUPcFXOEWObG6GX0I08";

            if ($request->getParameter('address', null) != '') {
                $address = urlencode($request->getParameter('location_id') . ', ' . $request->getParameter('address'));

                $url = "http" . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . "://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&sensor=false&language=" . $this->getUser()->getCulture();
            } else {
                $url = "http" . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . "://maps.googleapis.com/maps/api/geocode/json?latlng=" . str_replace('\'', '', $lat . ',' . $lng) . "&sensor=false&language=en";
            }
            sfContext::getInstance()->getLogger()->emerg('GEOCODE: 15');
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
                //TODO


                foreach ($json_a ['results'] [0] ['address_components'] as $key => $val) {
                    //start
                    if ($val ['types'] [0] == 'street_number') {
                        $company_location->setStreetNumber($val ['long_name']);
                    } elseif ($val ['types'] [0] == 'route') {
                        $list_street_types = array('булевард' => 1, 'улица' => 6, 'площад' => 5, 'шосе' => 17, 'bulevard' => 1, 'ulitsa' => 6, 'ploshtad' => 5,
                            'Bulevardul' => 1, 'Cartier' => 2, 'Strada' => 6, 'Calea' => 10, 'Prelungirea' => 12, 'Piata' => 5, 'Drumul' => 14, 'Intrarea' => 7, 'Șoseaua' => 17, 'Aleea' => 18);

                        $list_neighbourhood_types = array('жк' => 2, 'кв.' => 3, 'м.' => 4, 'п.к.' => 7, 'к-с' => 8);

                        $str_long_name = $val ['long_name'];
                        $firstword = explode(" ", $str_long_name, 2);

                        $term = $firstword [0];
                        $str_long_name = trim(str_replace($remove, ' ', $str_long_name));
                        $rest = trim(str_replace($term, '', $str_long_name));

                        if (isset($list_street_types [$term])) {
                            $company_location->setStreetTypeId($list_street_types [$term]);
                            $company_location->setSublocation($str_long_name);
                            $company_location->setStreet($rest);
                            $company_location->setLocationType('');
                            $company_location->setNeighbourhood('');
                            $company_location->setBuildingNo('');
                        } elseif (isset($list_neighbourhood_types [$term])) {

                            $company_location->setStreetTypeId('');
                            $company_location->setSublocation($str_long_name);
                            $company_location->setStreet('');
                            $company_location->setLocationType($list_neighbourhood_types [$term]);
                            $company_location->setNeighbourhood($rest);
                            $company_location->setBuildingNo('');
                        } else {
                            $company_location->setStreetTypeId('');
                            $company_location->setSublocation($str_long_name);
                            $company_location->setStreet($str_long_name);
                            $company_location->setLocationType('');
                            $company_location->setNeighbourhood('');
                            $company_location->setBuildingNo('');
                        }
                    } elseif ($val ['types'] [0] == 'locality') {

                        $j_City = $val ['long_name'];

                        $city = Doctrine::getTable('City')->createQuery('c')->where('c.name LIKE ? OR c.name_en LIKE ?', array($j_City, $j_City))->fetchOne();
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

                            $city = (int)$request->getParameter('location_id', false);

                            if (is_int($city) && $city) {
                                $city = Doctrine::getTable('City')->find($city);
                            }
                        }
                        $company->clearRelated('City');
                        $company->setCityId($city->getId());
                        $company->setCountryId($country->getId());
                    } //else {
                    //return 'bbb';
                    //}
                    //end
                }

                $company->save();
                $company_location->save();
                $company->setLocation($company_location);
                $company->save();
                $company_classification->save();
            }

            $return = array('status' => 'SUCCESS', 'indentifier' => $company->getId());
        } else {
            $return = array('status' => 'ERROR', 'error' => array_merge($form->getErrorSchema()->getGlobalErrors(), $form->getErrorSchema()->getErrors()));
        }
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
            $return = array('status' => 'ERROR', 'error' => $user_data ['error'] ['message']);

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

                            $result = Doctrine_Query::create()->from('City c')->innerJoin('c.County co')->where('co.country_id = ?', $tmpCountry->getId())->where('c.name = ? OR c.name_en = ?', array($city, $city))->fetchOne();

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
                    sfContext::getInstance()->getLogger()->emerg('GEOCODE: 16');
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

                                $city = Doctrine::getTable('City')->createQuery('c')->where('c.name LIKE ? OR c.name_en LIKE ?', array($j_City, $j_City))->fetchOne();
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

}
