<div id="search_by_category">
	<h2><?php echo __('Search in getlokal', null, 'messages')?></h2>
	<ul class="category_menu">
	  <?php foreach($sectors as $sector): ?>
	  <?php if ($county || (getlokalPartner::getInstanceDomain() == 78)): ?>
	    <li class="category_<?php echo $sector->getId() ?>"><a title="<?php echo $sector ?>" href="<?php echo url_for('@sectorCounty?slug='. $sector->getSlug(). '&county='. $sf_user->getCounty()->getSlug()) ?>" class=""><?php echo $sector ?></a></li>	    
	  <?php else: ?>
	    <li class="category_<?php echo $sector->getId() ?>"><a title="<?php echo $sector ?>" href="<?php echo url_for('@sector?slug='. $sector->getSlug(). '&city='. $sf_user->getCity()->getSlug()) ?>" class=""><?php echo $sector ?></a></li>
	  <?php endif; ?>
	  <?php endforeach ?>
	</ul>
</div>
<a title="<?php echo __('see all', null, 'messages')?>" href="javascript:void(0)" id="category_menu_colapse"><?php echo __('see all', null, 'messages')?></a>
<a title="<?php echo __('hide', null, 'messages')?>" href="javascript:void(0)" id="category_menu_colapse2"><?php echo __('hide', null, 'messages')?></a>