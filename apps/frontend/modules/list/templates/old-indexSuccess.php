<?php
use_helper('Pagination');
$lists = $pager->getResults();
$listscount = $pager->getNbResults();
//$culture=$sf_user->getCulture();
?>
<div class="sector-classification-wrap">
    <?php include_component('box', 'boxCategoriesMenu') ?>
</div>

<div class="lists_index_page">
    <div class="content_in">
        <div class="listing_wrap">
            <?php /* <p><?php echo format_number_choice('[0]No lists|[1]1 lists|(1,+Inf]%count% lists', array('%count%' => $listscount), $listscount,'user'); ?></p>  */ ?>
            <?php
            if ($listscount > 0):
                foreach ($lists as $list):
                    include_partial('list/list', array('list' => $list, 'list_user' => $list->getUserProfile()));
                endforeach;
                echo pager_navigation($pager, url_for('list/index'));
            endif;
            ?>
            <!--
            <div class="suggest_info_box">
                    <h3>Can't find the event you are looking for?</h3>
                    <p><a href="#">Send it to us</a> and we will add it</p>
            </div>
            -->
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        var loading= false;

        $(".close_form_report").click(function() {
            $(this).parent().parent().parent().html("");
        });
        
        $(".review_interaction a.report").click(function() {
            var element = $(this).parent().parent().find('.ajax');

            $.ajax({
                url: $(this).attr('data'),
                beforeSend: function() {
                  $(element).html('<img src="/images/gui/blue_loader.gif"/>');
                },
                success: function(data){
                  $(element).html(data);
                }
            });

            return false;
        });

    });
</script>


<div class="sidebar">
    <div class="list_index_page">
        <div class="hp_block">
            <?php if ($is_place_admin_logged): ?>
                <?php $sf_user->setAttribute('redirect_after_login', url_for('list/create')); ?>
                <?php echo link_to(sprintf(__('Login as %s and Create List', null, 'user'), $sf_user->getGuardUser()->getUserProfile()), 'companySettings/logout', array('class' => 'button_pink')) ?>
            <?php else: ?>
                <a class="button_pink_bigger"  href="<?php echo url_for('list/create') ?>"><?php echo __('Create a List Now', null, 'list') ?></a>
<?php endif; ?>
            <div class="clear"></div>
        </div>
    </div>
<?php    /*
<?php if ($video): ?>
        <h3><?php echo __('Latest episode of Getweekend', null, 'list') ?></h3>
        <iframe style="margin-bottom:25px;" width="300" height="170" src="http://www.youtube.com/embed/<?php echo $video->getEmbed() ?>?rel=0" frameborder="0" allowfullscreen></iframe>
    <?php endif; ?>
*/ ?>
    <?php include_partial('global/ads', array('type' => 'box')) ?>
    <?php if ($sf_user->getCountry()->getSlug()!= 'fi'):?>  
        <?php include_component('home','social_sidebar'); ?>
    <?php endif;?> 
    <?php //include_component('box', 'column', array('key' => 'home', 'column' => 2));  ?>
    <div style="margin: 57px 0 20px 0">
        <?php include_component('box', 'boxOffers') ?>
    </div>
    <?php include_component('box', 'boxVip') ?>
    <?php if ($sf_user->getAttribute('country_id') == getlokalPartner::GETLOKAL_RO): ?>
         <?php  include_partial('global/ads', array('type' => 'box2')); ?>  
    <?php endif;?> 
</div>
<?php /* ?>
  <?php if(!$is_place_admin_logged):?>
  <script type="text/javascript">
  $(document).ready(function() {
  $('.path_buttons').html('<a class="button_pink" href="<?php echo url_for("list/create" )?>"><?php echo __("Create List", null, "list")?></a>');
  })
  </script>
  <?php endif; */ ?>
