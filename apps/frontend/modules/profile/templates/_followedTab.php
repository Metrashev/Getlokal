<div class="row subtabs">	
	<a class="subtab col-xs-1 pull-right" id="tab_2" onclick="showTab('places')">Places</a>
	<a class="subtab col-xs-1 pull-right active" id="tab_1" onclick="showTab('users')">Users</a>
</div>
<div id="users">
<ul class="list-box-wrapper">
	<?php foreach($pager->getResults() as $followed_page){
		if(get_class($followed_page->getPage()->getRawValue()) !='CompanyPage'){
			// TODO: get it out in a partial
			$userProfile = $followed_page->getPage()->getUserProfile();
			if($sf_user->getCulture() != 'sr'){
				$vr1 = $userProfile->getCountry()->getCountryNameByCulture();
				$vr2 = $userProfile->getCity()->getDisplayCity();
			}else{
				$vr1 = $userProfile->getCity()->getDisplayCity();
				$vr2 = $userProfile->getCountry()->getCountryNameByCulture();
			}
			$send_message = true;
			?>
			<li class="list-box user">
				<div class="custom-row">
					<img src="<?=myTools::getImageSRC($userProfile->getThumb(), 'user')?>" class="img-circle profile-img">
					<div class="info">
						<?php echo link_to_public_profile($userProfile, array('class'=>'name'));?>
						<div class="location"><i class="fa fa-map-marker"></i><?php echo $vr1.", ".$vr2?></div>
					</div>
				</div>
				<div class="custom-row">
				<?php if ($userProfile):?>
		           <?php if($user && !$is_other_place_admin_logged):?>
						<?php echo link_to(__('Unfollow'), 'follow/stopFollow?page_id='. $followed_page->getPageId(), array('class' =>'default-btn small')); ?>
					<?php endif;?>
		             <?php if(sfConfig::get('app_enable_messaging')):?>
		              <?php if ($send_message):?>
		                <?php if ($followed_page->getInternalNotification()):?>
		                   <?php echo link_to(__('Send Message'), 'message/view?user='.$followed_page->getPageId(), array('class'=>'default-btn small')) ?>
		                <?php endif;?>
		              <?php endif;?>
		            <?php endif;?>
		          <?php endif;?>
				</div>
			</li><!-- END User -->
		<?php 
		}
	} ?>   
</ul>						
</div>

<div id="places" style="display: none;">
	<ul class="list-box-wrapper">
		<?php foreach($pager->getResults() as $followed_page){  
				// TODO: get it out in a partial
				if(get_class($followed_page->getPage()->getRawValue()) =='CompanyPage'){
					$companyProfile = $followed_page->getPage()->getCompany();
				?>
					<li class="list-box place">
						<div class="custom-row">
							<?php echo link_to(image_tag($companyProfile->getThumb(1), array('class' => 'profile-img', 'alt'=>$companyProfile->getCompanyTitle())), $companyProfile->getUri(ESC_RAW)); ?>
							<div class="info">
								<?php echo link_to_company($companyProfile, array('class' => 'name')); ?> 
								<div class="location"><i class="fa fa-map-marker"></i><?php echo $companyProfile->getDisplayAddress();?></div>
								<div class="tag"><i class="fa fa-tags"></i><?php echo $companyProfile->getClassification()?></div>
							</div>
						</div>
					</li><!-- END Place -->
		<?php   } 
			} ?>
	</ul>
</div>
<script type="text/javascript">
function showTab(tab){
	if(tab == 'users'){
		$('#tab_1').addClass('active');
		$('#tab_2').removeClass('active');
		$('#users').show();
		$('#places').hide();
	}else{
		$('#tab_2').addClass('active');
		$('#tab_1').removeClass('active');
		$('#places').show();
		$('#users').hide();
	}
	
}
</script>