<?php
ini_set('max_execution_time', 6000);
set_time_limit(0);
ini_set('memory_limit','1024M');

require_once dirname(__FILE__).'/../lib/eventGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/eventGeneratorHelper.class.php';

/**
 * event actions.
 *
 * @package    getLokal
 * @subpackage event
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class eventActions extends autoEventActions
{
    public function executeMark(sfWebRequest $request)
    {
        $event = Doctrine::getTable('Event')->find($request->getParameter('id'));
        $this->forward404Unless($event);

        if ($event->recommended_at) {
            $event->recommended_at = NULL;
            $event->recommend = 0;
        } else {
            $event->recommended_at = date('Y-m-d H:i:s');
            $event->recommend = 1;
        }

        $event->save();

        $this->redirect($request->getReferer());
    }

    public function executeBatchApprove(sfWebRequest $request)
    {
        $ids = $request->getParameter('ids');
        $culture = 'bg';
        $records = Doctrine_Query::create()
            ->from('Event')
            ->whereIn('id', $ids)
            ->execute();

        foreach ($records as $event) {
            $event->setIsActive(true);
            $event->save();
        }
        $this->getUser()->setFlash('notice', 'The selected events have been approved successfully.');

        $this->redirect('@event');
    }

    public function executeBatchDisapprove(sfWebRequest $request)
    {
        $ids = $request->getParameter('ids');
        $records = Doctrine_Query::create()
            ->from('Event')
            ->whereIn('id', $ids)
            ->execute();

        foreach ($records as $event) {
            $event->setIsActive(false);
            $event->save();
        }
        $this->redirect('@event');
    }

    public function executeBatchSave(sfWebRequest $request)
    {
        $ids = $request->getParameter('ids');
        $records = Doctrine_Query::create()
            ->from('Event')
            ->whereIn('id', $ids)
            ->execute();

        foreach ($records as $event) {
            //$event->setIsActive(false);
            $event->save();
        }
        $this->redirect('@event');
    }
}
