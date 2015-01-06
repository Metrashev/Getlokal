<div class="default-form-wrapper embedded">
    <div class="embeded-form-container">
        <form id="imgCompanyForm" action="<?php echo url_for('company/addImage?id='. $company->getId()) ?>" method="post" enctype="multipart/form-data">

            <div class="row">
                <div class="col-sm-12">
                    <h2 class="form-title">
                    <?php echo __('Add Photo', null, 'company')?>
                    <button type="button" class="close" onclick="$('.add_photo_content').html('')"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </h2>
                    
                    <?php echo $form['_csrf_token']->render() ?>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-12">
                    <div class="file-input-wrapper <?php echo $form['file']->hasError() ? 'incorrect' : '' ?>">
                        <label for="fileUpload" class="file-label">
                            <?php echo __('No File chosen', null, 'form'); ?>
                            <?php echo $form['file']->render(array('id' => 'fileUpload', 'class' => 'file-input')) ?>
                        </label>
                        <div class="error-txt"><?php echo $form['file']->renderError() ?></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="default-input-wrapper<?php echo $form['caption']->hasError() ? ' incorrect' : '' ?>">
                        <?php echo $form['caption']->renderLabel(null, array('class' => 'default-label')) ?>
                        <?php echo $form['caption']->render(array('class' => 'default-input')); ?>
                        <div class="error-txt"><?php echo $form['caption']->renderError() ?></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-3">  
                    <div class="add-image-loader"></div>
                </div>
                <div class="col-sm-9">
                    <input type="submit" value="<?php echo __('Save'); ?>" class="default-btn success pull-right " />
                </div>
            </div>

        </form>
    </div>
</div>

<?php //if (isset($ajaxValidation) && $ajaxValidation) : ?>
    <script type="text/javascript">

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
                    $('#imgCompanyForm div.file-input-wrapper').removeClass('error');
                    $('#imgCompanyForm div.error-txt').remove();
                    $('.add-image-loader').html(LoaderHTML);
                },

                success: function(data)
                {
                    if (data.error == true) {
                        $.each(data.errors, function(field, error) {
                            var elem = $('#imgCompanyForm').find('input[name^="image[' + field + ']"]');
                            elem.closest('div.file-input-wrapper').addClass('incorrect');
                            var errorList = '<div class="error-txt"><ul class="error_list">';
                            // $.each(error, function(errorKey, errorVal) {
                                errorList += '<li>' + error + '</li>';
                            // });
                            errorList += '</ul></div>';
                            $('.filename').html('');
                            elem.after(errorList);
                            $('.add-image-loader').html('');
                        });
                    }

                    if (data.success == true) {

                        // $.ajax({
                        //     url: "<?php echo url_for($company->getUri(ESC_RAW), true);?>",
                        //     cache: false,
                        //     success: function(content) {
                        //         $("body").html(content);
                        //     }
                        // });
                        
                        // $("#imgCompanyForm").prepend("<div class=\"form-message success\"><?php echo __('The photo was published successfully.') ?></div>");
                        // $(".form-message").fadeOut(8000);

                        window.location=data.redirectURL;
                    }
                }
            });

            return false;
        });
    </script>
<?php //endif; ?>