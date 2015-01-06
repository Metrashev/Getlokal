<?php

require_once dirname(__FILE__).'/../lib/listsGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/listsGeneratorHelper.class.php';

/**
 * lists actions.
 *
 * @package    getLokal
 * @subpackage lists
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class listsActions extends autoListsActions
{
 public function executeGetCitiesAutocomplete(sfWebRequest $request) {
		$culture = $this->getUser ()->getCulture ();
		$this->getResponse ()->setContentType ( 'application/json' );
		
		$q = "%" . $request->getParameter ( 'q' ) . "%";
		
		$limit = $request->getParameter ( 'limit', 20 );
		
		// FIXME: use $limit
		$dql = Doctrine_Query::create ()->from ( 'City c' )->where ( 'c.name LIKE ? OR c.slug LIKE ?', array ($q, $q ) )->limit ( $limit );
		$this->rows = $dql->execute();
		$cities = $cities_names = array ();
		$cities_dql = Doctrine_Query::create ()->select('c.name')->from ( 'City c' )->groupBy('c.name')->having('COUNT(c.name) > 1');
		
		$cities_names = $cities_dql->fetchArray ();
		$partner_class = getlokalPartner::getLanguageClass ( getlokalPartner::getInstance () );
		
		foreach ( $this->rows as $row ) {
			if ($culture == 'en') {
				if (in_array($row->getName(), $cities_names[0])){
				$cities [$row ['id']] = $row->getLocation() . ', ' . mb_convert_case ( call_user_func ( array ('Transliterate' . $partner_class, 'toLatin' ), $row->getCounty ()->getName () ), MB_CASE_TITLE, 'UTF-8' );
				}else {
				$cities [$row ['id']] = $row->getLocation();	
				}
			} else {
			if (in_array($row->getName(), $cities_names[0])){
				$cities [$row ['id']] = $row->getName().', ' .$row->getCounty()->getName();
				}else {
				$cities [$row ['id']] = $row->getName();
				}
				
			}
		
		}
		
		return $this->renderText ( json_encode ( $cities ) );
	
	}

  public function executeBatchApprove(sfWebRequest $request) {
		$ids = $request->getParameter ( 'ids' );
		$culture='bg';
		$records = Doctrine_Query::create()
	      ->from('Lists')
	      ->whereIn('id', $ids)
	      ->execute();
		foreach ( $records as $list ) {			
			
			$list->setStatus('approved');
            $list->save();
			
		}
		$this->getUser ()->setFlash ( 'notice', 'The selected lists have been approved successfully.' );
		
		$this->redirect ( '@lists' );
	}
	
  public function executeBatchDisapprove(sfWebRequest $request) {
		$ids = $request->getParameter ( 'ids' );
		$records = Doctrine_Query::create()
	      ->from('Lists')
	      ->whereIn('id', $ids)
	      ->execute();
	      
		foreach ( $records as $list ) {
			
				$list->setStatus('rejected');
				$list->save();
		}
	$this->getUser ()->setFlash ( 'notice', 'The selected lists have been disapproved successfully.' );
	$this->redirect ( '@lists' );
  }
	
}
