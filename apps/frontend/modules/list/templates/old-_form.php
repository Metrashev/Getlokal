<?php use_stylesheets_for_form($form) ?>
<?php use_stylesheet('ui-lightness/jquery-ui-1.8.17.custom.css'); ?>
<?php //use_javascripts_for_form($form) ?>
 <?php if($sf_user->getFlash('newsuccess')):?>   
    <div class="flash_success">
      <?php echo  __($sf_user->getFlash('newsuccess'),null,'list') ?>
      <a></a>
    </div>
   <?php endif;?>
 <?php if($sf_user->getFlash('newerror')):?>   
    <div class="flash_error">
      <?php echo  __($sf_user->getFlash('newerror'),null,'list') ?>
    </div>
   <?php endif;?>
<form id ="listForm" action="<?php echo url_for('list/'.($form->getObject()->isNew() ? 'create' : 'edit').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
	
   <?php $lng= mb_convert_case(getlokalPartner::getLanguageClass(), MB_CASE_LOWER,'UTF-8');   ?>
    <div class="content_in">
    	<div class="content_full_form">
			<div class="form_box<?php if( $form[$lng]['title']->hasError()):?> error<?php endif;?> ">
				<?php echo $form[$lng]['title']->renderLabel()?>
				<?php echo $form[$lng]['title']->render(array('placeholder' => __('Name this list...',null,'list') ));  ?>
				<?php echo $form[$lng]['title']->renderError()?>
			</div>
			<div class="form_box<?php if( $form[$lng]['description']->hasError()):?> error<?php endif;?>">
				<?php echo $form[$lng]['description']->renderLabel()?>
				<?php echo $form[$lng]['description']->render(array('placeholder' => __('What is this list about...',null,'list') ));  ?>
				<?php echo $form[$lng]['description']->renderError()?>
			</div>
		</div>
		<div class="form_box form_label_inline<?php if( $form['is_open']->hasError()):?> error<?php endif;?>">
			<?php echo $form['is_open']->render(array('class' => 'input_check')); ?>
			<?php echo $form['is_open']->renderLabel()?>
			<?php echo $form['is_open']->renderError()?>
		</div>
		
		<div class="form_box<?php if( $form['file']->hasError()):?> error<?php endif;?>">
			<?php echo $form['file']->renderLabel()?>
			<?php echo $form['file'] ?>
			<?php echo $form['file']->renderError()?>
		</div>
		<?php 
		if ($form->getObject()->getImageId()):
			echo image_tag($form->getObject()->getThumb(2),array('size'=>'127x127', 'alt'=>$form->getObject()->getImage()->getCaption() ));
		endif;
		?>
		<div class="form_box<?php if( $form['caption']->hasError()):?> error<?php endif;?>">
			<?php echo $form['caption']->renderLabel()?>
			<?php echo $form['caption'] ?>
			<?php echo $form['caption']->renderError()?>
		</div>
		<?php if (!$form->getObject()->isNew()) : ?>
		<div id="dropdown_search">
			<div class="form_search">
				<div class="form_box">
					<?php //echo $form['place_id']->renderLabel()?> 
					<input id="search_place" type="text" placeholder="<?php echo __('Click to add places to your list!', null, 'list')?>" autocomplete="off"/>
				</div>
				<div class="form_city"<?php if( $form['location_id']->hasError()):?> error<?php endif;?>>
					<?php echo $form['location_id']->renderLabel()?>
					<?php echo $form['location_id'] ?>
					<?php echo $form['location_id']->renderError()?>
					<a href="javascript:void(0);" id="search_city_name"></a>
				</div>
				<div class="clear"></div>
			</div>
			<div class="form_box">
				<div id="PlacesList" class="list_of_places places_dropdown">
					<a href="javascript:void(0)" id="form_close"></a>
					<div>
						<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
						<div class="viewport">
							<div class="overview">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="form_box">
			<div class="list_of_places" id="list_of_places">
				<?php $options = array(  'places' => $form->getObject()->getListPage(),
				 						 'culture'=>$sf_user->getCulture(), 
				 						 'user'=>$user, 
				 						 'listUserId'=>$form->getObject()->getUserId(), 
				 						 'listId'=>$form->getObject()->getId(),
				 						 'is_place_admin_logged' => $is_place_admin_logged);
						 ?>
			
				<?php include_partial('list/places', $options ); ?>
			</div>
			<div class="clear"></div>
		</div>
		<?php endif;?>
		<div class="form_box">
			<a href="<?php echo url_for('list/index') ?>" class="button_pink"><?php echo __("Back to 'Lists'",null,'list')?></a>
			<input type="submit" value="<?php echo $form->getObject()->isNew() ? __( 'Next',null,'list') :__( 'Publish',null,'messages') ?>" class="button_green" />
		</div>
		<?php echo  $form->renderHiddenFields();?>
	</div>
	<div class="sidebar sidebar_full">
		<div class="form_box">
			<div class="form_box form_label_inline<?php if( $form['en']['title']->hasError()):?> error<?php endif;?>">
				<span class="label">
					<?php echo $form['en']['title']->renderLabel()?>
					<?php echo ' ('. __('English').')'?>
				</span>
				<?php echo $form['en']['title']->render(array('placeholder' => __('Name in English',null,'list') )); ?>
				<?php echo $form['en']['title']->renderError()?>
			</div>
			<div class="form_box form_label_inline <?php if( $form['en']['description']->hasError()):?> error<?php endif;?>">
				<span class="label">
					<?php echo $form['en']['description']->renderLabel()?>
					<?php echo ' ('. __('English').')'?>
				</span>
				<?php echo $form['en']['description']->render(array('placeholder' => __('Description in English',null,'list') ));  ?>
				<?php echo $form['en']['description']->renderError()?>
			</div>
		</div>
	</div>
