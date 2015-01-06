<?php 
$gcodes = array('bg' => 'UA-1443488-5',
	        'ro' => 'UA-1443488-8',
	        'mk' => 'UA-1443488-13',
	        'sr' => 'UA-1443488-16',
                'fi' => 'UA-1443488-18'
	       );
 
$_ua = @$gcodes[$sf_user->getCountry()->getSlug()];
?>
<?php if(@!empty($_ua)):?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?php echo $_ua ?>']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<?php endif;?>