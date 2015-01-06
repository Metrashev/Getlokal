<?php echo '<?' ?>xml version="1.0" encoding="utf-8" ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <?php //foreach ($classifications as $classification): ?>
  	<sitemap>
      <loc><?php echo url_for('home/index', true) ?></loc>
      <lastmod><?php echo date('Y-m-d') ?></lastmod>
    </sitemap>
    <sitemap>
      <loc><?php echo url_for('sitemap/classification', true) ?></loc>
      <lastmod><?php echo date('Y-m-d') ?></lastmod>
    </sitemap>
  <?php //endforeach; ?>
   <?php foreach ($classifications as $classification): ?>
      <?php if($classification->Translation[$sf_user->getCountry()->getSlug()]->number_of_places): ?>
    <sitemap>
      <loc><?php echo url_for('sitemap/location?slug=sitemap_classifier_'.$classification->Translation['en']->slug, true); ?></loc>
      <lastmod><?php echo date('Y-m-d') ?></lastmod>
    </sitemap>
    <?php endif;?>
  <?php endforeach; ?> 
  <?php $max_count1 = $pager->getLastPage();?>
  <?php for ($i = 1; $i <= $max_count1; $i ++): ?>
    <sitemap>
      <loc><?php echo url_for('sitemap/company?page=' . $i, true) ?></loc>
      <lastmod><?php echo date('Y-m-d') ?></lastmod>
    </sitemap>
  <?php endfor ?>
   <?php $max_count2 = $pager2->getLastPage();?>
  <?php for ($i = 1; $i <= $max_count2; $i ++): ?>
    <sitemap>
      <loc><?php echo url_for('sitemap/event?page=' . $i, true) ?></loc>
      <lastmod><?php echo date('Y-m-d') ?></lastmod>
    </sitemap>
  <?php endfor ?>
  <?php $max_count3 = $pager3->getLastPage();?>
  <?php for ($i = 1; $i <= $max_count3; $i ++): ?>
    <sitemap>
      <loc><?php echo url_for('sitemap/article?page=' . $i, true) ?></loc>
      <lastmod><?php echo date('Y-m-d') ?></lastmod>
    </sitemap>
  <?php endfor ?>
  <?php $max_count4 = $pager4->getLastPage();?>
  <?php for ($i = 1; $i <= $max_count4; $i ++): ?>
    <sitemap>
      <loc><?php echo url_for('sitemap/offer?page=' . $i, true) ?></loc>
      <lastmod><?php echo date('Y-m-d') ?></lastmod>
    </sitemap>
  <?php endfor ?>
</sitemapindex>
