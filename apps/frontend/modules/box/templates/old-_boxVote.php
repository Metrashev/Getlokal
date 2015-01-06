<div class="hp_2columns_right">
    <div class="vote_titile_wrap">
        <h2 itemprop="name"><?php echo $title?><?php echo __(' for ', null, 'messages') ?><?php echo $company->getCompanyTitle() ?></h2>
    </div>
    <ul class="hp_2columns_voting_list">
	  	<?php foreach ($futures as $future):?>
	  	<li  id="<?php echo $future->getId() ?>">
		    <p><?php echo $future->getName()?></p>
		    <?php //echo $future->getPlaceFeature()->getId();exit();?>
		    <div class="vote_wrap red">
		    	<?php  echo ( count($future->getPlaceFeature()) )? $future->getVotNo(): '0' ?>
		    	<a href="<?php echo url_for('company/voteFeature?page_id='. $pageId .'&feature_id='.$future->getId().'&vote=no')?>" class="vote_no"><img alt="<?php echo __("vote") ?>" src="/images/gui/icon_vote_bg.png"></img></a>
	    	</div>
		    <div class="vote_wrap green">
		    	<a href="<?php echo url_for('company/voteFeature?page_id='. $pageId .'&feature_id='.$future->getId().'&vote=yes')?>" class="vote_yes"><img alt="<?php echo __("vote") ?>" src="/images/gui/icon_vote_bg.png"></img></a>
		    	<?php echo ( count($future->getPlaceFeature()) )? $future->getVotYes():'0' ?>
		    </div>
	    </li>
	    <?php endforeach;?>
	</ul>
	<a id="vote_menu_colapse_li" href="javascript:void(0)"><?php echo __('see all', null, 'messages')?></a>
	<a id="vote_menu_colapse2_li" href="javascript:void(0)"><?php echo __('hide', null, 'messages')?></a>
</div>
<div class="clear"></div>
<script type="text/javascript">
$('.vote_yes, .vote_no').click(function() {
    var element = this;

    $.ajax({
        url: this.href,

        success: function(data, url) {
          $(element).parent().parent().html(data);
          loading = false;
          //console.log(url);
        },
        error: function(e, xhr)
        {
          console.log(e);
        }
    });
    return false;
  });
</script>