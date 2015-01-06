<?php
/**
 * home actions.
 *
 * @package    getLokal
 * @subpackage home
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class homeActions extends sfActions {
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    
    
    /** Calculating coordinates for county by all the cities in it **/
    
	public function mapCoordsCounty() {
		$queryBounds = Doctrine_Query::create()
		->select('c.lat as lat, c.lng as lng')
		->from('City c')
		->where('c.county_id = ?', $this->getUser()->getCounty()->getId())
		->fetchArray();
		 
		$south = $queryBounds[0]['lat'];
		$north = $queryBounds[0]['lat'];
		$west = $queryBounds[0]['lng'];
		$east = $queryBounds[0]['lng'];
	
		foreach ($queryBounds as $qb) {
			if ($south > $qb['lat'] && $qb['lat'] != NULL) {
				$south = $qb['lat'];
			}
			elseif ($north < $qb['lat'] && $qb['lat'] != NULL) {
				$north = $qb['lat'];
			}
			if ($west > $qb['lng'] && $qb['lng'] != NULL) {
				$west = $qb['lng'];
			}
			elseif ($east < $qb['lng'] && $qb['lng'] != NULL) {
				$east = $qb['lng'];
			}
		}

		return array($south, $west, $north, $east);		
	}
	
	public function getClassifications() {
	    $criteriaClassifications = Doctrine_Query::create()
	                                ->select('c.id')
	                                ->from('Classification c')
	                                ->innerJoin('c.ClassificationSector cs')
	                                ->innerJoin('c.Translation t')
	                                ->innerJoin('c.CompanyClassification cc')
	                                ->innerJoin('cc.Company cm');
	    if ($this->county) {
	        $criteriaClassifications = $criteriaClassifications
	                                    ->innerJoin('cm.City ci')
	                                    ->where('cs.sector_id = ?', $this->sector->getId ())
	                                    ->andWhere('ci.county_id = ?', $this->county->getId())
	                                    ->andWhere('t.is_active = 0 AND c.status = 1 AND cm.status = 0')
	                                    ->groupBy('c.id')
	                                    ->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR)
	                                    ->execute();
	    }
	    else {
	        $criteriaClassifications = $criteriaClassifications
	                                    ->where('cs.sector_id = ?', $this->sector->getId ())
	                                    ->addWhere('cm.city_id=?', $this->city->getId())
	                                    ->andWhere( 't.is_active = 0 AND c.status = 1 AND cm.status = 0')
	                                    ->groupBy('c.id')
	                                    ->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR)
	                                    ->execute();
	    }
	    
	    $this->classifications = Doctrine::getTable('Classification')
	                                ->createQuery('c')
	                                ->whereIn('c.id', $criteriaClassifications ? $criteriaClassifications : array(0))
	                                ->execute();
	    return $this->classifications;
	}
	
	public function executeIndex(sfWebRequest $request) {
		$this->domain = sfContext::getInstance()->getRequest()->getHost();
		$culture = $request->getParameter("sf_culture",false);
		if(!$culture){
			$culture = getlokalPartner::getDefaultCulture(getlokalPartner::getInstanceDomain());
			$request->setParameter("sf_culture",$culture);
		}
		
		//$user_is_same_culture = ($this->getUser()->getCountry()->getSlug() == $culture);
		$domain_country_id = getlokalPartner::getInstanceDomain();
		$this->getUser()->setCulture($culture);
		 
		 
//     	$request->setParameter('sf_culture',sfContext::getInstance()->getUser()->getCulture());
		/** Setting County instead of city **/

		if ((getlokalPartner::getInstanceDomain() == 78) || $request->getParameter('county', false)) {
			if ($this->getUser()->getAttribute('user.set_county_after_login', false)) {
				$this->getUser()->setAttribute('user.set_county_after_login', null);
				$this->redirect('@homeCounty?county=' . $this->getUser()->getCounty()->getSlug());
			}
			else {
				$user_country_id = $this->getUser()->getCountry()->getId();
				$slug = $request->getParameter('county');
				 
				// GETTING COUNTY FROM address slug "en/sofia"
				$this->county = County::getCountyByCountryAndSlug($domain_country_id, $slug);
				 
				// ELSE GETTING CITY FROM USER IF HE/SHE IS FROM THE SAME CULTURE" NOT TESTED
				//if (!$this->county) {
				//	if ($this->getUser()->getCounty() && $user_is_same_culture) {
				//		$this->county = $this->getUser()->getCounty();
				//	}
				//}
				 
				// ELSE GETTING CITY FROM `clicked_city`
				if (!$this->county){
					if ($this->getUser()->hasAttribute('clicked_county') && $this->getUser()->getAttribute('clicked_county', false)) {
						$this->county = County::getCountyByCountryAndSlug($domain_country_id, $this->getUser()->getAttribute('clicked_county'));
					}
				}
				 
				// ELSE GETTING DEFAULT CITY FOR THE CURRENT DOMAIN
				if(!$this->county){
					$this->county = County::getDefaultCounty($domain_country_id);
				}
				 
				$this->county = Doctrine::getTable('County')->find($this->county->getId());
				$this->getUser()->setCounty($this->county);

			}
			$this->countyName = $this->getUser()->getCounty()->getLocation('en');
			$this->countryName = $this->getUser()->getCounty()->getCountry()->getLocation('en');

			/** Coordinates for county by all the cities in it **/
			if (getlokalPartner::getInstanceDomain() != 78) {
				list($this->south, $this->west, $this->north, $this->east) = self::mapCoordsCounty();
			}
			$request->setParameter("county", $this->county->getSlug());
			if ($request->getParameter('county', false)) {
				$this->getUser()->setAttribute('clicked_county', $request->getParameter('county'));
				$this->getUser()->setAttribute('clicked_country', $this->getUser()->getCountry()->getId());
			}
// 			var_dump($this->getUser()->getCounty()->getSlug());die;
		}
		/**  End of setting  **/
		 
		else {
			if ($this->getUser()->getAttribute('user.set_city_after_login', false)) {
				$this->getUser()->setAttribute('user.set_city_after_login', null);

				$this->redirect('@home?city=' . $this->getUser()->getCity()->getSlug());
			}
			else {
				$user_country_id = $this->getUser()->getCountry()->getId();
				$city_slug = $request->getParameter('city');
				 
				// GETTING CITY FROM address slug "en/sofia"
				$this->city = City::getCityByCountryAndSlug($domain_country_id, $city_slug);
				
				// ELSE GETTING CITY FROM USER IF HE/SHE IS FROM THE SAME CULTURE"
				//if (!$this->city) {
				//	if ($this->getUser()->getCity() && $user_is_same_culture) {
				//		var_dump("GETTING CITY FROM address slug en/sofia");die;
				//		$this->city = $this->getUser()->getCity();
				//	}
				//}

				// ELSE GETTING CITY FROM `clicked_city`
				if (!$this->city){
					if ($this->getUser()->hasAttribute('clicked_city') && $this->getUser()->getAttribute('clicked_city', false)) {
						$this->city = City::getCityByCountryAndSlug($domain_country_id, $this->getUser()->getAttribute('clicked_city'));
					}
				}

				// ELSE GETTING DEFAULT CITY FOR THE CURRENT DOMAIN
				if(!$this->city){
					$this->city = City::getDefaultCity($domain_country_id);
				}

				//                 $this->redirect('@home?city=' . $city->getSlug());
				$this->getUser()->setCity($this->city);
			}
			$request->setParameter("city", $this->city->getSlug());
			
			if ($request->getParameter('city', false)) {
				$this->getUser()->setAttribute('clicked_city', $request->getParameter('city'));
				$this->getUser()->setAttribute('clicked_country', $this->getUser()->getCountry()->getId());
			}
		}

		 
		 
		$i18n = sfContext::getInstance()->getI18N();
		if ($request->getParameter('county', false)) {
			$meta = $this->getUser()->getCounty()->getLocation() . ' - '.$i18n->__('Going Out, Leisure, Health and Beauty, Shopping', null, 'pagetitle');
		}
		else {
			$meta = $this->getUser()->getCity()->getLocation() . ' - '.$i18n->__('Going Out, Leisure, Health and Beauty, Shopping', null, 'pagetitle');
		}

		$this->review = Doctrine::getTable('Review')->getTopReview();
        $this->event = Doctrine::getTable('Event')->getTopEvent();
        
		$this->getResponse()->addMeta('description', $meta);
		$this->getResponse()->addMeta('keywords', myTools::generateKeywords($meta));
	}
    
    public function executeSetCulture(sfWebRequest $request) {
        $this->getUser()->setCulture($request->getParameter('sf_culture'));

        $uri = str_replace($request->getUriPrefix(), '', $request->getReferer());
        $params = explode( '/', $uri);

        $i = 1;
        if ($params [1] == 'frontend_dev.php')
            $i = 2;

    //    if (in_array($params [$i], array ('ro', 'bg', 'en', 'fi')))
          if (in_array($params [$i], sfConfig::get('app_culture_slugs')))

            $params [$i] = $request->getParameter('sf_culture');

        $this->redirect($this->getRequest()->getUriPrefix().implode ('/', $params));
    }

    public function executeCategory(sfWebRequest $request) {
        if ($request->getParameter('county', false)) {
        	$this->forward404Unless ($this->county = Doctrine::getTable('County')->findOneBySlug($request->getParameter('county', '')));
        	$this->getUser()->setCounty($this->county);
        	
        	/** Coordinates for county by all the cities in it **/
        	if (getlokalPartner::getInstanceDomain() != 78) {
        	    list($this->south, $this->west, $this->north, $this->east) = self::mapCoordsCounty();
        	}
        }
        else {
        	$this->forward404Unless ($this->city = Doctrine::getTable('City')->findOneBySlug($request->getParameter('city', '')));
        	$this->getUser()->setCity($this->city);
        }
        $criteriaQuery = Doctrine_Query::create()->select('s.id')
                            ->from('Sector s')
                            ->innerJoin('s.Translation t')
                            ->where('t.slug = ? and t.lang=? ', array($request->getParameter ('slug'), $this->getUser()->getCulture()))
                            ->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR)
                            ->execute();
                          
        $query = Doctrine::getTable('Sector')
                         ->createQuery ('s')
                         ->whereIn('s.id', $criteriaQuery ? $criteriaQuery : array(0));

        $this->sector = $query->fetchOne();

        if (!$this->sector) {
            $criteriaSector = Doctrine_Query::create()->select('s.id')
                                ->from('Sector s')
                                ->innerJoin('s.Translation st')
                                ->innerJoin('s.SectorSlugLog sl')
                                ->where('sl.old_slug=? and sl.lang=?', array($request->getParameter('slug'), $this->getUser()->getCulture()))
                                ->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR)
                                ->execute();

            $this->sector = Doctrine::getTable('Sector')
                                ->createQuery('s')
                                ->whereIn('s.id', $criteriaSector ? $criteriaSector : array(0))
                                //->orWhere('st.slug=? and st.lang=? and st.id!=?', array($slug, $lang, $id) )
                                ->fetchOne();

            $this->forward404Unless($this->sector);
            
            if ($request->getParameter('county', false)) {
            	$this->redirect('sectorCounty', array('sf_culture' => $this->getUser()->getCulture(), //redirect to the new  sector slug url
            			'county' => $this->getUser()->getCounty()->getSlug(),
            			'slug' => $this->sector->getSlug()
            	), 301);
            }
            else {
            	$this->redirect('sector', array('sf_culture' => $this->getUser()->getCulture(), //redirect to the new  sector slug url
            			'city' => $this->city->getSlug(),
            			'slug' => $this->sector->getSlug()
            	), 301);
            }
        }
        
        breadCrumb::getInstance()->add($this->sector->getTitle());
        
        $this->classifications = self::getClassifications();

        $criteriaTopLocations = Doctrine_Query::create()->select('DISTINCT c.id')
                ->from('Company c')
                ->leftJoin('c.Image i')
                ->innerJoin('c.Location l')
                ->innerJoin('c.Classification cf')
                ->innerJoin('cf.ClassificationSector cs')
                ->innerJoin('cf.Translation')
        		->leftJoin('c.AdServiceCompany adc WITH adc.ad_service_id = 11 AND adc.active_from <= DATE('.ProjectConfiguration::nowAlt().') AND adc.status = "active" AND ((adc.active_to is null AND adc.crm_id is not null) OR (adc.active_to >= '.ProjectConfiguration::nowAlt().' AND  adc.crm_id is null))' );

        if ($this->county) {
            $criteriaTopLocations = $criteriaTopLocations->innerJoin('c.City ci')
	            ->where('cs.sector_id = ?', $this->sector->getId())
	            ->andWhere('c.status = ? ', CompanyTable::VISIBLE )
	            ->andWhere('ci.county_id = ?', $this->county->getId());
        }else {
            $criteriaTopLocations = $criteriaTopLocations->where('cs.sector_id = ?', $this->sector->getId())
	            ->andWhere('c.status = ? ', CompanyTable::VISIBLE )
	            ->andWhere('c.city_id = ?', $this->city->getId());
        }
        $criteriaTopLocations = $criteriaTopLocations
        	->addOrderBy ("adc.id IS NULL asc")
        	->addOrderBy('(c.average_rating < 3.00)')
        	->addOrderBy('i.id IS NULL')
	        ->addOrderBy ('c.number_of_reviews DESC')
        	->addOrderBy('RAND()')
	        ->limit(8)
	        ->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR)
	        ->execute();

        $this->topLocations = Doctrine::getTable('Company')
                                ->createQuery('c')
                                ->whereIn('c.id', $criteriaTopLocations ? $criteriaTopLocations : array(0))
                                ->execute();
