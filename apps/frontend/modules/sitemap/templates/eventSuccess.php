<?php echo '<?' ?>xml version="1.0" encoding="utf-8" ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($events as $event): ?>
    <url>
      <loc><?php echo url_for('event/show?id='.$event->getId(),true);?></loc>
      <lastmod><?php echo date('Y-m-d') ?></lastmod>
      <changefreq>hourly</changefreq>
      <priority>1.0</priority>
    </url>
<?php endforeach; ?>
</urlset>