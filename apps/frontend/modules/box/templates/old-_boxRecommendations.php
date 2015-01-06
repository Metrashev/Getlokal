<?php
function substr_unicode($str, $s, $l = null) {
    return join("", array_slice(
        preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY), $s, $l));
}
?>
<?php if(!$sf_request->isXmlHttpRequest()): ?>
<div class="listing_tabs_wrap">
  <div class="listing_tabs_top recommendations">
    <?php foreach($categories as $item): ?>
      <a title="<?php echo $item ?>" href="<?php echo $sf_request->getUri() ?>?recommend_id=<?php echo $item->getId() ?>" class="<?php echo $item->getId() == $category->getId()?'current': '' ?>" rel="<?php echo $item->getId() ?>"><?php echo $item ?></a>
      <?php endforeach ?>
  </div>

  <div class="listing_tabs_content">
<?php endif ?>
    <div class="listing_tabs_bar">
      <div class="tab_clear"></div>
      <?php if ($sf_request->getParameter('county',false)): ?>
        <span><?php echo __('See more in',null,'messages')?> <a title="<?php echo $category->getTitle() ?>" href="<?php echo url_for('@sectorCounty?county='. $sf_user->getCounty()->getSlug(). '&slug='. $category->getSlug()) ?>"><?php echo $category->getTitle() ?></a></span>
      <?php else: ?>
        <span><?php echo __('See more in',null,'messages')?> <a title="<?php echo $category->getTitle() ?>" href="<?php echo url_for('@sector?city='. $sf_user->getCity()->getSlug(). '&slug='. $category->getSlug()) ?>"><?php echo $category->getTitle() ?></a></span>
	  <?php endif; ?>
    </div>

    <div class="hp_tabs_holder">
      <?php if ( ($sf_user->getCulture()=='bg' ) && (substr($sf_user->getCity()->getLocation(),0,2 )=='В' || substr($sf_user->getCity()->getLocation(),0,2 )=='Ф' ) ):?>
      	<h2><?php echo __('Top Places in %city%', array('%city%' => $sf_user->getCity()->getDisplayCity()), 'exception') ?></h2>
      <?php else:?>
          <?php if ($sf_request->getParameter('county',false)): ?>
	        <h2><?php echo __('Top Places in %city%', array('%city%' => $sf_user->getCounty()->getLocation())) ?></h2>	    
	      <?php else: ?>
	        <h2><?php echo __('Top Places in %city%', array('%city%' => $sf_user->getCity()->getDisplayCity())) ?></h2>
	      <?php endif; ?>      	
      <?php endif;?>
        
      <ul class="hp_tabs_in_holder">

        <?php foreach($top_places as $i => $place): ?>
          <li class="short">
            <?php echo link_to(image_tag($place->getThumb(1), 'size=45x45 alt='.$place->getCompanyTitle()), $place->getUri(ESC_RAW), array('title' => $place->getCompanyTitle())) ?>
            <?php // echo link_to($place->getCompanyTitle(), $place->getUri(ESC_RAW), array('title' => $place->getCompanyTitle())) ?>
            <a itemprop="company-name" title="<?php echo $place->getCompanyTitle();?>" href="<?php echo url_for($place->getUri(ESC_RAW));?>"><?php echo substr_unicode($place->getCompanyTitle(), 0, 32) ?><?php echo (mb_strlen($place->getCompanyTitle(), 'UTF-8') > 32 ? '...' : '') ;?></a>
            <div class="review_rateing">
              <div class="rateing_stars">
                <div style="width: <?php echo $place->getRating() ?>%;" class="rateing_stars_orange"></div>
              </div>
              <span class="top-reviews"><?php echo format_number_choice('[0]0 reviews|[1]1 review|(1,+Inf]%count% reviews', array('%count%' => $place->getNumberOfReviews()), $place->getNumberOfReviews()); ?></span>
            </div>
          </li>
              
       <?php if($i == 11): ?>
      </ul>
        
      <ul class="hp_tabs_in_holder">
          <?php endif ?>
          <?php endforeach ?>

      </ul>

      <?php if($review): ?>
        <div class="hp_tabs_in_holder" style="margin-right: 0;">
          <div class="hp_review">
            <h3><?php echo link_to($review->getCompany()->getCompanyTitle(), $review->getCompany()->getUri(ESC_RAW), array('title' => $review->getCompany()->getCompanyTitle())) ?></h3>
            <div class="review_rateing">
              <div class="rateing_stars">
                <div class="rateing_stars_orange" style="width: <?php echo $review->getRatingProc() ?>%;"></div>
              </div>
              <span><?php echo format_number_choice('[0]0 reviews|[1]1 review|(1,+Inf]%count% reviews', array('%count%' => $review->getCompany()->getNumberOfReviews()), $review->getCompany()->getNumberOfReviews()); ?></span>
            </div>
            
            <a title="<?php echo $review->getCompany()->getClassification() ?>" href="<?php echo url_for($review->getCompany()->getClassificationUri(ESC_RAW)) ?>" class="category"><?php echo $review->getCompany()->getClassification() ?></a>

            <p><?php echo truncate_text($review->getText(), 100, '...', true);?></p>
            
            <div class="user_info">
              <?php echo $review->getUserProfile()->getLink(1, 'size=45x45', 'class=image', ESC_RAW) ?>
              
              <h3><?php echo $review->getUserProfile()->getLink(ESC_RAW) ?></h3>
              
              <?php // echo $review->getUserProfile()->getCity()->getLocation() ?>
            </div>

            
            <div class="clear"></div>
          </div>
        </div>
        <?php endif ?>

      <div class="clear"></div>
    </div>
    
<?php if(!$sf_request->isXmlHttpRequest()): ?>
  </div>
  

</div>

<script type="text/javascript">

  $(document).ready(function() {
        function topPlacesShuffle(){
            
        
            $('ul.hp_tabs_in_holder').each(function(){
                $(this).find('.short').shuffle();
            });
        }  
        setInterval(function () {
            topPlacesShuffle()
        },15000);   
        
        
        
  
      $('.recommendations a').click(function() {
        var element = this;
        
        $(element).parent().find('.current').removeClass('current');
        $(element).addClass('current');
        
        $.ajax({
            url: '<?php echo url_for('box/load?box_id='. $box->getBox()->getId().'&county='. $county) ?>',
            data: 'settings='+ '<?php echo $box->getStringSettings() ?>' + '&recommend_id='+ this.rel, 
            success: function(data) {
              $(element).parent().parent().find('.listing_tabs_content').html(data)
            }
        })
        return false;
      })
  })
</script>
<?php endif ?>