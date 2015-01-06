<?php

require_once dirname(__FILE__).'/../lib/imageGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/imageGeneratorHelper.class.php';

/**
 * image actions.
 *
 * @package    getLokal
 * @subpackage image
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class imageActions extends autoImageActions
{
	
	public function executeBatchApprove(sfWebRequest $request) {
	 if (!$ids = $request->getParameter('ids'))
    {
      $this->getUser()->setFlash('error', 'You must at least select one item.');

      $this->redirect('@image');
    }
    
    foreach ($ids as $id)
    {
    	$this->forward404Unless ( $image = Doctrine::getTable ( 'Image' )->find ( $id ) );
		$image->setStatus('approved');
		$image->save();
					
		$this->getUser()->setFlash('notice', 'The selected items have been approved successfully.');
			
		
    }
     $this->redirect('@image');
	}
    public function executeBatchDisapprove(sfWebRequest $request) {
	 if (!$ids = $request->getParameter('ids'))
    {
      $this->getUser()->setFlash('error', 'You must at least select one item.');

      $this->redirect('@image');
    }
    
    foreach ($ids as $id)
    {
    	$this->forward404Unless ( $image = Doctrine::getTable ( 'Image' )->find ( $id ) );
		$image->setStatus('rejected');
        $image->save();
		$this->getUser()->setFlash('notice', 'The selected items have been rejected successfully.');
	
    }
     $this->redirect('@image');
	}
}
