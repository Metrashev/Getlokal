<?php

require_once dirname(__FILE__).'/../lib/staticpageGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/staticpageGeneratorHelper.class.php';

/**
 * staticpage actions.
 *
 * @package    getLokal
 * @subpackage staticpage
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class staticpageActions extends autoStaticpageActions
{

    public function preExecute()
    {
        // disable maps for this module
        sfConfig::set('view_no_google_maps', true);
        parent::preExecute();
    }

    protected function addSortQuery($query)
    {
        //don't allow sorting; always sort by tree and lft
        $query->addOrderBy('root_id, lft');
    }

    public function executeBatch(sfWebRequest $request)
    {
        if ("batchOrder" == $request->getParameter('batch_action'))
        {
            return $this->executeBatchOrder($request);
        }

        parent::executeBatch($request);
    }

    protected function buildQuery()
    {
        $query = parent::buildQuery();
        $root = $query->getRootAlias();

        $query->addWhere("{$root}.country_id = ?", $this->getUser()->getCountry()->getId());

        return $query;
    }

    public function executeDelete(sfWebRequest $request)
    {
        $request->checkCSRFProtection();

        $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

        $object = $this->getRoute()->getObject();
        if ($object->getNode()->isValidNode())
        {
            $object->getNode()->delete();
        }
        else
        {
            $object->delete();
        }

        $this->getUser()->setFlash('notice', 'The item was deleted successfully.');

        $this->redirect('@static_page');
    }

    public function executeChild(sfWebRequest $request)
    {
        $this->executeNew($request);
        $this->form->setDefaults(array(
            'parent' => $this->getRoute()->getObject()->getId(),
            // set default country from parent too
            'country_id' => $this->getRoute()->getObject()->getCountryId()
        ));

        $this->setTemplate('edit');
    }

    public function executeUp(sfWebRequest $request)
    {
        $node = $this->getRoute()->getObject()->getNode();
        if ($node->hasPrevSibling())
        {
            $prev = $node->getPrevSibling();
            if ($node->moveAsPrevSiblingOf($prev))
            {
                $this->getUser()->setFlash('notice', 'The node has been moved up!');
            }
        }

        $this->redirect('@static_page');
    }

    public function executeDown(sfWebRequest $request)
    {
        $node = $this->getRoute()->getObject()->getNode();
        if ($node->hasNextSibling())
        {
            $next = $node->getNextSibling();
            if ($node->moveAsNextSiblingOf($next))
            {
                $this->getUser()->setFlash('notice', 'The node has been moved down!');
            }
        }

        $this->redirect('@static_page');
    }

}
