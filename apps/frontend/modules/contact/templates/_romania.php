<div class="actual-map" id="google_map" style="width:100%"></div>

<script type="text/javascript">
	$(document).ready(function(){
		map.init();
		map.loadMarkers('<?php echo json_encode(array(array(
			'lat' => 44.432444,
 			'lng' => 26.107978,
			'title' => "getlokal",
			'icon' => 'getlokal_map_marker'
		)))?>');
	});
</script>

