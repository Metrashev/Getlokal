<?php include_partial('global/commonSlider'); ?>

<div class="container set-over-slider">
        <div class="row">   
            <div class="container">
                <div class="row">
                    <h1 class="col-xs-12 main-form-title"><?php echo __('Sign in via Facebook', null, 'user');?></h1>
                </div>
            </div>            
        </div>
        <form action="<?php echo url_for('@facebook_confirm_registration')?>" method="post">
            <div class="row">
                <div class="default-container default-form-wrapper col-sm-12">  
                    <?php echo $form[$form->getCSRFFieldName()]; ?>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="default-input-wrapper required <?php if( $form['sf_guard_user']['first_name']->hasError()):?> incorrect<?php endif;?>">
                                <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                                <div class="error-txt">
                                <?php if($form['sf_guard_user']['first_name']->hasError()):?>
                                    <?php echo $form['sf_guard_user']['first_name']->renderError();?>
                                <?php endif;?>
                                </div>
                                <label for="<?= $form['sf_guard_user']['first_name']->getName()?>" class="default-label"><?= __('Name', null, 'user')?></label>
                                <?php echo $form['sf_guard_user']['first_name']->render(array('class' => 'default-input','placeholder' => __('Name', null, 'user')));?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="default-input-wrapper required <?php if( $form['sf_guard_user']['last_name']->hasError()):?> incorrect<?php endif;?>">
                                <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                                <div class="error-txt">
                                <?php if($form['sf_guard_user']['last_name']->hasError()):?>
                                    <?php echo $form['sf_guard_user']['last_name']->renderError();?>
                                <?php endif;?>
                                </div>
                                <label for="<?= $form['sf_guard_user']['last_name']->getName()?>" class="default-label"><?= __('Surname', null, 'user')?></label>
                                <?php echo $form['sf_guard_user']['last_name']->render(array('class' => 'default-input','placeholder' => __('Surname', null, 'user')));?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="default-input-wrapper required <?php if( $form['sf_guard_user']['email_address']->hasError()):?> incorrect<?php endif;?>">
                                <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                                <div class="error-txt">
                                <?php if($form['sf_guard_user']['email_address']->hasError()):?>
                                    <?php echo $form['sf_guard_user']['email_address']->renderError();?>
                                <?php endif;?>
                                </div>
                                <label for="<?= $form['sf_guard_user']['email_address']->getName()?>" class="default-label"><?= __('Email', null, 'user')?></label>
                                <?php echo $form['sf_guard_user']['email_address']->render(array('class' => 'default-input','placeholder' => __('Email', null, 'user')));?>
                            </div>
                        </div>
                    </div>
        
                    <?php if (isset($form['gender'])) : ?>
                        <div class="form_box<?php if ($form['gender']->hasError()): ?> error<?php endif; ?>">
                            <label><?php echo __('Gender', null, 'user') ?><span class="pink">*</span>:</label>
                            <?php echo $form['gender']->render(); ?>
                            <?php if ($form['gender']->hasError()): ?>
                                <p class="error"><?php echo $form['gender']->renderError(); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="default-input-wrapper required<?php if($form['country_id']->hasError()):?> incorrect<?php endif;?>">
                                <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                                <?php if($form['country_id']->hasError()):?>
                                <div class="error-txt">
                                    <?php echo $form['country_id']->renderError();?>
                                </div>
                                <?php endif;?>
                                <label for="<?= $form['country_id']->getName()?>" class="default-label"><?php echo __('Country',null,'user')?>
                                </label>
                                <?php echo $form['country_id']->render(array('class'=>'default-input','placeholder'=>__('Country',null,'user')));?>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="default-input-wrapper required<?php if($form['city_id']->hasError()):?> incorrect<?php endif;?>">
                                <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
                                <?php if($form['city_id']->hasError()):?>
                                <div class="error-txt">
                                    <?php echo $form['city_id']->renderError();?>
                                </div>
                                <?php endif;?>
                                <label for="<?= $form['city_id']->getName()?>" class="default-label"><?php echo __('Location',null,'user')?>
                                </label>
                                <?php echo $form['city_id']->render(array('class'=>'default-input','placeholder'=>__('Location',null,'user')));?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="custom-row">
                        <div class="default-checkbox">
                            <?= $form['accept']->render(array('class' => 'input_check', 'id' => 'accept'));?>
                            <div class="fake-box"></div>
                        </div>
                        <label for="accept" class="default-checkbox-label">
                            <?= sprintf(__('I agree with the %s and the %s'),  link_to(__('Terms of Use'), '@static_page?slug=terms-of-use',array('popup'=>true,'class' => 'default-form-link') ), link_to(__('Policy for Use and Protection of the Information on the Getlokal Website'),  '@static_page?slug=privacy-policy',array('popup'=>true,'class' => 'default-form-link')));?>
                        </label>
                    </div>
                    
                    <?php if (isset($formRegister['underage'])) : ?>
                    <?php echo __('If you are underage person, your parent/trustee must also declare his/her consent below');?>
                
                    <div class="custom-row">
                        <div class="default-checkbox">
                            <?= $formRegister['underage']->render(array('class' => 'input_check'));?>
                            <div class="fake-box"></div>
                        </div>
                        <label for="<?= $formRegister['underage']->getName()?>" class="default-checkbox-label"> 
                            <?= sprintf(__('In my capacity as parent/trustee I hereby declare that I agree with the %s and the %s'),  link_to(__('Terms of Use'), '@static_page?slug=terms-of-use',array('popup'=>true) ), link_to (__('Policy for Use and Protection of the Information on the Getlokal Website'), '@static_page?slug=privacy-policy',array('popup'=>true)))?>
                        </label>
                        
                    </div>
                    <?php endif; ?>
                    
                    <div class="form_box">
                        <input type="submit" value="<?php echo __('Confirm')?>" class="default-btn success" />
                    </div>
                </div>
            </div>
        </form>
