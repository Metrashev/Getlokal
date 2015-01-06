
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
