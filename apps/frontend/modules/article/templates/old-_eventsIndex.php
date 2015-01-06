<?php if (count($articleEvents)>0):?>
		<div class="related_articles_wrap">
			<h2><?php echo __('Related Events',null,'article')?></h2>
			<div class="outline_wrap">
				<ul>
			<?php foreach ($articleEvents as $article_event):?>	
					<li>
						<a title="<?php echo $article_event->getEvent()->getDisplayTitle() ?>" href="<?php echo url_for('event/show?id='.$article_event->getEvent()->getId()) ?>"><?php echo image_tag($article_event->getEvent()->getThumb(2), array( 'size'=>'88x88', 'alt'=>$article_event->getEvent()->getDisplayTitle() ) );?></a>
						<?php echo link_to(truncate_text( $article_event->getEvent()->getDisplayTitle(), 40, '...', true),'event/show?id='.$article_event->getEvent()->getId(), array('title' => $article_event->getEvent()->getDisplayTitle()));?>
						<p><?php echo truncate_text(strip_tags( html_entity_decode ( $article_event->getEvent()->getDisplayDescription() ) ) , 80, '...', true) ?></p>
						<div class="clear"></div>
					</li>
				<?php endforeach;?>
				</ul>
			</div>
		</div>	
<?php endif;?>