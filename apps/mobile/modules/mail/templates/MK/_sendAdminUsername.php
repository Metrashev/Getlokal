<?php $company = $pageadmin->getCompanyPage()->getCompany();?>
Добредојде на getlokal.mk<br>



Dear<?php echo ($pageadmin->getUserProfile()->getGender() == 'f')? ' Mrs': (($pageadmin->getUserProfile()->getGender() == 'm')? ' Mr': '');?> <?php  if ($pageadmin->getUserProfile()->getGender()): echo ($pageadmin->getUserProfile()->getLastName())? $pageadmin->getUserProfile()->getLastName():$pageadmin->getUserProfile()->getFirstName() ; endif;?>,
<br>

You requested a username for your place <?php echo $company->getCompanyTitle('en');?>. Here it is:

<br>
<?php echo $pageadmin->getUsername() ?><br><br>

<br>
You can now log in using your username:<br>

<?php echo url_for('companySettings/login?slug='.$company->getSlug(), true) ?><br>
<br>


<br>
If you have any questions, feel free to write to us at: <a href="mailto:macedonia@getlokal.com">macedonia@getlokal.com</a><br>
Thank you very much  and enjoy getlokal.mk<br>
The getlokal.mk team

<?php include_partial('mail/mail_footer_mk');?>