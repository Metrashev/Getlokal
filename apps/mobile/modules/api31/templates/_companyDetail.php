<?php if ($company->getCompanyDetail() && $company->getCompanyDetail()->getHourFormatCPage('wed')): ?>
    <div class="hours gray">
        <?php foreach ($company->getCompanyDetail()->getWorkingHours() as $hour): ?>
            <strong><?php echo $hour['time']; ?></strong> <span><?php echo __($hour['day']); ?></span><br>
        <?php endforeach ?>
    </div>
<?php endif; ?>
