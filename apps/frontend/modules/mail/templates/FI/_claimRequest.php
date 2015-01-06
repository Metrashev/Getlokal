<?php  $company = $pageAdmin->getCompanyPage()->getCompany();?>

Hyvä<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' Hyvä': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' Herra': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo (($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName()) ; endif;?>,
<br><br>

Olemme vastaanottaneet pyynnön <?php echo $userAdmin->getUserProfile()?> to administrate <?php echo $company->getCompanyTitle('fi');?>,  <?php echo $company->getDisplayAddress('fi');?>.

<br><br>
Jotta voimme käsitellä pyyntösi, ole hyvä ja 
<?php echo link_to('log into you profile','userSettings/companySettings', array('absolute'=>true))?>, mene osioon Minun Yritykseni, kirjaudu yrityksen profiiliin ja valitse valikosta Sivuston Ylläpitäjä vaihtoehto.<br><br>
<ul>
<li> Hyväksymällä Sivuston Ylläpitäjä pyynnön, annat valitulle Sivuston Ylläpitäjälle oikeuden päivittää yrityksen tietoja</li>
<li> Hylkäämällä Sivuston Ylläpitäjä pyynnön, estät Sivuston Ylläpitäjän oikeuden paivittää yrityksen tietoja.</li>
</ul>
<br><br>
Jos Sinulla on kysyttävää, ole hyvä ja kirjoita meille: <a href="mailto:finland@getlokal.com">finland@getlokal.com</a>.<br>
Toivomme, että viihdyt getlokal.fi palvelun parissa! <br>
Getlokal.fi tiimi

<br><br>
-----------------------------------------------
<br><br>

<?php  $company = $pageAdmin->getCompanyPage()->getCompany();?>

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

If you have any questions, feel free to write to us at: <a href="mailto:finland@getlokal.com">finland@getlokal.com</a><br>
<br>
Thank you very much and enjoy getlokal.fi! <br>
The getlokal.fi team
<br>
<?php include_partial('mail/mail_footer_fi');?>
