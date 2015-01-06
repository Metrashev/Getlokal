<?php $company = $pageadmin->getCompanyPage()->getCompany();?>

Tisztelt <?php echo ($pageadmin->getUserProfile()->getGender() == 'f')? ' Asszony': (($pageadmin->getUserProfile()->getGender() == 'm')? ' Úr': '');?> <?php  if ($pageadmin->getUserProfile()->getGender()): echo (($pageadmin->getUserProfile()->getLastName())? $pageadmin->getUserProfile()->getLastName():$pageadmin->getUserProfile()->getFirstName()) ; endif;?>,
<br><br>

 Ön jelszót kért a <?php echo $company->getCompanyTitle('hu');?> helyre. Tessék itt van:<br><br>
<?php echo $password ?><br><br>
Már beléphet a profiljába a felhasználoi nevével: <br>
<?php echo url_for('companySettings/login?slug='.$company->getSlug(), true) ?><br>
<br>
Ha bármi kérdése van nyugodtan írjon nekünk <a href="mailto:hungary@getlokal.com">hungary@getlokal.com címre</a>.<br>
<br> Köszönjük és élevezze a getlokal.hu-ot!
<br>getlokal.hu csapata.

<br><br><br>

-----------------------------------------------
<br><br>
Dear<?php echo ($pageadmin->getUserProfile()->getGender() == 'f')? ' Mrs': (($pageadmin->getUserProfile()->getGender() == 'm')? ' Mr': '');?> <?php  if ($pageadmin->getUserProfile()->getGender()): echo ($pageadmin->getUserProfile()->getLastName())? $pageadmin->getUserProfile()->getLastName():$pageadmin->getUserProfile()->getFirstName() ; endif;?>,
<br>

You requested a password for your place <?php echo $company->getCompanyTitle('en');?>. Here it is:

<br>
<?php echo $password ?><br><br>

<br>
You can now log in using your username:<br>

<?php echo url_for('companySettings/login?slug='.$company->getSlug(), true) ?><br>
<br>

If you have any questions, feel free to write to us at: <a href="mailto:hungary@getlokal.com">hungary@getlokal.com</a><br>
Thank you very much  and enjoy getlokal.hu<br>
The getlokal.hu team

<?php include_partial('mail/mail_footer_hu');?>