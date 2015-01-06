<?php
$lng=$sf_user->getCulture().'_'.mb_convert_case($sf_user->getCulture(), MB_CASE_UPPER,'UTF-8');
if ($sf_user->getCulture()=='en') $lng=$sf_user->getCulture().'_US';
?>

<?php if(isset($type) && $type == 'box'){ ?>
  <div class="fb-like-box" data-href="<?php echo $facebook;?>" data-border-color="#CCC" data-width="300" data-height="263" data-show-faces="true"  data-stream="false" data-header="true"></div>
<?php } else{ ?>
  <div class="fb-like" data-href="<?php echo $facebook;?>" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>
<?php } ?>

<script>
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=289748011093022&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>