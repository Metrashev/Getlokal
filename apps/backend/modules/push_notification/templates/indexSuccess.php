<?php 
if (in_array(sfContext::getInstance()->getUser()->getId(),array(4216, 89984, 97746)) ) {
	if (!$no_form) {?>
	<form action="push_notification" method="post">
		<div>
			<div>
			<?php echo $form['message']->renderLabel(); ?>
			</div>
			<?php
				  echo $form['message']->render();
		    	  echo $form['message']->renderError();
		    ?>
		</div>
		<div>
			<div>
			<?php echo $form['device_os']->renderLabel(); ?>
			</div>
			<?php echo $form['device_os']->render();
		    	  echo $form['device_os']->renderError();
		    ?>
		</div>
		<div>
			<div>
			<?php echo $form['app_version']->renderLabel(); ?>
			</div>
			<?php echo $form['app_version']->render();
		    	  echo $form['app_version']->renderError();
		    ?>
		</div>
		<div>
			<div>
			<?php echo $form['country_id']->renderLabel(); ?>
			</div>
			<?php 
				  echo $form['country_id']->render();
		    	  echo $form['country_id']->renderError();
		    ?>
		</div>
		<div>
			<div>
			<?php echo $form['city_id']->renderLabel(); ?>
			</div>
			<?php echo $form['city_id']->render();
		    	  echo $form['city_id']->renderError();
		    ?>
		</div>
		<div>
			<div>
			<?php echo $form['country_gps']->renderLabel(); ?>
			</div>
			<?php echo $form['country_gps']->render();
		    	  echo $form['country_gps']->renderError();
		    ?>
		</div>
		<div>
			<div>
			<?php echo $form['locale']->renderLabel(); ?>
			</div>
			<?php echo $form['locale']->render();
		    	  echo $form['locale']->renderError();
		    ?>
		</div>
	<input type="submit">
	</form>
<?php }
	  else {
		  if ($iOS) { ?>
			  <div>
			  	<b>iOS</b><br/>
				<?php if (isset($iOS_result) && $iOS_result) { ?>
					<p>All tokens: <?php echo $iOS_result['all']?></p>
					<p>Success: <?php echo $iOS_result['success']?></p>
					<p>Failure: <?php echo $iOS_result['failure']?></p>
					<p>Deleted: <?php echo $iOS_result['deleted']?></p>
				<?php } else { ?>
					<p>No iOS tokens.</p>
				<?php } ?>
			  </div>
	<?php } 
		  if ($android) { 
			  if ($iOS) { ?>
			  	<br/>
		<?php } ?>
		  	  <div>
			  	<b>Android</b><br/>
				<?php if (isset($android_result) && $android_result) { ?>
					<p>All tokens: <?php echo $android_result['all']?></p>
					<p>Success: <?php echo $android_result['success']?></p>
					<p>Failure: <?php echo $android_result['failure']?></p>
					<p>Deleted: <?php echo $android_result['deleted']?></p>
				<?php } else { ?>
					<p>No Android tokens.</p>
				<?php } ?>
			  </div>
	<?php }?>
<?php }
} ?>
