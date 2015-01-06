<?php use_helper('Pagination'); ?>
<div class="review-lists">
	<div class="user-review">
		<div class="review-image">
			<?php 
			if (is_object($user)){ ?>
				<img src="<?=myTools::getImageSRC($sf_user->getGuardUser()->getUserProfile()->getThumb(0), 'user')?>" alt="<?=$user->getFirstName()." ".$user->getLastName()?>" height="80px" width="80px">
			<?php } else{ 
					echo image_tag('/images/gui/default_user_80x80.jpg');
				}
			?>
		</div><!-- review-image -->
		
		<div name="review-content" class="review-content default-form-wrapper user-loged">

			<?php if ($sf_user->getFlash('error')) { 
				include_partial('global/actionMessage');
				?>
	            <div class="form-message error">
	                <p><?php echo __($sf_user->getFlash('error')); ?></p>
	            </div>
	        <?php } ?>
	        <?php if ($sf_user->getFlash('notice')){ 
	        	include_partial('global/actionMessage', array());
	        	?> 
	            <div class="form-message success">
	                <p><?php echo __($sf_user->getFlash('notice')) ?></p>
	            </div> 
	        <?php } ?>

			<form id="reviewForm" action="<?php echo url_for( $company->getUri(ESC_RAW)); ?>" method="post" class="default-form clearfix">		

				<div class="custom-row">
					<label class="rate-txt"><?php echo __('Rate', null, 'company'); ?></label>
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
				<h3 class="custom-row">
					<?php echo __('Write a Review', null, 'company'); ?>							
				</h3>
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
			          <?php if ((!$user_is_admin or !$user_is_company_admin) && $user && !$is_other_place_admin_logged){ ?>
			                 <input style="border: none;" type="submit" value="<?php echo __('Publish')?>" class="default-btn success publish-btn" />
			       <?php }elseif(!$user){ ?>
			                  <a href="javascript:void(0)" onClick="loginFormReviews()" id="login" class="default-btn success publish-btn"><?php echo __('Publish')?></a>
			         <div class="login_form_wrap" <?=(!($formRegister->isBound() && !$formRegister->isValid()) ? 'style="display: none"' : '')?> >
			                  <?php 
			                   if ($formRegister->isBound() && !$formRegister->isValid()){
			                      include_partial('company/register_form_review', compact('formRegister'));
			                   }else{
			                 	  include_partial('company/signin_form_review',array('form'=>$formLogin, 'company'=> $company));
			                   } ?>
			               </div>
			       <?php }?>
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
		</div><!-- review-content -->
	</div><!-- user-review -->
	
	<div class="user-comments" id="company_review_container">
		<?php echo include_partial('companyReviewList', array('reviews' => $reviews, 'user'=>$user,'company_id'=>$company->getId())); ?>
	</div>
</div>
<?php use_stylesheet('jquery.rating.css');
	  use_javascript('rating_stars.js');
?>
<?php //use_javascript('jquery.rating.js');?>
<?php //include_partial('company/rating');?>
<script type="text/javascript">
	function goToLoginForm(){
		$("html, body").stop(true, true).animate({
            scrollTop: 0
        });
		$('.form-login').css('z-index', '51');
		$('.form-login').css('display', 'block');		
	}
	function checkRating(n){
		for(i=1;i<6;i++){
			//$('#review_rating_'+i).attr('checked', false);
			//$('#review_rating_'+i).removeAttr('checked');
		}
		$('#review_rating_'+n).attr('checked', true);
	}
</script>
<style>
.radio_list{
	display: none;
}
</style>