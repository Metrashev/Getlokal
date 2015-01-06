<?php 
//$uri = ProjectConfiguration::getRouting()->generate('company', array('sf_culture' => 'bg', 'city'=>$company->getCity()->getSlug(),'slug'=>$company->getSlug()),true);?>
Здравей, <?php echo $company->getCreatedByUser()->getFirstName();?>,<br>
<?php  $uri = '@company?slug='.$company->getSlug().'&city='.$company->getCity()->getSlug().'&sf_culture=bg';?>
<br>

Надяваме се, че ти е харесало в <?php echo link_to($company->getCompanyTitleByCulture('bg'), $uri, array('absolute'=>true)) ?>.
<br><br>
Отдели ни момент и напиши ревюто си, качи снимки и сподели изживяванията си с други като теб :)
<br>Благодарим! 
<br><br>
Ако имаш някакви въпроси, не се колебай да се свържеш с нас на <a href="mailto:info@getlokal.com">info@getlokal.com</a>.<br>
Благодарим и приятно сърфиране!<br>
Екипът на getlokal.com
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
If you have any questions, feel free to write to us at: <a href="mailto:info@getlokal.com">info@getlokal.com</a><br>
Enjoy getlokal.com!<br>
The getlokal.com team
