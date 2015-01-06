<?php slot('description') ?>
<?php if ($page == 1):?>
  <?php echo sprintf(__('%s in %s - information in getlokal: see address, telephone, working hours, photos and user reviews for %s, %s', null, 'pagetitle'),$company->getCompanyTitle(),$company->getCity()->getLocation(), $company->getCompanyTitle(), $company->getCity()->getLocation());?>
<?php else:?>
  <?php echo sprintf(__('Find up-to-date reviews, comments and ratings of customer for %s in %s. Add your own review!', null, 'pagetitle'), $company->getCompanyTitle(), $company->getCity()->getLocation());?>
<?php endif;?>
<?php end_slot() ?>


<?php slot('facebook') ?>
   <?php $culture = $sf_user->getCulture();?>
  <meta property="fb:app_id" content="<?php echo sfConfig::get('app_facebook_app_'.$sf_user->getCountry()->getSlug().'_id'); ?>"/>
  <meta property="og:title" content="<?php echo $company->getCompanyTitle().' | ' .$company->getClassification()->getTitle(). ' | Getlokal'; ?>" />
  <meta property="og:url" content="<?php echo url_for($company->getUri(ESC_RAW), true);?>" />
  <?php if($company->getImageId()):?>
    <meta property="og:image" content="<?php echo image_path($company->getThumb(3), true);  ?>" />
  <?php else:?>
    <!-- <meta property="og:image" content="<?php // echo ($sf_request->isSecure()? 'http://':'https://').$sf_request->getHost().'/images/gui/mobile-logo.png' ?>" />  -->
    <meta property="og:image" content="<?php echo image_path('/images/gui/getlokal_thumbnail_200x200.jpg', true);  ?>" />
  <?php endif; ?>  
  <meta property="og:type" content="business.business" />
  <meta property="og:image" content="<?php echo image_path($company->getThumb(), true)  ?>" />
  <meta property="business:contact_data:country_name" content="<?php echo mb_convert_case($sf_user->getCountry()->getSlug(), MB_CASE_UPPER) ?>" />
  <meta property="business:contact_data:locality" content="<?php echo $company->getCity()->getLocation(); ?>" />
  <meta property="business:contact_data:website" content="<?php echo $sf_request->getUriPrefix(); ?>" />
 
  <?php if($company->getCompanyDescription($culture)):?>
    <meta property="og:description" content="<?php echo $company->getCompanyDescription($culture)?>" />
  <?php endif; ?>
<?php if($company->getLocation()->getPostcode() != ''): ?>
  <?php $postal_code = $company->getLocation()->getPostcode(); ?>
<?php else: ?>
  <?php $postal_code = myTools::getPostcode($company->getLocation()->getLatitude(), $company->getLocation()->getLongitude());?>
<?php endif; ?>
  <meta property="business:contact_data:postal_code" content="<?php echo $postal_code;?>" />
  <meta property="business:contact_data:street_address" content="<?php echo $company->getDisplayAddress();?>" />

  <meta property="place:location:latitude" content="<?php echo $company->getLocation()->getLatitude() ?>" /> 
  <meta property="place:location:longitude" content=" <?php echo $company->getLocation()->getLongitude() ?>" /> 
<?php end_slot() ?>


<?php /* slot('facebook') ?>
  <?php $culture = $sf_user->getCulture();?>
  <meta property="fb:app_id" content="<?php echo sfConfig::get('app_facebook_app_'.$sf_user->getCountry()->getSlug().'_id');?>"/>
  <meta property="og:title" content="<?php echo $company->getCompanyTitle() .' | ' .$company->getClassification()->getTitle(). ' | getlokal';?>" />
  <meta property="og:type" content="company" />
  <meta property="og:url" content="<?php echo url_for($company->getUri(ESC_RAW), true);?>" />
  <?php if($company->getCompanyDescription($culture)):?>
    <meta property="og:description" content="<?php echo $company->getCompanyDescription($culture)?>" />
  <?php endif;?>
  <?php if ($company->getDisplayAddress()): ?>
  	<meta property="og:street-address" content="<?php echo $company->getDisplayAddress();?>" />
  <?php endif;?>
  <meta property="og:locality" content="<?php echo $company->getCity()->getLocation(); ?>" />
  <meta property="og:image" content="<?php echo image_path($company->getThumb(), true)  ?>" />
  <meta property="og:site_name" content="<?php echo $sf_request->getHost() ?>" />
  <meta property="og:country-name" content="<?php echo mb_convert_case($sf_user->getCountry()->getSlug(), MB_CASE_UPPER) ?>" />
<?php end_slot()  */?>

<?php slot('canonical') ?>
  <link rel="canonical" href="<?php echo $company->getCanonicalUrl() ?>">
  <?php foreach(sfConfig::get('app_domain_slugs') as $iso): ?>
  <link rel="alternate" hreflang="en-<?php echo $iso ?>" href="<?php echo $company->getPermalink($iso, 'en') ?>">
  <link rel="alternate" hreflang="<?php echo $iso ?>-<?php echo $iso ?>" href="<?php echo $company->getPermalink($iso, $iso) ?>">
  <?php endforeach ?>
<?php end_slot() ?>

<?php use_helper('Pagination') ?>
<?php //use_javascript('review.js') ?>
<?php include_partial('review/reviewJs');?>
<?php use_stylesheet('jquery.rating.css');?>
<?php //use_javascript('jquery.rating.js');?>
<?php include_partial('company/rating');?>
<?php //include_javascripts('jquery.rating.js')?>

