<?php $company = $pageadmin->getCompanyPage()->getCompany();?>

Bună ziua<?php echo ($pageadmin->getUserProfile()->getGender() == 'f')? ' D-na': (($pageadmin->getUserProfile()->getGender() == 'm')? ' D-nul': '');?> <?php  if ($pageadmin->getUserProfile()->getGender()): echo ($pageadmin->getUserProfile()->getLastName())? $pageadmin->getUserProfile()->getLastName():$pageadmin->getUserProfile()->getFirstName() ; endif;?>,
<br /><br>

Iată username-ul pe care l-ai cerut pentru locul tău - <?php echo $company->getCompanyTitle('ro');?>: <br><br><?php echo $pageadmin->getUsername() ?><br><br>
De acum înainte te poți loga folosind acest username. <br>
<?php echo url_for('companySettings/login?slug='.$company->getSlug(), true) ?><br>
<br>
Dacă ai întrebări, le așteptăm pe <a href="mailto:romania@getlokal.com">romania@getlokal.com</a>. Răspundem cât de repede putem!<br>
<br>Mulţumim şi un surffing plăcut!<br />
<br>Echipa getlokal.ro

<br><br><br>

-----------------------------------------------
<br><br><br>Dear<?php echo ($pageadmin->getUserProfile()->getGender() == 'f')? ' Mrs': (($pageadmin->getUserProfile()->getGender() == 'm')? ' Mr': '');?> <?php  if ($pageadmin->getUserProfile()->getGender()): echo ($pageadmin->getUserProfile()->getLastName())? $pageadmin->getUserProfile()->getLastName():$pageadmin->getUserProfile()->getFirstName() ; endif;?>,
<br>

You requested a username for your place <?php echo $company->getCompanyTitle('en');?>. Here it is:

<br>
<?php echo $pageadmin->getUsername() ?><br><br>

<br>
You can now log in using your username:<br>

<?php echo url_for('companySettings/login?slug='.$company->getSlug(), true) ?><br>
<br>


<br>
If you have any questions, feel free to write to us at: <a href="mailto:romania@getlokal.com">romania@getlokal.com</a><br>
Thank you very much  and enjoy getlokal.ro<br>
The getlokal.ro team

<?php include_partial('mail/mail_footer_ro');?>