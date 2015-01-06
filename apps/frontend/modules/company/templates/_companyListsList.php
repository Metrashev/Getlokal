<ul class="tab-lists">
	<?php 
		foreach($lists->getResults() as $list):
			include_partial('list/listItemSmall',array('list'=>$list));
		endforeach;
	?>
</ul>
<div class="wrapper-pager">
	<div class="ajaxPager paging paging-number" style="clear: both;">
		<?php 
			$PagerData = myTools::getPager($lists->getPage(), $lists->getNbResults(),null,Lists::COMPANY_LISTS_PER_PAGE);
		?>
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
	var lists_target = '#company_lists_container';
	var company_id = '<?=$company_id?>';
	var lists_type = 'lists';
	$(lists_target+" .pagerCenter a").click(function(e){
		var page = $(this).attr("value");
		$(lists_target+" .pagerCenter a").removeClass("current");
		$(this).addClass("current");
		ajaxPaging(page,lists_target,company_id,lists_type);
	});

	$(lists_target+" .pagerLeft a").click(function(e){
		var page = $(this).attr("value");
		$(lists_target+" .pagerCenter a").removeClass("current");
		$(lists_target+" #page-"+page).addClass("current");
		ajaxPaging(page,lists_target,company_id,lists_type);
	});

	$(lists_target+" .pagerRight a").click(function(e){
		var page = $(this).attr("value");
		$(lists_target+" .pagerCenter a").removeClass("current");
		$(lists_target+" #page-"+page).addClass("current");
		ajaxPaging(page,lists_target,company_id,lists_type);
	});
		
</script>