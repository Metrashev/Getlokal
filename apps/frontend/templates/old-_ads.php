<?php
$culture = getlokalPartner::getInstanceDomain();
$route = sfContext::getInstance()->getRouting()->getCurrentRouteName();
$home=0;
if($route == 'home' || $route == 'homepage') $home=1;
//$home = (int) $route == 'home';

$protocol = $sf_request->isSecure() ? 'https://' : 'http://';

$_options = array(
		getlokalPartner::GETLOKAL_BG => array(
				0 => array( // inner page
						'branding' => 'adoceanrealitaterookfkgiqfpe',
						'leader' => 'adoceanrealitaterovmknqpntip',
						'interstitial' => 'adoceanrealitaterosnrtdnhino',
						'sky' => 'adoceanrealitaterollmqjvjkoz',
						'box' => 'adoceanrealitateroyldhnsdpju',
				),
				1 => array( // home page
						'branding' => 'adoceanrealitateroteenollfwf',
						'leader' => 'adoceanrealitateroqfltbjfkra',
						'interstitial' => 'adoceanrealitateroxhqgmqshup',
						'sky' => 'adoceanrealitaterokhjqititlq',
						'box' => 'adoceanrealitaterongckfwoobv',

				)
		),
		getlokalPartner::GETLOKAL_RO => array(
				0 => array( // inner page
						'branding' => 'adoceanrealitateroyocqgpgfdg',
						'leader' => 'adoceanrealitateropbitqwdtsr',
						'interstitial' => 'adoceanrealitateromcpjeunhxq',
						'sky' => 'adoceanrealitaterovpjgkmqjnb',
						'box' => 'adoceanrealitaterosarmnjkoiw',
						'box2'=>'adoceanrealitaterordqmftnmmt',
						'inread'=>'ado-604xfeb7XNr6P9DWAgDxQDGXcOznLgMmlkrg9mufyp..x7',
						'adoce'=>'adoceanrealitateromilhbkstbq'
				),
				1 => array( // home page
						'branding' => 'adoceanrealitaterokkijcqljqc',
						'leader' => 'adoceanrealitaterormnmmxihtr',
						'interstitial' => 'adoceanrealitateroulggjkpsks',
						'sky' => 'adoceanrealitateroonetpusldm',
						'box' => 'adoceanrealitateroxkppfnfopx',
						'box2'=>'adoceanrealitaterowdkshwrfts',
						'adoce'=>'adoceanrealitaterozicoexlikp'
				)
		),
		getlokalPartner::GETLOKAL_MK => array(
				0 => array( // inner page
						'branding' => 'adoceanrealitateroxerncuprad',
						'leader' => 'adoceanrealitaterorgpkjodlax',
						'interstitial' => 'adoceanrealitaterolinhqihufn',
						'sky' => 'adoceanrealitateroufiegrjgqc',
						'box' => 'adoceanrealitateroohgrmlnpks',
				),
				1 => array( // home page
						'branding' => 'adoceanrealitaterozpghouegmd',
						'leader' => 'adoceanrealitateroqcmkimstmo',
						'interstitial' => 'adoceanrealitateronddrljmirn',
						'sky' => 'adoceanrealitaterowaonbsokhy',
						'box' => 'adoceanrealitaterotbfefpipnt',
				)
		),
		getlokalPartner::GETLOKAL_RS => array(
				0 => array( // inner page
						'branding' => 'adoceanrealitateroqpmroppngg',
						'leader' => 'adoceanrealitaterokblofkdhca',
						'interstitial' => 'adoceanrealitateroucjlmugqlq',
						'sky' => 'adoceanrealitateronaeicnjsib',
						'box' => 'adoceanrealitateroxbcfjxmlbv',

				),
				1 => array( // home page
						'branding' => 'adoceanrealitateroskclkqesec',
						'leader' => 'adoceanrealitaterommqhbliltw',
						'interstitial' => 'adoceanrealitaterownoeivlucm',
						'sky' => 'adoceanrealitateropljrnnognb',
						'box' => 'adoceanrealitaterozmhoeispsr',
				)
		),
);

