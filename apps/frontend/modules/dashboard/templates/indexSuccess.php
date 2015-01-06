<div class="container activities">
 <?php if (isset($pager) && $pager->getNbResults()>0):?> 
<?php foreach($sf_data->getRaw('pager') as $item): ?>

		<?php if($sf_user->getCulture() == 'sr' && $item->getUserProfile()->getGender() == 'f') :?>
			<?php $file = 'dashboardf'; ?>
		<?php else :?>
			<?php $file = 'dashboard'; ?>
		<?php endif; ?>
 
     <?php if($item instanceof ActivityImage): ?>
      <div class="activity">
        
        <div class="activity_content">
		         
          <?php if ($item->getPage() instanceof CompanyPage):?>
          <div class="activity_user">
          <?php echo sprintf(__('%s published a photo for %s.', null, $file),  $item->getUserProfile(),link_to_company($item->getPage()->getCompany()));?>
            </div>
          <?php elseif($item->getPage() instanceof UserPage):?>
          <div class="activity_user">
          <?php echo sprintf(__('%s changed their profile photo.', null, $file),  $item->getUserProfile());?>
           
          </div>
          <?php endif;?>
       
        </div>
      </div>
    <?php endif ?>
    
   
      <?php if($item instanceof ActivityList): ?>
      <div class="activity">
       
        <div class="activity_content">
          <div class="activity_user">
         <?php echo sprintf(__('%s created a %s.', null, $file),  $item->getUserProfile(), link_to(__('List', null, $file), 'list/show?id='.$item->getActionId()));?>
           
          </div>
       
          
          <?php //include_component('comment', 'comments', array('element' => $item, 'comments' => $item->getComment())) ?>
        </div>
      </div>
    <?php endif ?>
    
     <?php if($item instanceof ActivityComment): ?>
      <div class="activity">
        
        <div class="activity_content">
          <div class="activity_user">
          <?php if( $item->getActivity() instanceof ActivityEvent ): ?>
             <?php $val=  link_to($item->getActivity()->getEvent()->getTitle(), 'event/show?id='.$item->getActivity()->getActionId()); ?>
           <?php elseif( $item->getActivity() instanceof ActivityList ): ?>
             <?php $val=  link_to($item->getActivity()->getLists()->getTitle(), 'list/show?id='.$item->getActivity()->getActionId()); ?>
        
         <?php endif;?>  
          <?php echo sprintf(__('%s published a Comment for %s.', null, $file),  $item->getUserProfile(), $val); ?>
          
           
          </div>
          
          <?php //include_component('comment', 'comments', array('element' => $item, 'comments' => $item->getComment())) ?>
        </div>
      </div>
    <?php endif ?> 
   
      <?php if($item instanceof ActivityEvent): ?>
      <div class="activity">
        
        <div class="activity_content">
          <div class="activity_user">

          <?php echo sprintf(__('%s created an %s.', null, $file),  $item->getUserProfile(), link_to($item->getEvent()->getTitle(), 'event/show?id='.$item->getActionId())); ?>
          
          </div>
          
          <?php //include_component('comment', 'comments', array('element' => $item, 'comments' => $item->getComment())) ?>
        </div>
      </div>
    <?php endif ?>    
    
    <?php if($item instanceof ActivityReview): ?>
      <div class="activity">
      <?php if ($item->getActivity()->getId()): ?>      
        <div class="activity_content">
          <div class="activity_user">
          <?php echo sprintf(__('%s published a reply to %s\'s review.', null, $file),link_to_company($item->getPage()->getCompany()),$item->getActivity()->getUserProfile());?>
          </div>
          </div>
          <?php else:?>

        <div class="activity_content">
          <div class="activity_user">
          <?php echo sprintf(__('%s published a review for %s.', null, $file), $item->getUserProfile(),link_to_company($item->getPage()->getCompany()));?>
            
          </div>
           </div>
        
          <?php endif;?>
          
          <?php //include_component('comment', 'comments', array('element' => $item, 'comments' => $item->getComment())) ?>
       
      </div>
    <?php endif ?>
    
    <?php if($item instanceof ActivityCompanyOffer): ?>
      <div class="activity">
        
        <div class="activity_content">
          <div class="activity_user">
          <?php echo sprintf(__('%s just published a new %s.', null, $file),link_to_company($item->getPage()->getCompany()), link_to(__('Deal', null, $file), 'offer/show?id='.$item->getActionId()))?>
          </div>
          
          <?php //include_component('comment', 'comments', array('element' => $item, 'comments' => $item->getComment())) ?>
        </div>
      </div>
    <?php endif ?>
    <?php if($item instanceof ActivityPage): ?>
      <div class="activity">       
        
        <div class="activity_content">
          <div class="activity_user">
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
	<?php echo $string;?>
	<?php else:?>
	 <?php if( $item->getActivity() instanceof ActivityList ): ?>
             <?php $val=  link_to(__('List', null, $file), 'list/show?id='.$item->getActivity()->getActionId()); ?>
             <?php echo sprintf(__('%s was added to a %s.', null, $file),link_to_company($item->getPage()->getCompany()), $val); ?>
         <?php endif;?>    
	<?php endif;?>
          </div>
                  
          
          <?php //include_component('comment', 'comments', array('element' => $item, 'comments' => $item->getComment())) ?>
        </div>
      </div>
    <?php endif ?>
     <?php if($item instanceof ActivityFollowPage): ?>
     
      <div class="activity">
       
        <div class="activity_content">
          <div class="activity_user">
          <?php if($item->getPage()->getType() == PageTable::COMPANY_PAGE):?>
             <?php $followed =  link_to_company($item->getPage()->getCompany()); ?>
                 <?php elseif ($item->getPage()->getType() == PageTable::USER_PAGE):?>
             <?php $followed = $item->getPage()->getUserProfile() ?>
        <?php endif;?>
            <?php echo sprintf(__('%s is now following %s.', null, $file), $item->getUserProfile(),$followed); ?> 
           
            
          </div>
          
                  
          
          <?php //include_component('comment', 'comments', array('element' => $item, 'comments' => $item->getComment())) ?>
        </div>
      </div>
    <?php endif ?>
    <div class="clear"></div>
  <?php endforeach; ?>
      <?php endif ?>
</div>