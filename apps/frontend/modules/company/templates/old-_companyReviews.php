<?php //print_r(count($pager->getResults()));exit();
$reviews = $pager->getResults();
$reviewscount = $pager->getNbResults();
$i18n=$sf_user->getCulture();
?>
<?php if ($reviewscount == 0): ?>
<p>
  <?php echo __('There are no reviews', null, 'reviews'); ?>
</p>
<?php else: ?>
<div class="review_list_wrap">
<?php  foreach ($reviews as $review): print_r('dasdas ');
//$company = Doctrine::getTable ( 'Company' )->find(Doctrine::getTable ( 'Page' )->find($review->getPageId())->getForeignId())
?>
							<div class="review_list_company">
								Review for
								<h2><a href="#" title="Laguna Vienese Patisserie"><?php //echo ($i18n=='en') ?  $company->getTitleEn() :  $company->getTitle() ?></a></h2>
								<a href="#" class="category">Restourants</a>

								<a href="#" class="review_list_img"><img src="/images/places/100x100/place1.jpg" alt="[place name]" title="[place name]" /></a>


								<div class="review_rateing">
									<div class="rateing_stars">
										<div class="rateing_stars_orange" style="width: 20%;"></div>
									</div>
									<span class="">1 / 5</span>
								</div>

								<p><?php echo $review->getText();?></p>

								<a href="#" class="vote">Vote <span>24</span></a>
								<a href="#" class="report">Report</a>
							</div>
<?php endforeach;?>
</div>
<?php endif;?>
