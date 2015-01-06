<?php 
$link_to_pdf = __('claim it', null, 'businessPage');
if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_MK)
	$link_to_pdf = '<a target="_blank" href="/pdf/Menadziranje_profil.pdf">'.__('claim it', null, 'businessPage').'</a>';

$workhour = '';
if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_BG)
	$workhour = '09:00 18:00';
elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO)
	$workhour = '09:30 23:30';
elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_MK)
	$workhour = '08:00 16:30';
elseif($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RS)
	$workhour = '09:00 18:00';
?>

<div class="business_feature_wrap">
<div class="business_feature_top">
<div class="business_feature_list">
<h1 class="pink">getBusiness</h1>
<p><?php echo __('Getlokal is the place where you meet your customers. Engage in a conversation with them – be notified whenever someone publishes a review about your place and post an official answer to them, upload photos, your contact details and business description! Improve your position in front of your competition and bring relevance to your online presence! What are the steps?', null, 'businessPage'); ?></p>
<?php //$domain = sfContext::getInstance()->getRequest()->getHost();  ?>
<ul>
	<li><?php printf(__('%s on getlokal! If you are new @ %s you need to register first.', null, 'businessPage'), link_to(__('Register', null, 'businessPage'), url_for('@user_register?business=1'), array('target'=>'_blank')), 'getlokal'); ?></li>
	<li><?php printf(__('Find or add your place! %s, find your place and %s! If you can’t find it, %s or %s and we will do it for you. And then again - log in, find your place and %s!', null, 'businessPage'), link_to(__('Log in', null, 'businessPage'), '@sf_guard_signin?business=1', array('target' => '_blank')), $link_to_pdf, link_to(__('add it yourself', null, 'businessPage'), 'company/addCompany', array('target' => '_blank')), link_to(__('let us know', null, 'businessPage'), 'contact/getlokal', array('title' => __('Contact Us'), 'target' => '_blank')), $link_to_pdf); ?></li>
	<li><?php echo __('Fill in content! It’s free and easy! What are your benefits? Unlimited photo upload, place description in two languages and most importantly - you engage in a conversation with your customers!', null, 'businessPage'); ?></li>
	<li><?php printf(__('Can’t get enough? After you get acquainted with your place profile, %s for more info about the businesslokal+ features.', null, 'businessPage'), link_to(__('write to us', null, 'businessPage'), 'contact/getlokal', array('title' => __('Contact Us'), 'target' => '_blank'))); ?></li>
</ul>
</div>
<div class="sidebar">
<div class="business_feature_links"><a
	target="_blank" href="<?php echo url_for('@user_register?business=1') ?>"><?php echo __('Start Here!', null, 'businessPage'); ?></a>
<p><?php echo __('Register', null, 'businessPage'); ?></p>
<a target="_blank" href="<?php echo url_for('@sf_guard_signin?business=1')?>"><?php echo __('Already Have an Account?', null, 'businessPage'); ?>
</a>
<p><?php echo __('Login and Claim your place', null, 'businessPage'); ?></p>
<?php echo link_to(__('Need Help?', null, 'businessPage'), 'contact/getlokal', array('title' => __('Contact Us'), 'target' => '_blank'));?>
<p>
	<?php echo __('Contact us (we’ll answer as fast as we can)', null, 'businessPage'); ?>
	<?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_MK): ?>
		<br/><a target="_blank" href="/pdf/Menadziranje_profil.pdf"><?php echo __('Download the Guide for Managing Your Business Profile', null, 'businessPage')?></a>
	<?php endif; ?>
