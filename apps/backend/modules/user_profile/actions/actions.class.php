<?php

require_once dirname(__FILE__).'/../lib/user_profileGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/user_profileGeneratorHelper.class.php';

/**
 * user_profile actions.
 *
 * @package    getLokal
 * @subpackage user_profile
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class user_profileActions extends autoUser_profileActions
{

  public function preExecute()
  {
    sfConfig::set('view_no_google_maps', true);
    parent::preExecute();
  }

  public function executeStats(sfWebRequest $request)
  {
    $this->forward404Unless($this->user = Doctrine::getTable('UserProfile')->find($request->getParameter('id')));

    $this->stats = $this->user->getUserStat();
  }

  public function executeDisallowContact(sfWebRequest $request)
  {
    $this->forward404Unless($this->user = Doctrine::getTable('UserProfile')->find($request->getParameter('id')));
    $setting = $this->user->getUserSetting();
    $setting->setAllowContact(false);
    $setting->setAllowNewsletter(false);
    $setting->setAllowBCmc(false);
    $setting->save();
    $newsletters =  $this->user->getNewsletterUser();
    if (count($newsletters) > 0)
    {
      foreach ($newsletters as $newsletter)
      {
        $newsletter->setIsActive(false);
        $newsletter->save();
      }
    }
    $this->getUser()->setFlash('notice', 'Unsubscribed from ' . count($newsletters) .' newsletters');
    $this->redirect('@user_profile');
  }

  public function executeFilter(sfWebRequest $request)
  {
    $this->setPage(1);

    if ($request->hasParameter('_reset'))
    {
      $this->setFilters($this->configuration->getFilterDefaults());

      $this->redirect('@user_profile');
    }

    $this->filters = $this->configuration->getFilterForm($this->getFilters());
    $this->filters->bind($request->getParameter($this->filters->getName()));
    if ($this->filters->isValid())
    {
      $this->setFilters($this->filters->getValues());
      // $params= $request->getParameter('user_profile_filters');
      if($request->getParameter('csv') == 'true')
      {
        ini_set('max_execution_time', 6000);
        set_time_limit(0);
        ini_set('memory_limit','1024M');

        $this->getResponse ()->clearHttpHeaders ();
        $this->getResponse ()->setHttpHeader ( 'Pragma-Type', 'public' );
        $this->getResponse ()->setHttpHeader ( 'Expires', '0' );
        $this->getResponse ()->setHttpHeader ( 'Content-Type', 'application/vnd.ms-excel;charset:UTF-8' );
        $this->getResponse ()->setHttpHeader ( 'Content-Disposition', 'attachment; filename=UserExport.xls' );
        $this->getResponse ()->setHttpHeader ( 'Content-Transfer-Encoding', 'binary' );
        $this->setLayout('csv');
      }
      else
      {
        $this->redirect('@user_profile');
      }
    }

    $this->pager = $this->getPager();
    $this->sort = $this->getSort();

    if ($request->getParameter('csv') == 'true')
    {
      $this->setTemplate('csvList');
    }
    else
    {
      $this->setTemplate('index');
    }
  }

  public function executeListShow(sfWebRequest $request)
  {
    $this->forward404Unless($this->user_profile = Doctrine::getTable('UserProfile')->find($request->getParameter('id')));

  }

  public function in_array_r($needle, $haystack, $strict = false) {
  	foreach ( $haystack as $item ) {
  		if (($strict ? $item === $needle : $item == $needle) || (is_array ( $item ) && $this->in_array_r ( $needle, $item, $strict ))) {
  			return true;
  		}
  	}
  
  	return false;
  }
  
  public function executeAutocomplete($request)
     {
     	/*if (!$countryId = $this->getUser()->getAttribute('registration_profile.countryId')) {
            $countryId = null;
        }*/
     	$domain = sfContext::getInstance()->getRequest()->getHost();
     	$domCom = (strstr($domain, '.my') || strstr($domain, '.com')) ? true : false;
        $countryId=sfContext::getInstance()->getUser()->getCountry()->getId();
        
        $culture = $this->getUser()->getCulture();
        $this->getResponse()->setContentType('application/json');

        $q = "%" . $request->getParameter('term') . "%";
        
        $limit = $request->getParameter('limit', 10);

        // FIXME: use $limit
        $dql = Doctrine_Query::create()
                ->from('City c')
                ->innerJoin('c.Translation ctr')
                ->where('ctr.name LIKE ? ',$q )
                ->limit($limit);

        if ($countryId && !$domCom) {
            $dql->innerJoin('c.County cnty')
                ->andWhere('cnty.country_id = ?', $countryId);
        }
        
        $this->rows = $dql->execute();
        $cities = $cities_names = array();

        $partner_class = getlokalPartner::getLanguageClass(getlokalPartner::getInstance());

        foreach ($this->rows as $city) {
            $cities [] = array(
                        'id' => $city ['id'],
                        'value' => $city->getCityNameByCulture() . ', ' . mb_convert_case($city->getCounty()->getName(), MB_CASE_TITLE, 'UTF-8').($domCom ? ' ('.$city ['id'].')' : '')
                    );
        }
        

        return $this->renderText(json_encode($cities));  	
  }
  
  public function executeGetCountriesAutocomplete(sfWebRequest $request) {
  	$culture = $this->getUser()->getCulture();
  	$domain = sfContext::getInstance()->getRequest()->getHost();
  	$domCom = (strstr($domain, '.my') || strstr($domain, '.com')) ? true : false;
  	$this->getResponse()->setContentType('application/json');
  
  	$q = "%" . $request->getParameter('term') . "%";
  
  	$limit = $request->getParameter('limit', 20);
  
  	// FIXME: use $limit
  	$dql = Doctrine_Query::create()->from('Country c')->where('c.name LIKE ? OR c.name_en LIKE ?', array($q, $q))->limit($limit);
  
  	$this->rows = $dql->execute();
  
  	$countries = array();
  
        foreach ($this->rows as $row) {
                $countries [] = array(
                        'id' => $row ['id'],
                        'value' => $row['name'].($domCom ? ' ('.$row ['id'].')' : '')
                );
        }
        
        
        /*
  	foreach ($this->rows as $row) {
  		if ($culture == 'en') {
  			$countries [] = array(
  					'id' => $row ['id'],
  					'value' => $row['name_en'].($domCom ? ' ('.$row ['id'].')' : '')
  			);
  		} else {
  			if ($row['name']) {
  				$countries [] = array(
  						'id' => $row ['id'],
  						'value' => $row['name'].($domCom ? ' ('.$row ['id'].')' : '')
  				);
  			} else {
  				$countries [] = array(
  						'id' => $row ['id'],
  						'value' => $row['name_en'].($domCom ? ' ('.$row ['id'].')' : '')
  				);
  			}
  		}
  	}
        */
  
  	return $this->renderText(json_encode($countries));
  }

}
