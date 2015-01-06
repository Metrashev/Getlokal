<div class="gray_bg_mobile">
    <div class="mobile_app__wrapper">    
        <div id="content">
          <div class="company event">
            <a href="getlokal://images" class="image">
              <img src="<?php echo image_path($event->getThumb(2)) ?>" />
            </a>
              <div class="event_title_wrapper">
                <h1 class="event_title"><?php echo $event->getDisplayTitle() ?></h1>  
              </div>
            <?php if($event->getFirstCompany()): ?>
            <div class="col_event">
              <div class="icon"><?php echo image_tag('mobile/pink_marker_mobile_events.png') ?></div>

              <div class="event_place">
                <p><a href="<?php echo $companyUrl ?>"><?php echo $event->getFirstCompany() ?></a></p>
                <p class="distance_to_event"><?php echo number_format($event->kms, 2) ?> <?php echo __('km') ?></p>
              </div>
              <div class="clear"></div>
            </div>
            <?php endif ?>

            <div class="col_event">
                    <div class="icon"><?php echo image_tag('mobile/hours_b.png') ?></div>

                    <div class="text">
                      <p><?php echo $event->getDateTimeObject('start_at')->format('d / m / y') ?></p>
                    </div>

                    <div class="event_start_hour">          
                        <p><?php if ($event->getStartH()) : ?>
                            <?php echo substr($event->getStartH(), 0, -3); ?>
                        <?php endif; ?></p>
                    </div>   
                    <div class="clear"></div>
                  <div class="rspv_event">
                    <div class="attend_button">
                      <a href="getlokal://status">
                        <?php echo __('ATTEND') ?>
                      </a>
                    </div>    
                    <div class="count">
                      <?php echo __('%d participants', array('%d' => '<strong>'.$no_rspv.'</strong>')) ?>
                    </div>
                    <div class="clear"></div>
                    <div class="details">
                    <p><?php echo $event->getDisplayDescription(ESC_RAW) ?></p>
                    </div>
                  </div>
             </div>
          </div>
        </div>
    </div>
</div>    
<script type="text/javascript">
    //CALL
    $(document).ready(function () {
        $(".attend_button").on('touchstart', function (event) {
            $(".attend_button").addClass('tap');
        });

        $(".attend_button").on('touchend', function (event) {
            $(".attend_button").removeClass('tap');
        });
    });
</script>