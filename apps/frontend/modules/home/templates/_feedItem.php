<?php 
	$profile = $item->getUserProfile();
	$activity = $sf_data->getRaw('item');
	$className = get_class($activity);
	switch ($activity){
		case '' : $action = ""; break;
	}
?>  
<li class="testimonial">
	<div class="testimonial-image alignleft">
		<a href="#">
			<!-- <img src="<?php //echo myTools::getImageSRC($profile->getThumb(1), 'user') ?>" alt=""> -->
		</a>
	</div>

	<div class="testimonial-content alignleft">
		<p>
			<?php if($sf_user->getCulture() == 'sr' && $profile->getGender() == 'f') :?>
				<?php $file = 'dashboardf'; ?>
			<?php else :?>
				<?php $file = 'dashboard'; ?>
			<?php endif; ?>
 <?php if($activity instanceof ActivityImage): ?>
		     <?php if ($activity->getPage() && $activity->getPage()->getType() == PageTable::COMPANY_PAGE):?>
               <div>
				 <p><?php echo sprintf(__('%s published a photo for %s.', null, $file),  link_to_public_profile($profile, array('class'=>'user')), link_to_company($activity->getPage()->getCompany()));?></p>
				 <div class="clear"></div>
               </div>
		     <?php else:?>
               <div>
				 <p><?php echo sprintf(__('%s changed their profile photo.', null, $file),  link_to_public_profile($profile, array('class'=>'user')));?></p>
				 <div class="clear"></div>
               </div>          
		     <?php endif;?>
		   <?php endif ?>
		   <?php if($activity instanceof ActivityList): ?>
             <div>
			   <p><?php echo sprintf(__('%s created a %s.', null, $file),  link_to_public_profile($profile, array('class'=>'user')), link_to(__('List', null, $file), 'list/show?id='.$activity->getActionId()));?></p>
			   <div class="clear"></div>
             </div>  
		   <?php endif ?>		 
		   <?php if($activity instanceof ActivityComment): ?>
		     <?php if( $activity->getActivity() instanceof ActivityEvent ): ?>
               <?php $val=  link_to($activity->getActivity()->getEvent()->getTitle(), 'event/show?id='.$activity->getActivity()->getActionId()); ?>
		     <?php elseif( $activity->getActivity() instanceof ActivityList ): ?>
               <?php $val=  link_to($activity->getActivity()->getLists()->getTitle(), 'list/show?id='.$activity->getActivity()->getActionId()); ?>
		     <?php endif;?> 
             <div>
			   <p><?php echo sprintf(__('%s published a Comment for %s.', null, $file),  link_to_public_profile($profile, array('class'=>'user')), $val); ?></p>
			   <div class="clear"></div>
             </div>               
		   <?php endif ?> 
		   <?php if($activity instanceof ActivityEvent): ?>
             <div>
			   <p><?php echo sprintf(__('%s created an %s.', null, $file), link_to_public_profile($profile, array('class'=>'user')), link_to($activity->getEvent()->getTitle(), 'event/show?id='.$activity->getActionId())); ?></p>
			   <div class="clear"></div>
             </div>
		   <?php endif ?> 
		   <?php if($activity instanceof ActivityReview): ?>
		     <?php if ($activity->getActivity()->getId()): ?>
               <div>
			     <p><?php echo sprintf(__('%s published a reply to %s\'s review.', null, $file),link_to_company($activity->getPage()->getCompany()),link_to_public_profile($activity->getActivity()->getUserProfile(), array('class'=>'user')));?></p>
			     <div class="clear"></div>
               </div>
		     <?php else:?>
               <div>
			     <p><?php echo sprintf(__('%s published a review for %s.', null, $file), link_to_public_profile($profile, array('class'=>'user')), link_to_company($activity->getPage()->getCompany()));?></p>
			     <div class="clear"></div>
               </div>
		     <?php endif;?>
		   <?php endif ?>
		   <?php if($activity instanceof ActivityCompanyOffer): ?>
             <div>
			   <p><?php echo sprintf(__('%s just published a new %s.', null, $file),link_to_company($activity->getPage()->getCompany()), link_to(__('Deal', null, $file), 'offer/show?id='.$activity->getActionId()))?></p>
			   <div class="clear"></div>
             </div>
		   <?php endif ?>
		   <?php if($activity instanceof ActivityPage): ?>
		     <?php if ($activity->getModifiedField()):?>
		       <?php if (substr_count( $activity->getModifiedField(),',') ==  0):?>
		         <?php switch ($activity->getModifiedField()):
				    case 'description':
				    case 'description_en':
				    case 'content':
					$string = sprintf(__('%s updated their place description.', null, $file),link_to_company($activity->getPage()->getCompany()));
					break; 
					case 'title':
					case 'title_en':
					$string = sprintf(__('%s just changed their name.', null, $file),link_to_company($activity->getPage()->getCompany()));
					break;	
					case 'phone':
					case 'phone1':
					case 'phone2':
					$string = sprintf(__('%s just changed their phone number.', null, $file),link_to_company($activity->getPage()->getCompany()));
					break;
					case 'email':
					$string = sprintf(__('%s just changed their email address.', null, $file),link_to_company($activity->getPage()->getCompany()));
					break;
					case 'website_url':
					$string = sprintf(__('%s just changed their website.', null, $file),link_to_company($activity->getPage()->getCompany()));
					break;
					case 'googleplus_url':
					$string = sprintf(__('%s just changed their Google+ page.', null, $file),link_to_company($activity->getPage()->getCompany()));
					break;
					case 'facebook_url':
					$string = sprintf(__('%s just changed their Facebook page.', null, $file),link_to_company($activity->getPage()->getCompany()));
					break;
					case 'twitter_url':
					$string = sprintf(__('%s just changed their Twitter.', null, $file),link_to_company($activity->getPage()->getCompany()));
					break;	
					case 'w_hours':
					$string = sprintf(__('%s just changed their working hours.', null, $file),link_to_company($activity->getPage()->getCompany()));
					break;
					case 'location':
					case 'city_id':
					$string = sprintf(__('%s just changed their address.', null, $file),link_to_company($activity->getPage()->getCompany()));
					break;
		         endswitch;?>
		       <?php else:?>	
		         <?php $string = sprintf(__('%s just updated their profile info.', null, $file),link_to_company($activity->getPage()->getCompany()));?>
		       <?php endif;?>
		       <div>
			     <p><?php echo $string;?></p>
			     <div class="clear"></div>
		       </div>	
		     <?php else:?>
		       <?php if( $activity->getActivity() instanceof ActivityList ): ?>
                 <?php $val = link_to(__('List', null, $file), 'list/show?id='.$activity->getActivity()->getActionId()); ?>
                   <div>
                 <p><?php echo sprintf(__('%s was added to a %s.', null, $file),link_to_company($activity->getPage()->getCompany()), $val); ?></p>
                 <div class="clear"></div>
                 </div>             
		       <?php endif;?>    
		     <?php endif;?>
		   <?php endif ?>
		   <?php if($activity instanceof ActivityFollowPage): ?>
		     <?php if($activity->getPage()->getType() == PageTable::COMPANY_PAGE):?>
               <?php $followed =  link_to_company($activity->getPage()->getCompany()); ?>
             <?php elseif ($activity->getPage()->getType() == PageTable::USER_PAGE):?>
               <?php $followed = link_to_public_profile($activity->getPage()->getUserProfile(), array('class'=>'user')) ?>
		     <?php endif;?>
		       <div>
			     <p><?php echo sprintf(__('%s is now following %s.', null, $file), link_to_public_profile($profile, array('class'=>'user')),$followed); ?></p>
			     <div class="clear"></div>
		       </div>              
		   <?php endif ?>
		</p>
		<small>
			<strong><?php echo ezDate(date('d.m.Y H:i', strtotime( $item->getUpdatedAt() ))); ?></strong>
		</small>
	</div>
</li>


