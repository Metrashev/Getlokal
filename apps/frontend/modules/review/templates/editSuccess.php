<?php use_stylesheet('jquery.rating.css');?>
<?php include_partial('company/rating');?>

<form id="reviewForm" action="<?php echo url_for('review/edit?review_id='.$form->getObject()->getId()); ?>" method="post" class="default-form clearfix">		
				<div class="row">
					<div class="col-sm-12">
						<h2 class="form-title">
							<?php echo __('Edit', NULL, 'company'); ?>
							<a href="<?php echo url_for( 'review/cloce?review_id='.$form->getObject()->getId() ) ?>" class="close_form_review">
								<button type="button" class="close close_signin"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							</a>							
						</h2>
					</div>
				</div>
				<div class="custom-row">
					<div class="mark-rating-stars">
						<div class="default-radio star">
							<input type="radio" value="1" id="rr_1" name="rr" class="star-check" onclick="checkRating(1)"></input>
							<div class="fake-box"></div>
						</div>

						<div class="default-radio star">
							<input type="radio" value="2" id="rr_2" name="rr" class="star-check" onclick="checkRating(2)"></input>
							<div class="fake-box"></div>
						</div>

						<div class="default-radio star">
							<input type="radio" value="3" id="rr_3" name="rr" class="star-check" onclick="checkRating(3)"></input>
							<div class="fake-box"></div>
						</div>	
						<div class="default-radio star">
							<input type="radio" value="4" id="rr_4" name="rr" class="star-check" onclick="checkRating(4)"></input>
							<div class="fake-box"></div>
						</div>	
						<div class="default-radio star">
							<input type="radio" value="5" id="rr_5" name="rr" class="star-check" onclick="checkRating(5)"/></input>
							<div class="fake-box"></div>
						</div>
						<div class="error-txt error-txt-review" id="rating_error"><?php echo $form['rating']->renderError()?></div>
						<?php echo $form['rating']->render()?>
					</div><!-- Stars -->
				</div>
				
				<div class="form-review-content">
					<!-- <label style="display: block; margin: 0;"><?php echo __('Review'); ?></label> -->
          			<div class="row">
          				<div class="col-sm-12">
          					<div class="default-input-wrapper<?php if($form['text']->hasError()):?> incorrect<?php endif;?>">
          						<div class="error-txt error-txt-review"><?php echo $form['text']->renderError()?></div>
          						<?php echo $form['text']->render(array('cols'=>78, 'rows'=>3, 'class' => 'default-input', 'placeholder' => 'Your review text goes here...')) ?>
          						<!-- <textarea placeholder="Placeholder text" class="default-input"></textarea> -->
          					</div><!-- Form TextArea -->
          				</div>
          			</div>
					<div class="tip"><?php echo __('Please write clearly, without using offensive or obscene language.', null, 'messages'); ?></div>
				</div>
		
				<div class="form-review-actions">
			        <div class="form_box">
			            <input style="border: none;" type="submit" value="<?php echo __('Publish')?>" class="default-btn success publish-btn" />
			        </div>
			    </div><!-- form-review-actions -->

				<?php 
					if ($sf_user->hasAttribute('my_token') && $sf_user->getAttribute('my_token')){
						$token = $sf_user->getAttribute('my_token');
					} else{
						$token = $form->getCSRFToken();
					}

					echo $form['_csrf_token']->render(array('value' => $token));
				?>
			</form>

<?php if($sf_request->isXmlHttpRequest()): ?>
<script type="text/javascript">
  $('a.close_form_review').click(function () {
	  var loading = false;
      
	    if(loading) return false;
	    
	    var element = $(this).parent().parent().parent().parent().parent();
	        console.log(element);
	    loading = true;

	    $.ajax({
	        url: this.href,
	        type: 'POST',
	        beforeSend: function() {
	          element.html(LoaderHTML);
	        },
	        success: function(data, url) {
	        	element.html(data);
	            loading = false;
	            if ($('.profile_review_scroll').length > 0) {
	                if ($('.profile_review_scroll .scrollbar').length > 0) {
	            			$('.profile_review_scroll').tinyscrollbar_update('relative');
	            	  }
	            }
	        }
	    });
	    
	    return false;
  });
  
  $('#review-<?php echo $review->getId() ?> form').submit(function() {
    var loading = false;
        
    if(loading) return false;
    
    var element = $(this).parent().parent().parent().find('div.review-content-body');
        
    loading = true;

    $.ajax({
        url: this.action,
        type: 'POST',
        data: $(this).serialize(),
        beforeSend: function() {
          $(element).html(LoaderHTML);
        },
        success: function(data, url) {
          $(element).html(data);
          $('.review_edit_success').html("<?php echo sprintf(__('Your review about %s was changed successfully.'),$form->getObject()->getCompany()->getCompanyTitle() ) ?>").addClass('flash_success');
          loading = false;
        },
        error: function(e, xhr)
        {
          console.log(e);
        }
    });
    
    return false;
  });

</script>
<?php endif ?>