<?php use_helper('TimeStamps');?>
<h3><?php echo __('Conversations')?></h3>
  <?php
  //get_class($page->getRawValue()); 
  ?>
  
<?php if ($page->getType() == PageTable::USER_PAGE):?>
	<a href="<?php echo url_for('userSettings/follow') ?>"><?php echo __('Follow Settings');?></a>
<?php elseif ($page->getType() == PageTable::COMPANY_PAGE):?>
    <a href="<?php echo url_for('companySettings/followers?slug='.$page->getCompany()->getSlug()) ?>"><?php echo __('All Messages');?></a>
<?php endif;?>
    
<?php if(!$pager->getNbResults())://if(!$pager->getNbResults()): ?>
	<div id="no_people" class="no_content">
		<div class="no_icon">
			<p><?php echo __('No conversations')?></p>
		</div>
	</div>
	
<?php else: ?>
	<div class="messageBox">
		<?php foreach ($pager->getResults() as $key=>$conversation): ?>
			<div class="<?php echo $key%2==0?'odd':'' ?>">
				<?php /* <input type="checkbox" name="selected[]" /> */?>
				
				<?php if(get_class($conversation->getToPage()->getRawValue()) =='UserPage'):?>
                	<?php $obj = $conversation->getToPage()->getUserProfile();
					$image=  $obj->getLink(1, ESC_RAW) ?>
                <?php else:?>
					<?php $obj =$conversation->getToPage()->getCompany();
					$image = link_to_company($obj) ?>     
                <?php endif;?>

				<div class="messageContent">
					<?php echo link_to('<img src="/images/gui/close.png" alt="X" />', 'message/delete?id='.$conversation->getId(), 'class=messageDelete confirm='.__('Do you really want to delete this converstaion?')) ?>
	                
	                <span><?php echo ezDate(date('d.m.Y H:i', strtotime($conversation->getUpdatedAt()))); ?></span>
					
                    <?php echo link_to($obj . ' ' . $image, 
                    'message/view?user='.$conversation->getToPage()->getId(),
                    'class=messageFrom') ?>

					<?php echo link_to(__('View Messages'), 'message/view?user='.$conversation->getToPage()->getId(), 'class="button_pink"') ?>
	                <p><?php echo $conversation->getMessage()->getBody() ?></p>
	                
	                <div class="clear"></div>
               	</div>

				<div class="clear"></div>
			</div>
        <?php endforeach; ?>
	</div>
<?php endif; ?>
    