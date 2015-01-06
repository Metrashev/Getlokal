<?php echo '<?' ?>xml version="1.0" encoding="utf-8" ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
     <?php $request=sfContext::getInstance()->getRequest();?>
     <?php $culture = $request->getParameter('culture')?>
     
<?php for ($i = $start; $i < $end; $i++): ?>
    <url>
    
      <loc><?php echo url_for('review/index?sf_culture='.$culture.'&page='.$i, true )?></loc>
      <lastmod><?php echo date('Y-m-d') ?></lastmod>
      <changefreq>daily</changefreq>
      <priority>0.5</priority>
    </url>
<?php endfor; ?>
    
</urlset>