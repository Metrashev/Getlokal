<?php include_partial('global/commonSlider'); 
	  
$data = array(
	'send_message_option' => $send_message_option,
	'user' => $user,
	'is_other_place_admin_logged' => $is_other_place_admin_logged,
	'is_current_user' => $is_current_user,
	'is_followed' => $is_followed,
	'profile' => $profile,
	'pageuser' => $pageuser,
	'is_current_user' => $is_current_user,			
	'reviewCount' => $reviewCount,
	'review' => $review,			
	'imageCount' => $imageCount,
	'image' => $image,			
	'listCount' => $listCount,
	'image' => $image,						
	'list' => $list,			
	'eventCount' => $eventCount,
	'event' => $event,						
	'articleCount' => $articleCount,
	'user' => $user,
	'article' => $article,
	'messageCount' => $messageCount,
	'followerCount' => $followerCount,
	'followedCount' => $followedCount,
	'badgeCount' => $badgeCount,
	'voucherCount' => $voucherCount,
	'placesCount' => $placesCount,
	'checkIns' => $checkIns
);
$innerPages['top'] = array('reviewsTab', 'photosTab', 'listsTab', 'eventsTab', 'articlesTab');
$innerPages['bottom'] = array('conversationsTab', 'followersTab', 'followedTab', 'badgesTab', 'vouchersTab', 'placesTab');
?>
<div class="container">
	<div class="row">
		<div class="col-sm-12 default-container overflow-visible mar-85 ">
			<?php include_partial('userProfileInformation', $data); ?>
			<div class="row">
				<div class="col-sm-12">
				<?php $data['selectedTab'] = isset($tab) ? $tab : ''; include_partial('tabs', $data); ?>
					<?php if(isset($tab) && in_array($tab, $innerPages['top'])){	?>
						<div class="tab-content default-form-tabs-content">
							<div class="tab-pane active" id="Section01">
								<?php include_partial($tab, $tabData); ?>
							</div>
						</div>
					<?php } ?>
					<!-- Form Tabs Start -->
					
					<!-- Form Tabs End -->
					<?php if(isset($tab) && in_array($tab, $innerPages['bottom'])){?>
						<div class="tab-content default-form-tabs-content">
							<div class="tab-pane active" id="Section01">
								<?php include_partial($tab, $tabData); ?>
							</div>
						</div>
					<?php }?>
					<!-- END Form Tabs -->
				</div>
			</div>
		</div>
	</div>
</div>