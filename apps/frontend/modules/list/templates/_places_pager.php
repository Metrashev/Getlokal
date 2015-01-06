<?php use_helper('Pagination'); ?>
<div class="list_of_places" id="list_of_places">
    <?php $placeUser = false; ?>
<ul class="list-details-company">
	<?php $placeUser = false;
	
	$places = $pager->getResults();
	foreach ($places as $place): 
		if ($user && $user->getId() == $place->getUserId()) $placeUser = true;
		$place_company = $place->getCompanyPage()->getCompany();
		$place_company_image = $place_company->getImage();
		
		$img_title = ($place_company_image && $place_company_image->getCaption()) ?  $place_company_image->getCaption() : $place_company->getCompanyTitle();
	?>
	<li class="list-details-company-item">
		<div class="list-details-company-image"
			id="item_<?= $place->getId(); ?>">
			<a href="#"> <?php echo image_tag($place_company->getThumb(0), array('size' => '150x100', 'alt' => $img_title)); ?>
				<!-- 				<img src="css/images//temp/category-image1.jpg" alt=""> -->
			</a>
		</div>
		<div class="list-details-company-desc show-list">
			<h4>
				<a href="<?php echo url_for($place_company->getUri(ESC_RAW)) ?>"
					title="<?php echo $place_company->getCompanyTitle($culture) ?>"> <?php echo $place_company->getCompanyTitle($culture) ?>
				</a>
			</h4>
			<div class="stars-holder bigger">
				<ul>
					<li class="gray-star"><i class="fa fa-star"></i>
					</li>
					<li class="gray-star"><i class="fa fa-star"></i>
					</li>
					<li class="gray-star"><i class="fa fa-star"></i>
					</li>
					<li class="gray-star"><i class="fa fa-star"></i>
					</li>
					<li class="gray-star"><i class="fa fa-star"></i>
					</li>
					<li><p class="reviews-number">
							<?php echo format_number_choice('[0]<span>0</span> reviews|[1]<span>1</span> review|(1,+Inf]<span>%count%</span> reviews', array('%count%' => $place_company->getNumberOfReviews()), $place_company->getNumberOfReviews()); ?>
						</p>
					</li>
				</ul>
				<div class="top-list">
					<div class="hiding-holder" style="width: <?= $place_company->getRating() ?>%;">
						<ul class="spans-holder">
							<li class="red-star"><i class="fa fa-star"></i>
							</li>
							<li class="red-star"><i class="fa fa-star"></i>
							</li>
							<li class="red-star"><i class="fa fa-star"></i>
							</li>
							<li class="red-star"><i class="fa fa-star"></i>
							</li>
							<li class="red-star"><i class="fa fa-star"></i>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<p class="places">
				<i class="fa fa-tags"></i>
				<?php echo link_to($place->getCompanyPage()->getCompany()->getClassification(), $place->getCompanyPage()->getCompany()->getClassificationUri(ESC_RAW), array('class' => 'category')) ?>
				<!-- 				<a title="Места за хапване" class="category" href="/bg/sofia/mesta-za-hapvane/restoranti">Ресторанти</a> -->
			</p>
			<p class="<?php echo (!$is_place_admin_logged) ? 'short' : '' ?>"><?php echo $place->getCompanyPage()->getCompany()->getDisplayAddress(); ?></p>
                        <?php // USE $is_place_admin_logged ?>

                        <?php if ($user && ( $user->getId() == $place->getUserId() || $user->getId() == $listUserId )): ?>
                            <a id="<?php echo $place->getId() ?>" class="button_gray delete-chat" href="javascript:void(0);"><i class="fa fa-trash-o"></i><?php echo __('Delete') ?></a>
                        <?php endif; ?>
			
			<div class="list-details-btn">
			<?php 
				$link_events = $place_company->getEventCount() ? link_to('<span></span>'.__('Events'), 'company/events?slug=' . $place_company->getSlug() . '&city=' . $place_company->City->getSlug(), array('class'=>'event-btn','title' => $place_company->getCompanyTitle())) : '';
				$link_offers = $place_company->getAllOffers(true, false, true) ? link_to(__('Get Voucher'), 'company/showAllOffers?slug=' . $place_company->getSlug() . '&city=' . $place_company->City->getSlug(), array('title' => $place_company->getCompanyTitle())) : '';
			?>
			<?php if($link_events != ''){ ?>
				<?= $link_events?>
			<?php }if($link_offers != ''){ ?>
				<a class="get-vaucher-btn" href="$link_offers"><span>%</span>Get Voucher</a>
			<?php } ?>
				 
			</div>
		</div> <!-- end list-details-company-desc --> <?php if ($review = $place_company->getReviews()->getFirst()): ?>
		<div class="list-details-review-writter">
			<?php if ($review->getUserProfile()): ?>
			<div class="list-details-wrap-img">
				<a href="#"> <?php echo image_tag($review->getUserProfile()->getThumb(),array('size'=>"50x50"))?>
					<!-- 					<img src="http://lorempixel.com/55/55/" alt=""> -->
				</a>
			</div>
			<?php endif;?>
			<div class="list-details-wrap-txt">
				<?php if ($review->getUserProfile()): ?>
				<a href="#"><h5>
						<?php echo $review->getUserProfile()->getLink(ESC_RAW) ?>
					</h5> </a>
				<?php endif; ?>
				<p>
					<?php echo $review->getText() ?>
				</p>
			</div>
		</div> <!-- end list-details-review --> <?php endif;?>
	</li>
	<?php endforeach;?>
	<!-- end list-details-company-item -->
