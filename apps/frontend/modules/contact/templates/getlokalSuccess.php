<?php include_partial('global/commonSlider'); ?>
<div class="container set-over-slider">
	<div class="row">
		<div class="container">
			<div class="row">
				<h1 class="col-xs-12 main-form-title"><?= __('Contact Us'); ?></h1>
			</div>
		</div>
	          
	</div>
	<div class="row">
		<div class="default-container default-form-wrapper col-sm-12">					
			<?php if (getlokalPartner::getInstance() == getlokalPartner::GETLOKAL_BG): ?>
			    <div class="center_dynamic">
			        <h2 class="office_bg"><?php echo __('Getlokal Bulgaria', null, 'contact') ?></h2>
			        <p><?php echo __('Address:', null, 'contact') ?><br>
			            <?php echo __('1 Balsha Street', null, 'contact') ?>,
			            <?php echo __('Sofia 1408', null, 'contact') ?></p>
			        <p><?php echo __('Telephone:', null, 'contact') ?> +359 2 805 1500</br>
			            <?php echo __('Fax:', null, 'contact') ?> +359 2 952 3921</p>
			    </div>
			<?php elseif (getlokalPartner::getInstance() == getlokalPartner::GETLOKAL_RO): ?>
			    <div class="center_dynamic">
			        <h2 class="office_ro"><?php echo __('Getlokal Romania', null, 'contact') ?></h2>
			        <p><?php echo __('Address:', null, 'contact') ?><br>
			            <?php echo __('Bucuresti, Radu Calomfirescu Str. 7, fl. 2 ap. 5', null, 'contact') ?>,
			            <?php echo __('Bucuresti, Romania', null, 'contact') ?></p>
			        <p><?php echo __('Telephone:', null, 'contact') ?><br> +40 723 68 78 58</p>
			    </div>
			<?php elseif (getlokalPartner::getInstance() == getlokalPartner::GETLOKAL_MK): ?>
			    <div class="center_dynamic">
			        <h2 class="office_mk"><?php echo __('Getlokal Macedonia', null, 'contact') ?></h2>
			        <p><?php echo __('Address:', null, 'contact') ?><br>
			            <?php echo __('bul. Partizanski odredi. 42/2', null, 'contact') ?>,
			            <?php echo __('1000 Skopje, Macedonia', null, 'contact') ?></p>
			        <p><?php echo __('Telephone:', null, 'contact') ?> +389 (0)2 3177 888<br>
			            <?php echo __('Fax:', null, 'contact') ?> 02 3178 488</p>
			    </div>
			<?php elseif (getlokalPartner::getInstance() == getlokalPartner::GETLOKAL_RS): ?>
			    <div class="center_dynamic">
			        <h2 class="office_sr"><?php echo __('Getlokal Serbia', null, 'contact') ?></h2>
			        <p><?php echo __('Address:', null, 'contact') ?><br>
			            <?php echo __('Nemanjina 4/XIII Beograd', null, 'contact') ?></p>
			        <p><?php echo __('Telephone:', null, 'contact') ?> +381 11 4060400<br>
			           <?php echo __('Fax:', null, 'contact') ?> +381 11 4060410</p>
			    </div>
			<?php elseif (getlokalPartner::getInstance() == getlokalPartner::GETLOKAL_HU): ?>
			    <div class="center_dynamic">
			        <h2><?php echo __('Getlokal Hungary', null, 'contact') ?></h2>
			        <p><?php echo __('Address:', null, 'contact') ?><br>
			            <?php echo __('MTT Media Kft. ', null, 'contact') ?></p>
			        <p><?php echo __('H-2040 Budaors, Baross utca 89, Hungary', null, 'contact') ?></p>
			      <?php /*  <p><?php echo __('Telephone:', null, 'contact') ?> +381 11 4060400<br>
			           <?php echo __('Fax:', null, 'contact') ?> +381 11 4060410</p> */ ?>
			    </div>
			<?php endif; ?>
	
	    	<?php include_partial('form', array('form' => $form)) ?>
	
			<div class="contact_map_wrap">
			<?php if (getlokalPartner::getInstance() == getlokalPartner::GETLOKAL_BG): ?>
			    <?php include_partial('contact/bulgaria'); ?>
			<?php elseif (getlokalPartner::getInstance() == getlokalPartner::GETLOKAL_RO): ?>
			    <?php include_partial('contact/romania'); ?>
			<?php elseif (getlokalPartner::getInstance() == getlokalPartner::GETLOKAL_MK): ?>
			    <?php include_partial('contact/macedonia'); ?>
			<?php elseif (getlokalPartner::getInstance() == getlokalPartner::GETLOKAL_RS): ?>
			    <?php include_partial('contact/serbia'); ?>
			<?php elseif (getlokalPartner::getInstance() == getlokalPartner::GETLOKAL_HU): ?>
			    <?php include_partial('contact/hungary'); ?>
			<?php elseif (getlokalPartner::getInstance() == getlokalPartner::GETLOKAL_FI): ?>
			    <?php include_partial('contact/finland'); ?>
			<?php endif; ?>
			</div>
	
		</div><!-- END default-form-wrapper -->
	</div>
</div>


