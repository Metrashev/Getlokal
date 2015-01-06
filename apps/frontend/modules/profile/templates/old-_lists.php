<?php use_stylesheet('ui-lightness/jquery-ui-1.8.16.custom.css'); ?>
<?php foreach($pager->getResults() as $list): ?>
    <?php $pages = $list->getAllListPage()?>
     <li class="listing_content">
     <a href="<?php echo url_for("list/show?id=".$list->getId())?>" title="<?php echo $list->getTitle();?>">
        <?php if ($list->getImageId()):
            echo image_tag($list->getThumb(0),array('size'=>'119x119', 'alt'=>$list->getTitle() ));
        elseif (count($pages)):

            foreach ($pages as $kay => $company):
                if ($company->getCompanyPage()->getCompany()->getImageId() || $kay==count($pages)-1):
                    echo image_tag($company->getCompanyPage()->getCompany()->getThumb(0),array('size'=>'119x119', 'alt'=> $list->getTitle() ));
                    break;
                endif;
            endforeach;
        endif; ?>
    </a>
    <h2>
        <img alt="<?php echo $list->getIsOpen() ? 'unlocked' : 'locked'?>" title="<?php echo __($list->getIsOpen() ? 'Open' : 'Closed')?>" src="/images/gui/<?php echo $list->getIsOpen() ? 'unlocked' : 'locked'?>.png" />
        <?php /* ?>
        <img title="<?php echo __($list->getIsOpen() ? 'Open' : 'Closed')?>" src="/images/gui/warning.png" />
        */ ?>
        <a href="<?php echo url_for("list/show?id=".$list->getId())?>" title="<?php echo $list->getTitle();?>">
            <?php echo $list->getTitle();?>
        </a>
    </h2>
    <span><?php echo __('by').' '.'<span class="user">'.$list->getUserProfile()->getLink(ESC_RAW).'</span>';?></span>
    <p><?php echo truncate_text(html_entity_decode ($list->getDescription()), 230, '...', true) ?></p>
    <?php /* <a href="<?php echo url_for("list/show?id=".$list->getId())?>" title="" >see full description</a> */ ?>
    <?php /* <span>24 places in this list</span> */ ?>

    <div class="review_content">
        <h3>
            <?php if(isset($show_user) && $show_user):?>
                <?php echo __('by'); ?>
                <span class="user"><?php echo $list->getUserProfile()->getLink(ESC_RAW); ?></span>
            <?php else:?>
            <?php
                 if (count($pages)):
                    $last=count($pages)-1; //echo count($pages);
                    foreach ($pages as $kay=>$page):
                        echo link_to($page->getCompanyPage()->getCompany()->getCompanyTitle(), $page->getCompanyPage()->getCompany()->getUri(ESC_RAW));
                        if ($kay==2 && $kay!=$last): ?>
                        <span><?php echo format_number_choice('[0]No places were added|[1]and one more place|(1,+Inf]and %count% more places', array('%count%' => $last-$kay), $last-$kay,'list'); ?></span>
                        <?php
                            break;
                        endif;
                        if ($kay!=$last): echo ', '; endif;
                    endforeach;
                 endif;?>
            <?php endif;?>
        </h3>
    </div>
    <div class="review_interaction">

    <?php if($is_current_user): ?>
        <?php if ($list->getUserProfile()->getId() == $user->getId()):?>
            <a class="list_delete" href="<?php echo url_for('profile/deleteList?list_id='.$list->getId() )?>"><?php echo __('delete')?></a>
            <a class="list_edit" href="<?php echo url_for('list/edit?id='.$list->getId() )?>" ><?php echo __('edit')?></a>
        <?php else: ?>
            <a id="<?php echo $list->getId()?>" href="javascript:void(0);" data="<?php echo url_for('report/list?id='.$list->getId()) ?>" class="report"><?php echo __('report')?></a>
        <?php endif ?>
    <?php else: ?>
        <a id="<?php echo $list->getId()?>" href="javascript:void(0);" data="<?php echo url_for('report/list?id='.$list->getId()) ?>" class="report"><?php echo __('report')?></a>
    <?php endif ?>
    </div>
    <div class="ajax"></div>
    <div class="clear"></div>
</li>
    <?php endforeach ?>

    <div id="dialog-confirm" title="<?php echo __('Deleting List', null, 'messages') ?>" style="display:none;">
        <p><?php echo __('Are you sure you want to delete your list?', null, 'messages') ?></p>
   </div>

<script type="text/javascript">
    $(document).ready(function() {
/*Delete review */
        $('a.list_delete').live('click',function(event) {

            var deleleReviewLink = $(this).attr('href');
            $("#dialog-confirm").data('id', deleleReviewLink).dialog('open');

            $(".ui-dialog").css("z-index", "2");

            return false;

        });
/*END Delete review */

        $(".review_interaction a.report").click(function() {
            var element = $(this).parent().parent().find('.ajax');

            $.ajax({
                url: $(this).attr('data'),
                beforeSend: function() {
                  $(element).html('<img src="/images/gui/blue_loader.gif"/>');
                },
                success: function(data){
                  $(element).html(data);
                  loading = false;
                  if ($('.profile_list_scroll').length > 0) {
                      if ($('.profile_list_scroll .scrollbar').length > 0) {
                            $('.profile_list_scroll').tinyscrollbar_update('relative');
                      }
                  }
                }
            });

            return false;
        });

    });

    $("#dialog-confirm").dialog({

        resizable: false,
        autoOpen: false,
        height: 250,
        width:340,
        buttons: {
            "<?php echo __('delete', null) ?>": function() {
                 window.location.href =  $("#dialog-confirm").data('id');
            },
            <?php echo __('cancel', null) ?>: function() {
                $(this).dialog("close");
            }
        }
    });
</script>
