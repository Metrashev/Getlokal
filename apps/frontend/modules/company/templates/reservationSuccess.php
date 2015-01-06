<div class="default-form-wrapper">

	<?php if ($sf_user->getFlash('newerror')) { ?>
	    <div class="form-message error">
	        <p><?php echo __($sf_user->getFlash('newerror'), null, 'company'); ?></p>
	    </div>
	<?php } ?>
	<?php if ($sf_user->getFlash('newsuccess')): ?> 
	    <div class="form-message success">
	        <p><?php echo __($sf_user->getFlash('newsuccess')) ?></p>
	    </div> 
	<?php endif; ?>

	    <form name="reservation" id="reservationForm" action="<?php url_for('company/reservation?slug='.$company->getSlug()); ?>" method="POST">

	    	<div class="row">
	    	    <div class="col-sm-12">
					<h2 class="form-title">
					<?php echo __('Reservation Request', null, 'form')?>
					<button type="button" class="close" onclick="$('.reservation_content').html('')"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					</h2>
				</div>
			</div>

		    <div class="row">
		        <div class="col-sm-6">
		            <div class="default-input-wrapper required active <?php echo $form['email']->hasError() ? 'incorrect' : '' ?>">
		                <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
		                <?php echo $form['email']->renderLabel(null, array('class' => 'default-label')) ?>
		                <?php echo $form['email']->render(array('placeholder' => __('Example@domain.com'), 'class' => 'default-input')); ?>
		                <div class="error-txt"><?php echo $form['email']->renderError() ?></div>
		            </div>
		        </div>
		        <div class="col-sm-6">
		            <div class="default-input-wrapper active <?php echo $form['name']->hasError() ? 'incorrect' : '' ?>">
		                <?php echo $form['name']->renderLabel(null, array('class' => 'default-label')) ?>
		                <?php echo $form['name']->render(array('placeholder' => __('John Doe' , null , 'company'), 'class' => 'default-input')); ?>
		                <div class="error-txt"><?php echo $form['name']->renderError() ?></div>
		            </div>
		        </div>
		    </div>

		    <div class="row">
		        <div class="col-sm-6">
		            <div class="default-input-wrapper required active <?php echo $form['phone']->hasError() ? 'incorrect' : '' ?>">
		                <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
		                <?php echo $form['phone']->renderLabel(null, array('class' => 'default-label')) ?>
		                <?php echo $form['phone']->render(array('placeholder' => __('+359 3 234 123'), 'class' => 'default-input')); ?>
		                <div class="error-txt"><?php echo $form['phone']->renderError() ?></div>
		            </div>
		        </div>
		    </div>

		    <div class="row">
		        <div class="col-sm-6">
		            <div class="default-input-wrapper required active <?php echo $form['start_date']->hasError() ? 'incorrect' : '' ?>">
		                <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
		                <?php echo $form['start_date']->renderLabel(null, array('class' => 'default-label')) ?>
		                <?php echo $form['start_date']->render(array('type' => 'text', 'id' => 'datepicker_start', 'class' => 'default-input')); ?>
		                <div class="error-txt"><?php echo $form['start_date']->renderError() ?></div>
		            </div>
		        </div>


		        <?php if($company->reservationType() == 'hotel'): ?>
		        	<div class="col-sm-6">
		                <div class="default-input-wrapper required active <?php echo $form['end_date']->hasError() ? 'incorrect' : '' ?>">
		                    <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
		                    <?php echo $form['end_date']->renderLabel(null, array('class' => 'default-label')) ?>
		                    <?php echo $form['end_date']->render(array('type' => 'text', 'id' => 'datepicker_end', 'class' => 'default-input')); ?>
		                    <div class="error-txt"><?php echo $form['end_date']->renderError() ?></div>
		                </div>
		            </div>
		        <?php elseif($company->reservationType() == 'restaurant'): ?>
		        	<div class="col-sm-4">
		                <div class="default-input-wrapper required active select-wrapper <?php echo $form['time']->hasError() ? 'incorrect' : '' ?>">
		                    <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
		                    <?php echo $form['time']->renderLabel(null, array('class' => 'default-label')) ?>
		                    <?php echo $form['time']->render(array('id' => 'hours', 'class' => 'default-input')); ?>
		                    <div class="error-txt"><?php echo $form['time']->renderError() ?></div>
		                </div>
		            </div>
		        <?php endif; ?>

		    </div>
		    
			<div class="row">
		        <div class="col-sm-5">
		            <div class="default-input-wrapper required active <?php echo $form['people']->hasError() ? 'incorrect' : '' ?>">
		                <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
		                <?php echo $form['people']->renderLabel(null, array('class' => 'default-label')) ?>
		                <?php echo $form['people']->render(array('class' => 'default-input')); ?>
		                <div class="error-txt"><?php echo $form['people']->renderError() ?></div>
		            </div>
		        </div>

		        <?php if($company->reservationType() == 'hotel'): ?>
		            <div class="col-sm-4">
		                <div class="default-input-wrapper required active <?php echo $form['nights']->hasError() ? 'incorrect' : '' ?>">
		                    <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
		                    <?php echo $form['nights']->renderLabel(null, array('class' => 'default-label')) ?>
		                    <?php echo $form['nights']->render(array('class' => 'default-input')); ?>
		                    <div class="error-txt"><?php echo $form['nights']->renderError() ?></div>
		                </div>
		            </div>
				<?php endif; ?>
		    </div>

		    <div class="row">
		        <div class="col-sm-6">
		            <div class="default-input-wrapper active <?php echo $form['about']->hasError() ? 'incorrect' : '' ?>">
		                <?php echo $form['about']->renderLabel(null, array('class' => 'default-label')) ?>
		                <?php echo $form['about']->render(array('class' => 'default-input')); ?>
		                <div class="error-txt"><?php echo $form['about']->renderError() ?></div>
		            </div>
		        </div>
		    </div>

			<?php if(sfConfig::get('app_recaptcha_active', false)): ?>
				<div class="row">
		            <div class="col-sm-12">
		                <div class="default-input-wrapper required active <?php echo $form['captcha']->hasError() ? 'incorrect' : '' ?>">
		                    <div class="required-txt"><?php echo __('Required', null, 'form'); ?></div>
		                    <div class="error-txt"><?php echo $form['captcha']->renderError() ?></div>
		                    <?php echo $form['captcha']->renderLabel(null, array('class' => 'default-label')) ?>
		                    <?php echo $form['captcha']->render(array('class' => 'default-input')); ?>
		                </div>
		            </div>
		        </div>
			<?php endif; ?>

			<div class="row">
				<div class="col-sm-3">  
                    <div class="reservation-loader"></div>
                </div>
		        <div class="col-sm-9">
		            <input type="submit" value="<?php echo __('Send', null, 'company'); ?>" class="default-btn success pull-right " />
		        </div>
		    </div>
		</form>
