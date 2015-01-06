<?php if (count($articleEvents)>0):?>
		<div class="default-container rel-events-fix">				
				<h3 class="heading"><?php echo __('Related Events',null,'article')?></h3> <!-- END heading -->
				<div class="content">					
					<div class="related-events-box">	
					<?php 
					foreach ($articleEvents as $article_event){
						include_partial('relatedEventItem', array('event' => $article_event));	
					}?>
					</div>
				</div><!-- END content -->
		</div> <!-- END default-container -->
<?php endif;?>