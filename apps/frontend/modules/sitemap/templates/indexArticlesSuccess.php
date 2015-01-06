<?php echo '<?' ?>xml version="1.0" encoding="utf-8" ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

  <?php $max_count3 = $pager3->getLastPage();?>
  <?php for ($i = 1; $i <= $max_count3; $i ++): ?>
    <sitemap>
      <loc><?php echo url_for('sitemap/article?page=' . $i, true) ?></loc>
      <lastmod><?php echo date('Y-m-d',strtotime($last_mod[$i])) ?></lastmod>
    </sitemap>
  <?php endfor ?>

</sitemapindex>
