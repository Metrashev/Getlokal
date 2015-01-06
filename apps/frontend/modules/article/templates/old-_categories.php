<ul>
<?php foreach ($articleCategories as $articleCategory) : ?> 
	<li>
		<a href="#" id="<?php echo $articleCategory->getId()?>" class="button_x"><img src="/images/gui/btn_x.png" alt="X" /></a>
		<span class="pink"><?php echo $articleCategory->getCategory()->getTitle();?></span>
	</li>
<?php endforeach; ?>
</ul>