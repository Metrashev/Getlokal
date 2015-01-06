<?php

/**
 * pilot actions.
 *
 * @package    getLokal
 * @subpackage pilot
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class pilotActions extends sfActions
{
  
  private function __json($response) {
    $this->getResponse()->setContentType('application/json');
    return $this->renderText(json_encode($response));
  }

  private function __getTodayVotes() {
    return Doctrine::getTable('PilotVote')->createQuery('v')
    ->addWhere('v.user_id = ?', $this->getUser()->getId())
    ->addWhere('DATE(v.created_at) = ?', date('Y-m-d'))
    ->execute();
  }

  public function executeIndex(sfWebRequest $request)
  {
    $this->videos = Doctrine_Query::create()->from('PilotVideo')->execute();
      
    // has voted today
    $this->canVote = true;
    $this->todayVoteId = null;
    
    if ($this->getUser()->isAuthenticated()) {
      $votes = $this->__getTodayVotes();
      if ($votes->count()) {
        $this->canVote = false;
        $this->todayVoteId = $votes->getFirst()->getPilotVideo()->getId();
      }
    }

    if ($request->hasParameter('v')) {
      $this->forceVote = $request->getParameter('v');
    }

    $this->vote_disabled = Doctrine::getTable('Setting')->createQuery('st')
        ->addWhere('st.k=?', 'getpilot_vote_disabled')
        ->addWhere('st.val=?', 'true')
        ->fetchOne();
    $this->winner_message = Doctrine::getTable('Setting')->createQuery('st')
        ->where('st.k=?', 'getpilot_message')
        ->fetchOne();
    
  }

  public function executeVote(sfWebRequest $request) 
  {
    
    $disabled = Doctrine::getTable('Setting')->createQuery('st')
        ->addWhere('st.k=?', 'getpilot_vote_disabled')
        ->addWhere('st.val=?', 'true')
        ->fetchOne();
        
    if ($disabled) {
       return $this->__json(array(
         'status' => false,
         'message' => 'Voturile sunt dezactivate'
       )); 
    }

    $user = $this->getUser();
    if (!$user->isAuthenticated()) {
      // set redirect after login
      $user->setAttribute('local.referer', $this->generateUrl('getpilot') . "?v=" . $request->getParameter('id'));
      $user->setFlash('notice', 'Trebuie să fii logat pentru a vota.');
      return $this->__json(array(
        'status' => false,
        'not_authenticated' => true
      ));
    }

    $votes = $this->__getTodayVotes();
    if ($votes->count()) {
      return $this->__json(array(
        'status' => false,
        'message' => 'Ai votat deja astazi!'
      ));
    }
    
    $video = Doctrine::getTable('PilotVideo')->find($request->getParameter('id'));
    if (!$video) {
      return $this->__json(array('status' => false));
    }
    $vote = new PilotVote();
    $vote->setPilotVideo($video);
    $vote->setUserId($user->getId());
    $vote->setPilotVideo($video);
    $vote->save();

    // if ($request->isXmlHttpRequest()) {  
    return $this->__json(array(
      'status' => true,
      'count' => $video->getPilotVote()->count() 
    ));
  }
}
