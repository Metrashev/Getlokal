<div class="actual-map" id="google_map" style="width:100%"></div>

<script type="text/javascript">
	$(document).ready(function(){
		map.init();
		map.loadMarkers('<?php echo json_encode(array(array(
			'lat' => 47.456598,
 			'lng' => 18.947098,
			'title' => "getlokal",
			'icon' => 'getlokal_map_marker'
		)))?>');
	});
</script>