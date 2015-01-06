<?php use_helper('Date','Frontend');
$pages = $list->getAllListPage();
?>
<li>
    <div class="list-content-image">
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
    </div>

    <div class="list-content-description">
    	<a class="list-content-desc-title" href="<?php echo url_for("list/show?id=".$list->getId())?>" title="<?php echo $list->getTitle();?>">
		<h2><?php echo $list->getTitle();?></h2>
		</a>
    	<span class="list-uploaded-by"><?php echo __('by')?></span><span class="uploader-name-list"><?php echo $list->getUserProfile()->getLink(ESC_RAW); ?></span>
    	<p class="list-txt"><?php echo truncate_text(html_entity_decode ($list->getDescription()), 230, '...', true) ?></p>
    	<?php 
     if (count($pages)): 
     	$last=count($pages)-1; //echo count($pages);
     	foreach ($pages as $kay=>$page):
     		echo link_to($page->getCompanyPage()->getCompany()->getCompanyTitle(), $page->getCompanyPage()->getCompany()->getUri(ESC_RAW), array('title' => $page->getCompanyPage()->getCompany()->getCompanyTitle(), 'class' => 'list-places'));
     		if ($kay==2 && $kay!=$last): ?>
     		<a class="list-more"><?php echo format_number_choice('[0]No places were added|[1]and one more place|(1,+Inf]and %count% more places', array('%count%' => $last-$kay), $last-$kay,'list'); ?></a>
     		<?php 
     			break;
     		endif;
    		if ($kay!=$last): echo ', '; endif;
     	endforeach;
     endif;?>
    </div>

    <div class="list-report">
    	<?php if(!$sf_user->getGuardUser() || ($sf_user->getGuardUser()->getId()!=$list->getUserId()) ): ?> 
			<a id="<?php echo $list->getId()?>" href="javascript:void(0);" data="<?php echo url_for('report/list?id='.$list->getId()) ?>" class="list-report-link"><?php echo __('report')?></a> 
		<?php endif ?>
    </div>
    <div class="ajax"></div>
</li>

<script type="text/javascript">
    $(document).ready(function() {
        var loading= false;

        $(".close_form_report").click(function() {
            $(this).parent().parent().parent().html("");
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
                }
            });

            return false;
        });

    });
</script>