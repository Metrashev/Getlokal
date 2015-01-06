<?php use_helper('Pagination');
    $articles = $pager->getResults();
    $articles_count = $pager->getNbResults();
    //$culture=$sf_user->getCulture();

    slot('pre_content'); 
        include_component('article', 'category', compact('category'));
    end_slot(); 

?>
<div class="content_in content_in_small">
<?php if(!empty($last_add) && sfContext::getInstance()->getRequest()->getParameter('page', 1) == 1 ):?>
<div class="article_item">
		<h2><a href="<?php echo  url_for('article', array('slug'=>$last_add->getSlugByCulture() ) ) ?>"><?php echo $last_add->getTitleByCulture() ?></a></h2>
		<div class="article_info">
			<?php echo $last_add->getUserProfile()->getLink(ESC_RAW); ?> /
			<span><?php echo date('d.m.Y',strtotime( $last_add->getCreatedAt() ) );?></span>

			<?php include_component('article', 'categories_for_article', array( 'article_id'=>$last_add->getId() ) );?>

		</div>
		<div class="article_content">
			<?php if ( $last_add->getArticleImageForIndex() ):?>
			<div class="article_picture_wrap">
				<a href="<?php echo  url_for('article', array('slug'=>$last_add->getSlugByCulture() ) ) ?>" ><img src="<?php echo ZestCMSImages::getImageURL('article', 'big').$last_add->getArticleImageForIndex()->getFilename();?>" alt="<?php echo $last_add->getArticleImageForIndex()->getDescrption(); ?>" /></a>
				<?php if ($last_add->getArticleImage()->getFirst()->getSource() ):?>
					<p> <?php echo __('Source',null,'article')?>: <?php echo $last_add->getArticleImageForIndex()->getSource() ;?></p>
				<?php endif;?>
			</div>
			<?php endif;?>
			<?php echo strip_tags(truncate_text(html_entity_decode ($last_add->getContentIndex()), 370, '...', true)) ?>
		</div>
	</div>
<?php endif;?>
	<?php if ( $articles_count > 0):?>
	<?php $article_listed=0;?>
	<?php $last = count($articles)-1;?>
	<?php foreach ($articles as $kay=>$article): ?>
		<?php $article_listed++;?>
		<?php  if ($article_listed==1): ?>
			<div class="article_listed">
		<?php endif;?>

	<div class="article_item">
		<div class="article_content">
			<?php if ( $article->getArticleImageForIndex() ):?>
			<div class="article_picture_wrap">
				<?php if ($article->getArticleImageForIndex()):?>
					<a href="<?php echo  url_for('article', array('slug'=>$article->getSlugByCulture() ) ) ?>"
                    style="background-image: url(<?php echo ZestCMSImages::getImageURL('article', 'big').$article->getArticleImageForIndex()->getFilename();?>);"
                    title="<?php echo $article->getArticleImageForIndex()->getDescrption(); ?>">
                    </a>
				<?php endif;?>
			</div>
			<?php endif;?>
		</div>

		<h2><a href="<?php echo  url_for('article', array('slug'=>$article->getSlugByCulture() ) ) ?>"><?php echo $article->getTitleByCulture() ?></a></h2>
		<div class="article_info">
			<?php echo $article->getUserProfile()->getLink(ESC_RAW); ?> /
			<span><?php echo date('d.m.Y',strtotime( $article->getCreatedAt() ) );?></span>

			<?php include_component('article', 'categories_for_article', array( 'article_id'=>$article->getId() ) );?>

		</div>
	</div>

		<?php if ($article_listed==2 || $last==$kay): $article_listed=0?>
			<div class="clear"></div>
			</div>
		<?php endif;?>

	<?php endforeach; ?>
		<?php if(sfContext::getInstance()->getActionName() == 'index'):?>
			<?php echo pager_navigation($pager, url_for('@article_index')); ?>
		<?php elseif(sfContext::getInstance()->getActionName() == 'category'):?>
			<?php echo pager_navigation($pager, url_for( '@article_category?slug='.$slug )); ?>
		<?php endif;?>
	<?php endif;?>



	<div class="article_wrap">
		<?php include_component('article', 'listsIndex', array('articles'=>$articles)); ?>
	</div>

</div>

	<?php /* ?>
				<!-- First item start -->
				<div class="article_item">
					<h2><a href="#">Title</a></h2>
					<div class="article_info">
						<a href="#">User profile</a> /
						<span>27.03.2013</span> /
						<ul>
							<li>
								<a class="category" href="#">Събития и култура</a>
								/
							</li>
							<li>
								<a class="category" href="#">Семейство</a>
							</li>
						</ul>
					</div>
					<div class="article_content">
						<div class="article_picture_wrap">
							<a href="#" ><img width="289" height="217" src="/images/users/50x50/50x50.png" alt="" /></a>
						</div>
					</div>
				</div>
				<!-- First item end -->
	<?php */?>


<div class="sidebar">
	<?php if  ( $user && $user->getId() && ($user_profile->isSuperAdmin()  || in_array('article_editor', $user_profile->getCredentials()->getRawValue() ) || in_array('article_writer', $user_profile->getCredentials()->getRawValue())  ) ):?>
	<div class="hp_block">
		<a class="button_pink_bigger" href="<?php echo url_for('article/create' )?>"><?php echo __('Create an Article', null, 'article')?></a>
	</div>
	<?php endif;?>
	<?php include_component('article', 'eventsIndex', array('articles'=>$articles)); ?>
	<?php include_component('article', 'placesIndex', array('articles'=>$articles)); ?>
<?php /*
	<?php  if ( $video ):?>
			<h3><?php echo __('Latest episode of Getweekend',null,'list') ?></h3>
			<iframe style="margin-bottom:25px;" width="300" height="170" src="http://www.youtube.com/embed/<?php echo $video->getEmbed() ?>?rel=0" frameborder="0" allowfullscreen></iframe>
		<?php endif;?>
*/ ?>
	<?php if ($sf_user->getCountry()->getSlug()!= 'fi'):?>   
	    <?php include_component('home','social_sidebar'); ?> 
	<?php endif;?>
        <?php include_partial('global/ads', array('type' => 'box')) ?>
	<?php include_component('box', 'boxCategories'); ?>
        <?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
        <div class="pullUp">
            <?php  include_partial('global/ads', array('type' => 'box2')); ?>
        </div>    
        <?php endif;?> 
</div>
<div class="clear"></div>
