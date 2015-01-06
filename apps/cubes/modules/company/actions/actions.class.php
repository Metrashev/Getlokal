<?php

/**
 * api actions.
 *
 * @package    getLokal
 * @subpackage api
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class companyActions extends sfActions {
	protected function checkToken($token) {

		$return = false;

		if (! $token || ! $login = Doctrine::getTable ( 'CubesLogin' )->findOneByToken ( $token )) {
			$return = array ('status' => 'ERROR', 'error' => 'Invalid user token or token expired' );
		}

		if (! $return && $login->getDateTimeObject ( 'expires_at' )->format ( 'U' ) < time ()) {
			$return = array ('status' => 'ERROR', 'error' => 'Invalid user token or token expired' );
		}
		if ($return) {

			$this->getResponse ()->setContent ( json_encode ( $return ) );

			$this->forward ( 'company', 'stop' );

		} else {

			$is_getlokal_admin = (($login->getSfGuardUser () && in_array ( $login->getSfGuardUser ()->getId (), sfConfig::get ( 'app_getlokal_power_user', array () ) )) ? true : false);
			if (! $is_getlokal_admin) {
				$return = array ('status' => 'ERROR', 'error' => 'You Are Not Authorized to View This Page' );
				$this->getResponse ()->setContent ( json_encode ( $return ) );
				$this->forward ( 'company', 'stop' );
			}

			$this->token = $token;
			$this->getUser ()->setAttribute ( 'user_id', $login->getUserId (), 'sfGuardSecurityUser' );
			$this->getUser ()->setAuthenticated ( true );
			$this->getUser ()->clearCredentials ();
			$this->getUser ()->addCredentials ( $login->getsfGuardUser ()->getAllPermissionNames () );
			$this->user = $this->getUser ()->getGuardUser ();

		}

		return true;
	}
	public function executeCreate(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );
		sfForm::disableCSRFProtection ();
		$this->company = new Company ();

		$this->form = new CRMCompanyForm ( $this->company, array (), false );

		if ($request->isMethod ( 'post' )) {

			$this->processForm ( $request, $this->form );

			return sfView::NONE;
		}
		$this->setTemplate ( 'form' );
	}

	public function executeUpdate(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );
		$id = $request->getParameter ( 'id' );

		$this->object = Doctrine_Core::getTable ( 'Company' )->findOneById ( $id );
		if (! $this->object) {
			$return = array ('status' => 'ERROR', 'error' => 'Object Not Found' );
			$this->getResponse ()->setContent ( json_encode ( $return ) );
			return sfView::NONE;
		}

		sfForm::disableCSRFProtection ();
		$this->form = new CRMCompanyForm ( $this->object, array (), false );
		if ($request->isMethod ( 'post' )) {
			$this->processForm ( $request, $this->form );
			return sfView::NONE;
		}
		$this->setTemplate ( 'form' );
	}

	protected function processForm(sfWebRequest $request, sfForm $form) {
		$params = $request->getParameter ( $this->form->getName () );
		sfContext::getInstance ()->getConfiguration ()->loadHelpers ( 'Frontend' );
                
                
                
        $culture = sfContext::getInstance()->getUser()->getCountry()->getSlug();
        $partner_class = getlokalPartner::getLanguageClass();

        $cultures = sfConfig::get('app_languages_'.$culture);

        $params [$culture]['title'] = format_company_title ( $params [$culture]['title']);

        if (! isset ( $params ['en']['title'] ) or ($params ['en']['title'] == '')) {
            $params ['en']['title'] = format_company_title (call_user_func(array('Transliterate'.$partner_class, 'toLatin'),$params [$culture]['title']));

            if($this->form->getObject ()->isNew ()){
            	$params ['slug'] = Company::generateCompanySlug(myTools::cleanSlugString($params ['en']['title']));
            }        
        }
        else
        {
            $params ['en']['title'] = format_company_title ($params ['en']['title']);
            if($this->form->getObject ()->isNew ()){
            	$params ['slug'] = Company::generateCompanySlug(myTools::cleanSlugString($params ['en']['title']));
            }        
        }

        if(count($cultures)>2){
            foreach($cultures as $language){
                if ($culture !='en' && $language != $culture){
                    $current_culture = $language;
                }

                if (! isset ( $params [$current_culture]['title'] ) || ($params [$current_culture]['title'] == '')) {
                    if(method_exists('Transliterate'.$partner_class, 'to'.$current_culture)){
                        $params [$current_culture]['title'] = format_company_title (call_user_func(array('Transliterate'.$partner_class, 'to'.$current_culture),$params [$culture]['title']));
                    }
                    else{
                        $params [$current_culture]['title'] = format_company_title ($params [$culture]['title']);
                    }
                }else
                {
                    $params [$current_culture]['title'] = format_company_title ($params [$current_culture]['title']);
                }
            }
        }
                
                          
                /*
		$params ['title'] = format_company_title ( $params ['title'] );
		if (! isset ( $params ['title_en'] ) or ($params ['title_en'] == '')) {
			$partner_class = getlokalPartner::getLanguageClass ();
			$params ['title_en'] = format_company_title ( call_user_func ( array ('Transliterate' . $partner_class, 'toLatin' ), $params ['title'] ) );
		} else {
			$params ['title_en'] = format_company_title ( $params ['title_en'] );
		}
                 * 
                 */
		/*
		if (isset ( $params ['website_url'] ) && $params ['website_url'] != '' && stripos ( $params ['website_url'], 'http://' ) !== 0) {
			$params ['website_url'] = 'http://' . $params ['website_url'];
		}
		if (isset ( $params ['facebook_url'] ) && $params ['facebook_url'] != '' && stripos ( $params ['facebook_url'], 'http://' ) !== 0) {
			$params ['facebook_url'] = 'http://' . $params ['facebook_url'];
		}
		*/
		$city = Doctrine::getTable ( 'City' )->findOneById ( $params ['city_id'] );
		if ($city) {
			$params ['country_id'] = $city->getCounty ()->getCountryId ();
		}
		$this->form->bind ( $params );
		if (! $this->form->isValid ()) {
			$this->errors = $this->form->getAllErrors ();
			$return = array ('status' => 'ERROR', 'error' => $this->errors );
			$this->getResponse ()->setContent ( json_encode ( $return ) );

		} else {
			if (! $this->form->getObject ()->isNew ()) {
				$update = true;
				$this->object = $this->form->getObject ();

				if ($this->object->getStatus () == CompanyTable::NEW_PENDING && $params ['status'] == CompanyTable::VISIBLE) {
					if ($this->object->getCreatedBy ()) {
						$user_profile = $this->object->getCreatedByUser ();
						if ($user_profile) {
							$send_mail = ((in_array ( $this->object->getCreatedBy (), sfConfig::get ( 'app_getlokal_power_user', array () ) )) ? false : true);

						}
					}
				} elseif ($this->object->getStatus () == CompanyTable::NEW_PENDING && $params ['status'] == CompanyTable::REJECTED) {
					if ($this->object->getCreatedBy ()) {
						$user_profile = $this->object->getCreatedByUser ();
						if ($user_profile) {
							$send_mail2 = ((in_array ( $this->object->getCreatedBy (), sfConfig::get ( 'app_getlokal_power_user', array () ) )) ? false : true);

						}
					}
				}

			}

			$this->object = $this->form->save ();
			//if ($this->object->getCountryId () == getlokalPartner::GETLOKAL_BG) {
/*
				$name = Doctrine::getTable('SerbianNames')
				->createQuery ( 'sn' )
				->where('name = ?', $user_profile->getFirstName())
				->fetchOne();

				if ($name){
					$first_name =  $name->getSuffix();
				} else{
					$first_name =  $user_profile->getFirstName();
				}
*/
/*
                if (isset ( $send_mail ) && $send_mail) {
                    $first_name = $user_profile->getSpecialFirstName();
                    myTools::sendMail ( $user_profile, 'Approved Place on getlokal', 'place_approved', array ('profile' => $user_profile, 'company' => $this->object, 'firstName' => $first_name ) );
                }
*/
                if (isset ( $send_mail2 ) && $send_mail2) {
                    $first_name = $user_profile->getSpecialFirstName();
                    myTools::sendMail ( $user_profile, 'Rejected Place on getlokal', 'place_rejected', array ('profile' => $user_profile, 'company' => $this->object, 'firstName' => $first_name ) );
                }

			//}
			if (isset ( $update ) && $update) {

				$msg = array ('user' => $this->user, 'object' => 'company', 'action' => 'basicInfo', 'object_id' => $this->object->getId () );
				$this->dispatcher->notify ( new sfEvent ( $msg, 'user.write_log' ) );
				/*}*/
			} else {
				$msg = array ('user' => $this->user, 'object' => 'company', 'action' => 'create', 'object_id' => $this->object->getId () );
				$this->dispatcher->notify ( new sfEvent ( $msg, 'user.write_log' ) );

			}
			$return = array ('status' => 'SUCCESS', 'id' => $this->object->getId () );
			$this->getResponse ()->setContent ( json_encode ( $return ) );
		}

	}

	public function executeDelete(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );
		$id = $request->getParameter ( 'id' );

		$this->object = Doctrine_Core::getTable ( 'Company' )->findOneById ( $id );
		if (! $this->object) {
			$return = array ('status' => 'ERROR', 'error' => 'Company Not Found' );
			$this->getResponse ()->setContent ( json_encode ( $return ) );
			return sfView::NONE;
		}
		$this->object->setUser ( $this->getUser () );
		try {
			$con = Doctrine::getConnectionByTableName ( 'Company' );
			$con->beginTransaction ();

			if ($this->object->getCompanyPage ()->getPageAdmin ()) {
				foreach ( $this->object->getCompanyPage ()->getPageAdmin () as $admin ) {
					$admin->delete ();
				}
			}
			$this->object->getCompanyPage ()->delete ();
			$this->object->delete ();
			$con->commit ();
		} catch ( Exception $e ) {
			$con->rollBack ();
			$return = array ('status' => 'ERROR', 'error' => $e->getMessage () );
			$this->getResponse ()->setContent ( json_encode ( $return ) );
			return sfView::NONE;

		}

		$msg = array ('user' => $this->user, 'object' => 'company', 'action' => 'delete', 'object_id' => $id );
		$this->dispatcher->notify ( new sfEvent ( $msg, 'user.write_log' ) );

		$return = array ('status' => 'SUCCESS' );
		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}

	public function executeCheck(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );
		$id = $request->getParameter ( 'id' );

		$this->object = Doctrine_Core::getTable ( 'Company' )->findOneById ( $id );
		if (! $this->object) {
			$this->cnt = 0;
		} else {
			$this->cnt = 1;
		}
		$return = array ('status' => 'SUCCESS', 'cnt' => $this->cnt );
		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;

	}
	public function executeGetlink(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );
		$id = $request->getParameter ( 'id' );
		$this->object = Doctrine_Core::getTable ( 'Company' )->findOneById ( $id );
		if (! $this->object) {
			$return = array ('status' => 'ERROR', 'error' => 'Company Not Found' );
			$this->getResponse ()->setContent ( json_encode ( $return ) );
			return sfView::NONE;
		}
		$culture = mb_convert_case ( getlokalPartner::getLanguageClass (), MB_CASE_LOWER );
		$return = array ('status' => 'SUCCESS', 'link' => sfContext::getInstance ()->getConfiguration ()->generateFrontendUrl ( 'company_settings', array ('sf_culture' => $culture, 'slug' => $this->object->getSlug () ) ) );
		$link = sfContext::getInstance ()->getConfiguration ()->generateFrontendUrl ( 'company_settings', array ('sf_culture' => $culture, 'slug' => $this->object->getSlug () ), false );

		$this->redirect ( $link );

	}
	public function executeStop() {
		return sfView::NONE;
	}

	public function executeGetClassifiersAutocomplete(sfWebRequest $request) {
		$culture = $this->getUser ()->getCulture ();
		$this->getResponse ()->setContentType ( 'application/json' );

		$q = "%" . $request->getParameter ( 'q' ) . "%";
		$limit = $request->getParameter ( 'limit', 20 );

		$dql = Doctrine_Query::create ()->select ( 'id, t.title' )->from ( 'Classification c' )->innerJoin ( 'c.Translation t' )->where ( 't.title LIKE ? AND t.lang=? AND t.is_active = 0 AND c.status = 1', array ($q, $culture ) )->limit ( $limit );

		$this->rows = $dql->execute ();

		$classifiers = array ();

		if ($this->rows) {
			foreach ( $this->rows as $row ) {
				$classifiers [$row ['id']] = $row ['title'];

			}
		}
		return $this->renderText ( json_encode ( $classifiers ) );

	}

	public function executeCheckAdmins(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );

		$listadmins = array ();

		$id = $request->getParameter ( 'id' );
		$this->object = Doctrine_Core::getTable ( 'Company' )->findOneById ( $id );
		if (! $this->object) {
			$return = array ('status' => 'ERROR', 'error' => 'Company Not Found' );
			$this->getResponse ()->setContent ( json_encode ( $return ) );
			return sfView::NONE;
		}

		$allapprovedadmins = $this->object->getApprovedAdmins ();
		if (count ( $allapprovedadmins ) > 0) {
			foreach ( $allapprovedadmins as $allapprovedadmin ) {
				$listadmins [$allapprovedadmin->getId ()] = $allapprovedadmin->getUserProfile ()->getId ();
			}
		}
		$return = array ('status' => 'SUCCESS', 'admins' => $listadmins );
		$this->getResponse ()->setContent ( json_encode ( $return ) );
		return sfView::NONE;
	}

	public function executeMerge(sfWebRequest $request) {
		$this->checkToken ( $request->getParameter ( 'token' ) );

		$company_1_id = $request->getParameter ( 'company1_id' );
		$company_2_id = $request->getParameter ( 'company2_id' );

		$this->action = 'merge';

		$this->object = Doctrine_Core::getTable ( 'Company' )->findOneById ( $company_1_id );
		if (! $this->object) {
			$return = array ('status' => 'ERROR', 'error' => 'First Company Not Found' );
			$this->getResponse ()->setContent ( json_encode ( $return ) );
			return sfView::NONE;
		}
		$this->object_to_hide = Doctrine_Core::getTable ( 'Company' )->findOneById ( $company_2_id );
		if (! $this->object_to_hide) {
			$return = array ('status' => 'ERROR', 'error' => 'Second Company Not Found' );
			$this->getResponse ()->setContent ( json_encode ( $return ) );
			return sfView::NONE;
		}
		$con = Doctrine::getConnectionByTableName ( 'Company' );
		try {
			$con->beginTransaction ();
			/*
		 * sfForm::disableCSRFProtection ();
		   $this->form = new CRMCompanyForm ( $this->object, array (), false );
		   if ($request->isMethod ( 'post' )) {
			 $this->processForm ( $request, $this->form );
			 if (isset($this->errors))
			 {
				return sfView::NONE;
			 }
			*/
			$reviews = $this->object_to_hide->getReview ();

			if (count ( $reviews ) > 0) {
				foreach ( $reviews as $review ) {
					$review->setCompanyId ( $this->object->getId () );
					$review->save ();
				}
			    if (!$this->object->getReviewId() && $this->object_to_hide->getReviewId()){
					$this->object->setReviewId($this->object_to_hide->getReviewId());
				    $this->object->save();
				}
			}
			$company_images = $this->object_to_hide->getCompanyImage ();

			if (count ( $company_images ) > 0) {
				foreach ( $company_images as $company_image ) {
					$company_image->setCompanyId ( $this->object->getId () );
					$company_image->save ();
				}
				if (!$this->object->getImageId() && $this->object_to_hide->getImageId()){

					$this->object->setImageId($this->object_to_hide->getImageId());
				    $this->object->save();
				}
			}



			$page_admins = $this->object_to_hide->getCompanyPage ()->getPageAdmin ();

			if (count ( $page_admins ) > 0) {
				foreach ( $page_admins as $page_admin ) {
					$page_admin->setPageId ( $this->object->getCompanyPage ()->getId () );

					$page_admin->save ();
				}
			}
			$page_events = $this->object_to_hide->getCompanyPage ()->getEventPage ();

			if (count ( $page_events ) > 0) {
				foreach ( $page_events as $page_event ) {
					$page_event->setPageId ( $this->object->getCompanyPage ()->getId () );

					$page_events->save ();
				}
			}

			$page_lists = $this->object_to_hide->getCompanyPage ()->getListPage ();

			if (count ( $page_lists ) > 0) {
				foreach ( $page_lists as $page_list ) {
					$page_list->setPageId ( $this->object->getCompanyPage ()->getId () );
					$page_list->save ();
				}
			}

			$all_orders = $this->object_to_hide->getAdServiceCompany ();

			if (count ( $all_orders ) > 0) {
				foreach ( $all_orders as $order ) {

					$order->setCompanyId ( $this->object->getId () );
					$order->save ();
				}
			}

		    $statistics = $statistics_old = $stats_old = $new_statistics = array ();
			$stats_old = $this->object_to_hide->getCompanyStats ();

			if (count ( $stats_old ) > 0) {
				foreach ( $stats_old as $stat ) {
					$statistics_old [$stat ['month']] [$stat ['action_id']]= $stat ['views'] ;
				}
			}

			$stats = $this->object->getCompanyStats ();

			if (count ( $stats ) > 0) {
				foreach ( $stats as $stat ) {
					$statistics [$stat ['month']][$stat ['action_id']] = $stat ['views'] ;
				}
			}

			foreach ( $statistics_old as $key => $val ) {

				if (array_key_exists ( $key, $statistics )) {

					foreach ( $val as $val_key => $val_val ) {

						if (array_key_exists ( $val_key, $statistics [$key] )) {

							$statistics [$key][$val_key] =  $val_val + $statistics [$key] [$val_key] ;
						}else {
							$statistics [$key][$val_key]=  $val_val;
						}
					}

				}
			}

			if (! empty ( $statistics )) {
				foreach ( $statistics as $new_key => $new_val ) {
					foreach ( $new_val as $val_key => $val_val ) {
						$query = Doctrine::getTable ( 'CompanyStats' )->createQuery ( 'cs' )->where ( 'cs.company_id = ? ', $this->object->getId () )->andWhere ( 'cs.month = ? ', $new_key )->andWhere ( 'cs.action_id = ? ', $val_key );
						$stata = $query->fetchOne ();
						if ($stata) {
							$stata->setViews ( $val_val );
							$stata->save ();
						} else {
							$stata = new CompanyStats ();
							$stata->setCompanyId ( $this->object->getId () );
							$stata->setMonth ( $new_key );
							$stata->setActionId ( $val_key );
							$stata->setViews ( $val_val );
							$stata->save ();
						}
					}
				}
			}

			$company_offers = $this->object_to_hide->getCompanyOffer ();

			if (count ( $company_offers ) > 0) {
				foreach ( $company_offers as $company_offer ) {
					$company_offer->setCompanyId ( $this->object->getId () );
					$company_offer->save ();
				}
			}
			/*
			$company_articles = $this->object_to_hide->getArticleCompany ();

			if (count ( $company_articles ) > 0) {
				foreach ( $company_articles as $company_article ) {
					$company_article->setCompanyId ( $this->object->getId () );
					$company_article->save ();
				}
			}
			*/
			$company_getweekends = $this->object_to_hide->getGetWeekendCompany ();

			if (count ( $company_getweekends ) > 0) {
				foreach ( $company_getweekends as $company_getweekend ) {
					$company_getweekend->setCompanyId ( $this->object->getId () );
					$company_getweekend->save ();
				}
			}

			$place_features = Doctrine::getTable ( 'PlaceFeature' )->createQuery ( 'pf' )->where ( 'pf.page_id = ? ', $this->object_to_hide->getCompanyPage ()->getId () )->execute ();

			if (count ( $place_features ) > 0) {
				foreach ( $place_features as $place_feature_vote ) {
					$place_feature_vote->setPageId ( $this->object->getCompanyPage ()->getId () );
					$place_feature_vote->save ();
				}
			}

			$this->object_to_hide->updateAvg_NumberOf_Reviews ();
			$this->object_to_hide->setStatus ( CompanyTable::INVISIBLE );
			$this->object_to_hide->save ();

			$con->commit ();
		} catch ( Exception $e ) {
			$con->rollback ();
		echo ($e->getMessage());
			$return = array ('status' => 'ERROR', 'error' => 'Error while merging companies. Contact your sys admin' );
			$this->getResponse ()->setContent ( json_encode ( $return ) );
			return sfView::NONE;

		}
		$msg = array ('user' => $this->user, 'object' => 'company', 'action' => 'merge', 'object_id' => $this->object->getId () );
		$this->dispatcher->notify ( new sfEvent ( $msg, 'user.write_log' ) );

		$msg = array ('user' => $this->user, 'object' => 'company', 'action' => 'merged', 'object_id' => $this->object_to_hide->getId () );
		$this->dispatcher->notify ( new sfEvent ( $msg, 'user.write_log' ) );

		$return = array ('status' => 'SUCCESS', 'object_id' => $this->object->getId () );
		$this->getResponse ()->setContent ( json_encode ( $return ) );

		return sfView::NONE;
		/*}
		$this->setTemplate ( 'form' );*/

	}

}
