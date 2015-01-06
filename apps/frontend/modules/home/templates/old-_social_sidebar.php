<?php
$lng=$sf_user->getCulture().'_'.mb_convert_case($sf_user->getCulture(), MB_CASE_UPPER,'UTF-8');
if ($sf_user->getCulture()=='en') $lng=$sf_user->getCulture().'_US';
?>
<div id="fb-root"></div>
<div>  
<div class="fb-like-box" data-href="<?php echo $facebook;?>" data-border-color="#CCC" data-width="300" data-height="263" data-show-faces="true"  data-stream="false" data-header="true"></div>
<?php /*?>
<div class="fb_like_box"><div class="fb-like" data-href="<?php echo $facebook;?>" data-send="false" data-width="263" data-show-faces="true"></div></div>
*/ ?>
<div class="tweet_box"><a href="<?php echo $twitter;?>" class="twitter-follow-button" data-show-count="true" data-dnt="true">Follow @getlokal</a></div>
<div class="like_box">
	<?php if (isset($plus)):?><a class="google_plus" href="<?php echo $plus;?>" rel="publisher" target="_blank">Google+</a><?php endif;?>
	<?php if (isset($tube)):?><a class="youtube" href="<?php echo $tube?>" target="_blank">YouTube</a><?php endif;?>
	<script type="IN/FollowCompany" data-id="2404523" data-counter="none"></script>
	<div class="clear"></div>
</div>
</div>
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
        // LinkedIn
        add('//platform.linkedin.com/in.js');
        fjs.parentNode.insertBefore(frag, fjs);
    }(document, 'script')); 


    });
</script>