<?php

/**
 * Review
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Review extends BaseReview {
	const FRONTEND_REVIEWS_PER_TAB = 10;
	const FRONTEND_REVIEWS_PER_PAGE = 10;
	const FRONTEND_REVIEWS_IS_PUBLISHED = 1;
	const FRONTEND_REVIEWS_IS_NOT_PARENT = NULL;

	public function GetReviewType() {
		if ($this->getParentId ()) {
			return 'answer';
		} else {
			return 'review';
		}
	}

	public function getRatingProc() {
		return round ( ($this->getRating () / 5) * 100, 0 );
	}

	public function preInsert($event) {
		parent::preInsert ( $event );
		$this->text = strip_tags($this->text);
		if (!$this->getReferer()) {
			$from = sfContext::getInstance ()->getRequest ()->getCookie ( 'from' );
            if ($from) {
			    $this->setReferer ( $from );
            }
		}
	}

	public function postSave($event) {

		$review = Doctrine::getTable ( 'Review' )->createQuery ( 'r' )->where ( 'r.user_id = ?', $this->getUserId () )->count ();

		$review_classification = Doctrine::getTable ( 'Review' )->createQuery ( 'r' )->innerJoin ( 'r.Company c' )->where ( 'r.user_id = ?', $this->getUserId () )->andWhere ( 'c.classification_id = ?', $this->getCompany ()->getClassificationId () )->count ();

		$review_sector = Doctrine::getTable ( 'Review' )->createQuery ( 'r' )->innerJoin ( 'r.Company c' )->where ( 'r.user_id = ?', $this->getUserId () )->andWhere ( 'c.sector_id = ?', $this->getCompany ()->getSectorId () )->count ();

		Doctrine::getTable ( 'UserStat' )->updateStat ( $this->getUserId (), array ('reviews' => $review, 'review_classification_' . $this->getCompany ()->getClassificationId () => $review_classification, 'review_sector_' . $this->getCompany ()->getSectorId () => $review_sector ) );

		$main_review = Doctrine::getTable ( 'Review' )->createQuery ( 'r' )->where ( 'r.company_id = ?', $this->getCompanyId () )->orderBy ( 'r.recommended_at DESC, r.created_at DESC' )->andWhere ( 'r.parent_id IS NULL' )->andWhere ( 'r.is_published = 1' )->fetchOne ();

		$counts = Doctrine::getTable ( 'Review' )->createQuery ( 'r' )->select ( 'COUNT(r.id) count, AVG(r.rating) avg' )->where ( 'r.company_id = ?', $this->getCompanyId () )->andWhere ( 'r.parent_id IS NULL' )->andWhere ( 'r.is_published = ?', Review::FRONTEND_REVIEWS_IS_PUBLISHED )->fetchArray ();

		$company = $this->getCompany ();
		if ($main_review) {
			$company->setReviewId ( $main_review->getId () );
		} else {
			$company->setReviewId ( NULL );
		}
		if ($count = $counts [0]) {
			$company->setNumberOfReviews ( $count ['count'] );
			$company->setAverageRating ( $count ['avg'] );
		}

		$company->save ();
	}

	public function postInsert($event) {
		parent::postInsert ( $event );
		$activity = Doctrine::getTable ( 'ActivityReview' )->getActivity ( $this->getId () );
		$activity->setText ( $this->getText () );
		$activity->setCaption ( $this->getText () );
		$activity->setUserId ( $this->getUserId () );
		if ($this->getParentId())
		{
			$rev_activity = Doctrine::getTable ( 'ActivityReview' )->getActivity ( $this->getParentId() );
			if ($rev_activity){
				$activity->setActivityId ( $rev_activity->getId () );
			}
		}
		$activity->setPageId (  $this->getCompany ()->getCompanyPage()->getId() );
		$activity->setMediaId ( $this->getCompany ()->getImageId () );
		$activity->save ();
	}

	public function postDelete($event) {
		$company = $this->getCompany ();

		$counts = Doctrine::getTable ( 'Review' )->createQuery ( 'r' )->select ( 'COUNT(r.id) count, AVG(r.rating) avg' )->where ( 'r.company_id = ?', $this->getCompanyId () )->andWhere ( 'r.parent_id IS NULL' )->andWhere ( 'r.is_published = ?', Review::FRONTEND_REVIEWS_IS_PUBLISHED )->fetchArray ();

		if ($count = $counts [0]) { //exit($count['count']);
			$company->setNumberOfReviews ( $count ['count'] );
			$company->setAverageRating ( $count ['avg'] );
		}
		$company->save ();

	}

	public function getAnswers() {
		$answers = Doctrine_Core::getTable ( 'Review' )->createQuery ( 'r' )->where ( 'r.parent_id = ?', $this->getId () )->andWhere ( 'r.company_id = ?', $this->getCompanyId () )
      ->andWhere('r.is_published = ?', Review::FRONTEND_REVIEWS_IS_PUBLISHED)
      ->addOrderBy('r.created_at','DESC')->execute();
     if (count($answers)>0)
     {
     	return $answers;
     }
     return false;
  	}

  	public function save(Doctrine_Connection $con = NULL) {
  	    parent::save($con);

  	    if (mb_strlen($this->getText(), 'UTF-8') > 1000) {
  	        myTools::sendMailReview($this->getId());  	         
  	    }  	     
  	}
	
	public function getReviewsByCountry($countryId) {
        $query = Doctrine::getTable('Review')
                ->createQuery('r')
                ->innerJoin('r.Company c')
                ->where('c.country_id = ?', $countryId)
                ->andWhere('c.status = 0');

        if ($query) {
            return $query->count();
        }
        return;
    }
}
