<?php echo '<?' ?>xml version="1.0" encoding="utf-8" ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <?php //foreach ($classifications as $classification): ?>
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
  

</sitemapindex>
