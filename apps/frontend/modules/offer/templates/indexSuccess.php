<?php 
	include_partial('indexSlider');
?>
<div class="wrapper-offers-slider"> <!-- start wrapper-offers-slider -->

	<div class="container"><!-- start container->wrapper-header -->
		<div class="row">
			<div class="col-sm-12 wrapper-header">
				<h1 class="offers-header"><?php  echo  __('Offers',null,'offer'); ?></h1>
				<p class="offers-paragraph-header"><?php echo __('Choose an offer, download the voucher now and pay when you use it in the place.', null, 'form')?></p>
			</div>
		</div>
	</div> <!-- end container->wrapper-header -->

	<div class="container"><!-- start content container -->
		<div class="row"> <!-- start row container -->
			<div class="col-sm-4 wrapper-sidebar-left"> <!-- star-wrapper-sidebar-left -->
				<div class="all-locations-offers">
					<?php echo $form['city_id']->render() ?>					
				</div>
				<div class="events-section-categories">
                    <div class="event-categories-title">
                    <div class="marker"></div>
                    	<?php echo __('Select category', null, 'events') ?>
                    </div><!-- categories-title -->
                        <ul class="events-category-list">
                        <?php 
                        	foreach ($choices['sector'] as $url => $sector){
								//$url = substr(strrchr($url, "/"), 1);
							?>
							<li<?=$sector['cont'] == 'All sectors' ? ' class="selected" id="all_sectors_option"' : ''?>>
                                <div class="marker"></div>
                                <a data-value="<?=$sector['sec']?>" value="<?=$url?>" title="<?=$sector['cont']?>"><?=__($sector['cont'])?></a>
                            </li>
							<?php 
							}
                        ?>                            
                        </ul><!-- categories-list -->
                </div>

                <div class="list-premium-places" >
					<?php include_component('box', 'boxVip') ?>	
				</div> <!-- end list-premium-places -->
			</div><!-- end-wrapper-sidebar-left with col-sm-4 -->

			<div class="col-sm-8 wrapper-all-offers"> <!-- start wrapper-all-offers -->
				<div class="all-offers-category"> <!-- start all-offers-category -->
                    <ul>
                        <li value="3" class="selected"><a class="item-offers-category"><?=__('Latest',null,'messages');?></a></li>
                        <li value="4"><a class="item-offers-category"><?=__('Expiring soon',null,'messages');?></a></li>
                        <li value="1"><a class="item-offers-category"><?=__('Discount low to high',null,'messages');?></a></li>
                        <li value="2"><a class="item-offers-category"><?=__('Discount high to low',null,'messages');?></a></li>
                    </ul>
                </div><!-- end all-offers-category -->

                <div class="offers-list" id="offers_list_container"> <!-- start offers-list -->
                	<?php include_partial('offersList', array('pager' => $pager)); ?>
                </div> <!-- end offers-list -->
			</div> <!-- end wrapper-all-offers with col-sm-8 -->

		</div> <!-- end row container -->
	</div><!-- start content container -->
</div> <!-- end wrapper-offers-slider -->
                        
<script type="text/javascript">
$(".events-category-list li a").click(function(e){
	var id = $(this).attr("value");
	$(".events-category-list li").removeClass("selected");

	$(this).parent().addClass("selected");		
	backToFirstPage();
	listOffers();
});

$(".all-offers-category li").click(function(e){
	var id = $(this).attr("value");
	$(".all-offers-category li").removeClass("selected");
	$(this).addClass("selected");
	backToFirstPage();
	listOffers();
});

$("#city_id").change(function(e){
	var id = $(this).attr("value");
	$(this).addClass("selected");

	$(".events-category-list li").removeClass("selected");
	$('#all_sectors_option').addClass("selected");	
	backToFirstPage();
	listOffers();
});

function backToFirstPage(){
	$(".pagerCenter a").removeClass("current");
	$("#page-1").addClass("current");
}

function listOffers(){
	city = $("#city_id").val();
	page = $(".pagerCenter a.current").attr("value");
	slug = $(".events-category-list li.selected a").attr("value");
	order = $(".all-offers-category li.selected").attr("value");
	
	url = "?order="+order+"&page="+page+"&is_ajax=1";
	if(city != 'offers'){
		city_select = $("#city_id");
		city_id = $('option:selected', city_select).attr('data-group');
		url += '&city='+city+'&city_id='+city_id;
	}
	if(slug != 'offers'){
		sector_select = $(".events-category-list li.selected a");
		sector_id = sector_select.attr('data-value');
		url += '&slug='+slug+'&sector_id='+sector_id;
	}
	$('#offers_list_container').html('<div id="loader_container_events">'+LoaderHTML+'</div>');
	$.ajax({
		  type: "POST",
		  url: url,
		  success: function( data ) {
              $('#offers_list_container').html(data);
          }
	});
}
</script>