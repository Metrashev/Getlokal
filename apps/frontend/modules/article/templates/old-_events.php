<?php foreach ($articleEvents as $articleEvent): ?> 
<li>
	<a href="#" id="<?php echo $articleEvent->getId()?>" class="button_x"><img src="/images/gui/btn_x.png" alt="X" /></a>
	<span class="pink"><?php echo $articleEvent->getEvent()->getTitle();?></span>
</li>
<?php endforeach; ?>