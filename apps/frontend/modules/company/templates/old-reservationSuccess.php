<?php //echo $form[$form->getCSRFFieldName()]; ?>
<?php $labelClass = 'asterisk'?>
<form name="reservation" id="reservationForm" action="<?php url_for('company/reservation?slug='.$company->getSlug()); ?>" method="POST">
	
	<div class="form-head">
		<div class="form-group">
			<div class="form-row">
				<label for="yourreservation"><?php echo __('Reservation Request', null, 'form')?></label>
			</div>
		</div>
	</div>

	<div class="form-body">
		<div class="form-group">
			<ul>
				<li>
					<div class="form-row<?php if($form['email']->hasError()): ?> error<?php endif; ?>">
						<label class="asterisk"><?php echo __('Your e-mail:', null, 'contact')?></label>
						<div class="form-controls">
							<?php echo $form['email']->render(array ('placeholder' => __("Example@domain.com"))); ?>
							<?php echo $form['email']->renderError(); ?>
						</div>
					</div>
				</li>
				
				<li>
					<div class="form-row<?php if($form['name']->hasError()): ?> error<?php endif; ?>">
						<label><?php echo __('Your name:', null, 'contact')?></label>
						<div class="form-controls">
							<?php echo $form['name']->render(array ('placeholder' => __("John Doe" , null , 'company'))); ?>
							<?php echo $form['name']->renderError(); ?>
						</div>
					</div>
				</li>
				
				<li>
					<div class="form-row no-margin <?php if($form['phone']->hasError()): ?> error<?php endif; ?>">
						<label class="asterisk"><?php echo __('Your phone:',null,'contact')?></label>
						<div class="form-controls">
							<?php echo $form['phone']->render(array ('placeholder' => __("+359 3 234 123"))); ?>
							<?php echo $form['phone']->renderError(); ?>
						</div>
					</div>
				</li>
			</ul>
		</div>
		
		<div class="form-group">
			<ul>
				<li>
					<div class="form-row <?php if( $form['start_date']->hasError()):?> error<?php endif;?>">
						<?php echo $form['start_date']->renderLabel(null, array( 'class' => $labelClass))?>
						<div class="form-controls">
							<?php echo $form['start_date']->render(array('type' => 'text', 'id' => 'datepicker_start', 'readonly' => "readonly")) ?>
							<?php echo $form['start_date']->renderError()?>
						</div>
					</div>
					
					<ul class="width">
							<?php if($company->isHotel() == true): ?>
							<li>
								<div class="form-row <?php if( $form['end_date']->hasError()):?> error<?php endif;?>">
									<?php echo $form['end_date']->renderLabel(null, array( 'class' => $labelClass))?>
									<div class="form-controls">
										<?php echo $form['end_date']->render(array('type' => 'text', 'id' => 'datepicker_end')); ?>
										<?php echo $form['end_date']->renderError()?>
									</div>
									<div class=""></div>
								</div>
							</li>	

							<li>
								<div class="form-row night <?php if( $form['nights']->hasError()):?> error<?php endif;?>">
									<?php echo $form['nights']->renderLabel(null, array( 'class' => $labelClass))?>
									<div class="form-controls">
										<?php echo $form['nights']->render(); ?>
										<?php echo $form['nights']->renderError()?>
									</div>
									<div class="clear"></div>
								</div>
							</li>
							<?php //endif?>
						
							<?php elseif($company->isRestaurant() == true): ?>
							<li>
								<div class="form-row <?php if( $form['time']->hasError()):?> error<?php endif;?>">
									<?php echo $form['time']->renderLabel()?>
									<div id="time" class="form-controls">
										<i class="fa fa-chevron-down"></i>
										<?php echo $form['time']->render(array('id' => 'hours')); ?>
										<?php echo $form['time']->renderError()?>
									</div>
									<div class="clear"></div>
								</div>
							</li>	
							<?php endif; ?>
						<li>
							
							<div class="form-row no-margin <?php if($form['people']->hasError()): ?> error <?php endif; ?><?php echo ($company->isHotel()==true  ?'hotel': 'restaurant');?> ">
								<?php echo $form['people']->renderLabel(null, array( 'class' => $labelClass)); ?>
								<div class="form-people">
									<?php echo $form['people']->render(); ?>
									<?php echo $form['people']->renderError(); ?>
								</div>
							</div>
						</li>
					</ul>
				</li>
				
				<li>
					<div class="form-row no-margin <?php if($form['about']->hasError()): ?> error <?php endif; ?>">
						<div class="form-textarea">
							<label><?php echo __('Additional Information',null,'contact')?></label>
							<div class="form-controls">
								<?php echo $form['about']->render(); ?>
								<?php //if($form['about']->hasError()): ?>
								<?php echo $form['about']->renderError(); ?>
								<?php //endif; ?>
							</div>
						</div>
					</div>
				</li>
			
				<?php 
				$isHotel = false;
				if($company->isHotel() == true): 
					$isHotel = true;
				?>
				
				<li class="captcha-hotel">
					<?php if(sfConfig::get('app_recaptcha_active', false)): ?>
						<div class="form-row captcha_out">
							<?php echo $form['captcha']->renderLabel(null, array( 'class' => $labelClass)); ?>
							<div class="form-captcha">
								<?php echo $form['captcha']->render(); ?>
								<?php echo $form['captcha']->renderError(); ?>
							</div>
						</div>
					<?php endif; ?>
				</li>
				<?php endif; ?>
			</ul>
		</div>
			<?php if($company->isRestaurant() && !$isHotel): ?>
		<div class="form-group">
			<ul>
				<li class="captcha-res">
					<?php if(sfConfig::get('app_recaptcha_active', false)): ?>
						<div class="form-row captcha_out">
							<?php echo $form['captcha']->renderLabel(null, array( 'class' => $labelClass)); ?>
							<div class="form-captcha">
								<?php echo $form['captcha']->render(); ?>
								<?php echo $form['captcha']->renderError(); ?>
							</div>
						</div>
					<?php endif; ?>
				</li>
			</ul>
		</div>
		<?php endif; ?>
	</div>
	
	<div class="form-foot">
		<div class="warning">
			<div class="form-row">
				<label for="#"><?php echo __('All fields marked with <span>*</span> are mandatory', null, 'company') ?></label>
				<div class="form-controls">
				
				</div>
			</div>
		</div>

		<div class="btn-blue">
			<div class="clear"></div>
				<div class="form-row">
					<div class="form-controls">
						<input type="submit" id="input-submit" class="input_submit" value="<?php echo __('Send' , null , 'company'); ?>" />
					</div>
				</div>
			</form>
			<div class="clear"></div>
		</div>
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

			var day = $( "#datepicker_start" ).datepicker( "getDate" );
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
    var element = $(this).parent().parent().parent().find('div.place_content');      
	    $.ajax({
	        url: "<?php echo url_for('company/reservation?slug=' . $company->getSlug(), array(), true) ?>",
	        type: 'POST',
	        data: $(this).serialize(),
            beforeSend: function(data) {
                    document.getElementById("loading-overlay").style.display="block";
                }, 
	        success: function(data, url) {
	        	document.getElementById("loading-overlay").style.display="none";
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




