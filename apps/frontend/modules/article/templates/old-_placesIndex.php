<?php if (count($articlePages)>0):?>
<div class="related_places_wrap">
			<h2><?php echo __('Related Places',null,'article')?></h2>
			<div class="outline_wrap">
				<ul>
			<?php foreach ($articlePages as $article_page):?>
					<li>
					<?php echo link_to(image_tag($article_page->getCompanyPage()->getCompany()->getThumb(1), 'size=52x52 alt=' . $article_page->getCompanyPage()->getCompany()->getCompanyTitle()), $article_page->getCompanyPage()->getCompany()->getUri(ESC_RAW), array('title' => $article_page->getCompanyPage()->getCompany()->getCompanyTitle())) ?>
         			<?php echo link_to(truncate_text($article_page->getCompanyPage()->getCompany()->getCompanyTitle(), 40, '...', true), $article_page->getCompanyPage()->getCompany()->getUri(ESC_RAW), array('title' => $article_page->getCompanyPage()->getCompany()->getCompanyTitle())) ?>
						<div class="place_rateing">
							<div class="rateing_stars">
              					<div class="rateing_stars_orange" style="width: <?php echo $article_page->getCompanyPage()->getCompany()->getRating() ?>%;"></div>
            				</div>
            				<p><?php echo format_number_choice('[0]0 reviews|[1]1 review|(1,+Inf]%count% reviews', array('%count%' => $article_page->getCompanyPage()->getCompany()->getNumberOfReviews()), $article_page->getCompanyPage()->getCompany()->getNumberOfReviews()); ?></p>
						</div>
					</li>
			<?php endforeach;?>
				</ul>
			</div>
		</div>
<?php endif;?>