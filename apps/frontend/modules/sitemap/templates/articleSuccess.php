<?php echo '<?' ?>xml version="1.0" encoding="utf-8" ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($articles as $article): ?>
	<?php foreach (array($sf_user->getCountry()->getSlug(), 'en') as $culture): ?>
		<?php if ($article->Translation[$culture]->get('slug')): ?>
	    <url>
	      <loc><?php echo  url_for('article', array('slug'=>$article->Translation[$culture]->get('slug') ,'sf_culture'=>$culture ),true ) ?></loc>
	      <lastmod><?php echo date('Y-m-d') ?></lastmod>
	      <changefreq>hourly</changefreq>
	      <priority>1.0</priority>
	    </url>
	    <?php endif;?>
    <?php endforeach; ?>
<?php endforeach; ?>
</urlset>