<?php
decorate_with('widget');
$vars = array(
    'get' => url_for('@geocoding'),
    'count' => $sf_request->getParameter('count', 0)
);
?>
<style>
#logging {
    float: left;
    width: 50%;
    overflow: auto;
    height: 400px;
    font-size: 12px;
}
.cl { clear: both; }
#map {
    float: right;
    width: 50%;
    height: 400px;
}
</style>
<script>
window.geo = <?php echo json_encode($vars); ?>
</script>
<div id="logging">
</div>
<div id="map">

</div>
<div class="cl"></div>
<input type="submit" id="start" value="start">
<input type="submit" id="stop" value="stop">
