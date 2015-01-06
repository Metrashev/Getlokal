<?php 
	//use_helper('Pagination'); 
	$events = $pager->getResults();
	$eventscount = $pager->getNbResults();
	
	$sliderData = array();	
	$sliderData['city'] = $city->getDisplayCity();
	$sliderData['path'] = '';

	if(getlokalPartner::getInstanceDomain() == 78){
		$sliderData['headLine'] = sprintf(__('RECOMMENDATIONS FOR EVENTS IN %s', null, 'events'), $sf_user->getCounty());
	}else{
		$sliderData['headLine'] = sprintf(__('RECOMMENDATIONS FOR EVENTS IN %s', null, 'events'), $sf_user->getCity()->getDisplayCity());
	}

	foreach(breadCrumb::getInstance()->getItems() as $i=>$item){
		if($item->getUri()){
	    	$sliderData['path'] .= link_to($item->getText(), $item->getUri(), array('class' => 'path-item'));
		}else{ 
			$sliderData['path'] .= $item->getText();
		}
	    if($i+1 < sizeof(breadCrumb::getInstance()->getItems())){
	    	$sliderData['path'] .= ' / ' ;
		}
	} 
	//var_dump($eventscount); die;
	include_partial('event/eventsCalendarFilterJs', $arCalendarFilterAttributes);
	include_partial('sliderRecommended', array('sliderData' => $sliderData));	
	
?>
<script type="text/javascript">
	city_id = <?=$city->getId()?>;	
</script>
<div class="event-categories_wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-lg-4 hidden-sm">
                <?php 
                	$content = get_partial('eventCategories',array('categories'=>$categories));
                	slot('side_categories');
                	echo $content;
                	end_slot();
                	echo $content;
               	?>
                <?php include_component('box', 'boxVip') ?>
                <?php include_component('box','boxSingleSliderOffers'); ?>
                <?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
				<div class="default-container">
					<h3 class="heading"><?php echo __('Sponsored'); ?></h3>
					<!-- END heading -->
					<div class="content">
						<?php include_partial('global/ads', array('type' => 'box')) ?>
					</div>
					<!-- END content -->
				</div>
				<?php endif;?>
            </div>
            <div class="col-sm-12 col-md-8 col-lg-8">
                <div class="all-events-category">
                    <ul class="all-event-category-tabs">
                  <!--  <blockquote>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
							</blockquote> -->
                        <li value="active" <?php if($selected_tab == "active"):?>class="selected"<?php endif;?>><a><?php echo __('Today', null, 'events') ?>
                        </a></li>
                        <li value="future" <?php if($selected_tab =="future"):?>class="selected"<?php endif;?>><a><?php echo __('Future Events', null, 'events') ?>
                        </a></li>
                        <li value="past" <?php if($selected_tab =="past"):?>class="selected"<?php endif;?>><a><?php echo __('Past Events', null, 'events') ?>
                        </a></li>
                        <li id="calendar_tab" <?php if($selected_tab == "date"):?>class="selected"<?php endif;?> value="date"><a class="calendar-label"><?php echo __('Calendar', null, 'events') ?>
                        </a><input type="hidden" class="date-test" id="date_filter" /></li>                                            
                    </ul>
                    <a class="default-btn success" href="<?php echo url_for('event/create') ?>"><span class="plus-icon-add-new-events"></span><?php echo __('New Event', null, 'events') ?></a>                                        
                </div>
                <div id="events_container" class="event-container-events">
                    <?php
                    	include_partial('eventsList', array('events' => $events, 'eventscount' => $eventscount, 'currentPage' => $currentPage));													
					?>
                </div>                                    
            </div> 

            <div class="col-sm-6 hidden-md hidden-lg">
            	<?php include_component('box', 'boxVip') ?>
            </div>    

            <div class="col-sm-6 hidden-md hidden-lg">
            	<?php include_component('box','boxSingleSliderOffers'); ?>
            </div>                          
		</div>
	</div>
</div><!-- event-categories_wrapper -->
<script type="text/javascript">
<!--
	function backToFirstPage(){
		$(".pagerCenter a").removeClass("current");
		$("#page-1").addClass("current");
	}
	
	function listEvents(){
		page = $(".pagerCenter a.current").attr("value");
		category_id = $(".events-category-list li.selected a").attr("value");
		tab = $(".all-events-category li.selected").attr("value");
		date = $("#date_filter").val();	
		
		url = "?city_id="+city_id+"&selected_tab="+tab+"&date_selected="+date+"&page="+page+"&category="+category_id+"&is_ajax=1";
		$('#events_container').html('<div id="loader_container_events">'+LoaderHTML+'</div>');
		$.ajax({
			  type: "POST",
			  url: url,
			  success: function( data ) {
	              $('#events_container').html(data);
	          }
		});
	}
	
	$(".events-category-list li a").click(function(e){
		var id = $(this).attr("value");
		$(".events-category-list li").removeClass("selected");
	
		categoryTitle = $(this).html()+' <?php echo __('in', null, 'events') ?> <?=$city->getDisplayCity()?>';
		$("#selected_category_title").html(categoryTitle);
		
		$(this).parent().addClass("selected");		
		backToFirstPage();
		listEvents();
	});
	
	$(".all-events-category li").click(function(e){
		var id = $(this).attr("value");
		if(id != 'date'){
			$(".all-events-category li").removeClass("selected");
			$(this).addClass("selected");
			$('.calendar-label').html('<?php echo __('Calendar', null, 'events') ?>');
			backToFirstPage();
			$("#date_filter").val("");
			listEvents();
		}
	});
 
    $( "#date_filter" ).datepicker({
    	dateFormat: 'yy-mm-dd',
        showOn: "button",
        buttonImage: "/images/fa-angle-down.png",
        buttonImageOnly: true,
        onSelect: function(dateText, inst) { 
        	$("#date_filter").val(dateText);
        	$('.calendar-label').html(dateText);
        	backToFirstPage();
        	$(".all-events-category li").removeClass("selected");
        	$("#calendar_tab").addClass("selected");
        	listEvents();
        }
    });
    $(".calendar-label").click(function(e){
    	$(".calendar-label").datepicker('show');
    });

//-->
</script>

