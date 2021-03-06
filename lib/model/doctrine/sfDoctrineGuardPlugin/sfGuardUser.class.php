<?php

/**
 * sfGuardUser
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class sfGuardUser extends PluginsfGuardUser {
	
	public function addDefaultPermissionsAndGroups(Array $a_permissions, Array $a_groups) {
		$permissions = Doctrine_Query::create ()->from ( 'sfGuardPermission' )->whereIn ( 'name', $a_permissions )->execute ();
		foreach ( $permissions as $permission ) {
			$this->sfGuardUserPermission []->permission_id = $permission->id;
		}
		
		$groups = Doctrine_Query::create ()->from ( 'sfGuardGroup' )->whereIn ( 'name', $a_groups )->execute ();
		foreach ( $groups as $group ) {
			$this->sfGuardUserGroup []->group_id = $group->id;
		}
		
		$this->save ();
	}
	
	public function getIsPageAdmin($company = null) {
		$result = false;
		$q = Doctrine::getTable ( 'PageAdmin' )->createQuery ( 'p' );
		if ($company) {
			$q->where ( 'p.page_id = ?', $company->getCompanyPage ()->getId () );
		}
		$q->innerJoin ( 'p.UserProfile' )->andWhere ( 'p.user_id = ?', $this->getId () )->andWhere ( 'p.status = ?', 'approved' );
		$pageAdmin_count = $q->count ();
		if ($pageAdmin_count > 0) {
			$result = true;
		}
		return $result;
	
	}
	
	public function getIsGetlokalAdmin() {
		$result = false;
		
		if (in_array ( $this->getId (), sfConfig::get ( 'app_getlokal_power_user', array () ) )) {
			$result = true;
		}
		return $result;
	}
	
	public function getAllStatusPageAdmin($company) {
		$result = false;
		$pageAdmin_count = Doctrine::getTable ( 'PageAdmin' )->createQuery ( 'p' )->where ( 'p.page_id = ' . $company->getCompanyPage ()->getId () )->andWhere ( 'p.user_id = ' . $this->getId () )->count ();
		
		if ($pageAdmin_count > 0) {
			$result = true;
		}
		return $result;
	}
	public function getUri() {
		return '@user_page?username=' . $this->getUsername ();
	}
	
	public function getAllReviews() {
		$reviews = Doctrine::getTable ( 'Review' )->createQuery ( 'r' )->where ( 'r.user_id = ?', $this->getId () )->andWhere ( 'r.parent_id is NULL' )->execute ();
		if (count ( $reviews ) > 0) {
			return $reviews;
		}
		return false;
	}
	
	public function getAllPictures() {
		$query = Doctrine::getTable ( 'Image' )->createQuery ( 'i' )->innerJoin ( 'i.CompanyImage ci' )->andWhere ( 'i.user_id = ' . $this->getId () );
		
		$q3 = $query->createSubquery ()->select ( 'c.id' )->from ( 'Company c' )->innerJoin ( 'c.CompanyPage cp' )->innerJoin ( 'cp.PageAdmin pa' )->where ( 'pa.user_id = ' . $this->getId () )->andWhere ( 'pa.status = "approved"' );
		
		$query->andWhere ( 'ci.company_id NOT IN (' . $q3->getDql () . ')' );
		$images = $query->execute ();
		
		if (count ( $images ) > 0) {
			return $images;
		}
		return false;
	}
	public function getCountry() {
		return $this->getUserProfile ()->getCountry ();
	}
	public function getIsPlaceAdmin() {
		$pageAdmins = Doctrine::getTable ( 'PageAdmin' )->createQuery ( 'p' )->innerJoin ( 'p.UserProfile' )->andWhere ( 'p.user_id = ?', $this->getId () )->andWhere ( 'p.status = ?', 'approved' )->execute ();
		
		return $pageAdmins;
	}
	
	public function getAllStatusCompanyAdmin($company) {
		$result = false;
		$pageAdmin = Doctrine::getTable ( 'PageAdmin' )->createQuery ( 'p' )->where ( 'p.page_id = ' . $company->getCompanyPage ()->getId () )->andWhere ( 'p.user_id = ' . $this->getId () )->fetchOne ();
		
		return $pageAdmin;
	}
	
	public function getUserNotificationsInfo($page_id= null, $show_read = true, $model_name = null, $limit = null) {
		
		$query = Doctrine::getTable ( 'Notification' )->createQuery ( 'n' );
	    if (!$page_id){
		    $query->where ( 'n.page_id = ? ', $this->getUserProfile ()->getUserPage ()->getId () );
		}else {
			$query->where ( 'n.page_id = ? ', $page_id );
		}
		$query->orderBy ( 'is_read, created_at DESC' );
		if ($model_name) {
			$query->addWhere ( 'n.model_name = ?', $model_name );
		}else {
			$query->addWhere ( 'n.model_name != ?', "Message" );
		}
		if (!$show_read) {
			$query->addWhere ( 'n.is_read = ?', false );
		}
		if ($limit) {
			$query->limit ( $limit );
		}
		$notifications = $query->execute ();
		return $notifications;
	}
	
	public function getUserNotificationsCount($page_id= null,$with_read = true, $model_name = null) {
		$query = Doctrine::getTable ( 'Notification' )->createQuery ( 'n' );
		if (!$page_id){
		$query->where ( 'n.page_id = ? ', $this->getUserProfile ()->getUserPage ()->getId () );
		}else {
			$query->where ( 'n.page_id = ? ', $page_id );
		}
		$query->orderBy ( 'is_read, created_at DESC' );
		if (!$with_read) {
			$query->addWhere ( 'n.is_read = ?', false );
		}
		if ($model_name) {
			$query->addWhere ( 'n.model_name = ?', $model_name );
		}else {
			$query->addWhere ( 'n.model_name != ?', 'Message' );
		}
		$notifications = $query->count ();
		return $notifications;
	}
public function getPlaceAdmin($company) {

		$pageAdmin = Doctrine::getTable ( 'PageAdmin' )->createQuery ( 'p' )
			
	        ->innerJoin ( 'p.UserProfile' )
	        ->where ( 'p.page_id = ?', $company->getCompanyPage ()->getId () )
	        ->andWhere ( 'p.user_id = ?', $this->getId () )
	        ->andWhere ( 'p.status = ?', 'approved' )
	        ->fetchOne();
		
		
		return $pageAdmin;
	
	}
}
