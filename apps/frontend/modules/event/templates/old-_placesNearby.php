<?php ?>
<div class="separator_dotted"></div>
<div class="similar_events_wrap event_item_page">
  <h2><?php echo __($similarTitle,null,'events')?></h2>
   <ul>
 <?php foreach ($companies as $company):?>
    <li>
     <?php echo link_to(image_tag($company->getThumb(0), 'size=133x100'), $company->getUri(ESC_RAW)) ?>
     <?php echo link_to($company, $company->getUri(ESC_RAW)) ?>
     <div class="place_rateing">
             <div class="rateing_stars">
              <div style="width: <?php echo $company->getRating() ?>%;" class="rateing_stars_orange"></div>
             </div>
          <?php echo format_number_choice('[0]No reviews|[1]1 review|(1,+Inf]%count% reviews', array('%count%' => $company->getNumberOfReviews()), $company->getNumberOfReviews(),'user'); ?>
   </div>
    </li>
<?php endforeach;?>

   </ul>
   <div class="clear"></div>
  </div>