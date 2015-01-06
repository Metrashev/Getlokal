<?php
    $description = $company->getI18nDescription();
    if (!empty($description)): ?>
    	<div class="about wrap">
    		<?php echo $company->getI18nDescription(); ?>
    	</div>
<?php endif ?>
