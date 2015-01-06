<?php echo '<?' ?>xml version="1.0" encoding="utf-8" ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($offers as $offer): ?>
        <url>
          <loc><?php echo url_for('offer/show?id='.$offer->getId(),true);?></loc>
          <lastmod><?php echo date('Y-m-d') ?></lastmod>
          <changefreq>weekly</changefreq>
          <priority>1.0</priority>
        </url>
<?php endforeach; ?>
</urlset>