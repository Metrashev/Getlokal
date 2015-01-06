<?php use_helper('Pagination'); ?>
<div class="review-lists">
	<div class="user-review">
		<div class="review-image">
			<?php 
			if (is_object($user)){ ?>
				<img src="<?=myTools::getImageSRC($sf_user->getGuardUser()->getUserProfile()->getThumb(0), 'user')?>" alt="<?=$user->getFirstName()." ".$user->getLastName()?>" height="80px" width="80px">
			<?php } ?>
		</div><!-- review-image -->
		
		<div name="review-content" class="review-content default-form-wrapper">
			<form id="reviewForm" action="<?php echo url_for( $company->getUri(ESC_RAW)); ?>" method="post" class="default-form clearfix">
				<h3><?php echo __('Rate', null, 'company'); ?></h3>
				<div class="col-sm-12">
					<div class="custom-row">
						<div class="default-radio star active">
							<input type="radio" id="star1" name="<?= $form['rating']->getName()?>">
							<div class="fake-box"></div>
						</div>

						<div class="default-radio star">
							<input type="radio" id="star2" name="<?= $form['rating']->getName()?>">
							<div class="fake-box"></div>
						</div>

						<div class="default-radio star">
							<input type="radio" id="star3" name="<?= $form['rating']->getName()?>">
							<div class="fake-box"></div>
						</div>	
						<div class="default-radio star">
							<input type="radio" id="star4" name="<?= $form['rating']->getName()?>" checked="checked">
							<div class="fake-box"></div>
						</div>	
						<div class="default-radio star">
							<input type="radio" id="star5" name="<?= $form['rating']->getName()?>">
							<div class="fake-box"></div>
						</div>
					</div><!-- Stars -->
				</div>
				<div class="reviews-holder">
					<div class="stars-holder bigger">					
						<?php  echo $form['rating']->render(array('class'=>'star')); ?>
	          			<?php echo $form['rating']->renderError()?>
					</div>
				</div>
				
					<div class="form-review-content">
						<?php echo $form['text']->render(array('cols'=>78, 'rows'=>3)) ?>
	          			<?php echo $form['text']->renderError()?>
						<p><?php echo __('Please write clearly, without using offensive or obscene language.', null, 'messages'); ?></p>
					</div>
			
					<div class="form-review-actions">
						<div class="form_box">
						    <?php if ((!$user_is_admin or !user_is_company_admin) && $user && !$is_other_place_admin_logged){ ?>
			          				<input style="border: none;" type="submit" value="<?php echo __('Publish')?>" class="publish-btn" />
							<?php }elseif(!$user){ ?>
						            <a href="javascript:void(0)" onClick="$('.login_form_wrap').toggle()" id="login" class="default-btn success publish-btn"><?php echo __('Publish')?></a>
									<div class="login_form_wrap" <?=(!($formRegister->isBound() && !$formRegister->isValid()) ? 'style="display: none"' : '')?> >
						            <?php 
							            if ($formRegister->isBound() && !$formRegister->isValid()){
							              	include_partial('company/register_form', compact('formRegister'));
							            }else{
									        include_partial('company/signin_form',array('form'=>$formLogin, 'company'=> $company));
							            } ?>
							        </div>
							<?php }?>				
			        	</div>		        
					</div><!-- form-review-actions -->	
			</form> 		
		</div><!-- review-content -->		
	</div><!-- user-review -->
	
	<div class="user-comments" id="company_review_container">
		<?php echo include_partial('companyReviewList', array('reviews' => $reviews, 'user'=>$user,'company_id'=>$company->getId())); ?>
	</div>
</div>
<?php use_stylesheet('jquery.rating.css');?>
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
</script>