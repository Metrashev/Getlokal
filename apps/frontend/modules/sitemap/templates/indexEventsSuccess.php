<?php echo '<?' ?>xml version="1.0" encoding="utf-8" ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  
  <?php $max_count2 = $pager2->getLastPage();?>
  <?php for ($i = 1; $i <= $max_count2; $i ++): ?>
    <sitemap>
      <loc><?php echo url_for('sitemap/event?page=' . $i, true) ?></loc>
      <lastmod><?php echo date('Y-m-d',strtotime($last_mod[$i])) ?></lastmod>
    </sitemap>
  <?php endfor ?>

</sitemapindex>
