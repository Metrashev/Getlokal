<?php if (count($similarArticles) > 0) { ?>
<div class="related-articles-holder floated">
							
	<div class="heading-container">
		<div class="title"><?= __('Related Articles',null,'article'); ?></div>
		<a href="<?= url_for('@article_category?slug='.$category->getSlug()); ?>" title="<?= __('see all',null,'messages')?>" class="view-all"><?= __('see all',null,'messages')?></a>
	</div> <!-- END heading-container -->

	<div class="content-container">
		
		<div class="row rel-row">
			
			<?php 
				foreach($similarArticles as $similarArticle) {
					$getArticleImageForIndex = $similarArticle->getArticleImageForIndex();
					if(is_object($getArticleImageForIndex)){
						$src = ( file_exists(sfConfig::get('sf_web_dir').ZestCMSImages::getImageURL('article', 'size-sm').$similarArticle->getArticleImageForIndex()->getFilename()) ? ZestCMSImages::getImageURL('article', 'size-sm') : ZestCMSImages::getImageURL('article', 'size-s') ).$similarArticle->getArticleImageForIndex()->getFilename();
					}else{
						$src = '';
					}
			?>
			<div class="col-md-4 related-article-item-container">
				<a href="<?= url_for( '@article?slug='.$similarArticle->getSlug() ); ?>" title="<?= $similarArticle->getTitleByCulture(); ?>" class="related-article-item">
					<span class="rel-article-title"><?= $similarArticle->getTitleByCulture(); ?></span>
					<span class="rel-article-image-holder">
						<img src="<?= $src; ?>" alt="">
					</span>
				</a>
			</div> <!-- END related-article-item-container -->
			<?php } ?>
			
		</div>

	</div><!--  END content-container -->

</div> <!-- END related-articles-holder -->
<?php } ?>