</div>

<?php 
	$disabledDates[] = array();
	foreach(array('sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat') as $day){
		if($company->getCompanyDetail() != null){
			if($company->getCompanyDetail()->get($day.'_from') != NULL || $company->getCompanyDetail()->get($day.'_to') != NULL){
				if($company->getCompanyDetail()->get($day.'_from') > $company->getCompanyDetail()->get($day.'_to')){
					$daysFrom[] = $company->getCompanyDetail()->get($day.'_from');
					$daysTo[] = $company->getCompanyDetail()->get($day.'_to') + 1440;
				}
				else{
					$daysFrom[] = $company->getCompanyDetail()->get($day.'_from');
					$daysTo[] = $company->getCompanyDetail()->get($day.'_to');
				}
			}
			else{
				$daysFrom[] = '0';
				$daysTo[] = '1410';
			}
			if($company->getCompanyDetail()->get($day.'_from') == 1){
	  			$disabledDates[] = ucfirst($day);
			}
		}
		else{
			$daysFrom[] = '0';
			$daysTo[] = '1410';
		}
	}
?>

<script type="text/javascript">
$(document).ready(function() {

	<?php $js_array = json_encode($disabledDates);
	echo "var javascript_array = ". $js_array . ";\n";
	?>

	var dateToday = new Date();
	function unavailable(date) {
		var wd = $.datepicker.formatDate('D', date);
		for (i = 0; i < javascript_array.length; i++) {
			if($.inArray(wd, javascript_array) != -1) {
				return [false];
			}
		}
		return [true];
	}

	jQuery(document).ready(function() {
		jQuery('#datepicker_start, #datepicker_end').datepicker({
			dateFormat: 'dd/mm/yy',
			minDate: dateToday,
			beforeShowDay: unavailable,
			onClose: hours
		});
	});

	function removeOptions(selectbox){
	    var i;
	    for(i=selectbox.options.length-1;i>=0;i--)
	    {
	        selectbox.remove(i);
	    }
	}

	function hours(hours){
		if(document.getElementById('hours') != null){
			removeOptions(document.getElementById("hours"));

			var day = $( "#datepicker_start" ).datepicker('getDate');
			if(day == null) return;
			var selecteddate =  $( "#datepicker_start" ).datepicker( "getDate" ).getDay();

			var sel = document.getElementById('hours');
			var opt = null;

			<?php $from_array = json_encode($daysFrom);
				echo "var from = ". $from_array . ";\n"; ?>
			<?php $to_array = json_encode($daysTo);
				echo "var to = " . $to_array .";\n"; ?>

			for (i = parseInt(from[selecteddate]); i <= parseInt(to[selecteddate]); i += 30) {
				var time = new Date(); 
				time.setHours(Math.floor(i / 60));
				time.setMinutes((i % 60));

				opt = document.createElement('option');
			    opt.innerHTML = ("0" + time.getHours()).slice(-2) + ":" + ("0" + time.getMinutes()).slice(-2);
			    sel.appendChild(opt);
			}
		}
	}

}); 
</script>

<script>
	$('#reservationForm').submit(function(){
    var element = $(this).parent().parent();
	    $.ajax({
	        url: "<?php echo url_for('company/reservation?slug=' . $company->getSlug(), array(), true) ?>",
	        type: 'POST',
	        data: $(this).serialize(),
            beforeSend: function(data) {
                    // document.getElementById("loading-overlay").style.display="block";
                $('.reservation-loader').html(LoaderHTML);
            }, 
	        success: function(data, url) {
	        	// document.getElementById(".place_content").style.display="none";
	        
	          $(element).html(data);
	        },
	        error: function(e, xhr)
	        {
	          console.log(e);
	        }
	    });
	    return false;
	});
</script>