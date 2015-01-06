<?php slot('no_map', true) ?>
<div class="settings_content">
  <h2><?php echo __('Account Settings')?></h2>

  <form action="<?php echo url_for('userSettings/index') ?>" method="post">

    <?php echo $form[$form->getCSRFFieldName()]; ?>
    <div class="form_wrap two_fields">
	    <div class="form_box <?php echo $form['sf_guard_user']['first_name']->hasError()? 'error': ''?>">
	      <?php echo $form['sf_guard_user']['first_name']->renderLabel() ?>
	      <?php echo $form['sf_guard_user']['first_name']->render() ?>
	      <?php echo $form['sf_guard_user']['first_name']->renderError() ?>
	    </div>

	    <div class="form_box <?php echo $form['sf_guard_user']['last_name']->hasError()? 'error': ''?>">
	      <?php echo $form['sf_guard_user']['last_name']->renderLabel() ?>
	      <?php echo $form['sf_guard_user']['last_name']->render() ?>
	      <?php echo $form['sf_guard_user']['last_name']->renderError() ?>
	    </div>
	    <div class="clear"></div>
    </div>

	<div class="form_wrap two_fields">
	    <div class="form_box <?php echo $form['country_id']->hasError()? 'error': ''?>">
	        <?php echo $form['country_id']->renderLabel() ?>
	        <?php echo $form['country_id']->render();?>
	        <?php echo $form['country_id']->renderError();?>
	    </div>

	    <div class="cityField form_box <?php echo $form['city_id']->hasError()? 'error': ''?>" style="display: block">
	      <?php echo $form['city_id']->renderLabel() ?>
	      <?php echo $form['city_id']->render() ?>
	      <?php echo $form['city_id']->renderError() ?>
	    </div>
	    <div class="clear"></div>
    </div>

    <div class="form_wrap three_fields">
	    <?php if (isset($form['gender'])) : ?>
	        <div class="form_box <?php echo $form['gender']->hasError()? 'error': ''?>">
	          <?php echo $form['gender']->renderLabel() ?>
	          <?php echo $form['gender']->render() ?>
	          <?php echo $form['gender']->renderError() ?>
	        </div>
	    <?php endif; ?>

	    <div class="form_box <?php echo $form['birthdate']->hasError()? 'error': ''?>">
	      <?php echo $form['birthdate']->renderLabel() ?>
	      <?php echo $form['birthdate']->render() ?>
	      <?php echo $form['birthdate']->renderError() ?>
	    </div>
	    <div class="clear"></div>
    </div>


    <div class="additional_info_gray_bg">
    	<div class="form_wrap three_long_fields">
		    <div class="form_box <?php echo $form['phone_number']->hasError()? 'error': ''?>">
		      <?php echo $form['phone_number']->renderLabel() ?>
		      <?php echo $form['phone_number']->render() ?>
		      <?php echo $form['phone_number']->renderError() ?>
                      <a class="tip">
                         <span class="details"><?php echo __('The correct format to use is 023456789 or for mobile phones 0888888888. Add only the local area code for landlines. Only add digits – any other characters or spaces between characters are not allowed.', null, 'company') ?></span>
                       </a>
		    </div>
		    <div class="form_box <?php echo $form['website']->hasError()? 'error': ''?>">
		      <?php echo $form['website']->renderLabel() ?>
		      <?php echo $form['website']->render() ?>
		      <?php echo $form['website']->renderError() ?>
		    </div>
		    <div class="form_box blog <?php echo $form['blog_url']->hasError()? 'error': ''?>">
		      <?php echo $form['blog_url']->renderLabel() ?>
		      <?php echo $form['blog_url']->render() ?>
		      <?php echo $form['blog_url']->renderError() ?>
		    </div>
		    <div class="clear"></div>
	    </div>

	    <div class="form_box <?php echo $form['summary']->hasError()? 'error': ''?>">
	      <?php echo $form['summary']->renderLabel() ?>
	      <?php echo $form['summary']->render() ?>
	      <?php echo $form['summary']->renderError() ?>
	    </div>

    	<div class="company_details">
	    	<div class="company_settings_social">
			    <div class="form_box <?php echo $form['facebook_url']->hasError()? 'error': ''?>">
			      <?php //echo $form['facebook_url']->renderLabel() ?>
			      <?php echo $form['facebook_url']->render() ?>
			      <?php echo $form['facebook_url']->renderError() ?>
			    </div>

				  <div class="form_box <?php echo $form['twitter_url']->hasError()? 'error': ''?>">
			      <?php //echo $form['twitter_url']->renderLabel() ?>
			      <?php echo $form['twitter_url']->render() ?>
			      <?php echo $form['twitter_url']->renderError() ?>
			    </div>
			    <div class="form_box <?php echo $form['google_url']->hasError()? 'error': ''?>">
			      <?php //echo $form['google_url']->renderLabel() ?>
			      <?php echo $form['google_url']->render() ?>
			      <?php echo $form['google_url']->renderError() ?>
			    </div>
			    <div class="clear"></div>
		    </div>
	    </div>
    </div>

    <div class="form_box company_details">
      <input type="submit" value="<?php echo __('Save')?>" class="button_green" />
      <div class="clear"></div>
    </div>

  </form>
<?php // echo link_to(__('Deactivate your getlokal account'), 'userSettings/deactivateAccount', array('confirm'=> __('Confirm getlokal account deactivation'), 'class' => 'button_pink')); ?>

</div>
<script type="text/javascript">
	$(document).ready(function() {
            $('.path_wrap').css('display', 'none');
//            $('.search_bar').css('display', 'none');
            $(".banner").css("display", "none");

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

            $("#autocomplete_user_profile_country_id").live('keyup', function(event){
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

                            if (response.countryId != null && response.countryId != undefined && response.countryId > 0) {
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
                if (countryId > 0) {
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

                        if (response.countryId != null && response.countryId != undefined && response.countryId >=0 && response.countryId <=4 || response.countryId == 78 || response.countryId == 63 || response.countryId == 202 || response.countryId == 104 || response.countryId == 180 ) {
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
