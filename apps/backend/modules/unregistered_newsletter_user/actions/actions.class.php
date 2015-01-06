<?php

require_once dirname(__FILE__).'/../lib/unregistered_newsletter_userGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/unregistered_newsletter_userGeneratorHelper.class.php';

/**
 * unregistered_newsletter_user actions.
 *
 * @package    getLokal
 * @subpackage unregistered_newsletter_user
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class unregistered_newsletter_userActions extends autoUnregistered_newsletter_userActions
{
    /*
        WHERE 1,2 = COUNTRY ID
        Sergey	Stalev	xxx@xxx.com	1
        Vasya	Pupkin	vasya@abv.bg	2
        Kirill	Ivanov	kirill@yahoo.com	1
        Maria	Petrova	mariap@abv.bg	
        Sergey	Stalev	xxx@xxx.net	1
     */
    public function executeImportFromTxt(sfWebRequest $request) {
        if ($request->getMethod() == 'POST' && $files = $request->getFiles('txt')) {
            if (!$files['error']) {
                @move_uploaded_file($files['tmp_name'], sfConfig::get("sf_web_dir") . '/' . $files['name']);
                
                $path = sfConfig::get("sf_web_dir") . '/' . $files['name'];
                
                $fp = fopen($path, "r");
                $data = '';
                while(!feof($fp)) {
                    $data .= fread($fp, filesize($path));
                }

                fclose($fp);
/*
 if we have a country name
                // Get countries
                $query = Doctrine::getTable('Country')->createQuery('c');
                $results = $query->execute();
                $countriesArray = array();
                
                foreach ($results as $result) {
                    $countriesArray[$result->getNameEn()] = $result->getId();
                }
*/
                $dataArray = explode("\r\n", $data);

                foreach ($dataArray as $info) {
                    $data = explode("\t", $info);

                    if (strlen(trim($info)) && count($data)) {
                        $user = Doctrine::getTable('UnregisteredNewsletterUser')->findOneBy('email_address', $data[2]);

                        if (!$user) {
                            $user = new UnregisteredNewsletterUser();
                        }

                        if ($user) {
                            $user->setFirstname($data[0]);
                            $user->setLastname($data[1]);
                            $user->setEmailAddress($data[2]);

                            // Bulgaria by default
/*
if we have a country name
                            $cid = 1;

                            if (isset($data[3]) && $data[3] && in_array($data[3], array_keys($countriesArray))) {
                                $cid = $countriesArray[$data[3]];
                            }
*/
                            $cid = $data[3];

                            $user->setCountryId($cid);

                            $user->save();
                        }
                    }
                }

                @unlink($path);
            }

            $this->getUser()->setAttribute('showForm', false);
            $this->redirect('@unregistered_newsletter_user');
        }
        else {
            $this->getUser()->setAttribute('showForm', true);
            $this->forward('unregistered_newsletter_user', 'index');
        }

        $this->setTemplate('index');
        //$this->redirect('@unregistered_newsletter_user');
    }

    public function executeIndex(sfWebRequest $request)
    {
        $query = Doctrine::getTable('UnregisteredNewsletterUser')->createQuery();
        $users = $query->execute();

        foreach ($users as $user) {
            if (MC::checkInList($user->getEmailAddress(), $user->getCountryId(), 'UnregisteredUsers') === false) {
                $user->delete();
            }
        }


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
}