<div class="review_list_wrap">

   <p><?php echo format_number_choice('[0]No reviews|[1]1 review|(1,+Inf]%count% reviews', array('%count%' => $pager->getNbResults()), $pager->getNbResults(),'user'); ?>
    </p><div class="review_edit_success"></div>
   <?php if ($pager->getNbResults()>0): ?>
    <?php foreach ($pager->getResults() as $review): ?>
      <?php include_partial('review/review', array('review' => $review,'company'=>$company, 'review_user' => true, 'user'=>$user, 'user_is_admin'=>$user_is_admin, 'user_is_company_admin'=>$user_is_company_admin)) ?>
    <?php endforeach;?>
  <?php endif;?>

  <?php if(!$user_is_admin && !$user_is_company_admin && !$is_other_place_admin_logged):?>
    <div class="add_review" id="add_review_container">
      <h3><?php echo __('Write a Review'); ?></h3>
      <form id="reviewForm" action="<?php echo url_for( $company->getUri(ESC_RAW)); ?>" method="post">
        <div class="form_box<?php if( $form['rating']->hasError()):?> error<?php endif;?>">
          <label><?php echo __('Rate'); ?></label>
          <?php  echo $form['rating']->render(array('class'=>'star')); ?>
          <?php echo $form['rating']->renderError()?>
          <div class="clear"></div>
        </div>
        <div class="form_box<?php if( $form['text']->hasError()):?> error<?php endif;?>">

          <label><?php echo __('Review'); ?></label>
          <?php echo $form['text'] ?>
          <?php echo $form['text']->renderError()?>
        </div>

        <div class="form_box">

			     <?php if ((!$user_is_admin or !user_is_company_admin) && $user && !$is_other_place_admin_logged):?>
          			<input type="submit" onClick="_gaq.push(['_trackEvent', 'Review', 'Publish', 'company']);" value="<?php echo __('Publish')?>" class="input_submit" />
				<?php elseif (!$user):?>
					<a href="javascript:void(0)" onClick="_gaq.push(['_trackEvent', 'Review', 'Publish', 'company']);" id="login" class="button_green"><?php echo __('Publish')?></a>
					<div class="login_form_wrap" <?php
            if (!($formRegister->isBound() && !$formRegister->isValid())) {
              echo 'style="display: none"';
            }
          ?>>
						<!-- <a href="javascript:void(0)" id="header_close"></a>  -->
            <?php if ($formRegister->isBound() && !$formRegister->isValid()): ?>
              <?php include_partial('company/register_form', compact('formRegister')) ?>
            <?php else: ?>
		        	<?php include_partial('company/signin_form',array('form'=>$formLogin, 'company'=> $company));?>
            <?php endif ?>
	        </div>
				<?php endif;?>

        </div>
        <?php if ($sf_user->hasAttribute('my_token') && $sf_user->getAttribute('my_token')):?>
			<?php $token = $sf_user->getAttribute('my_token'); ?>
		<?php else : ?>
			<?php $token = $form->getCSRFToken(); ?>
        <?php endif;?>

        <?php echo $form['_csrf_token']->render(array('value' => $token)) ?>
      </form>

      <?php echo __('Please write clearly, without using offensive or obscene language.', null, 'messages');?>
    </div>
      <?php endif;?>
    <?php /*elseif (!$user):?>
        <div class="add_review" id="add_review_container">
	      <h3><?php echo __('Write a Review'); ?></h3>
	      <?php include_partial('user/signin_form',array('form'=>$formLogin));?>
	    </div>
  <?php  endif; */?>

  <?php  echo pager_navigation($pager, url_for( $company->getUri(ESC_RAW))); ?>

</div>

<div class="clear"></div>
<script type="text/javascript">
        $(document).ready(function(){
            $("form#reviewForm").submit(function(){
              $('input').attr('readonly', true);
              $('input[type=submit]').attr("disabled", "disabled");
              $('a').unbind("click").click(function(e) {
                  e.preventDefault();
              });
            });
    });
</script>

<script type="text/javascript">
  $(document).ready(function() {	  
	  map.classification_id = '<?php echo $company->getClassificationId(); ?>';
	  
	  $('.radio_list li span div#review_rating_1 a').attr('title', "<?php echo __('Poor'); ?>");
	  $('.radio_list li span div#review_rating_2 a').attr('title', "<?php echo __('Average'); ?>");
	  $('.radio_list li span div#review_rating_3 a').attr('title', "<?php echo __('Good'); ?>");
	  $('.radio_list li span div#review_rating_4 a').attr('title', "<?php echo __('Very good'); ?>");
	  $('.radio_list li span div#review_rating_5 a').attr('title', "<?php echo __('Excellent'); ?>");
	  if ($('div.star-rating a').css('background-image') != "none")
	  {
		  $('div.star-rating a').css('text-indent', '-9999px');
	  }
      $('.pager a').click(function() {
          $.ajax({
              url: this.href,
              beforeSend: function( ) {
                $('.standard_tabs_in').html('<div class="review_list_wrap">loading...</div>');
              },
              success: function( data ) {
                $('.standard_tabs_in').html(data);
              }
          });
          return false;
      });
      //review.init();

  $('#login').click(function() {
	  $('.login_form_wrap').toggle();
  });
<?php /*?>
$('.register_pos, .login_form_wrap .button_green').click(function() {
	    //var element = this;

	    $.ajax({
	        url: this.href,
	        beforeSend: function() {
	          $('.login_form_wrap').html('loading...');
	        },
	        success: function(data, url) {
	          $('.login_form_wrap').html(data);
	          loading = false;
	          //console.log(id);
	        },
	        error: function(e, xhr)
	        {
	          console.log(e);
	        }
	    });
	    return false;
	  });
	  <?php */?>
  });
</script>
<?php CompanyStatsTable::saveStatsLog (sfConfig::get ( 'app_log_actions_page_view' ), $company->getId () );?>
