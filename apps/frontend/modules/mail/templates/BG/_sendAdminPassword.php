<?php $company = $pageadmin->getCompanyPage()->getCompany();?>

Здравейте<?php echo ($pageadmin->getUserProfile()->getGender() == 'f')? ' г-жо': (($pageadmin->getUserProfile()->getGender() == 'm')? ' г-н': '');?> <?php  if ($pageadmin->getUserProfile()->getGender()): echo (($pageadmin->getUserProfile()->getLastName())? $pageadmin->getUserProfile()->getLastName():$pageadmin->getUserProfile()->getFirstName()) ; endif;?>,
<br><br>

 Mожете да влезете в профила си за фирма <?php echo $company->getCompanyTitle('bg');?> в getlokal с парола:<br><br>
<?php echo $password ?><br><br>
Използвайте този линк, за да влезете в профила си: <br>
<?php echo url_for('companySettings/login?slug='.$company->getSlug(), true) ?><br>
<br>
Ако имате някакви въпроси, не се колебайте да се свържете с нас на  <a href="mailto:info@getlokal.com">info@getlokal.com</a>.<br>
<br> Благодарим ви и ви пожелаваме приятно сърфиране!
<br>Екипът на getlokal.com

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

If you have any questions, feel free to write to us at: <a href="mailto:info@getlokal.com">info@getlokal.com</a><br>
Thank you very much  and enjoy getlokal.com<br>
The getlokal.com team

<?php include_partial('mail/mail_footer_bg');?>