<div class="actual-map" id="google_map" style="width:100%"></div>

<script type="text/javascript">
	$(document).ready(function(){
		map.init();
		map.loadMarkers('<?php echo json_encode(array(array(
			'lat' => 44.807038,
 			'lng' => 20.4579887,
			'title' => "getlokal",
			'icon' => 'getlokal_map_marker'
		)))?>');
	});
</script>
