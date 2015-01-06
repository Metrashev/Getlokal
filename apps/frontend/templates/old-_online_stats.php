<?php if($sf_user->getCountry()->getSlug() == 'bg'):?>
<!-- START Nielsen Online SiteCensus V6.0 -->
<!-- COPYRIGHT 2010 Nielsen Online -->
<script type="text/javascript" src="//secure-it.imrworldwide.com/v60.js">
</script>
<script type="text/javascript">
 var pvar = { cid: "bg-goldenpages", content: "0", server: "secure-it" };
 var feat = { check_fraud: 1 };
 var trac = nol_t(pvar, feat);
 trac.record().post();
</script>
<noscript>
 <div>
 <img src="//secure-it.imrworldwide.com/cgi-bin/m?ci=bg-goldenpages&amp;cg=0&amp;cc=1&amp;ts=noscript"
 width="1" height="1" alt="" />
 </div>
</noscript>
<!-- END Nielsen Online SiteCensus V6.0 -->
<?php elseif($sf_user->getCountry()->getSlug() == 'ro'):?>

<!-- START Nielsen Online SiteCensus V6.0 -->
<!-- COPYRIGHT 2010 Nielsen Online -->
<script type="text/javascript" src="//secure-it.imrworldwide.com/v60.js">
</script>
<script type="text/javascript">
 var pvar = { cid: "bg-goldenpages", content: "0", server: "secure-it" };
 var feat = { check_fraud: 1 };
 var trac = nol_t(pvar, feat);
 trac.record().post();
</script>
<noscript>
 <div>
 <img src="//secure-it.imrworldwide.com/cgi-bin/m?ci=bg-goldenpages&amp;cg=0&amp;cc=1&amp;ts=noscript"
 width="1" height="1" alt="" />
 </div>
</noscript>
<!-- END Nielsen Online SiteCensus V6.0 -->
<?php elseif($sf_user->getCountry()->getSlug() == 'mk'):?>
<?php endif;?>