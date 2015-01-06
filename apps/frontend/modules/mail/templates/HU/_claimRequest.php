<?php  $company = $pageAdmin->getCompanyPage()->getCompany();?>

Tisztelt<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' Asszony': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' Úr': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo (($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName()) ; endif;?>,
<br><br>

Felkérést kaptunk <?php echo $userAdmin->getUserProfile()?> részéről  <?php echo $company->getCompanyTitle('hu');?> adminisztrálására,  <?php echo $company->getDisplayAddress('hu');?>.

<br><br>
A felkérés jóváhagyására vagy elutasítására kérjük a következőre,
<?php echo link_to('jelentkezzen be a fiókjába','userSettings/companySettings', array('absolute'=>true))?>, Изберете опцията Моите места, логнете се в профила на сътветното място и изберете опцията Администратори от менюто вляво.<br><br>
<ul>
<li>	Jóváhagyván az adminisztrálási felkérést teljes jogot biztosítanak a jóváhagyott adminisztrátornak a helyük tartalmának kezelésére. </li>
<li>	Elutasítván az adminisztrálási felkérést tagadják a várakozó adminisztrátortól a jogot a helyük tartalmának kezelésére. </li>
</ul>
<br><br>
Ha bármilyen kérdésük van, írjanak nekünk <a href="mailto:hungary@getlokal.com">hungary@getlokal.com címre</a>.<br>

Köszönünk és élvezze a getlokal.hu-ot!
getlokal.hu csapata

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

If you have any questions, feel free to write to us at: <a href="mailto:hungary@getlokal.com">hungary@getlokal.com</a><br>
<br>
Thank you very much and enjoy getlokal.hu! <br>
The getlokal.hu team

<?php include_partial('mail/mail_footer_hu');?>