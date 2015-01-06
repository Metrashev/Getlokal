<?php //include_partial('review/reviewJs');?>
<?php use_javascript('review.js') ?>
<?php use_helper('Pagination');?>
<div class="review-lists">
	<div class="user-review">
		<div class="review-image">
			<?php
			if($user){ 
				echo image_tag($sf_user->getGuardUser()->getUserProfile()->getThumb(0),array("size"=>"80x80"));
			}
			?>
		</div>
		<!-- review-image -->
		
		<div class="review-content">
			<div class="custom-row margin-bottom-small">
				<h3><?php echo __('Leave Comment', null, 'messages'); ?></h3>
			</div>
			<form action="<?php echo url_for('comment/save?id='.$activity->getId()); ?>" method="post" id="comment_form">
				<div class="form-review-content">
					<?php echo $form['body'] ?>
<!-- 					<textarea name="" id="" cols="" rows="3">Your review text goes here...</textarea> -->
					<p><?php echo __('Please write clearly, without using offensive or obscene language.'); ?></p>
				</div>

				<div class="form-review-actions">
					<?php /* 
					<div class="checkbox-container">
						<input type="checkbox" class="field" id="facebook-checkbox"> 
							<label for="facebook-checkbox" name="checkbox">I want to share on Facebook my review</label>
					</div>*/
					?>
					<!-- checkbox -->
					<?php if($user && $user->getId()){ ?>

					<input type="submit" class="default-btn success pull-right" value="<?php echo __('Publish');?>" class="input_submit" />
					<?php }elseif(!$user){ ?>
					<a href="javascript:void(0)" onClick="$('.login_form_wrap').toggle()" id="login" class="default-btn success publish-btn"><?php echo __('Publish')?> </a>
					<?php }?>
					<!-- 					<a href="#" class="publish-btn">Publish</a> -->
					<?php echo $form['_csrf_token'] ?>
				</div>
				<!-- form-review-actions -->
			</form>
			<?php if(!$user){?>
				<div class="default-form-wrapper login_form_wrap"<?=(!($formRegister->isBound() && !$formRegister->isValid()) ? 'style="display: none"' : '')?>>
					<form method="post" class="default-form clearfix">
						<?php //include_partial('user/signin_form',array('form'=>new sfGuardFormSignin(), 'publish_item'=>__('comments'))); ?>
						<?php 
						if ($formRegister->isBound() && !$formRegister->isValid()){
			              	include_partial('company/register_form', array_merge(compact('formRegister'),array("with_form"=>true)));
			            }else{
					        include_partial('company/signin_form',array('form'=>$formLogin));
			            } ?>
			        </form>
				</div>
			<?php }?>
		</div>
		<div class="clearfix"></div>
		<!-- review-content -->
		<div class="user-comments">
			<ul class="user-comment">
				<?php 
					//$results = $pager->getResults();
				foreach($results as $i => $comment): ?>
			    	<?php include_partial('comment/comment', array('comment' => $comment, 'user' => $user)) ?>
				<?php endforeach ?>
			</ul>
		</div>
		<div id="comment_pager">
			<?php // echo pager_navigation($pager, $url ); ?>
		</div>
		<input type="hidden"  value="<?php echo $url ?>" id="comment_pager_url">
	</div>
	<!-- user-review -->
</div>
<!-- review-tab-lists -->
<?php  
	if (isset($pager_class)) {$load_class=$pager_class;}
	else ($load_class='standard_tabs_in')
		
?>
<script type="text/javascript">
$(document).ready(function() {
	
	$('#comment_pager a').on('click',function() {
		$.ajax({
			url: this.href,
			beforeSend: function( ) {
				$('.<?php echo $load_class?>').html('<div class="review_list_wrap">loading...</div>');
			  },
			success: function( data ) {
				 $('.<?php echo $load_class?>').html(data);
			}
		});
		return false;
	  });
  review.init();
})

$('#comment_form').on('submit',function(e) {
	  e.preventDefault();
	  console.log("here");
	  $(".new_reply").removeClass("new_reply");
      var element = $("<li class='new_reply'></li>");
	  $("ul.user-comment").prepend(element);//$(this).parent().parent().parent();
	  var comment_pager_url = '';
		
	  var b="<?php echo $url; ?>";
	  if($("#comment_form textarea").val()){
		  $.ajax({
		      type: 'POST',
		      url:  this.action,
		      dataType: 'html',
		      data: $(this).serialize()+"&pager_url="+b,
		      beforeSend: function() {
	            element.html(LoaderHTML);
	          },
		      success: function(data) {
		    	  element.html($(data).html());
		    	  $("#comment_form textarea").val("");
		        //$('.comments').html($(data).html());
	          }
	     }); 
	  }
    return false;
  })
</script>

