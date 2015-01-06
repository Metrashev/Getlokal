<?php
	$domain = getlokalPartner::getInstanceDomain();
	$lang = $sf_user->getCulture();
	if($lang != "en"): slot('canonical') ?>
    	<link rel="canonical" href="<?php echo url_for('@static_page?sf_culture=en&slug='.$slug,true); ?>">
	<?php end_slot(); endif; ?> 
	
<li <?=($slug == $page->getSlug() || $static_page->getParent()->getId() == $page->getId()) ? 'class="selected" ' : ''?>>
	<div class="marker"></div>
    <?=link_to($page->getTitle(), '@static_page?slug=' . $page->getSlug()); ?>    
</li>
<?php if ( $page->getNode()->hasChildren() && ($slug == $page->getSlug() || $static_page->getParent()->getId() == $page->getId() ) ){ ?>
    <div class="category-dropdown">
        <ul>
        <?php 
        	foreach ($page->getNode()->getChildren() as $subpage){

        		include_partial('page', array('page' => $subpage, 'static_page' => $static_page));
			} 
		?>
        </ul>
    </div>
<?php } ?>
