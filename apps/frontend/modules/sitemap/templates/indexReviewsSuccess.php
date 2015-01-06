<?php echo '<?' ?>xml version="1.0" encoding="utf-8" ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    
        <?php $culture = $sf_user->getCountry()->getSlug()?>
  <?php //$max_count1 = $pager->getLastPage();?>
  <?php for ($i = 1; $i <= $pages; $i ++): ?>
    <sitemap>
      <loc><?php echo url_for('sitemap/reviews/?culture='.$culture.'&page=' . $i, true) ?></loc>
      <lastmod><?php echo date('Y-m-d') //,strtotime($last_mod[$i]) ?></lastmod>
    </sitemap>
    <sitemap>
      <loc><?php echo url_for('sitemap/reviews/?culture=en&page=' . $i, true) ?></loc>
      <lastmod><?php echo date('Y-m-d') //,strtotime($last_mod[$i]) ?></lastmod>
    </sitemap>
  <?php endfor; ?>
    

</sitemapindex>
