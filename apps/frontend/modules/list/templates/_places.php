<?php use_helper('Pagination'); ?>
<?php $placeUser = false;

foreach ($places as $place): 
	if ($user && $user->getId() == $place->getUserId()) $placeUser = true;
	$place_company = $place->getCompanyPage()->getCompany();
	$place_company_image = $place_company->getImage();
	
	$img_title = ($place_company_image && $place_company_image->getCaption()) ?  $place_company_image->getCaption() : $place_company->getCompanyTitle();
?>
<li class="list-details-company-item">
	<div class="list-details-company-image"
		id="item_<?= $place->getId(); ?>">
		<a href="<?php echo url_for($place_company->getUri(ESC_RAW)) ?>"> <?php echo image_tag($place_company->getThumb(0), array('size' => '100x100', 'alt' => $img_title)); ?>
			<!-- 				<img src="css/images//temp/category-image1.jpg" alt=""> -->
		</a>
	</div>
	<div class="list-details-company-desc">
		<h4>
			<a href="<?php echo url_for($place_company->getUri(ESC_RAW)) ?>"
				title="<?php echo $place_company->getCompanyTitle($culture) ?>"> <?php echo $place_company->getCompanyTitle($culture) ?>
			</a>
		</h4>
		<div class="stars-holder big">
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

		<?php /*if ( $user && ( $user->getId() == $place->getUserId() || $user->getId() == $listUserId ) ):?>
			<a id="<?php echo $place->getId()?>" class="button_gray" href="javascript:void(0);"><?php echo __('Delete')?></a>
		<?php endif; */?>
		
		<div class="list-details-btn">
		<?php 
			$link_events = $place_company->getEventCount() ? link_to(__('Events'), 'company/events?slug=' . $place_company->getSlug() . '&city=' . $place_company->City->getSlug(), array('title' => $place_company->getCompanyTitle())) : '';
			$link_offers = $place_company->getAllOffers(true, false, true) ? link_to(__('Get Voucher'), 'company/showAllOffers?slug=' . $place_company->getSlug() . '&city=' . $place_company->City->getSlug(), array('title' => $place_company->getCompanyTitle())) : '';
		?>
		<?php if($link_events != ''){ ?>
			<a class="event-btn" href="<?=$companyConverted['link-events']?>"><span></span>Events</a>
		<?php }if($link_offers != ''){ ?>
			<a class="get-vaucher-btn" href="#"><span>%</span>Get Vaucher</a>
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
				<?php echo strip_tags(truncate_text(html_entity_decode ($review->getText()), 100, '...', true)); ?>
			</p>
		</div>
	</div> <!-- end list-details-review --> <?php endif;?>
</li>
<?php endforeach;?>

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

