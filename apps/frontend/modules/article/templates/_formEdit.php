<h2 class="form-title"><?php echo __('Additional Information', null, 

'contact'); ?></h2>		
<div class="clear"></div>
<?php $lng = 'bg'; ?>
<div class="col-sm-12">
	<ul class="nav nav-tabs default-form-tabs" role="tablist" id="myTab">
		<li id="opt_1" value="1" class="active"><a href="#Section01" role="tab" data-toggle="tab"><?php echo __('Places');?></a></li>
		<li id="opt_2" value="2" class=""><a href="#Section02" role="tab" data-toggle="tab"><?php echo __('Lists');?></a></li>
		<li id="opt_3" value="3" class=""><a href="#Section03" role="tab" data-toggle="tab"><?php echo __('Events',null,'events');?></a></li>
	</ul>
	<br />
	<div class="col-sm-12">
		<div class="default-input-wrapper active">
			<label for="name" class="default-label"><?php echo __('Places').", ".__('Lists').", ".__('Events',null,'events');?></label>
			<input type="text" id="locate_item" id="name" class="default-input">			
		</div>		
		<div id="item_list" style="display: none;"></div>
	</div>
	<br /><br />				
	<div class="tab-content default-form-tabs-content">
		<div class="tab-pane active" id="Section01">
			<div class="form_list_wrap">
				<div class="col-sm-12">
					<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
					<div class="viewport">
						<div class="overview">
							<ul class="tag-wrapper" id="list_of_places">
								<?php include_component('article', 'places', array('article' => $form->getObject(), 'form' => $form)); ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane" id="Section02">
			<div class="form_list_wrap">
				<div class="col-sm-12">
					<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
					<div class="viewport">
						<div class="overview">
							<ul class="tag-wrapper" id="list_of_lists">
								<?php include_component('article', 'lists', array('article' => $form->getObject(), 'form' => $form)); ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane" id="Section03">
			<div class="form_list_wrap">
				<div class="col-sm-12">
					<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
					<div class="viewport">
						<div class="overview">
							<ul class="tag-wrapper" id='list_of_events'>
								<?php include_component('article', 'events', array('article' => $form->getObject(), 'form' => $form)); ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div>
		<div class="col-sm-12">
			<div class="default-input-wrapper select-wrapper active required <?php echo $form['status']->hasError() && $form['status']->renderError() != '' ? 'incorrect' : '' ?>">
				<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
				<?php echo $form['status']->renderLabel(null, array('for' => 'name', 'class' => 'default-label'))?>
				<?php echo $form['status']->render(array('placeholder' => $form['status']->renderPlaceholder(), 'id' => 'article_status', 'class' => 'default-input' ));  ?>							
				<div class="error-txt"><?php echo $form['status']->renderError()?></div>
			</div>
		</div>		
<?php if (!$form->getObject()->isNew() && $user_profile->hasCredential('article_editor')){ ?>
		<div class="col-sm-12">
			<div class="default-input-wrapper select-wrapper active required <?php echo $form['user_id']->hasError() && $form['user_id']->renderError() != '' ? 'incorrect' : '' ?>">
				<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
				<?php echo $form['user_id']->renderLabel(null, array('for' => 'name', 'class' => 'default-label'))?>
				<?php echo $form['user_id']->render(array('placeholder' => $form['user_id']->renderPlaceholder(), 'id' => 'article_status', 'class' => 'default-input' ));  ?>							
				<div class="error-txt"><?php echo $form['status']->renderError()?></div>
			</div>
		</div>	
<?php } ?>		
		<div class="col-sm-12">
			<div class="default-input-wrapper select-wrapper <?php echo $form['publish_on']->hasError() && $form['publish_on']->renderError() != '' ? 'incorrect' : '' ?>">
				<?php echo $form['publish_on']->render(array('placeholder' => $form['publish_on']->renderPlaceholder(), 'id' => 'publish_on', 'class' => 'default-input' ));  ?>							
				<div class="error-txt"><?php echo $form['publish_on']->renderError()?></div>
			</div>
		</div>	
		
<?php if (!$form->getObject()->isNew()){?>
		<div class="col-sm-12">
			<div class="default-input-wrapper select-wrapper active required <?php echo $form['category_id']->hasError() && $form['category_id']->renderError() != '' ? 'incorrect' : '' ?>">
				<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
				<?php echo $form['category_id']->renderLabel(null, array('for' => 'name', 'class' => 'default-label'))?>
				<?php echo $form['category_id']->render(array('placeholder' => $form['category_id']->renderPlaceholder(), 'id' => 'article_status', 'class' => 'default-input' ));  ?>							
				<div class="error-txt"><?php echo $form['category_id']->renderError()?></div>
			</div>
		</div>	
<?php }?>	 

</div>
		
<script type="text/javascript"> 
$('#locate_item').keyup(function() {
	var values = $(this).val();
	//var selected = $('input[type="radio"]:checked').val();
	var selected = $('#myTab li.active').attr('value');
	var container = $('#item_list');
	var cityId = <?=$sf_user->getCity()->getId()?>;
	var articleId = <?php echo $form->getObject()->getId() ?>;

	if (values.length > 2) {
		$("#item_list").css("display", "block");
		container.html('');
		var url = '';
		if (selected == 1) {
			url = '<?php echo url_for("article/getPage") ?>';
		}
		else if (selected == 2) {
			url = '<?php echo url_for("article/getList") ?>';
		}
		else if (selected == 3) {
			url = '<?php echo url_for("article/getEvent") ?>';
		}

		$.ajax({
			url: url,
				data: {'values': values, 'articleId': articleId, 'cityId': cityId},
			success: function(data, url) {
				container.html(data);
		    },
		    error: function(e, xhr)
		    {
		        console.log(xhr);
		    }
		});
	}
	else{
		  $("#item_list").css("display", "none");
		  $("#item_list").html('')
		}
});

$("#list_of_places a, #list_of_lists a, #list_of_events a").click(function() {
	var Id = $(this).attr('id');
	var thisEl = $(this);
	var row = $(this).parent();

	var container = row.parent();
	var url = '';
	if (container.attr('id') == 'list_of_places')
		url = '<?php echo url_for("article/delPageFromArticle") ?>';
	else if (container.attr('id') == 'list_of_lists')
		url = '<?php echo url_for("article/delListFromArticle") ?>';
	else if (container.attr('id') == 'list_of_events')
		url = '<?php echo url_for("article/delEventFromArticle") ?>';

	$.ajax({
		url: url,
		data: {'Id': Id},
		success: function(data, url) {
			$(row).remove();
			$('.form_list_wrap > div').tinyscrollbar({size: 215});
		},
		error: function(e, xhr)
		{
			console.log(xhr);
		}
	});
	return false;
});
</script>