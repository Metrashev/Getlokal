<?php use_helper('Pagination') ?>
<div class="content_in_full">
	<div class="badge">
	  <?php echo image_tag($badge->getFile('active_image')->getUrl(), 'class=image size=75x75') ?>

	  <div class="badge_content">
	    <h3><?php echo $badge->getName() ?></h3>
	    <p><?php echo sprintf( __('Badge unlocked by <span> %s%s </span> of users'),$badge->getPercent(),'%' ) ?></p>

	    <span class="description"><?php echo $badge->getDescription() ?></span>
	  </div>
	  <div class="clear"></div>
	</div>

	<div class="badge_users">
	  <ul>
	    <?php foreach($pager->getResults() as $bu): ?>
	    <li>
	      <?php echo $bu->getUserProfile()->getLink(0, ESC_RAW) ?>
	      <?php echo $bu->getUserProfile()->getLink(ESC_RAW) ?><br/>
	      <?php echo $bu->getUserProfile()->getCity() ?>
	    </li>
	    <?php endforeach ?>
	  </ul>

	  <div class="clear"></div>
	</div>
	<div class="badges_pager_wrap">
		<?php echo pager_navigation($pager, 'badge/show?id='. $badge->getId()) ?>
	</div>
</div>