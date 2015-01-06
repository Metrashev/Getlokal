<?php /* See http://www.getlokal.com/bg/sofia/inter-expo-center-1 */ ?>

<?php use_helper('Pagination');?>

<div class="company_offers_wrap">
	<h2><?php echo __('Offers', null, 'offer'); ?></h2>
	<?php if (!$pager->getNbResults()) : ?>
	    <p style="margin-left: 25px;">
	        <?php echo __('There are no offers', null, 'offer'); ?>
	    </p>
	<?php else:?>
	    <?php foreach ($pager->getResults() as $offer) : ?>
	        <?php include_partial('offer/customOffer', array('offer' => $offer)) ?>
	    <?php endforeach;?>
	<?php endif;?>
	
	<?php echo pager_navigation($pager, 'company/showAllOffers?slug=' . $company->getSlug() . '&city=' . $company->getCity()->getSlug() . '&template=customOffer') ?>
	
	<div class="clear"></div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
      // See http://www.getlokal.com/bg/sofia/inter-expo-center-1

      $('.pager a').click(function() {
          $.ajax({
              url: this.href,
              beforeSend: function( ) {
                $('.place_content').html('<div class="review_list_wrap">loading...</div>');
              },
              success: function( data ) {
                $('.place_content').html(data);
              }
          });
          return false;
      });

      var loading = false;
      
  }) 
</script>