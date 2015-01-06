<?php $company = $pageadmin->getCompanyPage()->getCompany();?>

<br><br>
<?php echo ($pageadmin->getUserProfile()->getGender() == 'f')? 'Poštovana': (($pageadmin->getUserProfile()->getGender() == 'm')? 'Poštovani': '');?> <?php  if ($pageadmin->getUserProfile()->getGender()): echo ($pageadminName)? $pageadminName:$pageadmin->getUserProfile()->getLastName() ; endif;?>,
<br>

Tražili ste lozinku za profil svoje firme <?php echo $company->getCompanyTitle('me');?>. Izvolite:

<br>
<?php echo $password ?><br><br>

<br>
Možete se logovati korišćenjem svog korisničkog imena:<br>

<?php echo url_for('companySettings/login?slug='.$company->getSlug(), true) ?><br>
<br>

Ako imate bilo kakvo pitanje slobodno nas kontaktirajte na: <a href="mailto:montenegro@getlokal.com">montenegro@getlokal.com</a><br>
Uživajte koristeći getlokal.me!<br>
Getlokal.me tim

<br><br><br>

-----------------------------------------------
<br><br>
Dear<?php echo ($pageadmin->getUserProfile()->getGender() == 'f')? ' Mrs': (($pageadmin->getUserProfile()->getGender() == 'm')? ' Mr': '');?> <?php  if ($pageadmin->getUserProfile()->getGender()): echo ($pageadminName)? $pageadminName:$pageadmin->getUserProfile()->getLastName() ; endif;?>,
<br>

You requested a password for your place <?php echo $company->getCompanyTitle('en');?>. Here it is:

<br>
<?php echo $password ?><br><br>

<br>
You can now log in using your username:<br>

<?php echo url_for('companySettings/login?slug='.$company->getSlug(), true) ?><br>
<br>

If you have any questions, feel free to write to us at: <a href="mailto:montenegro@getlokal.com">montenegro@getlokal.com</a><br>
Thank you very much  and enjoy getlokal.me<br>
The getlokal.me team

<?php include_partial('mail/mail_footer_me');?>