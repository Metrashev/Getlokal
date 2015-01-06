<?php
  $culture = getlokalPartner::getInstanceDomain();
  $route = sfContext::getInstance()->getRouting()->getCurrentRouteName();
  $home=0;
  $module = $sf_context->getModuleName();
  $action = $sf_context->getActionName();
  if($route == 'home' || $route == 'homepage' || $route == 'home2' || $route == 'home3') $home=1;
  //$home = (int) $route == 'home';

  $protocol = $sf_request->isSecure() ? 'https://' : 'http://';

  $_options = array(
    getlokalPartner::GETLOKAL_BG => array(
      0 => array( // inner page
        'branding' => 'adoceanthinkdigitalrophgjenktyb',
        'leader' => 'adoceanthinkdigitalrosgpsqpqohg',
        'interstitial' => 'adoceanthinkdigitalrominphkeisa',
        'sky' => 'adoceanthinkdigitalroyerfkvmfnq',
        'box' => 'adoceanthinkdigitalrovfimnsgkil',
      ),
      1 => array( // home page
        'branding' => 'adoceanthinkdigitalronmqpimfplf',
        'leader' => 'adoceanthinkdigitalroqljjfplkbk',
        'interstitial' => 'adoceanthinkdigitalroknhgmjptga',
        'sky' => 'adoceanthinkdigitalrowjlmouhrbq',
        'box' => 'adoceanthinkdigitalrotkctbsrfgp',
 
      )
    ),
    getlokalPartner::GETLOKAL_RO => array(
      0 => array( // inner page
        'branding' => 'adoceanthinkdigitalrotareflhswf',
        'leader' => 'adoceanthinkdigitalrowpjobonnqk',//728x90
        'interstitial' => 'adoceanthinkdigitalroqbiliirgqe',
        'sky' => 'adoceanthinkdigitalrosmneejglsa',//160x600
        'box' => 'adoceanthinkdigitalropnelhwpprv',//300x250 za6toto ima 2
        'box2'=>'adoceanthinkdigitalromolrktjubq',
        'inread'=>'ado-zF5HDHCyhwIK2zyfprNW3g0msLjGsoOeVPGAsh6wG7f.g7',
      	'search' => 'adoceanthinkdigitalrowckhipoohu',
      	'article_between'=>'adoceanthinkdigitalropafeoxqqif',
      	'article_end'=>'adoceanthinkdigitalrombmkbvkfne',
      	'event_native'=>'adoceanthinkdigitalroqeiepjshwo',
      	'lists'=>'adoceanthinkdigitalrorileqldpat',
      ),
      1 => array( // home page
        'branding' => 'adoceanthinkdigitalrovoghhnnhdp',
        'leader' => 'adoceanthinkdigitalroogcsmxlste',
        'interstitial' => 'adoceanthinkdigitalroyhqodsplxy',
        'sky' => 'adoceanthinkdigitalrokdgipseqvu',
        'box' => 'adoceanthinkdigitalroxdnocqouup',
        'box2'=>'adoceanthinkdigitalroueefgnijko',
      )
    ),
    getlokalPartner::GETLOKAL_MK => array(
      0 => array( // inner page
        'branding' => 'adoceanthinkdigitalrowgmteiflci',
        'leader' => 'adoceanthinkdigitalrozffnbllgsn',
        'interstitial' => 'adoceanthinkdigitalrothdkivopmd',
        'sky' => 'adoceanthinkdigitalropehqkqhndt',
        'box' => 'adoceanthinkdigitalromfogonrrno',
      ),
      1 => array( // home page
        'branding' => 'adoceanthinkdigitalroulgkjxpgpm',
        'leader' => 'adoceanthinkdigitalroxkptfkgsvn',
        'interstitial' => 'adoceanthinkdigitalrormnqmujlzh',
        'sky' => 'adoceanthinkdigitalronjrgppsiqx',
        'box' => 'adoceanthinkdigitalrokkincnmnws',
      )
    ),
    getlokalPartner::GETLOKAL_RS => array(
      0 => array( // inner page
        'branding' => 'adoceanthinkdigitalrongcoftpshl',
        'leader' => 'adoceanthinkdigitalroqflhcwfoxq',
        'interstitial' => 'adoceanthinkdigitalrokhjejqjhmk',
        'sky' => 'adoceanthinkdigitalrowdnkllsuxw',
        'box' => 'adoceanthinkdigitalroteeroimjcv',
      ),
      1 => array( // home page
        'branding' => 'adoceanthinkdigitalrollmekskofp',
        'leader' => 'adoceanthinkdigitalrookfogvqjku',
        'interstitial' => 'adoceanthinkdigitalroyldlnpetpk',
        'sky' => 'adoceanthinkdigitalrouihrpknqva',
        'box' => 'adoceanthinkdigitalrorjohdihflz',
      )
    ),
  );

  $_masterIds = array(
    getlokalPartner::GETLOKAL_BG => array(
      0 => 'XOuR1qAIbNx1yRykNKzPsQWcHVktcEd17A6lDt4Ncyf.e7', // inner page
      1 => 'VzCsMttvTXOPd096FFgeIy3FA30xNFISQMlGsClfCur.O7' // homepage
    ),
    getlokalPartner::GETLOKAL_RO => array(
      0 => 'acpB5nGcvEaXNIGXIqsmks00DZumsqcVtUrVPL4F4xf.57', // inner page
      1 => 'x8ycHnsm7eK1Ss8abvIO8lsrQeXDV4c0UvV9rPzktwX.O7' // home page
    ),  
    getlokalPartner::GETLOKAL_MK => array(
      // deactivate mk banners before deploy
       0 => '_5Sak6bHovSf9ehsaKTgxMS5f3zyO27GCYVxtvd3kGD.L7', // inner page
       1 => '5AExtM0mXKSscaJ2v2CtrITifaIdeQbGQhjVW3ltA7T.k7' // when home
    ),
    getlokalPartner::GETLOKAL_RS => array(
      0 => 'TPOcl1Od7Vkgrwk3ddrR0xKPIBvvHeOQBzRDAZoNmVf.T7',//inner page
      1 => 'mM.1jn5MjewwepAKamt1YOUgnghd1HrEqWlR_byLR.r.s7'//home page
    ),
  );
  if($module == 'search'){
  	$mId = 'R2tQahtb5wJVLRI_aCov1HWF7sMdFpryiPt4mVx__2v.Q7';
  }elseif($module == 'article'){
  	$mId = 'jJ6b3RAkSIbadF3WY57KFuvhTOhuKR.eHfV.A.vt7Tr.27';
  }elseif($module == 'event'){
  	$mId = 'uSg3rJG.J8dI4RtlMDF_U1II32APaC_tR6806NoRjCP.a7';
  }elseif($module == 'list'){
  	$mId = 'fjeqBTaZA858Uv2mCvIxJMwTbdGesWb32yRvbjS9abj.W7';
  }else{
  	$mId = isset($_masterIds[$culture][$home]) ? $_masterIds[$culture][$home] : false;
  }
  if (!$mId) {
    return;
  }
  
?>

<?php if ($type == 'head'): ?>
    <script type="text/javascript" src="<?php echo $protocol ?>thinkdigitalro.adocean.pl/files/js/ado.js"></script>
	<script type="text/javascript">
	/* (c)AdOcean 2003-2014 */
		if(typeof ado!=="object"){ado={};ado.config=ado.preview=ado.placement=ado.master=ado.slave=function(){};} 
		ado.config({mode: "old", xml: false, characterEncoding: true});
		ado.preview({enabled: true, emiter: "thinkdigitalro.adocean.pl", id: "oXTn7j_ad6iUkvFGD4nXY6nZ8P9b3WcB2q20ggVKEw7.e7"});
	</script>

  <!-- start master -->  <script type="text/javascript">
  /* (c)AdOcean 2003-2013, MASTER: f5web_ro.getlokal all site */
  ado.master({id: '<?php echo $mId; ?>', server: 'thinkdigitalro.adocean.pl' });
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
  <?php
    $id = $_options[$culture][$home][$type];
  ?>
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
        ado.placement({id: '<?php echo $id; ?>', server: 'thinkdigitalro.adocean.pl' });
    </script>
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
