<?php echo '<?' ?>xml version="1.0" encoding="utf-8" ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc><?php echo url_for('@directory_categories?sf_culture=en', true) ?></loc>
    <lastmod><?php echo date('Y-m-d') ?></lastmod>
    <changefreq>daily</changefreq>
    <priority>0.5</priority>
  </url>
  <url>
    <loc><?php echo url_for('@directory_categories_no_culture', true) ?></loc>
    <lastmod><?php echo date('Y-m-d') ?></lastmod>
    <changefreq>daily</changefreq>
    <priority>0.5</priority>
  </url>
  <?php foreach ($categories as $category): ?>
    <?php foreach (array('en', 'ro') as $culture): ?>
      <?php $url = '@categories_show?id=' . $category->getId() . '&slug=' . strtolower($category->getSlugUrl()) ?>      
      <url>
        <loc><?php echo url_for($url, true);?></loc>
        <lastmod><?php echo date('Y-m-d') ?></lastmod>
        <changefreq>daily</changefreq>
        <priority>0.5</priority>
      </url>
    <?php endforeach; ?>
  <?php endforeach; ?>
</urlset>