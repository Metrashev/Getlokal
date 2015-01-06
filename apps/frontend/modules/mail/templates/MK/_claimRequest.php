<?php  $company = $pageAdmin->getCompanyPage()->getCompany();?>

Почитуван<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? 'a г-а': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' г-дин': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName() ; endif;?>,
<br><br>

Добивме барање од <?php echo $userAdmin->getUserProfile()?> за администрација на <?php echo $company->getCompanyTitle('mk');?>,  <?php echo $company->getDisplayAddress('mk');?>.

<br><br>
За да го одобрите или одбиете ова барање,
<?php echo link_to('log into you profile','userSettings/companySettings', array('absolute'=>true))?>, кликнете на Мои места, одберете го местото и кликнете на опцијата Администратори од левото мени.<br><br>
<ul>
<li>Со одобрување на барањето за администрација, му давате пристап на одобрениот администратор да менаџира со содржината за местото</li>
<li>Со одбивање на барањето за администрација, не му дозволувате на неодобрениот администратор да менаџира со содржината за местото</li>
</ul>
<br><br>
Доколку имате било какви прашања, слободно контактирајте не на <a href="mailto:macedonia@getlokal.com">macedonia@getlokal.com</a><br />
<br />
Ви благодариме! <br />
Тимот на getlokal.mk

<br><br><br>

-----------------------------------------------
<br><br>

Dear<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' Mrs': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' Mr': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName() ; endif;?>,
<br><br>

We received a request from <?php echo $userAdmin->getUserProfile()?> to administrate <?php echo $company->getCompanyTitle('en');?>,  <?php echo $company->getDisplayAddress('en');?>.

<br><br>
In order to approve or reject the request, please
<?php echo link_to('log into you profile','userSettings/companySettings?sf_culture=en', array('absolute'=>true))?>, go to My Places, log into the place profile and choose the Administrators option from the menu to the left.<br><br>
<ul>
<li> By approving the administration request, you grant the approved administrator the rights to manage the place content </li>
<li> By rejecting the administration request, you deny the pending administrator the rights to manage the place content </li>
</ul>
<br><br>
If you have any questions, feel free to write to us at: <a href="mailto:macedonia@getlokal.com">macedonia@getlokal.com</a><br />
<br />
Thank you very much and enjoy getlokal.mk! <br />
The getlokal.mk team

<?php include_partial('mail/mail_footer_mk');?>
