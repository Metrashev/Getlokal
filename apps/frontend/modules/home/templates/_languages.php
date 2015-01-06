<ul>
<?php for($i=0; $i<=count($language)-1; $i++):?>
    <?php 
    if($i==0): ?>
        <li class="current">
            <a href="javascript:void(0);" 
                title="<?php echo $language[$i]['name'] ?>">
                <i class="fa fa-check"></i>
                <?php echo $language[$i]['name']; ?>
            </a>
        </li>
    <?php else:
    	//$url = url_for(${"uri_$i"});
    	$url = ${"uri_$i"};
    	$arUrl = explode('?', $url);
    	$url = $arUrl[0];
    ?>
    	<li>
            <a href="<?php echo $url;?>"
                title="<?php echo $language[$i]['name'] ?>">
                <?php echo $language[$i]['name']; ?>
            </a>
        </li>
    <?php endif; ?>

    <?php /* if($i != 0) {
        $url = ${"uri_$i"};
        $arUrl = explode('?', $url);
        $url = $arUrl[0];
    ?>

        <li>
            <a href="<?php echo $url;?>"
                title="<?php echo $language[$i]['name'] ?>">
                <i class="fa fa-check"></i>
                <?php echo $language[$i]['name']; ?>
            </a>
        </li>
    <?php } */ ?>

<?php endfor;?>
</ul>