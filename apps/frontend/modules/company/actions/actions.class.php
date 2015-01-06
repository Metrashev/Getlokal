<?php
/**
 * company actions.
 *
 * @package    getlokal
 * @subpackage company
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class companyActions extends sfActions {
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $this->companies = Doctrine::getTable ( 'Company' )->createQuery ( 'c' )->limit ( 10 )->execute ();

    }

    public function executeRegisterPost(sfWebRequest $request) {
    	$this->with_form = $request->getParameter("with_form",false);
        $this->formRegister = new OldRegisterForm(null, array('city_is_mandatory' => true));
    }

    public function executeLoginPost(sfWebRequest $request) {
        $this->formLogin = new sfGuardFormSignin ();
    }

    protected function configCompany(sfWebRequest $request)
    {
        $query = Doctrine::getTable('Company')->createQuery('c')
            ->innerJoin('c.City l')
            ->innerJoin('l.County co')
            ->innerJoin('co.Country')
            ->innerJoin('c.CompanyLocation')
            ->leftJoin('c.CompanyDetail d')
            ->where('c.slug = ?', $request->getParameter('slug'));
        $this->company = $query->fetchOne();
        //return;
        if (!$this->company)
        {
            $this->forward404Unless($this->company = Doctrine::getTable('Company')->findOneByOldSlug($request->getParameter('slug')));
            if ($this->company->getStatus() != CompanyTable::VISIBLE && !$this->getUser()->hasCredential('admin'))
            {
              $this->redirect ( 'company/notFound', 410 );
            }
            $this->redirect($this->company->getUri(), 301);
        }
        elseif ($this->company->getStatus() != CompanyTable::VISIBLE && !$this->getUser()->hasCredential('admin'))
        {

            $this->redirect('company/notFound' , 410);
        }

        $this->forward404Unless($this->company);
        $this->company->setUser($this->getUser());

    }

    public function configShow(sfWebRequest $request)
    {
        $this->configCompany($request);

        $related_q = Doctrine::getTable('Company')->createQuery('c')
            ->innerJoin('c.City l')
            ->innerJoin('c.Image')
            ->innerJoin('c.Classification ca')
            ->innerJoin('c.Sector s')
            ->innerJoin('s.Translation')
            ->innerJoin('ca.Translation')
            ->where('c.classification_id = ?', $this->company->getClassificationId())
            ->limit(4);
        
        
//         $relations_array = array(
//         	"Company"=>array("Sector","Classification")
//         );
        //$related_q->useResultCache(true,3600,"related_companies_".serialize($related_q->getCountQueryParams()),$relations_array);
        
        $related = $related_q->execute();

        $query = Doctrine::getTable('Image')->createQuery('i')
            ->innerJoin('i.CompanyImage ci')
            ->innerJoin('i.UserProfile p')
            ->innerJoin('p.sfGuardUser')
            ->where('ci.company_id = :company')
            ->andWhere('i.type != :type_id')
            ->orderBy('i.id= :company');

        if ($this->company->getImageId())
        {
            $query->andWhere('ci.image_id != :pimage');
        }

        $this->followers = Doctrine::getTable('FollowPage')->createQuery('fp')
           ->where('fp.page_id= ?', $this->company->getCompanyPage()->getId())
           ->execute();

        $this->images = $query->execute(array(
            'company' => $this->company->getId(),
            'type_id' => 'video',
            'pimage' => $this->company->getImageId()
        ));

        $query = Doctrine::getTable('Lists')->createQuery('l')
            ->innerJoin('l.UserProfile p')
            ->innerJoin('p.sfGuardUser sf')
            ->innerJoin('l.ListPage lp')
            ->where('lp.page_id = ?', $this->company->getCompanyPage()->getId())
            ->orderBy('l.created_at DESC');

        $this->listsCount = $query->count();

        $this->videos = $this->company->getVideos(true);
        $this->lastOffer = $this->company->getLastOffer();
        $this->offers = $this->company->getAllOffers(true);
        $this->offerCount = $this->company->getAllOffers(true, false, true);
        $this->user_is_admin = false;
        $this->is_other_place_admin_logged = false;
        $this->is_followed = false;

        $this->user = $this->getUser()->getGuardUser();
        if ($this->getUser()->getPageAdminUser())
        {
            $this->is_other_place_admin_logged = true;
            $admin = Doctrine::getTable('PageAdmin')->createQuery('a')
                ->where('a.id = ?', $this->getUser()->getPageAdminUser()->getId())
                ->andWhere('a.status = ?', 'approved')
                ->andWhere('a.page_id = ?', $this->company->getCompanyPage()->getId())
                ->fetchOne();
            if ($admin)
            {
                $this->user_is_admin = true;
                $this->is_other_place_admin_logged = false;
            }
        }

        $this->user_is_company_admin = (($this->user && $this->user->getIsPageAdmin ( $this->company )) ? true : false);
        $this->user_is_not_approved_admin = (($this->user && $this->user->getAllStatusPageAdmin ( $this->company )) ? true : false);
        $this->getUser()->setCity($this->company->getCity());

        if ($this->user)
        {
          $this->is_followed = Doctrine::getTable ( 'FollowPage' )->getFollowPage ( $this->user->getId (), $this->company->getCompanyPage()->getId ()  );
        }
        
        if ((getlokalPartner::getInstanceDomain() == 78) || $request->getParameter('county', false)) {
            breadCrumb::getInstance()->add($this->company->getSector()->getTitle(),
                '@sectorCounty?county=' . $this->company->getCity()->getCounty()->getSlug() . '&slug=' . $this->company->getSector()->getSlug());
            breadCrumb::getInstance()->add($this->company->getClassification()->getTitle(),
                '@classificationCounty?county=' . $this->company->getCity()->getCounty()->getSlug() . '&sector=' . $this->company->getSector()->getSlug() . '&slug=' . $this->company->getClassification()->getSlug());
        }
        else {
            breadCrumb::getInstance()->add($this->company->getSector()->getTitle(),
                '@sector?city=' . $this->company->getCity()->getSlug() . '&slug=' . $this->company->getSector()->getSlug());
            breadCrumb::getInstance()->add($this->company->getClassification()->getTitle(),
                '@classification?city=' . $this->company->getCity()->getSlug() . '&sector=' . $this->company->getSector()->getSlug() . '&slug=' . $this->company->getClassification()->getSlug());
        }        

        $eventsQ = Doctrine::getTable('Event')->createQuery('e')
            ->innerJoin('e.Translation t')
            ->innerJoin('e.UserProfile p')
            ->innerJoin('p.sfGuardUser sf')
            ->innerJoin('e.EventPage ep')
            ->where('ep.page_id = ?', $this->company->getCompanyPage()->getId())
            ->addWhere('e.is_active = ?', 1);
        $eventsQ = EventTable::applyFutureFilter($eventsQ);
        $this->eventCount = $eventsQ->count();

        if ($this->company->getActivePPPService(true))
        {
            $this->getResponse()->setSlot('sub_module', 'company_vip');
            $date = date('Y-m-d');

            // active events
            $this->events = $eventsQ->limit(2)->execute();

            $query_lists = Doctrine::getTable('Lists')->createQuery('l')
                ->innerJoin('l.Translation lt')
                ->innerJoin('l.ListPage lp')
                ->where('lp.page_id = ?', $this->company->getCompanyPage()->getId())
                ->andWhere('l.is_active = 1')
                ->orderBy('l.created_at DESC');

            $this->lists = $query_lists->execute();

            $query_article = Doctrine::getTable('Article')->createQuery('ar')
                //->innerJoin('ar.Translation art')
                ->innerJoin('ar.ArticlePage arp')
                ->where('arp.page_id = ?', $this->company->getCompanyPage()->getId())
                //->andWhere('art.lang = ?',$this->getUser ()->getCulture ())
                ->addWhere('ar.status = "approved"')
                ->orderBy('ar.created_at DESC');

            $this->articles = $query_article->execute();

            $this->getResponse()->setSlot('sub_module_parameters', array(
                'company' => $this->company,
                'images' => $this->images,
                'videos' => $this->videos,
                'user_is_admin' => $this->user_is_admin,
                'user_is_company_admin' => $this->user_is_company_admin,
                'is_other_place_admin_logged' => $this->is_other_place_admin_logged,
                'user' => $this->user,
                'offers' => $this->offers,
                'offerCount' => $this->offerCount,
                'lastOffer' => $this->lastOffer,
                'eventCount' => $this->eventCount,
                'related' => $related,
                'listsCount' => $this->listsCount,
                'is_followed' => $this->is_followed,
                'followers' => $this->followers,
                'events' => $this->events,
                'lists' => $this->lists,
                'articles' => $this->articles,
                'user_is_not_approved_admin' => $this->user_is_not_approved_admin,
                'list_form' => $this->list_form
            ));


            $this->hasFbStatuses = Doctrine::getTable('CompanyStatus')->createQuery('cs')
                ->where('cs.company_id = ? ', $this->company->getId())
                ->andWhere('cs.is_published = ?', 1)
                ->andWhere('cs.publish_to = ?', 'fb')
                ->count();
        }
        else
        {
            $this->eventCount = $eventsQ->count();

            $this->similar_places = $this->company->getSimilarPlaces();

            $this->getResponse()->setSlot('sub_module', 'company');
            $this->getResponse()->setSlot('sub_module_parameters', array(
                'company' => $this->company,
                'images' => $this->images,
                'videos' => $this->videos,
                'user_is_admin' => $this->user_is_admin,
                'user_is_company_admin' => $this->user_is_company_admin,
                'is_other_place_admin_logged' => $this->is_other_place_admin_logged,
                'user' => $this->user,
                'offers' => $this->offers,
                'offerCount' => $this->offerCount,
                'followers' => $this->followers,
                'lastOffer' => $this->lastOffer,
                'eventCount' => $this->eventCount,
                'related' => $related,
                'listsCount' => $this->listsCount,'is_followed' => $this->is_followed,'similar_places' => $this->similar_places,
                'user_is_not_approved_admin' => $this->user_is_not_approved_admin,
                'list_form' => $this->list_form
            ));
        }

        $request->setParameter('location', $this->company->getCity());
        $request->setParameter('classification', $this->company->getClassification()->getTitle());
        $this->getResponse()->setTitle($this->company->getCompanyTitle());
        //$meta = $this->company->getCompanyTitle().' - '.$this->company->getDisplayAddress();
       //$this->getResponse()->addMeta('description', $meta);
        //$this->getResponse()->addMeta('keywords', myTools::generateKeywords($meta));
    }
/*public function executeFollow(sfWebRequest $request)
  {
    $this->configShow ( $request );
    if(!$this->user_is_admin && !$this->is_other_place_admin_logged  && $this->user)
    {
      $follow = Doctrine::getTable('FollowPage')->getFollowPage($this->user->getId(), $this->company->getCompanyPage()->getId());
      if(!$follow){
      $follow = new FollowPage();
      $follow->setUserId($this->user->getId());
      $follow->setPageId($this->company->getCompanyPage()->getId());
      $follow->save();

      $this->getUser()->setFlash('notice', 'success follow');
      }
    }

    $this->redirect($request->getReferer());
  }
    */

        // Return events
        public function executeGetEventsAutocomplete(sfWebRequest $request) {
            if ($keyword = trim($request->getPostParameter('keyword', false))) {
                $keyword = mb_convert_case($keyword, MB_CASE_TITLE, "UTF-8");

                $this->eventsList = Doctrine::getTable('Event')
                                    ->createQuery('e')
                                    ->innerJoin('e.Translation et')
                                    ->where('et.title LIKE ?', '%' . $keyword . '%')
                                    ->orderBy('e.id DESC')
                                    ->limit(100)
                                    ->execute();
            }
        }

        // Save company status
        public function executeSaveCompanyStatus(sfWebRequest $request) {
            $this->configShow($request);

            if (($this->user_is_admin && $this->user_is_company_admin) || $this->getUser()->isGetlokalAdmin()) {
                if ($request->getPostParameter('save', false) && trim($request->getPostParameter('message', false))) {
                    $userId = $this->getUser()->getId();

                    $eventId = $request->getPostParameter('eventId', NULL);
                    $offerId = $request->getPostParameter('offerId', NULL);

                    $additionalHtml = '';
                    $object = NULL;

                    if ($eventId) {
                        $eventId = explode('eventId_', $eventId);
                        $eventId = array_pop($eventId);

                        $object = Doctrine::getTable('Event')->findOneById($eventId);
                        $additionalHtml = '<div>';

                        if ($object->getImage()->getType() == 'poster') {
                            $additionalHtml .= '<a href="' . $this->generateUrl('default', array('module' => 'event', 'action' => 'show', 'id' => $object->getId()), true) . '" class="img_wrap"><img src="' . $object->getThumb('preview') . '" width="101" height="135" /></a>';
                        }
                        else {
                            $additionalHtml .= '<a href="' . $this->generateUrl('default', array('module' => 'event', 'action' => 'show', 'id' => $object->getId()), true) . '" class="img_wrap"><img src="' . $object->getThumb(2) . '" width="101" height="135" /></a>';
                        }

                        $additionalHtml .= '<a href="' . $this->generateUrl('default', array('module' => 'event', 'action' => 'show', 'id' => $object->getId()), true) . '">' . $object->getDisplayTitle() . '</a>';
                        $additionalHtml .= '<p>' . $object->getDateTimeObject('start_at')->format('d/m/Y') . '</p>';
                        $additionalHtml .= '</div>';
                    }
                    elseif ($offerId) {
                        foreach ($this->offers as $offer) {
                            if ($offer->getId() == $offerId) {
                                $object = $offer;

                                break;
                            }
                        }

                        if ($object) {
                            $i18n = sfContext::getInstance()->getI18N();

                            $additionalHtml = '<div>';

                            if ($object->getImageId()) {
                                $additionalHtml .= '<a href="' . $this->generateUrl('default', array('module' => 'offer', 'action' => 'show', 'id' => $object->getId()), true) . '" class="img_wrap"><img src="' . $object->getThumb() . '" width="100" height="100" /></a>';
                            }
                            else {
                                $additionalHtml .= '<a href="' . $this->generateUrl('default', array('module' => 'offer', 'action' => 'show', 'id' => $object->getId()), true) . '" class="img_wrap"><img src="gui/default_offer_100x100.jpg" width="100" height="100" /></a>';
                            }

                            $additionalHtml .= '<a href="' . $this->generateUrl('default', array('module' => 'offer', 'action' => 'show', 'id' => $object->getId()), true) . '">' . $object->getDisplayTitle() . '</a>';

                            $additionalHtml .= '<a href="' . $this->generateUrl('default', array('module' => 'offer', 'action' => 'show', 'id' => $object->getId()), true) . '" class="button_pink">' . $i18n->__('Order Voucher', null, 'offer') . '</a>';
                            $additionalHtml .= '</div>';
                        }
                    }



                    $status = new CompanyStatus();
                    $status->setUserId($userId);
                    $status->setCompanyId($this->company->getId());

                    $message = trim($request->getPostParameter('message', ''));
                    $message = '<p>' . strip_tags($message) . '</p>' . $additionalHtml;


                    $status->setText($message);

                    if ($request->getPostParameter('publishTo', false)) {
                        $publishTo = $request->getPostParameter('publishTo', false);
                        $publishTo = implode(',', $publishTo);

                        $status->setPublishTo($publishTo);
                    }

                    $status->save();

                    return $this->renderText(json_encode(array('success' => true)));
                }
            }

            return $this->renderText(json_encode(array('error' => true)));
        }

        public function executeRemoveCompanyStatus(sfWebRequest $request) {
            $this->configShow($request);

            //if (!$this->user_is_admin && !$this->user_is_company_admin && !$this->getUser()->isGetlokalAdmin()) {
            if (($this->user_is_admin && $this->user_is_company_admin) || $this->getUser()->isGetlokalAdmin()) {
                if ($request->getPostParameter('remove', false) && $request->getPostParameter('statusId', false)) {
                    if ($status = Doctrine::getTable('CompanyStatus')->find($request->getPostParameter('statusId', 0))) {
                        if ($status->getCompanyId() == $this->company->getId()) {
                            $status->delete();

                            return $this->renderText(json_encode(array('success' => true)));
                        }
                        else {
                            return $this->renderText(json_encode(array('error' => true)));
                        }
                    }
                }
            }

            return $this->renderText(json_encode(array('error' => true)));
        }

        // Get company statuses
        public function executeGetListOfCompanyStatuses(sfWebRequest $request) {
            $this->configShow($request);
            $this->hideRemoveLink = true;

            //if (!$this->user_is_admin && !$this->user_is_company_admin && !$this->getUser()->isGetlokalAdmin()) {
            if (($this->user_is_admin && $this->user_is_company_admin) || $this->getUser()->isGetlokalAdmin()) {
                $this->hideRemoveLink = false;
            }

            $this->listOfStatuses = Doctrine::getTable('CompanyStatus')
                ->createQuery('cs')
                ->where('cs.company_id =? ', $this->company->getId())
                ->andWhere('cs.is_published = ?', 1)
                ->orderBy('cs.created_at DESC')
                ->limit(7)
                ->execute();
        }

        // Show all offers
        public function executeShowAllOffers(sfWebRequest $request) {
            $this->configShow($request);

            $query = $this->company->getAllOffers(true, true, false);

            $this->pager = new sfDoctrinePager ( 'CompanyOffer', CompanyOffer::OFFERS_PER_PAGE );
            $this->pager->setQuery ( $query );
            $this->pager->setPage ( $request->getParameter ( 'page', 1 ) );
            $this->pager->init ();


            if ($template = $request->getParameter('template', false)) {
                if ($template != 'customOffer') {
                    $template = 'customOffer';
                }
            }
            else {
                $template = 'customOffer';
            }

            $this->setTemplate($template);
        }

        // Show all events - see executeEvents
    public function executeShow(sfWebRequest $request) {
    	$this->reviewSuccess = 'no review';
        $this->configShow ( $request );

        $this->form = new ReviewForm ();
        $this->formRegister = new OldRegisterForm(null, array('city_is_mandatory' => true));
        $this->formLogin = new sfGuardFormSignin ();
        $user = $this->getUser()->getGuardUser();
        //echo $this->form->getName ();
        //die;
        $reviewData = $request->getParameter('review');
        
        //var_dump(is_object($user), is_numeric($user->getId()) ,isset($review['rating']) ,isset($review['text']) ,is_numeric($review['rating']) ,$review['text'] != ''); die;
        if ($this->getUser ()->hasAttribute ( 'review' ) && $this->getUser ()->hasAttribute ( 'review_rating' )) {
        	//var_dump($review['text'], $review['rating']+0); die;
        	
        	$review = new Review ();
            $review->setText ( $reviewData['text'] );
            $review->setRating ( $reviewData['rating'] );
            $review->setUserId ( $user->getId () );
            $review->setCompanyId ( $this->company->getId () );
            //var_dump(  $review['text'],$review['rating'],$user->getId (),$this->company->getId () ); die;
            //var_dump( $review->getText (),$review->setRating (),$review->setUserId (),$review->setCompanyId () ); die;
            //$review->save ();
            
            //$this->getUser ()->setFlash ( 'notice', 'Your review was published successfully. the First' );
            $request->setParameter('text', '');
            $request->setParameter('rating', '');
            $request->setParameter('review', '');
            
            //
            
        }else{
        	if ($request->isMethod ( 'post' )) {
        		$this->form->bind ( $request->getParameter ( $this->form->getName () ) );
        	}
        }

        if ($request->isMethod ( 'post' )) {

            $params = $request->getParameter ( $this->formLogin->getName () );

            /*if (isset ( $params ['facebook'] )) {
                $this->form->bind ( $request->getParameter ( $this->form->getName () ) );
                if ($this->form->isValid ()) {
                    $review = $this->form->updateObject ();
                    $this->getUser ()->setReferer ( $request->getReferer () );
                    $this->getUser ()->setAttribute ( 'review', $review->getText () );
                    $this->getUser ()->setAttribute ( 'review_rating', $review->getRating () );
                    $this->executeFBLogin ( $request );
                    $this->user = $this->getUser ()->getGuardUser ();
                } else {
                    $this->getUser ()->setFlash ( 'error', 'Your review was not published successfully.' );
                }
            } else*/

            if ($request->getParameter ( $this->formLogin->getName () )) {
                $this->formLogin->bind ( $request->getParameter ( $this->formLogin->getName () ) );
                if ($this->formLogin->isValid ()) {
                    $values = $this->formLogin->getValues ();
                    $this->getUser ()->signin ( $values ['user'], array_key_exists ( 'remember', $values ) ? $values ['remember'] : false );

                                        // Set city after login
                                        if ($this->getUser()->getCountry()->getId() == $this->getUser()->getProfile()->getCountry()->getId()) {
                                            $this->getUser()->setCity($this->getUser()->getProfile()->getCity());
                                            $this->getUser()->setAttribute('user.set_city_after_login', true);
                                        }

                    $this->user = $this->getUser ()->getGuardUser();
                }
            } elseif ($request->getParameter ( $this->formRegister->getName () )) {
                $params = $request->getParameter($this->formRegister->getName());

                $this->formRegister->bind ( $request->getParameter ( $this->formRegister->getName () ) );

                if ($this->formRegister->isValid ()) {
                    $con = Doctrine::getConnectionByTableName ( 'sfGuardUser' );
                    $params = $request->getParameter ( $this->formRegister->getName () );

                    $profile = $this->formRegister->updateObject ();
                    
                    if ($profile->getCountryId() > 4 && $profile->getCountryId() != 78) {
                        $profile->setCityId(NULL);
                    }

                    $activation_hash = md5 ( rand ( 100000, 999999 ) );
                    $profile->setHash ( $activation_hash );
                    $user_register = $this->formRegister->getEmbeddedForm ( 'sf_guard_user' )->getObject ();
                    $user_register->setUsername ( substr ( uniqid ( md5 ( rand () ), true ), 0, 8 ) );
                    $user_register->setIsActive ( true );
                    $profile->setSfGuardUser ( $user_register );
                    try {
                        $con->beginTransaction ();
                                                // OLD
                        //$profile->setCountryId ( getlokalPartner::getInstance () );

                                                if (isset($params['gender']) && $params['gender']) {
                                                    $profile->setGender($params['gender']);
                                                }

                        $profile->save ();

                        $user_settings = new UserSetting ();
                        $user_settings->setId ( $profile->getId () );


                        if (!isset($params ['allow_contact'])) {
                            $user_settings->setAllowContact(false);
                            $user_settings->setAllowNewsletter(false);
                        } else {
                            $user_settings->setAllowContact(true);
                            $user_settings->setAllowNewsletter(true);
                            $user_settings->setAllowPromo(true);
                        }

                        if (!isset($params ['underage'])) {
                            $user_settings->setUnderage(false);
                        } else {
                            $user_settings->setUnderage(true);
                        }


                        $user_settings->save ();


                        // Subscribe to newsletter
                        $newsletters = NewsletterTable::retrieveActivePerCountryForUser($profile->getCountryId());
                        if ($newsletters) {
                            foreach ($newsletters as $newsletter) {
                                $usernewsletter = new NewsletterUser ();
                                $usernewsletter->setNewsletterId($newsletter->getId());
                                $usernewsletter->setUserId($profile->getId());
                                $usernewsletter->setIsActive($user_settings->getAllowContact());
                                $usernewsletter->save();
                            }

                            MC::subscribe_unsubscribe($user_register);
                        }

                        $user_register = $profile->getSfGuardUser ();
                        //$user_register->addDefaultPermissionsAndGroups ( array ('user' ), array () );

                        $this->__associatedFriends($profile);

                        $con->commit ();
                    } catch ( Exception $e ) {
                        $con->rollback ();

                        $this->getUser ()->setFlash ( 'error', 'We were unable to send a confirmation request to the email address that you provided. Please check the email you provided is correct.' );
                        return sfView::SUCCESS;

                    }
                    $this->getUser()->signIn($user_register);
                    $this->user = $this->getUser()->getGuardUser();
                    $culture = $this->getUser ()->getCulture ();

                    myTools::sendMail ( $user_register, 'Welcome to getlokal', 'activation', array ('user' => $user_register ) );
                    $i18n = sfContext::getInstance ()->getI18N ();
                    $this->getUser()->setAttribute('home.notice',
                        $i18n->__('<p class="part_one"><span class="greet">Congrats</span> you are our newest registered user.</p><p class="part_two"> Now you can tell everyone about the great places only you know!</p>',null,'user'));
                }
            }

            
            if ($this->getUser()->hasAttribute('my_token') && $this->getUser()->getAttribute('my_token')){
                $this->form->addCSRFProtection($this->getUser()->getAttribute('my_token'));
            }
            
            if ($this->form->isValid () && ($this->getUser ()->isAuthenticated () || isset ( $user_register ))) {
                if($this->user->getUserProfile()->getIsCompanyAdmin ( $this->company )){
                    $this->getUser ()->setFlash ( 'error', 'You are already an administrator for this place and cannot write reviews for it but only reply to reviews by other users about your place.' );
                }
                else{                	
                    $this->getUser()->setAttribute('my_token', null);

                    $review = $this->form->updateObject ();
                    if (isset ( $user_register )) {
                        $review->setUserId ( $user_register->getId () );
                    } else {
                        $review->setUserId ( $this->getUser ()->getId () );
                    }

                    $review->setCompanyId ( $this->company->getId () );
					if(is_object($user)){
                    	$this->_sendEmailAfterReview($user, $reviewData['text']);
					}
                    
                    $review->save ();
                
                    $this->getUser ()->setFlash ( 'notice', 'Your review was published successfully.' );
                    
                    $this->redirect ( $this->company->getUri () );
                }
            }
            else {
            	if (!$this->getUser()->hasAttribute('my_token') || $this->getUser()->getAttribute('my_token', false))
                {
                    $this->getUser()->setAttribute('my_token', $this->form->getValue('_csrf_token'));
                }                
                $this->getUser ()->setFlash ( 'error', 'Your review was not published successfully.' );
            }

        //$this->redirect ( $this->company->getUri ().'#add_review_container' );

        }

        $query = Doctrine::getTable ( 'Review' )->createQuery ( 'r' )->
        innerJoin ( 'r.Company c WITH c.id = ?', $this->company->getId () )->
        innerJoin ( 'r.UserProfile p' )->
        innerJoin ( 'p.sfGuardUser sf' )->
        leftJoin ( 'p.Image im' )->
        //->leftJoin('a.UserLike l WITH l.user_id = ?', $this->getUser()->getId())
        leftJoin ( 'r.Review rr' )->
        where ( 'r.is_published = ?', Review::FRONTEND_REVIEWS_IS_PUBLISHED )->
        addWhere ( 'r.parent_id IS NULL' )->
        //->addWhere( 'sf.is_active=1')
        orderBy ( 'r.created_at DESC' );
        $this->page = $request->getParameter ( 'page', 1 );
        $this->pager = new sfDoctrinePager ( 'Review', Review::FRONTEND_REVIEWS_PER_TAB );
        $this->pager->setQuery ( $query );
        $this->pager->setPage ( $this->page );
        $this->pager->init ();
        if ($this->page > 1) {
            $i18n = sfContext::getInstance ()->getI18N ();
            $request->setParameter ( 'no_location', true );
            $this->getResponse ()->setTitle ( sprintf ( $i18n->__ ( '%s, %s - reviews and ratings from customers', null, 'pagetitle' ), $this->company->getCompanyTitle (), $this->company->getCity ()->getLocation () ) );
        }
        $this->reviews = $this->_getCompanyReviews($this->company->getId(), 1);
        $this->events = $this->_getCompanyEvents($this->company->getId(), 1);
        $this->lists = $this->_getCompanyLists($this->company->getId(), 1);
        if(!$this->company->getActivePPPService(true)){
        	$this->setTemplate('pp');
        }else{
        	$this->setTemplate('ppp');
        }
    }
    
    protected function _sendEmailAfterReview($user, $reviewText){
    	$to = $user->getEmailAddress();
    	$name = $user->getFirstName()." ".$user->getLastName();
    	$companyTitle = $this->company->getTitle();
    	
    	$similar_places = $this->company->getSimilarPlaces();
    	sfContext::getInstance()->getConfiguration()->loadHelpers('tag');
    	sfContext::getInstance()->getConfiguration()->loadHelpers('url');
    	$similarCompanies = array();
    	foreach($similar_places as $sub_similar_places){
    		foreach($sub_similar_places as $splace){
    			//$similarCompanies[] = link_to($splace->getCompanyTitle(), $splace->getUri('esc_raw'), array(), true );
    			$similarCompanies[] = '<a href="'.url_for($splace->getUri('esc_raw'), true ).'" target="blank">'.$splace->getCompanyTitle().'</a>';
    		}
    	}
    	array_unique($similarCompanies);
    	$companies = array_slice($similarCompanies, 0, 5);
    	$sSimilarCompanies = implode(', ', $companies);
    	$country_name = mb_strtolower($user->getCountry()->getNameEn(), 'utf-8');
    	switch ($user->getCountry()->getSlug()){
    		case 'bg' : 
    			$from = $country_name.'@getlokal.com';
    			$subject = $name.', благодарим за оставеното ревю за '.$companyTitle.' в Getlokal';
    			$text = 'Здравей '.$name.', благодарим за оставеното ревю за '.$companyTitle.' в Getlokal, "'.$reviewText.'". Увеличи шансовете си да спечелиш Samsung таблет или почивка за двама и напиши още ревюта за '.$sSimilarCompanies; 
    		break;
    		case 'sr' : 
    			$from = $country_name.'@getlokal.rs';
    			$subject = $name.', hvala za preporuku za '.$companyTitle.' na Getlokal';
    			$text = 'Zdravo '.$name.', hvala za preporuku za '.$companyTitle.'na Getlokal, "'.$reviewText.'". Povećaj šanse da osvojiš iPhone 6 ili putovanje tako što ćeš preporučiti još mesta: '.$sSimilarCompanies; 
    		break;
    		case 'ro' : 
    			$from = $country_name.'@getlokal.ro';
    			$subject = $name.', mulțumim pentru publicarea recomandării  la '.$companyTitle.' pe Getlokal';
    			$text = 'Bună '.$name.', mulțumim pentru publicarea recomandării "'.$reviewText.'" la '.$companyTitle.' pe Getlokal. Îți poți crește șansele la premiile puse în joc, dacă ne dai de veste și cum ți s-a părut la '.$sSimilarCompanies; 
    		break;
    		case 'mk' : 
    			$from = $country_name.'@getlokal.mk';
    			$subject = $name.', ти благодариме за препораката за '.$companyTitle.' на Getlokal';
    			$text = 'Здраво '.$name.', ти благодариме за препораката за '.$companyTitle.' на Getlokal, "'.$reviewText.'". Зголеми ги шансите за да освоиш патување и напиши уште препораки за '.$sSimilarCompanies;
    		break;
    	}
    	//echo $text;    	 die;
    	$message = Swift_Message::newInstance()
    	->setSubject($subject)
    	->setFrom($from)
    	->setTo($to)
    	->setBody(strip_tags($text))
    	->addPart($text, 'text/html');

    	try
    	{
    		sfContext::getInstance()->getMailer()->send($message);
    	}
    	catch (Exception $e)
    	{
    		sfContext::getInstance()->getUser()->setFlash('error', 'The email could not be sent.');
    	}
    }

        /*
    public function executeFBLogin(sfWebRequest $request) {
        $app_id = "289748011093022";
        $app_secret = "517d65d2648bf350bb303914cb0ec664";

        //$app_id = "375081614838";
        //$app_secret = "3a207c2ee149b63e2bdf8f8b44a2fcea";


        $my_url = $this->generateUrl ( 'default', array ('module' => 'company', 'action' => 'FBLogin' ), true );

        $code = $request->getParameter ( 'code' );

        if (empty ( $code )) {
            $dialog_url = "http://www.facebook.com/dialog/oauth?client_id=" . $app_id . "&redirect_uri=" . urlencode ( $my_url ) . '&scope=user_location,email,user_birthday,offline_access,user_checkins';

            $this->redirect ( $dialog_url );
        }

        $token_url = "https://graph.facebook.com/oauth/access_token?client_id=" . $app_id . "&redirect_uri=" . urlencode ( $my_url ) . "&client_secret=" . $app_secret . "&code=" . $code;

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $token_url );
        curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_AUTOREFERER, true );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false ); # required for https urls


        $access_token = curl_exec ( $ch );

        curl_setopt ( $ch, CURLOPT_URL, "https://graph.facebook.com/me?" . $access_token );

        $user_data = json_decode ( curl_exec ( $ch ), true );
        if (isset($user_data ['id']) && $user_data ['id'] )
        {
          $profile = Doctrine::getTable ( 'UserProfile' )->findOneByFacebookUid ( $user_data ['id'] );
        }
        if (! $profile) {
            if (! $user = Doctrine::getTable ( 'sfGuardUser' )->findOneByEmailAddress ( $user_data ['email'] )) {
                curl_setopt ( $ch, CURLOPT_URL, "https://graph.facebook.com/me/picture?type=large&" . $access_token );

                $temp_pic = sfConfig::get ( 'sf_upload_dir' ) . '/' . uniqid ( 'tmp_' ) . '.jpg';
                file_put_contents ( $temp_pic, curl_exec ( $ch ) );

                $file = new sfValidatedFile ( myTools::cleanUrl ( $user_data ['name'] ) . '.jpg', filetype ( $temp_pic ), $temp_pic, filesize ( $temp_pic ) );

                $password = $this->generatePassword ();

                $user = new sfGuardUser ();
                $user->setEmailAddress ( $user_data ['email'] );
                $user->setUsername ( substr ( uniqid ( md5 ( rand () ), true ), 0, 8 ) );
                $user->setFirstName ( $user_data ['first_name'] );
                $user->setLastName ( $user_data ['last_name'] );
                $user->setPassword ( $password );
                $user->save ();

                $date = DateTime::createFromFormat ( 'm/d/Y', $user_data ['birthday'] );

                                $fbUserCity = array_shift(explode(',', $user_data['location']['name']));

                $city = Doctrine::getTable ( 'City' )->createQuery ( 'c' )->innerJoin ( 'c.County co' )->addWhere ( 'co.country_id = ?', getlokalPartner::getInstance () )->andWhere ( 'c.name LIKE ? or c.slug LIKE ? OR c.name_en LIKE ?', array ($fbUserCity, $fbUserCity, $fbUserCity ) )->fetchOne ();

                $profile = new UserProfile ();
                if ($city) {
                    $profile->setCityId ( $city->getId () );
                    $country_id = $city->getCounty ()->getCountryId ();
                    $profile->setCountryId ( $country_id );
                } else {
                    $profile->setCountryId ( getlokalPartner::getInstance () );
                    $city = Doctrine::getTable ( 'City' )->createQuery ( 'c' )->innerJoin ( 'c.County co' )->where ( 'co.country_id = ?', getlokalPartner::getInstance () )->orderBy ( 'c.is_default DESC' )->limit ( 1 )->fetchOne ();
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
                $image->save ();

                $profile->clearRelated ();
                $profile->setImageId ( $image->getId () );
                $profile->save ();

                @unlink ( $temp_pic );

                myTools::sendMail ( $user, 'Welcome to getlokal', 'fbRegister' );
            } else {
                $profile = $user->getUserProfile ();
            }

            $profile->setAccessToken ( $access_token );
            $profile->setFacebookUid ( $user_data ['id'] );
            $profile->save ();
        }else {
            if(!$profile->getCountryId()) $profile->setCountryId($this->getUser()->getCountry()->getId());
            if(!$profile->getCityId()) $profile->setCityId($this->getUser()->getCity()->getId());
            $profile->save ();
        }

        $this->getUser ()->signIn ( $profile->getSfGuardUser (), true );

        $this->redirect ( $this->getUser ()->getReferer () );
    }
    */

    protected function generatePassword() {
        $salt = "abchefghjkmnpqrstuvwxyz0123456789";
        $pass = '';
        srand ( ( double ) microtime () * 1000000 );
        $i = 0;
        while ( $i <= 7 ) {
            $num = rand () % 33;
            $tmp = substr ( $salt, $num, 1 );
            $pass = $pass . $tmp;
            $i ++;
        }

    }

    public function executeEvents(sfWebRequest $request)
    {
        // $this->configShow($request);
        // we only need company info here not all variables
        $this->configCompany($request);

        $date = date('Y-m-d');

        if ($this->getContext()->getRouting()->getCurrentRouteName() == 'company_events')
        {
            $this->openTab = 'tab1';
        }

        $this->past = $request->getParameter('past', false);
        if ($this->past === 'false')
        {
            $this->past = false;
        }

        $query = Doctrine::getTable('Event')->createQuery('e')
            ->innerJoin('e.Translation t')
            ->innerJoin('e.EventPage ep')
            ->where('ep.page_id =  ?', $this->company->getCompanyPage()->getId())
            ->andWhere('e.is_active = 1');

        $this->all_events = $query->count();
        if ($request->getParameter('ppp', false))
        {
            $this->future_events = EventTable::applyFutureFilter($query->copy())->count();
            $this->past_events = EventTable::applyPastFilter($query->copy())->count();
        }

        if ($this->past)
        {
            $query = EventTable::applyPastFilter($query);
        }
        else
        {
            $query = EventTable::applyFutureFilter($query);
        }

        $query->innerJoin('e.UserProfile p')->innerJoin('p.sfGuardUser sf');

        $this->pager = new sfDoctrinePager('Event', Event::EVENTS_PER_PAGE);
        $this->pager->setQuery($query);
        $this->pager->setPage($request->getParameter('page', 1));
        $this->pager->init();

        if ($template = $request->getParameter('template', false)) {
            if ($template != 'customEvent') {
                $template = 'customEvent';
            }

            $this->setTemplate($template);
        }
    }

    public function executeLists(sfWebRequest $request) {
        //$this->configShow ( $request );


        $query = Doctrine::getTable ( 'Lists' )->createQuery ( 'l' )->innerJoin ( 'l.UserProfile p' )->innerJoin ( 'p.sfGuardUser sf' )->innerJoin ( 'l.ListPage lp' )->where ( 'lp.page_id = ?', $request->getParameter ( 'pageId' ) )->orderBy ( 'l.created_at DESC' );

        $this->pager = new sfDoctrinePager ( 'Lists', UserProfile::FRONTEND_EVENTS_PER_TAB );
        $this->pager->setQuery ( $query );
        $this->pager->setPage ( $request->getParameter ( 'page', 1 ) );
        $this->pager->init ();

        $this->page_id = $request->getParameter ( 'pageId' );
    }
    public function executeListsPPP(sfWebRequest $request) {
        //$this->configShow ( $request );


        $query_lists = Doctrine::getTable ( 'Lists' )
        ->createQuery ( 'l' )
        ->innerJoin('l.Translation lt')
        ->innerJoin ( 'l.ListPage lp' )
        ->where ( 'lp.page_id = ?', $request->getParameter ( 'pageId' ) )
        ->andWhere('l.is_active = 1')
        ->orderBy ( 'l.created_at DESC' );

        $this->lists = $query_lists->execute();
    }

    public function executeAddToList(sfWebRequest $request) {

        $this->forward404Unless ( $this->company = Doctrine::getTable ( 'Company' )->find ( $request->getParameter ( 'id' ) ) );

        $this->form = new ListCompanytForm(null, array('page_id'=>$this->company->getCompanyPage()->getId() ) );
        $this->template = $request->getParameter ( 'type' );
        $this->page_id = $this->company->getCompanyPage()->getId();
        $this->company_id = $request->getParameter ( 'id' );
    }

    public function executeInfo(sfWebRequest $request) {
        $this->configShow ( $request );
        $i18n = sfContext::getInstance ()->getI18N ();
        $request->setParameter ( 'no_location', true );
        $this->getResponse ()->setTitle ( sprintf ( $i18n->__ ( '%s, %s - detailed information', null, 'pagetitle' ), $this->company->getCompanyTitle (), $this->company->getCity ()->getLocation () ) );

    }
    public function executeDetail(sfWebRequest $request) {
        $this->redirect ( '@company_detail?slug=' . $request->getParameter ( 'slug' ) . '&city=' . $request->getParameter ( 'city' ), 301 );

    }

    public function executeRedirectTo(sfWebRequest $request) {
        $this->configCompany ( $request );

        if ($this->company->getActivePPPService (true)) {
            CompanyStatsTable::saveStatsLog ( sfConfig::get ( 'app_log_actions_weblink_clicked' ), $this->company->getId () );
        }
        return true;
    }

    public function executeRedirectToFacebook(sfWebRequest $request) {

        $this->configCompany ( $request );

        if ($this->company->getActivePPPService (true)) {
            CompanyStatsTable::saveStatsLog ( sfConfig::get ( 'app_log_actions_facelink_clicked' ), $this->company->getId () );

        }
        return true;
    }

    public function executeRedirectToTwitter(sfWebRequest $request) {

        $this->configCompany ( $request );

        if ($this->company->getActivePPPService (true)) {
            CompanyStatsTable::saveStatsLog ( sfConfig::get ( 'app_log_actions_tweetlink_clicked' ), $this->company->getId () );
        }

        return true;
    }

    public function executeRedirectToFoursquare(sfWebRequest $request) {

        $this->configCompany ( $request );

        if ($this->company->getActivePPPService (true)) {
            CompanyStatsTable::saveStatsLog ( sfConfig::get ( 'app_log_actions_fsqlink_clicked' ), $this->company->getId () );
        }

        return true;
    }

    public function executeRedirectToGooglePlus(sfWebRequest $request) {

        $this->configCompany ( $request );

        if ($this->company->getActivePPPService (true)) {
            CompanyStatsTable::saveStatsLog ( sfConfig::get ( 'app_log_actions_gpluslink_clicked' ), $this->company->getId () );
        }

        return true;
    }

    public function executeRedirectToYellowPagesRS(sfWebRequest $request) {

        $this->configCompany ( $request );

        if ($this->company->getActivePPPService (true)) {
            CompanyStatsTable::saveStatsLog ( sfConfig::get ( 'app_log_actions_yplink_clicked' ), $this->company->getId () );
        }

        return true;
    }

    public function executeSendMailTo(sfWebRequest $request) {
        $this->configShow ( $request );

        $this->form = new ContactForm ( null, array ('company' => $this->company ) );

        $i18n = sfContext::getInstance ()->getI18N ();

        if ($request->isMethod ( 'post' )) {

            $params = $request->getParameter ( $this->form->getName (), array () );
            $this->form->bind ( $request->getParameter ( $this->form->getName () ) );

            if ($this->form->isValid ()) {
                myTools::sendMailToCompany ( $this->company, 'Request through getlokal', 'sendMail', array ('user_data' => $params ));
                if ($this->company->getActivePPPService (true)) {
                    CompanyStatsTable::saveStatsLog ( sfConfig::get ( 'app_log_actions_send_email' ), $this->company->getId () );
                }

            }

        }

        if ($this->form->isValid() && $request->getParameter('getFlashOnly', false)) {
            $response = array('success' => $this->form->isValid(), 'html' => $i18n->__($this->getUser()->getFlash('notice', false)));

            // Bug fix
            $this->getUser()->setFlash('notice', null);
        }
        else {
            $html = $this->getPartial('sendMailToSuccess', array('company' => $this->company, 'form' => $this->form));
            $response = array('success' => false, 'html' => $html);
        }

        $this->getResponse ()->setTitle ( sprintf ( $i18n->__ ( 'send email to %s', null, 'company' ), $this->company->getCompanyTitle () ) );
        return $this->renderText(json_encode($response));
    }

    public function executeAddImage(sfWebRequest $request) {
    	ob_clean();
    	
        $this->forward404Unless ( $this->company = Doctrine::getTable ( 'Company' )->find ( $request->getParameter ( 'id' ) ) );
        $this->company->setUser ( $this->getUser () );
        $this->form = new ImageForm ();
        $this->ajaxValidation = $request->getParameter('ajaxValidation', false);
        


        if ($request->isMethod ( 'post' )) {
            $this->form->bind ( $request->getParameter ( $this->form->getName () ), $request->getFiles ( $this->form->getName () ) );

            
            if ($this->form->isValid ()) {
                $photo = new Image ();
                $photo->setFile ( $this->form->getValue ( 'file' ) );
                $photo->setCaption ( $this->form->getValue ( 'caption' ) );
                $photo->setUserId ( $this->getUser ()->getId () );
                $photo->setStatus ( 'approved' );
                $photo->setType ( 'company' );
                $photo->save ();

                $company_image = new CompanyImage ();
                $company_image->setImageId ( $photo->getId () );
                $company_image->setCompanyId ( $this->company->getId () );
                $company_image->save ();

                if (! $this->company->getImageId ()) {
                    $this->company->setImageId ( $photo->getId () );
                    $this->company->save ();
                }

                $this->getUser()->setFlash ( 'noticeImg', 'The photo was published successfully.' );
                //$this->setTemplate('abuse');

                if ($request->isXmlHttpRequest()) {
                    return $this->renderText(json_encode(array('success' => true, 'redirectURL' => $this->generateUrl('company', array('slug' => $this->company->getSlug(), 'city' => $this->company->getCity()->getSlug()), true))));
                }

                $this->redirect ( '@company?slug=' . $this->company->getSlug () . '&city=' . $this->company->getCity ()->getSlug () );
            }
            else {
                $i18n = sfContext::getInstance()->getI18N();
                if(myTools::isExceedingMaxPhpSize()){
                    return $this->renderText(json_encode(array('error' => true, 'errors' => array('file' => $i18n->__('File size limit is 4MB.Please reduce file size before submitting again.', null, 'form')))));
                }
                if ($request->isXmlHttpRequest()) {
                    // $i18n = sfContext::getInstance()->getI18N();
                    $errors = array();

                    foreach($this->form->getErrorSchema()->getErrors() as $field => $error) {
                        $errors[$field][] = $i18n->__($error->__toString(), null, 'form');
                    }

                    return $this->renderText(json_encode(array('error' => true, 'errors' => $errors)));
                }
            }
        }
    }
    
    public function executeClaim(sfWebRequest $request) {

        $uri = $request->getUri();
        if(!$this->getUser()->isAuthenticated())
        {
          $this->getUser()->setAttribute('claim.referer', $uri);
          $this->redirect('user/signin');
        }

        $this->user = $this->getUser ()->getGuardUser ();

        $query = Doctrine::getTable ( 'Company' )->createQuery ( 'c' )->innerJoin ( 'c.City l' )->leftJoin ( 'c.CompanyDetail d' )->where ( 'c.slug = ?', $request->getParameter ( 'slug' ) );
        $this->forward404Unless ( $this->company = $query->fetchOne () );
        $this->company->setUser ( $this->getUser () );
        $profile = $this->user->getUserProfile ();
        $page = $this->page = $this->company->getCompanyPage ();
        if (! $page) {
            $page = new CompanyPage ();
            $page->setCompany ( $this->company );
            $page->setIsPublic ( 0 );
            $page->setCountryId ( $this->company->getCity ()->getCounty ()->getCountryId () );
            $page->save ();
        }
        $q = Doctrine::getTable ( 'PageAdmin' )->createQuery ( 'p' )->where ( 'p.page_id = ?', $page->getId () )->addWhere ( 'p.user_id = ?', $this->user->getId () );
        $this->pageAdmin = $q->fetchOne ();

        if ($this->pageAdmin) {
            if ($this->pageAdmin->getStatus () == 'rejected') {
                $this->setTemplate ( 'rejectedclaim' );
            } elseif ($this->pageAdmin->getStatus () == 'pending') {
                $this->setTemplate ( 'pendingclaim' );
            } elseif ($this->pageAdmin->getStatus () == 'approved') {
                $this->redirect ( 'company/thankyouclaim' );
            }
        } elseif (! $this->pageAdmin) {
            $this->pageAdmin = new PageAdmin ();
            $this->pageAdmin->setUserProfile ( $profile );
            $this->pageAdmin->setCompanyPage ( $page );
        }

        $this->form = new PageAdminForm ( $this->pageAdmin );

        if ($request->isMethod ( 'post' )) {
            $this->form->bind ( $request->getParameter ( $this->form->getName () ) );

            if ($this->form->isValid ()) {
                $con = Doctrine::getConnectionByTableName ( 'sfGuardUser' );

                $params = $request->getParameter ( $this->form->getName () );

                $userAdmin = $this->form->updateObject ();

                $profile = $this->form->getEmbeddedForm ( 'user_profile' )->getObject ();
                $userSetting = $profile->getUserSetting ();
                if (! $profile->getIsPageAdminConfirmed ()) {
                    $allow_b_cmc = false;
                    if (isset ( $params ['allow_b_cmc'] )) {
                        $allow_b_cmc = true;
                    }
                }
                try {

                    $userAdmin->save ();
                    $profile->save ();
                    if (isset ( $allow_b_cmc )) {
                        $userSetting->setAllowBCmc ( $allow_b_cmc );
                        $userSetting->save ();
                    }

                } catch ( Exception $e ) {
                    $con->rollback ();

                    $this->getUser ()->setFlash ( 'error', 'We were unable to process your request. Place administration process failed.' );
                    return sfView::SUCCESS;

                }
                if ($page->getPrimaryAdmin () && ($page->getPrimaryAdmin()->getId() != $userAdmin->getId ())) {
                    $userAdmin->setIsPrimary ( false );
                    $userAdmin->save ();
                } else {

                    $new_reg_no = null;
                    if (isset ( $params ['registration_no'] ) && $params ['registration_no'] != $this->company->getRegistrationNo ()) {
                        $new_reg_no = $params ['registration_no'];

                        if($this->company->getRegistrationNo() == NULL || $this->company->getRegistrationNo() == ''){
                            $this->company->setRegistrationNo($new_reg_no);
                            $this->company->save();
                        }
                    }

                    myTools::sendMail ( null, 'Claim Request', 'companyClaim', array ('pageAdmin' => $userAdmin, 'new_registration_no' => $new_reg_no ) );

                }
                if (isset ( $allow_b_cmc )) {
                    $newsletters = NewsletterTable::retrieveActivePerCountry ( $userAdmin->getUserProfile ()->getCountryId (), 'business' );
                    if ($newsletters) {
                        foreach ( $newsletters as $newsletter ) {
                            $newsletter_user = NewsletterUserTable::getPerUserAndNewsletter ( $this->user->getId (), $newsletter->getId () );
                            if (! $newsletter_user) {
                                $newsletter_user = new NewsletterUser ();
                                $newsletter_user->setNewsletterId ( $newsletter->getId () );
                                $newsletter_user->setUserId ( $profile->getId () );
                            }
                            if (isset ( $params ['allow_b_cmc'] )) {

                                $newsletter_user->setIsActive ( 1 );
                            } else {
                                $newsletter_user->setIsActive ( 0 );
                            }
                            $newsletter_user->save ();
                        }

                                                MC::subscribe_unsubscribe($this->user);
                    }
                }

                if (!$userAdmin->getIsPrimary ()) {
                    $primaryAdmin = $this->company->getPrimaryAdmin ();

                    if ($primaryAdmin) {

                        $name = Doctrine::getTable('SerbianNames')
                        ->createQuery ( 'sn' )
                        ->where('name = ?', $primaryAdmin->getUserProfile()->getFirstName())
                        ->fetchOne();

                        if ($name){
                            $first_name =  $name->getSuffix();
                        } else{
                            $first_name =  $primaryAdmin->getUserProfile()->getFirstName();
                        }

                        myTools::sendMail ($primaryAdmin->getUserProfile (), 'Place Claim in getlokal', 'claimRequest', array ('pageAdmin' => $primaryAdmin, 'userAdmin' => $userAdmin, 'firstName' => $first_name ) );
                    }
                }
                $msg = array ('user' => $this->user, 'object' => 'place_admin', 'action' => 'claimRequest', 'object_id' => $userAdmin->getId () );
                $this->dispatcher->notify ( new sfEvent ( $msg, 'user.write_log' ) );
                $this->getUser ()->setFlash ( 'notice', 'Your claim was submitted successfully!' );

                $this->redirect ( 'company/thankyouclaim' );
            }
        }

        $i18n = sfContext::getInstance ()->getI18N ();
        breadCrumb::getInstance()->removeRoot();
        breadCrumb::getInstance()->add($i18n->__('Claim Your Company', null, 'company'));
    }

    public function executeThankyou(sfWebRequest $request) {
        //$this->configShow ( $request );
    }
    public function executeThankyouclaim(sfWebRequest $request) {
        //$this->configShow ( $request );
    }

    public function executeAddNewCompany(sfWebRequest $request) {
        $this->user = $this->getUser ()->getGuardUser ();
        $this->classification_id = $this->sector_id = null;
        $this->company = new Company ();
        $this->company->setUser ( $this->getUser () );
        $this->form = new newCompanyForm ( $this->company, array ('user' => $this->user ) );
        if ($request->isMethod ( 'post' )) {

            sfContext::getInstance ()->getConfiguration ()->loadHelpers ( 'Frontend' );
            $params = $request->getParameter ( $this->form->getName () );
            $params ['title'] = format_company_title ( $params ['title'] );
            if (! isset ( $params ['title'] ) or ($params ['title'] == '')) {
                $partner_class = getlokalPartner::getLanguageClass ();
                $params ['title'] = format_company_title ( call_user_func ( array ('Transliterate' . $partner_class, 'toLatin' ), $params ['title'] ) );
            } else {
                $params ['title'] = format_company_title ( $params ['title'] );
            }
            $params ['status'] = CompanyTable::VISIBLE;
            $cityname = $params ['city'];
            $city = Doctrine::getTable ( 'City' )->createQuery ( 'l' )->where ( 'l.name = ? OR l.slug= ?', array ($cityname, $cityname ) )->fetchOne ();
            if ($city) {
                if ($city->getId () != $params ['city_id']) {
                    $params ['city_id'] = $city->getId ();
                }
            }
            $this->form->bind ( $params );

            if ($this->form->isValid ()) {
              $company = $this->form->save ();

              $this->pageadmin = $this->user->getAllStatusCompanyAdmin($company);

                $this->getUser ()->setFlash ( 'notice', 'Your company information was saved successfully. It will be added to getlokal after it has been approved by an administrator.' );
                myTools::sendMail ( null, 'Claim Request', 'companyClaim', array ('pageAdmin' =>$this->pageadmin ) );
                $this->redirect ( 'company/thankyou' );
            } else {
                $this->classification_id = $params ['classification_id'];
                $this->sector_id = $params ['sector_id'];
                $this->lat = $params ['company_location'] ['latitude'];
                $this->long = $params ['company_location'] ['longitude'];

            }

        }
    }

    public function executeGetClassifiersAutocomplete(sfWebRequest $request) {
        $culture = $this->getUser ()->getCulture ();
        $this->getResponse ()->setContentType ( 'application/json' );

        $q = "%" . $request->getParameter ( 'term' ) . "%";
        $limit = $request->getParameter ( 'limit', 20 );

        $dql = Doctrine_Query::create ()->select ( 'id, t.title' )->from ( 'Classification c' )->innerJoin ( 'c.Translation t' )->where ( 't.title LIKE ? AND t.lang=? AND t.is_active = 0 AND c.status = 1', array ($q, $culture ) )->limit ( $limit );

        $this->rows = $dql->execute ();

        $classifiers = array ();

        if ($this->rows) {
         foreach ($this->rows as $row) {
                $classifiers [] = array('title' => $row ['title'], 'id' => $row ['id']);
        }
        }
        return $this->renderText ( json_encode ( $classifiers ) );

    }

    public function executeSelectClassification(sfWebRequest $request) {
        $this->forward404Unless ( $request->isXmlHttpRequest () );
        $form = new SectorClassificationForm ();
        return $this->renderPartial ( 'company/selectClassification', array ('form' => $form ) );
    }

  public function executeAutocomplete(sfWebRequest $request)
  { 
    if (!$cityId = $this->getUser()->getAttribute('add_company.cityId')) {
        $cityId = null;
    }

    if (!$countryId = $this->getUser()->getAttribute('registration_profile.countryId')) {
        $countryId = null;

    }
   
    $query = Doctrine::getTable('Company')
              ->createQuery('c')
            ->innerJoin('c.Translation ctr')
              ->where('ctr.title LIKE ?', '%'. $request->getParameter('term'). '%')
              // ->andWhere('c.country_id = ?', $this->getUser()->getCountry()->getId())
              // ->andWhere('c.city_id = ?', $cityId)
              ->andWhere('c.status = 0')
              ->limit(10);

    if ($cityId) {
        $query = $query->andWhere('c.city_id = ?', $cityId)->orderBy('ctr.title');
    }
    else{
        $query = $query->andWhere('c.country_id = ?', $countryId)->orderBy('ctr.title');
    }

    $return = array();
    $culture = sfContext::getInstance()->getUser()->getCulture();

    foreach($query->execute() as $company)
    {
      $return[] = array(
        'id'        => $company->getId(),
        'value'     => mb_convert_case($company->getCompanyTitleByCulture(), MB_CASE_TITLE, 'UTF-8'),
        'address'   => mb_convert_case($company->getCity()->getCityNameByCulture($culture) ? $company->getCity()->getCityNameByCulture($culture) : $company->getCityNameByCulture('en'), MB_CASE_TITLE, 'UTF-8'). ', ' .
                       mb_convert_case($company->getLocation()->getStreet(), MB_CASE_TITLE, 'UTF-8'). ' ' .
                       mb_convert_case($company->getLocation()->getStreetNumber(), MB_CASE_TITLE, 'UTF-8'),
        'sector_id' => $company->getSectorId(),
        'city'      => $company->getCity()->getName(),
        'city_id'   => $company->getCity()->getId(),
        'street_no' => $company->getLocation()->getStreetNumber(),
        'street'    => $company->getLocation()->getStreet(),
        'lat'       => $company->getLocation()->getLatitude(),
        'lng'       => $company->getLocation()->getLongitude(),
        'classification'    => $company->getClassification()->getTitle(),
        'classification_id' => $company->getClassificationId(),
      );
    }

    $this->getResponse()->setContent(json_encode($return));

    return sfView::NONE;
  }


  public function executeGetListsAutocomplete(sfWebRequest $request) {
    //$this->configShow($request);

    //print_r($request->getParameterHolder());exit();

    $culture = $this->getUser ()->getCulture ();
    $this->getResponse ()->setContentType ( 'application/json' );

    $q = "%" . $request->getParameter ( 'term' ) . "%";
    $limit = $request->getParameter ( 'limit', 20 );


    //print_r($request->getParameter ( 'pageId' ));exit();

    $dql = Doctrine::getTable ( 'Lists' )
    ->createQuery ( 'l' )
    ->select ( 'l.id, t.title' )
    ->innerJoin ( 'l.Translation t' )
   // ->where ( 't.title LIKE ? AND t.lang=? AND l.is_active = 1 AND l.is_open = 1 AND l.status = "approved" AND l.id not in ( select list_id from list_page  where page_id=?) ', array ($q, $culture, $request->getParameter ( 'pageId' ) ) )
    ->where ( 't.title LIKE ? AND l.is_active = 1 AND l.is_open = 1 AND l.status = "approved" AND l.id not in ( select list_id from list_page  where page_id=?) ', array ($q, $request->getParameter ( 'pageId' ) ) )
    ->groupBy('l.id')
    ->limit( $limit );

    //print_r($dql->getSqlQuery());exit();

    $this->rows = $dql->execute ();

    $lists = array ();
    
    if ($this->rows ) {
        foreach ($this->rows as $row) {
            $lists [] = array('value' => $row->getTitle(), 'id' => $row ['id']);
        }
    }
    return $this->renderText ( json_encode ( $lists ) );

  }

  public function executeAutocompleteClassification(sfWebRequest $request)
  {
    $query = Doctrine::getTable('Classification')
              ->createQuery('c')
              ->innerJoin('c.Translation t WITH t.lang = ?', $this->getUser()->getCulture())
              ->innerJoin('c.PrimarySector s')
              ->innerJoin('s.Translation st WITH st.lang = ?', $this->getUser()->getCulture())
              ->where('t.title LIKE ?', '%'. $request->getParameter('term'). '%')
              ->orWhere('st.title LIKE ?', '%'. $request->getParameter('term'). '%')
              ->orderBy('LENGTH(t.title)');
              

    $return = array();
    foreach($query->execute() as $classification)
    {
      $return[] = array(
        'value'     => $classification->getTitle(),
        'sector_id' => $classification->getSectorId(),
        'id'        => $classification->getId()
      );
    }

    $this->getResponse()->setContent(json_encode($return));

    return sfView::NONE;
  }

    public function executeAutocompleteCity(sfWebRequest $request)
      {
        $culture = $this->getUser ()->getCulture ();
        $query = Doctrine::getTable('City')
                  ->createQuery('c')
                  ->innerJoin('c.Translation ctr')
                  ->innerJoin('c.County co')
                  ->innerJoin('co.Translation cotr')
                  ->where('ctr.name LIKE ? ','%'. $request->getParameter('term'). '%')
                  ->andWhere('co.country_id = ?', getlokalPartner::getInstance())
                  ->limit(10);

        $return = array();
        foreach($query->execute() as $city)
        {

         $value = mb_convert_case($city->getCityNameByCulture($culture). ', '. $city->getCounty ()->getCountyNameByCulture($culture), MB_CASE_TITLE,'UTF-8');
         
          $return[] = array(
            'value' => $value,
            'id'    => $city->getId()
          );
        }

        $this->getResponse()->setContent(json_encode($return));

        return sfView::NONE;
      }

  public function executeAddCompany(sfWebRequest $request)
  {
   /* if($this->getUser()->isAnonymous())
    {
      $this->getUser()->setAttribute('local.referer', 'company/addCompany');
      $this->redirect('user/signin');
    }
*/

  //  $this->newCompany = $this->company;

//    $params['country_id'] = $this->getUser()->getCountry()->getId();

    // $this->getResponse()->setSlot('no_map', true);

    $this->user = $this->getUser ()->getGuardUser ();
    $this->company = new Company ();
    //$this->company->setUser ( $this->getUser () );
    $this->review = new Review();
    $this->profile = new UserProfile();
    $this->city = new City();

    $userCountry = myTools::getUserCountry();
    $required = false;

    $this->owner= false;
    if (strpos( $request->getReferer(),'/userSettings/')){
        $this->owner= true;
    }

    $this->form = new AddCompanyForm ($this->company ,array ('user' => $this->user ) );
    //$this->form = new newCompanyForm ();
    if ($request->isMethod ( 'post' ))
    {
        sfContext::getInstance()->getConfiguration()->loadHelpers('Frontend');
        $params = $request->getParameter ( $this->form->getName (), array() );

//        if($params['phone_number']!='') $params['phone'] = $params['phone_number'];
//        if (isset($params['ph'][0]) )  $params['phone'] = $params['ph'][0];
//        if (isset($params['ph'][1]) )  $params['phone1'] = $params['ph'][1];
//        if (isset($params['ph'][2]) )  $params['phone2'] = $params['ph'][2];

        if (isset($params['classification_list_id']) )  $params['classification_id'] = $params['classification_list_id'][0];

        if (isset($params['sector_list_id'])) $params['sector_id'] = $params['sector_list_id'][0];


        $positions = explode(',', $params['city']);

        $city = Doctrine::getTable ( 'City' )     
          ->createQuery ( 'l' )
          ->innerJoin('l.County co')
          ->innerJoin('l.Translation ct')
          ->where ( 'ct.name = ? OR l.slug= ?', array ($positions[0], $positions[0] ) )
//          ->andWhere( 'co.country_id = ?', $this->getUser()->getCountry()->getId() )
          ->andWhere( 'co.country_id = ?', ($params['country_id'] != '') ? $params['country_id'] : $this->getUser()->getCountry()->getId())
          ->fetchOne ();

        $geocode = $request->getParameter('geocode');

        if ($city)
        {
          $params ['city_id'] = $city->getId ();
          $params['country_id'] = $city->getCountry()->getId();
        }
        elseif(!$city && $params['city_id'] == '' && $geocode != '') //todo add geocode
        {
            $geocodeNonAssoc = explode(",", $geocode);
            $keys = array('lat', 'lng', 'city_en', 'county_en', 'country_en');
            $geocodeResults = array_combine($keys, $geocodeNonAssoc);

            $lat = $geocodeResults['lat'];
            $lng = $geocodeResults['lng'];
            $city_name_en = $geocodeResults['city_en'];
            $county_name_en = $geocodeResults['county_en'];
            $country_name_en = $geocodeResults['country_en'];
            $countryId = $params['country_id'];

            if($country_name_en != '' && $countryId == ''){
                $country = Doctrine::getTable('Country')
                            ->createQuery('c')
                            ->where('c.name = ? OR c.name_en = ?', array($country_name_en, $country_name_en))
                            ->fetchOne();

                if($country){
                    $countryId = $country->getId();
                    $params['country_id'] =  $countryId;
                }
            }

            if($county_name_en != '' && $countryId != ''){
                if($countryId == 3){
                    $countyId = 71;
                }
                else{
                    $county = Doctrine::getTable('County')
                            ->createQuery('c')
                            ->innerJoin('c.Translation ct')
                            ->where('ct.name = ? OR ct.name = ?', array($county_name_en, $county_name_en))
                            ->andWhere( 'c.country_id = ?', $countryId)
                            ->fetchOne();

                    if(!$county){
                        $county = new County();
                        $county->setCountryId($countryId);
                        $county->setSlug(CountyTable::slugify($county_name_en));
                        $county->setName($county_name_en);
                        $county->setLang('en');
                        $county->save();

                        $countyId = $county->getId();
                    }
                    else{
                        $countyId = $county->getId();
                    }
                }

               if($city_name_en != ''){

                    $city = Doctrine::getTable('City')
                        ->createQuery('c')
                        ->innerJoin('c.Translation ct')
                        ->innerJoin('c.County cot')
                        ->where('ct.name = ? OR ct.name = ?', array($city_name_en, $city_name_en))
                        ->andWhere( 'cot.country_id = ?', $countryId)
                        ->fetchOne();

                    if($city){
                        $params['city_id'] = $city->getId();
                    }
                    else{

                        $city = new City();
                        $city->setCountyId($countyId);
                        $city->setLat($lat);
                        $city->setLng($lng);
                        $city->setSlug(CityTable::slugify($city_name_en));
                        $city->setName($city_name_en);
                        $city->setLang('en');
                        $city->save();

                        $params['city_id'] = $city->getId();
                    }
                }
            }


        }
        else
        {
            $key = "AIzaSyDDZGSZsZTNuGUImUPcFXOEWObG6GX0I08";

            $address = urlencode($params['city']. ',' . $params['country']);
            $lang = 'en';

            $url = "http" . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . "://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&sensor=false&language=en";
            sfContext::getInstance()->getLogger()->emerg('GEOCODE: 19');

            $string = file_get_contents($url);
            $geocode = json_decode($string, true);
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0); //Change this to a 1 to return headers
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $results = curl_exec($ch);
            curl_close($ch);

            $city_name = $county_name = $city_name_en = $county_name_en = $country_name = $country_name_en = $countryId = '';

            if (isset($results[0]) && isset($geocode['results'][0]['address_components'])) {
                foreach ($geocode['results'][0]['address_components'] as $key => $val) {

                    switch ($val['types'][0]) {
                    case 'locality':
                        $city_name_en = $val['long_name'];

                    case 'administrative_area_level_1':
                        $county_name_en = $val['long_name'];
                        break;   

                    case 'administrative_area_level_2':
                        $county_name_en = $val['long_name'];
                        break;

                    case 'administrative_area_level_3':
                        $county_name_en = $val['long_name'];
                        break;

                    case 'country':
                        $country_name_en = $val['long_name'];
                        break;  
                    }
                }
            }

            $countryId = $params['country_id'];

            if($country_name_en != '' && $countryId == ''){
                $country = Doctrine::getTable('Country')
                            ->createQuery('c')
                            ->where('c.name = ? OR c.name_en = ?', array($country_name_en, $country_name_en))
                            ->fetchOne();

                if($country){
                    $countryId = $country->getId();
                    $params['country_id'] =  $countryId;
                }
            }

            foreach (getlokalPartner::getAllPartners() as $partner) {
                if($partner == $countryId){
                    $lang = getlokalPartner::getDefaultCulture($countryId);
                    break;
                }
            }

            if($lang != 'en'){
                $url = "http" . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . "://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&sensor=false&language=" . $lang;
                sfContext::getInstance()->getLogger()->emerg('GEOCODE: 19');

                $string = file_get_contents($url);
                $geocode = json_decode($string, true);
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HEADER, 0); //Change this to a 1 to return headers
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                $results = curl_exec($ch);
                curl_close($ch);

                if (isset($results[0]) && isset($geocode['results'][0]['address_components'])) {
                    foreach ($geocode['results'][0]['address_components'] as $key => $val) {

                        switch ($val['types'][0]) {
                        case 'locality':
                            $city_name = $val['long_name']; 

                        case 'administrative_area_level_1':
                            $county_name = $val['long_name'];
                            break;   

                        case 'administrative_area_level_2':
                            $county_name = $val['long_name'];
                            break;

                        case 'administrative_area_level_3':
                            $county_name = $val['long_name'];
                            break;

                        case 'country':
                            $country_name = $val['long_name'];
                            break;  
                        }
                    }
                }

                if($lang == 'sr'){
                    $partnerInstance = getlokalPartner::getInstance($lang);
                    $partnerClass = getlokalPartner::getLanguageClass($partnerInstance);

                    $city_name = call_user_func(array('Transliterate' . $partnerClass, 'toLatinSr'), $city_name);
                    $county_name = call_user_func(array('Transliterate' . $partnerClass, 'toLatinSr'), $county_name);
                }
            }

            if($county_name_en != '' && $countryId != ''){
                if($countryId == 3){
                    $countyId = 71;
                }
                else{
                    $county = Doctrine::getTable('County')
                            ->createQuery('c')
                            ->innerJoin('c.Translation ct')
                            ->where('ct.name = ? OR ct.name = ?', array(($county_name != '') ? $county_name : $county_name_en, $county_name_en))
                            ->andWhere( 'c.country_id = ?', $countryId)
                            ->fetchOne();

                    if(!$county){
                        $county = new County();
                        $county->setCountryId($countryId);
                        $county->setSlug(CountyTable::slugify($county_name_en));
                        $county->setName($county_name_en);
                        $county->setLang('en');
                        $county->save();

                        if($lang != 'en' && $county_name != ''){
                            $conn = Doctrine::getConnectionByTableName('county_translation');
                            $conn->execute('INSERT INTO county_translation(id, name, lang) VALUES("'.$county->getId().'", "'.$county_name.'", "'.$lang.'");');
                        }

                        $countyId = $county->getId();
                    }
                    else{
                        $countyId = $county->getId();
                    }
                }

               if($city_name_en != ''){

                    $city = Doctrine::getTable('City')
                        ->createQuery('c')
                        ->innerJoin('c.Translation ct')
                        ->innerJoin('c.County cot')
                        ->where('ct.name = ? OR ct.name = ?', array(($city_name != '') ? $city_name : $city_name_en, $city_name_en))
                        ->andWhere( 'cot.country_id = ?', $countryId)
                        ->fetchOne();

                    if($city){
                        $params['city_id'] = $city->getId();
                    }
                    else{
                        $lat = $geocode['results'][0]['geometry']['location']['lat'];
                        $lng = $geocode['results'][0]['geometry']['location']['lng'];

                        $city = new City();
                        $city->setCountyId($countyId);
                        $city->setLat($lat);
                        $city->setLng($lng);
                        $city->setSlug(CityTable::slugify($city_name_en));
                        $city->setName($city_name_en);
                        $city->setLang('en');
                        $city->save();

                        if($lang != 'en'){
                            $conn = Doctrine::getConnectionByTableName('city_translation');
                            $conn->execute('INSERT INTO city_translation(id, name, lang) VALUES("'.$city->getId().'", "'.$city_name.'", "'.$lang.'");');
                        }

                        $params['city_id'] = $city->getId();
                    }
                }
            }
        }

        $oldCulture = $this->getUser()->getCulture();

        $country = Doctrine::getTable('Country')->findOneById($params['country_id']);
        if($country){
            $slug = $country->getSlug();
            $this->getUser()->setCulture($this->getUser()->getCountry()->getSlug());
        } else {
            $slug = sfContext::getInstance()->getUser()->getCountry()->getSlug();
        }

        $params['lang'] = $slug;

        $culture = sfContext::getInstance()->getUser()->getCountry()->getSlug();
        $partner_class = getlokalPartner::getLanguageClass();

        $cultures = sfConfig::get('app_languages_'.$culture);

        $params [$slug]['title'] = format_company_title ( $params [$culture]['title']);

        if (! isset ( $params ['en']['title'] ) or ($params ['en']['title'] == '')) {

            if($userCountry['language'] == 'cyrillic' || $userCountry['language'] == 'other') {
                $required = true;
            }

            if(method_exists('Transliterate'.$userCountry['slug'], 'toLatin')){
                $params ['en']['title'] = format_company_title (call_user_func(array('Transliterate'.$partner_class, 'toLatin'),$params [$culture]['title']));
            }
            else{
                $params ['en']['title'] = transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', $params [$culture]['title']);
            }

            $params ['slug'] = Company::generateCompanySlug(myTools::cleanSlugString($params ['en']['title']));
        }
        else
        {
            $params ['en']['title'] = format_company_title ($params ['en']['title']);
            $params ['slug'] = Company::generateCompanySlug(myTools::cleanSlugString($params ['en']['title']));
        }

        if(count($cultures)>2){
            foreach($cultures as $language){
                if ($culture !='en' && $language != $culture){
                    $current_culture = $language;
                
                    if (! isset ( $params [$current_culture]['title'] ) || ($params [$current_culture]['title'] == '')) {
                        if(method_exists('Transliterate'.$partner_class, 'to'.$current_culture)){
                            $params [$current_culture]['title'] = format_company_title (call_user_func(array('Transliterate'.$partner_class, 'to'.$current_culture),$params [$culture]['title']));
                        }
                        else{
                            $params [$current_culture]['title'] = format_company_title ($params [$culture]['title']);
                        }
                    }
                    else{
                        $params [$current_culture]['title'] = format_company_title ($params [$current_culture]['title']);
                    }
                }
            }
        }

      /*
      $params [$culture]['title'] = format_company_title ( $params [$culture]['title']);

      if (! isset ( $params ['en']['title'] ) or ($params ['en']['title'] == '')) {
        $params ['en']['title'] = format_company_title (call_user_func(array('Transliterate'.$partner_class, 'toLatin'),$params [$culture]['title']));
        
        $params ['slug'] = Company::generateCompanySlug(myTools::cleanSlugString($params ['en']['title']));
      }
      else
      {
        $params ['en']['title'] = format_company_title ($params ['en']['title']);
        $params ['slug'] = Company::generateCompanySlug(myTools::cleanSlugString($params ['en']['title']));
      }

      
      if (! isset ( $params [$current_culture]['title'] ) or ($params [$current_culture]['title'] == '')) {
        $params [$current_culture]['title'] = format_company_title (call_user_func(array('Transliterate'.$partner_class, 'to'.$current_culture),$params [$culture]['title']));
      }
      else
      {
        $params [$current_culture]['title'] = format_company_title ($params [$current_culture]['title']);
      }
      
      */
      
      $params['status'] = CompanyTable::VISIBLE;

      // unset($params[$culture]);

      $this->form->bind ( $params );
      
       // PAGE ADMIN
    /*  if ( !isset($params['page_admin']) || $params['page_admin']['username'] =='' || $params['page_admin']['password'] =='' ) {
        $this->form->setOption('no_page_admin', true);
      }
    */
      if ($this->form->isValid () && $required == false)
      {
        $company = $this->form->save();
        //$company->save ();
        
        $classification = $params['classification_id'];

        if(isset($params['classification_list_id']) && $classification ==''){
            $classification = $params['classification_list_id'][0];
        }

        //Update Classification Translation 'number_of_places'
        $lang_array = getlokalPartner::getEmbeddedLanguages();

        foreach ($lang_array as $lang){
            if($lang !='en'){
                 $country_id = getlokalPartner::getInstance(getlokalPartner::getDefaultCulture());
                 $count_places  =  Doctrine::getTable('Company')
                        ->createQuery('c')
                        ->innerJoin('c.CompanyClassification cc')
                        ->addWhere('country_id = ? AND status = ? ', array($country_id, CompanyTable::VISIBLE))
                        ->andWhere('cc.classification_id = ? ', $classification)
                        ->count();

                 $count_places++;

                 $q = Doctrine_Query::create()
                        ->update('ClassificationTranslation')
                        ->set('number_of_places', $count_places)
                        ->where('id = ?', $classification)
                        ->andWhere('lang = ?', $lang)->execute();
             }
        }

        if(isset($params['classification_list_id'])){
            foreach ($params['classification_list_id'] as $key => $cls){
                if ($key>0){
                    $company_clas = new CompanyClassification();
                    $company_clas ->setCompanyId($company->getId());
                    $company_clas ->setClassificationId($cls);
                    $company_clas ->save();
                }
            }
        }
        $titles = Doctrine::getTable('CompanyTranslation')
            ->createQuery('ct')
            ->select('ct.title')
            ->where('ct.id=?', $company->getId())
            ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
            ->execute();
 
        foreach($titles as $title){
            
            if ($title['title'] == NULL || $title['title'] == '') {
                Doctrine::getTable('CompanyTranslation')
                ->createQuery('ct')
                ->select('ct.id')
                ->delete()
                ->where('ct.id = ?', $company->getId())
                ->where('ct.lang = ?', $title['lang'])
                //->addWhere('ct.title = ?', NULL)
               // ->orWhere('ct.title = ""')
                ->execute();
            }
        }

        if($this->getUser()->isAnonymous()){

            $place[] = $company->getId();

            if($this->getUser()->hasAttribute('added.companies')){
                $places = $this->getUser()->getAttribute('added.companies', array());
     
                if (!in_array($company->getId(), $places))
                {
                  array_push($places, $company->getId());
             
                  $this->getUser()->setAttribute('added.companies', $places);
                }
            }
            else{
                $this->getUser()->setAttribute('added.companies', $place);
            }

            $this->getUser()->setAttribute('not.logged', 'company/addCompany');
            
        }
        else{
            if(isset($params['page_admin']['username']) && $params['page_admin']['username'] != '' && $params['page_admin']['password'] != '' && $params['registration_no'] != ''){
                $user = $this->getUser()->getGuardUser();
                $reg_no = $params['registration_no'];

                myTools::sendMail ( null, 'Claim Request', 'addCompanyClaim', array (
                    'profile' => $user, 'reg_no' => $reg_no, 'user_data' => $params, 'company' => $this->company ) );
            }
            else{
                $page = $this->company->getCompanyPage ();

                $q = Doctrine::getTable ( 'PageAdmin' )
                                        ->createQuery ( 'p' )
                                        ->where ( 'p.page_id = ?', $page->getId () )
                                        ->addWhere ( 'p.user_id = ?', $this->getUser()->getGuardUser()->getId () );
                $pageAdmin = $q->fetchOne ();

                if($pageAdmin){
                    $pageAdmin->delete();
                }
            }
        }

        return $this->renderText(json_encode(array('response' => 'true', 'required' => $required, 'title' => $company->getTitle(), 'url' => 'http://'.$request->getHost().'/'.$oldCulture.'/'.
            $company->getCity()->getSlug().'/'.$company->getSlug())));

        // $this->setTemplate('thankyou');
      }
      else
      {
        $this->getUser ()->setFlash ( 'newerror', 'There is missing info and/or errors. Please check again!' );
         // $this->clear_class_id=true;
         // if ($params['classification_id'] !='' )  $params['classification_list_id'][0]=$params['classification_id'];
         // if ($params['sector_id'] != '') $params['sector_list_id'][0] = $params['sector_id'];
         // if ($params['classification'] != '' ) $params['classification_list_title']['0'] = $params['classification'] ;
         // if (isset($params['classification_list_id']) ) $this->classification_list_id = $params['classification_list_id'];
         // if (isset($params['classification_list_title']) ) $this->classification_list_title = $params['classification_list_title'];
         // if (isset($params['sector_list_id']) ) $this->sector_list_id = $params['sector_list_id'];
         // if (isset($params['ph']) )  $this->phone_list = $params['ph'];
         // if (!isset($params['ph']) && $params['phone_number']!='') $this->phone_number=$params['phone_number'] ;
      }

    }
   
    breadCrumb::getInstance()->removeRoot();
  }

    public function executeDeleteReview(sfWebRequest $request) {
        $this->user = $this->getUser ()->getGuardUser ();

        $query = Doctrine::getTable ( 'Review' )->createQuery ( 'r' )->where ( 'r.id = ?', $request->getParameter ( 'review_id' ) )->andWhere ( 'r.user_id = ?', $this->user->getId () );
        $this->forwardUnless ( $this->review = $query->fetchOne (), 'user', 'secure' );
        $this->review->getCompany ()->setUser ( $this->getUser () );

        $this->review->delete ();

        $company = Doctrine::getTable ( 'Company' )->find ( $request->getParameter ( 'company_id' ) );
        $this->getUser ()->setFlash ( 'notice', 'Review was deleted successfully.' );
        $this->redirect ( $company->getUri () );
    }

    public function executeVoteFeature(sfWebRequest $request) {
        $this->user = $this->getUser ()->getGuardUser ();
        $query = Doctrine::getTable ( 'PlaceFeature' )->createQuery ( 'pf' )->//->leftJoin('a.UserLike l WITH l.user_id = ?', $this->getUser()->getId())
where ( 'pf.page_Id = ? ', $request->getParameter ( 'page_id' ) )->andWhere ( 'pf.feature_id= ?', $request->getParameter ( 'feature_id' ) );

        if (! $this->placeFeature = $query->fetchOne ()) {
            $this->placeFeature = new PlaceFeature ();
            $this->placeFeature->setPageId ( $request->getParameter ( 'page_id' ) );
            $this->placeFeature->setFeatureId ( $request->getParameter ( 'feature_id' ) );
            $this->placeFeature->setVotedNo ( '0' );
            $this->placeFeature->setVotedYes ( '0' );
            $this->placeFeature->save ();
        }

        //$this->forward404Unless($this->activity = $query->fetchOne());


        //if (!$this->getUser()->isAuthenticated()){
        //$feature_ids = $this->getUser()->getAttribute('feature_ids', array());
        //if(in_array($this->placeFeature->getId(), $feature_ids) && !$this->getUser()->isAuthenticated()) return;
        //}
        $feature_vote = $this->getUser ()->getAttribute ( 'feature_vote', array () );

        $query = Doctrine::getTable ( 'PlaceFeatureVote' )->createQuery ( 'pfv' );
        if ($this->user) {

            $query->where ( 'pfv.user_id = ?', $this->user->getId () );
        } else {

            $query->where ( 'pfv.user_id IS NOT NULL' );
        }

        $query->andWhere ( 'pfv.place_feature_id = ?', $this->placeFeature->getId () );

        $vote = $query->fetchOne ();

        if ($vote && $this->user) {

            if ($request->getParameter ( 'vote' ) == 'yes' && $vote->getVote () == - 1) {
                $this->placeFeature->setVotedNo ( $this->placeFeature->getVotedNo () - 1 );
            } elseif ($request->getParameter ( 'vote' ) == 'no' && $vote->getVote () == 1) {
                $this->placeFeature->setVotedYes ( $this->placeFeature->getVotedYes () - 1 );
            } else
                return;
        }

        elseif (array_key_exists ( $this->placeFeature->getId (), $feature_vote ) && ! $vote && $this->user) {

            $query = Doctrine::getTable ( 'PlaceFeatureVote' )->createQuery ( 'pfv' )->where ( 'pfv.user_id IS NULL' )->andWhere ( 'pfv.place_feature_id = ?', $this->placeFeature->getId () )->andWhere ( 'pfv.vote = ?', $feature_vote [$this->placeFeature->getId ()] );
            $vote = $query->fetchOne ();

            $vote->setUserId ( $this->user->getId () );

            if ($request->getParameter ( 'vote' ) == 'yes' && $vote->getVote () == - 1) {
                $this->placeFeature->setVotedNo ( $this->placeFeature->getVotedNo () - 1 );
            } elseif ($request->getParameter ( 'vote' ) == 'no' && $vote->getVote () == 1) {
                $this->placeFeature->setVotedYes ( $this->placeFeature->getVotedYes () - 1 );
            } elseif ($request->getParameter ( 'vote' ) == 'yes' && $vote->getVote () == 1 || $request->getParameter ( 'vote' ) == 'no' && $vote->getVote () == - 1) {
                return;
            }
        } elseif (array_key_exists ( $this->placeFeature->getId (), $feature_vote ) && ! $vote && ! $this->user) {

            $query = Doctrine::getTable ( 'PlaceFeatureVote' )->createQuery ( 'pfv' )->where ( 'pfv.user_id IS NULL' )->andWhere ( 'pfv.place_feature_id = ?', $this->placeFeature->getId () )->andWhere ( 'pfv.vote = ?', $feature_vote [$this->placeFeature->getId ()] );
            $vote = $query->fetchOne ();

            if ($request->getParameter ( 'vote' ) == 'yes' && $vote->getVote () == - 1) {
                $this->placeFeature->setVotedNo ( $this->placeFeature->getVotedNo () - 1 );
            } elseif ($request->getParameter ( 'vote' ) == 'no' && $vote->getVote () == 1) {
                $this->placeFeature->setVotedYes ( $this->placeFeature->getVotedYes () - 1 );
            } elseif ($request->getParameter ( 'vote' ) == 'yes' && $vote->getVote () == 1 || $request->getParameter ( 'vote' ) == 'no' && $vote->getVote () == - 1) {
                return;
            }

        }

        elseif (! array_key_exists ( $this->placeFeature->getId (), $feature_vote )) {

            $vote = new PlaceFeatureVote ();
            if ($this->user) {
                $vote->setUserId ( $this->user->getId () );
            }
            $vote->setPlaceFeatureId ( $this->placeFeature->getId () );
        } else {
            return;
        }

        if ($request->getParameter ( 'vote' ) == 'yes') {
            $this->placeFeature->setVotedYes ( $this->placeFeature->getVotedYes () + 1 );
            $this->placeFeature->save ();
            $vote->setVote ( '1' );
        }
        if ($request->getParameter ( 'vote' ) == 'no') {
            $this->placeFeature->setVotedNo ( $this->placeFeature->getVotedNo () + 1 );
            $this->placeFeature->save ();
            $vote->setVote ( '-1' );
        }
        $vote->save ();
        //if (!$this->getUser()->isAuthenticated()){


        $feature_vote [$this->placeFeature->getId ()] = $vote->getVote ();
        $this->getUser ()->setAttribute ( 'feature_vote', $feature_vote );

        //}
    //$this->redirectUnless($request->isXmlHttpRequest(), $request->getReferer());


    }

    public function executeAddCrmCompany(sfWebRequest $request) {
        $this->company = new Company ();
        $this->company->setUser ( $this->getUser () );
        $this->form = new CRMCompanyForm ( $this->company, array (), false );

        if ($request->isMethod ( 'post' )) {

            $this->processForm ( $request, $this->form );

        }

    }
    protected function processForm(sfWebRequest $request, sfForm $form) {  
        $params = $request->getParameter ( $this->form->getName () );
        sfContext::getInstance ()->getConfiguration ()->loadHelpers ( 'Frontend' );
        $params ['title'] = format_company_title ( $params ['title'] );
        if (! isset ( $params ['title'] ) or ($params ['title'] == '')) {
            $partner_class = getlokalPartner::getLanguageClass ();
            $params ['title'] = format_company_title ( call_user_func ( array ('Transliterate' . $partner_class, 'toLatin' ), $params ['title'] ) );
        } else {
            $params ['title'] = format_company_title ( $params ['title'] );
        }
        $city = Doctrine::getTable ( 'City' )->findOneById ( $params ['city_id'] );
        $params ['country_id'] = $city->getCounty ()->getCountryId ();
        $this->form->bind ( $params );

        if ( $this->form->isValid ()) {
            $this->object = $this->form->save ();


        }

    }
        public function executeNotFound(sfWebRequest $request) {
            $this->getResponse ()->setStatusCode(410);
        }
