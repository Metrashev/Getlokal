<?php
    // prepare a cleaned url (no query) for social media sharing
    $share_url = strstr($sf_request->getUri(), '?', true);
	
	if (!$share_url) {
		$share_url = $sf_request->getUri();
	}
?>
<?php
$lng=$sf_user->getCulture().'_'.mb_convert_case($sf_user->getCulture(), MB_CASE_UPPER,'UTF-8');
if ($sf_user->getCulture()=='en') $lng=$sf_user->getCulture().'_US';
?>
<?php if ($hasSocialHTML): ?>
<div class="social_wrap">

       <div id="fb-root"></div>    
       <div class="fb-like" data-href="<?php echo $share_url; ?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div>
       <div class="fb-share-button" data-href="<?php echo $share_url; ?>" data-type="button_count"></div>
       <div data-href="<?php echo $share_url; ?>" class="g-plus" data-action="share" data-annotation="bubble"></div>
       <div class="twitter_wrap"><a data-url="<?php echo $share_url; ?>" href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
  </div>
  <div class="clear"></div>
  <?php if (isset($embed) && isset($company)): ?>
    <?php include_partial('global/embedding', array(
      'embed' => $embed,
      'company' => $company
    )) ?>
  <?php elseif(isset($embed)): ?>
    <?php include_partial('global/embedding', array(
      'embed' => $embed
    )) ?>
  <?php else: ?>
    <?php include_partial('global/embedding') ?>
<?php endif; ?>
</div>
<?php endif; ?>
<?php if ($hasSocialScripts): ?>
<script>
    $(window).bind("load", function() {
    (function(doc, script) {
        var js, 
        fjs = doc.getElementsByTagName(script)[0],
        frag = doc.createDocumentFragment(),
        add = function(url, id) {
            if (doc.getElementById(id)) {return;}
            js = doc.createElement(script);
            js.src = url;
            id && (js.id = id);
            frag.appendChild( js );
        };
        
        // Google+ button
        add('http://apis.google.com/js/plusone.js');
        // Facebook SDK
        add('//connect.facebook.net/<?php echo $lng; ?>/all.js#xfbml=1&status=0&appId=289748011093022', 'facebook-jssdk');
        // Twitter SDK
        add('//platform.twitter.com/widgets.js');
        
        fjs.parentNode.insertBefore(frag, fjs);
    }(document, 'script')); 
    });
</script>
<?php endif; ?>

