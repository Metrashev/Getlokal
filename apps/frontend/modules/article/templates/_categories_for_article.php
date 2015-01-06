<?php 
	if(count($categories)>0 ){
		$array_keys = count($categories)-1;
		foreach ($categories as $key => $category){?>
			<a href="<?=url_for( '@article_category?slug='.$category->getSlug() ); ?>" class="alignleft"><i class="fa fa-tags"></i><?=$category->getTitle();?></a>
<?php 	}
	} 
?>