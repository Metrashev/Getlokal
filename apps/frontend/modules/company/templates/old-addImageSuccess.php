<form id="imgCompanyForm" action="<?php echo url_for('company/addImage?id='. $company->getId()) ?>" method="post" enctype="multipart/form-data">
	<h2><?php echo __('Add Photo', null, 'company')?></h2>
	<?php echo $form['_csrf_token']->render() ?>
    <div class="form_box <?php echo $form['file']->hasError()? 'error': '' ?>">
      <?php echo $form['file']->renderLabel() ?>
      <?php echo $form['file']->render(array('class' => 'image_title')) ?>
      <?php echo $form['file']->renderError() ?>
    </div>
    
    <div class="form_box <?php echo $form['caption']->hasError()? 'error': '' ?>">
      <?php echo $form['caption']->renderLabel() ?>
      <?php echo $form['caption']->render() ?>
      <?php echo $form['caption']->renderError() ?>
    </div>
    
    <div class="form_box">
		<input type="submit" value="<?php echo __('Save', null, 'messages'); ?>" class="button_green" />
    </div>
</form>

<?php if (isset($ajaxValidation) && $ajaxValidation) : ?>
    <script type="text/javascript">
        $(function() {

            $.fn.serializefiles = function() {
                var obj = $(this);

                var formData = new FormData();
                $.each($(obj).find('input[name^="image[file]"]'), function(i, tag) {
                    $.each($(tag)[0].files, function(i, file) {
                        formData.append(tag.name, file);
                    });
                });

                var params = $(obj).serializeArray();
                $.each(params, function (i, val) {
                    formData.append(val.name, val.value);
                });

                return formData;
            };


            $('#imgCompanyForm').submit('live', function() {
                <?php /*
                var files = new FormData($('input[name^="image[file]"]'));     
                $.each($('input[name^="image[file]"]')[0].files, function(i, file) {
                    files.append(i, file);
                });
                */ ?>

                $.ajax({
                    type: "POST",
                    cache: false,
                    contentType: false,
                    processData: false,
                    url: $(this).attr('action'),
                    data: $(this).serializefiles(), //$(this).serialize(), files,
                    dataType: 'json',

                    beforeSend: function() {
                        $('#imgCompanyForm div.form_box').removeClass('error');
                        
                        $('#imgCompanyForm ul.error_list').remove();
                    },

                    success: function(data)
                    {
                        if (data.error == true) {
                            $.each(data.errors, function(field, error) {
                                var elem = $('#imgCompanyForm').find('input[name^="image[' + field + ']"]');
                                elem.closest('div.form_box').addClass('error');

                                var errorList = '<ul class="error_list">';

                                $.each(error, function(errorKey, errorVal) {
                                    errorList += '<li>' + errorVal + '</li>';
                                });

                                errorList += '</ul>';

                                elem.after(errorList);
                            });
                        }

                        if (data.success == true) {
                            window.location=data.redirectURL;
                        }
                    }
                });

                return false;
            });
        });
    </script>
<?php endif; ?>