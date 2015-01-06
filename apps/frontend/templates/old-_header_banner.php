<?php if($sf_user->getCountry()->getSlug() == 'bg'): ?>
  <?php /* ?>
  <div class="cta_message">
	<?php if ($sf_user->getCulture()=='bg'):?>
		<a class="banner" href="<?php echo url_for('@promo') ?>"><img src="/images/banners/new_promo.png" alt="Promotion page" /></a>
	<?php elseif ($sf_user->getCulture()=='en'):?>
		<a class="banner" href="<?php echo url_for('@promo') ?>"><img src="/images/banners/new_promo_en.png" alt="Promotion page" /></a>
	<?php endif;?>
  </div>
  <?php */?>

<?php if (sfContext::getInstance()->getRouting()->getCurrentRouteName() == 'home') : ?>
<?php /*
    <script type='text/javascript'>
        googletag.cmd.push(function() {
            googletag.defineSlot('/7328715/getlokal.com-top-homepage', [975, 90], 'div-gpt-ad-1359394987132-0').addService(googletag.pubads());
            googletag.pubads().enableSingleRequest();
            googletag.pubads().collapseEmptyDivs();
            googletag.enableServices();
        });
    </script>

    <!-- getlokal.com-top-homepage -->
    <div id='div-gpt-ad-1359394987132-0' style='width:975px; height:90px;' class="banner">
        <script type='text/javascript'>
            googletag.cmd.push(function() { googletag.display('div-gpt-ad-1359394987132-0'); });
        </script>
    </div>
 */ ?>
<?php else : ?>
<?php /*
    <script type='text/javascript'>
        googletag.cmd.push(function() {
            googletag.defineSlot('/7328715/getlokal.com-top-interior', [975, 90], 'div-gpt-ad-1359395160409-0').addService(googletag.pubads());
            googletag.pubads().enableSingleRequest();
            googletag.pubads().collapseEmptyDivs();
            googletag.enableServices();
        });
    </script>

    <!-- getlokal.com-top-interior -->
    <div id='div-gpt-ad-1359395160409-0' style='width:975px; height:90px;' class="banner">
        <script type='text/javascript'>
            googletag.cmd.push(function() { googletag.display('div-gpt-ad-1359395160409-0'); });
        </script>
    </div>
 */
?>
<?php endif; ?>
<?php elseif($sf_user->getCountry()->getSlug() == 'ro'): ?>
    <?php /*<a class="banner" href="<?php echo url_for('getweekend/index')?>" target="_blank"><img style="margin-bottom: 10px;" src="/images/banners/new_promo_ro.png" alt="Promotion page" /></a> */ ?>

    <?php if (sfContext::getInstance()->getRouting()->getCurrentRouteName() == 'home') : ?>
        <script type='text/javascript'>
            googletag.cmd.push(function() {
                googletag.defineSlot('/7328715/getlokal.com-top-homepage', [975, 90], 'div-gpt-ad-1361453030730-0').addService(googletag.pubads());
                googletag.pubads().enableSingleRequest();
                googletag.pubads().collapseEmptyDivs();
                googletag.enableServices();
            });
        </script>

        <!-- getlokal.com-top-homepage -->
        <div id='div-gpt-ad-1361453030730-0' style='width:975px;' class="banner_top_home">
            <script type='text/javascript'>
                googletag.cmd.push(function() {
                googletag.display('div-gpt-ad-1361453030730-0'); });
            </script>
        </div>
    <?php else : ?>
        <script type='text/javascript'>
            googletag.cmd.push(function() {
                googletag.defineSlot('/7328715/getlokal.com-top-interior', [975, 90], 'div-gpt-ad-1361453030730-1').addService(googletag.pubads());
                googletag.pubads().enableSingleRequest();
                googletag.pubads().collapseEmptyDivs();
                googletag.enableServices();
            });
        </script>

        <!-- getlokal.com-top-interior -->
        <div id='div-gpt-ad-1361453030730-1' style='width:975px;' class="banner_top_inner">
            <script type='text/javascript'>
                googletag.cmd.push(function() {
                googletag.display('div-gpt-ad-1361453030730-1'); });
            </script>
        </div>
    <?php endif; ?>
<?php elseif($sf_user->getCountry()->getSlug() == 'mk'): ?>
    <?php /*
        <a class="banner" href="<?php echo url_for('promo')?>" target="_blank"><img style="margin-bottom: 10px;" src="/images/promo/reviewPlace_mk/banner.png" alt="Promotion page" /></a>
     */ ?>

    <?php if (sfContext::getInstance()->getRouting()->getCurrentRouteName() == 'home') : ?>
        <script type='text/javascript'>
            googletag.cmd.push(function() {
                googletag.defineSlot('/7328715/getlokal-mk-top-homepage', [975, 90],
                'div-gpt-ad-1359396325123-0').addService(googletag.pubads());
                googletag.pubads().enableSingleRequest();
                googletag.pubads().collapseEmptyDivs();
                googletag.enableServices();
            });
        </script>

        <!-- getlokal-mk-top-homepage -->
        <div id='div-gpt-ad-1359396325123-0' style='width:975px;' class="banner">
            <script type='text/javascript'>
                googletag.cmd.push(function() {
                googletag.display('div-gpt-ad-1359396325123-0'); });
            </script>
        </div>
    <?php else : ?>
        <script type='text/javascript'>
            googletag.cmd.push(function() {
                googletag.defineSlot('/7328715/getlokal-mk-top-interior', [975, 90],
                'div-gpt-ad-1359396410424-0').addService(googletag.pubads());
                googletag.pubads().enableSingleRequest();
                googletag.pubads().collapseEmptyDivs();
                googletag.enableServices();
            });
        </script>

        <!-- getlokal-mk-top-interior -->
        <div id='div-gpt-ad-1359396410424-0' style='width:975px;' class="banner">
            <script type='text/javascript'>
                googletag.cmd.push(function() {
                googletag.display('div-gpt-ad-1359396410424-0'); });
            </script>
        </div>
    <?php endif; ?>
<?php endif;?>