</div>

<script type="text/javascript">
    // $(document).ready(function() {

        $("#autocomplete_user_profile_country_id").keyup(function(event){
            if (event.keyCode != 16 && event.keyCode != 17 && event.keyCode != 18 && event.keyCode != 19 && event.keyCode != 20 && event.keyCode != 27 && event.keyCode != 112
            && event.keyCode != 113 && event.keyCode != 114 && event.keyCode != 115 && event.keyCode != 116 && event.keyCode != 117 && event.keyCode != 118
            && event.keyCode != 119 && event.keyCode != 120 && event.keyCode != 121 && event.keyCode != 122 && event.keyCode != 123 && event.keyCode != 44 && event.keyCode != 145 && event.keyCode != 20
            && event.keyCode != 91 && event.keyCode != 93 && event.keyCode != 34 && event.keyCode != 35 && event.keyCode != 36 && event.keyCode != 37 && event.keyCode != 38 && event.keyCode != 39 && event.keyCode != 40 && event.keyCode != 45 && event.keyCode != 46 && event.keyCode != 20
            && event.keyCode != 9) {
                $("#user_profile_country_id").val('');

                //$(".cityField").hide();
                $("#autocomplete_user_profile_city_id").val('');
                $("#user_profile_city_id").val('');
            }
        });

        $( "#autocomplete_user_profile_country_id" ).autocomplete({
            change: function( event, ui ) {
                setCountry();
            },

            select: function( event, ui ) {
                var id = ui.item.id;
                var value = ui.item.value;

                setCountry(id, value);
            }
        });

        // Get country
        <?php if ($form->hasErrors() || $form->hasGlobalErrors()) : ?>
            // do something special here
        <?php else : ?>
            getCountryAndCity();
        <?php endif; ?>
    // });

    function getCountryAndCity() {
        var countryId = $("#user_profile_country_id").val();
        var countryName = $("#autocomplete_user_profile_country_id").val();

        if (countryId) {
            $.ajax({
                type: 'POST',
                url: '<?php echo url_for('@user_set_country') ?>',
                //data: {countryId: countryId },
                data: {countryName: countryName},
                dataType: 'json', //text

                // callback handler that will be called on success
                success: function(response, textStatus, jqXHR) {
                    // log a message to the console
                    if (response.success == true && response.resetCity == true) {
                        //$("#autocomplete_user_profile_city_id").val('');
                        //$("#user_profile_city_id").val('');

                        if (response.countryId != null && response.countryId != undefined && response.countryId > 0 && response.countryId <= 4) {
                            countryId = response.countryId;
                        }
                        else {
                            countryId = null;
                        }
                    }
                },
                // callback handler that will be called on error
                error: function(jqXHR, textStatus, errorThrown) {
                    // log the error to the console
                    //console.log("The following error occured: " + textStatus, errorThrown);
                },
                // callback handler that will be called on completion
                // which means, either on success or error
                complete: function(){
                }
            });

            // If is not Bulgaria, Romania, Serbia and Macedonia
            if (countryId > 0 && countryId <= 4) {
                $(".cityField").show();
            }
            else {
                $(".cityField").hide();
                $("#autocomplete_user_profile_city_id").val('');
                $("#user_profile_city_id").val('');
            }
        }
    }

    function setCountry(cId, cName) {
        var countryId = countryName = null;

        if (cId && cName) {
            countryId = cId;
            countryName = cName;
        }
        else {
            countryId = $("#user_profile_country_id").val();
            countryName = $("#autocomplete_user_profile_country_id").val();
        }

        $.ajax({
            type: 'POST',
            url: '<?php echo url_for('@user_set_country') ?>',
            //data: {countryId: countryId },
            data: {countryName: countryName},
            dataType: 'json', //text

            // callback handler that will be called on success
            success: function(response, textStatus, jqXHR) {
                // log a message to the console
                if (response.success == true && response.resetCity == true) {
                    $("#autocomplete_user_profile_city_id").val('');
                    $("#user_profile_city_id").val('');

                    if (response.countryId != null && response.countryId != undefined && response.countryId > 0 && response.countryId <= 4) {
                        $(".cityField").show();
                    }
                    else {
                        $(".cityField").hide();
                        $("#autocomplete_user_profile_city_id").val('');
                        $("#user_profile_city_id").val('');
                    }

                    if (response.countryId != null && response.countryId != undefined) {
                        $('#user_profile_country_id').val(response.countryId);
                        $('#autocomplete_user_profile_country_id').val(countryName);
                    }
                }
            },
            // callback handler that will be called on error
            error: function(jqXHR, textStatus, errorThrown) {
                // log the error to the console
                //console.log("The following error occured: " + textStatus, errorThrown);
            },
            // callback handler that will be called on completion
            // which means, either on success or error
            complete: function(){
            }
        });
    }
</script>
