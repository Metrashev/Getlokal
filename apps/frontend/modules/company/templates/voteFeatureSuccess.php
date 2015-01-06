<?php $vote = sfContext::getInstance()->getRequest()->getParameter("vote"); ?>
<ul>
	<li class="voted-thumb">
	 <a href="<?php echo url_for('company/voteFeature?page_id='. $placeFeature->getPageId() .'&feature_id='.$placeFeature->getFeatureId().'&vote=yes')?>" class="vote_yes"><i class="fa fa-thumbs-up"></i><?php echo $placeFeature->getVotedYes() ?></a>
  </li>

  <li class="voted-thumb">
   <a href="<?php echo url_for('company/voteFeature?page_id='. $placeFeature->getPageId() .'&feature_id='.$placeFeature->getFeatureId().'&vote=no')?>" class="vote_no"><i class="fa fa-thumbs-down"></i><?php  echo $placeFeature->getVotedNo() ?></a>
  </li>
</ul>

<script type="text/javascript">
$('.vote_yes, .vote_no').click(function() {
    var element = this;

    $.ajax({
        url: this.href,

        success: function(data, url) {
          $(element).parent().parent().parent().html(data);
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
