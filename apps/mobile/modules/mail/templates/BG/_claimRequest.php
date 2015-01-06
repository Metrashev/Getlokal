<?php  $company = $pageAdmin->getCompanyPage()->getCompany();?>

Здравейте<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' г-жо': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' г-н': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo (($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName()) ; endif;?>,
<br><br>

Получихме заявка от <?php echo $userAdmin->getUserProfile()?> за администриране на <?php echo $company->getCompanyTitle('bg');?>,  <?php echo $company->getDisplayAddress('bg');?>.

<br><br>
За да одобрите или отхвърлите заявката, моля,
<?php echo link_to('влезте във вашия профил','userSettings/companySettings', true)?>, Изберете опцията Моите места, логнете се в профила на сътветното място и изберете опцията Администратори от менюто вляво.<br><br>
<ul>
<li>	Одобрявайки заявката за администриране, вие давате пълни права на одобрения да управлява съдържанието за вашето място. </li>
<li>	Отхвърляйки заявката, вие отказвате права на заявилия се администратор да управлява съдържанието за вашето място. </li>
</ul>
<br><br>
Ако имате въпроси, свържете с нас на <a href="mailto:info@getlokal.com">info@getlokal.com</a>.<br>

Благодарим ви и ви пожелаваме приятно сърфиране!
Екипът на getlokal.com

<br><br><br>

-----------------------------------------------
<br><br>
Dear<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' Mrs': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' Mr': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName() ; endif;?>,
<br><br>

We received a request from <?php echo $userAdmin->getUserProfile()?> to administrate <?php echo $company->getCompanyTitle('en');?>,  <?php echo $company->getDisplayAddress('en');?>.

<br><br>
In order to approve or reject the request, please
<?php echo link_to('log into you profile','userSettings/companySettings?sf_culture=en', true)?>, go to My Places, log into the place profile and choose the Administrators option from the menu to the left.<br><br>
<ul>
<li> By approving the administration request, you grant the approved administrator the rights to manage the place content </li>
<li> By rejecting the administration request, you deny the pending administrator the rights to manage the place content </li>
</ul>
<br><br>

If you have any questions, feel free to write to us at: <a href="mailto:info@getlokal.com">info@getlokal.com</a><br>
<br>
Thank you very much and enjoy getlokal.com! <br>
The getlokal.com team

<?php include_partial('mail/mail_footer_bg');?>