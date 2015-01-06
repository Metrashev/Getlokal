<?php

/**
 * box actions.
 *
 * @package    getLokal
 * @subpackage box
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class boxActions extends sfActions
{
  public function executeEnterSetup(sfWebRequest $request)
  {
    $this->getUser()->setAttribute('edit_mode', true);
    $this->redirect($request->getReferer());
  }
  
  public function executeExitSetup(sfWebRequest $request)
  {
    //
    
    $this->getUser()->setAttribute('edit_mode', false);
    $this->redirect($request->getReferer());
  }
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeSave(sfWebRequest $request)
  {
    $key = $request->getParameter('key', '');
    
    Doctrine::getTable('BoxToZone')
        ->createQuery('z')
        ->where('z.key = ?', $key)
        ->delete()
        ->execute();
        
    $values = unserialize(base64_decode($request->getParameter('values')));
    
    foreach($values as $col_no => $boxes)
    {
      foreach($boxes as $weight => $box)
      {
        $box_to_zone = new BoxToZone();
        $box_to_zone->setBoxId($box['id']);
        $box_to_zone->setKey($key);
        $box_to_zone->setWeight($weight);
        $box_to_zone->setColNo($col_no);
        $box_to_zone->setSettings(unserialize(base64_decode($box['settings'])));
        $box_to_zone->save();
      }
    }
    
    $this->redirect($request->getReferer());
  }
  
  public function executeLoad(sfWebRequest $request)
  {
    $this->forward404Unless($box = Doctrine::getTable('Box')->find($request->getParameter('box_id')));
    
    $settings = unserialize(base64_decode($request->getParameter('settings')));
    
    $this->box = new BoxToZone();
    $this->box->setSettings($settings);
    $this->box->setBox($box);
  }
  
  public function executeSetup(sfWebRequest $request)
  {
    $this->forward404Unless($this->box = Doctrine::getTable('Box')->find($request->getParameter('id')));
    $this->settings = unserialize(base64_decode($request->getParameter('settings')));
    
    $this->setLayout('modal');
    
    $this->done = false;
    $formClass = ucfirst($this->box->getComponent()). 'BoxForm';
    
    $this->form = new $formClass();
    $this->form->setDefaults($this->settings);
    if($request->getParameter($this->form->getName(), ''))  
    {
      $this->form->bind($request->getParameter($this->form->getName()));
      
      if($this->form->isValid())
      {
        $this->settings = base64_encode(serialize($this->form->getValues()));
        
        $this->done = true;
      }
    }
    
    $this->nodes = array();
  }
}
