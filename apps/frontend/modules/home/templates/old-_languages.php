<?php for($i=0; $i<=count($language)-1; $i++):?>
    <?php 
    if($i==0): ?>
        <a href="javascript:void(0);"
            class="current"
            title="<?php echo $language[$i]['name'] ?>">
            <img src="/images/gui/flag_<?php echo $language[$i]['code'] ;?>.gif"
                alt="<?php echo $language[$i]['name'] ?>"/></a>
    <?php else:
    	//$url = url_for(${"uri_$i"});
    	$url = ${"uri_$i"};
    	$arUrl = explode('?', $url);
    	$url = $arUrl[0];
    ?>
    	
        <a href="<?php echo $url;?>"
            title="<?php echo $language[$i]['name'] ?>">
            <img src="/images/gui/flag_<?php echo $language[$i]['code']; ?>.gif"
                alt="<?php echo $language[$i]['name']?>"/></a>
    <?php endif;?>
<?php endfor;?>

