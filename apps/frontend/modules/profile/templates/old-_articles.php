<?php use_stylesheet('ui-lightness/jquery-ui-1.8.16.custom.css'); ?>
<?php foreach($pager->getResults() as $article): ?>
	<li class="article_item">
	
		<?php /*?><a href="<?php echo url_for('article',array('sf_culture'=>$article->getLangForCP() , 'slug'=>$article->getSlugForCP() ))?>"> <?php */ ?>
		<?php $secure = $sf_request->isSecure()? 'https://':'http://'?>
		
		<a href="<?php echo $secure.str_replace( getlokalPartner::getDomains(),$article->getArticleDomain(),$sf_request->getHost()).'/'.$article->getLangForCP().'/article/'.$article->getSlugForCP() ?>">
			<?php echo truncate_text( $article->getTitleForCP(), 50, '...', true) ;?>
			<?php if ($article->getStatus() == 'pending'):?>
				<img class="status" src="/images/gui/icon_pending.png" alt="<?php echo __('Pending', null, 'form')?>" />
			<?php elseif ($article->getStatus() == 'rejected'):?>
				<img class="status" src="/images/gui/icon_reject.png" alt="<?php echo __('Rejected', null, 'form')?>" />
			<?php endif;?>
		</a>
		<?php if ($article->getStatus() == 'pending'):?>
			<p class="tooltip_body2"><span><?php echo __('Pending', null, 'form')?></span></p>
		<?php elseif ($article->getStatus() == 'rejected'):?>
			<p class="tooltip_body2"><span><?php echo __('Rejected', null, 'form')?></span></p>
		<?php endif; ?>
		<?php /* ?>
		<a href="<?php echo  url_for('article', array('slug'=>$article->getSlug() ) ) ?>"><?php echo $article->getTitle().' '.$article->getId(); ?></a>
		<?php */?>
		<p><?php echo strip_tags(truncate_text(html_entity_decode ($article->getContentUP( $article->getLangForCP() ) ), 370, '...', true)) ?></p>
		<?php /*?>
		<div class="article_info">
			<?php //echo $article->getUserProfile()->getLink(ESC_RAW); ?> 
			<span><?php //echo date('d.m.Y',strtotime( $article->getCreatedAt() ) );?></span> 
			
		</div>
		
		<div class="article_content">
			
			<?php if ( $article->getArticleImageForIndex() ):?>
			<div class="article_picture_wrap">
				<a href="<?php echo  url_for('article', array('slug'=>$article->getSlug() ) ) ?>" ><img src="<?php echo ZestCMSImages::getImageURL('article', 'big').$article->getArticleImageForIndex()->getFilename();?>" alt="<?php echo $article->getArticleImageForIndex()->getDescrption(); ?>" /></a>        
				<?php if ($article->getArticleImage()->getFirst()->getSource() ):?>
					<p> <?php echo __('Source',null,'article')?>: <?php echo $article->getArticleImageForIndex()->getSource() ;?></p>
				<?php endif;?>
			</div>
			<?php endif;?>
			
		</div>
		*/?>
		<div class="review_interaction">
		    <?php if(is_object($user) && isset($is_current_user) && $article->getUserProfile()->getId() == $user->getId()):?>
		        <a class="list_delete" href="<?php echo url_for('profile/deleteArticle?article_id='.$article->getId() )?>"><?php echo __('delete')?></a>
                <a class="list_edit" href="<?php echo url_for('article/edit?id='.$article->getId() )?>" ><?php echo __('edit')?></a>
            <?php endif ?>

        </div>
        
        <div class="ajax"></div>
        <div class="clear"></div>
    </li>
<?php endforeach ?>

<div id="dialog-confirm" title="<?php echo __('Deleting Article', null, 'messages') ?>" style="display:none;">
        <p><?php echo __('Are you sure you want to delete your article?', null, 'messages') ?></p>
   </div>

<script type="text/javascript">
    $(document).ready(function() {
	    $('.article_item a').each(function() {
    	    var element = $(this);
    	    var tooltip_text = $(this).parent().children('.tooltip_body2');
    	    var leftOffset = element.outerWidth() + 20;
		    var topOffset = 10;
		    tooltip_text.css({'left': leftOffset, 'top': topOffset});
        });
        
        $('.tooltip_body2').hide();
		
        var loading= false;
        
        $('.reply, .report').live("click", function(){
            var href = $(this).attr('data');
            
            if(loading) return false;

            var element = $(this).parent().parent().children('.ajax');
            element.css('display', 'block');
            loading = true;
            $.ajax({
                url: href,
                beforeSend: function() {
              	 $(element).html('<img src="/images/gui/blue_loader.gif"/>');
                },
                success: function(data, url) {
              	 element.html(data);
                  loading = false;
                  if ($('.profile_review_scroll').length > 0) {
                      if ($('.profile_review_scroll .scrollbar').length > 0) {
                  		$('.profile_review_scroll').tinyscrollbar_update('relative');
                      }
                  }
                  //console.log(id);
                },
                error: function(e, xhr)
                {
                  console.log(e);
                }
            });
            return false;
          });

/*Delete review */
        $('a.list_delete').live('click',function(event) {
           
            var deleleReviewLink = $(this).attr('href');
            $("#dialog-confirm").data('id', deleleReviewLink).dialog('open');
            
            $(".ui-dialog").css("z-index", "2");
          
            return false;        
    
        });
/*END Delete review */  
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
    
    $(".article_item").live({
        mouseenter : function() {
            $(this).children('div.review_interaction').children("a.report,a.list_report,a.edit,a.list_edit,a.delete,a.list_delete").fadeIn("fast");
        },
        mouseleave : function() {
            $(this).children('div.review_interaction').children("a.report,a.list_report,a.edit,a.list_edit,a.delete,a.list_delete").fadeOut("fast");
        }    
    });
</script>