<?php

require_once dirname(__FILE__).'/../lib/get_weekendGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/get_weekendGeneratorHelper.class.php';

/**
 * get_weekend actions.
 *
 * @package    getLokal
 * @subpackage get_weekend
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class get_weekendActions extends autoGet_weekendActions
{
  public function executeAddCompany(sfWebRequest $request)
  {
    $this->forward404Unless($company = Doctrine::getTable('Company')->findOneBySlug($request->getParameter('slug')));
    
    $this->getResponse()->setContent($this->getPartial('company', array('company' => $company)));
    return sfView::NONE;
  }
  
  public function executeAddEvent(sfWebRequest $request)
  {
    $this->forward404Unless($company = Doctrine::getTable('Event')->find($request->getParameter('id')));
    
    $this->getResponse()->setContent($this->getPartial('event', array('event' => $company)));
    return sfView::NONE;
  }
}
