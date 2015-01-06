<?php 
if(is_array($company)){
	$company = $company[0];
}
?>
<div class="listing_place<?=$company->getIsPPP() ? ' vip' : ''?>" id="company-<?=$company->getId()?>">
    <a class="listing_place_img" title="<?=$company->getTitle()?>" href="/<?=$sf_user->getCulture()?>/<?=$company->getCity()->getSlug()?>/<?=$company->getSlug()?>">
    	<img alt="<?=$company->getTitle()?>" src="<?=$company->getImageURL($company->getIsPPP() ? 1 : 0)?>" >
    </a>    
    <?php if(!$company->getIsPPP()){ ?>
	    <div class="listing_place_in" style="width: 270px;">
			<div class="listing_place_rateing">
	            <div class="rateing_stars">
	                <div class="rateing_stars_orange" style="width: <?=$company->getRating()?>%;"></div>
	            </div>
	            <div>
	                <span><?php echo format_number_choice('[0]0 reviews|[1]1 review|(1,+Inf]%count% reviews', 
	                		array('%count%' => $company->getReviewsCount()), $company->getReviewsCount()    ); ?></span>
	            </div>
	        </div>
	        <h3>
	        	<a href="/<?=$sf_user->getCulture()?>/<?=$company->getCity()->getSlug()?>/<?=$company->getSlug()?>" title="<?=$company->getTitle()?>"><?=$company->getTitle()?></a>
	        </h3>           
	        <p><strong><a title="<?=$company->Sector['title']?>" class="category" href="/<?=$sf_user->getCulture()?>/<?=$company->getCity()->getSlug()?>/<?=$company->Sector['slug']?>/<?=$company->Classification['slug']?>"><?=$company->Classification['title']?></a></strong></p>
	        <p><?=$company->getDisplayAddress();?>
	           <br /><?=$company->getPhoneFormated()?>
	        </p>        
	    </div>
    <?php }else{ ?>
        <div class="vip_badge"></div>
	    <div class="official_page"><?php echo __('Official page', null, 'company'); ?></div>
	    <div class="listing_place_in" style="width: 270px;">
	        <h3>
	            <a href="/<?=$sf_user->getCulture()?>/<?=$company->getCity()->getSlug()?>/<?=$company->getSlug()?>" title="<?=$company->getTitle()?>"><?=$company->getTitle()?></a>
	        </h3>
	        <div class="listing_place_rateing vip">
	            <div class="rateing_stars">
	                <div class="rateing_stars_orange" style="width: <?=$company->getRating()?>%;"></div>
	            </div>
	            <div>
	            	<span><?php echo format_number_choice('[0]0 reviews|[1]1 review|(1,+Inf]%count% reviews', 
	                		array('%count%' => $company->getReviewsCount()), $company->getReviewsCount()    ); ?></span>
	            </div>
	        </div>
	        <p><strong><a title="<?=$company->Sector['title']?>" class="category" href="/<?=$sf_user->getCulture()?>/<?=$company->getCity()->getSlug()?>/<?=$company->Sector['slug']?>/<?=$company->Classification['slug']?>"><?=$company->Classification['title']?></a></strong></p>
	        <p><?=$company->getDisplayAddress();?>
	           <br /><?=$company->getPhoneFormated()?>
	        </p>
	    </div>
    <?php } ?>
    <div class="clear"></div>
    <!--last review-->
    <?php if( $company->getReviewsCount() ){ ?>
	<div class="listing_place_review">
		<strong>
			<a title="<?=$company->Review['first_name']. " " .$company->Review['last_name']?>" href="/<?=$sf_user->getCulture()?>/profile/<?=$company->Review['username']?>"><?=$company->Review['first_name']. " " .$company->Review['last_name']?></a>            
		</strong>
		<img class="quotation_icon" src="/images/gui/quotation_icon<?=$sf_user->getCulture() == 'bg' ? '_bg' : ''?>.png">
		<q class="item_review"><?=$company->Review['text']?></q>
	</div>
	<?php } ?>
</div>