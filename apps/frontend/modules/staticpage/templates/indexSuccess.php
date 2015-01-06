<?php 
	use_helper('Pagination');
	include_partial('global/commonSlider');
?>

<div class="container set-over-slider">
	<div class="row">	
		<div class="container">
			<div class="row">
				<?php include_partial('global/breadCrumb') ?>
				<h1 class="col-xs-12 list-header"><?=$static_page->getTitle()?></h1>
			</div>
		</div>
		
		<div class="col-sm-4">
           <div class="section-categories">
                <div class="categories-title">
                    
	            </div><!-- categories-title -->
                <ul class="categories-list">
	                <?php 
	                foreach ($root->getNode()->getChildren() as $subpage){
	                	include_partial('page', array('page' => $subpage, 'slug' => $slug, 'static_page' => $static_page)); 
	                }
	                ?>	                
	            </ul>
	       </div>
		</div>
		 <div class="col-sm-8">            
            <div class="list-content-default">
                <div class="articles-list-content">
                	<div class="static-page-container">
						<!-- EDITOR OUTPUT -->
						<?php echo htmlspecialchars_decode($static_page['content']); ?>
                	</div>
                </div> <!-- END articles-list-content -->
            </div>
        </div>
	</div>
</div>
<style>


</style>