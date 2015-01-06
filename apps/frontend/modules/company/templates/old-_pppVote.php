<div class="vip_vote_wrap">
	<img class="btn_close" src="/images/gui/close_small.png" alt="close" />
	<a href="#">
                <h2 itemprop="name"><?php echo __('Vote')?><?php echo __(' for ', null, 'messages') ?><?php echo $company->getCompanyTitle() ?></h2>
		<img alt="<?php echo __("down") ?>" src="/images/gui/arrow_down_blue.png" />
		<div class="right">
                    <img alt="<?php echo __("yes") ?>" src="/images/gui/icon_vote_yes.png" />
                    <span class="green"><?php echo $place_vote[0]->getVotYes()?></span>
                    <img alt="<?php echo __("no") ?>" class="no_img" src="/images/gui/icon_vote_no.png" />
                    <span class="red"><?php echo $place_vote[0]->getVotNo()?></span>
                </div>
	</a>
	<?php include_component('box','boxVote', array('company'=>$company, 'title'=> '' ) );?>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$('.vip_vote_wrap').click(function() {
		var elem = $(this);
		if ($('.hp_2columns_right').css('display') == 'none') {
			$('.hp_2columns_right').slideDown('fast', function() {
				$(this).show();
			});
			elem.children('a').children('img').attr('src', '/images/gui/arrow_down_gray.png');
			elem.addClass('vote_wrap_opened');
		}
		else {
			$('.hp_2columns_right').slideUp('fast', function() {
				$(this).hide();
				elem.removeClass('vote_wrap_opened');
				elem.children('a').children('img').attr('src', '/images/gui/arrow_down_blue.png');
			});
		}
		result = 0;
		$('ul.hp_2columns_voting_list li div.green').each(function() {
			result += parseInt($(this).text());
		});
		$('.vip_vote_wrap a span').children('.green').text(result);

		result = 0;
		$('ul.hp_2columns_voting_list li div.red').each(function() {
			result += parseInt($(this).text());
		});
		$('.vip_vote_wrap a span').children('.red').text(result);
		return false;
	});
});
</script>