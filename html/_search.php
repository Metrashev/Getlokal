<script type="text/javascript">
    var searchHeaderWherePlaceholder = 'София';
</script>
<div class="form-search global-search-margin">
		<div class="container">
			<div class="row">
				<form  action="/bg/d/search/index"  method="get" id="search-form">
					<div class="col-sm-12">
						<div class="col-sm-7">
							<div class="form-row">
								<label for="#">Търси</label>
								<div class="form-controls">
													                    		<input placeholder="напр. пица, Starbucks" type="text" id="search_header_what" name="s" value="" class="field field-search"/>
																	</div><!-- /.form-controls -->
							</div>
						</div>
						
						<div class="col-sm-5">
							<div class="form-row">
								<label for="#">Къде</label>
								<div class="form-controls">
									<input type="hidden" id="ac_where" name="ac_where" value="">
				                    <input type="hidden" id="ac_where_ids" name="ac_where_ids" value="">
				                    <input placeholder="София" type="text" id="search_header_where" name="w" value="" />
									<button type="submit" class="btn btn-search">
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
            map.lat = 42.6965;
            map.lng = 23.325997;

            map.loadUrl = '/bg/d/search/searchNear';
            map.autocompleteUrl = '/bg/d/search/autocomplete';
            map.init();
        });
    </script>