//         var_dump($this->topLocations->toArray());die;
        $this->offers = array();

        $this->vips = array();

        $this->reviews = new Box();
        $this->reviews->setSettings(array('sector_id' => $this->sector->getId()));

        $i18n = sfContext::getInstance()->getI18N();
        $this->getResponse()->setTitle($this->sector->getPageTitle());

        $meta = sprintf($i18n->__('%s in getlokal - addresses, telephones, working hours and user reviews for %s in %s, %s', null, 'pagetitle'),
            $this->sector->getTitle(),
            $this->sector->getTitle(),
            ($this->city ? $this->city->getLocation() : $this->county->getLocation()),
            $this->sector->getMetaDescription());
        $this->getResponse()->addMeta('description', $meta);

        $this->getResponse()->addMeta('keywords', myTools::generateKeywords($meta));
    }

    public function executeDirectory(sfWebRequest $request) {
        $this->classifications = Doctrine::getTable('Classification')
                                        ->createQuery('c')
                                        ->innerJoin('c.Translation t WITH t.lang=?', sfContext::getInstance()->getUser()->getCulture())
                                        ->innerJoin('c.PrimarySector s')
                                        ->innerJoin('s.Translation st WITH st.lang=?', sfContext::getInstance()->getUser()->getCulture())
                                        ->where('t.is_active = 0 AND c.status = 1')
                                        ->addOrderBy('s.id')
                                        ->execute();

        //breadCrumb::getInstance ()->removeRoot ();
        breadCrumb::getInstance()->add('Directory', 'home/directory');

        $request->setParameter('no_location', true);
        $this->getResponse()->setTitle('Select a classification');


        $i18n = sfContext::getInstance()->getI18N();
        $meta = $i18n->__('Select a classification', null, 'pagetitle') .' - ' .  $this->getUser()->getCity()->getLocation();
        $this->getResponse()->addMeta('description', $meta);
        $this->getResponse()->addMeta('keywords', myTools::generateKeywords($meta));
    }

    public function executeClassification(sfWebRequest $request)
    {
    	if($request->getParameter('county', false)) {
    		$this->county = Doctrine::getTable('County')->findOneBySlug($request->getParameter('county', ''));
    		$this->forward404Unless($this->county);
    		$this->getUser()->setCounty($this->county);
    	}
    	else {
    		$this->city = Doctrine::getTable('City')->findOneBySlug($request->getParameter('city', ''));
    		$this->forward404Unless($this->city);
    		$this->getUser()->setCity($this->city);
    		$this->county = null;
    	}
    	
        $old_sector = false;

        $criteriaSector = Doctrine_Query::create()
                            ->select('s.id')
                            ->from('Sector s')
                            ->innerJoin('s.Translation t')
                            ->where('t.slug = ?', $request->getParameter('sector'))
                            ->andWhere('t.lang = ?', $this->getUser()->getCulture())
                            ->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR)
                            ->execute();
        
        $this->sector = Doctrine::getTable( 'Sector')
            ->createQuery('s')
            ->whereIn('s.id', $criteriaSector ? $criteriaSector : array(0))
            ->fetchOne();

        if (!$this->sector) {
            $this->sector = Doctrine::getTable('Sector')
                                ->createQuery('s')
                                ->innerJoin('s.Translation st')
                                ->innerJoin('s.SectorSlugLog sl')
                                ->where('sl.old_slug=? and sl.lang=?', array($request->getParameter('slug'), $this->getUser()->getCulture()))
                                ->fetchOne();

            if ($this->sector) {
                $old_sector = true;
            }

        }

        $this->classification = ClassificationTable::findOneBySlugLog($request->getParameter('slug'));

        $page = $request->getParameter('page', 1);

        // if is a string than it requires redirect
        if (is_string($this->classification)) {
        	if ($this->county) {
        		$redirect = sprintf('@classificationCounty?sector=%s&county=%s&slug=%s',
        				$this->sector->getSlug(),
        				$this->county->getSlug(),
        				$this->classification
        		);
        		if ($page > 1) {
        			$redirect .= "&page={$page}";
        		}
        		$this->redirect($redirect, 301);
        	}
        	else {
        		$redirect = sprintf('@classification?sector=%s&city=%s&slug=%s',
        				$this->sector->getSlug(),
        				$this->city->getSlug(),
        				$this->classification
        		);
        		if ($page > 1) {
        			$redirect .= "&page={$page}";
        		}
        		$this->redirect($redirect, 301);
        	}            
        }

        $this->forward404Unless($this->classification);

        if(!$this->sector)
        {
        	if ($this->county) {
        		$this->redirect('@classificationCounty?sector=' . $this->classification->getPrimarySector()->getSlug() . '&county='.$this->county->getSlug().'&slug='.$this->classification->getSlug(), 301);
        	}
        	else {
        		$this->redirect('@classification?sector=' . $this->classification->getPrimarySector()->getSlug() . '&city='.$this->city->getSlug().'&slug='.$this->classification->getSlug(), 301);
        	}
        }
        else
        {
            $check = Doctrine::getTable('ClassificationSector')
                        ->createQuery('cs')
                        ->where( 'cs.sector_id = ?', $this->sector->getId () )
                        ->addWhere( 'cs.classification_id=?', $this->classification->getId() )
                        ->fetchOne();
            if (!$check) {
            	if ($this->county) {
            		$this->redirect('@classificationCounty?sector=' . $this->classification->getPrimarySector()->getSlug() . '&county='.$this->county->getSlug().'&slug='.$this->classification->getSlug());
            	}
            	else {
            		$this->redirect('@classification?sector=' . $this->classification->getPrimarySector()->getSlug() . '&city='.$this->city->getSlug().'&slug='.$this->classification->getSlug());
            	}
            }
        }

        if ($old_sector) {
        	if ($this->county) {
        		if ($page == 1) {
        			$this->redirect( '@classificationCounty?sector='.$this->sector->getSlug().'&county='.$this->county->getSlug().'&slug='.$this->classification->getSlug(), 301);
        		} else {
        			$this->redirect( '@classificationCounty?sector='.$this->sector->getSlug().'&county='.$this->county->getSlug().'&slug='.$this->classification->getSlug().'&page='.$page, 301);
        		}
        	}
        	else {
                if ($page == 1) {
                    $this->redirect( '@classification?sector='.$this->sector->getSlug().'&city='.$this->city->getSlug().'&slug='.$this->classification->getSlug(), 301);
                } else {
                    $this->redirect( '@classification?sector='.$this->sector->getSlug().'&city='.$this->city->getSlug().'&slug='.$this->classification->getSlug().'&page='.$page, 301);
                }
        	}
        }
        
        if ($this->county) {
        	breadCrumb::getInstance()->add($this->sector->getTitle(), '@sectorCounty?county='.$this->county->getSlug(). '&slug=' . $this->sector->getSlug());
        	breadCrumb::getInstance()->add($this->classification->getTitle());
        }
        else {
        	breadCrumb::getInstance()->add($this->sector->getTitle(), '@sector?city='.$this->city->getSlug(). '&slug=' . $this->sector->getSlug());
        	breadCrumb::getInstance()->add($this->classification->getTitle());
        }
        
        if ($this->county) {
        	$query = Doctrine::getTable ( 'Company' )
        	            ->createQuery('c')
        	            ->leftJoin('c.Image')
        	            ->innerJoin('c.Location l')
        	            ->innerJoin('c.City ci')
        	            ->leftJoin ('c.Classification cf')
        	            ->innerJoin('c.CompanyClassification cc')
        	            ->innerJoin('cf.Translation')
        	            ->leftJoin('c.TopReview r')
        	            ->leftJoin('r.UserProfile p')
        	            ->leftJoin('p.sfGuardUser')
        	            ->leftJoin('c.AdServiceCompany adc WITH adc.ad_service_id = 11 AND adc.active_from <= '.ProjectConfiguration::nowAlt().' AND adc.status = "active"
                                    AND ((adc.active_to is null AND adc.crm_id is not null) OR (adc.active_to >= '.ProjectConfiguration::nowAlt().' AND  adc.crm_id is null))')
        	            ->andWhere('c.status = ?', CompanyTable::VISIBLE )
        	            ->andWhere('cc.classification_id = ?', $this->classification->getId())
        	            ->andWHere('ci.county_id = ?', $this->county->getId())
        	            ->orderBy('adc.id IS NOT NULL DESC, c.number_of_reviews DESC, c.average_rating DESC, c.company_number ');
        }
        else {
            $query = Doctrine::getTable ( 'Company' )
                        ->createQuery('c')
                        ->leftJoin('c.Image')
                        ->innerJoin('c.Location l')
                        ->innerJoin('c.City')
                        ->leftJoin ('c.Classification cf')
                        ->innerJoin('c.CompanyClassification cc')
                        ->innerJoin('cf.Translation')
                        ->leftJoin('c.TopReview r')
                        ->leftJoin('r.UserProfile p')
                        ->leftJoin('p.sfGuardUser')
                        ->leftJoin('c.AdServiceCompany adc WITH adc.ad_service_id = 11 AND adc.active_from <= '.ProjectConfiguration::nowAlt().' AND adc.status = "active"
                                    AND ((adc.active_to is null AND adc.crm_id is not null) OR (adc.active_to >= '.ProjectConfiguration::nowAlt().' AND  adc.crm_id is null))')
                        ->andWhere('c.status = ?', CompanyTable::VISIBLE )
                        ->andWhere('cc.classification_id = ?', $this->classification->getId())
                        ->andWHere('c.city_id = ?', $this->city->getId())
                        ->orderBy('adc.id IS NOT NULL DESC, c.number_of_reviews DESC, c.average_rating DESC, c.company_number ');
        }

        $this->pager = new sfDoctrinePager ( 'Company', 15 );
        $this->pager->setPage($request->getParameter('page', 1));
        $this->pager->setQuery($query);
        $this->pager->init();
        
        if($this->pager->getNbResults() == 0){
	        $this->getResponse()->setSlot("meta_noindex_follow",true);
        }
        $this->topLocations = $this->pager->getResults();
        
        $this->isClassification = true;

        $this->box = new Box();
        $this->box->setSettings(array('sector_id' => $this->sector->getId()));

        $this->classifications = self::getClassifications();
        $this->getResponse()->setTitle($this->classification->getPageTitle());

        $i18n = sfContext::getInstance()->getI18N();
        $meta = sprintf($i18n->__('%s in getlokal - addresses, telephones, working hours and user reviews for %s in %s, %s', null, 'pagetitle'),
            $this->classification->getTitle(),
            $this->classification->getTitle(),
            ($this->city ? $this->city->getLocation() : $this->county->getLocation()),
            $this->classification->getMetaDescription());

        $this->getResponse()->addMeta('description', $meta);
        $this->getResponse()->addMeta('keywords', myTools::generateKeywords($meta));
        
        $this->setTemplate('category');
    }

    public function executeError404(sfWebRequest $request) {
        $host = $request->getHost();
        $uri = str_replace( "http://" . $host, "", $request->getUri());
        $url = Doctrine::getTable('UrlMap')
                    ->createQuery('u')
                    ->where('? REGEXP u.old_url', $uri)
                    ->fetchOne();
        if ($url) {
            $redirect = $url->getNewUrl();
            preg_match('|' .$url->getOldUrl() . '|i', $uri, $matches);

            for($i = 1; $i < count ( $matches ); $i ++)
                $redirect = str_replace(sprintf ( '[$%d]', $i), $matches [$i], $redirect);

            $this->redirect($redirect, 301);

        }

        $request->setParameter('no_location', true);
        $this->getResponse()->setTitle( 'The page can\'t be found');
    }

    public function executeOldUrl(sfWebRequest $request) {
        $query = Doctrine::getTable('Company')
                        ->createQuery('c')
                        ->where('c.slug LIKE ?', '%' . $request->getParameter ('id'))
                        ->orWhere('c.company_number = ?', $request->getParameter( 'id'));

        $company = $query->fetchOne();
        //$this->forward404Unless($company = $query->fetchOne());
        if (!$company)
        {
            $this->redirect ( 'company/notFound', 410 );
        }
        $this->redirect($company->getUri (), 301);
    }

    public function executeBusiness(sfWebRequest $request) {
        breadCrumb::getInstance()->removeRoot();
    }

    public function executeLocations(sfWebRequest $request) {
        $old = false;
        $this->classification = Doctrine::getTable ( 'Classification' )
                                     ->createQuery('c')
                                     ->innerJoin('c.Translation t WITH t.lang = ?', $this->getUser()->getCulture())
                                     ->innerJoin('c.PrimarySector s')
                                     ->innerJoin('s.Translation st WITH st.lang = ?', $this->getUser()->getCulture())
                                     ->where('t.slug = ?', $request->getParameter('slug'))
                                     ->fetchOne();

        if (! $this->classification) {
            $this->classification = Doctrine::getTable('Classification')
                                          ->createQuery('c')
                                          ->innerJoin('c.Translation t WITH t.lang = ?', $this->getUser()->getCulture())
                                          ->where('t.old_slug = ?', $request->getParameter('slug' ))
                                          ->fetchOne();

            if ($this->classification) {
                $old = true;
            }
        }
        $this->forward404Unless($this->classification);
        
			$citiesId = Doctrine_Query::create()
						        ->select('c.city_id')
						        ->from('Company c')
						        ->innerJoin('c.Translation ctr WITH ctr.lang = ?', $this->getUser()->getCulture())
						        ->innerJoin ( 'c.CompanyClassification cc' )
						        ->innerJoin ( 'cc.Classification cl' )
						        ->innerJoin('cl.Translation t WITH t.lang = ?', $this->getUser()->getCulture())
						        ->where('cc.classification_id = ? ', $this->classification->getId())
						        ->addWhere('c.status = ?', CompanyTable::VISIBLE)
						        ->addWhere('c.country_id = ? ', $this->getUser()->getCountry()->getId())
						        ->andWhere('t.is_active = 0 AND cl.status = 1')
						        ->distinct()
						        ->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR)
						        ->execute();
        
			
			$this->locations = Doctrine::getTable('City' )->createQuery('s')
								->innerJoin('s.Translation str WITH str.lang = ?', $this->getUser()->getCulture())
								->whereIn('s.id', $citiesId ? $citiesId : array(0))
								->execute();
			
        /*
        $this->locations = Doctrine::getTable('City' )->createQuery('s')
                                ->innerJoin('s.Translation str')
                                ->innerJoin('s.Company c')
                                ->innerJoin('c.Translation ctr')
                                ->innerJoin ( 'c.CompanyClassification cc' )
                                ->innerJoin ( 'cc.Classification cl' )
                                ->innerJoin ( 'cl.Translation t' )
                                ->where('cc.classification_id = ? ', $this->classification->getId())
                                ->addWhere('c.status = ?', CompanyTable::VISIBLE)
                                ->addWhere('c.country_id = ? ', $this->getUser()->getCountry()->getId())
                                ->andWhere('t.is_active = 0 AND cl.status = 1')
                                ->addOrderBy('str.name')
                                ->distinct()
                                ->execute();
*/
        breadCrumb::getInstance()->add('Directory', 'home/directory');
        breadCrumb::getInstance()->add($this->classification->getTitle());
        //breadCrumb::getInstance ()->removeRoot ();

        /*
        $cities_names = array();
        $cities_dql = Doctrine_Query::create()->select('ctr.name')
                ->from('CityTranslation ctr')
                ->groupBy('ctr.name')
                ->having('COUNT(ctr.name) > 1');

        $this->cities_names = $cities_dql->fetchArray();
        
         * 
         */
        $request->setParameter('no_location', true);

        $this->getResponse ()->setTitle ( $this->classification->getTitle () . ' - ' . $this->classification->getPrimarySector ()->getTitle () );
        $meta = $this->classification->getTitle () . ' - ' . $this->classification->getPrimarySector ()->getTitle () .' - '. $this->getUser()->getCity()->getLocation();
        $this->getResponse()->addMeta('description', $meta);
        $this->getResponse()->addMeta('keywords', myTools::generateKeywords($meta));

        if ($old) {
            $this->redirect ( '@locations?sector=' . $this->classification->getPrimarySector ()->getSlug () . '&slug=' . $this->classification->getSlug (), 301 );
        }
    }

    public function executeSublevel(sfWebRequest $request) {

        $this->classification = Doctrine::getTable('Classification')
                                    ->createQuery('c')
                                    ->innerJoin('c.Translation t')
                                    ->where('t.slug = ?', $request->getParameter('slug'))
                                    ->fetchOne();
        $this->forward404Unless( $this->city = Doctrine::getTable('City')->findOneBySlug($request->getParameter('city')));
        $this->getUser()->setCity($this->city);
        $this->forward404Unless( $this->classification );
        $query = Doctrine::getTable('Sector')
                        ->createQuery('s')
                        ->innerJoin ('s.Translation t')
                        ->where('t.slug = ?', $request->getParameter ('sector'));

        $this->sector = $query->fetchOne();

        if (!$this->sector) { //sector query result is empty?
            $this->sector = Doctrine::getTable('Sector') //we check in sector slug log table
                                     ->createQuery('s')
                                     ->innerJoin('s.Translation t')
                                     ->leftJoin('s.SectorSlugLog sl')
                                     ->where('sl.old_slug = ?', $request->getParameter('sector'))
                                     ->addWhere('t.lang = sl.lang')
                                     ->fetchOne();

            $this->forward404Unless($this->sector);//asign sector with what we found
        }

        /*$query = Doctrine_Query::create ()->

        select ( 's.neighbourhood  nbh, COUNT(s.neighbourhood)  cnt' )->from ( 'CompanyLocation s' )->

        innerJoin ( 's.Company c ' )->where ( 'c.classification_id =  ' . $this->classification->getId () )->addWhere ( 'c.status = ? ', CompanyTable::VISIBLE )->addWhere ( 'c.city_id =  ' . $city->getId () )->addWhere ( 's.neighbourhood is not NULL AND s.neighbourhood != ""' )->addWhere ( 's.location_type IN (2,3,8)' )->addGroupBy ( 's.neighbourhood' )->addOrderBy ( 's.neighbourhood, s.location_type' );
        $this->locations = $query->execute ( array (), Doctrine_Core::HYDRATE_SCALAR );
        */
        $query = Doctrine_Query::create()
                        ->select('replace(replace(replace(cl.sublocation, "“","") ,"„" ,""), "”", "") nbh, COUNT(cl.sublocation)  cnt')
                        ->from('CompanyLocation cl')
                        ->innerJoin('cl.Company c ' )
                        ->where('c.classification_id =  ' . $this->classification->getId())
                        ->addWhere('c.status = ? ', CompanyTable::VISIBLE )
                        ->addWhere('c.city_id =  ' . $this->city->getId () )
                        ->addWhere('cl.sublocation is not null')
                        ->addWhere('cl.sublocation != ""')
                        ->addGroupBy('nbh')
                        ->addOrderBy('nbh');

        $this->locations = $query->execute(array(), Doctrine_Core::HYDRATE_SCALAR);

        if (count ( $this->locations ) == 0) {
            $this->redirect('@classification?sector=' . $this->sector->getSlug() . '&city=' . $this->city->getSlug() . '&slug=' . $this->classification->getSlug());
        }
        breadCrumb::getInstance()->add('Directory', 'home/directory');
        breadCrumb::getInstance()->add($this->classification->getTitle(), '@classification?sector=' . $this->sector->getSlug () . '&city=' . $this->city->getSlug() . '&slug=' . $this->classification->getSlug());
        breadCrumb::getInstance()->add('Locations', '@locations?sector=' . $this->sector->getSlug().'&slug='.$this->classification->getSlug());

        //breadCrumb::getInstance ()->removeRoot ();
    }

    public function executeOldClassification(sfWebRequest $request) {
        $this->forward404Unless ( $city = Doctrine::getTable ( 'City' )->findOneBySlug ( $request->getParameter ( 'city' ) ) );
        $this->getUser ()->setCity ( $city );

        $this->classification = Doctrine::getTable ( 'Classification' )->createQuery ( 'c' )->innerJoin ( 'c.Translation t' )->where ( 't.old_slug = ?', $request->getParameter ( 'old_slug' ) )->fetchOne ();

        $this->forward404Unless ( $this->classification );
        if ($this->classification)

            $page = $request->getParameter ( 'page', 1 );
        if ($page == 1) {
            $this->redirect ( '@classification?sector=' . $this->classification->getPrimarySector ()->getSlug () . '&city=' . $city->getSlug () . '&slug=' . $this->classification->getSlug (), 301 );
        } else {
            $this->redirect ( '@classification?sector=' . $this->classification->getPrimarySector ()->getSlug () . '&city=' . $city->getSlug () . '&slug=' . $this->classification->getSlug () . '&page=' . $page, 301 );
        }

    }
    public function executeStreetClassification(sfWebRequest $request) {

        $this->classification = Doctrine::getTable ( 'Classification' )
                ->createQuery ( 'c' )
                ->innerJoin ( 'c.Translation t' )
                ->where ( 't.slug = ?', $request->getParameter ( 'slug' ) )
                ->andWhere ( 't.is_active = 0 AND c.status = 1' )
                ->fetchOne ();
        if (! $this->classification) {
            $this->classification = Doctrine::getTable ( 'Classification' )
                                        ->createQuery('c')
                                        ->innerJoin('c.Translation t')
                                        ->where('t.old_slug = ?', $request->getParameter ( 'slug' ))
                                        ->fetchOne();
            if ($this->classification) {
                $page = $request->getParameter ( 'page', 1 );
                if ($page == 1) {
                    $this->redirect('@classification?sector=' . $this->classification->getPrimarySector()->getSlug() . '&city=' . $city->getSlug() . '&slug=' . $this->classification->getSlug(), 301 );
                } else {
                    $this->redirect('@classification?sector=' . $this->classification->getPrimarySector()->getSlug() . '&city=' . $city->getSlug() . '&slug=' . $this->classification->getSlug() . '&page=' . $page, 301 );
                }
            }
        }
        $this->forward404Unless ( $this->classification );
        $query = Doctrine::getTable ( 'Sector' )->createQuery ( 's' )->innerJoin ( 's.Translation t' )->where ( 't.slug = ?', $request->getParameter ( 'sector' ) );
        $this->forward404Unless ( $this->sector = $query->fetchOne () );

        $this->forward404Unless ( $this->city = Doctrine::getTable ( 'City' )->findOneBySlug ( $request->getParameter ( 'city', '' ) ) );
        $this->getUser ()->setCity ( $this->city );
        $partner_class = getlokalPartner::getLanguageClass ( getlokalPartner::getInstance () );

        if(method_exists('Transliterate' . $partner_class, 'toLocal')){
            $this->street = call_user_func ( array ('Transliterate' . $partner_class, 'toLocal' ), str_replace(array("“","„","”"), "", $request->getParameter ( 'street', '' )) );
        }
        else{
            $this->street = str_replace(array("“","„","”"), "", $request->getParameter ( 'street', '' )) ;
        }

        //breadCrumb::getInstance ()->removeRoot ();
        //breadCrumb::getInstance ()->add ( 'Directory', 'home/directory' );
        //breadCrumb::getInstance ()->add ( 'Locations', '@locations?sector=' . $this->sector->getSlug () . '&slug=' . $this->classification->getSlug () );
        breadCrumb::getInstance ()->add ( $this->sector->getTitle (), '@sector?city=' . $this->city->getSlug () . '&slug=' . $this->sector->getSlug () );
        breadCrumb::getInstance ()->add ( $this->classification->getTitle (), '@classification?slug=' . $this->classification->getSlug () . '&sector=' . $this->sector->getSlug () . '&city=' . $this->city->getSlug () );

        $query = Doctrine::getTable('Company')
                        ->createQuery('c')
                        ->leftJoin('c.Image')
                        ->innerJoin('c.Location l')
                        ->innerJoin('c.City')
                        ->leftJoin('c.Classification cf')
                        ->innerJoin('c.CompanyClassification cc')
                        ->innerJoin('cf.Translation')
                        ->leftJoin('c.TopReview r')
                        ->leftJoin('r.UserProfile p')
                        ->leftJoin('p.sfGuardUser')
                        ->leftJoin('c.AdServiceCompany adc WITH adc.ad_service_id = 11 AND adc.active_from <= '.ProjectConfiguration::nowAlt().' AND adc.status = "active"
                                     AND ((adc.active_to is null AND adc.crm_id is not null) OR (adc.active_to >= '.ProjectConfiguration::nowAlt().' AND  adc.crm_id is null))')
                        ->andWhere ( 'c.status = ?', CompanyTable::VISIBLE )
                        ->andWhere('cc.classification_id = ?', $this->classification->getId())
                        ->andWHere ( 'c.city_id = ?', $this->city->getId())
                       // ->andWhere('l.resublocation = ?', $this->street )
                        ->andWhere('replace(replace(replace(l.sublocation, "“","") ,"„" ,""), "”", "") = ?', $this->street )
                        ->orderBy('adc.id IS NOT NULL DESC, c.number_of_reviews DESC, c.average_rating DESC, c.company_number ');
                       // echo $this->street; exit();
                 
        $this->pager = new sfDoctrinePager ( 'Company', 15 );
        $this->pager->setPage ( $request->getParameter ( 'page', 1 ) );
        $this->pager->setQuery ( $query );
        $this->pager->init ();


        if ($this->pager->getNbResults () == 0) {
            $lang = getlokalPartner::getDefaultCulture ();

            $key = "AIzaSyDDZGSZsZTNuGUImUPcFXOEWObG6GX0I08";

            $address = urlencode ( $request->getParameter ( 'street' ) . ', ' . $this->city->getCityNameByCulture('en') );

            $url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&sensor=false&language=" . $lang;
            
            sfContext::getInstance()->getLogger()->emerg('GEOCODE: 2 WHERE: 1');

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
                //print_r($json_a ['results'] [0] ['address_components']); exit();
            	foreach ( $json_a ['results'] [0] ['address_components'] as $key => $val ) {
            		if ($this->in_array_r ( 'street', $val ) or $this->in_array_r ( 'route', $val )) {
                        $this->street = $val ['long_name'];
                        $remove = array('â€ž', '"', 'â€', 'â€œ');
                        $this->street = str_replace($remove, '', $this->street);
                        //echo $this->street; exit();
                    }
                }

            }
            if ($this->street) {
                $query1 = Doctrine::getTable('Company')
                                ->createQuery('c')
                                ->leftJoin('c.Image')
                                ->innerJoin( 'c.Location l')
                                ->innerJoin('c.City')
                                ->leftJoin('c.Classification cf')
                                ->innerJoin('c.CompanyClassification cc')
                                ->innerJoin('cf.Translation')
                                ->leftJoin('c.TopReview r')
                                ->leftJoin('r.UserProfile p')
                                ->leftJoin('p.sfGuardUser')
                                ->andWhere('c.status = ?', CompanyTable::VISIBLE )
                                ->andWhere('cc.classification_id = ?', $this->classification->getId () )
                                ->andWHere('c.city_id = ?', $this->city->getId())
                                //->andWhere ( 'l.sublocation = ?', $this->street )
                                ->andWhere ('replace(replace(replace(l.sublocation, "“","") ,"„" ,""), "”", "") = ?', $this->street )
                                ->orderBy('c.number_of_reviews DESC, c.average_rating DESC, c.company_number ');

                $this->pager = new sfDoctrinePager('Company', 15);
                $this->pager->setPage($request->getParameter( 'page', 1 ) );
                $this->pager->setQuery($query1 );
                $this->pager->init();

            }
            if ($this->pager->getNbResults() == 0) {
                $this->redirect('@classification?slug=' . $this->classification->getSlug() . '&sector=' . $this->sector->getSlug() . '&city=' . $this->city->getSlug());
            }
        }

        $this->box = new Box ();
        $this->box->setSettings(array('sector_id' => $this->sector->getId()));

        $this->classifications = Doctrine::getTable ( 'Classification' )
                                        ->createQuery('c')
                                        ->innerJoin('c.ClassificationSector cs')
                                        ->innerJoin('c.Translation t')
                                        ->where('cs.sector_id = ?', $this->sector->getId ())
                                        ->andWhere('t.is_active = 0 AND c.status = 1' )
                                        ->execute();
        if ($request->getParameter('street')) {
            $this->street_params = ($this->getUser()->getCulture() == 'en') ? $request->getParameter('street' ) : $this->street;
            $to_upper = explode(' ', $this->street_params);
            $i=0;
            foreach ($to_upper as $word)
            {
                $i++;
                if( $i != 1 )
                {
                    $words[] = mb_convert_case($word, MB_CASE_TITLE,'UTF-8');

                }else {
                    $words[] = $word;
                }

            }

            $this->street_params = implode(' ', $words);

            $request->setParameter ('street', $this->street_params );
        }
        $this->getResponse()->setTitle($this->classification->getTitle());
        $this->setTemplate('classification');
        $meta = $this->classification->getTitle () . ' - ' . $this->classification->getPrimarySector ()->getTitle () .' - '. $this->getUser()->getCity()->getLocation() .' - '.$request->getParameter('street');
        $this->getResponse()->addMeta('description', $meta);
        $this->getResponse()->addMeta('keywords', myTools::generateKeywords($meta));
    }
    protected function in_array_r($needle, $haystack, $strict = true) {
        foreach ( $haystack as $item ) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array ( $item ) && $this->in_array_r ($needle, $item, $strict ))) {
                return true;
            }
        }

        return false;
    }

    public function executeNotFound(sfWebRequest $request) {
        die; // temp solution for loop redirect
        $this->forward404(true);
    }

    public function executeEjobs(sfRequest $request) {

      
    }

    public function executeKeepalive(sfRequest $request) {
        
        $this->getResponse()->setContentType('application/json');

        return $this->renderText(json_encode(array('authenticated' => $this->getUser()->isAuthenticated())));
    }

    public function executeTopBanner(sfRequest $request) {
        $this->userCountry = myTools::getUserCountry();
    }
    
}
