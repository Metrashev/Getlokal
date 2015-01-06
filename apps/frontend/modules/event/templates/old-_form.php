<?php use_stylesheets_for_form($form) ?>
<?php use_stylesheet('ui-lightness/jquery-ui-1.8.16.custom.css'); ?>
<?php use_javascript('jquery.ui.dialog.js'); ?>
<?php use_javascript('jquery-ui-i18n-'.mb_convert_case(getlokalPartner::getLanguageClass(), MB_CASE_LOWER,'UTF-8').'.js'); ?>
<?php //use_javascripts_for_form($form) ?>
 <?php if($sf_user->getFlash('newsuccess')):?>   
    <div class="flash_success">
      <?php echo  __($sf_user->getFlash('newsuccess'),null,'events') ?>
      <a></a>
    </div>
   <?php endif;?>
 <?php if($sf_user->getFlash('newerror')):?>   
    <div class="flash_error">
      <?php echo  __($sf_user->getFlash('newerror'),null,'events') ?>
    </div>
   <?php endif;?>
<div class="content_in">
<form id="eventForm" action="<?php echo url_for('event/'.($form->getObject()->isNew() ? 'create' : 'edit').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
	
   <?php $lng= mb_convert_case(getlokalPartner::getLanguageClass(), MB_CASE_LOWER,'UTF-8');   ?>
   <?php $tab_lng=sfConfig::get('app_cultures_en_'.$lng);?>
	<div class="form_box form_label_inline<?php if( $form[$lng]['title']->hasError()):?> error<?php endif;?> ">
		<?php echo $form[$lng]['title']->renderLabel()?>
		<?php echo '('.__($tab_lng, null, 'company').')'?><br />
		<?php echo $form[$lng]['title'] ?>
		<?php echo $form[$lng]['title']->renderError()?>
	</div>
	<div class="form_box form_label_inline<?php if( $form[$lng]['description']->hasError()):?> error<?php endif;?>">
		<?php echo $form[$lng]['description']->renderLabel()?>
		<?php echo '('.__($tab_lng, null, 'company').')'?><br />
		<?php echo $form[$lng]['description'] ?>
		<?php echo $form[$lng]['description']->renderError()?>
	</div>
	
	<div class="form_box form_label_inline<?php if( $form['en']['title']->hasError()):?> error<?php endif;?>">
		<?php echo $form['en']['title']->renderLabel()?>
		<?php echo ' ('. __('English').')'?><br />
		<?php echo $form['en']['title'] ?>
		<?php echo $form['en']['title']->renderError()?>
	</div>
		<div class="form_box form_label_inline <?php if( $form['en']['description']->hasError()):?> error<?php endif;?>">
		<?php echo $form['en']['description']->renderLabel()?>
		<?php echo ' ('. __('English').')'?><br />
		<?php echo $form['en']['description'] ?>
		<?php echo $form['en']['description']->renderError()?>
	</div>
	<div class="form_wrap">
		<div class="form_box form_box_350<?php if( $form['start_at']->hasError()):?> error<?php endif;?>">
			<?php echo $form['start_at']->renderLabel()?>
			<?php echo $form['start_at'] ?>
			<a id="event_calendar_start"></a>
			<?php echo $form['start_at']->renderError()?>
			<div class="clear"></div>
		</div>
		<div class="form_box form_box_230<?php if( $form['start_h']->hasError()):?> error<?php endif;?>">
			<?php echo $form['start_h']->renderLabel()?>
			<?php echo $form['start_h'] ?>
			<?php echo $form['start_h']->renderError()?>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="form_box<?php if( $form['end_at']->hasError()):?> error<?php endif;?>">
		<?php echo $form['end_at']->renderLabel()?>
		<?php echo $form['end_at'] ?>
		<div class="calendar_wrap"><a id="event_calendar_end"></a></div>
		<?php echo $form['end_at']->renderError()?>
		<div class="clear"></div>
	</div>
	<div class="form_box<?php if( $form['category_id']->hasError()):?> error<?php endif;?>">
		<?php echo $form['category_id']->renderLabel()?>
		<?php echo $form['category_id'] ?>
		<?php echo $form['category_id']->renderError()?>
	</div>
	<div class="form_box"<?php if( $form['location_id']->hasError()):?> error<?php endif;?>>
		<?php echo $form['location_id']->renderLabel()?>
		<?php echo $form['location_id'] ?>
		<?php echo $form['location_id']->renderError()?>
	</div>
	<div class="form_box">
	<?php echo $form['place_id']->renderLabel()?> <input id="pace" type="text" autocomplete="off"/>
	<!-- Places list -->
	<div class="list_of_places event_list_of_places">
		<?php include_component('event', 'places', array('event' => $form->getObject(), 'form' => $form)); ?>
	</div>
	<div id='PlacesList'></div>
	<!-- End of Places list -->
	</div>
	<div class="form_box"<?php if( $form['info_url']->hasError()):?> error<?php endif;?>>
		<?php echo $form['info_url']->renderLabel()?>
		<?php echo $form['info_url'] ?>
		<?php echo $form['info_url']->renderError()?>
	</div>
	<div class="form_box<?php if( $form['buy_url']->hasError()):?> error<?php endif;?>">
		<?php echo $form['buy_url']->renderLabel()?>
		<?php echo $form['buy_url'] ?>
		<?php echo $form['buy_url']->renderError()?>
	</div>
	<div class="form_box<?php if( $form['price']->hasError()):?> error<?php endif;?>">
		<?php echo $form['price']->renderLabel()?>
		<?php echo $form['price'] ?>
		<?php echo $form['price']->renderError()?>
	</div>
	<div class="form_wrap">
		<div class="form_box<?php if( $form['file']->hasError()):?> error<?php endif;?>">
			<?php echo $form['file']->renderLabel()?>
			<?php echo $form['file'] ?>
			<?php echo $form['file']->renderError()?>
		</div>
		<div class="form_box<?php if( $form['poster']->hasError()):?> error<?php endif;?>">
				<?php echo $form['poster']->renderLabel()?>
				<?php echo $form['poster'] ?>
				<?php echo $form['poster']->renderError()?>
		</div>
		<div class="clear"></div>
	</div>
	<div class="form_box<?php if( $form['caption']->hasError()):?> error<?php endif;?>">
		<?php echo $form['caption']->renderLabel()?>
		<?php echo $form['caption'] ?>
		<?php echo $form['caption']->renderError()?>
	</div>
	<div class="form_box">
		<?php if($sf_user->hasAttribute('profile.edit.event')): ?>
			<a href="<?php echo url_for('profile/events?username=' . $sf_user->getGuardUser()->getUsername()) ?>" class="button_pink"><?php echo __('Back to list',null,'messages')?></a>
			<?php $sf_user->getAttributeHolder()->remove('profile.edit.event'); ?>
		<?php else: ?>
			<a href="<?php echo url_for('event/recommended') ?>" class="button_pink"><?php echo __('Back to list',null,'messages')?></a>
		<?php endif; ?>

		<?php if (!$form->getObject()->isNew()): ?>
            <?php echo link_to(__('Delete'), 'event/delete?id='.$form->getObject()->getId(), array(/*'method' => 'delete',*/ 'class' => 'button_confirm' )) ?>
          <?php endif; ?>
		<input type="submit" value="<?php echo __('Publish',null,'messages')?>" class="button_green" />
	</div>
	<?php echo  $form->renderHiddenFields();?>
