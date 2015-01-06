<?php
	use_helper('Pagination');
	use_helper('Date', 'Frontend');
?>

<h2><?php echo __('Lists'); ?></h2>
<div class="all-lists">
    <a class="default-btn add-new-list-btn" href="<?php echo url_for('list/create') ?>"><?php echo __('Create a List Now', null, 'list') ?></a>
</div>

<?php if ($pager->getNbResults() == 0) { ?>
    <p class="flash_error"><?php echo __('There are no Lists'); ?></p>
<?php } else { ?>

    <div class="list-content">
        <ul>
            <?php foreach ($pager->getResults() as $list) { ?>
                <?php $pages = $list->getAllListPage(); ?>
                <li>
                    <div class="list-content-image">
                        <a href="<?php echo url_for("list/show?id=" . $list->getId()) ?>" title="<?php echo $list->getTitle(); ?>">
                            <?php
                            if ($list->getImageId()):
                                echo image_tag($list->getThumb(0), array('size' => '119x119', 'alt' => $list->getTitle()));
                            elseif (count($pages)):

                                foreach ($pages as $kay => $company):
                                    if ($company->getCompanyPage()->getCompany()->getImageId() || $kay == count($pages) - 1):
                                        echo image_tag($company->getCompanyPage()->getCompany()->getThumb(0), array('size' => '119x119', 'alt' => $list->getTitle()));
                                        break;
                                    endif;
                                endforeach;
                            endif;
                            ?>
                        </a>
                    </div>

                    <div class="list-content-description">
                        <a class="list-content-desc-title" href="<?php echo url_for("list/show?id=" . $list->getId()) ?>" title="<?php echo $list->getTitle(); ?>">
                            <h2><?php echo $list->getTitle(); ?>
								<?php 
                            		$c_ = $list->getIsOpen() ? "unlock" : "lock";
                            		$t_ = $list->getIsOpen() ? "This list is open." : "This list is locked.";
                            	?>
                            	<span class="page-icon-list <?= $c_?>"> <!-- !!!!!! change class lock / unlock to change icon -->
                                    <span class="wrapper-tooltip-list-details"><span class="tooltip-arrow-lists"></span><span class="tooltip-body-lists"><?= $t_?></span></span>
                                </span>
                            </h2>
                        </a>
                        <span class="list-uploaded-by"><?php echo __('by') ?></span><span class="uploader-name-list"><?php echo $list->getUserProfile()->getLink(ESC_RAW); ?></span>
                        <p class="list-txt"><?php echo truncate_text(html_entity_decode($list->getDescription()), 230, '...', true) ?></p>
                        <?php
                        if (count($pages)):
                            $last = count($pages) - 1; //echo count($pages);
                            foreach ($pages as $kay => $page):
                                echo link_to($page->getCompanyPage()->getCompany()->getCompanyTitle(), $page->getCompanyPage()->getCompany()->getUri(ESC_RAW), array('title' => $page->getCompanyPage()->getCompany()->getCompanyTitle(), 'class' => 'list-places'));
                                if ($kay == 2 && $kay != $last):
                                    ?>
                                    <a class="list-more"><?php echo format_number_choice('[0]No places were added|[1]and one more place|(1,+Inf]and %count% more places', array('%count%' => $last - $kay), $last - $kay, 'list'); ?></a>
                                    <?php
                                    break;
                                endif;
                                if ($kay != $last): echo ', ';
                                endif;
                            endforeach;
                        endif;
                        ?>
                    </div>

                    <div class="list-report">
                        <!-- <a href="#" class="list-report-link"><?php //echo __('report'); ?></a> -->
                    



                    <?php if($is_current_user){ ?>
				        <?php if ($list->getUserProfile()->getId() == $user->getId()):?>
				            <a class="list-delete" href="<?php echo url_for('profile/deleteList?list_id='.$list->getId() )?>"><?php echo __('delete')?></a>
				            <a class="list-edit" href="<?php echo url_for('list/edit?id='.$list->getId() )?>" ><?php echo __('edit')?></a>
				        <?php else: ?>
				            <a id="<?php echo $list->getId()?>" href="javascript:void(0);" data="<?php echo url_for('report/list?id='.$list->getId()) ?>" class="list-report-link"><?php echo __('report')?></a>
				        <?php endif ?>
				    <?php } else{ ?>
				        <a id="<?php echo $list->getId()?>" href="javascript:void(0);" data="<?php echo url_for('report/list?id='.$list->getId()) ?>" class="list-report-link"><?php echo __('report')?></a>
				    <?php } ?>

				    </div>
				    <div class="ajax"></div>
                </li>
    		<?php } ?>
        </ul>         
    </div>
<?php } ?>

<div id="dialog-confirm" title="<?php echo __('Deleting List', null, 'messages') ?>" style="display:none;">
    <p><?php echo __('Are you sure you want to delete your list?', null, 'messages') ?></p>
</div>

<?php echo pager_navigation($pager, url_for('profile/lists?username='. $pageuser->getUsername())); ?>


<script type="text/javascript">

    $('a.list-delete').click(function(event) {
        var deleleReviewLink = $(this).attr('href');
        $("#dialog-confirm").data('id', deleleReviewLink).dialog('open');
        // $(".ui-dialog").css("z-index", "2");
        return false;
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
            <?php echo __('cancel', null, 'company') ?>: function() {
                $(this).dialog("close");
            }
        }
    });

    $(".list-report-link").click(function() {
        var element = $(this).parent().parent().find('.ajax');

        $.ajax({
            url: $(this).attr('data'),
            beforeSend: function() {
              $(element).html(LoaderHTML);
            },
            success: function(data){
              $(element).html(data);
              loading = false;
            }
        });

        return false;
    });
</script>
