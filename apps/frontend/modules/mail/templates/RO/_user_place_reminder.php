<?php 
//$uri = ProjectConfiguration::getRouting()->generate('company', array('sf_culture' => 'bg', 'city'=>$company->getCity()->getSlug(),'slug'=>$company->getSlug()),true);?>
Dragă <?php echo $company->getCreatedByUser()->getFirstName();?>,<br>
<?php  $uri = '@company?slug='.$company->getSlug().'&city='.$company->getCity()->getSlug().'&sf_culture=ro';?>
<br>
Sperăm că ți-a plăcut la <?php echo link_to($company->getCompanyTitleByCulture('ro'), $uri, array('absolute'=>true)) ?>. <br>
<br>
Durează mai puțin de un minut să ne spui, în scris, care a fost experiența ta la local, poate să publici și câteva fotografii și apoi să împarți părerile tale cu prietenii :) <br>
<br>
Mulțumim! <br>
<br>
Dacă ai întrebări sau nelămuriri, așteptăm un mail la: <a href="mailto:romania@getlokal.com">romania@getlokal.com</a><br>
<br>
Sperăm să îți placă getlokal.ro!<br>
Echipa Getlokal
<br><br>
-----------------------------------------------
<br><br>
<?php  $uri = '@company?slug='.$company->getSlug().'&city='.$company->getCity()->getSlug().'&sf_culture=en';?>
Dear, <?php echo $company->getCreatedByUser()->getFirstName();?>,<br>
We hope you enjoyed <?php echo link_to($company->getCompanyTitleByCulture('en'), $uri, array('absolute'=>true)) ?>.
<br><br>
Take a moment to review it, post pictures and share your experience with other people like you :)
<br>Thank you!
<br><br>
If you have any questions, feel free to write to us at: <a href="mailto:romania@getlokal.com">romania@getlokal.com</a><br>
Enjoy getlokal.com!<br>
The getlokal.com team