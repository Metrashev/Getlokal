<?php

/**
 * article actions.
 *
 * @package    getLokal
 * @subpackage article
 * @author     Get Lokal
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class articleActions extends sfActions
{

    public function preExecute()
    {
        $this->is_place_admin_logged = false;
        $this->user = $this->getUser()->getGuardUser ();
        if ($this->getUser()->getPageAdminUser()) {
            $this->is_place_admin_logged = true;
        }

    }

    public function executeIndex(sfWebRequest $request)
    {
        if (in_array($request->getRequestFormat(), array('atom', 'xml'))) {
            // rss request
            $this->articles = $query->limit(20)->execute();
            sfContext::getInstance()->getResponse()->setContentType('xml');
            return sfView::SUCCESS;
        }

        $culture = $this->getUser()->getCulture();

        if($culture != 'en' && $culture != getlokalPartner::getDefaultCulture()){
            $culture = 'en';
        }
        
            $query_last = Doctrine_Core::getTable('Article')
                ->createQuery('a')
                ->innerJoin('a.Translation at')
                ->where('a.country_id = ?',$this->getUser()->getCountry()->getId() )
                ->addWhere('at.lang = ? ', $culture)
                ->addWhere('a.status = "approved"')
                ->orderBy('a.created_at DESC');

            $this->last_add = $query_last->fetchOne();
            $article_id = 0;

            if($this->last_add){
            	$article_id = $this->last_add->getId();
            }
            
            $query = Doctrine_Core::getTable('Article')
                ->createQuery('a')
                ->innerJoin('a.Translation at')
                ->where('a.country_id = ?',$this->getUser()->getCountry()->getId() )
                ->addWhere('at.lang = ? ', $culture)
                ->addWhere('a.status = "approved"')
                ->addWhere('a.id != ?', $article_id)
                ->orderBy('a.created_at DESC');

        $this->pager = new sfDoctrinePager('Article', 10);
        $this->pager->setQuery($query);
        $this->pager->setPage($request->getParameter('page', 1));
        $this->pager->init();
        $this->user_profile = $this->getUser();

        breadCrumb::getInstance()->add('Articles', null);

        $this->video = Doctrine::getTable('getWeekend')->createQuery('g')
            ->where('g.country_id = ?', sfContext::getInstance()->getUser()->getCountry()->getId())
            ->orderBy('g.aired_on DESC')
            ->limit(1)
            ->fetchOne();

    }

    public function executeCategory(sfWebRequest $request)
    {
        $this->category = Doctrine_Core::getTable('CategoryArticle')->createQuery('ca')
            ->innerJoin('ca.Translation cat')
            ->where('cat.slug = ?', $request->getParameter('slug'))
            ->addWhere('cat.lang = ?', $request->getParameter('sf_culture'))
            ->fetchOne();


        if ($request->getParameter('page', 1) == 1) {
            $last_add = Doctrine_Core::getTable('Article')->createQuery('a')
                ->innerJoin('a.Translation at')
                ->leftJoin('a.ArticleCategory ac')
                ->innerJoin('ac.CategoryArticle ca')
                ->innerJoin('ca.Translation cat')
                ->where('a.country_id = ?',$this->getUser()->getCountry()->getId() )
                ->addWhere('at.lang = ? ', $this->getUser ()->getCulture ())
                ->addWhere('a.status = "approved"')
                ->addWhere('cat.id = ? ',$this->category->getId())
                ->orderBy('a.created_at DESC')
                ->fetchOne();

            if ($last_add) {
                $this->last_add = $last_add;
            }
        }

        $query = Doctrine_Core::getTable('Article')->createQuery('a')
            ->innerJoin('a.Translation at')
            ->leftJoin('a.ArticleCategory ac')
            ->innerJoin('ac.CategoryArticle ca')
            ->innerJoin('ca.Translation cat')
            ->where('a.country_id = ?',$this->getUser()->getCountry()->getId() )
            ->addWhere('at.lang = ? ', $this->getUser ()->getCulture ())
            ->addWhere('a.status = "approved"')
            ->addWhere('cat.id = ? ',$this->category->getId())
            ->orderBy('a.created_at DESC');
        if ($request->getParameter('page', 1) == 1 && $this->last_add) {
            $query->addWhere('a.id != ?', $this->last_add->getId());
        }

        $this->pager = new sfDoctrinePager('Article', 10);
        $this->pager->setQuery($query);
        $this->pager->setPage($request->getParameter('page', 1));
        $this->pager->init();

        $this->user_profile = $this->getUser();
        $this->slug = $request->getParameter('slug');
        breadCrumb::getInstance()->add('Articles', '@article_index');
        breadCrumb::getInstance()->add($this->category->getTitle(), null);

        $this->video = Doctrine::getTable('getWeekend')->createQuery('g')
        ->where('g.country_id = ?', sfContext::getInstance()->getUser()->getCountry()->getId())
        ->orderBy('g.aired_on DESC')
        ->limit(1)
        ->fetchOne();

        $this->setTemplate('index');
    }

    public function executeShow(sfWebRequest $request)
    {
        $this->getContext()->getConfiguration()->loadHelpers('Text');
        $this->user_profile =$this->getUser();

        if($request->getParameter('sf_culture') != 'en' && $request->getParameter('sf_culture') != getlokalPartner::getDefaultCulture()){
            $request->setParameter('sf_culture', 'en');
        }

        //print_r($request->getParameter('slug'));exit();
        $this->article = Doctrine_Core::getTable('Article')->createQuery('a')
            ->innerJoin('a.Translation at')
            ->where('at.slug = ?', $request->getParameter('slug'))
            ->addWhere('a.status = "approved"')
            ->addWhere('at.lang = ?', $request->getParameter('sf_culture'))
            ->fetchOne();

        if (!$this->article) {
            $this->article = Doctrine_Core::getTable('Article')->createQuery('a')
                ->innerJoin('a.ArticleSlugLog asl')
                ->where('asl.old_slug = ?', $request->getParameter('slug'))
                ->addWhere('a.status = "approved"')
                ->addWhere('asl.lang = ?', $request->getParameter('sf_culture'))
                ->fetchOne();
            if ($this->article) {
                $this->redirect('article/show?slug='.$this->article->getSlug(), 301);
            }
        }

        $this->article2 = Doctrine_Core::getTable('Article')->createQuery('a')
            ->innerJoin('a.Translation at')
            ->where('at.slug = ?', $request->getParameter('slug'))
            ->addWhere('at.lang = ?', $request->getParameter('sf_culture'))
            ->fetchOne();

        if (!$this->article2) {
            $this->article2 = Doctrine_Core::getTable('Article')->createQuery('a')
                ->innerJoin('a.ArticleSlugLog asl')
                ->where('asl.old_slug = ?', $request->getParameter('slug'))
                //->addWhere('a.status = "approved"')
                ->addWhere('asl.lang = ?', $request->getParameter('sf_culture'))
                ->fetchOne();
            if ($this->article2) {
                $this->redirect('article/show?slug='.$this->article2->getSlug(), 301);
            }
        }

        $this->forward404Unless($this->article || (
            $this->article2 && $this->article2->getUserId() == $this->getUser()->getId()));

        $this->article = $this->article2;

        $this->url_for_fb = $this->generateUrl('article', array(
                'module' => 'article',
                'action' => 'show',
                'slug' => $this->article->getSlug()
        ), true);
        $this->url_for_fb = str_replace('https://', 'http://', $this->url_for_fb);

        $this->article_events = $this->article->getArticleEvent();
        $this->article_lists = $this->article->getArticleList();
        $this->article_pages = $this->article->getArticlePage();

        $this->getResponse()->setTitle ($this->article->getTitle());
        $articleTitle = $this->article->getTitle() . ' - '. sfContext::getInstance()->getUser()->getCity()->getLocation();
        if($this->article->getDescription() =='')
        {
            $this->getResponse()->addMeta('description', $articleTitle);
        }
        else
        {
            $this->getResponse()->addMeta('description', $this->article->getDescription());
        }
        if($this->article->getKeywords() =='')
        {
            $this->getResponse()->addMeta('keywords', myTools::generateKeywords($articleTitle));
        }
        else
        {
            $this->getResponse()->addMeta('keywords', $this->article->getKeywords());
        }

//        $categories  = Doctrine::getTable('CategoryArticle')
//                ->createQuery('c')
//                ->leftJoin('c.ArticleCategory ac')
//                ->where('c.status = "approved"')
//                ->addWhere( 'ac.article_id = ?', $this->article->getId())
//                ->orderBy('ac.id ASC')
//                ->setHydrationMode(Doctrine::HYDRATE_SINGLE_SCALAR)
//	        ->execute();
//        
//        $this->category = $categories[0];
//        
//        $this->similarArticles = array();
//        
//        $similarArticles = Doctrine::getTable('Article')
//                ->createQuery('a')
//                ->innerJoin('a.Translation at')
//                ->innerJoin('a.ArticleCategory ac')
//                ->innerJoin('a.ArticleSlugLog asl')
//                ->where('ac.category_id = ?', $categories[0])
//                ->andWhere('a.id != ?', $this->article->getId())
//                ->andWhere('asl.lang = ?', $request->getParameter('sf_culture'))
//                ->andWhere('at.lang = ?', $request->getParameter('sf_culture'))
//                ->orderBy('a.created_at DESC')
//                ->limit(3)
//                ->execute();
//        
//        if(is_object($similarArticles->count()) && $similarArticles->count() < 3) {
//            foreach ($similarArticles as $sA) {
//                $this->similarArticles[] = $sA;
//            }
//        }
//        
//        $catCount = count($categories);
//        $similarArticles2 = null;
//        
//        if(count($this->similarArticles) && count($this->similarArticles) < 3) {
//	   for ($i = 1; $i < $catCount; $i++) {
//               $similarArticles2 = Doctrine::getTable('Article')
//                        ->createQuery('a')
//                        ->innerJoin('a.Translation at')
//                        ->innerJoin('a.ArticleCategory ac')
//                        ->innerJoin('a.ArticleSlugLog asl')
//                        ->where('ac.category_id = ?', $categories[$i]->getId())
//                        ->andWhere('a.id != ?', $this->article->getId())
//                        ->andWhere('asl.lang = ?', $request->getParameter('sf_culture'))
//                        ->andWhere('at.lang = ?', $request->getParameter('sf_culture'))
//                        ->addWhere('a.status = "approved"')
//                        ->orderBy('a.created_at DESC')
//                        ->limit(3 - $this->similarArticles->count())
//                        ->execute();
//               
//               if (is_object($similarArticles2->count()) && $similarArticles2->count() > 0) {
//                   foreach ($similarArticles2 as $sA) {
//                       $this->similarArticles[] = $sA;
//                   }
//                   
//                   $similarArticles2 = null;
//               }
//               
//               if (count($this->similarArticles) >= 3) {
//                   break;
//               }
//           }
//        }
        
        breadCrumb::getInstance()->add('Articles', '@article_index');
        breadCrumb::getInstance()->add(truncate_text($this->article->getTitle(), 80, '...', true));

        $this->video = Doctrine::getTable('getWeekend')->createQuery('g')
            ->where('g.country_id = ?', sfContext::getInstance()->getUser()->getCountry()->getId())
            ->orderBy('g.aired_on DESC')
            ->limit(1)
            ->fetchOne();

    }

    public function executeCreate(sfWebRequest $request)
    {
        $this->user_profile = $this->getUser ();
        //$this->forward404Unless($request->isMethod(sfRequest::POST));
        $this->form = new ArticleForm();
        
        if ($request->isMethod(sfRequest::POST)){
        	
        	if(myTools::isExceedingMaxPhpSize()){
        		$img_form = $this->form->getEmbeddedForm("newImages")->getEmbeddedForm("0");
        		$img_form->getErrorSchema()->addError(new sfValidatorError($img_form->getValidator("filename"),"max_size"));
        		$this->form->getErrorSchema()->addErrors($img_form->getErrorSchema()->getErrors());
        		//$this->form->getErrorSchema()->addError(new sfValidatorError($this->form->getValidator("location_id"),"required"));
				//$asd = $this->form->renderGlobalErrors();
        		//var_dump($asd);die;
        		//$this->form->getErrorSchema()->addError(new sfValidatorError($this->form->getValidator("file"), "max_size"));
        	}else{
        		$this->processForm($request, $this->form);
        	}
    	}

        $i18n = sfContext::getInstance()->getI18N();
        breadCrumb::getInstance()->add ( 'Articles', '@article_index');
        breadCrumb::getInstance()->add ( $i18n->__('New Article',null,'article') );
        $this->setTemplate('new');
    }

    public function executeEdit(sfWebRequest $request)
    {
        $this->user_profile = $this->getUser();
        //$this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
        $this->forward404Unless($article = Doctrine_Core::getTable('Article')->find(array($request->getParameter('id'))), sprintf('Object article does not exist (%s).', $request->getParameter('id')));

        //var_dump(in_array('article_editor', $this->getUser()->getCredentials() ) );exit();
        //$credentials = $this->getUser()->getCredentials() ;
        if ($this->getUser()->isSuperAdmin()  || in_array('article_editor', $this->getUser()->getCredentials() ) ){
            //
        }else{
            $this->forward404Unless($article->getUserId() == $this->getUser()->getId() , sprintf('Object article does not exist (%s).', $request->getParameter('id')));
        }

        $this->form = new ArticleForm($article);

        if($request->isMethod(sfRequest::POST)){
            $this->processForm($request, $this->form);
        }
        $this->setTemplate('edit');

        $i18n = sfContext::getInstance()->getI18N();
        breadCrumb::getInstance()->add ( 'Articles', '@article_index');
        breadCrumb::getInstance()->add ( $i18n->__('Edit Article',null,'article') );
    }

    public function executeDelete(sfWebRequest $request)
    {
        $request->checkCSRFProtection();

        $this->forward404Unless($article = Doctrine_Core::getTable('Article')->find(array($request->getParameter('id'))), sprintf('Object article does not exist (%s).', $request->getParameter('id')));
        $article->delete();

        $this->redirect('article/index');
    }

    protected function clearInputAndJsCall($string) {
        $pattern = '@<\s*input\s+type="hidden"\s+id="gwProxy"\s*>.+?<\s*/\s*div\s*>@is';
        $stringa = preg_replace ( $pattern, "", $string );
        return $stringa;
    }

    protected function processForm(sfWebRequest $request, sfForm $form)
    {
        if ($this->is_place_admin_logged) {
            $this->redirect('event/noAccess');
        }

        $params = $request->getParameter ( $form->getName(), array() );
        $files = $request->getFiles($form->getName());

        foreach ($files['newImages'] as $kay=>$img) {
            if ($img['filename']['name']){
                $params['newImages'][$kay]['user_id'] = $this->getUser()->getGuardUser()->getId();
            }
        }

        $errora = false;
        $culture=getlokalPartner::getDefaultCulture();
        $current_lang = sfContext::getInstance()->getUser()->getCulture();

        $errora_slug_en = false;
        $errora_slug_culture = false;


        $params [$culture] ['content']=trim($params [$culture] ['content']);
        $params ['en'] ['content']= trim($params ['en'] ['content']);
        $params [$culture] ['title']=trim($params [$culture] ['title']);
        $params ['en'] ['title']=trim($params ['en'] ['title']);

        if (isset ( $params [$culture] ['content'] )) {
            $params [$culture] ['content'] = $this->clearInputAndJsCall ( $params [$culture] ['content'] );
        }

        if (isset ( $params ['en'] ['content'] )) {
            $params ['en'] ['content'] = $this->clearInputAndJsCall ( $params ['en'] ['content'] );
        }

        if (  ($params [$culture] ['title'] == '') && ( $params [$culture] ['content'] != '' )  )  {
            $errora = true;
        }elseif ( ($params [$culture] ['title'] != '') && ( $params [$culture] ['content'] == '') )  {
            $errora = true;
        }elseif (!isset($params [$culture] ['title']) or !isset($params [$culture] ['content'])){
            $errora = true;
        }

        if ( ($params ['en'] ['title'] == '') && ( $params ['en'] ['content']  != '') ) {
            $errora = true;
        }elseif ( ( $params ['en'] ['title'] != '' ) && ( ($params ['en'] ['content']) == '') ) {
            $errora = true;
        }elseif (!isset($params ['en'] ['title']) or !isset($params ['en'] ['content'])){
            $errora = true;
        }

        if ($params [$culture] ['title'] =='' && $params [$culture] ['content'] ==''&& $params ['en'] ['title'] =='' && $params ['en'] ['content'] =='' ){
            $errora = true;
        }

        if ($form->getObject()->isNew()){
                $params['location_id'] = sfContext::getInstance()->getUser()->getCity()->getId();
                $params['user_id'] = $this->user->getId();
        }

        $params['country_id'] = getlokalPartner::getInstanceDomain();


        if ($form->getObject()->isNew()) {
            $partner_class = getlokalPartner::getLanguageClass();
            if ($params [$culture] ['title'] != '' && ( !isset($params [$culture] ['slug'] ) || $params [$culture] ['slug']== '' ) )  {
                    $params [$culture] ['slug'] = myTools::cleanSlugString( call_user_func (  array ('Transliterate' . $partner_class, 'toLatin' ),$params [$culture] ['title'] ) );
            }
            if ($params ['en'] ['title'] != '' && ( !isset($params ['en'] ['slug']) || $params ['en'] ['slug']== '' ) ) {
                $params ['en'] ['slug'] = myTools::cleanSlugString( call_user_func (  array ('Transliterate' . $partner_class, 'toLatin' ),$params ['en'] ['title'] ) );
            }
            if ( !empty($params [$culture] ['slug'])) $params [$culture] ['slug'] = Article::generateSlug($params [$culture] ['slug'],$culture);
            if ( !empty($params ['en'] ['slug'])) $params ['en'] ['slug'] = Article::generateSlug($params ['en'] ['slug'],'en');
        }

        if (!$form->getObject()->isNew() ) {
            $article = Doctrine_Core::getTable('Article')->findOneBy('id',$form->getObject()->getId());
            if ( !isset($params [$culture] ['slug'] ) || $params [$culture] ['slug']== '' )  {
                if ($article->getSlugByCulture($culture) ) {
                    $params [$culture] ['slug']=$article->getSlugByCulture($culture);
                }else {
                    $partner_class = getlokalPartner::getLanguageClass();
                    $params [$culture] ['slug'] = myTools::cleanSlugString( call_user_func (  array ('Transliterate' . $partner_class, 'toLatin' ),$params [$culture] ['title'] ) );
                }
            }
            if ( !isset($params ['en'] ['slug'] ) || $params ['en'] ['slug'] == '' )  {
                if ($article->getSlugByCulture('en') ) {
                    $params ['en'] ['slug']=$article->getSlugByCulture('en');
                }else {
                    $partner_class = getlokalPartner::getLanguageClass();
                    $params ['en'] ['slug'] = myTools::cleanSlugString( call_user_func (  array ('Transliterate' . $partner_class, 'toLatin' ),$params ['en'] ['title'] ) );
                }
            }
            //$params [$culture] ['slug'] = iconv(mb_detect_encoding($params [$culture] ['slug'], mb_detect_order(), true), "UTF-8", $params [$culture] ['slug']);
            if ( $params [$culture] ['slug']!= '' && $params [$culture] ['slug'] != $article->getSlugByCulture($culture) && Article::checkSlug($params [$culture] ['slug'],$culture, $form->getObject()->getId() ) ) $errora_slug_culture = true ;
            if ( $params ['en'] ['slug'] !='' && $params ['en'] ['slug'] != $article->getSlugByCulture('en') && Article::checkSlug($params ['en'] ['slug'],'en', $form->getObject()->getId() ))  $errora_slug_en = true ;
        }

        if (empty($params['user_id'])) {
            $params['user_id'] = $form->getObject()->getUserProfile()->getId();
        }

        if(isset($params['category_id']))  {
            $categories = $params['category_id'];
            unset($params['category_id']);
        }

        $form->bind($params, $files);

        if ($form->isValid() && $errora == false && $errora_slug_en == false && $errora_slug_culture == false) {

            $article=$form->save();
            
            $cacheManager = $this->getContext()->getViewCacheManager();
            foreach (getlokalPartner::getEmbeddedLanguages() as $lang) {
                $cacheManager->remove('@sf_cache_partial?module=article&action=_content&sf_cache_key='.$article->getId().$lang);
            }

            if ($params [$culture] ['title'] == '' && $params [$culture] ['content'] == '') {
                Doctrine::getTable('ArticleTranslation')
                ->createQuery('at')
                ->select('at.id')
                ->delete()
                ->where('at.id = ?', $article->getId())
                ->addWhere('at.lang = ?', $culture)
                ->execute();
            }

            if ($params ['en'] ['title'] == '' && $params ['en'] ['content'] == '') {
                Doctrine::getTable('ArticleTranslation')
                ->createQuery('at')
                ->select('at.id')
                ->delete()
                ->where('at.id = ?', $article->getId())
                ->addWhere('at.lang = "en"')
                ->execute();
            }
            if (!$article->getTitleByCulture($current_lang) && !$article->getContentByCulture($current_lang)) {
                Doctrine::getTable('ArticleTranslation')
                ->createQuery('at')
                ->select('at.id')
                ->delete()
                ->where('at.id = ?', $article->getId())
                ->addWhere('at.lang = ?', $current_lang)
                ->execute();
            }

            
            
            $article = Doctrine::getTable('Article')->findOneBy('id', $article->getId());

            if ($article && isset( $categories )) {
                foreach ($categories as $category_id){
                    $art_cat = Doctrine::getTable('ArticleCategory')
                    ->createQuery('ac')
                    ->where('ac.category_id = ?',$category_id )
                    ->addWhere('ac.article_id = ?',$article->getId())
                    ->fetchOne();
                    if ( !$art_cat) {
                        $article_category = new ArticleCategory();
                        $article_category->setCategoryId($category_id);
                        $article_category->setArticleId($article->getId());
                        $article_category->save();
                    }

                }

                Doctrine::getTable('ArticleCategory')
                ->createQuery('ac2')
                ->select('ac2.id')
                ->delete()
                ->where('ac2.article_id = ?',$article->getId())
                ->whereNotIn('ac2.category_id', $categories)
                ->execute();

            }elseif ($article && !isset( $categories )) {
                Doctrine::getTable('ArticleCategory')
                ->createQuery('ac2')
                ->select('ac2.id')
                ->delete()
                ->where('ac2.article_id = ?',$article->getId())
                //->whereNotIn('ac2.category_id', $categories)
                ->execute();
            }
            
            $this->redirect('article/edit?id='.$article->getId());
        }

        if ($errora_slug_en == true) {
            $this->getUser()->setFlash ( 'slug_en_error', 'This slug has already been used in another article. Please enter a new slug for the English version of  the article.' );
        }
        if ($errora_slug_culture == true) {
            $lng= mb_convert_case(getlokalPartner::getLanguageClass(), MB_CASE_LOWER,'UTF-8');
            $tab_lng=sfConfig::get('app_cultures_en_'.$lng);
            $this->getUser()->setFlash ( 'slug_culture_error', 'This slug has already been used in another article. Please enter a new slug for the '.$tab_lng.' version of  the article.' );
        }
        if ($errora == true) {
            $this->getUser()->setFlash ( 'newerror', 'The atricle title and content are mandatory for at least one of the two language versions.' );
        }
        if (!$form->isValid()) {
            $this->getUser()->setFlash ( 'newerror', 'The article was not saved. Please fill in all mandatory fields.' );
        }

    }




    public function executeGetPage(sfWebRequest $request) {

        $this->cityId = $request->getParameter ( 'cityId' );
        $this->placeStr = trim ( $request->getParameter ( 'values', null ) );
        $this->culture = $this->getUser()->getCulture();
        $this->articleId = $request->getParameter ( 'articleId' );

        if ( !$request->getParameter ( 'page' )) $page=1;
        $page=$request->getParameter ( 'page' );
        $this->placePager = Page::getPagerForArticleSearchByTitle ($this->placeStr, $this->cityId, $page, $articleId=$this->articleId);

    }
    public function executeAddPageToArticle(sfWebRequest $request) {
        $this->placeId = $request->getParameter ( 'placeId' );
        $this->articleId = $request->getParameter ( 'articleId' );
        $this->culture = $this->getUser()->getCulture();

        if ($this->placeId && $this->articleId) {
            $addArticletPage = new ArticlePage();
            $addArticletPage->setArticleId($this->articleId);
            $addArticletPage->setPageId($this->placeId);
            $addArticletPage->save();
            
            $html = $this->getPartial('places', array( 'places' => array($addArticletPage) ));
            echo $html;
        }
        return sfView::NONE;
    }

    public function executeDelPageFromArticle(sfWebRequest $request) {

        $articlePageId = $request->getParameter ( 'Id' );
        Doctrine::getTable('ArticlePage')
        ->createQuery('ap')
        ->delete()
        ->where('ap.id = ?', $articlePageId)
        ->execute();
        $this->setTemplate('delFromList');
        return sfView::NONE;
        die;
    }

    public function executeGetList(sfWebRequest $request) {

        $this->listStr = trim ( $request->getParameter ( 'values', null ) );
        $this->culture = $this->getUser()->getCulture();
    $this->articleId = $request->getParameter ( 'articleId' );

    if ( !$request->getParameter ( 'page' )) $page=1;
        $page=$request->getParameter ( 'page' );
        $this->listPager = Lists::getPagerOfListsForArticleSearchByTitle ($this->listStr, $this->cityId, $page, $articleId=$this->articleId);

    }

    public function executeAddListToArticle(sfWebRequest $request) {
        $this->listId = $request->getParameter ( 'listId' );
        $this->articleId = $request->getParameter ( 'articleId' );
        $this->culture = $this->getUser()->getCulture();

        if ($this->listId && $this->articleId) {
            $addArticletList = new ArticleList();
            $addArticletList->setArticleId($this->articleId);
            $addArticletList->setListId($this->listId);
            $addArticletList->save();

            $html = $this->getPartial('lists', array( 'articleLists' => array($addArticletList) ));
            echo $html;
        }
        return sfView::NONE;
    }

    public function executeDelListFromArticle(sfWebRequest $request) {
        $articleListId = $request->getParameter ( 'Id' );
        Doctrine::getTable('ArticleList')
        ->createQuery('al')
        ->delete()
        ->where('al.id = ?', $articleListId)
        ->execute();
        return sfView::NONE;
        die;
    }

    public function executeGetEvent(sfWebRequest $request) {

        $this->eventStr = trim ( $request->getParameter ( 'values', null ) );
        $this->culture = $this->getUser()->getCulture();
        $this->articleId = $request->getParameter ( 'articleId' );

        if ( !$request->getParameter ( 'page' )) $page=1;
        $page=$request->getParameter ( 'page' );
        $this->eventPager = Event::getPagerOfEventsForArticleSearchByTitle ($this->eventStr, $this->cityId, $page, $articleId=$this->articleId);

    }

    public function executeAddEventToArticle(sfWebRequest $request) {
        $this->eventId = $request->getParameter ( 'eventId' );
        $this->articleId = $request->getParameter ( 'articleId' );
        $this->culture = $this->getUser()->getCulture();

        if ($this->eventId && $this->articleId) {
            $addArticletEvent = new ArticleEvent();
            $addArticletEvent->setArticleId($this->articleId);
            $addArticletEvent->setEventId($this->eventId);
            $addArticletEvent->save();

            $html = $this->getPartial('events', array( 'articleEvents' => array($addArticletEvent) ));
            echo $html;
        }
        return sfView::NONE;
    }

    public function executeDelEventFromArticle(sfWebRequest $request) {
        $articleListId = $request->getParameter ( 'Id' );
        Doctrine::getTable('ArticleEvent')
        ->createQuery('ae')
        ->delete()
        ->where('ae.id = ?', $articleListId)
        ->execute();
        return sfView::NONE;
        die;
    }

    public function executeGetCategory(sfWebRequest $request) {

        $this->categoryStr = trim ( $request->getParameter ( 'values', null ) );
        $this->culture = $this->getUser()->getCulture();
        $this->articleId = $request->getParameter ( 'articleId' );

        if ( !$request->getParameter ( 'page' )) $page=1;
        $page=$request->getParameter ( 'page' );
        $this->categoryPager = CategoryArticle::getPagerOfCategoriesForArticleSearchByTitle ($this->categoryStr, $this->cityId, $page, $articleId=$this->articleId);

    }

    public function executeImages(sfWebRequest $request)
    {
        $this->article = Doctrine_Core::getTable('Article')->find(array($request->getParameter('article')));
        $page=$request->getParameter('page','1');

        $query = Doctrine::getTable ( 'ArticleImage' )
        ->createQuery ( 'ai' )
        ->where ( 'ai.article_id = ?', $request->getParameter('article') )
        ->orderBy('ai.rank ASC, ai.id DESC');

        /*if (!$request->getParameter('contributors')){
            $query->addWhere('ai.user_id = ?', $this->article->getUserId());
        }
        elseif ($request->getParameter('contributors')){
            $query->addWhere('ai.user_id != ?', $this->article->getUserId());
        }*/

        //$pager = new sfDoctrinePager ( 'Image', 20 );
        //$pager = new sfDoctrinePager ( 'Image', Event::FORM_IMAGES_PER_PAGE );
        //print_r($query->getSqlQuery());exit();
        //$pager->setQuery($query);
        //$pager->setPage ( $page );
        //$pager->init();

        $this->pager=$query->execute();
    }

    public function executeDeleteImage(sfWebRequest $request) {

        $image_id = $request->getParameter('id');

        $image = $this->article = Doctrine_Core::getTable('ArticleImage')->findOneBy('id', $request->getParameter('id'));
        $article_id=$image->getArticleId();
        //print_r($article_id);
        //exit();
        $image->delete();
        $this->getUser()->setFlash('image_notice', 'Снимката беше изтрита успешно!');
        $this->redirect('article/edit?id='.$article_id);
    }

    public function executeComments(sfWebRequest $request)
    {
        $this->article = Doctrine_Core::getTable('Article')->find(array($request->getParameter('article_id')));
    }

    public function executeEditImgSoure(sfWebRequest $request)
    {

        $image = Doctrine_Core::getTable('ArticleImage')->find($request->getParameter('image_id'));

        if ($request->getParameter("name")=='img_source' && $request->getParameter("value")!=''){
            $image->setSource($request->getParameter("value"));
            $image->save();
            $value = $image->getSource();
            $but = 'Edit Source';
        }elseif ($request->getParameter("name")=='img_source' && $request->getParameter("value")==''){
            $value = $image->getSource();
            $but = 'Edit Source';
        }

        if ($request->getParameter("name")=='img_descrption'){
            $image->setDescrption($request->getParameter("value"));
            $image->save();
            $value = $image->getDescrption();
            $but = 'Edit Descrption';
        }

        $str = '<span id="span_'.$request->getParameter("name").'_'.$request->getParameter("image_id").'">'.$value.'</span><a class="'.$request->getParameter("name").'" id="'.$request->getParameter("image_id").'" > '.$but.'</a>';
        return $this->renderText($str);
        //return sfView::NONE;
    }

    public function executeOrder(sfWebRequest $request)
    {
        $ids = $request->getParameter('item', array());
        $i = 0;
        foreach ($ids as $id) {
            $i += 1;
            $item = Doctrine_Core::getTable('ArticleImage')->find($id);
            $item->setRank($i);
            $item->save(null, false);
        }

        if ($i !== 0)
            return sfView::SUCCESS;
        else
            return sfView::ERROR;
    }
}
