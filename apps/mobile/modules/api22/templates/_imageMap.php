<?php
    $location = $company->getLocation();
    $latLng = $location->getLatitude() . ',' . $location->getLongitude();
    $marker = image_path('gui/icons/marker_'. $company->getSectorId(), true);
    $params = array(
        // 'center' => $latLng, // google know how to center if you give him markers
        'zoom' => '15',
        'size' => '300x100',
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
</div>