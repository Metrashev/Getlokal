<div class="actual-map" id="google_map" style="width:100%"></div>

<script type="text/javascript">
	$(document).ready(function(){
		map.init();
		map.loadMarkers('<?php echo json_encode(array(array(
			'lat' => 42.000636,
 			'lng' => 21.414362,
			'title' => "getlokal",
			'icon' => 'getlokal_map_marker'
		)))?>');
	});
</script>
