<?php use_stylesheet('select-menu/select2-green'); ?>
<?php $currentSector = sfContext::getInstance()->getRequest()->getParameter( 'sector' )?>
<?php $currentSlug = sfContext::getInstance()->getRequest()->getParameter( 'slug' )?>
<div class="sector-search-wrap">
    <div class="select">
        <h2><?php echo __('Search in getlokal', null, 'messages')?></h2>
        <div id="arrow_vert" class="menu_vertical_separator"></div>
    </div>
	<select id="search-by-sector">
            <option select="selected"></option>
            <option style="display: none;"></option>
	  <?php foreach($sectors as $sector): ?>
	  <?php if (($county || getlokalPartner::getInstanceDomain() == 78) && (!$sf_request->getParameter('city', false))): ?>
	    <option <?php echo (($currentSlug == $sector->getSlug()) or ($currentSector == $sector->getSlug())) ? ' selected="selected" ' : ''; ?> value="<?php echo url_for('@sectorCounty?slug='. $sector->getSlug(). '&county='. $sf_user->getCounty()->getSlug()) ?>" class="category_<?php echo $sector->getId() ?>"><a title="<?php echo $sector ?>" href="<?php echo url_for('@sectorCounty?slug='. $sector->getSlug(). '&county='. $county) ?>" class=""><span><?php echo $sector ?></span></a></option>	    
	  <?php else: ?>
	    <option <?php echo (($currentSlug == $sector->getSlug()) or ($currentSector == $sector->getSlug())) ? ' selected="selected" ' : ''; ?> value="<?php echo url_for('@sector?slug='. $sector->getSlug(). '&city='. $sf_user->getCity()->getSlug()) ?>" class="category_<?php echo $sector->getId() ?>"><a title="<?php echo $sector ?>" href="<?php echo url_for('@sector?slug='. $sector->getSlug(). '&city='. $sf_user->getCity()->getSlug()) ?>" class=""><span><?php echo $sector ?></span></a></option>
	  <?php endif; ?>
	  <?php endforeach ?>
	</select>
</div>
<div class="clear"></div>
<script type="text/javascript">
    $(function() {
        $.q('#search-by-sector').select2({
            placeholder: "<?php echo __('Choose... ', null, 'contact') ?>",
            removeHighlight: true
        }).on("select2-open", function() {
            $('.select2-results li').first().hide();
            $('#arrow_vert').hide();
        }).on("select2-close", function() {
           $('#arrow_vert').show();
        })
        
    });
</script>