</form>
<div class="clear"></div>
<?php /*if (! $form->getObject()->isNew()):?>
<div class="event_settings_content">
</div>
<script type="text/javascript">

$(document).ready(function() {
	
	$.ajax({
			url: '<?php echo url_for('event/images?event='.$form->getObject()->getId());?>',
			beforeSend: function( ) {
				$('.event_settings_content').html('<div class="review_list_wrap">loading...</div>');
			  },
			success: function( data ) {
				$('.event_settings_content').html(data);
			}
		});
	
	})
</script>	
<?php endif; */?>
<div class="clear"></div>
    <script type="text/javascript">
        $(document).ready(function(){
            $("form#listForm").submit(function(){
              $('input').attr('readonly', true);
              $('input[type=submit]').attr("disabled", "disabled");
              $('a').unbind("click").click(function(e) {
                  e.preventDefault();
              });
            });
    });
    </script>

<?php if (!$form->getObject()->isNew()): ?>
<script type="text/javascript">
$(document).ready(function() {
	$('.path_wrap').append('<div class="path_buttons"><a class="button_delete" method="delete" confirm="<?php echo __('Are you sure?');?>" href="<?php echo url_for("list/delete?id=".$form->getObject()->getId());?>"><?php echo __("Delete")?></a></div>');
})
</script>
<?php endif; ?>

<script type="text/javascript">
$(document).ready(function(){
	var city_clicked = false;
	$('a#search_city_name').text($('#autocomplete_list_location_id').val());
	$('a#search_city_name').click(function() {
		if (!city_clicked)
		{
			$(this).toggle('fast');
			$(this).parent().css({padding: '17px 10px'});
			$(this).parent().children('input').toggle('fast', 'swing', function() {
				$(this).parent().children('input').focus();
				city_clicked = true;
			});
		}
	});
	$('#autocomplete_list_location_id').blur(function() {
		if (city_clicked)
		{
			val = $(this).val();
			if ($.trim(val) != '') {
				$(this).parent().children('a').text(val.split(',')[0]);
			}
			else {
				$(this).val($(this).parent().children('a').text());
			}
			city_clicked = false;
		}
		$(this).toggle('fast');
		$(this).parent().children('a').toggle('fast', 'swing', function() {
			$(this).parent().css({padding: '22px 10px'});
		});
	});
	
	$('.ac_results').live('mouseup', function(e) {
		$('#search_city_name').text($('.ac_over').text().split(',')[0]);
	})
	
	$('div#list_of_places').sortable({
	          'update': function(event,ui){
	                          var info = $('div#list_of_places').sortable('serialize');
	                          $.ajax({
	                                 type: 'POST',
	                                 url: '<?php echo url_for('list/order'); ?>',
	                                 data: info,
	                                 success:function(str){
	                                    $('#status').html(str);
	                                 }
	                              })
	                   }
	   });
})
<?php if (!$form->getObject()->isNew()):?>
$(document).ready(function(){
  $('#list_of_places').css('cursor', 'move');
  $('body').bind('click', function(e) {
	    if($(e.target).closest('#dropdown_search').length == 0) {
	    	$("#PlacesList").css('display', 'none');
	    }
	});
  $('#PlacesList > div').tinyscrollbar({size: 120});

  $('#form_close').click(function() {
	  $("#PlacesList").css('display', 'none');
  });
  
  $('#search_place').keyup (function(){
	  //console.log($('#list_location_id').val());
	  var values = $(this).val();
	  var cityId = $('#list_location_id').val();
	  var listId = <?php echo $form->getObject()->getId() ?>;
	  $('.viewport').css({height: '138px'});
	  if(values.length > 2){
		  $("#PlacesList").css("display", "block");
    	$.ajax({
			url: '<?php echo url_for("list/getPage") ?>',
				data: {'place': values, 'listId': listId, 'cityId': cityId},
			success: function(data, url) {
				$("#PlacesList .overview").html(data);
				$("#PlacesList .overview div div a").each(function() {
					$(this).html($(this).html().replace(values, '<span>' + values + "</span>"));
				});
				
				$("#PlacesList > div").tinyscrollbar_update();
				if ($('#PlacesList .overview').outerHeight() < $('#PlacesList .viewport').outerHeight()) {
					$('#PlacesList .viewport').css('height', $('#PlacesList .overview').outerHeight());
					$('#PlacesList').css('height', 'auto');
				}
		    },
		    error: function(e, xhr)
		    {
		        console.log(xhr);
		    }
		});
	  }
	  else{
		  $("#PlacesList").css("display", "none");
		  }
  });
});
<?php endif;?>
</script>
