<?php use_helper('Date','Frontend');?>
<?php //$pages= $list->getListPage();?>
<?php $pages = $list->getAllListPage()?>
<div class="listing_content">
	<a href="<?php echo url_for("list/show?id=".$list->getId())?>" title="<?php echo $list->getTitle();?>">
		<?php if ($list->getImageId()):
			echo image_tag($list->getThumb(0),array('size'=>'119x119', 'alt'=>$list->getTitle() ));
		elseif (count($pages)):
			
			foreach ($pages as $kay => $company):
				if ($company->getCompanyPage()->getCompany()->getImageId() || $kay==count($pages)-1):
					echo image_tag($company->getCompanyPage()->getCompany()->getThumb(0),array('size'=>'119x119', 'alt'=> $list->getTitle() ));
					break;
				endif;
			endforeach;
		endif; ?>
	</a>
	<h2>
		<img alt="<?php echo $list->getIsOpen() ? 'unlocked' : 'locked'?>" title="<?php echo __($list->getIsOpen() ? 'Open' : 'Closed')?>" src="/images/gui/<?php echo $list->getIsOpen() ? 'unlocked' : 'locked'?>.png" />
		<?php /* ?>
		<img title="<?php echo __($list->getIsOpen() ? 'Open' : 'Closed')?>" src="/images/gui/warning.png" />
		*/ ?>
		<a href="<?php echo url_for("list/show?id=".$list->getId())?>" title="<?php echo $list->getTitle();?>">
			<?php echo $list->getTitle();?>
		</a>
	</h2>
	<span><?php echo __('by').' '.'<span class="user">'.$list->getUserProfile()->getLink(ESC_RAW).'</span>';?></span>
	<p><?php echo truncate_text(html_entity_decode ($list->getDescription()), 230, '...', true) ?></p>
	<?php /* <a href="<?php echo url_for("list/show?id=".$list->getId())?>" title="" >see full description</a> */ ?>
	<?php /* <span>24 places in this list</span> */ ?>
	
	<div class="review_content">
		<h3>  
			<?php if(isset($show_user) && $show_user):?>
				<?php echo __('by'); ?>  
				<span class="user"><?php echo $list->getUserProfile()->getLink(ESC_RAW); ?></span>
			<?php else:?>
			<?php 
			     if (count($pages)): 
			     	$last=count($pages)-1; //echo count($pages);
			     	foreach ($pages as $kay=>$page):
			     		echo link_to($page->getCompanyPage()->getCompany()->getCompanyTitle(), $page->getCompanyPage()->getCompany()->getUri(ESC_RAW), array('title' => $page->getCompanyPage()->getCompany()->getCompanyTitle()));
			     		if ($kay==2 && $kay!=$last): ?>
			     		<span><?php echo format_number_choice('[0]No places were added|[1]and one more place|(1,+Inf]and %count% more places', array('%count%' => $last-$kay), $last-$kay,'list'); ?></span>
			     		<?php 
			     			break;
			     		endif;
			    		if ($kay!=$last): echo ', '; endif;
			     	endforeach;
			     endif;?>
			<?php endif;?>  
		</h3>
	</div>
	<?php /**/?>
	<div class="review_interaction">
		<?php if ($sf_user->getGuardUser() && $sf_user->getGuardUser()->getId()==$list->getUserId()):?>
		<a class="list_edit" href="<?php echo url_for('list/edit?id='.$list->getId() )?>" ><?php echo __('edit')?></a>
		<a class="list_delete" href="<?php echo url_for('profile/deleteList?list_id='.$list->getId() )?>"><?php echo __('delete')?></a>
		<?php endif;?>
		<?php if(!$sf_user->getGuardUser() || ($sf_user->getGuardUser()->getId()!=$list->getUserId()) ): ?> 
		<a id="<?php echo $list->getId()?>" href="javascript:void(0);" data="<?php echo url_for('report/list?id='.$list->getId()) ?>" class="report"><?php echo __('report')?></a> 
		<?php endif ?>
	</div>
	<div class="ajax"></div>
	<?php /**/?>
	<?php /* <a href="<?php echo url_for("list/show?id=".$list->getId())?>" title="">see full list</a><br/> */ ?>
<div class="clear"></div>
</div>
