<?php $company = $pageadmin->getCompanyPage()->getCompany();?>

Hyvä<?php echo ($pageadmin->getUserProfile()->getGender() == 'f')? ' Rouva': (($pageadmin->getUserProfile()->getGender() == 'm')? ' Herra': '');?> <?php  if ($pageadmin->getUserProfile()->getGender()): echo (($pageadmin->getUserProfile()->getLastName())? $pageadmin->getUserProfile()->getLastName():$pageadmin->getUserProfile()->getFirstName()) ; endif;?>,
<br><br>

Olette pyytäneet salasanaa yrityksellenne <?php echo $company->getCompanyTitle('bg');?> Tässä, ole hyvä: <br><br>
<?php echo $password ?><br><br>
Voit nyt kirjautua sisään käyttäjätunnuksellanne: <br>
<?php echo url_for('companySettings/login?slug='.$company->getSlug(), true) ?><br>
<br>
Jos Sinulla on kysyttävää, ole hyvä ja ota yhteyttä kirjoittamalla: <a href="mailto:finland@getlokal.com">finland@getlokal.com</a>.<br>
toivomme, että viihdyt getlokal.fi palvelun parissa<br>
Getlokal.fi tiimi


<br><br>
-----------------------------------------------
<br><br>

<?php $company = $pageadmin->getCompanyPage()->getCompany();?>

Dear<?php echo ($pageadmin->getUserProfile()->getGender() == 'f')? ' Mrs': (($pageadmin->getUserProfile()->getGender() == 'm')? ' Mr': '');?> <?php  if ($pageadmin->getUserProfile()->getGender()): echo ($pageadmin->getUserProfile()->getLastName())? $pageadmin->getUserProfile()->getLastName():$pageadmin->getUserProfile()->getFirstName() ; endif;?>,
<br>

You requested a password for your place <?php echo $company->getCompanyTitle('en');?>. Here it is:

<br>
<?php echo $password ?><br><br>

<br>
You can now log in using your username:<br>

<?php echo url_for('companySettings/login?slug='.$company->getSlug(), true) ?><br>
<br>

If you have any questions, feel free to write to us at: <a href="mailto:finland@getlokal.com">finland@getlokal.com</a><br>
Thank you very much  and enjoy getlokal.fi<br>
The getlokal.fi team
<br>
<?php include_partial('mail/mail_footer_fi');?>
