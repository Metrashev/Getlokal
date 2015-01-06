<?php  $uri = '@company?slug='.$company->getSlug().'&city='.$company->getCity()->getSlug().'&sf_culture=sr';?>
Poštovani, <?php echo $company->getCreatedByUser()->getFirstName();?>,<br>
Nadamo se da ste uživali u <?php echo link_to($company->getCompanyTitleByCulture('sr'), $uri, array('absolute'=>true)) ?>.
<br><br>
Odvojite malo vremena i napišite preporuku, objavite fotografije i podelite svoje mišljenje sa drugim korisnicima :)
<br>Hvala vam!
<br><br>
Ako imate bilo kakvo pitanje slobodno nas kontaktirajte na: <a href="mailto:serbia@getlokal.com">serbia@getlokal.com</a><br>
Uživajte koristeći getlokal.com!<br>
Getlokal.com tim
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
If you have any questions, feel free to write to us at: <a href="mailto:serbia@getlokal.com">serbia@getlokal.com</a><br>
Enjoy getlokal.com!<br>
The getlokal.com team
