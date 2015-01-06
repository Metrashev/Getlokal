<?php echo '<?' ?>xml version="1.0" encoding="utf-8" ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <?php foreach ($classifiers as $classifier): ?>
    <?php foreach (array($sf_user->getCountry()->getSlug(), 'en') as $culture): ?>
    
    <?php if ($classifier->Translation[$sf_user->getCountry()->getSlug()]->number_of_places > 0): ?>
      <?php $url = '@locations?slug=' . $classifier->Translation[$culture]->slug. '&sector='. $classifier->getPrimarySector()->Translation[$culture]->slug .'&sf_culture='.$culture; ?>
      <url>
        <loc><?php echo url_for($url, true) ?></loc>
        <lastmod><?php echo date('Y-m-d') ?></lastmod>
        <changefreq>daily</changefreq>
        <priority>0.5</priority>
      </url>
      
      <?php endif;?>
    <?php endforeach; ?>
  <?php endforeach; ?>

</urlset>

