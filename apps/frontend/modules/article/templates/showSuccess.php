<?php 
	include_partial('showSlider');
	$img_count=count($article->getArticleImagesForSlider());
	
	$county = sfContext::getInstance()->getRequest()->getParameter('county', false);
	
	if ($county || (getlokalPartner::getInstanceDomain() == 78)){
		$hrefLocation = url_for('@homeCounty?county='. $sf_user->getCounty()->getSlug());
		$hrefArticle = url_for('@article_index');
	}else{
		$hrefLocation = url_for('@home?city='. $sf_user->getCity()->getSlug());
		$hrefArticle = url_for('@article_index');
	}
	
	slot('facebook') ?>
	<meta property="fb:app_id" content="<?php echo sfConfig::get('app_facebook_app_'.$sf_user->getCountry()->getSlug().'_id');?>"/>
	<meta property="og:url" content="<?php echo $url_for_fb?>">
	<meta property="og:title" content="<?php echo $article->getTitleByCulture() ?>">
	<meta property="og:description" content="<?php echo strip_tags(html_entity_decode ($article->getContentIndex())) ?>">
	<meta property="og:site_name" content="<?php echo $sf_request->getHost() ?>" />
    <meta property="og:type" content="article" />
	<?php if ($img_count):?>
    <meta property="og:image" content="<?php echo 'http'.((@$_SERVER['HTTPS'])?'s':'').'://'. $sf_request->getHost() .ZestCMSImages::getImageURL('article', 'big').$article->getArticleImagesForSlider()->getFirst()->getFilename() ;?>">
	<?php endif;?>
    <?php date_default_timezone_set('Europe/Bucharest');?>
    <?php $published_time = date(DATE_ISO8601, strtotime($article->getCreatedAt()));?>
	<meta property="article:published_time" content="<?php echo $published_time ?>" />
    <meta property="article:publisher" content="https://www.facebook.com/getlokal" />
        
