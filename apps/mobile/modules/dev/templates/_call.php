<?php if ($company->getPhone()) : ?>
    <div class="call gray">
        <a href="getlokal://call?<?php echo $company->getPhoneFormated($company->getPhone(), $sf_user->getCulture()) ?>">
            <span class="phone-icon"></span>
            <strong><?php echo __('CALL') ?></strong>
            <?php echo $company->getPhoneFormated($company->getPhone(), $sf_user->getCulture()) ?>
        </a>
    </div>
<?php endif; ?>
