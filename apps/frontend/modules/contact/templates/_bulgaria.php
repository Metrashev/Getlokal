<div class="actual-map" id="google_map" style="width:100%"></div>

<script type="text/javascript">
	$(document).ready(function(){
		map.init();
		map.loadMarkers('<?php echo json_encode(array(array(
			'lat' => 42.68099,
 			'lng' => 23.310592,
			'title' => "getlokal",
			'icon' => 'getlokal_map_marker'
		)))?>');
	});
</script>



