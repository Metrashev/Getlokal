<?php if(count($categories)>0 ) : ?>
/
<ul>
<?php $array_keys = count($categories)-1 ?>
<?php foreach ($categories as $key => $category):?>
<li><a href="<?php echo url_for( '@article_category?slug='.$category->getSlug() ); ?>" class="category"><?php echo $category->getTitle();?></a> <?php echo $array_keys!= $key ? '/' : ''?></li>
<?php endforeach;?>
</ul>
<?php endif;?>