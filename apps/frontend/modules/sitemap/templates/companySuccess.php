<?php echo '<?' ?>xml version="1.0" encoding="utf-8" ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($companies as $company): ?>
    
    <url>
      <loc><?php echo url_for($company->getUri(ESC_RAW). '&sf_culture='.$culture, true) ;?></loc>
      <lastmod><?php echo date('Y-m-d') ?></lastmod>
      <changefreq>daily</changefreq>
      <priority>0.5</priority>
    </url>
<?php endforeach; ?>
    
</urlset>