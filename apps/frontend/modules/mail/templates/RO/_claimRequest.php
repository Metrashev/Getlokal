<?php  $company = $pageAdmin->getCompanyPage()->getCompany();?>
Bună ziua
<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' D-na': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' D-nul': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName() ; endif;?>,


Am primit o cerere de la <?php echo $userAdmin->getUserProfile()?> pentru a administra <?php echo $company->getCompanyTitle('ro');?>,  <?php echo $company->getDisplayAddress('ro');?>.

<br><br>
Pentru a aproba sau a respinge cererea,
<?php echo link_to('te rugăm să intri în cont','userSettings/companySettings?sf_culture=ro', array('absolute'=>true))?>, să mergi la Locurile Mele, sa intri pe profilul locului și să alegi varianta Administrator, din meniul din stânga.<br><br>
<ul>
<li> Prin aprobarea cererii de administrare, acorzi drepturi de a manageria conținutul locului</li>
<li> Dacă respingi cererea de administrare, nu acorzi drepturile de modificare asupra conținutului de pe profilul locului tău</li>
</ul>
<br><br>

Dacă ai vreo întrebare, scrie-ne la <a href="mailto:romania@getlokal.com">romania@getlokal.com</a><br />

Mulțumim!
Echipa getlokal.ro

<br /><br /><br />

-----------------------------------------------
<br /><br />
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
If you have any questions, feel free to write to us at: <a href="mailto:romania@getlokal.com">romania@getlokal.com</a><br />
<br />
Thank you very much and enjoy getlokal.ro! <br />
The getlokal.ro team

<?php include_partial('mail/mail_footer_ro');?>