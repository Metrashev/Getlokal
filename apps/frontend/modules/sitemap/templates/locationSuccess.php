<?php echo '<?' ?>xml version="1.0" encoding="utf-8" ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <?php foreach (getlokalPartner::getEmbeddedLanguages() as $culture): ?>  
  <?php foreach ($locations as $location): ?>  
      <?php $url =  
       '@classification?slug='. Doctrine::getTable('Classification')->getTranslatedSlug($slug, $culture)
       .'&sector='. $classification->getPrimarySector()->Translation[$culture]->slug. 
       '&city='. $location->getSlug().
         '&sf_culture='. $culture;?>
        <url>
          <loc><?php echo url_for($url, true) ?></loc>
          <lastmod><?php echo date('Y-m-d') ?></lastmod>
          <changefreq>daily</changefreq>
          <priority>0.5</priority>
        </url>
      <?php endforeach; ?>  
  <?php endforeach; ?>
  
</urlset>