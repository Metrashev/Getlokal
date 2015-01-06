<?php
include_partial('global/commonSlider');
$params = array('company' => $company, 'adminuser' => $adminuser, 'companies' => $companies, 'is_getlokal_admin' => $is_getlokal_admin);
?>
<?php use_helper('Date'); ?>
<?php $culture = $sf_user->getCulture(); ?>

<?php if (!$month):?>
	<div class="user_notifications" id="user_notifications">
<?php endif;?>

<div class="container set-over-slider">
    <disv class="row">	
        <div class="container">
            <div class="row">
                <?php include_partial('topMenu', $params); ?>	
            </div>
        </div>	          
	

    <div class="col-sm-3">
        <div class="section-categories">
            <?php include_partial('rightMenu', $params); ?>	            
        </div>
    </div>
    <div class="col-sm-9">
        <div class="content-default">	            
            <form action="<?php echo url_for('companySettings/changeEmail') ?>" method="post" class="default-form clearfix">
                <div class="row">
                    <div class="default-container default-form-wrapper col-sm-12 p-15">
                        <div class="col-sm-12">
                            <?php include_partial('tabsMenu', $params); ?>	   
                        </div>
                        <h2 class="form-title"><?php echo __('Stats for ', null, 'company') . link_to_company($company, array('class' => 'default-link')); ?></h2>

                        <?php
                        $get_month = ($month ? $month : date('Y-m') . '-01');
                        if ($statsa = $company->getPrevMonths(true)) {
                            ?>

                            <div class="row">
                                <div class="col-sm-6 center-block remove-float">
                                    <div class="default-input-wrapper select-wrapper">
                                        <select class="default-input" id="stats">
                                            <?php foreach ($statsa as $key => $val) { ?> 
                                                <option value ="<?php echo $key; ?>" <?php echo ($get_month == $key ? ' selected="selected"' : '') ?>><?php echo format_date($val, 'MMM yyyy', $culture); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="loader"></div>

                            <div class="row selection-details">
                                <div class="col-sm-6 center-block remove-float">
                                    <!-- <label for="stats"> <?php echo format_date($get_month, 'MMM yyyy', $culture); ?></label> -->

                                    <script>
                                        $(function() {
                                            $('.loader').append(LoaderHTML);
                                            $('.loader').hide();
                                        });

                                        $('select').change(function() {
                                            $('.selection-details').hide();
                                            $('.loader').show();
                                            $.post("<?php url_for('companySettings/statistics?slug=' . $company->getSlug()) ?>", {with_month: $(this).val()}, function(data) {
                                                success: 
                                                    $('#user_notifications').html(data);
                                                    $('.selection-details').show();
                                            });
                                        });

                                    </script>
                                <?php } ?>

                                <?php if (!$month or $month == date('Y-m') . '-01') { ?>
                                    <div class="business_brief col-sm-12">
                                        <div class="value"><?php echo $company->getAverageRating(); ?></div>
                                        <div class="descript"> - <?php echo __('Rating', null, 'company'); ?></div>
                                    </div>
                                    <div class="business_brief col-sm-12">
                                        <div class="value"><?php echo $company->getNumberOfReviews() ?></div>
                                        <div class="descript"> - <?php echo __('Reviews') ?> </div>
                                    </div>
                                <?php } ?>

                                <?php
                                if ($company->getStatsPerMonth($get_month)) {
                                    $stats = $company->getStatsPerMonth($get_month);
                                    foreach ($stats as $key => $val) {

                                        switch ($key) {
                                            case 1:
                                                $string = 'Views in search';
                                                break;
                                            case 2:
                                                $string = 'Company Page Visits';
                                                break;
                                            case 3:
                                                $string = 'Clicks to website';
                                                break;
                                            case 4:
                                                $string = 'Clicks to Facebook page';
                                                break;
                                            case 5:
                                                $string = 'Sent Emails';
                                                break;
                                            case 13:
                                                $string = 'Views in search';
                                                break;
                                            case 14:
                                                $string = 'Clicks to Twitter page';
                                                break;
                                            case 15:
                                                $string = 'Clicks to Foursquare page';
                                                break;
                                            case 16:
                                                $string = 'Clicks to Google+ page';
                                                break;
                                            case 17:
                                                $string = 'Clicks to Yellow Pages page';
                                                break;
                                        }
                                        ?>

                                        <?php if ($key != sfConfig::get('app_log_actions_company_show_category') && $key != sfConfig::get('app_log_actions_company_show_search')) { ?>
                                            <div class="business_brief col-sm-12">
                                                <div class="value"><?php echo $val; ?></div>
                                                <div class="descript"> - <?php echo __($string, null, 'company') ?></div>
                                            </div>
                                        <?php } else { ?>
                                            <?php if ($key == sfConfig::get('app_log_actions_company_show_category') && !isset($stats[sfConfig::get('app_log_actions_company_show_search')])) { ?>
                                                <div class="business_brief col-sm-12">
                                                    <div class="value"><?php echo $val; ?></div>
                                                    <div class="descript"> - <?php echo __($string, null, 'company'); ?></div>
                                                </div>
                                            <?php } elseif ($key == sfConfig::get('app_log_actions_company_show_search')) { ?>
                                                <div class="business_brief col-sm-12">
                                                    <?php
                                                    if (isset($stats[sfConfig::get('app_log_actions_company_show_category')])) { ?>
                                                        <div class="value"><?php echo $val + $stats[sfConfig::get('app_log_actions_company_show_category')];?></div>
                                                    <?php } else { ?>
                                                        <div class="value"><?php echo $val; ?></div>
                                                    <?php } ?>

                                                    <div class="descript"> - <?php echo __($string, null, 'company'); ?></div>

                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>        
</div>


<?php if (!$month):?>
</div>
<?php endif;?>