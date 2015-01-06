<div class="article-author">
    <div class="avatar">
        <?php echo image_tag($article->getUserProfile()->getThumb(), array('size'=>'45x45', 'alt'=>'', 'class'=>'img-circle')) ?>
    </div>
    <div class="info">
        <div class="txt"><?php echo __("This article is created by", null, 'article'); ?></div>
        <div class="name"><?= $article->getUserProfile()->getLink(false, null, 'class="author"',ESC_RAW); ?></div>
        <div class="more">
            <?php 
                echo link_to(
                    __("More articles from", null, 'article') . " " . $article->getUserProfile()->getName(), 
                    'user_page_actions', 
                    array('username' => $article->getUserProfile()->getSfGuardUser()->getUsername(), 'action' => 'articles')
                ); 
            ?>
        </div>
        <div class="clear"></div>
    </div>
</div>