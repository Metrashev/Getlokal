<?php
$search_city = $sf_request->getParameter('w');
$ac_where = $sf_request->getParameter('ac_where');
$ac_where_ids = $sf_request->getParameter('ac_where_ids');
$wherePlaceholder = $sf_request->getParameter('placeholder');

if ($sf_user->getCountry()->getSlug() == 'fi') {
    $placeholder = $sf_user->getCounty();
} else {
    $placeholder = $sf_user->getCity();
}
?>
<script type="text/javascript">
	var city = '<?php echo mb_strtolower($sf_user->getCity()->getName(), 'utf-8'); ?>';
	var city_en = '<?php echo strtolower($sf_user->getCity()->getNameEn()); ?>';
	var country = '<?php echo $sf_user->getCountry()->getCountryNameByCulture('en'); ?>';
    var searchHeaderWherePlaceholder = '<?php echo $placeholder; ?>';
</script>
<div class="form-search global-search-margin home-search">
		<div class="container">
			<div class="row">
				<form  action="<?php echo url_for('search/index') ?>"  method="get" id="search-form">
					<div class="col-sm-12">
						<div class="col-sm-7">
							<div class="form-row">
								<label for="#"><?php echo __('Search for'); ?></label>
								<div class="form-controls search-what-controll">
									<?php if ($sf_user->getCountry()->getSlug() == 'mk'): ?>
										<input tabindex="1" placeholder="<?php echo __("e.g. pizza, Trend"); ?>" type="text" id="search_header_what" name="s" value="<?php echo trim($sf_request->getParameter('s')) ?>" class="field field-search"/>
									<?php elseif ($sf_user->getCountry()->getSlug() == 'sr'): ?>
				                    		<input tabindex="1" placeholder="<?php echo __("e.g. restaurant, hairdresser"); ?>" type="text" id="search_header_what" name="s" value="<?php echo trim($sf_request->getParameter('s')) ?>" class="field field-search"/>
									<?php else: ?>
				                    		<input tabindex="1" placeholder="<?php echo __("e.g. pizza, Starbucks"); ?>" type="text" id="search_header_what" name="s" value="<?php echo trim($sf_request->getParameter('s')) ?>" class="field field-search"/>
									<?php endif; ?>
								</div><!-- /.form-controls -->
							</div>
						</div>
						
						<div class="col-sm-5">
							<div class="form-row">
								<label for="#"><?php echo __('Where'); ?></label>
								<div class="form-controls search-where-controll">
									<input type="hidden" id="glr" name="glr" value="" />
									<input type="hidden" id="ac_where" name="ac_where" value="<?php echo $ac_where; ?>">
				                    <input type="hidden" id="ac_where_ids" name="ac_where_ids" value="<?php echo $ac_where_ids; ?>">
				                    <input tabindex="2" placeholder="<?php echo __($placeholder); ?>" type="text" id="search_header_where" name="w" value="<?php echo $wherePlaceholder ? $wherePlaceholder : $search_city; ?>" />
									<button tabindex="3" type="submit" class="btn btn-search">
										<i class="fa fa-search fa-2x"></i>
									</button>
								</div><!-- /.form-controls -->
							</div>
						</div>
					
				</div></form>
			</div>
		</div>
	</div>
	<script type="text/javascript">
        $(document).ready(function() {
            map.lat = <?php echo $sf_user->getCity()->getLat(); ?>;
            map.lng = <?php echo $sf_user->getCity()->getLng(); ?>;

            map.loadUrl = '<?php echo url_for('search/searchNear') ?>';
            map.autocompleteUrl = '<?php echo url_for('search/autocomplete') ?>';
            map.init();
        });
    </script>