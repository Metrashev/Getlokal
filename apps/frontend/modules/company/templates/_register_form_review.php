<?php if(!empty($with_form)):?>
<form method="post" class="default-form clearfix">
	<?php endif; ?>
	<?php echo $formRegister[$formRegister->getCSRFFieldName()]; ?>
	<div class="row">
		<div class="col-sm-12">
			<h2 class="form-title">
				<?php echo __('Register'); ?>
				<button type="button" class="close" onclick="$('#buttons_login_form').hide();$('.login_form_wrap').hide()"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			</h2>
		</div>
	</div>
	<?php if($formRegister['underage']->hasError() || $formRegister['accept']->hasError()):?>
	<div class="form-message error" style="overfolw: auto;">
		<?php echo $formRegister['underage']->renderError();?>
		<?php echo $formRegister['accept']->renderError();?>
	</div>
	<?php endif;?>
	<div class="row">
		<div class="col-sm-6">
			<div class="default-input-wrapper required<?php if($formRegister['sf_guard_user']['first_name']->hasError()):?> incorrect<?php endif;?>">
				<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
				<?php if($formRegister['sf_guard_user']['first_name']->hasError()):?>
				<div class="error-txt">
					<?php echo $formRegister['sf_guard_user']['first_name']->renderError();?>
				</div>
				<?php endif;?>
				<label for="<?= $formRegister['sf_guard_user']['first_name']->getName()?>" class="default-label"><?php echo __('Name',null,'user')?>
				</label>
				<?php echo $formRegister['sf_guard_user']['first_name']->render(array('class'=>'default-input','placeholder'=>__('Name',null,'user')));?>
			</div>
		</div>
	
		<div class="col-sm-6">
			<div class="default-input-wrapper required<?php if($formRegister['sf_guard_user']['last_name']->hasError()):?> incorrect<?php endif;?>">
				<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
				<?php if($formRegister['sf_guard_user']['last_name']->hasError()):?>
				<div class="error-txt">
					<?php echo $formRegister['sf_guard_user']['last_name']->renderError();?>
				</div>
				<?php endif;?>
				<label for="<?= $formRegister['sf_guard_user']['last_name']->getName()?>" class="default-label"><?php echo __('Surname',null,'user')?>
				</label>
				<?php echo $formRegister['sf_guard_user']['last_name']->render(array('class'=>'default-input','placeholder'=>__('Surname',null,'user')));?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6">
			<div class="default-input-wrapper required<?php if($formRegister['sf_guard_user']['email_address']->hasError()):?> incorrect<?php endif;?>">
				<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
				<?php if($formRegister['sf_guard_user']['email_address']->hasError()):?>
				<div class="error-txt">
					<?php echo $formRegister['sf_guard_user']['email_address']->renderError();?>
				</div>
				<?php endif;?>
				<label for="<?= $formRegister['sf_guard_user']['email_address']->getName()?>" class="default-label"><?php echo __('Email',null,'user')?>
				</label>
				<?php echo $formRegister['sf_guard_user']['email_address']->render(array('class'=>'default-input','placeholder'=>__('Email',null,'user')));?>
			</div>
		</div>
	
		<div class="col-sm-6">
			<div class="default-input-wrapper required<?php if($formRegister['sf_guard_user']['password']->hasError()):?> incorrect<?php endif;?>">
				<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
				<?php if($formRegister['sf_guard_user']['password']->hasError()):?>
				<div class="error-txt">
					<?php echo $formRegister['sf_guard_user']['password']->renderError();?>
				</div>
				<?php endif;?>
				<label for="<?= $formRegister['sf_guard_user']['password']->getName()?>" class="default-label"><?php echo __('Password',null,'user')?>
				</label>
				<?php echo $formRegister['sf_guard_user']['password']->render(array('class'=>'default-input','placeholder'=>__('Password',null,'user')));?>
			</div>
		</div>
	</div>


	<?php if (isset($formRegister['gender'])) : ?>
	<div class="form_box<?php if($formRegister['gender']->hasError()):?> error<?php endif;?>">
		<label for="<?= $formRegister['gender']->getName()?>"><?php echo __('Gender',null,'user')?><span class="pink">*</span>:</label>
		<?php echo $formRegister['gender']->render();?>
		<?php if($formRegister['gender']->hasError()):?>
		<p class="error">
			<?php echo $formRegister['gender']->renderError();?>
		</p>
		<?php endif;?>
	</div>
	<?php endif; ?>

	<div class="row">
		<div class="col-sm-6">
			<div class="default-input-wrapper required<?php if($formRegister['country_id']->hasError()):?> incorrect<?php endif;?>">
				<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
				<?php if($formRegister['country_id']->hasError()):?>
				<div class="error-txt">
					<?php echo $formRegister['country_id']->renderError();?>
				</div>
				<?php endif;?>
				<label for="<?= $formRegister['country_id']->getName()?>" class="default-label"><?php echo __('Country',null,'user')?>
				</label>
				<?php echo $formRegister['country_id']->render(array('class'=>'default-input','placeholder'=>__('Country',null,'user')));?>
			</div>
		</div>
	
		<div class="col-sm-6">
			<div class="default-input-wrapper required<?php if($formRegister['city_id']->hasError()):?> incorrect<?php endif;?>">
				<div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
				<?php if($formRegister['city_id']->hasError()):?>
				<div class="error-txt">
					<?php echo $formRegister['city_id']->renderError();?>
				</div>
				<?php endif;?>
				<label for="<?= $formRegister['city_id']->getName()?>" class="default-label"><?php echo __('Location',null,'user')?>
				</label>
				<?php echo $formRegister['city_id']->render(array('class'=>'default-input','placeholder'=>__('Location',null,'user')));?>
			</div>
		</div>
	</div>

	<div class="custom-row m-10">
		<div class="default-checkbox">
			<?= $formRegister['accept']->render(array('class' => 'input_check'));?>
			<div class="fake-box"></div>
		</div>
		<label for="<?= $formRegister['accept']->getName()?>" class="default-checkbox-label">
			<?= sprintf(__('I agree with the %s and the %s'),  link_to(__('Terms of Use'), '@static_page?slug=terms-of-use',array('popup'=>true, 'class'=>'default-link') ), link_to (__('Policy for Use and Protection of the Information of Getlokal'), '@static_page?slug=privacy-policy',array('popup'=>true, 'class'=>'default-link')));?>
		</label>
	</div>

	<div class="custom-row m-10">
		<div class="default-checkbox">
			<?= $formRegister['allow_contact']->render(array('class' => 'input_check'));?>
			<div class="fake-box"></div>
		</div>
		<label for="<?= $formRegister['allow_contact']->getName()?>" class="default-checkbox-label">
			<?= __('I agree to receive messages from getlokal and/or their partners.',null,'user');?>
		</label>
	</div>

	<?php if (isset($formRegister['underage'])) : ?>
	<?php echo __('If you are underage person, your parent/trustee must also declare his/her consent below');?>

	<div class="custom-row m-10">
		<div class="default-checkbox">
			<?= $formRegister['underage']->render(array('class' => 'input_check'));?>
			<div class="fake-box"></div>
		</div>
		<label for="<?= $formRegister['underage']->getName()?>" class="default-checkbox-label"> 
			<?= sprintf(__('In my capacity as parent/trustee I hereby declare that I agree with the %s and the %s'),  link_to(__('Terms of Use'), '@static_page?slug=terms-of-use',array('popup'=>true,'class'=>'default-link') ), link_to (__('Policy for Use and Protection of the Information of Getlokal'), '@static_page?slug=privacy-policy',array('popup'=>true,'class'=>'default-link')))?>
		</label>
		
	</div>
	<?php endif; ?>

	<div class="login_more">
		<input type="submit" class="default-btn success pull-right m-10" value="<?php echo __('Register');?>" />
	</div>

	<script type="text/javascript">
  $('input').each(function(index) {
    if (!($(this).hasClass('star')))
    {
      //$(this).ezMark();
    }
  });
  $('.login_pos').click(function() {
      //var element = this;
      $.ajax({
          url: this.href,
          beforeSend: function() {
            $('.login_form_wrap').html('loading...');
          },
          success: function(data, url) {
            $('.login_form_wrap').html(data);
            loading = false;
            //console.log(id);
          },
          error: function(e, xhr)
          {
            console.log(e);
          }
      });
      return false;
    });



            $(document).ready(function() {
                /*
                // For autocomplete cities - set country
                $("#autocomplete_user_profile_country_id").live('keyup', function(){
                    setCountry();
                });

                $("#autocomplete_user_profile_country_id").focusout(function() {
                    setCountry();
                });

                $("#autocomplete_user_profile_city_id").live('keydown', function(){
                    setCountry();
                });
                */

                $("#autocomplete_user_profile_country_id").on('keyup', function(event){
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
                <?php if ($formRegister->hasErrors() || $formRegister->hasGlobalErrors()) : ?>
                    // do something special here
                <?php else : ?>
                    getCountryAndCity();
                <?php endif; ?>
            });

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

                                if (response.countryId != null && response.countryId != undefined && response.countryId > 0 && (response.countryId <= 4 || response.countryId == 78)) {
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
                    if (countryId > 0 && (countryId <= 4 || countryId == 78)) {
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

                            if (response.countryId != null && response.countryId != undefined && response.countryId > 0 && (response.countryId <= 4 || response.countryId == 78)) {
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
	<?php if(!empty($with_form)):?>
</form>
<?php endif; ?>