</p>
</div>
</div>
<div class="clear"></div>
</div>
<div class="business_feature_content">
<h1><?php echo __('Your Business Profile', null, 'businessPage'); ?></h1>
<div class="business_features_wrap">
<div class="business_features">

	<div class="business_content_wrap">
	
		<div class="feature1">
			<div class="shadow_box_content">
				<?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_BG): ?>
					<p class="company_title">Getlokal.com</p>
					<p class="category"><?php echo __('Advertising in Sofia', null, 'businessPage')?></p>
				<?php elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO):?>
					<p class="company_title">Getlokal.ro</p>
					<p class="category"><?php echo __('Party and Event Organizers in Bucuresti', null, 'businessPage')?></p>
				<?php elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_MK):?>
					<p class="company_title">Getlokal.mk</p>
					<p class="category"><?php echo __('Advertising in Skopje', null, 'businessPage')?></p>
				<?php elseif($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RS): ?>
					<p class="company_title">Getlokal.rs</p>
					<p class="category"><?php echo __('Advertising in Belgrade', null, 'businessPage') ?></p>
				<?php endif; ?>
				<div class="place_rateing">
					<div class="rateing_stars">
						<div class="rateing_stars_orange" style="width: 100%;"></div>
					</div>
					<p class="orange">5.00 / 5</p>
					<?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_BG): ?>
						<p>9 <?php echo __('reviews')?></p>
					<?php else:?>
						<p>1 <?php echo __('review')?></p>
					<?php endif; ?>
				</div>
			</div>
			<div class="shadow_left"></div>
			<div class="shadow_right"></div>
			<a href="javascript:void(0);" class="sticker_left"><span><?php echo __('Who are you?', null, 'businessPage'); ?></span></a>
			<span><?php echo __('The place name goes here! Choose the most appropriate classification among 200 and more!', null, 'businessPage'); ?></span>
		</div>
		
		
		<div class="feature2">
			<div class="shadow_box_content">
				<img width="110px" src="/images/gui/place_oficial_en.png" alt="<?php echo __("Official") ?>" />
			</div>
			<div class="shadow_left"></div>
			<div class="shadow_right"></div>
			<a href="javascript:void(0);" class="sticker_right right_sticker"><span><?php echo __('Make it Official!', null, 'businessPage'); ?></span></a>
			<span><?php echo __('Put an official stamp that this is your business by claiming it!', null, 'businessPage'); ?></span>
		</div>
		<div class="clear"></div>
		
		<div class="feature3">
			<div class="shadow_box_content">
				<div class="place_addres">
					<?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_BG): ?>
						<b>02 805 1583</b>
						<p><?php echo __('Sofia, Balsha St 1, bl. 9 fl. 4', null, 'businessPage')?></p>
					<?php elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
						<b>0723 687 858</b>
						<p><?php echo __('Bucuresti - Sector 3, Radu Calomfirescu Str. 7, fl. 2 ap. 5', null, 'businessPage')?></p>
					<?php elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_MK): ?>
						<b>02 317 7888</b>
						<p><?php echo __('Skopje, Centar, Sv. Kliment Ohridski Blvd 53-1/3', null, 'businessPage')?></p>
						
						<?php elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RS): ?>
						<b>011 3040300</b>
						<p><?php echo __('Belgrade, Bacvanska St 21', null, 'businessPage')?></p><br/>
						
					<?php endif;?>
				</div>
			</div>
			<div class="shadow_left"></div>
			<div class="shadow_right"></div>
			<a href="javascript:void(0);" class="sticker_left"><span><?php echo __('Where are you?', null, 'businessPage'); ?></span></a>
			<span><?php echo __('Add your address and telephone number where you can be reached!', null, 'businessPage'); ?></span>
		</div>
		
		<div class="feature4">
			<div class="shadow_box_content">
				<img src="/images/gui/business_picture.png" />
			</div>
			<div class="shadow_left"></div>
			<div class="shadow_right"></div>
			<a href="javascript:void(0);" class="sticker_right right_sticker"><span><?php echo __('Get visual!', null, 'businessPage'); ?></span></a>
			<span><?php echo __('Show your place - post photos!', null, 'businessPage'); ?></span><br/><br/>
		</div>
		
		<div class="feature5">
			<div class="shadow_box_content">
				<?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_BG): ?>
					<p class="place_description"><?php echo __('Getlokal is Bulgaria\'s best site for reviews and recommendations. Here you can find information about restaurants, clubs, bars, shops, entertainment, art, etc. You can also write and share events, read our blog and get useful info from our newsletter. To explore and use all getlokal functionalities you must be a register user. This gives you right to collect cool badges, upload place or profile photos and participate in various getlokal games for great prizes.', null, 'businessPage')?></p>
				<?php elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
					<p class="place_description"><?php echo __('Looking for the best steak in town? The perfect coffee-house? The grooviest dancing place for a get together with your friends? Find what you seek and share what you think with getlokal.ro! This is the place page of our office in Bucharest - feel free to drop by anytime for a great espresso and a nice talk!', null, 'businessPage')?></p>
				<?php elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_MK): ?>
					<p class="place_description"><?php echo __('GetLokal is Macedonia\'s best site for reviews and recommendations. Here you can find information about restaurants, clubs, bars, shops, entertainment, art, etc. You can also write and share events, read our blog and get useful info from our newsletter. To explore and use all GetLokal functionalities you must be a register user. This gives you right to collect cool badges, upload place or profile photos and participate in various GetLokal games for great prizes.', null, 'businessPage')?></p>
				<?php elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RS): ?>
					<p class="place_description"><?php echo __('Getlokal is Serbia\'s best site for reviews and recommendations. Here you can find information about restaurants, clubs, bars, shops, entertainment, art, etc. You can also write and share events, read our blog and get useful info from our newsletter. To explore and use all getlokal functionalities you must be a register user. This gives you right to collect cool badges, upload place or profile photos and participate in various getlokal games for great prizes.', null, 'businessPage') ?>
					</p>
				<?php endif;?>
			</div>
			<div class="shadow_left"></div>
			<div class="shadow_right"></div>
			<a href="javascript:void(0);" class="sticker_left"><span><?php echo __('Tell your story!', null, 'businessPage'); ?></span></a>
			<span><?php echo __('Write a short description – why is your place different, what is its history? Be creative!', null, 'businessPage'); ?></span>	
		</div>
		
		<div class="feature6">
			<div class="shadow_box_content">
				<b class="working_title"><?php echo __('Working Hours', null, 'company'); ?></b>
				<div id="place_work_in">
					
					<div class="place_work_item">
						<b><?php echo __('Mon');?></b>
						<?php echo $workhour; ?>
					</div>
					<div class="place_work_item">
						<b><?php echo __('Tue');?></b>
						<?php echo $workhour; ?>
					</div>
					<div class="place_work_item">
						<b><?php echo __('Wed');?></b>
						<?php echo $workhour; ?>
					</div>
					<div class="place_work_item">
						<b><?php echo __('Thu');?></b>
						<?php echo $workhour; ?>
					</div>
					<div class="place_work_item">
						<b><?php echo __('Fri');?></b>
						<?php echo $workhour; ?>
					</div>
					<div class="place_work_item">
						<b><?php echo __('Sat');?></b>
						<img width="11px" alt="X" src="/images/gui/locked.png" title="Closed">
					</div>
					<div class="place_work_item">
						<b><?php echo __('Sun');?></b>
						<img width="11px" alt="X" src="/images/gui/locked.png" title="Closed">
					</div>
					<div class="clear"></div>
				</div>
				<ul class="place_contacts">
					<li>
						<p class="e-mail"><img width="12px" src="/images/gui/ico_email.gif" /><?php echo __('Send Email', null, 'company')?></p>
					</li>
					<li>
						<p class="web"><img width="12px" src="/images/gui/icon_internet.gif" /><?php echo __('Website', null, 'company')?></p>
					</li>
					<li style="position: absolute; right: 2px; top: 10px;">
						<p class="facebook"><img width="12px" src="/images/gui/ico_facebook.gif" />Facebook</p>
					</li>
				</ul>
				<div class="clear"></div>
			</div>
			<div class="shadow_left"></div>
			<div class="shadow_right"></div>
			<a href="javascript:void(0);" class="sticker_left"><span><?php echo __('Be available!', null, 'businessPage'); ?></span></a>
			<span><?php echo __('Set your working hours and the useful links!', null, 'businessPage'); ?></span>	
		</div>
		
		<div class="feature7">
			<div class="shadow_box_content">
				<div class="voting_item">
					<p><?php echo __('Professionals', null, 'businessPage')?></p>
					<div class="vote_wrap red">
						0<img width="11px" src="/images/gui/icon_vote_yes.png">
					</div>
					<div class="vote_wrap green">
						<img width="11px" src="/images/gui/icon_vote_no.png">21
					</div>
				</div>
				<div class="voting_item">
					<p><?php echo __('Meets Deadlines', null, 'businessPage')?></p>
					<div class="vote_wrap red">
						0<img width="11px" src="/images/gui/icon_vote_yes.png">
					</div>
					<div class="vote_wrap green">
						<img width="11px" src="/images/gui/icon_vote_no.png">18
					</div>
				</div>
				<div class="voting_item">
					<p><?php echo __('Street Parking', null, 'businessPage')?></p>
					<div class="vote_wrap red">
						0<img width="11px" src="/images/gui/icon_vote_yes.png">
					</div>
					<div class="vote_wrap green">
						<img width="11px" src="/images/gui/icon_vote_no.png">18
					</div>
				</div>
				<div class="voting_item">
					<p><?php echo __('Service', null, 'businessPage')?></p>
					<div class="vote_wrap red">0
						<img width="11px" src="/images/gui/icon_vote_yes.png">
					</div>
					<div class="vote_wrap green">
						<img width="11px" src="/images/gui/icon_vote_no.png">17
					</div>
				</div>
				<div class="voting_item">
					<p><?php echo __('Location', null, 'businessPage')?></p>
					<div class="vote_wrap red">
						0<img width="11px" src="/images/gui/icon_vote_yes.png">
					</div>
					<div class="vote_wrap green">
						<img width="11px" src="/images/gui/icon_vote_no.png">16
					</div>
				</div>
			</div>
			<div class="shadow_left"></div>
			<div class="shadow_right"></div>
			<a href="javascript:void(0);" class="sticker_right right_sticker"><span><?php echo __('Are you liked?', null, 'businessPage'); ?></span></a>
			<span><?php echo __('See what your customers appreciate most about your place!', null, 'businessPage'); ?></span>
		</div>
		
		<div class="feature8">
			<div class="shadow_box_content">
				<div class="review review_list_company">
					<p class="review_date"> over 3 months ago</p>
					<div>
						<?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_BG): ?>
							<p class="user"><b>Anna Georgieva</b></p>
							<img class="review_list_img" width="80" height="80" src="http://www.getlokal.com/uploads/photo_gallery/115/27/32/150x150/touch_of_the_rain____afremov_by_leonidafremov.jpg">
						<?php elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
							<p class="user"><b>Mihai Dragomirescu</b></p>
							<img class="review_list_img" width="80" height="80" src="http://www.getlokal.ro/uploads/photo_gallery/92/39/25/150x150/bob.jpg">
						<?php elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_MK): ?>
							<p class="user"><b>Ана Марија</b></p>
							<img class="review_list_img" width="80" height="80" src="http://www.getlokal.mk/uploads/photo_gallery/90/4/26/150x150/ana.jpg">
						<?php elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RS): ?>
							<p class="user"><b></b></p>
							<img class="review_list_img" width="80" height="80" src="">
						<?php endif;?>
						<div class="review_content">
							<div class="review_rateing">
								<div class="rateing_stars">
								<div class="rateing_stars_pink" style="width: 100%;"></div>
								</div>
								<p>5 / 5</p>
							</div>
							<?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_BG): ?>
								<p>Това е един от любимите ми сайтове, в него има много полезна информация. Използвам го доста често, дори наскоро си търсих хотел за лятната почивка, мненията на потребителите са безценни. В getlokal.com много често организират и игри, които са много интересни. Препоръчвам го.</p>
							<?php elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
								<p>Come by for a free espresso and a nice talk!</p>
							<?php elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_MK): ?>
								<p>Ова е еден од моите омилени сајтови, во него има многу корисни информации. Го користам доста често, дури неодамна барав ресторан каде е пријатно во летниот период и препораките на корисниците се навистина корисни. Го препорачувам на секој.</p>
							<?php elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RS): ?>
								<p></p>
							<?php endif;?>
						</div>
					</div>
					<div class="review_interaction">
						<?php echo __('Vote'); ?><p>0</p>
					</div>
					<?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_BG): ?>
						<div class="review_company_container">
							<div class="review_company_content">
								<b><?php echo __('from', null, 'company')?> Getlokal.com</b>
								<div class="review_company_content_wrap">
									<div class="review_content review_company_content_in">
										<p class="review_date">over 3 months ago</p>
										<p>Анна, признателни сме за милите думи. Това е нашата основна цел - да сме полезни за хората, търсещи информация за места, както и информацията за местата да е колкото се може по-подробна.</p>
									</div>
								</div>
							</div>
						</div>
					<?php elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_MK): ?>
						<div class="review_company_container">
							<div class="review_company_content">
								<b><?php echo __('from', null, 'company')?> Getlokal.mk</b>
								<div class="review_company_content_wrap">
									<div class="review_content review_company_content_in">
										<p class="review_date">over 2 months ago</p>
										<p>Ана, благодариме за убавите зборови. Тоа е нашата основна цел - да бидеме корисни за луѓето кои бараат информации за места, како и информациите за местата да бидат што е можно покорисни и подетални.</p>
									</div>
								</div>
							</div>
						</div>
					<?php elseif ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RS): ?>
						<div class="review_company_container">
							<div class="review_company_content">
								<b><?php echo __('from', null, 'company')?> Getlokal.rs</b>
								<div class="review_company_content_wrap">
									<div class="review_content review_company_content_in">
									<p class="review_date"></p>
									<p></p>
									</div>
								</div>									
							</div>
						</div>
					<?php endif;?>
				</div>
			</div>
			<div class="shadow_left"></div>
			<div class="shadow_right"></div>
			<a href="javascript:void(0);" class="sticker_left"><span><?php echo __('Pay attention!', null, 'businessPage'); ?></span></a>
			<span><?php echo __('Get to know your customers and engage in conversations as an official representative of your company!', null, 'businessPage'); ?></span>
		</div>
		
		<img class="business_picture_bg" src="/images/gui/business_picture_bg.png" />
		<img class="business_picture_buttons_bg" src="/images/gui/business_picture_buttons_bg.png" />
		<img class="business_picture_tabs_bg" src="/images/gui/business_picture_tabs_bg.png" />
		<img class="business_picture_vote_bg" src="/images/gui/business_picture_vote_bg.png" />
		<div class="clear"></div>
	</div>
