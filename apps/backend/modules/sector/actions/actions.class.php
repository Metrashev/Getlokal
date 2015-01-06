<?php

require_once dirname(__FILE__).'/../lib/sectorGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/sectorGeneratorHelper.class.php';

/**
 * sector actions.
 *
 * @package    getLokal
 * @subpackage sector
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sectorActions extends autoSectorActions
{

  public function preExecute()
  {
    // disable maps for this module
    sfConfig::set('view_no_google_maps', true);
    parent::preExecute();
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->sector = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this->sector);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }


   protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $params = $request->getParameter ($form->getName (), array());
    
    $lang_array = array('en', 'ro', 'bg', 'mk', 'sr', 'me', 'ru');
    
    $error_slug = false;
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    
    foreach ($lang_array as $culture ){
    	//var_dump(Sector::checkSlug($params[$culture]['slug'], $culture, $form->getObject()->getId()));
	    if ($params [$culture] ['slug']!= '' && Sector::checkSlug($params[$culture]['slug'], $culture, $form->getObject()->getId()))
	    {
	      $error_slug = true;
	      $slugs_with_error []= $culture ;
	    }
    }
    
    //var_dump($error_slug);exit();
    
    if ($form->isValid() && !$error_slug)
    {
      $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';

      try {
        $sector = $form->save();
      } catch (Doctrine_Validator_Exception $e) {

        $errorStack = $form->getObject()->getErrorStack();

        $message = get_class($form->getObject()) . ' has ' . count($errorStack) . " field" . (count($errorStack) > 1 ?  's' : null) . " with validation errors: ";
        foreach ($errorStack as $field => $errors) {
            $message .= "$field (" . implode(", ", $errors) . "), ";
        }
        $message = trim($message, ', ');

        $this->getUser()->setFlash('error', $message);
        return sfView::SUCCESS;
      }

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $sector)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $notice.' You can add another one below.');

        $this->redirect('@sector_new');
      }
      else
      {
        $this->getUser()->setFlash('notice', $notice);
        $this->redirect(array('sf_route' => 'sector_edit', 'sf_subject' => $sector));
      }
    }

    else
    {

     if ($error_slug == true) {
     	$tab_lng='';
        foreach ($slugs_with_error as $lng){
        	$tab_lng .='"'.sfConfig::get('app_culturesEn_'.$lng).'" ';
        }
        $this->getUser ()->setFlash ( 'error', 'This slug has already been used in another sector. Please enter a new slug value for the '.$tab_lng.'sector.' );
      
      } else 
      {
        $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.', false);
      }
    }
  }
}
