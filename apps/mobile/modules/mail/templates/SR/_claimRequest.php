<?php  $company = $pageAdmin->getCompanyPage()->getCompany();?>

<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? 'Poštovana': (($pageAdmin->getUserProfile()->getGender() == 'm')? 'Poštovani': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($firstName)? $firstName:$pageAdmin->getUserProfile()->getLastName() ; endif;?>, 
<br><br>

Primili smo zahtev od <?php echo $userAdmin->getUserProfile()?> da administrira <?php echo $company->getCompanyTitle('sr');?>,  <?php echo $company->getDisplayAddress('sr');?>.

<br><br>
Kako biste potvrdili ili odbili zahtev, molimo <?php echo link_to('log into you profile','userSettings/companySettings', array('absolute'=>true))?>, idite na Moja Mesta, ulogujte se na profil mesta/firme i odaberite opcije administratora iz menija levo.<br><br>
<ul>
<li> Potvrdom zahteva, odobravate novom administratoru da administrira sadržej profila. </li>
<li> Odbijanjem zahteva isključujete mogućnost da korisnik koji je podneo zahtev ažurira sadržaj profila. </li>
</ul>
<br><br>

Ako imate bilo kakvo pitanje slobodno nas kontaktirajte na: <a href="mailto:serbia@getlokal.com">serbia@getlokal.com</a><br>
Uživajte koristeći getlokal.rs!<br>
Getlokal.rs tim

<br><br><br>

-----------------------------------------------
<br><br>
Dear<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' Mrs': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' Mr': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($firstName)? $firstName:$pageAdmin->getUserProfile()->getLastName() ; endif;?>,
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

If you have any questions, feel free to write to us at: <a href="mailto:serbia@getlokal.com">serbia@getlokal.com</a><br>
<br>
Thank you very much and enjoy getlokal.rs! <br>
The getlokal.rs team

<?php include_partial('mail/mail_footer_sr');?>