<?php 
//$uri = ProjectConfiguration::getRouting()->generate('company', array('sf_culture' => 'bg', 'city'=>$company->getCity()->getSlug(),'slug'=>$company->getSlug()),true);?>
Hyvä, <?php echo $company->getCreatedByUser()->getFirstName();?>,<br>
<?php  $uri = '@company?slug='.$company->getSlug().'&city='.$company->getCity()->getSlug().'&sf_culture=fi';?>
<br>

Toivomme että pidit <?php echo link_to($company->getCompanyTitleByCulture('fi'), $uri, array('absolute'=>true)) ?>.
<br><br>
Käytä hetki paikan arvioimiseen, lataa kuvia ja jaa kokemuksesi muiden ihmisten kanssa :)
<br>Kiitos!
<br><br>
Jos Sinulla on kysyttävää, ole hyvä ja ota yhteyttä kirjoittamalla meille: <a href="mailto:finland@getlokal.com">finland@getlokal.com</a>.<br>
Toivomme että viihdyt getlokal.fi palvelumme parissa!<br>
Getlokal.fi tiimi

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
If you have any questions, feel free to write to us at: <a href="mailto:finland@getlokal.com">finland@getlokal.com</a><br>
Enjoy getlokal.fi!<br>
The getlokal.fi team
