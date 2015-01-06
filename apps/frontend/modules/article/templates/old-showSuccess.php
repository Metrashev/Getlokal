<?php 
    use_stylesheet('ui-lightness/jquery-ui-1.8.17.custom.css'); 
    $img_count=count($article->getArticleImagesForSlider());

    // categories slot
    slot('pre_content'); 
        include_component('article', 'category');
    end_slot(); 
?>
<?php $hasSocialScripts = true?>
<?php $hasSocialHTML = false;?> 
<?php // fb meta slot ?>
<?php slot('facebook') ?>
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
<?php // end fb meta slot ?>
        
<?php $culture=$sf_user->getCulture();?>

<?php // fb script for Mihai ?>
<?php if($sf_user->getCountry()->getSlug() == 'ro'): ?>
	<?php slot('facebook_article_script')?>
		<script type="text/javascript">
		var fb_param = {};
		fb_param.pixel_id = '6008740260570';
		fb_param.value = '0.00';
		(function(){
		  var fpw = document.createElement('script');
		  fpw.async = true;
		  fpw.src = (location.protocol=='http:'?'http':'https')+'://connect.facebook.net/en_US/fp.js';
		  var ref = document.getElementsByTagName('script')[0];
		  ref.parentNode.insertBefore(fpw, ref);
		})();
		</script>
		<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/offsite_event.php?id=6008740260570&amp;value=0" /></noscript>
	<?php end_slot() ?>
<?php endif;?>
<?php // end fb script ?>
<!-- start .article_wrap  -->
<div class="article_wrap">

        <?php // start .content_in ?>
	<div id="article-wrap" class="content_in">

		<h1><?php echo $article->getTitleByCulture();?></h1>
                    
                <?php // start .article_info ?>
		<div class="article_info">
			<?php echo $article->getUserProfile()->getGplusAuthorLink(ESC_RAW); ?> /
			<span><?php echo date('d.m.Y',strtotime( $article->getCreatedAt() ) );?></span>
			<?php include_component('article', 'categories_for_article', array( 'article_id'=>$article->getId() ) );?>
		</div>
                <?php // end .article_info  ?>
                <?php // start .place_social_wrap  ?>
		<div class="place_social_wrap">
			<?php include_partial('global/social', array('hasSocialScripts' => true, 'hasSocialHTML' => true)); ?>
		</div>
                <?php // end .place_social_wrap ?>
                <?php // start .article_content ?>
		<div id="article_content" class="article_content">
		<?php if ( $img_count ):?>
                        <?php // start .article_picture_wrap ?>
			<div class="article_picture_wrap">
                                <?php // start .carousel_wrapper ?>
				<div class="carousel_wrapper">
                                        <?php // start .carousel_content ?>
					<div class="carousel_content">
						<ul>
						 <?php foreach ($article->getArticleImagesForSlider() as $key => $image):?>
					        <li>
					       		<a name="<?php echo $image->getUserProfile() ?>" rev="<?php echo $image->getUserProfile()->getSfGuardUser()->getUsername();?>"  id="fancy-image-<?php echo $image->getId()?>" title="<?php echo $image->getDescrption(); ?>" href="<?php echo  ZestCMSImages::getImageURL('article', 'original').$image->getFilename() ?>" class="grouped_elements" rel="group2"><img src="<?php echo ZestCMSImages::getImageURL('article', 'big').$image->getFilename();?>" alt="<?php echo $image->getDescrption(); ?>" /> </a>
								<?php if ($image->getSource() ):?>
									<p><?php echo __('Source',null,'article')?>: <?php echo $image->getSource() ;?></p>
								<?php endif;?>
					        </li>
					     <?php endforeach;?>
						</ul>
						<?php if ( $img_count > 1):?>
						    <div class="carousel_dots">
							    <?php foreach ($article->getArticleImagesForSlider() as $image):?>
							        <div class="carousel_dot">
							        	<div class="carousel_img">
							          		<img src="<?php echo ZestCMSImages::getImageURL('article', 'size-xs').$image->getFilename();?>" alt="" />
							        	</div>
							        </div>
							    <?php endforeach;?>
						    </div>
					    <?php endif;?>
					</div>
				</div>
			</div>
		  <?php endif;?>
		  <?php
              include_partial('content', array(
                'article' => $article,
                'sf_cache_key' => $article->getId().$culture
              ));
          ?>
          
          <?php //echo html_entity_decode($article->getContentShow()); ?>
