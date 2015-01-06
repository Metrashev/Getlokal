<div class="profile_wrap">
	<div class="left_wrap">
		<ul class="special_tabs_listing">
					<!-- Photos -->
					<?php if ($imageCount > 0):?>
					<li>
						<div class="user_photo_listing">
							<h2><?php echo __('Photos', null,'company')?></h2>
							<?php foreach($images as $image):?>
							<div>
							  
								<?php echo image_tag($image->getThumb(0), array('alt' => $image->getCaption()))?>
								<?php if ($is_current_user):?>
								<div class="mask">
									<?php if($image->getId() != $pageuser->getUserProfile()->getImageId()): ?>
							          <a href="<?php echo url_for('userSettings/setProfile?id='. $image->getId()) ?>"><?php echo __('set as profile photo', null, 'company')?></a>
						            <?php endif ?>
									<?php echo link_to(__('delete', null, 'company'), 'userSettings/deleteImage?id='. $image->getId(), array('class' => 'confirm' )) ?>
								</div>
							  <?php endif;?>
							</div>
	                   <?php endforeach;?>
							<div class="clear"></div>
						</div>
						<a href="<?php echo url_for('profile/photos?username='. $pageuser->getUsername()) ?>"><?php echo __('see more')?></a>
					</li>
					<?php endif; ?>
					<!-- End Photos -->
					
					<!-- Reviews -->
					<?php if ($reviewCount > 0):?>
					<li class="odd">
						<div class="item_listing">
							<h2><?php echo __('Reviews')?></h2>
							
							<ul>
							<?php foreach($reviews as $review):?>
							<?php $company = $review->getCompany();?>
								<li>
									<?php echo link_to(image_tag($company->getThumb(1)),$company->getUri(ESC_RAW), 'class="img_wrap"') ?>
									<?php echo link_to_company($company)?>
									<?php echo link_to($company->getClassification(), $company->getClassificationUri(ESC_RAW), array('title='. $company->getSector(),'class'=>'category')) ?>
									<div class="place_rateing">
										<div class="rateing_stars" style="margin-top:2px;">
											<div style="width: <?php echo $review->getRating() * 20 ?>%" class="rateing_stars_pink"></div>
										</div>
										
										<span><?php echo $review->getRating() ?> / 5</span>
									</div>
									<p><?php echo (mb_strlen($review->getText(), 'UTF8') <= 53 )? $review->getText() : mb_substr($review->getText(), 0, 50, 'UTF8').'...';?></p>
								</li>
								<?php endforeach;?>
							</ul>
							
							<div class="clear"></div>
						</div>
						<a href="<?php echo url_for('profile/reviews?username='. $pageuser->getUsername()) ?>"><?php echo __('see more')?></a>
					</li>
					<?php endif;?>
					<!-- End Reviews -->
		</ul>
	</div>
	<div class="right_wrap">
		<ul class="special_tabs_listing">
					<!-- Lists -->
					<?php if ($eventCount > 0):?>
					<li>
						<div class="item_listing">
							<h2><?php echo __('Events')?></h2>
							<ul>
							<?php foreach($events as $event):?>
								<li>
									<?php if ($event->getImage()->getType()=='poster' ):
				      		echo image_tag($event->getThumb('preview'),array('size'=>'101x135', 'title'=>$event->getImage()->getCaption()));
				      	else:
		    			 	echo image_tag($event->getThumb(2), array( 'size'=>'180x135', 'title'=>$event->getImage()->getCaption() ) );
				        endif;?>
									<?php echo link_to($event->getDisplayTitle(),'event/show?id='.$event->getId());?>
									<p><?php echo  $event->getDateTimeObject('start_at')->format('d/m/Y')?></p>
									<p>
										<?php echo link_to($event->getCategory(),'event/index?category_id='. $event->getCategoryId(), array('class' => "extra"))?>
									</p>
								</li>
							<?php endforeach;?>
							</ul>
							<div class="clear"></div>
						</div>
						<a href="<?php echo url_for('profile/events?username='. $pageuser->getUsername()) ?>"><?php echo __('see more')?></a>
					</li>
					<?php endif;?>
					<!-- End Lists -->
					
					<?php if ($listCount > 0):?>
					<li>
						<div class="item_listing">
							<h2><?php echo __('Lists')?></h2>
							<ul>
							<?php foreach($lists as $list):?>
								<li>
									<a href="<?php echo url_for("list/show?id=".$list->getId())?>" title="<?php echo $list->getTitle();?>"  class="img_wrap">
										<?php if ($list->getImageId()):
											echo image_tag($list->getThumb(0),array('alt'=>$list->getTitle() ));
										    elseif ($list->getPlaces(true)):
											$places = $list->getPlaces();
											$places_count = $list->getPlaces(true);
											$i = 1;
											foreach ($places as $place):			
												if ($place->getImageId() || $i == $places_count - 1):
													echo image_tag($place->getThumb(0),array( 'alt'=> $list->getTitle() ));
													break;
												endif;
												$i++;
											endforeach;
											else:
											echo image_tag($list->getThumb(0),array('alt'=>$list->getTitle() ));
										endif; ?>
									</a>
									<a href="<?php echo url_for("list/show?id=".$list->getId())?>" title="<?php echo $list->getTitle();?>"><img alt="<?php echo $list->getIsOpen() ? 'unlocked' : 'locked'?>" title="<?php echo __($list->getIsOpen() ? 'Open' : 'Closed')?>" src="/images/gui/<?php echo $list->getIsOpen() ? 'unlocked' : 'locked'?>.png" /><?php echo $list->getTitle();?></a>
									<p><?php echo __('by')?> <a href="<?php url_for('@user_page?username='.$list->getUserProfile()->getsfGuardUser()->getUserName()) ?>" title="<?php echo $list->getUserProfile()->getName()?>" class="category"><?php echo $list->getUserProfile()->getName()?></a></p>
									<p>
									<?php foreach($list->getAllListPage(2) as $page):?>
										<?php echo link_to_company($page->getCompanyPage()->getCompany(), array('class'=>'extra'))?>,
										<?php endforeach?>
									</p>
								</li>
							<?php endforeach;?>
							</ul>
							<div class="clear"></div>
						</div>
						<a href="<?php echo url_for('profile/lists?username='. $pageuser->getUsername()) ?>"><?php echo __('see more')?></a>
					</li>
					<?php endif;?>
		</ul>
	</div>
</div>
<div id="dialog-confirm" title="<?php echo __('Delete this image?', null, 'company') ?>" style="display:none;">
        <p><?php echo __('Are you sure you want to delete this image?', null, 'company') ?></p>
</div>
<script type="text/javascript">
  /*Delete photo from user profile*/
     $('a.confirm').click(function() {
            var delelePhotoLink = $(this).attr('href');        
            $("#dialog-confirm").dialog({
                resizable: false,
                height: 250,
                width:340,
                buttons: {
                    "<?php echo __('delete', null) ?>": function() {
                       window.location.href = delelePhotoLink;
                    },
                    <?php echo __('cancel', null) ?>: function() {
                        $(this).dialog("close");
                    }
                }
            });
            $(".ui-dialog").css("z-index", "2");
            return false;
        });
     /*END Delete photo from user profile*/
</script>     