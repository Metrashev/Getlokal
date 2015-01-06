<?php if (count($articles) > 0): ?>
<div class="separator_dotted"></div>
    <div class="related_articles_wrap">
        <h2><?php echo __('Related Articles', null, 'article') ?></h2>
        <ul>
            <?php foreach ($articles as $article): ?>
                <li>
                    <div class="article_picture_wrap">
                        <?php if ($article->getArticle()->getArticleImageForIndex()): ?>
                            <a href="<?php echo url_for('article', array('slug' => $article->getArticle()->getSlug())) ?>" ><img src="<?php echo ZestCMSImages::getImageURL('article', 'size-s') . $article->getArticle()->getArticleImageForIndex()->getFilename(); ?>" alt="<?php echo $article->getArticle()->getArticleImageForIndex()->getDescrption(); ?>" /></a>
                        <?php else: ?>
                            <a href="<?php echo url_for('article', array('slug' => $article->getArticle()->getSlug())) ?>" ><img src="<?php echo '#' ?>" alt="<?php echo '#'; ?>" /></a>
                        <?php endif; ?>
                    </div>
                    <div class="article_desc_wrap">
                        <?php $secure = $sf_request->isSecure() ? 'https://' : 'http://' ?>
                        <a href="<?php echo $secure . str_replace(getlokalPartner::getDomains(), $article->getArticle()->getArticleDomain(), $sf_request->getHost()) . '/' . $article->getArticle()->getLangForCP() . '/article/' . $article->getArticle()->getSlugForCP() ?>"><?php echo truncate_text($article->getArticle()->getTitleForCP(), 50, '...', true); ?></a><br />

                        <p class="user_profile"><?php echo __('by', null, 'events') . " "; ?>
                         <?php echo $article->getArticle()->getUserProfile()->getLink(ESC_RAW); ?>
                        </p>
                    </div>
                    <div class="clear"></div>
                    <?php ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>