<?php /*
		  <!-- start .article_content_wrap  -->
		  <div class="article_content_wrap">
		  	<h3>
				<a href="#">

					<?php echo image_tag($article->getUserProfile()->getThumb(), array('size'=>'150x150', 'alt'=>'')) ?>

					<?php echo $article->getUserProfile()->getLink(ESC_RAW); ?>
				</a>
			</h3>
			<p>
			<?php
				$lines=explode("\n",wordwrap( $article->getUserProfile()->getSummary(), 370));
				echo $lines[0] . '...';
			?>
			</p>
		 </div>
		 <!-- end .article_content_wrap  -->
*/ ?>                 
		</div>
                <?php include_partial('global/ads', array('type' => 'inread')); ?>               
		<div class="clear"></div>
		<?php if (count($article_events)>0):?>
		<div class="article_content_wrap">
	 		<div class="event_module_wrap">
	 			<h3><?php echo __('Related Events',null,'article');?></h3>
	 			<div class="event_scroll">
        			<div class="scrollbar">
        				<div class="track">
        					<div class="thumb">
        						<div class="end">
        						</div>
        					</div>
        				</div>
        			</div>
        			<div class="viewport">
				 		<ul class="overview">
				 			<?php foreach ($article_events as $article_event):?>
					 			<li>
					 				<div class="pink_link_wrap">
					 					<?php echo link_to(__('More Info'),'event/show?id='.$article_event->getEvent()->getId(), array('class'=>'button_pink', 'title' => __('More Info')));?>
					 				</div>

					 				<?php if ($article_event->getEvent()->getImage()->getType()=='poster' ):
			      							echo image_tag($article_event->getEvent()->getThumb('preview'),array('size'=>'101x135', 'alt'=>$article_event->getEvent()->getDisplayTitle()));
			      						else:
	    			 						echo image_tag($article_event->getEvent()->getThumb(2), array( 'size'=>'180x135', 'alt'=>$article_event->getEvent()->getDisplayTitle() ) );
			        				endif;?>

			        				<?php echo link_to($article_event->getEvent()->getDisplayTitle(),'event/show?id='.$article_event->getEvent()->getId(), array('title' => $article_event->getEvent()->getDisplayTitle()));?>
					 				<span><?php echo  $article_event->getEvent()->getDateTimeObject('start_at')->format('d/m/Y')?></span>
					 				<?php echo link_to($article_event->getEvent()->getCategory(),'event/index?category_id='. $article_event->getEvent()->getCategoryId(), array('class' => "category", 'title' => $article_event->getEvent()->getCategory()))?>
					 				<div class="clear"></div>
					 			</li>
				 			<?php endforeach;?>
				 		</ul>
		 			</div>
	 			</div>
	 		</div>
	 	</div>
	 	<?php endif;?>


	 	<?php if (count($article_lists)>0):?>
			<div class="article_content_wrap">
				<h2><?php echo __('Related Lists',null,'article')?></h2>
				<?php foreach ($article_lists as $article_list):
					include_partial('list/list', array('list'=>$article_list->getLists(), 'list_user' => $article_list->getLists()->getUserProfile()));
				 endforeach;?>
				 <div class="clear"></div>
			</div>>
		<?php endif;?>

		<?php /*
		 <div class="more-states">
		 			<div class="states-head">
		 				<h2><?php echo __('Related Articles',null,'article')?></h2>
		 				<a href="<?php echo url_for( '@article_category?slug='.$category->getSlug() ); ?>"><?php echo __('see all',null,'messages')?></a>
		 			</div>
		 
		 			<div class="states-body">
		 				<ul class="more-articles">
                            <?php foreach($similarArticles as $similarArticle): ?>
		 					<li>
		 						<a href="<?php echo url_for( '@article?slug='.$similarArticle->getSlug() ); ?>">
		 							<img src="<?php echo ( file_exists(sfConfig::get('sf_web_dir').ZestCMSImages::getImageURL('article', 'size-sm').$similarArticle->getArticleImageForIndex()->getFilename()) ? ZestCMSImages::getImageURL('article', 'size-sm') : ZestCMSImages::getImageURL('article', 'size-s')).$similarArticle->getArticleImageForIndex()->getFilename();?>">
		 							<p><?php echo $similarArticle->getTitleByCulture() ?></p>
		 						</a>
		 					</li>
		 					<?php endforeach; ?>
		 				</ul>
		 			</div>
		 		</div>
		*/?>
		<div class="more-states">
			<?php include_component('article', 'related', array('article_id'=>$article->getId() )); ?>
		</div>
		<div class="article_content_wrap related">
			<h2><?php echo __('Comments')?></h2>

		    <div class="fb-comments" data-href="<?php echo $url_for_fb?>" data-num-posts="5" data-width="600" >
			</div>

			<div class="clear"></div>

			<div class="comment_in">
				<?php include_component('comment', 'comments', array('activity' => $article->getActivityArticle(), 'user' => $user, 'url'=>url_for('article/comments?article_id='. $article->getId()), 'pager_class' => 'comment_in' )) ?>
			</div>

		</div>
	</div>
	<div class="sidebar">
        <?php include_partial('author', compact('article')) ?>
        
		<?php if  ( $user && $user->getId() && ($user_profile->isSuperAdmin()  ||  $user->getId() == $article->getUserId() || in_array('article_editor', $user_profile->getCredentials()->getRawValue() ) ) ):?>
		<div class="hp_block">
			<a class="button_pink_bigger" href="<?php echo url_for('article/edit?id='.$article->getId() );?>"><?php echo __('Edit ')?></a>
		</div>
		<?php endif;?>


		<?php /*?>
			<div class="related_articles_wrap">
				<h2>Related Articles</h2>
				<div class="outline_wrap">
					<ul>
						<li>
							<a href=""><img src="" alt="" /></a>
							<a href="">Some article title here</a>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
							Mauris faucibus semper gravida. Nunc ac magna quis
							</p>
							<div class="clear"></div>
						</li>
						<li>
							<a href=""><img src="" alt="" /></a>
							<a href="">Some article title here2</a>
							<p>2Lorem ipsum dolor sit amet, consectetur adipiscing elit.
							Mauris faucibus semper gravida. Nunc ac magna quis
							</p>
							<div class="clear"></div>
						</li>
					</ul>
				</div>
			</div>
		<?php */?>

		<?php if (count($article_pages)>0):?>
			<div class="related_places_wrap">
				<h2><?php echo __('Related Places',null,'article')?></h2>
				<div class="outline_wrap">
					<ul>
					<?php foreach ($article_pages as $article_page):?>
							<li>
							<?php echo link_to(image_tag($article_page->getCompanyPage()->getCompany()->getThumb(1), 'size=52x52 alt=' . $article_page->getCompanyPage()->getCompany()->getCompanyTitle()), $article_page->getCompanyPage()->getCompany()->getUri(ESC_RAW), array('title' => $article_page->getCompanyPage()->getCompany()->getCompanyTitle())) ?>
		         			<?php echo link_to($article_page->getCompanyPage()->getCompany()->getCompanyTitle(), $article_page->getCompanyPage()->getCompany()->getUri(ESC_RAW), array('title' => $article_page->getCompanyPage()->getCompany()->getCompanyTitle())) ?>
								<div class="place_rateing">
									<div class="rateing_stars">
		              					<div class="rateing_stars_orange" style="width: <?php echo $article_page->getCompanyPage()->getCompany()->getRating() ?>%;"></div>
		            				</div>
		            				<p><?php echo format_number_choice('[0]0 reviews|[1]1 review|(1,+Inf]%count% reviews', array('%count%' => $article_page->getCompanyPage()->getCompany()->getNumberOfReviews()), $article_page->getCompanyPage()->getCompany()->getNumberOfReviews()); ?></p>
								</div>
							</li>
					<?php endforeach;?>
					</ul>
				</div>
			</div>
		<?php endif;?>