</div>
</div>
</div>
</div>

<script type="text/javascript">
	$(document).ready(function() { 
//		$('.path_wrap').css('display', 'none');
		$('.search_bar').css('display', 'none');
		$('.content_footer').css('display', 'none');

		var sticker_width = 146;
		var position_offset = -58;
		
		$('a.sticker_left,a.sticker_right').each(function() {
			if ($(this).children('span').height() > 40)
			{
				$(this).children('span').css({'line-height': 'normal', 'padding-top': '2px'});
			}
			$(this).children('span').height(40 - parseInt($(this).children('span').css('paddingTop')));
		});
		
		$('.shadow_box_content').each(function() {
			if ($(this).parent().hasClass('feature2') || $(this).parent().hasClass('feature4') || $(this).parent().hasClass('feature7')) {
				$(this).parent().css({marginRight: '-126px', paddingRight: '106px'});
				$(this).parent().children('.shadow_right').css('right', $(this).parent().css('padding-right'));
			}
			else {
				$(this).parent().css({marginLeft: '-126px', paddingLeft: '106px'});
				$(this).parent().children('.shadow_left').css('left', $(this).parent().css('padding-left'));
			}
			$(this).parent().css({width: $(this).outerWidth(), height: $(this).outerHeight()})
			$(this).parent().children('.shadow_left').css({width:($(this).outerWidth()/2 - 1)});
			$(this).parent().children('.shadow_right').css({width:($(this).outerWidth()/2 - 1)});

			//$(this).parent().children('span').css('height', $(this).outerHeight() - (parseInt($(this).parent().children('span').css('paddingTop')) + parseInt($(this).parent().children('span').css('paddingBottom')) + 1);
		});

		$('.business_content_wrap div').mouseenter(function () {
			var leftPX = $(this).outerWidth();
			var element = $(this).children('a');

			var curWidth = $(this).width() - (parseInt($(this).children('span').css('paddingLeft')) + parseInt($(this).children('span').css('paddingRight')) + 1);
			var curHeight = $(this).height() - 3 - parseInt($(this).children('span').css('paddingTop')) - parseInt($(this).children('span').css('paddingBottom'));
			
			if (!element.hasClass('right_sticker')) {				
				$(this).children('span').css({height: curHeight, width: 0, display: 'block'});
				$(this).children('span').stop().delay(40).animate({width: curWidth }, 500);
				element.stop().animate({left: leftPX, width: 0}, 500, function() {
					element.removeClass('sticker_left').addClass('sticker_right sticker_back_right');
				});
			}
			else if (element.hasClass('right_sticker')) {
				$(this).children('span').css({height: curHeight, left: ($(this).width() - 20), width: 0, display: 'block'});
				$(this).children('span').stop().animate({left: 0, width: $(this).width() - (parseInt($(this).children('span').css('paddingLeft')) + parseInt($(this).children('span').css('paddingRight')) + 1)}, 500);
				element.stop().animate({left: -10, width: 0}, 500, function() { 
					element.removeClass('sticker_right').addClass('sticker_left sticker_back_left').css('left', '-39px');
				});
			}
		})
		
		$('.business_content_wrap div').mouseleave(function () {
			var element = $(this).children('a');
			if (!element.hasClass('right_sticker')) {
				$(this).children('span').stop().animate({width: 0}, 500);
				element.stop().removeClass('sticker_right').removeClass('sticker_back_right').addClass('sticker_left');
				element.stop().animate({left: position_offset, width: sticker_width}, 500, function() {
					element.parent().children('span').css('display', 'none');
				});
			}
			else {
				$(this).children('span').stop().animate({width: 0, left: ($(this).width()-20)}, 500);
				element.stop().removeClass('sticker_left').removeClass('sticker_back_left').addClass('sticker_right');
				element.stop().animate({left: $(this).width(), width: sticker_width}, 500, function() {
					element.parent().children('span').css({display: 'none', left: $(this).width()});
				});
			}
		})

		

		<?php /*
		
		var sticker_width = 146;
		

		$('.sticker_left').mouseenter(function() {
			if (parseInt($(this).css('left')) == offsetLeft || !parseInt($(this).css('left')))
			{
				$(this).stop();
				$(this).parent().children('span').stop();
				var leftPX = offsetLeft + $(this).parent().outerWidth();
				$(this).parent().children('span').css({width: 0, display: 'block'});
				$(this).parent().children('span').animate({width: ($(this).parent().width() - 20)}, 300);
				$(this).animate({width: 0, left: leftPX}, 250, function() {
					$(this).removeClass('sticker_left').addClass('sticker_right').addClass('sticker_back_right').css('left', (leftPX - offsetLeft));
				});
			}
			else
			{
				$(this).returnLeft();
			}
		});

		$('.sticker_right').mouseenter(function() {
			if (parseInt($(this).css('left')) == ($(this).parent().width()))
			{
				$(this).stop();
				$(this).parent().children('span').stop();
				var leftPX = $(this).parent().width() - 20;
				$(this).parent().children('span').css({width: 0, display: 'block', left: leftPX});
				$(this).parent().children('span').animate({width: leftPX, left: 0}, 300);
				$(this).animate({width: 0, left: 0}, 250, function() {
					$(this).removeClass('sticker_right').addClass('sticker_left').addClass('sticker_back_left');
				});
			}
			else
			{
				$(this).returnRight();
			}
		});

		$('.feature1,.feature3,.feature5,.feature6,').mouseleave(function() {
			$(this).children('a').returnLeft();
		});

		$('.feature2,.feature4,.feature7').mouseleave(function() {
			$(this).children('a').returnRight();
		});

		jQuery.fn.returnLeft = function() {
			$(this).stop();
			$(this).parent().children('span').stop();
			$(this).removeClass('sticker_back_right').removeClass('sticker_right').addClass('sticker_left');
			var leftPX = $(this).parent().outerWidth();
			if (parseInt($(this).css('left')) == leftPX)
				$(this).css('left', (parseInt($(this).css('left')) + offsetLeft));
			$(this).animate({width: sticker_width, left: offsetLeft}, 300);
			$(this).parent().children('span').animate({width: 0}, 300, function() {
				$(this).css('display', 'none');
			});
		};

		jQuery.fn.returnRight = function() {
			$(this).stop();
			$(this).parent().children('span').stop();
			$(this).removeClass('sticker_back_left').removeClass('sticker_left').addClass('sticker_right');
			var leftPX = $(this).parent().width();
			$(this).animate({width: sticker_width, left: leftPX}, 300);
			$(this).parent().children('span').animate({width: 0, left: (leftPX - 20)}, 300, function() {
				$(this).css('display', 'none');
			});
		};
		*/ ?>
	});
</script>