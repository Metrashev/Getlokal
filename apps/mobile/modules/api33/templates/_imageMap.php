<?php
    $location = $company->getLocation();
    $latLng = $location->getLatitude() . ',' . $location->getLongitude();
    $marker = image_path('gui/icons/marker_'. $company->getSectorId(), true);
    $params = array(
        // 'center' => $latLng, // google know how to center if you give him markers
        'zoom' => '17',
        'size' => '600x200',
        'maptype' => 'roadmap',
        'markers' => "icon:{$marker}%7Cshadow:false%7C{$latLng}",
        'sensor' => 'false',
        'key' => 'AIzaSyDLUVQz9sWCrGaFTGMGniOPG4r7wTMasEc'
    );
    $ps = array();
    foreach ($params as $k => $v) {
        $ps[] = "{$k}={$v}";
    }
    $params = implode('&', $ps);
?>
<div class="wrap map clearfix">
    <div id="map">
        <a href="getlokal://map">
            <img src="http://maps.googleapis.com/maps/api/staticmap?<?php echo $params; ?>">
        </a>
    </div>
    <a href="getlokal://map" id="address">
        <i class="icon"></i>
        <?php if ($company->getDisplayAddress()): ?>
            <?php echo $company->getDisplayAddress(); ?>
        <?php endif ?>
    </a>
    <div class="edit-address-wrapper clearfix">
        <a href="getlokal://suggest" class="edit-address-btn col-xs-12">
            <?php echo __('Suggest an Edit') ?>
        </a>
    </div>
    <?php if(!is_null($company->getCreatedByUser()->getId())): ?>
    <div class="added-by-wrapper clearfix">
        <div class="col-xs-3 image">
            <?php echo image_tag($company->getCreatedByUser()->getThumb(0), array(
                'size' => '36x36',
                'class' => 'img-responsive'
            )); ?>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6 txt"><?php echo __('This place was added by', null, 'messages') . " "; ?></div>
            <div class="col-xs-12 col-sm-6  user-name"><?php echo $company->getCreatedByUser()->getSfGuardUser()->getFirstName() . ' ' . $company->getCreatedByUser()->getSfGuardUser()->getLastName(); ?></div>
        </div>
    </div>
    <?php endif; ?>
</div>
