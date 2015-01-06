<?php 
	if($article){
 		$author = $article->getUserProfile();
		$authorName = $author->getFirstName()." ".$author->getLastName();
?>
<div class="big-article-holder">
	<a href="<?php echo  url_for('article', array('slug'=>$article->getSlugByCulture() ) ) ?>" title="<?php echo $article->getTitleByCulture() ?>" class="article-title"><?php echo $article->getTitleByCulture() ?></a>

	<div class="article-info-box bot-distance big-article-preview">
		<div class="article-info">
			<div class="custom-row">
				<div class="article-date"><?php echo date('d.m.Y',strtotime( $article->getCreatedAt() ) );?></div>
				<div class="article-author">
					<?php echo __("This article is created by", null, 'article'); ?> <?php echo $article->getUserProfile()->getLink(false, null, 'class="author"',ESC_RAW); ?>
				</div> <!-- END article-author -->
			</div>
			<div class="tags">
				<?php include_component('article', 'categories_for_article', array( 'article_id'=>$article->getId() ) );?>
			</div>
		</div> <!-- END article-info -->

	</div> <!-- END article-info-box -->

	<div class="image-container">
		<a href="<?php echo  url_for('article', array('slug'=>$article->getSlugByCulture() ) ) ?>" title="" class="image-link-holder">
			<?php if (is_object($article) && is_object($article->getArticleImageForIndex())) { ?>
				<img src="<?php echo ZestCMSImages::getImageURL('article', 'big').$article->getArticleImageForIndex()->getFilename();?>" alt="<?php echo $article->getTitleByCulture(); ?>">
			<?php } ?>	
		</a>
	</div> <!-- END image-container -->

	<div class="article-description-container">
	<?php if ($article->getArticleImageForIndex()){ ?>
		<div class="source"><?php echo __('Source', null, 'article'); ?>: <a href="#" title=""><?php echo $article->getArticleImageForIndex()->getSource() ;?></a></div>
	<?php } ?>
		<div class="description">
			<?php echo strip_tags(truncate_text(html_entity_decode ($article->getContentShow()), 600, '...', true)); ?>
		</div>	
	</div> <!-- END article-description-container -->

</div> <!-- END big-article-holder -->
<?php } ?>