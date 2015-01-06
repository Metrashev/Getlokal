<?php if (count($similarArticles) > 0): ?>

	<div class="states-head">
		<h2><?php echo __('Related Articles',null,'article')?></h2>
		<a href="<?php echo url_for( '@article_category?slug='.$category->getSlug() ); ?>"><?php echo __('see all',null,'messages')?></a>
	</div>
		 
	<div class="states-body">
		<ul class="more-articles">
            <?php foreach($similarArticles as $similarArticle): 
            $getArticleImageForIndex = $similarArticle->getArticleImageForIndex();
            if(is_object($getArticleImageForIndex)){
				$src = ( file_exists(sfConfig::get('sf_web_dir').ZestCMSImages::getImageURL('article', 'size-sm').$similarArticle->getArticleImageForIndex()->getFilename()) ? ZestCMSImages::getImageURL('article', 'size-sm') : ZestCMSImages::getImageURL('article', 'size-s') ).$similarArticle->getArticleImageForIndex()->getFilename();
			}else{
				$src = '';
			}
            ?>
			<li>
				<a href="<?php echo url_for( '@article?slug='.$similarArticle->getSlug() ); ?>">
					<img src="<?php echo $src; ?>">
					<p><?php echo $similarArticle->getTitleByCulture() ?></p>
		 		</a>
		 	</li>
		 	<?php endforeach; ?>
		</ul>
	</div>

<?php endif; ?>