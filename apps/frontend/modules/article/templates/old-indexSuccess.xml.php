<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<rss version="2.0">
    <channel>
        <title><?php echo __('Getlokal Articles'); ?></title>
        <link href="<?php echo url_for('article_index', array(), true); ?>" rel="self" />

        <?php foreach ($articles as $a): ?>
            <item>
                <title><?php echo $a->getTitleByCulture(); ?></title>
                <link><?php echo url_for('article', array('slug' => $a->getSlugByCulture()), true); ?></link>
                <guid><?php echo url_for('article', array('slug' => $a->getSlugByCulture()), true); ?></guid>
                <updated><?php echo date('D, d M Y g:i:s O', strtotime($a->getUpdatedAt())); ?></updated>
                <description><?php echo $a->getDescription(); ?></description>
                <author><name><?php echo $a->getUserProfile()->getName(); ?></name></author>
                <pubDate><?php echo date('D, d M Y g:i:s O', strtotime($a->getCreatedAt())); ?></pubDate>
                <?php if (count($a->getArticleImage()) > 0): ?>
                    <?php
                        $images = $a->getArticleImage();
                        $image = $images[0];
                        $path = $image->getImagePath();
                    ?>
                    <?php if (file_exists($path)): ?>
                        <?php
                            $url = ZestCMSImages::getImageURL('article') . $image->getFilename();
                            $size = filesize();
                            $type = mime_content_type($image->getImagePath());
                        ?>
                        <enclosure url="<?php echo $url; ?>" length="<?php echo $size; ?>" type="<?php echo $type; ?>" />
                    <?php endif ?>
                <?php endif ?>
            </item>
        <?php endforeach ?>
    </channel>
</rss>
