		    <p><?php echo $placeFeature->getFeature()->getName()?></p>
		    <?php //echo $future->getPlaceFeature()->getId();exit();?>
		    <div class="vote_wrap red">
		    	<?php  echo $placeFeature->getVotedNo() ?>
		    	<a href="<?php echo url_for('company/voteFeature?page_id='. $placeFeature->getPageId() .'&feature_id='.$placeFeature->getFeatureId().'&vote=no')?>" class="vote_no"><img src="/images/gui/icon_vote_bg.png"></img></a>
			</div>
		    <div class="vote_wrap green">
		    	<?php echo $placeFeature->getVotedYes() ?>
		    	<a href="<?php echo url_for('company/voteFeature?page_id='. $placeFeature->getPageId() .'&feature_id='.$placeFeature->getFeatureId().'&vote=yes')?>" class="vote_yes"><img src="/images/gui/icon_vote_bg.png"></img></a>
		    </div>

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