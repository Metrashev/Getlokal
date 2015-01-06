<?php 
//$uri = ProjectConfiguration::getRouting()->generate('company', array('sf_culture' => 'hu', 'city'=>$company->getCity()->getSlug(),'slug'=>$company->getSlug()),true);?>
Kedves, <?php echo $company->getCreatedByUser()->getFirstName();?>,<br>
<?php  $uri = '@company?slug='.$company->getSlug().'&city='.$company->getCity()->getSlug().'&sf_culture=hu';?>
<br>

Reméljük, hogy a (<?php echo link_to($company->getCompanyTitle('hu', $company->getCountryId()), $uri, array('absolute'=>true)) ?>) tetszett.
<br><br>
Állj meg egy pillanatra és írd meg a megjegyzésedet, töltsél fel képeket és osszd meg a tapasztalataidat más emberekkel, olyanokkal mint te :)
<br>Köszönünk! 
<br><br>
Ha bármi kérdésed lenne, nyugodtan írjál nekünk <a href="mailto:hungary@getlokal.com">hungary@getlokal.com címre.</a>.<br>
Élvezzd a getlokal.hu-ot!<br>
getlokal.hu csapata<br><br><br>

-----------------------------------------------
<br><br>
<?php  $uri = '@company?slug='.$company->getSlug().'&city='.$company->getCity()->getSlug().'&sf_culture=en';?>
Dear, <?php echo $company->getCreatedByUser()->getFirstName();?>,<br>
We hope you enjoyed (<?php echo link_to($company->getCompanyTitle('en', $company->getCountryId()), $uri, array('absolute'=>true)) ?>).
<br><br>
Take a moment to review it, post pictures and share your experience with other people like you :)
<br>Thank you!
<br><br>
If you have any questions, feel free to write to us at: <a href="mailto:hungary@getlokal.com">hungary@getlokal.com</a><br>
Enjoy getlokal.hu!<br>
The getlokal.hu team
