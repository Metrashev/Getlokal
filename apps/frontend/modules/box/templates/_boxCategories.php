<?php 
$HARDCODED_CATEGORY_ICONS = array(
	1 => "icon-car",
	2 => "icon-hairstyle",
	3 => "icon-tools",
	4 => "icon-school",
	5 => "icon-cinema",
	6 => "icon-coffee",
	7 => "icon-drink",
	8 => "icon-food",
	9 => "icon-book-open",
	10 => "icon-smile",
	11 => "icon-home",
	12 => "icon-plus-circled",
	13 => "icon-house",
	14 => "icon-pin-star",
	15 => "icon-pin",
	16 => "icon-credit-card",
	17 => "icon-pallete",
	18 => "icon-music",
	19 => "icon-th",
	20 => "icon-tree",
	21 => "icon-pet",
	22 => "icon-briefcase",
	23 => "icon-phone",
	24 => "icon-basket",
	25 => "icon-cardio",
	26 => "icon-wheel",
	27 => "icon-hotels",
);
if($show_full_list){
	$class = " full-height";
}else{
	$class = "";
}

$selected_sector_id = !empty($selected_sector) ? $selected_sector->getId() : false;
$selected_classification_id = !empty($selected_classification) ? $selected_classification->getId() : false;

?>
<div class="section-categories<?=$class?>">
	<div class="categories-title">
		<?php echo __('Categories'); ?>
	</div><!-- categories-title -->

	<ul class="categories-list">
		<?php if($selected_sector_id):
			if ($county || (getlokalPartner::getInstanceDomain() == 78)):
				$href = url_for('@sectorCounty?slug='. $selected_sector->getSlug(). '&county='. $sf_user->getCounty()->getSlug());
			else:
				$href = url_for('@sector?slug='. $selected_sector->getSlug(). '&city='. $sf_user->getCity()->getSlug());
			endif;
		?>
			<li class="<?=$HARDCODED_CATEGORY_ICONS[$selected_sector->getId()]?> selected">
				<div class="marker"></div>
				<a title="<?php echo $selected_sector ?>" href="<?=$href?>" class=""><span class="icon"></span><span class="txt"><?php echo $selected_sector ?></span></a>
			</li>
			<div class="category-dropdown">
	            <ul>
	            	<?php foreach($classifications as $c):
	            		if (/*isset($county) &&*/ $county):
	            	      $href= url_for('@classificationCounty?slug='. $c->getSlug(). '&sector='. $c->getPrimarySector()->getSlug(). '&county='. $sf_user->getCounty()->getSlug(),true);
	            	  	else:
	            	      $href= url_for('@classification?slug='. $c->getSlug(). '&sector='. $c->getPrimarySector()->getSlug(). '&city='. $sf_user->getCity()->getSlug(),true);
	            	  	endif;
	            	?>
	                <li class="<?php echo $c->getId() == $selected_classification_id ? "selected" : ""?>">
	                	<a href="<?php echo $href?>"><?php if($c->getId() == $selected_classification_id ):?><i class="ico-category"></i><?php endif;?><?php echo $c->getTitle();?></a>
	                </li>
	                <?php endforeach;?>
	            </ul>
	        </div>
		<?php endif;?>
		<?php foreach($sectors as $sector):
			if($sector->getId() == $selected_sector_id) continue;
			if ($county || (getlokalPartner::getInstanceDomain() == 78)):
				$href = url_for('@sectorCounty?slug='. $sector->getSlug(). '&county='. $sf_user->getCounty()->getSlug());
			else:
				$href = url_for('@sector?slug='. $sector->getSlug(). '&city='. $sf_user->getCity()->getSlug());
			endif;
		?>
			<li class="<?=$HARDCODED_CATEGORY_ICONS[$sector->getId()]?>">
				<div class="marker"></div>
				<a title="<?php echo $sector ?>" href="<?=$href?>" class=""><span class="icon"></span><span class="txt"><?php echo $sector ?></span></a>
			</li>
			
		<?php endforeach ?>
	</ul><!-- categories-list --> 
	
	<div class="scroll-top">
		<a href="javascript:void(0)">
			<i class="fa fa-angle-double-up fa-2x"></i><p><?php echo __('Scroll to top'); ?></p><i class="fa fa-angle-double-up fa-2x"></i>
		</a>
	</div>

	<div class="see-more">
		<a href="javascript:void(0)">
			<i class="fa fa-angle-double-down fa-2x"></i><p><?php echo __('Scroll to bottom'); ?></p><i class="fa fa-angle-double-down fa-2x"></i>
		</a>
	</div>
</div>