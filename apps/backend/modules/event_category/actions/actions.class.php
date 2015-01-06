<?php

require_once dirname(__FILE__).'/../lib/event_categoryGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/event_categoryGeneratorHelper.class.php';

/**
 * event_category actions.
 *
 * @package    getLokal
 * @subpackage event_category
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class event_categoryActions extends autoEvent_categoryActions
{
	public function executeClassification(sfWebRequest $request)
	{
		$this->forward404Unless($this->category = Doctrine::getTable('Category')->find($request->getParameter('id')));
	
		//print_r($request->getParameterHolder());exit();
		$this->form = new ClCategoryForm($this->category);
		//$this->form->getWidgetSchema()->setNameFormat('requirements[%s]');
	
		
		if($request->isMethod('post'))
		{
			
			$classifications = Doctrine::getTable('CategoryClassification')
				->createQuery('cc')
				->select('cc.classification_id')
				->where('cc.category_id=?',$this->form->getObject()->getId())
				->fetchArray();
			
			// var_dump($classifications);exit();
			
			// print_r($request->getParameter($this->form->getName()));exit();
			
			$this->form->bind($request->getParameter($this->form->getName()));
	
			if($this->form->isValid())
			{
				$category=$this->form->save();
	
	
				$this->redirect('event_category/classification?id='.$category->getId());
			}
		}
	}
	
	public function executeAddClassification(sfWebRequest $request)
	{
		
		//print_r($request->getParameter('sector_id')); exit();
		
		$sector_id = $request->getParameter('sector_id');
		$category_id = $request->getParameter('category_id');
		
		$this->classifications = Doctrine::getTable('Classification')
		->createQuery('c')
		->select('c.*, cac.classification_id as classification_id')
		->leftJoin('c.ClassificationSector cs')
		->leftJoin('c.CategoryClassification cac with cac.category_id=?', $category_id)
		->innerJoin('cs.Sector s');
		if ($sector_id) {
			$this->classifications = $this->classifications->where('s.id = ? ', $sector_id);
		}
		$this->classifications = $this->classifications->execute();
		
		foreach ($this->classifications as $cls){
				$cl[] =  $cls->getId();
		}
		
		//exit();
		$this->category_classifications = Doctrine::getTable('CategoryClassification')
		->createQuery('cac')
		//->select('cac.classification_id')
		->where('cac.category_id=?',$category_id)
		//->addWhere('cac.classification_id not in select ')
		->whereNotIn('cac.classification_id',$cl)
		->execute();
		
		
	}
}
