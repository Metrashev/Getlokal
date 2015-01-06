<div class="content_in">
  <ul class="directory">
    <?php foreach($locations as $location): ?>
        <?php $clean_street = str_replace(array("„","“","”"),"", $location['cl_nbh']);?>
        <?php if ($location['cl_nbh'] && strlen($location['cl_nbh']) > 3):?>
            <?php $partner_class = getlokalPartner::getLanguageClass ( getlokalPartner::getInstance () );?>
            <?php $street= mb_convert_case ( call_user_func ( array ('Transliterate' . $partner_class, 'toLatin' ), $clean_street ), MB_CASE_TITLE, 'UTF-8' );?>
            <?php  $to = 'to'.$sf_user->getCulture();?>
            <?php if($sf_user->getCulture() != 'en' && $sf_user->getCulture() != $sf_user->getCountry()->getSlug() && method_exists('Transliterate' . $partner_class, $to)):
                    $street= mb_convert_case ( call_user_func ( array ('Transliterate' . $partner_class, $to ), $clean_street ), MB_CASE_TITLE, 'UTF-8' );
                  endif;
                ?>
            <?php $street_url= mb_convert_case ( call_user_func ( array ('Transliterate' . $partner_class, 'toLatin' ), $clean_street ), MB_CASE_LOWER, 'UTF-8' );?>
            <?php $url ='@streetClassification?slug='. $classification->getSlug(). '&sector='. $classification->getPrimarySector()->getSlug(). '&city='. $city->getSlug().'&street='.$street_url;  
            $url=urldecode($url);	?>
            <?php
            
            if ($sf_user->getCulture() == 'en') :	
                echo '<li>'.link_to($street . ', ' . $city->getCounty ()->getName() , $url) .' ('. $location['cl_cnt'] .')'.'</li>' ;
            else:
                echo '<li>'.link_to($clean_street . ', ' . mb_convert_case($city->getCounty ()->getName(), MB_CASE_TITLE,'UTF-8'), $url).' ('. $location['cl_cnt'] .')'.'</li>' ;
            endif;
            ?>
                <br>
        <?php endif;?> 
    <?php endforeach ?>
  </ul>

</div>

<div class="clear"></div>

<?php include_partial('home/sideBar');?>