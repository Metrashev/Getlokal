<?php

/**
 * company actions.
 *
 * @package    getLokal
 * @subpackage photo
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class profileActions extends sfActions {
	public function preExecute() {
		$request = $this->getRequest ();		
		$this->user = $this->getUser ()->getGuardUser ();
		$this->is_followed = false;
		$this->followerCount = 0;
		$this->followedCount = 0;
		$this->badgeCount = 0;
		$this->voucherCount = 0;
		$this->send_message_option = false;
		$this->placesCount = 0;
		if ($request->getParameter ( 'username', null))
		{
		  $this->pageuser = Doctrine::getTable ( 'sfGuardUser' )->findOneByUsername ( $request->getParameter ( 'username') );
		}
		if (! $this->pageuser) {
			$this->pageuser = $this->user;			
		}

		$this->is_other_place_admin_logged = false;
		$this->page_admin = $this->getUser ()->getPageAdminUser ();
		if ($this->page_admin) {
			$this->is_other_place_admin_logged = true;
			
			if ($this->page_admin->getCompanyPage ()->getCompany ()->getActivePPPService ( true ))
				$this->send_message_option = Doctrine::getTable ( 'FollowPage' )->getFollowPage ( $this->pageuser->getId (), $this->getUser ()->getPageAdminUser ()->getCompanyPage ()->getId () );
		
		}
		
		$this->redirectUnless ( $this->pageuser, 'user/signin' );
		
		$this->is_current_user = ($this->user && $this->user->getId () == $this->pageuser->getId ());
		
		$this->profile = $this->pageuser->getUserProfile ();
		
		breadCrumb::getInstance ()->add ( $this->profile );
		
		//reviews
		$this->review_query = Doctrine::getTable ( 'Review' )->createQuery ( 'r' )->innerJoin ( 'r.Company c' )->innerJoin ( 'r.UserProfile p' )->innerJoin ( 'p.sfGuardUser sf' )->where ( 'r.user_id = ? and r.parent_id IS NULL', $this->pageuser->getId () )->orderBy ( 'r.created_at DESC' );
		if (! $this->is_current_user) {
			$this->review_query->andWhere ( 'r.is_published = ?', true );
		}
		$this->reviewCount = $this->review_query->count ();
		$cloned = clone $this->review_query;
		$cloned->innerJoin ( 'c.CompanyImage ci' )->innerJoin ( 'ci.Image i' )->andWhere ( 'i.status = "approved"' )->andWhere ( 'c.status = ?', CompanyTable::VISIBLE );
		
		$this->review = $cloned->fetchOne ();
		
		//images       
		$this->image_query = Doctrine::getTable ( 'Image' )->createQuery ( 'i' )->innerJoin ( 'i.UserProfile p' )->innerJoin ( 'p.sfGuardUser sf' )->where ( 'i.user_id = ?', $this->pageuser->getId () )->orderBy ( 'i.created_at DESC' );
		if (! $this->is_current_user) {
			$this->image_query->andWhere ( 'i.status = "approved"' );
		}
		$this->imageCount = $this->image_query->count ();
		
		$this->image = $this->image_query->fetchOne ();

		$this->places_query = Doctrine::getTable('Company')
		->createQuery('c')
		->leftJoin('c.CompanyImage ci')
		->where('c.created_by = ? ', $this->pageuser->getId())
		->andWhere('c.status = 0')
                ->orderBy ( 'c.created_at DESC' );
		$this->placesCount = $this->places_query->count();
		
		//events
		$this->event_query = Doctrine::getTable ( 'Event' )
		->createQuery ( 'e' )	
		->leftJoin('e.EventImage ei')
		->innerJoin ( 'e.UserProfile p' )
		->innerJoin ( 'p.sfGuardUser sf' )
		->where ( 'e.user_id = ' . $this->pageuser->getId () . ' OR ' . 'e.id IN (SELECT evu.event_id FROM EventUser evu WHERE evu.user_id = ?)', $this->pageuser->getId () )
		->orderBy ( 'e.created_at DESC' );
		//echo  $this->event_query->getSqlQuery(); exit();
		
		if (! $this->is_current_user) {
			$this->event_query->andWhere ( 'e.is_active = ?', true );
		}
		$this->eventCount = $this->event_query->count ();
		
		$cloned = clone $this->event_query;
		$cloned->innerJoin ( 'e.Image i' );
		$this->event = $cloned->fetchOne ();
		//echo $this->event->getId(); exit();
		//lists
		$this->list_query = Doctrine::getTable ( 'Lists' )->createQuery ( 'l' )->innerJoin ( 'l.UserProfile p' )->innerJoin ( 'p.sfGuardUser sf' )->leftJoin ( 'l.ListPage lp' )->orderBy ( 'l.created_at DESC' )->addWhere ( 'lp.user_id = ? or l.user_id = ? ', array ($this->pageuser->getId (), $this->pageuser->getId () ) );
		if (! $this->is_current_user) {
			$this->list_query->addWhere ( ' lp.list_id IN (SELECT ListPage.list_id FROM ListPage GROUP BY list_id HAVING count(id) > 0)' );
			$this->list_query->andWhere ( 'l.status = ?', 'approved' );
		}
		$this->listCount = $this->list_query->count ();
		$cloned = clone $this->list_query;
		$cloned->innerJoin ( 'l.Image i' );
		$this->list = $cloned->fetchOne ();
		if (! $this->list) {
			//TODO
		}
		
		$this->messageCount = 0;
		if ($this->is_current_user) {
			$this->message_query = Doctrine::getTable ( 'Message' )->createQuery ( 'm' )->innerJoin ( 'm.Conversation c' )->innerJoin ( 'c.FromPage' )->where ( 'c.page_from = ' . $this->user->getUserProfile ()->getUserPage ()->getId () )->orderBy ( 'm.created_at DESC' );
			
			$cloned = clone $this->message_query;
			$cloned->andWhere ( 'm.is_read = 0 ' );
		//echo  $cloned->getSqlQuery(); exit();
			$this->messageCount = $cloned->count ();
			
			$this->voucher_query = VoucherTable::getVouchersQuery ( $this->user, false, false );
		    $this->voucherCount = $this->voucher_query->count();
		}
			$this->followers_query = Doctrine::getTable ( 'FollowPage' )->createQuery ( 'fp' )->innerJoin ( 'fp.UserProfile u' )->where ( 'fp.page_id = ?', $this->pageuser->getUserProfile ()->getUserPage ()->getId () );
			$this->followerCount = $this->followers_query->count ();
			
			$this->followed_query = Doctrine::getTable ( 'FollowPage' )->createQuery ( 'fp' )->innerJoin ( 'fp.UserProfile u' )->where ( 'fp.user_id = ?', $this->pageuser->getUserProfile ()->getId () );
			$this->followedCount = $this->followed_query->count ();
		
		
		if ($this->user && ! $this->is_current_user) {
			$this->is_followed = Doctrine::getTable ( 'FollowPage' )->getFollowPage ( $this->user->getId (), $this->profile->getUserPage ()->getId () );
		}
		
		$this->badges_query = Doctrine::getTable ( 'Badge' )->createQuery ( 'b' )->innerJoin ( 'b.UserBadge ub' )->where ( 'ub.user_id = ?', $this->pageuser->getId () );
		$this->badgeCount = $this->badges_query->count ();
		
		$this->articles_query = Doctrine::getTable ( 'Article' )
			->createQuery ( 'a' )
			//->innerJoin('a.Translation at')
			->where ( 'a.user_id = ?', $this->pageuser->getId () )
			->orderBy ( 'a.created_at DESC' );
			
		if (! $this->is_current_user) {
			$this->articles_query->andWhere ( 'a.status = ?', 'approved' );
		}
		$this->articleCount = $this->articles_query->count ();
		
		$cloned = clone $this->articles_query;
		$cloned->innerJoin ( 'a.ArticleImage i' );
		$this->article = $cloned->fetchOne ();
		
		$this->checkIns = Doctrine::getTable('CheckIn')
                    ->createQuery('c')
                    ->innerJoin('c.Company co')
                    ->innerJoin('co.CompanyLocation cl')
                    ->where('c.user_id = ?', $this->pageuser->getId())
                    ->orderBy('c.created_at DESC')
                    ->count();
		
		$this->getResponse ()->setSlot ( 'sub_module', 'profile' );
		
		$this->getResponse ()->setSlot ( 'sub_module_parameters', array ('profile' => $this->profile, 'pageuser' => $this->pageuser,  'user' => $this->user , 'reviewCount' => $this->reviewCount, 'imageCount' => $this->imageCount, 'eventCount' => $this->eventCount, 'listCount' => $this->listCount, 'messageCount' => $this->messageCount, 'followerCount' => $this->followerCount, 'followedCount' => $this->followedCount, 'badgeCount' => $this->badgeCount, 'articleCount' => $this->articleCount, 'review' => $this->review, 'image' => $this->image, 'event' => $this->event, 'list' => $this->list, 'article' => $this->article, 'is_current_user' => $this->is_current_user, 'is_followed' => $this->is_followed, 'is_other_place_admin_logged' => $this->is_other_place_admin_logged, 'send_message_option' => $this->send_message_option, 'checkIns' => $this->checkIns,'voucherCount' => $this->voucherCount, 'placesCount' => $this->placesCount) );

		$i18n = sfContext::getInstance ()->getI18N ();
		$request->setParameter ( 'no_location', true );
		$this->getResponse ()->setTitle ( sprintf ( $i18n->__ ( '%s - getlokal user', null, 'pagetitle' ), $this->pageuser->getName () ) );
	
	}
	
	public function executeIndex(sfWebRequest $request) {
		$this->reviews = $this->review_query->limit ( 3 )->execute ();
		$this->images = $this->image_query->limit ( 8 )->execute ();
		$this->lists = $this->list_query->limit ( 3 )->execute ();
		$this->events = $this->event_query->limit ( 3 )->execute ();
		
	}
	
	public function executePhotos(sfWebRequest $request) {
		
	    $this->page = $request->getParameter('page', 1);
		$this->pager = new sfDoctrinePager('Image', UserProfile::FRONTEND_PICTURES_PER_TAB);
        $this->pager->setQuery($this->image_query);
        $this->pager->setPage($this->page);
        $this->pager->init();
        if($request->isXmlHttpRequest()){
		$this->getResponse ()->setContent ( $this->getPartial ( 'photos', array ('pager' => $this->pager,  'user' => $this->user, 'is_current_user'=>$this->is_current_user, 'pageuser' => $this->pageuser) ) );
			return sfView::NONE;
        }
        $this->tabData = array('page' => $this->page, 'pager' => $this->pager, 'user' => $this->user, 'is_current_user' => $this->is_current_user, 'pageuser' => $this->pageuser);
        $this->tab = 'photosTab';
        $this->setTemplate('index');
	}
	public function executeReviews(sfWebRequest $request) {
		$this->page = $request->getParameter('page', 1);
		$this->pager = new sfDoctrinePager('Review', UserProfile::FRONTEND_REVIEWS_PER_TAB);
        $this->pager->setQuery($this->review_query);
        $this->pager->setPage($this->page);
        $this->pager->init();
        if($request->isXmlHttpRequest()){
		$this->getResponse ()->setContent ( $this->getPartial ( 'reviews', array ('pager' => $this->pager,  'user' => $this->user, 'is_other_place_admin_logged'=>$this->is_other_place_admin_logged ) ) );
			return sfView::NONE;
        }
        
        $this->tabData = array('page' => $this->page, 'pager' => $this->pager, 'user' => $this->user, 'pageuser' => $this->pageuser, 'is_other_place_admin_logged'=>$this->is_other_place_admin_logged);
        $this->tab = 'reviewsTab';
        $this->setTemplate('index');
	}
	
	public function executeEvents(sfWebRequest $request) {
		if($request->getParameter('attending',false))
		{
		$this->event_query = Doctrine::getTable ( 'Event' )
		->createQuery ( 'e' )		
		->innerJoin ( 'e.UserProfile p' )
		->innerJoin ( 'p.sfGuardUser sf' )
		->innerJoin('e.EventUser evu')		
		->where ( 'evu.user_id = ?' , $this->pageuser->getId ())
		->orderBy ( 'e.created_at DESC' );	
		}
		elseif($request->getParameter('my',false))
		{
		$this->event_query = Doctrine::getTable ( 'Event' )
		->createQuery ( 'e' )		
		->innerJoin ( 'e.UserProfile p' )
		->innerJoin ( 'p.sfGuardUser sf' )		
		->where ( 'e.user_id = ?' , $this->pageuser->getId ())
		->orderBy ( 'e.created_at DESC' );	
		}
	    $this->page = $request->getParameter('page', 1);
		$this->pager = new sfDoctrinePager('Event', 12);
        $this->pager->setQuery($this->event_query);
        $this->pager->setPage($this->page);
        $this->pager->init();
        if($request->isXmlHttpRequest()){
		$this->getResponse ()->setContent ( $this->getPartial ( 'events', array ('pager' => $this->pager,  'user' => $this->user, 'pageuser'=>$this->pageuser, 'is_current_user'=>$this->is_current_user ) ) );
			return sfView::NONE;
        }

        $this->tabData = array('page' => $this->page, 'pager' => $this->pager, 'user' => $this->user, 'pageuser'=>$this->pageuser, 'is_current_user'=>$this->is_current_user);
        $this->tab = 'eventsTab';
        $this->setTemplate('index');
		
	}
	public function executeArticles(sfWebRequest $request) {
		
	    $this->page = $request->getParameter('page', 1);
		$this->pager = new sfDoctrinePager('Article', UserProfile::FRONTEND_REVIEWS_PER_TAB);
        $this->pager->setQuery($this->articles_query);
        $this->pager->setPage($this->page);
        $this->pager->init();
        if($request->isXmlHttpRequest()){
		$this->getResponse ()->setContent ( $this->getPartial ( 'articles', array ('pager' => $this->pager,  'user' => $this->user, 'pageuser'=>$this->pageuser ) ) );
			return sfView::NONE;
        }
        
        $this->tabData = array('page' => $this->page, 'pager' => $this->pager, 'user' => $this->user, 'pageuser' => $this->pageuser, 'is_current_user' => $this->is_current_user);
        $this->tab = 'articlesTab';
        $this->setTemplate('index');
	
	}
	
	public function executeLists(sfWebRequest $request) {
		
	    $this->page = $request->getParameter('page', 1);
		$this->pager = new sfDoctrinePager('List', 15);
        $this->pager->setQuery($this->list_query);
        $this->pager->setPage($this->page);
        $this->pager->init();
        if($request->isXmlHttpRequest()){
		$this->getResponse ()->setContent ( $this->getPartial ( 'lists', array ('pager' => $this->pager,  'user' => $this->user, 'pageuser'=>$this->pageuser,'is_current_user' => $this->is_current_user ) ) );
			return sfView::NONE;
        }

        $this->tabData = array('page' => $this->page, 'pager' => $this->pager, 'user' => $this->user, 'pageuser'=>$this->pageuser, 'is_current_user'=>$this->is_current_user);
        $this->tab = 'listsTab';
        $this->setTemplate('index');
	}
	
	public function executeVouchers(sfWebRequest $request) {
		$this->forward404Unless ( $this->is_current_user );
		$this->page = $request->getParameter('page', 1);
		
		$this->pager = new sfDoctrinePager ( 'Voucher', 14);
		$this->pager->setPage ( $this->page );
		$this->pager->setQuery ( $this->voucher_query );
		$this->pager->init ();
	   	if($request->isXmlHttpRequest()){
		$this->getResponse ()->setContent ( $this->getPartial ( 'vouchers', array ('pager' => $this->pager,  'user' => $this->user, 'pageuser' => $this->pageuser) ) );
			return sfView::NONE;
        }
        
        $this->tabData = array('page' => $this->page, 'pager' => $this->pager, 'user' => $this->user, 'pageuser' => $this->pageuser);
        $this->tab = 'vouchersTab';
        $this->setTemplate('index');
	}
	
	public function executeDeleteReview(sfWebRequest $request) {
		$this->review = Doctrine::getTable ( 'Review' )->find ( $request->getParameter ( 'review_id' ) );
		$this->forward404Unless ( $this->user->getId () == $this->review->getUserId () );
		// if ($this->review->getReview())
		// {
		// 	$this->review->getReview()->delete();
		// }
		

		$this->review->delete ();
		$this->getUser ()->setFlash ( 'notice', 'Review was deleted successfully.' );
		$this->redirect ( 'profile/reviews?username='. $this->pageuser->getUsername() );
	}
	
	public function executeDeleteList(sfWebRequest $request) {
		$this->list = Doctrine::getTable ( 'Lists' )->find ( $request->getParameter ( 'list_id' ) );
		$this->forward404Unless ( $this->user->getId () == $this->list->getUserId () );
		// if ($this->review->getReview())
		// {
		// 	$this->review->getReview()->delete();
		// }
		

		$this->list->delete ();
		$this->getUser ()->setFlash ( 'notice', 'List was deleted successfully.' );
		$this->redirect ( 'profile/lists?username='. $this->pageuser->getUsername() );
	}
	
	public function executeDeleteArticle(sfWebRequest $request) {
		$this->article = Doctrine::getTable ( 'Article' )->find ( $request->getParameter ( 'article_id' ) );
		$this->forward404Unless ( $this->user->getId () == $this->article->getUserId () );
		$this->article->delete ();
		//$this->getUser ()->setFlash ( 'notice', 'List was deleted successfully.' );
		$this->redirect ( 'profile/articles?username='. $this->pageuser->getUsername() );
	}
	
	public function executeDeleteEvent(sfWebRequest $request) {
		$this->event = Doctrine::getTable('Event')->find($request->getParameter('event_id'));
		$this->forward404Unless ( $this->user->getId () == $this->event->getUserId () );
		$this->event->delete ();
		$this->redirect ( 'profile/events?username='. $this->pageuser->getUsername() );
	}
	
	public function executeConversations(sfWebRequest $request) {
		$this->forward404Unless ( $this->is_current_user );		
		
		$query = Doctrine::getTable ( 'Conversation' )
		->createQuery ( 'c' )->innerJoin ( 'c.Message m' )
		->innerJoin ( 'c.ToPage' )
		->where ( 'c.page_from = ?',  $this->user->getUserProfile()->getUserPage()->getId () )
		->orderBy ( 'm.is_read, m.created_at' );
		
		$this->page = $request->getParameter('page', 1);
	    $this->pager = new sfDoctrinePager ( 'Conversation', UserProfile::UNSPECIFIED );
		$this->pager->setPage ( $this->page );
		$this->pager->setQuery ( $query );
		$this->pager->init ();
		$this->getResponse ()->setTitle ( 'My Messages' );
	   
		if($request->isXmlHttpRequest()){
		$this->getResponse ()->setContent ( $this->getPartial ( 'conversations', array ('pager' => $this->pager,  'user' => $this->user) ) );
			return sfView::NONE;
        }
        
        $this->tabData = array('page' => $this->page, 'pager' => $this->pager, 'user' => $this->user);
        $this->tab = 'conversationsTab';
        $this->setTemplate('index');
	
	}
	public function executeMessages(sfWebRequest $request) {
		$this->forward404Unless ( $this->is_current_user );
		
		$query = Doctrine::getTable ( 'Message' )->createQuery ( 'm' )
		->innerJoin ( 'm.Conversation c' )
		->innerJoin ( 'c.ToPage' )
		->where ( 'c.page_to = ?', $this->user->getUserProfile ()->getUserPage ()->getId () )->orderBy ( 'm.created_at DESC' );
		
		$this->pager = new sfDoctrinePager ( 'Message', Lists::FRONTEND_LISTS_PER_TAB );
		$this->pager->setQuery ( $query );
		$this->pager->setPage ( $request->getParameter ( 'page', 1 ) );
		$this->pager->init ();
	
	}
	
	//URI: bg/d/profile/friends
	public function executeFriends(sfWebRequest $request) {
		// Get all friends via facebook
		if ($this->getUser ()->getId () && $accessToken = $this->getUser ()->getProfile ()->getAccessToken ()) {
			$friendUrl = 'https://graph.facebook.com/me/friends?' . $accessToken;
			$response = json_decode ( file_get_contents ( $friendUrl ) );
			
			$friendsList = array ();
			if ($response) {
				foreach ( $response->data as $responseItem ) {
					$friendsList [] = $responseItem->id;
				}
			}
			
			if (count ( $friendsList )) {
				/*WHERE (fl1.user_id1 = 51485 or fl2.user_id2 = 51485) AND
                    up.facebook_uid IN (100001642136166)*/
				
				/*
                    SELECT up.id as uid
                    FROM user_profile AS up
                    LEFT JOIN friend_lists AS fl1 ON (up.id = fl1.user_id1)
                    LEFT JOIN friend_lists AS fl2 ON (up.id = fl2.user_id2)
                   
                    WHERE up.facebook_uid IN (100001642136166) 
                    AND 
                    (
                        (
                            (fl1.user_id1 = 51485 AND fl1.user_id2 NOT IN 
                                (
                                    SELECT up1.id 
                                    FROM user_profile AS up1
                                    WHERE up1.facebook_uid IN (100001642136166)
                                )
                            )

                            OR

                            fl1.user_id1 IS NULL
                        )
                 
                        AND

                        (
                            (fl2.user_id2 = 51485 AND fl2.user_id1 NOT IN 
                                (
                                    SELECT up1.id 
                                    FROM user_profile AS up1
                                    WHERE up1.facebook_uid IN (100001642136166)
                                )
                            )
                 
                            OR

                            fl2.user_id2 IS NULL
                         )   
                    )
                 */
				
				//$con = Doctrine::getConnectionByTableName('UserProfile');
				//$q = Doctrine_Manager::getInstance()->getCurrentConnection();
				//, array('d1' => $friendsList/*,    $this->getUser()->getId(), $this->getUser()->getId()*/)
				

				$pdo = Doctrine_Manager::getInstance ()->getCurrentConnection ()->getDbh ();
				
				$query = "
                    SELECT up.id as uid
                    FROM user_profile AS up
                    LEFT JOIN friend_lists AS fl1 ON (up.id = fl1.user_id1)
                    LEFT JOIN friend_lists AS fl2 ON (up.id = fl2.user_id2)
                   
                    WHERE up.facebook_uid IN (:d1) 
                    AND 
                    (
                        (
                            (fl1.user_id1 = :d2 AND fl1.user_id2 NOT IN 
                                (
                                    SELECT up1.id 
                                    FROM user_profile AS up1
                                    WHERE up1.facebook_uid IN (:d1)
                                )
                            )

                            OR

                            fl1.user_id1 IS NULL
                        )
                 
                        AND

                        (
                            (fl2.user_id2 = :d2 AND fl2.user_id1 NOT IN 
                                (
                                    SELECT up1.id 
                                    FROM user_profile AS up1
                                    WHERE up1.facebook_uid IN (:d1)
                                )
                            )
                 
                            OR

                            fl2.user_id2 IS NULL
                         )   
                    )
                    ";
				
				$stmt = $pdo->prepare ( $query );
				$params = array ('d1' => implode ( ',', $friendsList ), 'd2' => $this->getUser ()->getId () );
				
				$stmt->execute ( $params );
				$results = $stmt->fetchAll ();
				
				$users = $stmt->fetchAll ();
				foreach ( $users as $user ) {
					exit ( 'ok' );
				}
				exit ( 'nok' );
				/*
                $count = Doctrine::getTable('InvitedUsers')

                    ->createQuery('iu')
                    ->where('iu.email = ?', $email)
                    ->count();
*/
			}
		
		//var_dump($response);
		//exit;
		

		/*
            $i = 0;
            foreach ($response->data as $responseItem) {
                $i++;
                echo $i, ' - ', $responseItem->name, ' - ', $responseItem->id, '<br />';
            }

            exit;
            */
		}
		
		exit ();
	}
	
	public function executeFollowers(sfWebRequest $request) {
		
		
		$this->page = $request->getParameter('page', 1);
	    $this->pager = new sfDoctrinePager ( 'FollowPage', UserProfile::UNSPECIFIED );
		$this->pager->setPage ( $this->page );
		$this->pager->setQuery ( $this->followers_query );
		$this->pager->init ();

		$this->getResponse ()->setTitle ( 'Followers' );
	   
		if($request->isXmlHttpRequest()){
		$this->getResponse ()->setContent ( $this->getPartial ( 'followers', array ('pager' => $this->pager,  'user' => $this->user,  'is_current_user'=>$this->is_current_user, 'pageuser' => $this->pageuser,'is_other_place_admin_logged' => $this->is_other_place_admin_logged) ) );
			return sfView::NONE;
        }
        
        $this->tabData = array('page' => $this->page, 'pager' => $this->pager, 'user' => $this->user);
        $this->tab = 'followersTab';
        $this->setTemplate('index');

	}
	
	public function executeFollowed(sfWebRequest $request) {
		
		
	    $this->page = $request->getParameter('page', 1);
	    $this->pager = new sfDoctrinePager ( 'FollowPage', UserProfile::UNSPECIFIED );
		$this->pager->setPage ( $this->page );
		$this->pager->setQuery ( $this->followed_query );
		$this->pager->init ();

		$this->getResponse ()->setTitle ( 'Following' );
	   
		if($request->isXmlHttpRequest()){
		$this->getResponse ()->setContent ( $this->getPartial ( 'followed', array ('pager' => $this->pager,  'user' => $this->user, 'is_current_user'=>$this->is_current_user, 'pageuser' => $this->pageuser,'is_other_place_admin_logged' => $this->is_other_place_admin_logged) ) );
			return sfView::NONE;
        }
        
        $this->tabData = array('page' => $this->page, 'pager' => $this->pager, 'user' => $this->user, 'is_current_user'=>$this->is_current_user, 'pageuser' => $this->pageuser,'is_other_place_admin_logged' => $this->is_other_place_admin_logged);
        $this->tab = 'followedTab';
        $this->setTemplate('index');
    }
    
	public function executeBadges(sfWebRequest $request) {
		$this->badges = $this->badges_query->execute();
		
		$this->tabData = array('badges' => $this->badges, 'user' => $this->user);
		$this->tab = 'badgesTab';
		$this->setTemplate('index');
    }


    public function executePlaces(sfWebRequest $request) {
		$this->page = $request->getParameter('page', 1);
		$this->pager = new sfDoctrinePager('Places', 15);
        $this->pager->setQuery($this->places_query);
        $this->pager->setPage($this->page);
        $this->pager->init();
        if($request->isXmlHttpRequest()){
		$this->getResponse ()->setContent ( $this->getPartial ( 'places', array ('pager' => $this->pager,  'user' => $this->user, 'is_other_place_admin_logged'=>$this->is_other_place_admin_logged, 'pageuser' => $this->pageuser) ) );
			return sfView::NONE;
        }
        
        $this->tabData = array('page' => $this->page, 'pager' => $this->pager, 'user' => $this->user, 'pageuser' => $this->pageuser);
        $this->tab = 'placesTab';
        $this->setTemplate('index');
	}
   
    
}