<?php

/**
 * messages actions.
 *
 * @package    ibuzz
 * @subpackage messages
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class messageActions extends sfActions {
	/**
	 * Executes index action
	 *
	 */
	public function preExecute() {
		$this->is_place_admin_logged = false;
		$this->user = $this->getUser ()->getGuardUser ();
		if ($this->getUser ()->getPageAdminUser ()) {
			$this->is_place_admin_logged = true;
			$this->page = $this->getUser ()->getPageAdminUser ()->getCompanyPage ();
		} else {
			$this->page = $this->user->getUserProfile ()->getUserPage ();
		}
	
	}
	
	public function executeCompose(sfWebRequest $request) {
		
		$this->form = new MessageForm ();
		if ($request->getParameter ( 'username' )) {
			$this->user_to = Doctrine::getTable ( 'sfGuardUser' )->findOneByUsername ( $request->getParameter ( 'username' ) );
			$this->forward404Unless ( $this->user_to );
			
			$this->page_to = $this->user_to->getUserProfile ()->getUserPage ();
			$this->forward404Unless ( $this->page_to );
			$page_id = $this->page_to->getId ();
			$this->configFollow ( $this->user_to, $this->page->getId () );
		}
		
		if ($request->isMethod ( 'post' )) {
			$this->form->bind ( $request->getParameter ( $this->form->getName () ) );
			if ($this->form->isValid ()) {
				$message = $this->form->updateObject ();
				if (! isset ( $page_id )) {
					$page_id = $message->getPageId ();
				}
				
				$conversation = Doctrine::getTable ( 'Conversation' )->getConversation ( $this->page->getId (), $page_id );
				
				$message->setPageId ( $this->page->getId () );
				$conversation->setNewMessage ( $message );
				$this->dispatcher->notify ( new sfEvent ( $message, 'social.write_message' ) );
				$this->redirect ( 'message/view?user=' . $page_id );
			}
		}
	}
	
	public function configFollow($user, $page_id) {
		$this->follow = Doctrine::getTable ( 'FollowPage' )->getFollowPage ( $user->getId (), $page_id );
		if (! $this->follow) {
			$this->getUser ()->setFlash ( 'error', 'You are not allowed to send message to the selected user' );
			
			$this->redirect ( 'message/index' );
		}
	}
	
	public function executeView(sfWebRequest $request) {
		$this->forward404Unless ( $this->page_to = Doctrine::getTable ( 'Page' )->find ( $this->getRequestParameter ( 'user' ) ) );
		
		$message = new Message ();
		$message->setPageId ( $this->page_to->getId () );
		$this->form = new MessageForm ( $message );
		
		if ($request->isMethod ( 'post' )) {
			$this->form->bind ( $request->getParameter ( $this->form->getName () ) );
			if ($this->form->isValid ()) {
				$message = $this->form->updateObject ();
				$conversation = Doctrine::getTable ( 'Conversation' )->getConversation ( $this->page->getId (), $this->page_to->getId () );
				
				$message->setPageId ( $this->page->getId () );
				$conversation->setNewMessage ( $message );
				$this->dispatcher->notify ( new sfEvent ( $message, 'social.write_message' ) );
				$return_partial = true;
			
		//$this->redirect('message/view?user='. $this->page_to->getId());
			}
		}
		
		$this->conversation = Doctrine::getTable ( 'Conversation' )->getConversation ( $this->page->getId (), $this->page_to->getId () );
		
		if (! $this->conversation->getOpened ()) {
			$this->conversation->setOpened ( true );
			$this->conversation->save ();
		}
		
		$this->messages = Doctrine::getTable ( 'Message' )
		->createQuery ( 'm' )
		->where ( 'm.conversation_id = ?', $this->conversation->getId () )
		->orderBy ( 'm.created_at ASC' )->execute ();
		
		if (isset ( $return_partial ) && $return_partial) {
			
			$this->getResponse ()->setContent ( $this->getPartial ( 'messages', array ('messages' => $this->messages, 'form' => $this->form, 'user' => $this->user, 'page_to' => $this->page_to, 'page'=>$this->page ) ) );
			return sfView::NONE;
		
		}
	}
	
	public function executeIndex() {
		
		$query = Doctrine::getTable ( 'Conversation' )->createQuery ( 'c' )->innerJoin ( 'c.Message m' )->innerJoin ( 'c.ToPage' )->where ( 'c.page_from = ?', $this->page->getId () )->orderBy ( 'c.updated_at DESC' );
		
		$pager = new sfDoctrinePager ( 'Conversation', 30 );
		$pager->setQuery ( $query );
		$pager->setPage ( $this->getRequestParameter ( 'page', 1 ) );
		$pager->init ();
		
		$this->pager = $pager;
	}
	
	public function executeDelete(sfWebRequest $request) {
		$query = Doctrine::getTable ( 'Conversation' )->createQuery ( 'c' )->where ( 'c.page_from = ?', $this->page->getId () )->andWhere ( 'c.id = ?', $request->getParameter ( 'id' ) );
		$this->forward404Unless ( $conversation = $query->fetchOne () );
		
		$conversation->delete ();
		$this->redirect ( $request->getReferer () );
	}
	
	public function executeSendBulkMessage(sfWebRequest $request) {
		
		$this->form = new BulkMessageForm ();
		
		if ($request->isMethod ( 'post' )) {
			$params = $request->getParameter ( $this->form->getName () );
			$this->form->bind ( $params );
			if ($this->form->isValid ()) {
				
				if (is_array ( $params ['to'] )) {
					
					foreach ( $params ['to'] as $page_id ) {
						$message = new Message ();
						$message->setBody ( $params ['body'] );
						$conversation = Doctrine::getTable ( 'Conversation' )->getConversation ( $this->page->getId (), $page_id );
						$message->setPageId ( $this->page->getId () );
						$conversation->setNewMessage ( $message );
						$this->dispatcher->notify ( new sfEvent ( $message, 'social.write_message' ) );
					
					}
				
				}
				$this->getUser ()->setFlash ( 'notice', 'Your message was sent successfully' );
			
				if ($this->is_place_admin_logged == true) {
				    $this->redirect('companySettings/followers?slug='.$this->getUser ()->getPageAdminUser ()->getCompanyPage ()->getCompany()->getSlug());
				} else {
					$this->redirect ( 'message/index' );
				}
			}
		     if ($this->is_place_admin_logged == true) {
				    $this->redirect('companySettings/contactFollowers?slug='.$this->getUser ()->getPageAdminUser ()->getCompanyPage ()->getCompany()->getSlug());
				}
		}
	}
	
	public function executeRead(sfWebRequest $request) {
		$this->message = Doctrine::getTable ( 'Message' )->findOneById ( $request->getParameter ( 'id' ) );
		$this->forward404Unless ( $this->message, 'message not found' );
		$this->forwardUnless ( $this->message->checkPageTo ( $this->page ), 'user', 'secure' );
		$this->message->read ();
	}
}
