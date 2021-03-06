<?php

/**
 * Article
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    getLokal
 * @subpackage model
 * @author     Get Lokal
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Article extends BaseArticle
{

	public function getTitleByCulture($culture = null) {
            if(is_null($culture)){
                $culture = sfContext::getInstance()->getUser()->getCulture();
            } 
            
            if ($this->Translation[$culture]->_get('title', $culture)){
                $title =  $this->Translation[$culture]->_get('title', $culture);
            }
            if(!isset($title) || !$title){
                $title = $this->Translation['en']->_get('title', 'en');
            }
            // get first title available if no EN or current lang title available
            if (!$title) {
            	foreach (getLokalPartner::getEmbeddedLanguages() as $culture) {
                    if ($this->Translation[$culture]->_get('title', $culture)) {
                        // fix for backend missing language for articles
                        if (sfContext::getInstance()->getConfiguration()->getApplication() == 'backend') {
                           sfContext::getInstance()->getUser()->setCulture($culture); 
                        }
//            	        return $this->Translation[$culture]->_get('title', $culture);
            	    }
            	}
            }
            return $title;
	}
	public function getContentByCulture($culture = null) {
            if(is_null($culture)){
                $culture = sfContext::getInstance()->getUser()->getCulture();
            }
            $content = $this->Translation[$culture]->_get('content', $culture);
            
            if(!isset($content) || $content =='' || $content ===null){
                $content = $this->Translation['en']->_get('content', 'en');
            }
            return $content;
	}
	
	public function getDescriptionByCulture($culture = null) {
		if(is_null($culture)){
			$culture = sfContext::getInstance()->getUser()->getCulture();
		}
		$description = $this->Translation[$culture]->_get('description', $culture);
	
		if(!isset($description) || $description =='' || $description ===null){
			$description = $this->Translation['en']->_get('description', 'en');
		}
		return $description;
	}
	
	public function getSlugByCulture($culture = null) {
            if(is_null($culture)){
                $culture = sfContext::getInstance()->getUser()->getCulture();
            }
            
            $slug = $this->Translation[$culture]->_get('slug',$culture);
            
            if(!isset($slug) || $slug == '' || $slug === null){
                $slug = $this->Translation['en']->_get('slug', 'en');
            }
            
            return $slug;
	}
	public function getContentShow() {
		$content = $this->getContent();

		if(!isset($content) || $content =='' || $content ===null){
			$content = $this->getContentByCulture();
		}

		if($this->getQuotation()!='' && $this->getQuotation() != null) {
			$quotation = "<blockquote><span>“</span>".$this->getQuotation()."<span>”</span></blockquote>";
			$content = str_replace ("{/quotation/}", $quotation, $content);
		}else {
			$content = str_replace ("{/quotation/}", '', $content);
		}

		$pattern = '|{\/([^\/]+)/}|is';
		preg_match_all($pattern, $content, $matches);

		if(sizeof($matches[0])){
			$images = Doctrine::getTable('ArticleImage')
			->createQuery('ai')
			->innerJoin('ai.UserProfile up')
			->innerJoin('up.sfGuardUser sfg')
			->WhereIn('ai.code', $matches[0])
			->execute();
				
			foreach ($images as $image){
				if(!$image->getId()){
					continue;
				}
				$sorse='';
				if ($image->getSource() )   $sorse = "<p>". __('Source',null,'article').": ". $image->getSource()."</p>" ;

				$content = str_replace ($image->getCode(), '
						<div class="article_picture_wrap">
						<a alt="'. $image->getDescrption() .'" id="image-'.$image->getId().'" class="grouped_elements_2"><img src="'.ZestCMSImages::getImageURL('article', 'big').$image->getFilename().'" alt="'. $image->getDescrption() .'"  /></a>
						'.$sorse.'</div>', $content);
			}//rel="test" href="'.ZestCMSImages::getImageURL('article', 'original').$image->getFilename().'" */
			foreach ($matches[0] as $code){
				$content = str_replace ($code, '', $content);
			}
		}
		/*
		 "'.
		($image->getSource() )  ? '"<p>"'. __('Photo source',null,'article').'":"'. $image->getSource().'"</p>"'
		:
		'""'.
		'"
		*/
		$content = "<div class=\"content_html\">".$content."</div>";
		if (getlokalPartner::getInstance() == getlokalPartner::GETLOKAL_RO):
			$content .= '<div class="col-sm-12">
							<div class="default-container">
								<div class="content">
									'.get_partial('global/ads', array('type' => 'inread')).'
								</div>
								<!-- END content -->
							</div>
						</div>';
		endif;
		return $content;
	}
	
	public function getContentIndex() {
		$content = $this->getContent();
                
                if(!isset($content) || $content =='' || $content ===null){
                    $content = $this->getContentByCulture();
                }
		$pattern = '|{\/([^\/]+)/}|is';
		preg_match_all($pattern, $content, $matches);
		foreach ($matches[0] as $code){
			$content = str_replace ($code, '', $content);
		}
	
		return $content;
	}
	
	public function getContentUP($culture) {
		$content = $this->getContentByCulture($culture);
		$pattern = '|{\/([^\/]+)/}|is';
		preg_match_all($pattern, $content, $matches);
		foreach ($matches[0] as $code){
			$content = str_replace ($code, '', $content);
		}
	
		return $content;
	}
	
	public function preSave($param){
		$this->setTitle(strip_tags($this->getTitle()));
		$content = html_entity_decode($this->getContent());
		$content = $this->addTargetBlanks($content);
// 		var_dump($content);die;
		$this->setContent($content);
		foreach (getlokalPartner::getEmbeddedLanguages() as $culture) {
			if ($content = $this->Translation[$culture]->_get('content')){
				$content = html_entity_decode($content);
				$content = $this->addTargetBlanks($content);
				$this->Translation[$culture]->_set('content',$content);
			}
		}
	}
	
	private function addTargetBlanks($content){
		$content = str_replace(array('target=\'_blank\'','target="_blank"'),"",$content);
		$content = str_replace('<a ','<a target="_blank" ',$content);
		return $content;
	}
	
	public function postSave($event) {
		parent::postSave ( $event );
		
		$art_tr = $this->getTranslation();
		
		foreach ($art_tr as $art){
			//echo $art->_get('slug');
		
			$article =  Doctrine::getTable('ArticleSlugLog')
			->createQuery('asl')
			->where('asl.old_slug=? and asl.lang=? and asl.article_id=?', array($art->_get('slug'), $art->_get('lang'),$art->_get('id') ) )
			->fetchOne();
		
			if (!$article && $art->_get('slug'))
			{
				$log = new ArticleSlugLog ();
				$log->setArticleId($art->_get('id'));
				$log->setLang($art->_get('lang'));
				$log->setOldSlug($art->_get('slug'));
				$log->save();
			}
		}
		
		
	}
	
	public function postInsert($event) {

		parent::postInsert ( $event );
	    $activity = Doctrine::getTable('ActivityArticle')->getActivity($this->getId());
        $activity->setText($this->getDescription());
        $activity->setCaption($this->getTitle());
        $activity->setUserId($this->getUserId());
        $activity->save();
	}
	
	public function	getArticleImagesForSlider(){
		$query = Doctrine::getTable ( 'ArticleImage' )
		->createQuery ( 'ai' )
		->innerJoin('ai.UserProfile up')
		->innerJoin('up.sfGuardUser sfg')
		->where ( 'ai.article_id = ?', $this->getId() )
		->orderBy('ai.rank ASC');
		return $query->execute();
		
	}
	
	
        public function getTitleForCP() {
		if ($this->_get('title'))
			return $this->_get('title');
                $cultures = sfConfig::get('app_culture_slugs');
		foreach ($cultures as $culture) {
			if ($this->Translation[$culture]->_get('title', $culture))
				return $this->Translation[$culture]->_get('title', $culture);
		}
	}
	public function getSlugForCP() {
		if ($this->_get('slug'))
			return $this->_get('slug');
                $cultures = sfConfig::get('app_culture_slugs');
		foreach ($cultures as $culture) {
			if ($this->Translation[$culture]->_get('slug', $culture))
				return $this->Translation[$culture]->_get('slug', $culture);
		}
	}
	public function getLangForCP() {
		if ($this->_get('title')) 
			return $this->_get('lang');
                $cultures = sfConfig::get('app_culture_slugs');
		foreach ($cultures as $culture) {
			if ($this->Translation[$culture]->_get('title', $culture))
				return $culture;
		}
	}
		
	
	public function	getArticleImageForIndex(){
		$query = Doctrine::getTable ( 'ArticleImage' )
		->createQuery ( 'ai' )
		->where ( 'ai.article_id = ?', $this->getId() )
		->orderBy('ai.rank ASC');
		
		return $query->fetchOne();
	
	}

	public static function generateSlug($slug,$lang)
	{
		//var_dump($slug);exit();
		$article = Doctrine::getTable('Article')
		->createQuery('a')
		->innerJoin('a.Translation at')
		->innerJoin('a.ArticleSlugLog asl')
		->where('asl.old_slug=? and asl.lang=?', array($slug, $lang) )
		->orWhere('at.slug=? and at.lang=?', array($slug, $lang) )
		->fetchOne();
		
		//if (Doctrine::getTable('ArticleTranslation')->findOneBy('slug', $slug))
		if($article)
		{
			$slug = Article::generateSlug($slug.'-'.substr ( uniqid ( md5 ( rand () ), true ), 0, 8 ), $lang );
		}
	
		return $slug;
	}
	
	public static function checkSlug($slug, $lang, $id)
	{
		//var_dump($slug);exit();
		$article = Doctrine::getTable('Article')
		->createQuery('a')
		->innerJoin('a.Translation at')
		->innerJoin('a.ArticleSlugLog asl')
		->where('asl.old_slug=? and asl.lang=? and asl.article_id!=?', array($slug, $lang, $id) )
		->orWhere('at.slug=? and at.lang=?', array($slug, $lang) )
		->fetchOne();
		//print_r($slug);
		//print_r($article->getSqlQuery());exit();
		if ($article)
		{
			return true;
		}
		
		return false;
	}
	
	public function getArticleDomain()
	{
 	 if ($this->getCountryId() == getlokalPartner::GETLOKAL_BG ) return '.com';
 	 elseif ($this->getCountryId() == getlokalPartner::GETLOKAL_RO ) return '.ro';
 	 elseif ($this->getCountryId() == getlokalPartner::GETLOKAL_MK ) return '.mk';
 	 elseif ($this->getCountryId() == getlokalPartner::GETLOKAL_RS ) return '.rs';
     elseif ($this->getCountryId() == getlokalPartner::GETLOKAL_FI ) return '.fi';
     elseif ($this->getCountryId() == getlokalPartner::GETLOKAL_ME) return '.me';
     elseif ($this->getCountryId() == getlokalPartner::GETLOKAL_RU) return '.ru';
 
	}
	

}