</ul>
</div>
<?php 
//====================================== MAP OVERLAYS =========================================
foreach($places as $p):
	$place_company = $p->getCompanyPage()->getCompany();
	$tmp = array();
	$tmp['lat'] = $place_company->Location->getLatitude();
	$tmp['lng'] = $place_company->Location->getLongitude();
	
	$tmp['id'] = $place_company->getId();
	$tmp['title'] = $place_company->getCompanyTitle();
	$tmp['icon'] = $place_company->getSmallIcon();
	
	$json_companies[] = $tmp;
?>
<div id="overlay_<?= $place_company->getId()?>" class="hidden">
	<div style="background-color:#fff;width:100px;">
	<?php 
	echo html_entity_decode(get_partial('search/item_overlay',array('company'=>$place_company)));?>
	</div>
</div>
<?php endforeach;?>

<?php
//====================================== PLACES AJAX PAGER ======================================
$PagerData = myTools::getPager($pager->getPage(), $pager->getNbResults(),null,Lists::FRONTEND_LISTS_PER_TAB);
?>
<div class="wrapper-pager">
	<div class="ajaxPager paging paging-number" style="clear: both;">
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
	$(".pagerCenter a").click(function(e){
		var page = $(this).attr("value");
		$(".pagerCenter a").removeClass("current");
		$(this).addClass("current");
		listPaging(page);
	});

	$(".pagerLeft a").click(function(e){
		var page = $(this).attr("value");
		$(".pagerCenter a").removeClass("current");
		$("#page-"+page).addClass("current");
		listPaging(page);
	});

	$(".pagerRight a").click(function(e){
		var page = $(this).attr("value");
		$(".pagerCenter a").removeClass("current");
		$("#page-"+page).addClass("current");
		listPaging(page);
	});
	
	function listPaging(page){
		url = "/bg/d/list/getListPage/id/<?= $listId ?>/page/"+page;

		$("#list_places_ul").html('<div id="loader_container_events">'+LoaderHTML+'</div>');
		$.post(url,{},function( data ) {
	        $("#list_places_ul").html(data);
	    });
	}
	
</script>
<script type="text/javascript">

//===================================== INIT MAP MARKERS ======================================

    
        
        $(document).ready(function() {
        	<?php 
if ($pager->getNbResults()){ ?>
            jsonString = '<?php echo json_encode($json_companies);?>';

            map.loadMarkers(jsonString);

            //map.geocodeAndPositionMap(map.address);
            
            //google.maps.event.trigger(map.map, 'resize');
            <?php } ?>

//===================================== END INIT MAP MARKERS ==================================
            $("#list_of_places a.button_gray").click(function() {
                var listPageId = $(this).attr('id');
                //var value = $(this).attr('title');
                var thisEl = $(this);
                var row = $(this).parent().parent();
			

                $.ajax({
                    url: '<?php echo url_for("list/delPageFromList") ?>',
                    data: {'listPageId': listPageId},
                    success: function(data, url) {
                        $(row).remove();
                        $('#spanPlaceCount').text(parseInt($('#spanPlaceCount').text())-1);
                        //console.log('success');
                    },
                    error: function(e, xhr)
                    {
                        console.log(xhr);
                    }
                });
			
                return false;
            })
		
        })
    
    </script>

