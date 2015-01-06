<?php use_helper('Pagination') ?>
<?php //echo javascript_include_tag(javascript_path('review.js')); ?>
<?php include_partial('review/reviewJs');?>
<script>
//review.init();
</script>

<?php //use_helper('jQuery') ?>
<?php include_partial('global/commonSlider'); 
$params = array('company' => $company, 'adminuser' => $adminuser, 'companies' => $companies, 'is_getlokal_admin' => $is_getlokal_admin);

$lng= mb_convert_case(getlokalPartner::getLanguageClass(), MB_CASE_LOWER,'UTF-8');

$languages = sfConfig::get('app_languages_'.$lng);
?>

<div class="container set-over-slider">
	<div class="row">	
		<div class="container">
			<div class="row">
				<?php include_partial('topMenu', $params); ?>	
			</div>
		</div>	          
	</div>		
		
	<div class="col-sm-4">
        <div class="section-categories">
            <!-- div class="categories-title">
                   
	        </div><!-- categories-title -->
            <?php include_partial('rightMenu', $params); ?>	            
	   </div>
	</div>
	<div class="col-sm-8">
        <div class="content-default">    
			<div class="row">
				<div class="default-container default-form-wrapper col-sm-12 p-0">
					<?php if ($sf_user->getFlash('error')) { 
							include_partial('global/actionMessage');
						?>
		            <div class="form-message error">
		                <p><?php echo __($sf_user->getFlash('error')); ?></p>
		            </div>
			        <?php } ?>
			        <?php if ($sf_user->getFlash('notice')){ 
			        	include_partial('global/actionMessage', array('class' => 'asd'));
			        	?> 
		            <div class="form-message success">
		                <p><?php echo __($sf_user->getFlash('notice')) ?></p>
		            </div> 
			        <?php } ?>
					<?php if (!$pager->getNbResults()) { ?>
						<p><?php echo __('There are no reviews', null, 'user'); ?></p>
					<?php } else { ?>
						<p class="reviews-num-company-settings"><?php echo format_number_choice('[0]No reviews|[1]1 review|(1,+Inf]%count% reviews', array('%count%' => $pager->getNbResults()), $pager->getNbResults(),'user'); ?></p>	
							<div class="pp-tabs">
								<div class="pp-tabs-body">
									

							<div class="review-lists">
								<div class="user-comments" id="company_review_container">
									<ul class="user-comment">
										<?php foreach ($pager->getResults() as $review) { ?>
											<li class="hover-reviews-cs">
					
												<?php include_partial('review/review', array('review' => $review, 'review_user' => true, 'user'=>$user, 'user_is_admin'=>$user_is_admin)) ?>
										
											</li>	
										<?php } ?>
	 
										<?php  echo pager_navigation($pager, 'companySettings/reviews'); ?>
		
									<?php } ?>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
$('.path_wrap').remove();
		
$('.pager a').click(function() {
    $.ajax({
        url: this.href,
        beforeSend: function( ) {
          $('.settings_content').html('<div class="review_list_wrap"><?php echo sprintf(__('loading...') ) ?></div>');
        },
        success: function( data ) {
          $('.settings_content').replaceWith(data);
          $('.settings_tabs_in div.settings_sidebar').width($('.settings_tabs_top > div').first().width() - 7);
          if ($('.settings_tabs_in div.settings_sidebar').width() < 150)
          {
        	  $('.settings_tabs_in div.settings_sidebar').width(150);
          }
          $('.settings_content').width(832 - $('.settings_tabs_in div.settings_sidebar').width());
          $('.settings_content div.pager_center').width($('.settings_content').width() - 52 - $('.settings_content div.pager_left').width() - $('.settings_content div.pager_right').width());
        }
    });
    return false;
  });
});

$(".review_list_company,.review_list_users,.review_company_content").on({
    mouseenter : function() {
        $(this).children("div.review_interaction").children("a.report,a.edit,a.reply,a.delete").fadeIn("fast");
    },
    mouseleave : function() {
        $(this).children("div.review_interaction").children("a.edit,a.delete,a.report,a.reply").fadeOut("fast");
    }
});

$('.report').click(function(e){
    var href = $(this).attr('data');
    
    var element = $(this).parent().parent().children('.ajax');
    element.stop(true, true).slideToggle();
    loading = true;
    $.ajax({
        url: href,
        beforeSend: function() {
      	 $(element).html('');
        },
        success: function(data, url) {
      	 element.html(data);
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
</script>
