		<?php if (count($articleLists)>0):?>	
			<div class="article_content_wrap">
				<h2><?php echo __('Related Lists',null,'article')?></h2>	
				<?php foreach ($articleLists as $article_list):	
					include_partial('list/list', array('list'=>$article_list->getLists(), 'list_user' => $article_list->getLists()->getUserProfile()));
				endforeach;?>
			<div class="clear"></div>
		  </div>
		  <?php endif;?>