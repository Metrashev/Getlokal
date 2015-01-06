<?php use_helper('Link')?>
<?php $path = link_to_frontend('sf_guard_signin', array('sf_culture'=>'hu'));?>

Tisztelt <?php echo ($profile->getGender() == 'f')? 'Asszony': (($profile->getGender() == 'm')? ' Úr': '');?> <?php  if ($profile->getGender()): echo (($profile->getLastName())? $profile->getLastName():$profile->getFirstName()) ; endif;?>,
<br><br>
Az igényük <?php echo $company->getCompanyTitle('hu');?>-nak a csatlakozására Önök bizniszprofiljához<a href="http://www.getlokal.hu">www.getlokal.hu-ban</a> vissza volt utasítva, mert probléma lépett fel. 
<br><br>
Valószinűleg ellentmondás volt a céginformációban, amit Önök küldtek és nem tudtuk felvenni a kapcsolatot telefonon hogy ellenőrizzük azt.
<br><br>
Kérjük lépjenek be újra a bizniszprofiljukba és ellenőrizzenek újból minden elérhetőséget  mielőtt hozzádnák  <?php echo $company->getCompanyTitle('hu');?> újra. 
<a href="<?php echo $path?>"><?php echo $path;?></a><br><br>
Megprobáljuk az új igény kezhezvétele után 3 munkanapon belül felvenni a kapcsolatot Önökkel.  Ha nem kaptak telefonhívást részünkről 3 munkanapon belül és az igényük nincs jóváhagyva, kérjük írjanak <a href="mailto:hungary@getlokal.com">hungary@getlokal.com</a>.<br><br>-ra.
Köszönünk és élvezze a getlokal.hu-ot!<br>
getlokal.hu csapata<br><br><br>
-----------------------------------------------
<?php $path = link_to_frontend('sf_guard_signin', array('sf_culture'=>'en'));?>

<br><br>
Dear<?php echo ($profile->getGender() == 'f')? ' Mrs': (($profile->getGender() == 'm')? ' Mr': '');?> <?php  if ($profile->getGender()): echo ($profile->getLastName())? $profile->getLastName():$profile->getFirstName() ; endif;?>,<br><br>

Your application for claiming <?php echo $company->getCompanyTitle('en');?> in <a href="http://www.getlokal.hu/en">www.getlokal.hu</a> has been rejected as there was a problem with it. <br><br>

This is most likely due to a discrepancy with the business information that we have for you and we haven't been able to contact you by phone to verify it.<br><br>

<a href="<?php echo $path?>"><?php echo $path;?></a><br><br>


Please log into your business profile and check all the contact information again before you claim <?php echo $company->getCompanyTitle('en');?> again.<br><br>

We will try to contact you within 3 working days of receiving the new claim. If you don't hear from us within 3 working days and your claim is not approved please contact us at:<a href="mailto:hungary@getlokal.com">hungary@getlokal.com</a> 
<br><br>
Thank you very much and enjoy getlokal.hu <br>
The getlokal.hu team 




