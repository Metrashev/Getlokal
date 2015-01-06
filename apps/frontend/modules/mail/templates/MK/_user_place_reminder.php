<?php 
//$uri = ProjectConfiguration::getRouting()->generate('company', array('sf_culture' => 'bg', 'city'=>$company->getCity()->getSlug(),'slug'=>$company->getSlug()),true);?>
Здравей, <?php echo $company->getCreatedByUser()->getFirstName();?>,<br>
<?php  $uri = '@company?slug='.$company->getSlug().'&city='.$company->getCity()->getSlug().'&sf_culture=mk';?>
<br>

Се надеваме дека ти се допаѓа <?php echo link_to($company->getCompanyTitleByCulture('mk'), $uri, array('absolute'=>true)) ?>.
<br><br>
Оддели само момент да напишеш Препорака, да прикачиш слика и да го споделиш искуството со другите како тебе :)
<br>Ти благодариме! 
<br><br>
Ако имаш някакви въпроси, не се колебай да се свържеш с нас на <a href="mailto:macedonia@getlokal.com">macedonia@getlokal.com</a>.<br>
Благодарим и приятно сърфиране!<br>
Екипът на getlokal.mk
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
If you have any questions, feel free to write to us at: <a href="mailto:macedonia@getlokal.com">macedonia@getlokal.com</a><br>
Enjoy getlokal.mk!<br>
The getlokal.mk team

<?php include_partial('mail/mail_footer_mk');?>
