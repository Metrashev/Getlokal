<?php if (count($lists)):?>
<h3><?php echo __('Lists') ?></h3>
					<div class="list_scroll">
				        <div class="scrollbar"><div class="track"><div class="thumb"></div></div></div>
				        <div class="viewport">
							<ul class="overview">
								<?php foreach ($lists as $list):?>
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
										endif; ?>
									</a>
									
									<a href="<?php echo url_for("list/show?id=".$list->getId())?>" title="<?php echo $list->getTitle();?>"><?php echo $list->getTitle();?></a>
									<p><?php echo __('by')?> <a href="<?php url_for('@user_page?username='.$list->getUserProfile()->getsfGuardUser()->getUserName()) ?>" title="<?php echo $list->getUserProfile()->getName()?>" class="category"><?php echo $list->getUserProfile()->getName()?></a></p>
									
									<img alt="<?php echo $list->getIsOpen() ? 'unlocked' : 'locked'?>" title="<?php echo __($list->getIsOpen() ? 'Open' : 'Closed')?>" src="/images/gui/<?php echo $list->getIsOpen() ? 'unlocked' : 'locked'?>.png" />
									
								</li>
								<?php endforeach;?>							
							</ul>
						</div>
					</div>
<?php endif;?>
<script type="text/javascript">
$(document).ready(function() {
if ($('.list_scroll .viewport ul li').length > 3) {
  $('.list_scroll').tinyscrollbar();
 }
 else {
  $('.list_scroll .viewport').css('height', $('.list_scroll .viewport ul').outerHeight());
  $('.list_scroll .viewport ul li').css('width', '245px');
  $('.list_scroll .scrollbar').remove();
 }
});
</script>