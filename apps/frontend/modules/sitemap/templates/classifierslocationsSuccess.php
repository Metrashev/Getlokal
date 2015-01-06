<?php echo '<?' ?>xml version="1.0" encoding="utf-8" ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  
<?php foreach ($classifiers_lists as $key=>$val): ?>  
    <?php $vars =  explode(',', $val); ?>
      <?php $url =  
       '@locations?slug='. $vars[2]
       .'&sector='.  $vars[1].
         '&sf_culture='. $vars[0];?>
        <url>
          <loc><?php echo url_for($url, true) ?></loc>
          <lastmod><?php echo date('Y-m-d') ?></lastmod>
          <changefreq>daily</changefreq>
          <priority>0.5</priority>
        </url>
      
  <?php endforeach; ?>

<?php foreach ($classifiers_locations as $key=>$val): ?>  
    <?php $vars =  explode(',', $val); ?>
      <?php $url =  
       '@classification?slug='. $vars[3]
       .'&sector='.  $vars[2]. 
       '&city='.$vars[1].
         '&sf_culture='. $vars[0];?>
        <url>
          <loc><?php echo url_for($url, true) ?></loc>
          <lastmod><?php echo date('Y-m-d') ?></lastmod>
          <changefreq>daily</changefreq>
          <priority>0.5</priority>
        </url>
      
  <?php endforeach; ?>
  
</urlset>