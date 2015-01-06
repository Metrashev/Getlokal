<?php

require_once dirname(__FILE__).'/../lib/invited_userGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/invited_userGeneratorHelper.class.php';

/**
 * invited_user actions.
 *
 * @package    getLokal
 * @subpackage invited_user
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class invited_userActions extends autoInvited_userActions
{
    public function executeIndex(sfWebRequest $request)
    {
        error_reporting(E_ALL ^ E_NOTICE); //don`t show notices

        // sorting
        if ($request->getParameter('sort') && $this->isValidSortColumn($request->getParameter('sort')))
        {
            $this->setSort(array($request->getParameter('sort'), $request->getParameter('sort_type')));
        }

        // pager
        if ($request->getParameter('page'))
        {
            $this->setPage($request->getParameter('page'));
        }

        $this->pager = $this->getPager();
        $this->sort = $this->getSort();
    }

    protected function getPager($isCSV = false)
    {
        if ($isCSV) {
            $pager = new mySfDoctrinePager('InvitedUser', 190000);
        }
        else {
            $pager = new mySfDoctrinePager('InvitedUser', 15);
        }

        $pager->setQuery($this->buildQuery());
        $pager->setPage($this->getPage());
        $pager->setNbRes($this->__calculateNbRecords());
        $pager->init();

        return $pager;
    }

    private function __calculateNbRecords() {
        $vals = array();

        foreach ($this->filters->getDefaults() as $key => $value) {
            if ($key == 'email' && $value['text']) $vals[] = "email_address LIKE '%" . $value['text'] . "'";
            if ($key == 'first_name' && $value['text']) $vals[] = "first_name LIKE '%" . $value['text'] . "'";
            if ($key == 'last_name' && $value['text']) $vals[] = "last_name LIKE '%". $value['text'] . "'";
            if ($key == 'invited_from' && $value) $vals[] = "invited_from = '". $value . "'";
        }
        
        $res = implode(" and ", $vals);

        $query = "SELECT COUNT(DISTINCT iu.user_id) as cnt 
            FROM invited_user as iu
            INNER JOIN user_profile as up ON (iu.user_id = up.id) and up.country_id=".getlokalPartner::getInstance()."
            INNER JOIN sf_guard_user as sgu ON (sgu.id = up.id)
            ";
  
        if ($res) {
            $query .= "WHERE " . $res;
        }

        $con = Doctrine::getConnectionByTableName('invited_user');
        $result = $con->execute($query)->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
        return $result['cnt'];
    }

/*
    private function __calculateNbRecords() {
        $query = "SELECT COUNT(DISTINCT iu.user_id) as cnt FROM invited_user as iu";
        

        $con = Doctrine::getConnectionByTableName('invited_user');
        $result = $con->execute($query)->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
        return $result['cnt'];
    }
*/

    protected function buildQuery()
    {
        $tableMethod = $this->configuration->getTableMethod();

        if (null === $this->filters)
        {
            $this->filters = $this->configuration->getFilterForm($this->getFilters());
        }

        $this->filters->setTableMethod($tableMethod);

        $query = $this->filters->buildQuery($this->getFilters());

        $this->addSortQuery($query);

        $event = $this->dispatcher->filter(new sfEvent($this, 'admin.build_query'), $query);
        $query = $event->getReturnValue();

        return $query;
    }

    public function executeFilter(sfWebRequest $request)
    {
        error_reporting(E_ALL ^ E_NOTICE); //don`t show notices

        $this->setPage(1);

        if ($request->hasParameter('_reset'))
        {
            $this->setFilters($this->configuration->getFilterDefaults());

            $this->redirect('@invited_user');
        }

        $this->filters = $this->configuration->getFilterForm($this->getFilters());

        $this->filters->bind($request->getParameter($this->filters->getName()));

        if ($this->filters->isValid())
        {
            $this->setFilters($this->filters->getValues());

            if ($request->getParameter('csv') == 'true') {
                ini_set('max_execution_time', 6000);
                set_time_limit(0);
                ini_set('memory_limit', '1024M');
                $this->getResponse()->clearHttpHeaders();
                $this->getResponse()->setHttpHeader('Pragma-Type', 'public');
                $this->getResponse()->setHttpHeader('Expires', '0');
// XLS
//                $this->getResponse()->setHttpHeader('Content-Type', 'application/vnd.ms-excel;charset:UTF-8');
//                $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename=inv_export.xls');

// CSV
                $this->getResponse()->setHttpHeader('Content-Type', 'application/CSV'); // text/csv
                $this->getResponse()->setHttpHeader('Content-Disposition', 'attachment; filename=inv_export.csv');

                $this->getResponse()->setHttpHeader('Content-Transfer-Encoding', 'binary');
                $this->setLayout('csv');
            }
            else {
                $this->redirect('@invited_user');
            }
        }

        $this->pager = $this->getPager($request->getParameter('csv', false));
        $this->sort = $this->getSort();

        if ($request->getParameter('csv') == 'true') {
            $this->setTemplate('csvList');
        }
        else {
            $this->setTemplate('index');
        }
    }
}
