<?php
if(!function_exists('format_date')){
	use_helper('Date');
}
$User = sfContext::getInstance()->getUser();
$culture = $User->getCulture();

$buy_url = $event->getBuyUrl();
$display_title = $event->getDisplayTitle();
$event_id = $event->getId();
$from_date = format_date($event->getStartAt(), 'dd MMM yyyy',$culture);
$category = $event->Category;
$city = $event->getCity();

$company = $event->EventPage[0]->CompanyPage->Company;
?>

<li class="event-list-item">
	<a href="<?= url_for('event/show?id='. $event->getId()); ?>">
		<div class="upcoming-event-head">
			<?php echo '<h6>'.$display_title.'</h6>'?>
			<?php echo '<h5>'.$company->Translation[$culture]['title'].'</h5>'; ?>
		</div>

		<div class="upcoming-event-body">
		
			<?php
			//var_dump($event->getImage()->getType());
			$size = '220x165';//'180x135';//'135x101';//'101x135';
			if(!$event->getImage()){
				$sector_id = $event->getCategory()->getId();
				$image_path = "/images/gui/default_event_".$sector_id.".jpg";
				$caption = "";
			}elseif ($event->getImage()->getType()=='poster' ){
				$image_path = $event->getThumb('preview');
				$size = '220x290';//'180x240';//'195x260';
				$caption = $event->getImage()->getCaption();
			}else{
				$image_path = $event->getThumb(2);//"http://static.getlokal.com/"
				$caption = $event->getImage()->getCaption();
			}
			echo image_tag($image_path,array('raw_name'=>true,'size'=>$size, 'alt'=> $caption));

		    if($event->hasTickets()){?>
				<div class="available-tickets">
	            	<i class="fa fa-ticket"></i><?php echo __('Tickets Available', null, 'offer'); ?>
	            </div>
			<?php } ?>
		</div><!-- event-body -->
		
		<div class="upcoming-event-foot">
			<div class="upcoming-section-date">
				<div class="upcoming-date"><?php echo __('from'); ?>: <span><?php echo $from_date?></span></div>
				<div class="alignright"><span></span></div>
			</div><!-- section-date -->
			
			<div class="upcoming-section-place">
				<span><?php echo $city?></span>	
			</div><!-- section-place -->

			<div class="upcoming-section-event-type">
				<div class="alignleft"><i class="fa fa-tag"></i><?php echo $category ?></div>
			</div><!-- section-event-type -->
		</div><!-- event-foot -->
	</li>
</a>