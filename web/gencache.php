<?php
if(!@$_GET['r']) header("Location: gencache.php?r=".rand());

set_time_limit(0);
ob_implicit_flush(true);
echo "
<script type=\"text/javascript\">
_bar = parent.document.getElementById('bar');
_tt = parent.document.getElementById('total');
_et = parent.document.getElementById('eta');
_m = parent.document.getElementById('message');
</script>
";

$time = explode(' ', microtime());
$_start = $time[1] + $time[0];

$entry[] = 'http://www.getlokal.com/sitemap/index';
$entry[] = 'http://www.getlokal.ro/sitemap/index';
$entry[] = 'http://www.getlokal.mk/sitemap/index';
$dir[] = 'http://www.getlokal.com/bg/d/sitemap/classifierslocations';
$dir[] = 'http://www.getlokal.ro/ro/d/sitemap/classifierslocations';
$dir[] = 'http://www.getlokal.mk/mk/d/sitemap/classifierslocations';

$craw = array(array(), array()); // Sitemaps, Directories

parseIndex($entry, $craw[0], 'Getting sitemap index:');
parseIndex($dir, $craw[1], 'Getting directory index:');

$toCraw = countItems();
$i = 0;

parse($craw[1], 'Getting directory index:');
parse($craw[0], 'Getting page:');


function parseIndex(&$index, &$to, $message){
  foreach($index as $url){
	  $start = getTime();
  
	  sendMessage("$message $url... ", true);
	  $data = file_get_contents($url);
	  preg_match_all('|<loc>(.*)<\/loc>|', $data,$matches);
	  $to = array_merge($to, $matches[1]);

	  $finish = getTime();

	  sendMessage("Done (".calcTime($start, $finish)."s)\\n");
  }
}

function parse(&$index, $message){
  global $_start, $i, $toCraw;
  while($url = array_shift($index)){
	  $start = getTime();
  
	  sendMessage("$message $url... ", true);
	  $data = file_get_contents($url);

	  $finish = getTime();
	  $i++;
	  sendMessage("Done (".calcTime($start, $finish)."s) (".countItems()." to go)\\n");
	  updateBar($i, $toCraw);
	  updateTime($_start, $i, countItems());
  }
}



function countItems(){
  global $craw;
  return (count($craw[0])+count($craw[1]));
}

$time = explode(' ', microtime());
$_finish = $time[1] + $time[0];
$_total = round(($_finish - $_start), 4);
sendMessage('Total time: '.sprintf("%02d:%02d:%02d", (($_total/3600)%24), (($_total/60)%60), $_total%60)."\\n");

function getTime(){
  $time = explode(' ', microtime());
  return $time[1] + $time[0];
}

function calcTime($start, $finish){
  return round(($finish - $start), 4);
}

function sendMessage($m, $clear = false){
    if(@$clear) echo "<script type='text/javascript'>_m.innerHTML = \"$m\"</script>";
    else echo "<script type='text/javascript'>_m.innerHTML = _m.innerHTML + \"$m\"</script>";
    flush();
}
function updateBar($c, $t){
    echo "<script type='text/javascript'>_bar.innerHTML ='".create_bar($c, $t, 1024)."'</script>";
}
function updateTime($_start, $_c, $_l){
    $time = explode(' ', microtime());
    $_finish = $time[1] + $time[0];
    $_total = round(($_finish - $_start), 4);
    $avg = round($_total / $_c);
    $eta = $_l*$avg;
    echo '<script type="text/javascript">_tt.innerHTML = "'.sprintf("%02d:%02d:%02d", (($_total/3600)%24), (($_total/60)%60), $_total%60).'"</script>';
    echo '<script type="text/javascript">_et.innerHTML = "'.sprintf("%02d:%02d:%02d", (($eta/3600)%24), (($eta/60)%60), $eta%60).'"</script>';
    
}


function create_bar($value,$total,$width=100,$height=12){
  $percent=round($value/$total, 2);
  if($percent<=1){
    $return='<div style="float:left;width: '.$width.'px;height:'.$height.'px; background-color: #FF0000;border:1px solid;" title="'.$value.'/'.$total.'"><span style="float:left;width: '.($percent*$width).'px;height:'.$height.'px; background-color: #00FF00;">&nbsp;</span>&nbsp;</div>';
  }
  else $return='<div style="float:left;width: '.$width.'px;height:'.$height.'px; background-color: #0000FF;border:1px solid;" title="'.$value.'/'.$total.'">&nbsp;</div>';

return $return;
}
?>
