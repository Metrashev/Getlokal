<div class="col-md-6 small-articles-col">
	<div class="small-article-holder">
		<a href="<?php echo  url_for('article', array('slug'=>$article->getSlugByCulture() ) ) ?>" title="<?php echo $article->getTitleByCulture() ?>" class="title"><?php echo $article->getTitleByCulture() ?></a>
		<div class="custom-row">
			<div class="date"><?php echo date('d.m.Y',strtotime( $article->getCreatedAt() ) );?></div>
			<div class="article-author pull-right"><?php echo $article->getUserProfile()->getLink(false, null, 'class="author"',ESC_RAW); ?></div>
		</div>
		<div class="tags">
			<?php include_component('article', 'categories_for_article', array( 'article_id'=>$article->getId() ) );?>
		</div>
		<div class="image-holder">
			<a href="<?php echo  url_for('article', array('slug'=>$article->getSlugByCulture() ) ) ?>" title="<?php echo $article->getTitleByCulture() ?>">
				<img src="<?=ZestCMSImages::getImageURL('article', 'original').$article->getArticleImageForIndex()->getFilename()?>" alt="<?php echo $article->getTitleByCulture() ?>">
			</a>
		</div>
		<div class="description">
			<?php echo strip_tags(truncate_text(html_entity_decode ($article->getContentShow()), 370, '...', true)); ?>
		</div>
	</div> <!-- END small-article-holder -->
</div>