</form>
<div class="clear"></div>

<script type="text/javascript">
    $(document).ready(function(){
        $("form#eventForm").submit(function(){
          $('input').attr('readonly', true);
          $('input[type=submit]').attr("disabled", "disabled");
          $('a').unbind("click").click(function(e) {
              e.preventDefault();
          });
        });
    });
</script>

<?php if (! $form->getObject()->isNew()):?>
<div class="event_settings_content">
</div>
<div id="dialog-confirm" title="<?php echo __('Deleting Event', null, 'messages') ?>" style="display:none;">
        <p><?php echo __('Are you sure you want to delete your event?', null, 'messages') ?></p>
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
<?php endif;?>
</div>
<div class="clear"></div>
<script type="text/javascript">
	
$(document).ready(function() {
  $('#event_calendar_start').click(function() {
	console.log('test');
	$('#event_start_at').focus();
	return false;
  });
  $('#event_calendar_end').click(function() {
		console.log('test');
		$('#event_end_at').focus();
		return false;
	  });
          
             /*Delete event confirmation */
     $('a.button_confirm ').click(function() {
            var deleleEventLink = $(this).attr('href');        
            $("#dialog-confirm").dialog({
                resizable: false,
                height: 250,
                width:340,
                buttons: {
                    "<?php echo __('delete', null) ?>": function() {
                       window.location.href = deleleEventLink;
                    },
                    "<?php echo __('cancel', null) ?>": function() {
                        $(this).dialog("close");
                    }
                }
            });
            $(".ui-dialog").css("z-index", "2");
            return false;
        });
     /*END Delete event */

})

$(document).ready(function(){
  $('#pace').keyup (function(){
	 $('#PlacesList').css('display', 'block'); 
	  console.log($('#event_location_id').val());
	  var values = $(this).val();
	  var cityId = $('#event_location_id').val();
	  <?php if (!$form->getObject()->isNew()):?>
	  	var iventId = <?php echo $form->getObject()->getId() ?>;
	  <?php endif;?>
	  if(values.length > 2){
    	$.ajax({
			url: '<?php echo url_for("event/addPage") ?>',
			<?php if (!$form->getObject()->isNew()):?>
				data: {'place': values, 'eventId': iventId, 'cityId': cityId},
			<?php else:?>
				data: {'place': values, 'cityId': cityId},
			<?php endif;?>
			beforeSend: function() {
				$("#PlacesList").html('loading...');
				//$("#PlacesList").toggle();
				console.log(values+'Send');
			},
			success: function(data, url) {
				$("#PlacesList").html(data);
				//console.log('success');
		    },
		    error: function(e, xhr)
		    {
		        console.log(e);
		    }
		});
	  }
  });
});
</script>