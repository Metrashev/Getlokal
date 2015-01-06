<?php

/**
 * UserProfile
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class UserProfile extends BaseUserProfile {
	const FRONTEND_RECORDS_PER_PAGE = 10;
	const FRONTEND_REVIEWS_PER_TAB = 10;
	const FRONTEND_EVENTS_PER_TAB = 6;
	const FRONTEND_PICTURES_PER_TAB = 15;
	const CRM_PARTNER = 6;
	const UNSPECIFIED = 0;
	
	public static $is_company_admin_cache = array();
	
	private $__to_string_cache = "";
	
	
	public function __toString() {
		$string = "";
		
		if($this->__to_string_cache){
			$string = $this->__to_string_cache;
		}elseif (trim ( $this->getFirstName () ) || trim ( $this->getLastName () )){
			$string =  $this->getFirstName () . ' ' . $this->getLastName ();
		}else{
			$string = ( string ) $this->sfGuardUser->getUsername (); 
		}
		
		return $this->__to_string_cache = $string;
	}
	public function getFirstName() {
		return $this->sfGuardUser->getfirst_name ();
	}
	
	public function getLastName() {
		return $this->sfGuardUser->getLastName ();
	}
	
	public function getEmailAddress() {
		return $this->sfGuardUser->getEmailAddress ();
	}
	
	public function getCounty() {
		return $this->getCity ()->getCounty ();
	}
	
	public function getFBtoken() {
		if (preg_match ( '|access_token=(.*?)&expires=|is', $this->getAccessToken (), $matches ))
			return $matches [1];
		
		return '';
	}
	
	public function getThumb($size = 0) {
		if (! $this->getImage () || ! $this->getImage ()->getId () || !$this->getImage()->getFileName()) {
			$image = new Image ();
			$sizes = $image->getFile ()->getOption ( 'sizes' );
			
			return 'gui/default_user_' . $sizes [$size] . '.jpg';
		}
		
		return $this->getImage ()->getFile ()->getThumb ( $size );
	}
	
	public function getUserGender() {
		return Social::$sexChoicesWEmpty [$this->getGender ()];
	}
	
	public function getPosition($company, $status) {
		$pageAdmin = $this->getIsCompanyAdmin ( $company, $status );
		return $pageAdmin->getPosition ();
	}
	
	public function getLink($size = false, $image_options = '', $link_options = '') {
		return link_to ( $size !== false ? image_tag ( $this->getThumb ( $size, true ), $image_options . ' alt=' . $this->__toString () ) : $this->__toString (), $this->getUrl (), $link_options . ' title=' . $this->__toString () );
	}

    public function getGplusAuthorLink() {
        $gplus = $this->getGoogleUrl();
        if (empty($gplus)) {
            return $this->getLink(false, '', 'rel=author', ESC_RAW);
        }
        return link_to($this->getSfGuardUser()->getName(), $gplus.'?rel=author');
    }

	public function getUrl() {
		return 'profile/index?username=' . $this->sfGuardUser->getUsername ();
	}
	
	public function getIsPageAdmin() {
		$q = Doctrine_Query::create ()->select ( 'COUNT(DISTINCT p.id) AS pageadmins' )->from ( 'PageAdmin p' )->innerJoin ( 'p.UserProfile u' )->where ( 'p.user_id = ?', $this->getId () )->andWhere ( 'p.status = ?', 'approved' );
		
		$count_pages = $q->count ();
		
		return $count_pages > 0;
	}
	
	public function getIsCompanyAdmin($company, $status = 'approved') {
		$cache_key = $this->getId().'-'.$company->getId().'-'.$status;
		
		if(isset(self::$is_company_admin_cache[$cache_key])){
			//die("returning ".$cache_key);
			return self::$is_company_admin_cache[$cache_key];
		}
		$q = Doctrine_Query::create()
		->select ( 'p.*' )
		->from ( 'PageAdmin p' )
		->innerJoin ( 'p.UserProfile u' )
		->where ( 'p.page_id = ?', $company->getCompanyPage ()->getId () )
		->andWhere ( 'p.user_id = ?', $this->getId () )
		->andWhere ( 'p.status = ?', $status );
		
		return self::$is_company_admin_cache[$cache_key] = $q->fetchOne ();
	}
	
	public function getIsTopUser() {
		$query = Doctrine_Query::create ()->select ( 'COUNT(DISTINCT r.id) AS topreviews' )->from ( 'Review r' )->innerJoin ( 'r.UserProfile p' )->innerJoin ( 'p.sfGuardUser sf' )->where ( 'r.user_id = ? and r.parent_id IS NULL and r.recommended_at IS NOT NULL', $this->getId () )->andWhere ( 'r.is_published = ?', true )->orderBy ( 'r.created_at DESC' );
		
		$count_reviews = $query->fetchArray ();
		
		return $count_reviews [0] ['topreviews'] > 0;
	}
	
	public function getBadges() {
		return Doctrine::getTable ( 'Badge' )->createQuery ( 'b' )->innerJoin ( 'b.UserBadge ub' )->where ( 'ub.user_id = ?', $this->getId () )->count ();
	}
	
	public function getReviews() {
		return Doctrine::getTable ( 'Review' )->createQuery ( 'r' )->innerJoin ( 'r.UserProfile p' )->innerJoin ( 'p.sfGuardUser sf' )->where ( 'r.user_id = ? and r.parent_id IS NULL', $this->getId () )->andWhere ( 'r.is_published = ?', true )->count ();
	}
	
	public function getImages() {
		return Doctrine::getTable ( 'Image' )->createQuery ( 'i' )->innerJoin ( 'i.UserProfile p' )->innerJoin ( 'p.sfGuardUser sf' )->where ( 'i.user_id = ?', $this->getId () )->count ();
	}
	public function getUri() {
		return '@user_page?username=' . $this->getSfGuardUser()->getUsername ();
	}
	public function getIsPageAdminConfirmed() {
		$q = Doctrine_Query::create ()->from ( 'PageAdmin p' )->innerJoin ( 'p.UserProfile u' )->where ( 'p.user_id = ?', $this->getId () )->andWhere ( 'p.username is not NULL AND p.username!=""' );
		$count_pages = $q->count ();
		
		return $count_pages > 0;
	}
	
	public function preInsert($event) {
		parent::preInsert ( $event );
		
		$this->setReferer ( sfContext::getInstance ()->getRequest ()->getCookie ( 'from' ) );
	}
	
	public function preSave($event) {
		$this->setSummary(strip_tags($this->getSummary()));
	}
	
	public function postInsert($event) {
		parent::postInsert ( $event );
		
		$user_page = new UserPage ();
		$user_page->setForeignId ( $this->getId () );
		$user_page->setUrlAlias ( $this->sfGuardUser->getUsername () );
		$user_page->setIsPublic ( 1 );
		$user_page->setCountryId ( $this->getCountryId () );
		$user_page->save ();
	}
	
	public function getSugestedCompanies($status = 'all', $from = null, $to = null) {
		
		$q = Doctrine_Query::create ()->from ( 'Company c' )->innerJoin ( 'c.CreatedByUser p' )->where ( 'c.created_by = ?', $this->getId () );
		if ($status != 'all') {
			if ($status == 'approved')
				$status = 0;
			$q->andWhere ( 'c.status = ?', $status );
		}
		if ($from) {
			$q->andWhere ( 'c.created_at >= ?', $from );
		}
		if ($to) {
			$q->andWhere ( 'c.created_at <= ?', $to );
		}
		
		$companies = $q->execute ();
		
		return $companies;
	}
	public function getCountPlacesAddPlaceGame($from = '2012-09-03 00:00:00', $to = '2012-09-14 17:00:00') {
		$companies_count = Doctrine_Query::create ()->from ( 'Company c' )->innerJoin ( 'c.CreatedByUser p' )->where ( 'c.created_by = ?', $this->getId () )->andWhere ( 'c.created_at >= ?', $from )->andWhere ( 'c.created_at < ?', $to )->andWhere ( 'c.status = ?', 0 )->count ();
		return $companies_count;
	}
	public function getAllowContact() {
		return $this->getUserSetting ()->getAllowContact ();
	}
	public function getAllowNewsletter() {
		return $this->getUserSetting ()->getAllowNewsletter ();
	}
	public function getAllowBCmc() {
		return $this->getUserSetting ()->getAllowBCmc ();
	}
	public function getName() {
		
		return $this->getFirstName () . ' ' . $this->getLastName ();
	
	}
	
	public function getVouchersReviews($from = null, $to = null) {
		
		$q = Doctrine_Query::create ()->from ( 'ReviewVoucher rv' )->innerJoin ( 'rv.UserProfile up' )->where ( 'up.id = ?', $this->getId () );
		
		if ($from) {
			$q->andWhere ( 'rv.date_issued >= ?', $from );
		}
		if ($to) {
			$q->andWhere ( 'rv.date_issued <= ?', $to );
		}
		$q->addOrderBy ( 'rv.id' );
		
		$user_review_vouchers = $q->execute ();
		
		return $user_review_vouchers;
	}
	
	public function getIsCompanyAdminAllStatus($company) {
		$q = Doctrine_Query::create ()->select ( 'p.*' )->from ( 'PageAdmin p' )->innerJoin ( 'p.UserProfile u' )->where ( 'p.page_id = ?', $company->getCompanyPage ()->getId () )->andWhere ( 'p.user_id = ?', $this->getId () );
		
		return $q->fetchOne ();
	}
	
	public function getFollowers($count = false) {
		
		$query = Doctrine::getTable ( 'FollowPage' )->createQuery ( 'fp' )->where ( 'fp.page_id = ?', $this->getUserPage ()->getId () );
		if ($count == true) {
			return $query->count ();
		} else {
			return $query->execute ();
		}
	
	}
	public function getFollowedPages($count = false) {
		
		$query = Doctrine::getTable ( 'FollowPage' )->createQuery ( 'fp' )->where ( 'fp.user_id = ?', $this->getId () );
		if ($count == true) {
			return $query->count ();
		} else {
			return $query->execute ();
		}
	
	}

    public function getSpecialFirstName() {
        $realName = '';

        $realName = $this->getSfGuardUser()->getFirstName();

        if ($this->getCountry()->getSlug() == 'sr') {
            $name = Doctrine::getTable('SerbianNames')
                ->createQuery ( 'sn' )
                ->where('name = ?', $realName)
                ->fetchOne();

            if ($name) {
                $realName = $name->getSuffix();
            }
        }

        return $realName;
    }
	
    public function getUsersCount($countryId) {
        $query = Doctrine::getTable('SfGuardUser')
                ->createQuery('sgu')
                ->innerJoin('sgu.UserProfile up')
                ->where('sgu.is_active = 1')
                ->andWhere('up.country_id = ?', $countryId);

        if ($query) {
            return $query->count();
        }
        return;
    }
    
    public function getUsersInCountry($countryId) {
        $query = Doctrine::getTable('Company')
                ->createQuery('c')
                ->innerJoin('c.CreatedByUser cbu')
                ->where('c.country_id = ?', $countryId)
                ->andWhere('c.status = 0')
                ->andWhere('cbu.facebook_uid IS NOT NULL OR cbu.image_id IS NOT NULL')
                ->groupBy('cbu.id')
                ->limit(6)
                ->execute();

        if ($query) {
            return $query;
        }
        return;
    }
}