<?php /*
		<?php  if ( $video ):?>
			<h3><?php echo __('Latest episode of Getweekend',null,'list') ?></h3>
			<iframe style="margin-bottom:25px;" width="300" height="170" src="http://www.youtube.com/embed/<?php echo $video->getEmbed() ?>?rel=0" frameborder="0" allowfullscreen></iframe>
		<?php endif;  ?>
*/ ?>
		<?php include_partial('global/ads', array('type' => 'box')) ?>
                
		<?php // include_component('home','social_sidebar'); ?>
		<?php include_component('box', 'boxCategories') ?>
                <?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
                    <div class="pullUp">
                        <?php  include_partial('global/ads', array('type' => 'box2')); ?>
                    </div>    
                <?php endif;?> 
	</div>

</div>

<script type="text/javascript">
$(document).ready(function() {
<?php if ( $img_count > 1):?>
  var pause = false;
  var max = $('.carousel_content li').length -1;
  var _x = -1;
  var _f = 0;


  var change = function() {
    $('.carousel_dots .carousel_dot').removeClass('active');
    $('.carousel_dots .carousel_dot:nth-child('+ (_x + 1) +')').addClass('active');

    $('.carousel_content ul li').animate({opacity:0.3}, 200, function() {
    	$('.carousel_content ul').css({left: (_x * -600) + 'px'});
    	$('.carousel_content ul li:nth-child('+ (_x + 1) +')').animate({opacity:1}, 200);
    });

    _f = 0;
  };

  var next = function() {
    _x++;
    if(_x > max) _x = 0;
    change();
  };

  $('.carousel_dots .carousel_dot').click(function() {
    var index = $(this).parent().children().index(this);
    if(_x != index)
    {
      _x = index;
      change();
    }

    return false;
  });

  $('.carousel_wrapper').hover(function() {
	 	pause = true;
  }, function() {
    pause = false;
  });

  setInterval(function() {
    if(pause) return;
    _f++;
    if(_f>10) {
      next();
    }
  }, 1000);

  next();
<?php  endif;?>
  	$('.event_scroll').tinyscrollbar();

	if ($('.event_scroll .viewport ul').outerHeight() < $('.event_scroll .viewport').outerHeight()) {
		$('.event_scroll .viewport').css('height', $('.event_scroll .viewport ul').outerHeight());
		$('.event_scroll .viewport ul li').css('width', '525px');
	}

	$('.grouped_elements_2').click(function() {
	 	$( 'a#fancy-'+$(this).attr('id') ).trigger('click');
		return false;
	});

	function formatTitle(title, currentArray, currentIndex, currentOpts) {
		var a1 = 'rev';
		var a2 = 'name';
		var a3 = 'http://'+top.location.host.toString()+'/'+"<?php echo $culture ?>"+'/profile/'+currentArray[currentIndex][a1];
	    return '<div class="picture_title" style="display: inline-block; width: 100%;"><span class="right">' + (currentIndex + 1) + '/' + currentArray.length + '</span><p>' + (title && title.length ? title : '' ) + '</p><p>' + "<?php echo __('by')?>" + ' <a href="'+a3+'">'+currentArray[currentIndex][a2]+'</a></p></div>';
	}

	function formatWidth(title, currentArray, currentIndex, currentOpts) {
	    return parseInt(currentArray[currentIndex]['href'].match(/width=[0-9]+/i)[0].replace('width=',''));
	}
	function formatHeight(title, currentArray, currentIndex, currentOpts) {
	    return parseInt(currentArray[currentIndex]['href'].match(/height=[0-9]+/i)[0].replace('height=',''));
	}

	$('a.grouped_elements').fancybox({
		'cyclic'			: true,
		'titlePosition'		: 'inside',
		'overlayColor'		: '#000',
		'overlayOpacity'	: 0.6,
		'titleFormat'		: formatTitle,
		'index'				: true
		//'autoScale'			: false,
		//'width'				: '100%',
		//'height'			: '100%',
	});

/*
    $('a.grouped_elements').each(function(){
        var dWidth 	= parseInt($(this).attr('href').match(/width=[0-9]+/i)[0].replace('width=',''));
        var dHeight 	=  parseInt($(this).attr('href').match(/height=[0-9]+/i)[0].replace('height=',''));
			$(this).fancybox({
				'width':dWidth,
				'height':dHeight,
				'autoScale'     	: false,
				'titlePosition'		: 'inside',
				'overlayColor'		: '#000',
				'overlayOpacity'	: 0.6,
				'titleFormat'		: formatTitle,
				'type'			: 'iframe'
			});
   });
*/
<?php if ($sf_user->getCulture()== 'bg'): ?>
    $(".article_content blockquote span").addClass('bg_quotation');
     $(".article_content blockquote span:first-child").addClass('bg_quotation'); 
<?php endif;?>
})
</script>