$_masterIds = array(
		getlokalPartner::GETLOKAL_BG => array(
				0 => '7iOVntaf7cbMi5URivONrTSDYKPi9mOUj9wQ9WwE7BX.K7', // inner page
				1 => 'QSvqo1_R422FpTfo11KVBhG13M8XEL.nMz6sUjKJC1H.77' // homepage
		),
		getlokalPartner::GETLOKAL_RO => array(
				0 => 'IxGhRppkzH4bdYG_QLNLqSVVsFT9lYNGH2djw_FANub.t7', // inner page
				1 => 'ZSdGm6Ce4tYurXYSKAyciA2836rGxy9CbldxuHEfrdn.Y7' // home page
		),
		getlokalPartner::GETLOKAL_MK => array(
				// deactivate mk banners before deploy
				0 => 'quSn60Pul1aZwyGhdgPi3ht_Ay2jlVHCcFNfzn_mwl..C7', // inner page
				1 => 'M.GWzvvNkknU1zVL610v5C.mIMwPaONA5juQtnZ6irD.l7' // when home
		),
		getlokalPartner::GETLOKAL_RS => array(
				0 => 'tphGBjLM4k1qMCXoKJ.MADOAch1axH5NxNFA3XeP00n.e7',
				1 => '2VDrX0FhiOb3WeMfZRwB8Bxm0soOsz4j5WVQ9q_BQ8v.X7'
		),
);
if (!isset($_masterIds[$culture][$home])) {
	return;
}
$mId = $_masterIds[$culture][$home];
?>

<?php if ($type == 'head'): ?>
<script
	type="text/javascript"
	src="<?php echo $protocol ?>realitatero.adocean.pl/files/js/ado.js"></script>
<script type="text/javascript">
  /* (c)AdOcean 2003-2013 */
    if(typeof ado!=="object"){ado={};ado.config=ado.preview=ado.placement=ado.master=ado.slave=function(){};}
    ado.config({mode: "old", xml: false, characterEncoding: true});
    ado.preview({enabled: true, emiter: "realitatero.adocean.pl", id: "lCFVXq1sndP8zCUkIlFt3931sSwRZece2XtNiNkkmEv.j7"});
  </script>

<!-- start master -->
<script type="text/javascript">
  /* (c)AdOcean 2003-2013, MASTER: f5web_ro.getlokal all site */
  ado.master({id: '<?php echo $mId; ?>', server: 'realitatero.adocean.pl' });
  </script>
<!--  end master  -->
<?php elseif ($type == 'interstitial'): ?>
<?php
$id = $_options[$culture][$home][$type];
?>
<div id="<?php echo $id; ?>"></div>
<script type="text/javascript">
    /* (c)AdOcean 2003-2013, f5web_ro.getlokal all site.<?php echo $type; ?> */
    ado.slave('<?php echo $id; ?>', {myMaster: '<?php echo $mId; ?>' });
</script>
<?php elseif ($type == 'box2'): ?>
<?php $id = $_options[$culture][$home][$type]; ?>
<div class="box2">
	<div id="<?php echo $id; ?>"></div>
	<script type="text/javascript">
	       /* (c)AdOcean 2003-2013, f5web_ro.getlokal all site.<?php echo $type; ?> */
	       ado.slave('<?php echo $id; ?>', {myMaster: '<?php echo $mId; ?>' });
	    </script>
</div>
<?php elseif ($type == 'inread'): ?>
<?php $id = $_options[$culture][$home][$type];?>
<div id="<?php echo $id; ?>"></div>
<script type="text/javascript">
    /* (c)AdOcean? 2003-2014, f5web_ro.getlokal RO.textlink.<?php echo $type; ?> */
    ado.placement({id: '<?php echo $id; ?>', server: 'realitatero.adocean.pl' });
</script>
<?php elseif ($type == 'adoce' && $home == 1): ?>
<div
	id="adoceanrealitaterozicoexlikp"></div>

<script type="text/javascript">

  /* (c)AdOcean 2003-2014, f5web_ro.getlokal RO.homepage.header */

  ado.slave('adoceanrealitaterozicoexlikp', {myMaster: 'ZSdGm6Ce4tYurXYSKAyciA2836rGxy9CbldxuHEfrdn.Y7' });

</script>
<?php elseif ($type == 'adoce' && $home == 0): ?>
<div
	id="adoceanrealitateromilhbkstbq"></div>

<script type="text/javascript">

	/* (c)AdOcean 2003-2014, f5web_ro.getlokal RO.all site.header */
	
	ado.slave('adoceanrealitateromilhbkstbq', {myMaster: 'IxGhRppkzH4bdYG_QLNLqSVVsFT9lYNGH2djw_FANub.t7' });

</script>
<?php elseif (isset($_options[$culture][$home][$type])): ?>
<?php
$id = $_options[$culture][$home][$type];
?>
<!-- start slave -->
<?php elseif (isset($_options[$culture][$home][$type])): ?>
<?php
$id = $_options[$culture][$home][$type];
?>
<!-- start slave -->
<div class="bannerTop bannerBox">
	<div id="<?php echo $id; ?>"></div>
	<script type="text/javascript">
    /* (c)AdOcean 2003-2013, f5web_ro.getlokal all site.<?php echo $type; ?> */
    ado.slave('<?php echo $id; ?>', {myMaster: '<?php echo $mId; ?>' });
    </script>
</div>
<!--  end slave  -->
<?php endif ?>
