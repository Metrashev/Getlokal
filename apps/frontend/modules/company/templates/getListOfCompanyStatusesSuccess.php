<?php use_helper('Date'); ?>
<?php use_helper('TimeStamps'); ?>

<?php if (isset($listOfStatuses) && count($listOfStatuses)){ ?>
    <div class="status-updates-head">
        <h3><?php echo __('Status updates', null, 'status') ?></h3>
    </div><!-- status-updates-head -->

    <div class="status-updates-body">					
        <?php foreach ($listOfStatuses as $status){ ?>
            <!-- <div class="status-updates-body-image"> -->
            <?php //if ($company->getLogoImageId()) : ?>
            <?php //echo image_tag($company->getLogoImage()->getThumb(0), array('size'=>'80x80', 'alt'=>($company->getLogoImage()->getCaption()? $company->getLogoImage()->getCaption() : $company->getCompanyTitle())));?>
            <?php //endif;?>
            <!-- </div>status-updates-body-image -->

            <div class="status-updates-body-content">
                <div class="status-updates-body-content-head">
                    <h4><?php echo $company->getCompanyTitle(); ?></h4>
                    <p><?php echo ezDate(date('d.m.Y H:i', strtotime($status->getCreatedAt()))); ?><i class="fa fa-mobile fa-2x"></i></p>
                </div><!-- status-updates-body-content-head -->
                <div class="status-updates-body-content-body">
                    <?php echo sfOutputEscaper::unescape($status->getText()); ?>
                </div><!-- status-updates-body-content-body -->
            </div><!-- status-updates-body-content -->
            </br></br></br>
        <?php } ?>
    </div><!-- status-updates-body -->
<?php } ?>