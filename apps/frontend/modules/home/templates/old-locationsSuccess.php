<div class="content_in">
<ul class="directory">    
  <?php 
  foreach($locations as $location): ?> 
   <?php
	$partner_class = getlokalPartner::getLanguageClass ( getlokalPartner::getInstance () );
	if ($location->getIsDefault () && 0):
	  $url = '@sublevel?slug=' . $classification->getSlug () . '&sector=' . $classification->getPrimarySector ()->getSlug () . '&city=' . $location->getSlug ();
	else:
	  $url = '@classification?slug=' . $classification->getSlug () . '&sector=' . $classification->getPrimarySector ()->getSlug () . '&city=' . $location->getSlug ();
	endif;		

            echo '<li>'.link_to($location->getLocation () . ', ' . mb_convert_case ( $location->getCounty ()->getName (), MB_CASE_TITLE, 'UTF-8' ), $url).'</li>' ;

            ?>
  <?php endforeach ?>
  </ul>
</div>
<?php include_partial('home/sideBar');?>
<div class="clear"></div>