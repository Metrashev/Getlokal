<ul class="offerts-list-unsorted-list">
<?php 
	$offers = $pager->getResults();
	$offerscount = $pager->getNbResults();
	$currentPage = $pager->getPage();
    foreach ($offers as $offer){
		include_partial('offer', array('offer' => $offer));
	}
?>
</ul>

	<div class="wrapper-pager">
		<div class="ajaxPager paging paging-number" style="clear: both;">
			<?php $PagerData = myTools::getPager($currentPage, $offerscount); ?>
			<div class="pagerLeft">
				<?=$PagerData['pagerLeft']?>
			</div>
			<div class="pagerCenter">
				<?=$PagerData['pagerCenter']?>
			</div>
			<div class="pagerRight">
		    	<?=$PagerData['pagerRight']?>
		    </div>
		</div>	
	</div>


<script type="text/javascript">
	<!--
	$(".pagerCenter a").click(function(e){
		var id = $(this).attr("value");
		$(".pagerCenter a").removeClass("current");
		$(this).addClass("current");
		listOffers();
	});

	$(".pagerLeft a").click(function(e){
		var id = $(this).attr("value");
		$(".pagerCenter a").removeClass("current");
		$("#page-"+id).addClass("current");
		listOffers();
	});

	$(".pagerRight a").click(function(e){
		var id = $(this).attr("value");
		$(".pagerCenter a").removeClass("current");
		$("#page-"+id).addClass("current");
		listOffers();
	});
	//-->
</script>
