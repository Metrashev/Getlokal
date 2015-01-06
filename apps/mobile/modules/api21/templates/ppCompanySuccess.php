<?php
    $isSecProto = "http" . (@$_SERVER['HTTPS'] ? 's' : '');
    $path = $isSecProto . "://maps.google.com/maps/api/js?sensor=true&libraries=places&language=" . $sf_user->getCulture();

    use_javascript('/js/map.js');
    use_javascript($path);
?>


<div id="content">
    <div class="mobile_ppp_company">
        <div class="company">
            <div class="content_area">
                <div class="image pp_company_header">
                    <?php if (count($company->getCompanyImage())) : ?>
                        <a href="getlokal://images">
                            <img src="<?php echo image_path($company->getThumb(0)) ?>" />
                        </a>
                    <?php endif; ?>

                    <h2 class="title_pp"><?php echo $company->getCompanyTitleByCulture(); ?></h2>

                    <div class="review_cnt">

                        <?php echo format_number_choice('[0]No reviews|[1]<span>1</span> review|(1,+Inf]<span>%count%</span> reviews', array('%count%' => $company->getNumberOfReviews()), $company->getNumberOfReviews(),'messages'); ?>
                        <div class="about_pp">
                            <div class="rating">
                                <?php echo image_tag('mobile/starsBg.png') ?>
                                <div class="fill" style="width: <?php echo $company->getRating() ?>%">
                                    <?php echo image_tag('mobile/stars.png') ?>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="distance_to_pp">
                        <p><?php echo number_format($company->kms, 2); ?> <?php echo __('km') ?></p>
                    </div>
                </div>

                <?php if ($company->getPhone()) : ?>
                    <div class="call">
                        <div class="phone_icon"></div>
                        <a href="getlokal://call?<?php echo $company->getPhoneFormated($company->getPhone(), $sf_user->getCulture()) ?>"><strong><?php echo __('CALL') ?></strong> <?php echo $company->getPhoneFormated($company->getPhone(), $sf_user->getCulture()) ?></a>
                    </div>
                <?php endif; ?>

                <div class="clear"></div>

                <?php if ($company->getCompanyDetail()&& $company->getCompanyDetail()->getHourFormatCPage('wed')): ?>
                    <div class="working_hours">
                        <div class="icon"><?php echo image_tag('mobile/hours_b.png') ?></div>

                        <div class="text">
                            <?php foreach ($company->getCompanyDetail()->getWorkingHours() as $hour): ?>
                                <strong><?php echo $hour['time'] ?></strong>  <span><?php echo __($hour['day']) ?></span><br/>
                            <?php endforeach ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                <?php endif ?>

                 <div class="function_tabs">
                    <ul>
                        <li id="addReview">
                            <a href="getlokal://review"><span class="review_icon"></span><?php echo __('Review') ?></a>
                        </li>
                        <li id="addPhoto">
                            <a href="getlokal://takephoto"><span class="add_photo"></span><?php echo __('Add Pic') ?></a>
                        </li>
                        <li id="follow" <?php echo ($is_favorite) ? 'class="tapped"' : '' ?>>
                            <a href="getlokal://favorite"><span class="follow"></span><?php echo ($is_favorite) ? __('Unfollow') : __('Follow') ?></a>
                        </li>
                        <li id="checkin" <?php echo ($is_check_in) ? 'class=" tapped"' : '' ?>>
                            <a href="getlokal://checkin"><span class="check_in"></span><?php echo __('Check-in') ?></a>

                            <div class="clear"></div>
                        </li>
                    </ul>
                    <div class="clear"></div>
                </div>

                <div class="map_wrapper">
                     <a href="getlokal://map">
                        <img src="http://maps.googleapis.com/maps/api/staticmap?center=<?php echo $company->getLocation()->getLatitude() ?>,<?php echo $company->getLocation()->getLongitude() ?>&zoom=15&size=298x93&maptype=roadmap&markers=icon:<?php echo image_path('gui/icons/marker_'. $company->getSectorId(), true) ?>%7Cshadow:false%7C<?php echo $company->getLocation()->getLatitude() ?>,<?php echo $company->getLocation()->getLongitude() ?>&sensor=false" class="map_image" />
                    </a>
                    <?php /*<div id="map_canvas" style="width: 100%; height: 93px;"></div> */ ?>
                    <div class="clear"></div>
                    <div class="place_address">
                        <div class="address">
                            <?php if ($company->getDisplayAddress()): ?>
                                <p><?php echo $company->getDisplayAddress(); ?></p>
                            <?php endif ?>
                        </div>
                        <a  href="getlokal://map">
                            <?php echo image_tag('mobile/goto_icon.png') ?>
                        </a>

                        <div class="clear"></div>
                    </div>
                </div>


                <?php if ($company->getNumberOfReviews()): ?>
                    <h4><?php echo __('REVIEWS') ?><span> (<?php echo $company->getNumberOfReviews() ?>)</span></h4>

                    <div class="reviews">
                        <?php foreach ($reviews as $review): ?>
                            <div class="review_wrapper">
                                <?php echo image_tag($review->getUserProfile()->getThumb(0), array('size' => '72x72')) ?>

                                <div class="review_details">
                                    <p class="review_date"><?php echo $review->getDateTimeObject('created_at')->format('d.m.Y') ?></p>
                                    <p class="reviewer_name"><?php echo $review->getUserProfile() ?></p>
                                   <!-- <div class="fill" style="width: <?php echo $review->getRatingProc() ?>%"><?php echo image_tag('mobile/stars.png') ?></div> -->
                                    <div class="rating">
                                         <?php echo image_tag('mobile/starsBg.png') ?>
                                         <div class="fill" style="width: <?php echo $review->getRatingProc() ?>%">
                                             <?php echo image_tag('mobile/stars.png') ?>
                                         </div>
                                     </div>
                                    <br>
                                    <p class="user_review"><?php echo $review->getText(ESC_RAW) ?></p>

                                    <?php $answers = $review->getAnswers(); ?>
                                    <?php if (isset($answers) && count($answers) && $answers) : ?>
                                    <div class="clear"></div>
                                        <div id="wrapper">
                                            <ul>
                                                <?php foreach ($answers as $answer) : ?>
                                                    <li>
                                                        <div class="owners_replies">
                                                            <?php echo image_tag($answer->getUserProfile()->getThumb(0), array('size' => '72x72')) ?>
                                                            <div class="owners_replies_details">
                                                                <p class="review_date"><?php echo $answer->getDateTimeObject('created_at')->format('d.m.Y') ?></p>
                                                                <p class="owner_name"><?php echo $answer->getUserProfile() ?></p>
                                                                <p class="owner_answer"><?php echo $answer->getText(ESC_RAW) ?></p>
                                                            </div>
                                                         </div>
                                                    </li>
                                                <?php endforeach; ?>
                                                    <div class="clear"></div>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="clear"></div>
                            </div>
                        <?php endforeach ?>
                    </div>
                <?php endif ?>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
