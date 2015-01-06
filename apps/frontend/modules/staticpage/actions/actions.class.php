<?php

/**
 * offer actions.
 *
 * @package    getLokal
 * @subpackage offer
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class staticpageActions extends sfActions
{

    public function executeIndex(sfWebRequest $request)
    {
        $this->static_page= Doctrine_Core::getTable('StaticPage')
            ->findOneBySlug($request->getParameter('slug'));
        
        $this->slug = $request->getParameter('slug');
        $this->rootId = $this->static_page->getRootId();

        $this->forward404Unless($this->static_page && $this->static_page['is_active'] == true);

        $this->pageTitle = $this->static_page['title'];
        $request->setParameter('no_location', true);
        $this->getResponse()->setTitle($this->static_page['title']);

        if ($node = $this->static_page->getNode()) {
            $this->root = Doctrine_Core::getTable('StaticPage')->find($node->getRootValue());
        }
        
        if (is_object($this->static_page->getParent()) && (strpos($this->static_page->getParent()->getTitle(), 'Root') === false) 
        		&& $this->static_page->getParent()->getTitle() != '') {
        	breadCrumb::getInstance()->add($this->static_page->getParent()->getTitle(), '@static_page?slug='.$this->static_page->getParent()->getSlug());
        }
        breadCrumb::getInstance()->add($this->static_page['title'], null);

        if (
            $request->getParameter('slug') == 'our-team' &&
            $this->static_page
        ) {
            // Form creation...
            $this->form = new ContactForm();
        }
    }

    public function executeSendMailTo(sfWebRequest $request) {
        $i18n = sfContext::getInstance()->getI18N();

        $this->form = new ContactForm();

        if ($request->isMethod('post')) {
            $params = $request->getParameter($this->form->getName(), array());

            $this->form->bind($params);

            if ($this->form->isValid()) {
                $userId = $request->getParameter('userId');

                $emailsArray = sfConfig::get('app_our-team_email');

                if (in_array($userId, array_keys($emailsArray))) {
                    myTools::sendMail(
                        $emailsArray[$userId],
                        'Email from Team Page',
                        'teamMail',
                        array('user_data' => $params)
                    );
                }

                return $this->renderText(json_encode(array('SUCCESS' => 'true')));
            } else {
                $errors = array();

                foreach($this->form->getErrorSchema()->getErrors() as $field => $error) {
                    $errors[$field][] = $i18n->__($error->__toString(), null, 'form');
                }

                return $this->renderText(json_encode(array('SUCCESS' => 'false', 'ERRORS' => $errors)));
            }
        }

        exit();
    }

    public function executeHandlerAction() {
        $isAjax = $this->get('Request')->isXMLHttpRequest();
        if ($isAjax) {
            return new Response('This is ajax response');
        }
        return new Response('This is not ajax!', 400);
    }

    public function executeDiscoverCity(sfWebRequest $request) {
        $this->form = new TextMessageForm();
        if ($request->isMethod(sfRequest::POST)) {
            $this->form->bind($request->getPostParameters());
            $this->form->save();
        }
    }

}
