<div class="article-author">
    <div class="avatar">
        <?php echo image_tag($article->getUserProfile()->getThumb(), array('size'=>'150x150', 'alt'=>'')) ?>
    </div>
    <div class="info">
        <?php echo __("This article is created by", null, 'article'); ?>
        <div class="name"><?php echo $article->getUserProfile()->getLink(ESC_RAW); ?></div>
    </div>
    <div class="clear"></div>
    <div class="more">
        <?php 
            echo link_to(
                __("More articles from", null, 'article') . " " . $article->getUserProfile()->getName(), 
                'user_page_actions', 
                array('username' => $article->getUserProfile()->getSfGuardUser()->getUsername(), 'action' => 'articles')
            ); 
        ?>
    </div>
</div>