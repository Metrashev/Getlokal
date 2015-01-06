
          <div class="voting-section hidden-sm hidden-xs">
            <div class="voting-head">
              <h4><?php echo __('Vote'); ?></h4>
              <h3><?php echo $title; ?><?php echo __(' for ', null, 'messages') ?><?php echo $company->getI18nTitle() ?></h3>
            </div><!-- voting-head -->

            <div class="voting-body">
              <div class="cols">
                <div class="col-col-1of2 left-table">
                  <table>
                    <thead></thead>
                    <tbody>
                      <?php
                        $half = count($futures) / 2;
                        for($i = 0; $i < (int) $half; $i++){
                      ?>
                        <tr>
                          <td class="vote-category"><?php echo $futures[$i]['name']; ?></td>
                          <td>
                            <ul>
                              <li class="vote-thumb-up"><a href="<?php echo url_for('company/voteFeature?page_id='. $pageId .'&feature_id='.$futures[$i]['id'].'&vote=yes')?>" class="vote_yes"><i class="fa fa-thumbs-up"></i><?php echo $futures[$i]['vot_yes'] ? $futures[$i]['vot_yes'] : '0'; ?></a></li>
                              <li class="vote-thumb-down"><a href="<?php echo url_for('company/voteFeature?page_id='. $pageId .'&feature_id='.$futures[$i]['id'].'&vote=no')?>" class="vote_no"><i class="fa fa-thumbs-down"></i><?php echo $futures[$i]['vot_no'] ? $futures[$i]['vot_no'] : '0'; ?></a></li>
                            </ul>
                          </td>
                        </tr>
                      <?php } ?> 
                    </tbody>
                    <tfoot></tfoot>
                  </table>
                </div><!-- col-col-1of2 -->

                <div class="col-col-1of2 right-table">
                  <table>
                    <thead></thead>
                    <tbody>
                      <?php for($i = (int) $half; $i < count($futures); $i++){ ?>
                        <tr>
                          <td class="vote-category"><?php echo $futures[$i]['name']; ?></td>
                          <td>
                            <ul>
                              <li class="vote-thumb-up"><a href="<?php echo url_for('company/voteFeature?page_id='. $pageId .'&feature_id='.$futures[$i]['id'].'&vote=yes')?>" class="vote_yes"><i class="fa fa-thumbs-up"></i><?php echo $futures[$i]['vot_yes'] ? $futures[$i]['vot_yes'] : '0'; ?></a></li>
                              <li class="vote-thumb-down"><a href="<?php echo url_for('company/voteFeature?page_id='. $pageId .'&feature_id='.$futures[$i]['id'].'&vote=no')?>" class="vote_no"><i class="fa fa-thumbs-down"></i><?php echo $futures[$i]['vot_no'] ? $futures[$i]['vot_no'] : '0'; ?></a></li>
                            </ul>
                          </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                    <tfoot></tfoot>
                  </table>
                </div><!-- col-col-1of2 -->
              </div><!-- cols -->
            </div><!-- voting-body -->

            <div class="voting-foot">
              
              <div class="row">
                <div class="col-sm-12">
                  <div class="custom-row toggle-row show-more">
                    <div class="center-block txt-more">
                      <i class="fa fa-angle-double-down fa-lg"></i>
                      <span><?php echo __('SHOW MORE', null, 'company'); ?></span>
                      <i class="fa fa-angle-double-down fa-lg"></i>
                    </div>

                    <div class="center-block txt-less">
                      <i class="fa fa-angle-double-up fa-lg"></i>
                      <span><?php echo __('SHOW LESS', null, 'company'); ?></span>
                      <i class="fa fa-angle-double-up fa-lg"></i>
                    </div>
                  </div><!-- Form Show-more-less Bar -->
                </div>
              </div>

            </div><!-- voting-foot -->
          </div><!-- voting-section -->
        

 <div class="wrapper-voting-sm hidden-md hidden-lg">
    <ul>
      <li class="voting-title">Местоположение</li>
      <li class="voting-vote-up"><a class="vote-up" href="#"><i class="fa fa-thumbs-up"></i>20</a></li>
      <li class="voting-vote-down"><a class="vote-down" href="#"><i class="fa fa-thumbs-down"></i>20</a></li>
    </ul>
        <ul>
      <li class="voting-title">Подходящо за деца</li>
      <li class="voting-vote-up"><a class="vote-up" href="#"><i class="fa fa-thumbs-up"></i>20</a></li>
      <li class="voting-vote-down"><a class="vote-down" href="#"><i class="fa fa-thumbs-down"></i>20</a></li>

    </ul>
        <ul>
      <li class="voting-title">За специални случаи</li>
      <li class="voting-vote-up"><a class="vote-up" href="#"><i class="fa fa-thumbs-up"></i>20</a></li>
      <li class="voting-vote-down"><a class="vote-down" href="#"><i class="fa fa-thumbs-down"></i>20</a></li>
    </ul>
  </div> 


<script type="text/javascript">
$('.vote_yes, .vote_no').click(function() {
    $(this).addClass('voted');
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