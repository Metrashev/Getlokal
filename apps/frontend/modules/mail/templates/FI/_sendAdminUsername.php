<?php $company = $pageadmin->getCompanyPage()->getCompany();?>

Hyvä<?php echo ($pageadmin->getUserProfile()->getGender() == 'f')? ' Rouva': (($pageadmin->getUserProfile()->getGender() == 'm')? ' Herra': '');?> <?php  if ($pageadmin->getUserProfile()->getGender()): echo (($pageadmin->getUserProfile()->getLastName())? $pageadmin->getUserProfile()->getLastName():$pageadmin->getUserProfile()->getFirstName()) ; endif;?>,
<br><br>

Olette pyytäneet uutta käyttäjätunnusta yrityksellenne <?php echo $company->getCompanyTitle('bg');?>. Tässä, ole hyvä: <br><br>
<?php echo $pageadmin->getUsername() ?><br><br>
Voit nyt kirjautua sisään uudella käyttäjätunnuksella: <br>
<?php echo url_for('companySettings/login?slug='.$company->getSlug(), true) ?><br>
<br>
Jos Sinulla on kysyttävää, ole hyvä ja kirjoita meille: <a href="mailto:finland@getlokal.com">finland@getlokal.com</a>.<br>
Toivomme, että viihdyt getlokal.fi palvelumme parissa<br>
Getlokal.fi tiimi


<br><br>
-----------------------------------------------
<br><br>

<?php $company = $pageadmin->getCompanyPage()->getCompany();?>

Dear<?php echo ($pageadmin->getUserProfile()->getGender() == 'f')? ' Mrs': (($pageadmin->getUserProfile()->getGender() == 'm')? ' Mr': '');?> <?php  if ($pageadmin->getUserProfile()->getGender()): echo ($pageadmin->getUserProfile()->getLastName())? $pageadmin->getUserProfile()->getLastName():$pageadmin->getUserProfile()->getFirstName() ; endif;?>,
<br>

You requested a username for your place <?php echo $company->getCompanyTitle('en');?>. Here it is:

<br>
<?php echo $pageadmin->getUsername() ?><br><br>

<br>
You can now log in using your username:<br>

<?php echo url_for('companySettings/login?slug='.$company->getSlug(), true) ?><br>
<br>

If you have any questions, feel free to write to us at: <a href="mailto:finland@getlokal.com">finland@getlokal.com</a><br>
Thank you very much  and enjoy getlokal.fi<br>
The getlokal.fi team
<br>
<?php include_partial('mail/mail_footer_bg');?>
