<div class="content_in">
  <ul class="directory">    
      <?php foreach($classifications as $classification): ?>
       <?php if($classification->Translation[$sf_user->getCountry()->getSlug()]->number_of_places): ?>
       <li><?php echo link_to($classification, '@locations?slug='. $classification->getSlug(). '&sector='. $classification->getPrimarySector()->getSlug()) ?></li>
       <?php endif;?>
      <?php endforeach ?>    
  </ul>
</div>

<?php //include_partial('home/sideBar');?>
<div class="clear"></div>

<script type="text/javascript">
$(document).ready(function() {
    //$('.path_wrap').remove();
});
</script>