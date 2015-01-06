<?php echo '<?' ?>xml version="1.0" encoding="utf-8" ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <?php $max_count4 = $pager4->getLastPage();?>
  <?php for ($i = 1; $i <= $max_count4; $i ++): ?>
    <sitemap>
      <loc><?php echo url_for('sitemap/offer?page=' . $i, true) ?></loc>
      <lastmod><?php echo date('Y-m-d') ?></lastmod>
    </sitemap>
  <?php endfor ?>
</sitemapindex>