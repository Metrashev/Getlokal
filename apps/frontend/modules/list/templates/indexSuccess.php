<?php
	use_helper('Pagination');
	include_partial('indexSlider');
	$lists = $pager->getResults();
	$listscount = $pager->getNbResults();
?>
<div class="container set-over-slider">
	<div class="row">
		<div class="container">
			<div class="row">
            		<div class="col-sm-12 path-holder-margin"><?php include_partial('global/breadCrumb') ?></div>
				<h1 class="col-sm-12 list-header"><?php echo __('Lists'); ?></h1>
			</div>
		</div>
		<div class="col-md-4 col-lg-4 hidden-sm boxesToBePulledDown">
			<?php include_component('box','boxCategories')?>
			<?php include_component('box', 'boxVip') ?>
			<?php include_component('box', 'boxSingleSliderOffers') ?>
		</div>
		<div class="col-sm-12 col-md-8 col-lg-8 boxesToBePulledDown">
            <div class="all-lists">
            	
                <a class="default-btn success add-new-list-btn" href="<?php echo url_for('list/create') ?>"><span class="plus-icon-add-new-list"></span><?php echo __('Create a List Now', null, 'list') ?></a>
            </div>
            <div class="list-content">
              <?php if ($listscount > 0){
	              	echo '<ul>';
		              foreach ($lists as $k=>$list){
						if($k == 4 && ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO)){?>
							<div class="col-sm-12">
								<div class="default-container">
									<div class="content">
										<?php include_partial('global/ads', array('type' => 'lists')) ?>
									</div>
									<!-- END content -->
								</div>
							</div>
						<?php }
						include_partial('listItem', array('list' => $list, 'list_user' => $list->getUserProfile()));
	              	  }
	              	echo '</ul>';
	                echo pager_navigation($pager, url_for('list/index'));	                
				} ?>
            </div>
       </div>
	</div>
</div><!-- categories_wrapper -->				
<div class="events_wrapper">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<?php include_component('event', 'sliderEvents', array('city' => $sf_user->getCity()->getDisplayCity()))?>						
			</div>
		</div>
	</div>
</div><!-- events_wrapper -->


<div class="container">
	<div class="row">
				<div class="col-sm-6 hidden-md hidden-lg">
			<?php include_component('box', 'boxVip') ?>
		</div>
		
		<div class="col-sm-6 hidden-md hidden-lg">
			<?php include_component('box', 'boxSingleSliderOffers') ?>
		</div>
	</div>
</div>