<?php
    $description = $company->getDescription();
    if (!empty($description)): ?>
    	<div class="about wrap">
    		<?php echo $company->getDescription(); ?>
    	</div>
<?php endif ?>
