<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="title" content="Спорт и фитнес" />
	<meta name="description" content="Спорт и фитнес в getlokal  - виж адреси, телефони, работно време и ревюта на потребители за всички Спорт и фитнес в София, " />
	<meta name="keywords" content="спорт, фитнес, getlokal, виж, адреси, телефони, работно, време, ревюта, потребители, всички, спорт, и, фитнес, в, софия, " />
	<title>Спорт и фитнес в София | getlokal</title>
	<link rel="stylesheet" type="text/css" media="screen" href="../web/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="../web/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="../web/css/style.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="../web/css/settings.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="../web/css/style1.css" />
	<link rel="stylesheet" type="text/css" media="screen" href="../web/images/favicon.ico" />
	<link rel="stylesheet" type="text/css" media="screen" href="../web/css/carousel.css" />
	<script type="text/javascript" src="../web/js/jquery.js"></script>
	<script type="text/javascript" src="../web/js/jquery.themepunch.tools.min.js"></script>
	<script type="text/javascript" src="../web/js/jquery.themepunch.revolution.min.js"></script>
	<script type="text/javascript" src="../web/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../web/js/jquery.nicescroll.js"></script>
	<script type="text/javascript" src="../web/js/jquery.carouFredSel-6.0.4-packed.js"></script>
	<script type="text/javascript" src="../web/js/functions.js"></script>
	<script type="text/javascript" src="../web/css/jquery-ui/jquery-ui-1.8.6.custom.css"></script>
	<script type="text/javascript" src="../web/js/jquery-ui.js"></script>
	<script type="text/javascript" src="../web/js/map.js"></script>
	<script type="text/javascript" src="../web/js/document.ready.js"></script>
	<script type="text/javascript" src="../web/js/philip.js"></script>
	<script type="text/javascript" src="../web/js/floatlabels.min.js"></script>
	<script type="text/javascript" src="../web/js/parsley.min.js"></script>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true&libraries=places&language=bg"></script>
	<script type="text/javascript"> var ModuleAction = 'home-category';</script>	
</head>
<body>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/bg_BG/sdk.js#xfbml=1&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<script src="https://apis.google.com/js/platform.js" async defer>
  {lang: 'bg'}
</script>

<script type="text/javascript">
window.twttr=(function(d,s,id){var t,js,fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id)){return}js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);return window.twttr||(t={_e:[],ready:function(f){t._e.push(f)}})}(document,"script","twitter-wjs"));
</script>

<?php 
	if(isset($_REQUEST['file']) && file_exists($_REQUEST['file'].".php")){
		$fileName = $_REQUEST['file'].".php";
		
		include '_header.php';
		include '_search.php';
		
		if(isset($_REQUEST['slider']) && $_REQUEST['slider'] == 'yes'){
			$slideName = $_REQUEST['file']."-slider.php";
			if(file_exists($slideName)){
				include $slideName;
			}else{
				die("<h3>&nbsp;&nbsp;&nbsp;&nbsp;алоооо шшшш - '$slideName'.<br />&nbsp;&nbsp;&nbsp;&nbsp;Такъв слайдър ня'а никъде :) </h3>");
			}
		}
		
		include $fileName;
		
		include '_footer.php';
	}else{
		$fileName = $_REQUEST['file'].".php";
		die("<h3>&nbsp;&nbsp;&nbsp;&nbsp;опааа файла - '$fileName' го НЕМА.<br />&nbsp;&nbsp;&nbsp;&nbsp;Ае малко :)</h3>");
	}
	

?>
</body>
</html>
