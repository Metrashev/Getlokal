<?php

class rssActions extends sfActions {
	
	
	public function executeNew() {
		$feed2 = new sfRss201Feed ();
		$i18n = sfContext::getInstance ()->getI18N ();
		
		$feed2->setTitle ( $i18n->__ ( 'Latest reviews and companies in getlokal.com', null, 'user' ) );
		$feed2->setLink ( 'rss/new' );
		$feed2->setAuthorEmail ( getlokalPartner::getEmailAddress () );
		$feed2->setAuthorName ( 'Getlokal' );
		$feed2->setLanguage ( $this->getUser ()->getCulture () );
		$country_id = getlokalPartner::getInstance ();
		$reviews = Doctrine::getTable ( 'Review' )->createQuery ( 'r' )->innerJoin ( 'r.Company c' )->where ( 'r.is_published = ?', Review::FRONTEND_REVIEWS_IS_PUBLISHED )->addWhere ( 'r.parent_id IS NULL' )->addWhere ( 'c.country_id = ?', $country_id )->addWhere ( 'c.status = ?', 0 )->orderBy ( 'r.created_at DESC' )->limit ( 10 )->execute ();
		
		foreach ( $reviews as $review ) {
			$company = $review->getCompany ();
			$item = new sfFeedItem ();
			$item->setTitle ( sprintf ( $i18n->__ ('%s for %s (%s)'), $review->getUserProfile (), $company->getCompanyTitle (), $review->getCompany ()->getCity ()->getLocation () ) );
			$item->setLink ( $company->getUri ( 'ESC_RAW' ) .'#review-'.$review->getId());
			$item->setAuthorName ( $review->getUserProfile () );
			$item->setAuthorLink ( '@user_page?username=' . $review->getUserProfile ()->getsfGuardUser ()->getUsername () );
			
			$item->setPubdate ( $review->getDateTimeObject ( 'created_at' )->format ( 'U' ) );
			$item->setDescription ( $this->feed_limit_words ( $review->getText (), 25, false ) );
			
			$feed2->addItem ( $item );
		}
		$companies = Doctrine::getTable ( 'Company' )->createQuery ( 'c' )->addWhere ( 'c.country_id = ?', $country_id )->addWhere ( 'c.status = ?', 0 )->orderBy ( 'c.created_at DESC' )->limit ( 10 )->execute ();
		foreach ( $companies as $company ) {
			
			$item = new sfFeedItem ();
			$item->setTitle ( sprintf ( $i18n->__ ('%s in %s'), $company->getCompanyTitle (), $review->getCompany ()->getCity ()->getLocation () ) );
			$item->setLink ( $company->getUri ( 'ESC_RAW' ) );
			$item->setAuthorName ( $company->getCreatedByUser () );
			$item->setAuthorLink ( '@user_page?username=' . $company->getCreatedByUser ()->getsfGuardUser ()->getUsername () );
			
			$item->setPubdate ( $review->getDateTimeObject ( 'created_at' )->format ( 'U' ) );
			$item->setDescription ( $this->feed_limit_words ( ($company->getDetailDescription () ? $company->getDetailDescription (ESC_RAW) : $company->getDisplayAddress ()), 25, false ) );
			
			$feed2->addItem ( $item );
		}
		$this->feed = $feed2;
	}
	
	protected function feed_limit_words($text, $limit = 25, $getlokal = false) {
		$explode = explode ( ' ', $text );
		$string = '';
		
		$dots = '...';
		if (count ( $explode ) <= $limit) {
			$dots = '';
			$limit = count ( $explode );
		}
		for($i = 0; $i < $limit; $i ++) {
			$string .= $explode [$i] . " ";
		}
		if ($getlokal == true) {
			$string = htmlspecialchars_decode ( $string );
			return $string . $dots;
		} else {
			return $string . $dots;
		}
	}
}