<?php 
	use_helper('Pagination');
	include_partial('indexSlider');
	$articles = $pager->getResults();
	$articles_count = $pager->getNbResults();
	$skipFirstArticle = false;	
?>
<div class="container set-over-slider">
	<div class="row">

		<div class="container">
			<div class="row">
		      	<div class="col-sm-12 list-holder article path-holder-margin">
            		<?php include_partial('global/breadCrumb') ?>
                </div>

				<h1 class="col-sm-12 list-header"><?=__('Articles')?></h1>
			</div>
		</div>
		<div class="col-md-4 col-lg-4 hidden-sm boxesToBePulledDown">
			<?php 
				$component = get_component('article', 'category');
				slot('side_categories');
				echo $component;
				end_slot();
				echo $component;
			?>
			<div class="list-premium-places">
				<?php include_component('box', 'boxVip') ?>	
			</div>
			<?php include_component('article', 'eventsIndex', array('articles'=>$articles)); ?>
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
            <?php if  ( $user && $user->getId() && ($user_profile->isSuperAdmin()  || in_array('article_editor', $user_profile->getCredentials()->getRawValue() ) || in_array('article_writer', $user_profile->getCredentials()->getRawValue())  ) ){ ?>
            		<a class="default-btn success top-article-btn" href="<?=url_for('article/create' )?>"><i class="fa fa-plus"></i><?php echo __('Create an Article', null, 'article')?></a>
            <?php }?>
            </div>
            <div class="list-content-default">
                <div class="articles-list-content">
					<?php 
					if($pager->getPage() == 1){
						include_partial('bigArticle', array('article' => $last_add));
					}?>
					<div class="small-articles-holder">
						
						<div class="row small-articles-row">
							<?php 
							foreach ($articles as $k=>$article){
								if($k == 2 && ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO)){?>
									<div class="col-sm-12">
										<div class="default-container">
											<div class="content">
												<?php //include_partial('global/ads', array('type' => 'branding')) ?>
												<?php include_partial('global/ads', array('type' => 'article_between')) ?>
											</div>
											<!-- END content -->
										</div>
									</div>
							<?php }
								if(is_object($article->getArticleImageForIndex())){
									include_partial('articleListItem', array('article' => $article) );
								}
							}
							?>
						</div>						

					</div> <!-- END small-articles-holder -->

					<div class="wrapper-pager">
						<div class="ajaxPager paging paging-number paging">
							<?php 
							if(sfContext::getInstance()->getActionName() == 'index'){
								echo pager_navigation($pager, url_for('@article_index'));
							}elseif(sfContext::getInstance()->getActionName() == 'category'){
								echo pager_navigation($pager, url_for( '@article_category?slug='.$slug ));
							}
							?>
						</div><!-- /.paging -->
					</div> <!-- END paging-holder -->

                </div> <!-- END articles-list-content -->
            </div>
        </div>
	</div>
</div>