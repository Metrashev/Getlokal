<?php echo '<?' ?>xml version="1.0" encoding="utf-8"?>
<feed>
<?php foreach ($companies as $key1 => $val1):?>
<location name="<?php echo $key1;?>">
<companies>
<?php $i=0;?>
<?php foreach ($val1 as $key => $val):?>
<company url="<?php echo  url_for($val->getUri(ESC_RAW), true);?>">
<title><?php echo $val->getTitle();?></title>
<sector><?php echo $val->getSector()?></sector>
<rating><?php echo $val->getAverageRating();?>/5</rating>
<reviews><?php echo $val->getNumberOfReviews();?></reviews>
<image><?php echo 'http://'.sfContext::getInstance()->getRequest()->getHost() . $val->getThumb(0);?></image>
<url><?php echo url_for($val->getUri(ESC_RAW), true);?></url>
</company>
<?php endforeach;?>
</companies>
</location>
<?php endforeach;?>
</feed>