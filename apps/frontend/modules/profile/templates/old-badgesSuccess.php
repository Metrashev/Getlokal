<?php slot('description') ?>
<?php echo sprintf(__('See information for %s and all their reviews in getlokal!', null, 'pagetitle'),  $pageuser->getName());?> 
  <?php end_slot() ?>

<?php //include_javascripts('review.js') ?>
<?php include_partial('review/reviewJs');?>
<?php use_stylesheet('jquery.rating.css');?>
<?php if (count($badges)):?>
<div class="content_in_full">
  <ul class="badges">
    <?php foreach($badges as $badge): ?>
      <li>
        <?php echo link_to(image_tag($badge->getFile('active_image')->getUrl(), array('alt' => $badge->getName()), 'class=image size=75x75'), 'badge/show?id='. $badge->getId()) ?>

        <div class="badge_content">
          <h3><?php echo $badge->getName() ?></h3>
          <p><?php echo sprintf( __('Badge unlocked by <span> %s%s </span> of users'),$badge->getPercent(),'%' ) ?></p>

          <span class="description"><?php echo $badge->getDescription() ?></span>

          <div class="tooltip_body"><?php echo $badge->getLongDescription() ?></div>
        </div>
        <div class="clear"></div>
      </li>
    <?php endforeach ?>
  </ul>
<div class="clear"></div>
</div>
<?php endif;?>
<div class="clear"></div>
<script type="text/javascript">
  $(document).ready(function() {
     

      $('.banner').css('display', 'none');
      $('a.lightbox').fancybox({
  	    titlePosition: 'over',
  	    cyclic:        true
  	  });
  	  
  	  $('a.iframe').each(function(i,s) {
  	    $(s).fancybox({
  	      type  : 'iframe',
  	        width : 800,
  	        height: 600,
  	        href  : $(s).attr('href')+ '?modal=1'
  	    })
  	  });
  }) 
</script>