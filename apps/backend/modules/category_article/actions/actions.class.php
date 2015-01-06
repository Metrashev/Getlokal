<?php

require_once dirname(__FILE__).'/../lib/category_articleGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/category_articleGeneratorHelper.class.php';

/**
 * category_article actions.
 *
 * @package    getLokal
 * @subpackage category_article
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class category_articleActions extends autoCategory_articleActions
{
	public function executeClassification(sfWebRequest $request)
	{
		$this->forward404Unless($this->category = Doctrine::getTable('CategoryArticle')->find($request->getParameter('id')));
	
		//print_r($request->getParameterHolder());exit();
		$this->form = new ClCategoryArticleForm($this->category);
		//$this->form->getWidgetSchema()->setNameFormat('requirements[%s]');
	
		
		if($request->isMethod('post'))
		{
			/*
			$classifications = Doctrine::getTable('CategoryArticleClassification')
				->createQuery('cac')
				->select('cac.classification_id')
				->where('cac.category_id=?',$this->form->getObject()->getId())
				->fetchArray();
			
			var_dump($classifications);exit();
			
			var_dump($request->getParameter($this->form->getName()));exit();
			*/
			$this->form->bind($request->getParameter($this->form->getName()));
	
			if($this->form->isValid())
			{
				$category=$this->form->save();
	
	
				$this->redirect('category_article/classification?id='.$category->getId());
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
		->leftJoin('c.CategoryArticleClassification cac with cac.category_id=?', $category_id)
		->innerJoin('cs.Sector s')
		->where('s.id = ? ', $sector_id)
		//->addWhere('csc.category_id=?', $category_id)
		->execute();
		
		foreach ($this->classifications as $cls){
				$cl[] =  $cls->getId();
		}
		
		//exit();
		$this->category_classifications = Doctrine::getTable('CategoryArticleClassification')
		->createQuery('cac')
		//->select('cac.classification_id')
		->where('cac.category_id=?',$category_id)
		//->addWhere('cac.classification_id not in select ')
		->whereNotIn('cac.classification_id',$cl)
		->execute();
		
		
	}
}