<?php end_slot() ?>
<div class="container set-over-slider">
	<div class="row">

		<div class="container">
			<div class="row">
			<div class="col-sm-12 path-holder-margin">
				<?php include_partial('global/breadCrumb') ?>
			</div>
   				<h1 class="col-sm-12 list-header"><?=__('Articles')?></h1>
			</div>
		</div>
		<div class="col-md-4 col-lg-4 hidden-sm boxesToBePulledDown">
				
			<?php include_component('article', 'category');?>	
			<div class="list-premium-places">
				<?php include_component('box', 'boxVip') ?>	
			</div>
			<?php 
			if (isset($articles) && $articles) {
				include_component('article', 'eventsIndex', array('articles'=>$articles)); 
			} ?>			
			<?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
			<div class="default-container">
				<h3 class="heading"><?php echo __('Sponsored'); ?></h3>
				<!-- END heading -->
				<div class="content">
					<?php include_partial('global/ads', array('type' => 'box')) ?>
				</div>
				<!-- END content -->
			</div>
			<?php endif;?>
			
		</div>
		 <div class="col-sm-12 col-md-8 col-lg-8 boxesToBePulledDown">
            <div class="all-lists">
            	                <?php if ($user && $user->getId() && ($user_profile->isSuperAdmin() || $user->getId() == $article->getUserId() || in_array('article_editor', $user_profile->getCredentials()->getRawValue()))) {?>
                <a class="default-btn edit top-article-btn" href="<?php echo url_for('article/edit?id='.$article->getId() );?>"><i class="fa fa-pencil"></i><?php echo __('Edit ')?></a>
                <?php } ?>
            </div>
            <div class="list-content-default">
                <div class="articles-list-content">
                	<div class="big-article-holder">
	                	<h1 class="article-title"><?php echo $article->getTitleByCulture(); ?></h1>
						<div class="article-info-box">
							<div class="article-info">
								<div class="article-date"><?php echo date('d.m.Y',strtotime( $article->getCreatedAt() ) );?></div>
								<div class="tags static-width">
									<?php include_component('article', 'categories_for_article', array( 'article_id'=>$article->getId() ) );?>
								</div>
							</div> <!-- END article-info -->
							<!-- written by: <?= $article->getUserProfile()->getLink(false, null, 'class="author"',ESC_RAW); ?>  -->
								<?php include_partial('author', compact('article')) ?>
						</div> <!-- END article-info-box -->

						<div class="social-bar floated">
							<div class="social-info-text"><?php echo __('SHARE', null, 'company'); ?></div>

							<div class="socials-container">
							<?php include_partial('global/social', array('hasSocialScripts' => true, 'hasSocialHTML' => true)); ?>
							<!-- 
								<div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
								<a class="twitter-share-button" href="https://twitter.com/share">Tweet</a>
								<div class="g-plusone" data-size="medium" data-annotation="inline" data-width="30"></div>
							-->
							</div>
						</div> <!-- END article-social-bar -->

						<?php if ( $img_count ) { ?>
						<div class="slider-container">
						
						    <div id="myCarousel" class="carousel slide article-slider" data-ride="carousel">
						      <!-- Indicators -->
						      <ol class="carousel-indicators">
						      <?php 
						      $i = 0;
						      foreach ($article->getArticleImagesForSlider() as $key => $image) { ?>
						      	<li data-target="#myCarousel" data-slide-to="<?= $i ?>"<?= ($i == 0 ? ' class="active"' : ''); ?>></li>
						      <?php
						      	$i++;
							  }
							  ?>
						     
						      </ol>
						      <div class="carousel-inner">
						      <?php 
						      	if ( $img_count > 0) {
									$i = 0;
									foreach ($article->getArticleImagesForSlider() as $image) {
						      ?>
						      	<div class="item<?= ($i == 0 ? ' active' : ''); ?>">
						      		<img src="<?php echo ZestCMSImages::getImageURL('article', 'original').$image->getFilename();?>" alt="<?=$article->getTitleByCulture();?>" title="<?=$article->getTitleByCulture();?>" />
						      	</div>
						      <?php 
						      			$i++;
						      		}
						      	}
						      ?>	
						      
						    </div><!-- /.carousel -->

						</div> <!-- END slider-container -->
						<?php } ?>

						<div id="articleContent" class="article-description-container">
							<?php echo html_entity_decode($article->getContentShow()); ?>
						</div> <!-- END article-description-container -->

						<?php if (count($article_pages) > 0) { ?>
						<div class="article-place-container floated">
						
							<?php foreach ($article_pages as $article_page) { ?>
							<div class="list-details-company-item">
                                <div class="col-sm-3 col-md-3 col-lg-3 list-details-company-image">
                                	<a href="<?php echo url_for(sprintf('@company?city=%s&slug=%s', $article_page->getCompanyPage()->getCompany()->getCity()->getSlug(), $article_page->getCompanyPage()->getCompany()->getSlug()));?>">
                                		<img src="<?= $article_page->getCompanyPage()->getCompany()->getThumb(0); ?>"  alt="<?= $article_page->getCompanyPage()->getCompany()->getCompanyTitleByCulture() ?>">
                                	</a>
                                </div> <!-- END list-details-company-image -->

                                <div class="col-sm-9 col-md-9 col-lg-9 list-details-company-desc">
                                    <a href="<?php echo url_for(sprintf('@company?city=%s&slug=%s', $article_page->getCompanyPage()->getCompany()->getCity()->getSlug(), $article_page->getCompanyPage()->getCompany()->getSlug()));?>" title="<?= $article_page->getCompanyPage()->getCompany()->getCompanyTitleByCulture(); ?>" class="title-holder"><h4><?= $article_page->getCompanyPage()->getCompany()->getCompanyTitleByCulture(); ?></h4></a>
                                    <div class="stars-holder big article-stars">
                                        <ul>
                                            <li class="gray-star"><i class="fa fa-star"></i></li>
                                            <li class="gray-star"><i class="fa fa-star"></i></li>
                                            <li class="gray-star"><i class="fa fa-star"></i></li>
                                            <li class="gray-star"><i class="fa fa-star"></i></li>
                                            <li class="gray-star"><i class="fa fa-star"></i></li>
                                            <li><p class="reviews-number"><span><?= $article_page->getCompanyPage()->getCompany()->getNumberOfReviews(); ?></span><?= format_number_choice('[0] reviews|[1] review|(1,+Inf] reviews', array(), $article_page->getCompanyPage()->getCompany()->getNumberOfReviews()); ?></p></li>
                                        </ul>
                                        <div class="top-list">
                                            <div class="hiding-holder" style="width: <?= $article_page->getCompanyPage()->getCompany()->getRating() ?>%;">
                                                <ul class="spans-holder">
                                                    <li class="red-star"><i class="fa fa-star"></i></li>
                                                    <li class="red-star"><i class="fa fa-star"></i></li>
                                                    <li class="red-star"><i class="fa fa-star"></i></li>
                                                    <li class="red-star"><i class="fa fa-star"></i></li>
                                                    <li class="red-star"><i class="fa fa-star"></i></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div><!--  END stars-holder -->
                                    <div class="localised-at"><?= $article_page->getCompanyPage()->getCompany()->getCity()->getLocation(); ?></div>
                                    <div class="bonus-details">
										<div class="single-detail">
											<i class="fa fa-map-marker"></i>
											<span><?= $article_page->getCompanyPage()->getCompany()->getDisplayAddress(); ?></span>
										</div> <!-- END single-details -->
										<div class="single-detail">
											<i class="fa fa-phone"></i>
											<span class="bold"><?= $article_page->getCompanyPage()->getCompany()->getPhoneFormated(); ?></span>
										</div> <!-- END single-details -->
										<a href="<?= url_for($article_page->getCompanyPage()->getCompany()->getClassificationUri(ESC_RAW)); ?>" title="<?= $article_page->getCompanyPage()->getCompany()->getClassification(); ?>" class="single-detail">
											<i class="fa fa-tags"></i>
											<span><?= $article_page->getCompanyPage()->getCompany()->getClassification(); ?></span>
										</a> <!-- END single-details -->
                                    </div><!--  END bonus-details -->
                                </div> <!-- END list-details-company-desc -->
                            </div> <!-- end list-details-company-item -->
                            <?php } ?>
						</div><!--  END article-place-container -->
						<?php } ?>

							<!-- Removed - Short description -->
							<!--
							<div class="article-description-container">

								<?//= $article->getDescriptionByCulture(); ?>

							</div> <! END article-description-container -->
							
							<!--  Related Articles -->
							<?php include_component('article', 'related', array('article_id'=>$article->getId() )); ?>
							<!--  End Related Articles -->
						</div> <!-- END big-article-holder -->
                	</div> <!-- END articles-list-content -->
            	</div>

	            <!-- START COMMENT -->
	            <div class="list-details-comments articles-comments-fix">
	                    <div class="wrapp-comment-header">
	                        <h3 class="comment-header"><?php echo __('Comments'); ?></h3>
	                    </div>
	                
	                <div class="lists-details-facebook-plugin">
	                        <?php include_partial('global/facebook_comments')?>
	                        <?php /*<div class="facebook-list-details fb-comments" data-href="<?= $url_for_fb; ?>" data-numposts="1" data-colorscheme="light"></div>*/?>
	                    <div class="pp-tabs">
	                        <div class="pp-tabs-body">
	                            <div class="pp-tab" style="display: block;">
	                            <?php include_component('comment', 'comments', array('activity' => $article->getActivityArticle(), 'user' => $user, 'url'=>url_for('article/comments?article_id='. $article->getId()), 'pager_class' => 'comment_in' )) ?>
	                                
	                            </div><!-- pp-tab -->                       
	                        </div><!-- pp-tabs-body -->
	                    </div> <!-- pp-tabs-end -->
	                </div>  <!-- end facebook plugin -->      
	            </div>
	            <!-- END COMMENT -->
        	</div>
		</div>
	</div>
</div>