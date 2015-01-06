<div class="menu-form">
	<form id="cs-form" action="<?php echo url_for('companySettings/menu?slug='.$company->getSlug()) ?>" enctype="multipart/form-data" method="post">
		<?php 
			echo $form['_csrf_token']->render(); 
			echo $form['id']->render(); 
			echo $form->renderGlobalErrors();
		?>
		<div class="form_box <?php echo $form['name']->hasError() ? 'error': ''; ?>">
			<?php 
				echo $form['name']->renderLabel();
				echo $form['name']->render();
				echo $form['name']->renderError();
			?>
		</div>
            <?php 
				$menu = $company->getFirstMenu();
				if ($menu) {
					echo __("Current file", null, 'form') . ": " . $menu->getDownloadLink($menu->getFilename(), 'target = "_blank"');
				}
            ?>
            <?php if ($menu): ?>
                <a class="list_delete button_pink" href="<?php echo url_for('companySettings/deleteMenu?id=' . $menu->getId()) ?>"><?php echo __('delete') ?></a>
            <?php endif; ?> 
		<div class="form_box upload<?php echo $form['name']->hasError() ? 'error': ''; ?>" style="width:273px;">
                     <?php
				echo $form['file']->renderLabel();
				echo $form['file']->render();
				echo $form['file']->renderError();
			?>
                     <ul class="error_listMenu " style="display:none;"></ul>
		</div>
                 <?php echo $form['_csrf_token']->render()?>
		<div class="form_box">
	      <input type="submit"  value="<?php echo __('Save', null, 'messages'); ?>" class="input_submit" />
	    </div>
        </form>
<div id="dialog-confirm-delete" title="<?php echo __('Delete file', null, 'messages') ?>" style="display:none;">
        <p><?php echo __('Are you sure you want to delete the current file?', null, 'messages') ?></p>
</div>    
<script type="text/javascript">
$(document).ready(function () {
    $( ".menu-form form" ).validate({
      errorContainer:"ul.error_list",
      errorElement: "li",
      rules: {
       'menu[file]': {
          required: true,
          extension: "pdf"
        }

      },
       messages:{
            'menu[file]': {required: '<?php echo __('The field is mandatory', null, 'form'); ?>',  
                           extension: '<?php echo __('Accepts pdf files only', null, 'form'); ?>'}  
        },  
      errorPlacement: function ($error, $element) {
            $(".error_list").show();
            $(".error_list").append($error);
        },
        success: function(element) {
				element
				.addClass('valid')
				.closest('.control-group').removeClass('error').addClass('success');
			}
        });
        
 
        $('a.list_delete').click(function(event) {
            var deleleReviewLink = $(this).attr('href');
            $("#dialog-confirm-delete").data('id', deleleReviewLink).dialog('open');       
            return false;        
    
        });
/*END Delete review */  


    $("#dialog-confirm-delete").dialog({
        
        resizable: false,
        autoOpen: false,
        height: 250,
        width:340,
        buttons: {
            "<?php echo __('delete', null) ?>": function() {
                 window.location.href =  $("#dialog-confirm-delete").data('id');
            },
		    <?php echo __('cancel', null) ?>: function() {
			    $(this).dialog("close");
			}
		}
	});
 
    });

</script>
</div>