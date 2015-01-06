<?php 
$rawCompany = $sf_data->getRaw('company'); 
$rawImages = $sf_data->getRaw('images');
?>

<ul class="gallery clearfix">
	<?php
	
	if(sizeof($rawImages)){
		foreach($rawImages as $image) {
			?><li>
			
			<a rel="prettyPhoto[gallery2]"
	           name="<?php echo ($rawCompany->getImage()->getUserProfile()->getIsCompanyAdmin($rawCompany) ? $rawCompany->getCompanyTitle() : $image->getUserProfile());?>"
	           rev="<?php echo ($rawCompany->getImage()->getUserProfile()->getIsCompanyAdmin($rawCompany) ? url_for( $rawCompany->getUri(ESC_RAW)) : url_for($image->getUserProfile()->getUri(ESC_RAW)) );?>"
	           title="<?php echo($image->getCaption(ESC_RAW)) ?> "
	           href="<?php echo $image->getThumb('preview')?>">
	               <?php echo image_tag($image->getThumb(0), array('size' => '150x150', 'alt' => $rawCompany->getCompanyTitle() . (($rawCompany->getImage()->getCaption()) ? ' - ' . $rawCompany->getImage()->getCaption() : ''))) ?>
	        </a>
			</li><?php
		}
	}elseif(is_numeric($rawCompany->getImageId())){
		?><li>
			<a rel="prettyPhoto[gallery2]" href="<?php echo $rawCompany->getThumb('preview')?>" >
	           <?php echo image_tag($rawCompany->getThumb(0), array('size' => '150x150')) ?>
	        </a>
			</li>
		<?php
	}else{
		?><li>
			<a><?php echo image_tag($rawCompany->getThumb(16), 'alt=' . $rawCompany->getCompanyTitle()) ?></a>
		  </li><?php
	} ?>
</ul>

<script type="text/javascript" charset="utf-8">
		$(document).ready(function(){

			$(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',theme:'facebook',slideshow:3000, autoplay_slideshow: false}); //add , info_markup: 	<?php echo json_encode($sf_data->getRaw('images')); ?> for comments and etc. in image preview

		});
</script>