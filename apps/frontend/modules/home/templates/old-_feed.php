<?php use_helper('Pagination');?>
<?php if (isset($pager) && $pager->getNbResults()>0): ?> 
	<div class="pink_dropdown">
		<div class="pink_dropdown_content">
		 <?php foreach($sf_data->getRaw('pager') as $item): ?>
		   <?php $profile = $item->getUserProfile();?>  
		   
		   	<?php if($sf_user->getCulture() == 'sr' && $profile->getGender() == 'f') :?>
				<?php $file = 'dashboardf'; ?>
			<?php else :?>
				<?php $file = 'dashboard'; ?>
			<?php endif; ?>
		    
		   <?php if($item instanceof ActivityImage): ?>
		     <?php if ($item->getPage() && $item->getPage()->getType() == PageTable::COMPANY_PAGE):?>
               <div>
			     <?php echo link_to(image_tag($profile->getThumb(1)), '@user_page?username='.$profile->getSfGuardUser()->getUsername(), array('title'=> $profile));?>
				 <p><?php echo sprintf(__('%s published a photo for %s.', null, $file),  link_to_public_profile($profile, array('class'=>'user')), link_to_company($item->getPage()->getCompany()));?></p>
				 <div class="clear"></div>
               </div>
		     <?php else:?>
               <div>
			     <?php echo link_to(image_tag($profile->getThumb(1)), '@user_page?username='.$profile->getSfGuardUser()->getUsername(), array('title'=> $profile));?>
				 <p><?php echo sprintf(__('%s changed their profile photo.', null, $file),  link_to_public_profile($profile, array('class'=>'user')));?></p>
				 <div class="clear"></div>
               </div>          
		     <?php endif;?>
		   <?php endif ?>
		   <?php if($item instanceof ActivityList): ?>
             <div>
			   <?php echo link_to(image_tag($profile->getThumb(1)), '@user_page?username='.$profile->getSfGuardUser()->getUsername(), array('title'=> $profile));?>
			   <p><?php echo sprintf(__('%s created a %s.', null, $file),  link_to_public_profile($profile, array('class'=>'user')), link_to(__('List', null, $file), 'list/show?id='.$item->getActionId()));?></p>
			   <div class="clear"></div>
             </div>  
		   <?php endif ?>		 
		   <?php if($item instanceof ActivityComment): ?>
		     <?php if( $item->getActivity() instanceof ActivityEvent ): ?>
               <?php $val=  link_to($item->getActivity()->getEvent()->getTitle(), 'event/show?id='.$item->getActivity()->getActionId()); ?>
		     <?php elseif( $item->getActivity() instanceof ActivityList ): ?>
               <?php $val=  link_to($item->getActivity()->getLists()->getTitle(), 'list/show?id='.$item->getActivity()->getActionId()); ?>
		     <?php endif;?> 
             <div>
			   <?php echo link_to(image_tag($profile->getThumb(1)), '@user_page?username='.$profile->getSfGuardUser()->getUsername(), array('title'=> $profile));?>
			   <p><?php echo sprintf(__('%s published a Comment for %s.', null, $file),  link_to_public_profile($profile, array('class'=>'user')), $val); ?></p>
			   <div class="clear"></div>
             </div>               
		   <?php endif ?> 
		   <?php if($item instanceof ActivityEvent): ?>
             <div>
			   <?php echo link_to(image_tag($profile->getThumb(1)), '@user_page?username='.$profile->getSfGuardUser()->getUsername(), array('title'=> $profile));?>
			   <p><?php echo sprintf(__('%s created an %s.', null, $file), link_to_public_profile($profile, array('class'=>'user')), link_to($item->getEvent()->getTitle(), 'event/show?id='.$item->getActionId())); ?></p>
			   <div class="clear"></div>
             </div>
		   <?php endif ?> 
		   <?php if($item instanceof ActivityReview): ?>
		     <?php if ($item->getActivity()->getId()): ?>
               <div>
			     <?php echo image_tag($item->getPage()->getCompany()->getThumb(1)) ?>
			     <p><?php echo sprintf(__('%s published a reply to %s\'s review.', null, $file),link_to_company($item->getPage()->getCompany()),link_to_public_profile($item->getActivity()->getUserProfile(), array('class'=>'user')));?></p>
			     <div class="clear"></div>
               </div>
		     <?php else:?>
               <div>
			     <?php echo link_to(image_tag($profile->getThumb(1)), '@user_page?username='.$profile->getSfGuardUser()->getUsername(), array('title'=> $profile));?>
			     <p><?php echo sprintf(__('%s published a review for %s.', null, $file), link_to_public_profile($profile, array('class'=>'user')), link_to_company($item->getPage()->getCompany()));?></p>
			     <div class="clear"></div>
               </div>
		     <?php endif;?>
		   <?php endif ?>
		   <?php if($item instanceof ActivityCompanyOffer): ?>
             <div>
			   <?php echo image_tag($item->getPage()->getCompany()->getThumb(1)) ?>
			   <p><?php echo sprintf(__('%s just published a new %s.', null, $file),link_to_company($item->getPage()->getCompany()), link_to(__('Deal', null, $file), 'offer/show?id='.$item->getActionId()))?></p>
			   <div class="clear"></div>
             </div>
		   <?php endif ?>
		   <?php if($item instanceof ActivityPage): ?>
		     <?php if ($item->getModifiedField()):?>
		       <?php if (substr_count( $item->getModifiedField(),',') ==  0):?>
		         <?php switch ($item->getModifiedField()):
				    case 'description':
				    case 'description_en':
				    case 'content':
					$string = sprintf(__('%s updated their place description.', null, $file),link_to_company($item->getPage()->getCompany()));
					break; 
					case 'title':
					case 'title_en':
					$string = sprintf(__('%s just changed their name.', null, $file),link_to_company($item->getPage()->getCompany()));
					break;	
					case 'phone':
					case 'phone1':
					case 'phone2':
					$string = sprintf(__('%s just changed their phone number.', null, $file),link_to_company($item->getPage()->getCompany()));
					break;
					case 'email':
					$string = sprintf(__('%s just changed their email address.', null, $file),link_to_company($item->getPage()->getCompany()));
					break;
					case 'website_url':
					$string = sprintf(__('%s just changed their website.', null, $file),link_to_company($item->getPage()->getCompany()));
					break;
					case 'googleplus_url':
					$string = sprintf(__('%s just changed their Google+ page.', null, $file),link_to_company($item->getPage()->getCompany()));
					break;
					case 'facebook_url':
					$string = sprintf(__('%s just changed their Facebook page.', null, $file),link_to_company($item->getPage()->getCompany()));
					break;
					case 'twitter_url':
					$string = sprintf(__('%s just changed their Twitter.', null, $file),link_to_company($item->getPage()->getCompany()));
					break;	
					case 'w_hours':
					$string = sprintf(__('%s just changed their working hours.', null, $file),link_to_company($item->getPage()->getCompany()));
					break;
					case 'location':
					case 'city_id':
					$string = sprintf(__('%s just changed their address.', null, $file),link_to_company($item->getPage()->getCompany()));
					break;
		         endswitch;?>
		       <?php else:?>	
		         <?php $string = sprintf(__('%s just updated their profile info.', null, $file),link_to_company($item->getPage()->getCompany()));?>
		       <?php endif;?>
		       <div>
			     <?php echo link_to(image_tag($item->getPage()->getCompany()->getThumb(1)),$item->getPage()->getCompany()->getUri(ESC_RAW)) ?>
			     <p><?php echo $string;?></p>
			     <div class="clear"></div>
		       </div>	
		     <?php else:?>
		       <?php if( $item->getActivity() instanceof ActivityList ): ?>
                 <?php $val = link_to(__('List', null, $file), 'list/show?id='.$item->getActivity()->getActionId()); ?>
                   <div>
                 <?php echo link_to(image_tag($item->getPage()->getCompany()->getThumb(1)),$item->getPage()->getCompany()->getUri(ESC_RAW)) ?>
                 <p><?php echo sprintf(__('%s was added to a %s.', null, $file),link_to_company($item->getPage()->getCompany()), $val); ?></p>
                 <div class="clear"></div>
                 </div>             
		       <?php endif;?>    
		     <?php endif;?>
		   <?php endif ?>
		   <?php if($item instanceof ActivityFollowPage): ?>
		     <?php if($item->getPage()->getType() == PageTable::COMPANY_PAGE):?>
               <?php $followed =  link_to_company($item->getPage()->getCompany()); ?>
             <?php elseif ($item->getPage()->getType() == PageTable::USER_PAGE):?>
               <?php $followed = link_to_public_profile($item->getPage()->getUserProfile(), array('class'=>'user')) ?>
		     <?php endif;?>
		       <div>
			     <?php echo link_to(image_tag($profile->getThumb(1)), '@user_page?username='.$profile->getSfGuardUser()->getUsername(), array('title'=> $profile));?>
			     <p><?php echo sprintf(__('%s is now following %s.', null, $file), link_to_public_profile($profile, array('class'=>'user')),$followed); ?></p>
			     <div class="clear"></div>
		       </div>              
		   <?php endif ?>
		  <?php endforeach;?>
		  <div id="feed_pager">
            <?php  echo pager_navigation($pager, 'dashboard/index' ); ?>	
		  </div>
		</div>
		<p><?php echo __('Latest News')?></p>
	</div>
	<script type="text/javascript">
	$(document).ready(function() {
		$('.follow_feed .pink_dropdown_content div').each(function() {
			$(this).children('p').css('paddingTop', ((45 - $(this).children('p').outerHeight()) / 2));
		});
		$('.follow_feed .pink_dropdown_content').hide();

		var animated = false;
		$('.follow_feed .pink_dropdown').click(function(e) {
			if (!animated) {
				animated = true;
				if ($(e.target).closest('.follow_feed .pink_dropdown_content').length == 0) {
					if ($('.follow_feed .pink_dropdown_content').css('display') == 'none') {
						$('.follow_feed').css('width', '435px');
						$('.follow_feed .pink_dropdown > p').css('background-image', 'url(/images/gui/arrow_up_on.png)');
					}
					$('.follow_feed .pink_dropdown_content').slideToggle('fast', function() {
						if ($('.follow_feed .pink_dropdown_content').css('display') == 'none') {
							$('.follow_feed').css('width', 'auto');
							$('.follow_feed .pink_dropdown > p').css('background-image', 'url(/images/gui/arrow_up.png)');
							
						}
						animated = false;
					});
			    }
			}
		});

		var loading = false;
		
		$('#feed_pager a').live('click',function() {
			if (!loading) {
				loading = true;
				$.ajax({
					url: this.href,
					beforeSend: function( ) {
						$('.follow_feed .pink_dropdown_content').html('loading...');
					  },
					success: function( data ) {
						 $('.follow_feed').html(data);
						 $('.follow_feed .pink_dropdown_content').show();
						 $('.follow_feed .pink_dropdown > p').css('background-image', 'url(/images/gui/arrow_up_on.png)');
						 loading = false;
					}
				});
			}
			return false;
		  });
	});
	</script>	
<?php endif;?>