public function executeAddOrEditCompany(sfWebRequest $request) { $this->getResponse()->setSlot('no_map', true);

        $this->form = new AddOrEditCompanyForm ();
        
        
      $culture = sfContext::getInstance()->getUser()->getCountry()->getSlug();

      $partner_class = getlokalPartner::getLanguageClass();
      
        if ($request->isMethod ( 'post' ))
    {
            sfContext::getInstance ()->getConfiguration ()->loadHelpers ( 'Frontend' );

            $params = $request->getParameter ( $this->form->getName () );
            $params [$culture]['title'] = format_company_title ( $params [$culture]['title'] );

            if (! isset ( $params [$culture]['title'] ) or ($params [$culture]['title'] == '')) {
                $partner_class = getlokalPartner::getLanguageClass ();
                $params [$culture]['title'] = format_company_title ( call_user_func ( array ('Transliterate' . $partner_class, 'toLatin' ), $params [$culture]['title'] ) );
            } else {
                $params [$culture]['title'] = format_company_title ( $params [$culture]['title'] );
            }
            
            $params ['status'] = CompanyTable::VISIBLE;
            $cityname = $params ['city'];
            $city = Doctrine::getTable ( 'City' )->createQuery ( 'l' )
                    ->innerJoin('l.Translation ct')
                    ->where ( 'ct.name = ? OR l.slug= ?', array ($cityname, $cityname ) )
                    ->fetchOne ();
            if ($city) {
                if ($city->getId () != $params ['city_id']) {
                    $params ['city_id'] = $city->getId ();
                }
            }

            $this->form->bind ( $params );

            if ($this->form->isValid ())
      {
                $company = $this->form->save();

                $this->getUser ()->setFlash ( 'notice', 'The place details were saved successfully.' );

                $this->redirect('company/thankyou');
            }

        }
        $request->setParameter ( 'no_location', true );
        $this->getResponse ()->setTitle ( 'Add Company' );
    }



    private function __getPoints($hash = null, $email = null, $facebookUID = null) {
        if (!$hash) return 0;

        $query = Doctrine::getTable('InvitedUser')
                ->createQuery('iu')
                ->where('iu.hash = ?', array($hash));

        if ($email) {
            $query->andWhere('iu.email = ?', array($email));
        }
        elseif ($facebookUID) {
            $query->andWhere('iu.email = ?', array($facebookUID));
        }

        $result = $query->fetchOne(array(), Doctrine_Core::HYDRATE_RECORD);
        if ($result) {
            return $result->getPointsToInvited();
        }
    }

    public function __associatedFriends($invitedUser) {
        if ($code = $this->getUser()->getAttribute('code', false)) {
            //$invitedUserTable = Doctrine::getTable('InvitedUser')->findOneByHash($code);

            $email = $invitedUser->getSfGuardUser()->getEmailAddress();
            $facebookUID = $invitedUser->getFacebookUid();
            $invitedUserTable = Doctrine::getTable('InvitedUser')
                    ->createQuery('iu')
                    ->where('iu.hash = ?', $code)
                    ->andWhere('iu.email = ? or iu.facebook_uid = ?', array($email, $facebookUID))
                    ->fetchOne();

            if ($invitedUserTable && $userWhoSentInvite = Doctrine::getTable('UserProfile')->findOneById($invitedUserTable->getUserId())) {
                $points = $userWhoSentInvite->getPoints() + $invitedUserTable->getPointsToUser();
                $userWhoSentInvite->setPoints($points);
                $userWhoSentInvite->save();
            }

            $pointsToInvited = 0;
            if ($invitedUserTable) {
                $pointsToInvited = $invitedUserTable->getPointsToInvited();
            }

            $points = $invitedUser->getPoints() + $invitedUserTable;
            $invitedUser->setPoints($points);
            $invitedUser->save();

            $friendList = new friendList();
            $friendList->setUserId1($userWhoSentInvite->getId());
            $friendList->setUserId2($invitedUser->getId());

            $friendList->save();

            // Delete current record
            // Deprecated after new specification
            //$invitedUserTable->delete();

            $this->getUser()->setAttribute('code', null);
        }
        else {
            // Set relation by e-mail of fb
            $email = $invitedUser->getSfGuardUser()->getEmailAddress();
            $facebookUID = $invitedUser->getFacebookUid();
            $query = Doctrine::getTable('InvitedUser')
                    ->createQuery('iu')
                    ->where('iu.email = ?', $email)
                    ->orWhere('iu.facebook_uid = ?', $facebookUID);

            if ($friends = $query->execute()) {
                foreach ($friends as $friend) {
                    $friendList = new friendList();
                    $friendList->setUserId1($invitedUser->getId());
                    $friendList->setUserId2($friend->getUserId());
                    $friendList->save();

                    // Deprecated after new specification
                    //$friend->delete();
                }
            }
        }
    }

    public function executeGeocodus(sfWebRequest $request)
    {
        if ($request->isXmlHttpRequest()) {
            $this->getResponse()->setContentType('application/json');
            $this->renderText(json_encode($this->_geocodus($request)));
            return sfView::NONE;
        }
    }

    private function _geocodus($request) {
        if ($request->isMethod('GET')) {
            // return next company
            $query = CompanyLocationTable::getInstance()->createQuery('cl')
                ->innerJoin('cl.Company c')
                ->innerJoin('c.City ci')
                ->innerJoin('ci.Translation cit')
                ->innerJoin('ci.County co')
                ->innerJoin('co.Translation cot')
                ->innerJoin('co.Country ct')
                ->select('cl.*, c.id, ci.id, cit.name')
                ->addSelect('co.id, cot.name, ct.id, ct.name_en')
                ->where('cl.geocode = 1')
                //->andWhere('cit.lang = ?','en')
                ->andWhere('cl.processed = 0')
                ->limit(1);

            if ($query->count() == 0) {
                return false;
            }
            $location = $query->execute();
            $location = $location[0];
            $city = $location->getCompany()->getCity();
            $data = array(
                'id' => $location->getId(),
                'address' => $location->getFullAddress(),
                'city' => $city->getName(),
                'county' => $city->getCounty()->getName(),
                'country' => $city->getCounty()->getCountry()->getNameEn()
            );
            $location->setProcessed(1);
            $location->save();
            return $data;
        }

        if ($request->isMethod('POST')) {
            $data = $request->getParameter('data');

            $location = CompanyLocationTable::getInstance()->findOneById($data['id']);
            if ($location) {
                // if data save company
                $location->setLatitude($data['lat']);
                $location->setLongitude($data['lng']);
                $location->setGeocode(0);
                $location->save();

                return true;
            }
            return false;
        }
    }

	public function executeReservation(sfWebRequest $request){
        $this->configShow($request);
        ReservationForm::setReservationType($this->company->reservationType());

        if($this->getUser()->isAuthenticated()){
            $user = $this->getUser()->getGuardUser();
            $this->form = new ReservationForm(array('email' => $user->getEmailAddress(), 'name' => $user->getFirstName().' '.$user->getLastName(), 'phone' => $user->getUserProfile()->getPhoneNumber()), array('company' => $this->company));
        } else{
            $this->form = new ReservationForm(null, array('company' => $this->company));
        }
        
        $i18n = sfContext::getInstance ()->getI18N ();

        if($request->isMethod('POST')){
            $params = $request->getParameter($this->form->getName(), array());
            $this->form->bind($request->getParameter($this->form->getName()));

            if($this->form->isValid()){
                myTools::sendMailToCompany($this->company, 'Reservation Request', 'reservationRequest', array('user_data' => $params, 'company' => $this->company));

                if($this->company->getActivePPPService(true)){
                    CompanyStatsTable::saveStatsLog(sfConfig::get('app_log_actions_reservation_request'), $this->company->getId());
               }
                // $this->getUser()->setFlash('newsuccess', 'Thank you for sending your reservation request. Getlokal will forward it to the relevant person and they will be in touch with you shortly.');
                $this->setTemplate('reservationDone');
            }
            else {
                $this->getUser ()->setFlash ( 'newerror', 'There is missing info and/or errors. Please check again!' );
    //            $html = $this->getPartial('reserve', array('company' => $this->company, 'form' => $this->form));
    //            $response = array('success' => false, 'html' => $html);
            }
        }
    }
    
    public function executeSuggest(sfWebRequest $request) {
        $this->getResponse()->setSlot('no_map', true);
        $this->localLang = false;
        
        
        $slug = $request->getParameter('slug', false);
        
        if ($slug) {
            $query = Doctrine::getTable('Company')->createQuery('c')
            ->innerJoin('c.City l')
            ->innerJoin('l.County co')
            ->innerJoin('co.Country')
            ->innerJoin('c.CompanyLocation')
            ->leftJoin('c.CompanyDetail d')
            ->where('c.slug = ?', $request->getParameter('slug'));

            $this->company = $query->fetchOne();

            if (!$this->company)
            {
                $this->forward404Unless($this->company = Doctrine::getTable('Company')->findOneByOldSlug($request->getParameter('slug')));

                if ($this->company->getStatus() != CompanyTable::VISIBLE)
                {
                  $this->redirect ( 'company/notFound', 410 );
                }

                //$this->redirect($this->company->getUri(), 301);
            }
            
            $c = Doctrine_Query::create()
                ->select('c.id, ct.lang')
                ->from('Company c')
                ->innerJoin('c.Translation ct')
                ->where('c.id = ?', $this->company->getId())
                ->fetchArray();
            
            foreach ($c[0]['Translation'] as $ct) {
                $languages[] = $ct['lang'];
            }
            
            $this->userCulture = sfContext::getInstance()->getuser()->getCulture();
            
            if (in_array($this->userCulture, $languages)) {
                $this->localLang = true;
            }
            
            $culture = sfContext::getInstance()->getUser()->getCulture();            
            $this->companyTitle = $this->company->getCompanyTitleByCulture($this->localLang ? $culture : 'en');
            $this->companyClassification = $this->company->getClassification()->getTitle();
            
            if ($this->company->getPhone()) {
                $this->companyPhone = $this->company->getPhoneFormated();
            }
            else {
                $this->companyPhone = $this->company->getPhone();
            }
            
            
            $this->form = new SuggestEditForm ( $this->company );
            
            if ($request->isMethod ( 'post' ))
            {
                sfContext::getInstance()->getConfiguration()->loadHelpers('Frontend');
                                
                $send = false;
                $companyLatitude = $this->company->getLocation()->getLatitude();
                $companyLongitude = $this->company->getLocation()->getLongitude();
                $companyStreet = $this->company->getLocation()->getStreet();
                $companyStreetNo = $this->company->getLocation()->getStreetNumber();
                $companyStreetType = $this->company->getLocation()->getStreetTypeId();
                $companyCityId = $this->company->getCityId();
                $companyPhone = $this->companyPhone;
                $companyTitle = $this->companyTitle;
                $companyClassification = $this->companyClassification;

                $params = $request->getParameter ( $this->form->getName (), array() );
                $closed = $request->getParameter('closed');
                $duplicate = $request->getParameter('duplicate');
                $moved = $request->getParameter('moved');
                $phoneNumber = $request->getParameter('phone_number');
                
                $companyId = $this->company->getId();

                $sendTo = 'm@getlokal.com';
                
                $sendFrom = sfContext::getInstance()->getUser()->getProfile()->getEmailAddress() ? sfContext::getInstance()->getUser()->getProfile()->getEmailAddress() : 'anonymous@getlokal.com';
                $sendSubject = 'USER SUGGESTED CHANGES FOR PLACE '.$this->company->getCompanyTitleByCulture($this->localLang ? $culture : 'en').', '.$this->company->getCity()->getLocation('en').', '.$this->company->getCountry()->getLocation('en');
                $urlPlace = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 's' : '') . '://www.getlokal.' . (sfContext::getInstance()->getUser()->getDomain($culture) ? sfContext::getInstance()->getUser()->getDomain($culture). '/' . $culture : 'com/en') . '/' . $this->company->getCity()->getSlug() . '/' . $this->company->getSlug();
                
                $name = ($companyTitle == $params[$this->localLang ? $culture : 'en']['title']) ? '' : $params[$this->localLang ? $culture : 'en']['title'];
                $phone = ($companyPhone == $params['phone']) ? '' : $params['phone'];
                $typePlace = ($companyClassification == $params['classification']) ? '' : $params['classification'];
                $streetName = ($companyStreet == $params['company_location']['street']) ? '' : $params['company_location']['street'];
                $streetNo = ($companyStreetNo == $params['company_location']['street_number']) ? '' : $params['company_location']['street_number'];
                $lat = ($companyLatitude == $params['company_location']['latitude']) ? '' : $params['company_location']['latitude'];
                $long = ($companyLongitude == $params['company_location']['longitude']) ? '' : $params['company_location']['longitude'];
                $streetType = ($companyStreetType == $params['company_location']['street_type_id']) ? '' : $params['company_location']['street_type_id'];
                $city = ($companyCityId == $params['city_id']) ? '' : $params['city'];
                
                $isClosed = $request->getParameter('closed') ? 'yes' : '';
                $isDuplicate = $request->getParameter('duplicate') ? 'yes' : '';
                $wrongPhone = $request->getParameter('phone_number') ? 'yes' : '';
                $hasMoved = $request->getParameter('moved') ? 'yes' : '';

                if ($streetType && $streetType != '') {
                	$cult = ucfirst($culture);
                	
                	if (class_exists("AddressType{$cult}")) {
                		$locTypeList = call_user_func_array(array("AddressType{$cult}", 'getInstance'),array($culture));
                		$streetType = $locTypeList[$streetType];
                	}
                	else {
                		$streetType = CompanyLocation::getStreetTypeStringById($streetType);
                	}
                }
                
                $data = array(
                    'sendTo' => $sendTo,
                    'sendFrom' => $sendFrom,
                    'sendSubject' => $sendSubject,
                    'urlPlace' => $urlPlace
                );

                $html = array(
                    'companyID' => $companyId,
                    'name' => $name,
                    'phone' => $phone,
                    'typePlace' => $typePlace,
                    'streetName' => $streetName,
                    'streetNo' => $streetNo,
                    'streetType' => $streetType,
                    'lat' => $lat,
                    'long' => $long,
                    'isClosed' => $isClosed,
                    'isDuplicate' => $isDuplicate,
                    'wrongPhone' => $wrongPhone,
                    'hasMoved' => $hasMoved
                );

                foreach ($html as $key => $val) {
                    if ($key != 'companyID') {
                        if ($val != '') {
                            $send = true;
                        }
                    }
                }
                if ($send) {
                    $value = array('data' => $data, 'html' => $html);
                    $valid = myTools::sendMailInvalidData($value);
                }
                
                $this->getUser ()->setFlash ( 'notice', 'Thank you! If the place is claimed, we will sent your suggestions to the owner. If not, we will manually verify and update the details of the place.' );
                $this->redirect($this->company->getUri());

            }
        }        
    }

    public function executeAddCompanySendMail(sfWebRequest $request){

        $this->form = new ContactForm();
        
        if($request->isMethod('POST')){
            $params = $request->getParameter($this->form->getName(), array());
            $this->form->bind($params);
            if($this->form->isValid()){
                $sSubject = 'Request through getlokal';
                $sFromEmail = mb_strtolower($this->form->getValue('email'));
                $sFromName = $this->form->getValue('name');
                $sFromPhone = $this->form->getValue('phone');
                $sFromText = $this->form->getValue('message');
                
                $sMessage = '<br /> Name: '. $sFromName;
                $sMessage .= '<br /> E-mail: '. $sFromEmail;
                $sMessage .= '<br /> Phone: '. $sFromPhone;
                $sMessage .= '<p>';
                $sMessage .= '<br /> '. $sFromText;

                $domain = sfContext::getInstance()->getRequest()->getHost();
                $domain_array = sfConfig::get('app_domain_slugs');
                $flag = false;
           
                foreach($domain_array as $dom){
                    if(strstr($domain, $dom) !== false){
                         $country_name = strtolower(sfConfig::get('app_countries_'.$dom));
                         $to = $country_name.'@getlokal.com';
                         $flag = true;
                         break;
                    }
               }

                if($flag === false && (strstr($domain, '.com') || strstr($domain, '.my'))){
                    $to = 'info@getlokal.com';
                }

                    $i18n = sfContext::getInstance ()->getI18N ();
                        $message = Swift_Message::newInstance ()
                        ->setSubject ($i18n->__($sSubject, null,'mailsubject'))->setFrom ( $sFromEmail )
                        ->setTo ( $to )->setBody ( stripslashes ( $sMessage ) )
                        ->addPart ( $sMessage, 'text/html' );
                        
                        $this->getMailer ()->send ( $message );                         
                
                $this->getUser()->setFlash('notice', 'Your message was sent successfully.'); 
            }
            
        }
    }
    
    public function executeCompanyRalatedObjects(sfWebRequest $request){
    	$type = $request->getParameter('type', false);
    	$companyId = $request->getParameter('company', false);
    	if(!is_object($this->company)){
    		$company = Doctrine::getTable('Company')->findOneById($companyId);
    	}else{
    		$company = $this->company;
    	}
    	$page = $request->getParameter('page', false);
    	switch ($type){
    		case 'reviews': 
    			$pager = $this->_getCompanyReviews($companyId, $page);
// 				var_dump($companyId,$page);die;
    			$html = $this->getPartial('companyReviewList', array('reviews' => $pager,'user'=>$this->getUser(),'company_id'=>$companyId));
    		break;
    		case 'events_incoming':
    		case 'events_past':
    			$pager = $this->_getCompanyEvents($companyId, $page,$type);
    			$html = $this->getPartial('companyEventsList',array('events'=>$pager,'company_id'=>$companyId,'type'=>$type));
    		break;
    		case 'lists':
    			$pager = $this->_getCompanyLists($companyId, $page);
    			$html = $this->getPartial('companyListsList',array('lists'=>$pager,'company_id'=>$companyId)); 
    		break;
    	}
    	echo $html;
    	return sfView::NONE;
    }
    
    protected function _getCompanyReviews($companyId, $page){
    	$query = Doctrine::getTable ( 'Review' )
    		->createQuery ( 'r' )
    		->innerJoin ( 'r.Company c WITH c.id = ?', $companyId )
    		->innerJoin ( 'r.UserProfile p' )//->leftJoin('r.ActivityReview a')
    		->innerJoin ( 'p.sfGuardUser sf' )
    		->leftJoin ( 'p.Image im' )//->leftJoin('a.UserLike l WITH l.user_id = ?', $this->getUser()->getId())
    		->leftJoin ( 'r.Review rr' )
    		->where ( 'r.is_published = ?', Review::FRONTEND_REVIEWS_IS_PUBLISHED )
    		->addWhere ( 'r.parent_id IS NULL' )//->addWhere( 'sf.is_active=1')
    		->orderBy ( 'r.created_at DESC' );
    	//echo $query->getSqlQuery();
    	$pager = new sfDoctrinePager ( 'Review', Review::FRONTEND_REVIEWS_PER_TAB );
    	$pager->setQuery ( $query );
    	$pager->setPage ( $page );
    	$pager->init ();
    	#$elll = $pager->getResults();
    	#ob_clean(); var_dump($elll[0]); die;
    	return $pager;
    }
    
    protected function _getCompanyEvents($companyId, $page,$type="events_incoming"){
    	 $query = EventTable::getEventSliderBaseQuery(false);
    	 $query->addWhere('c.id = ?',$companyId);
    	 if($type == "events_incoming"){
    	 	$query->addWhere('DATE(e.start_at) >= DATE(NOW())');
		 	$query->orderBy('e.start_at ASC');
    	 }elseif($type == "events_past"){
    	 	$query->addWhere('DATE(e.start_at) < DATE(NOW())');
    	 	$query->orderBy('e.start_at DESC');
    	 }
    	 $pager = new sfDoctrinePager ( 'Event', Event::COMPANY_EVENTS_PER_PAGE);
    	 $pager->setQuery ( $query );
    	 $pager->setPage ( $page );
    	 $pager->init ();
    	 return $pager;
    }
    
    protected function _getCompanyLists($companyId, $page){
    	$query = Doctrine::getTable('Lists')->createQuery('l')
    	->innerJoin('l.Translation lt')
    	->innerJoin('l.ListPage lp')
    	->where('lp.page_id = (SELECT page.id FROM page WHERE type = 2 AND page.foreign_id = ?)', $companyId)
    	->andWhere('l.is_active = 1')
    	->orderBy('l.created_at DESC');
    	$pager = new sfDoctrinePager ( 'Lists', Lists::COMPANY_LISTS_PER_PAGE);
    	$pager->setQuery ( $query );
    	$pager->setPage ( $page );
    	$pager->init ();
    	return $pager;
    }
	
}
