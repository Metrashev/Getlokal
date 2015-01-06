<?php if (isset($categories) && count($categories)>0){
		$currentUrl = sfContext::getInstance()->getRequest()->getParameter( 'slug' ); ?>
		<div class="events-section-categories">
                <div class="event-categories-title">
                   <?php echo __('Categories', null, 'article')?> 
	            </div><!-- categories-title -->
                <ul class="events-category-list">
                	<li <?=($currentUrl == '') ? ' class="selected" ' : ''; ?>>
						<div class="marker"></div>
						<a href="<?=url_for('@article_index') ?>"> <?php echo __("All categories", null, 'messages'); ?></a>
					
					</li>
                	<?php $array_keys = count($categories)-1;
						  foreach ($categories as $key => $category){ ?>
							<li <?=($currentUrl == $category->getSlug()) ? ' class="selected" ' : ''; ?>>
							<div class="marker"></div>
								<a href="<?=url_for( '@article_category?slug='.$category->getSlug() ); ?>"><?=$category->getTitle();?></a>
							</li>
					<?php } ?>
                </ul><!-- categories-list -->
        </div><!--  END events-section-categories -->            
<?php }?>

