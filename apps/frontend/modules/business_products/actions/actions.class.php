<?php

/**
 * business_products actions.
 *
 * @package    getLokal
 * @subpackage business_products
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class business_productsActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  	$slug = $request->getParameter('slug');
  	if ($slug == 'PPP') {
  		$this->setTemplate('ppp');  	
  	}
  	else if ($slug == 'PPPm') {
  		$this->setTemplate('PPPm');
  	}
  	else if ($slug == 'DEAL') {
  		$this->setTemplate('DEAL');
  	}
  	else {
  		$this->redirect('homepage');
  	}
  }
 
  
  public function executeEating(sfWebRequest $request)
  {
  	$this->companies = Doctrine_Core::getTable('Company')
  	->createQuery('c')
  	->innerJoin('c.City ci')
  	->leftJoin('c.Image im')
  	->where("c.country_id = ? AND ci.slug = ? AND c.sector_id = '8' AND c.status = '0' AND c.average_rating > 0.00 AND c.image_id is not null and c.image_id != '' ", array(getlokalPartner::getInstance(),$request->getParameter('slug')) )
  	->limit(30)
  	->orderBy("rand()")
  	->execute();
  	
  	$this->city = Doctrine_Core::getTable('City')->findOneBy('slug', $request->getParameter('slug'));
  	$this->slug = $request->getParameter('slug');
  	$this->source = $request->getParameter('source');
  	$this->medium = $request->getParameter('medium');
  	$this->term = $request->getParameter('term');
  	$this->campaign = $request->getParameter('campaign');
  	//$this->w = $request->getParameter('w');
  	//print_r(count($this->companies));exit();
  	$this->setTemplate('eatingOut');
  }

  public function executeBig(sfWebRequest $request)
  {
  	$this->companies = Doctrine_Core::getTable('Company')
  	->createQuery('c')
  	->innerJoin('c.City ci')
  	->leftJoin('c.Image im')
  	->where("c.country_id = ? AND ci.slug = ? AND c.sector_id = '8' AND c.status = '0' AND c.average_rating > 0.00 AND c.image_id is not null and c.image_id != '' ", array(getlokalPartner::getInstance(),$request->getParameter('slug')) )
  	->limit(30)
  	->orderBy("rand()")
  	->execute();
  	 
  	$this->city = Doctrine_Core::getTable('City')->findOneBy('slug', $request->getParameter('slug'));
  	$this->slug = $request->getParameter('slug');
  	$this->source = $request->getParameter('source');
  	$this->medium = $request->getParameter('medium');
  	$this->term = $request->getParameter('term');
  	$this->campaign = $request->getParameter('campaign');
  	//$this->w = $request->getParameter('w');
  	//print_r(count($this->companies));exit();
    $this->setTemplate('eatingOut4');
  }
  
}
