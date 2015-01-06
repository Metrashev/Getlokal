<?php $company = $pageadmin->getCompanyPage()->getCompany();?>

<br><br>
<?php echo ($pageadmin->getUserProfile()->getGender() == 'f')? 'Poštovana': (($pageadmin->getUserProfile()->getGender() == 'm')? 'Poštovani': '');?> <?php  if ($pageadmin->getUserProfile()->getGender()): echo ($pageadminName)? $pageadminName:$pageadmin->getUserProfile()->getLastName() ; endif;?>,
<br>

Tražili ste korisničko ime za profil Vaše firme <?php echo $company->getCompanyTitle('sr');?>. Izvolite:

<br>
<?php echo $pageadmin->getUsername() ?><br><br>

<br>
Možete se logovati korišćenjem Vašeg korisničkog imena:<br>

<?php echo url_for('companySettings/login?slug='.$company->getSlug(), true) ?><br>
<br>

Ako imate bilo kakvo pitanje slobodno nas kontaktirajte na: <a href="mailto:serbia@getlokal.com">serbia@getlokal.com</a><br>
Uživajte koristeći getlokal.rs!<br>
Getlokal.rs tim

<br><br><br>

-----------------------------------------------
<br><br>
Dear<?php echo ($pageadmin->getUserProfile()->getGender() == 'f')? ' Mrs': (($pageadmin->getUserProfile()->getGender() == 'm')? ' Mr': '');?> <?php  if ($pageadmin->getUserProfile()->getGender()): echo ($pageadminName)? $pageadminName:$pageadmin->getUserProfile()->getLastName() ; endif;?>,
<br>

You requested a username for your place <?php echo $company->getCompanyTitle('en');?>. Here it is:

<br>
<?php echo $pageadmin->getUsername() ?><br><br>

<br>
You can now log in using your username:<br>

<?php echo url_for('companySettings/login?slug='.$company->getSlug(), true) ?><br>
<br>

If you have any questions, feel free to write to us at: <a href="mailto:serbia@getlokal.com">serbia@getlokal.com</a><br>
Thank you very much  and enjoy getlokal.rs<br>
The getlokal.rs team

<?php include_partial('mail/mail_footer_sr');?>