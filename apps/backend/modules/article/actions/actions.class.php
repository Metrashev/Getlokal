<?php

require_once dirname(__FILE__).'/../lib/articleGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/articleGeneratorHelper.class.php';

/**
 * article actions.
 *
 * @package    getLokal
 * @subpackage article
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class articleActions extends autoArticleActions
{
	public function executeBatchApprove(sfWebRequest $request) {
		$ids = $request->getParameter ( 'ids' );
		$records = Doctrine_Query::create()
		->from('Article')
		->whereIn('id', $ids)
		->execute();
		foreach ( $records as $article ) {
				
			$article->setStatus('approved');
			$article->save();
				
		}
		$this->getUser ()->setFlash ( 'notice', 'The selected lists have been approved successfully.' );
	
		$this->redirect ( '@article' );
	}
	
	public function executeBatchDisapprove(sfWebRequest $request) {
		$ids = $request->getParameter ( 'ids' );
		$records = Doctrine_Query::create()
		->from('Article')
		->whereIn('id', $ids)
		->execute();
		 
		foreach ( $records as $article ) {
				
			$article->setStatus('rejected');
			$article->save();
		}
		$this->getUser ()->setFlash ( 'notice', 'The selected lists have been disapproved successfully.' );
		$this->redirect ( '@article' );
	}
	public function executeBatchSave(sfWebRequest $request) {
	
		//$ids = $request->getParameter ( 'ids' );
		$records = Doctrine_Query::create()
		->from('Article')
		//->whereIn('id', $ids)
		->execute();
		 
		foreach ( $records as $article ) {
				
			//$event->setIsActive(false);
			$article->save();
		}
		$this->redirect ( '@article' );
	}
}
