<?php slot('no_ads', true) ?>
<?php $followers_count = count($all_followers);?>
<div class="settings_content">
	<p class="settings_right_msg"><?php echo format_number_choice('[0]No followers|[1]1 follower|(1,+Inf]%count% followers', array('%count%' => $followers_count), $followers_count,'messages'); ?></p>
	<h2><?php echo __('Contact Followers')?></h2>
	
	<?php /*
	if($followers_count >0): ?>
		<div>
			<?php echo __('Send massage to:')?>
			
			<?php foreach($all_followers as $follower): ?>
				<div>
					<?php echo $follower->getUserProfile()->getLink(0, 'size=100x100', '', ESC_RAW) ?>
					<?php echo $follower->getUserProfile();?>
					<div class="clear"></div>
         		</div>
       		<?php endforeach;?>
     	</div>
     	
	<?php endif;
	*/?>
	<input type="checkbox" id="checkAll" /> <?php echo __('Select All');?>
	<form class="send_follow_msg" action="<?php echo url_for('companySettings/contactFollowers?slug='.$company->getSlug()) ?>" method="post">
		<?php echo $form[$form->getCSRFFieldName()] ?>
		<div class="checkbox_scroll">
			<div class="scrollbar"><div class="track"><div class="thumb"></div></div></div>
				        
			<div class="form_box viewport" id="to">
				<?php echo $form['to']->render(array('class'=>'pre_check'))?>
				
			</div>
                        <?php echo $form['to']->renderError()?>
		</div>
		<div class="form_box">
			<?php echo $form['body']?>
			<?php echo $form['body']->renderError()?>
		</div>
		<div class="form_box">
			<input type="submit" value="<?php echo __('Send');?>" class="button_pink" />
			
		</div>
	</form>
</div>
<div class="clear"></div>

<script type="text/javascript">
$(document).ready(function() {
	
	
	$("#checkAll").click(function(){
	    var status = $(this).attr("checked") ? "checked" : false;	  
	    $(".pre_check").attr("checked",status);
	    if (status) {
	    	 $('.pre_check').parent().addClass('ez-checked');
        }else
        {
       	 $('.pre_check').parent().removeClass('ez-checked');    
        }
        
             
	});
	$(".pre_check").click(function(){
	    var status = $(this).attr("checked") ? "checked" : false;	  
	   
	    if (!status) {
	    	 $("#checkAll").attr("checked",false);
	    	 $('#checkAll').parent().removeClass('ez-checked');
        }
        
             
	});

	if ($('checkbox_scroll .overview').outerHeight() > $('checkbox_scroll .viewport')) {
		$('checkbox_scroll').tinyscrollbar();
	}
	else {
		$('checkbox_scroll .viewport').css({height:'auto'});
		$('checkbox_scroll .overview').css({position:'static'});
		$('checkbox_scroll .scrollbar').remove();
	}
});
</script>