<?php /*
        // Start Google map initialization
        var map_center = new google.maps.LatLng(<?php echo $company->getLocation()->getLatitude() ?>, <?php echo $company->getLocation()->getLongitude() ?>);

        var myOptions = {
            center: map_center,
            zoom: 14,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            streetViewControl: true
        };

        var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

        var marker = new google.maps.Marker ({
            map: map,
            position: map_center,
            title: '<?php echo $company->getCompanyTitle() ?>',
            icon: '/images/gui/icons/small_marker_'+<?php echo $company->getSectorId() ?>+'.png'
        });
        // End Google map initialization
*/ ?>



        $(".call").on('touchstart', function (event) {
            $(".call").addClass('tap');

        });
        $(".call").on('touchend', function (event) {
            $(".call").removeClass('tap');

        });

        //ADD REVIEW OR PHOTO
        $('.function_tabs ul li#addPhoto').on('touchstart', function (event) {
            $(this).addClass('tapped');
            $(this).on('touchend', function (event) {
                $(this).removeClass('tapped');
            });
        });
        $('.function_tabs ul li#addReview').on('touchstart', function (event) {
            $(this).addClass('tapped');
            $(this).on('touchend', function (event) {
                $(this).removeClass('tapped');
            });
        });

        //FOLLOW & UNFOLLOW
        $('.function_tabs ul li#follow').live('click', function (e) {
            //e.preventDefault();
            $button = $(this);
            if ($button.hasClass('tapped')) {

                //$.ajax(); Do Unfollow

                $button.removeClass('tapped');
                // $button.removeClass('unfollow');
                $('.function_tabs  ul li#follow a').html('<span class="follow"></span><?php echo __('Follow') ?>');
            } else {

                // $.ajax(); Do Follow

                $button.addClass('tapped');
                $('.function_tabs  ul li#follow.tapped a').html('<span class="follow"></span><?php echo __('Unfollow') ?>');
            }
        });

        //CHECK IN
        $('.function_tabs  ul li#checkin').live('click', function (e) {
            //e.preventDefault();
            $button = $(this);
            if ($button.hasClass('tapped')) {
                //$button.removeClass('tapped');
            } else {
                $button.addClass('tapped');
            }
        });
    });
</script>
