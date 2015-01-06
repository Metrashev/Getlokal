<?php  $company = $pageAdmin->getCompanyPage()->getCompany();?>

<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? 'Poštovana': (($pageAdmin->getUserProfile()->getGender() == 'm')? 'Poštovani': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdminSr)? $pageAdminSr:$pageAdmin->getUserProfile()->getLastName() ; endif;?>,
<br><br>
Zahtev za preuzimanje profila mesta/firme  <?php echo $company->getCompanyTitleByCulture('sr');?>, <?php echo $company->getDisplayAddress(); ?> on <a href="http://www.getlokal.rs/sr">www.getlokal.rs</a> je odbijen.
<br><br>
Praksa je da putem telefonskog razgovora potvrdimo verodostojnost osobe koja želi da preuzme pravo za ađuriranje podataka mesta/firme.
<br><br>
Vaš zahtev je odbijen najverovatnije zbog nedovoljih informacija koje bi nas uverile da ste Vi ovlašćena osoba u firmi.
<br><br>
Takođe, moguće je da ste odbijeni zbog greške koja se javila u našem sistemu i u tom slučaju se izvinjavamo. Kontaktiraćemo vas u najkraćem mogućem roku kako bismo potvrdili vaše preuzimanje profila.
<br><br>
Ako imate bilo kakvo pitanje slobodno nas kontaktirajte na: <a href="mailto:serbia@getlokal.com">serbia@getlokal.com</a><br>
Uživajte koristeći getlokal.rs!<br>
Getlokal.rs tim

<br><br><br>

-----------------------------------------------
<br><br>
Dear<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' Mrs': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' Mr': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdminSr)? $pageAdminSr:$pageAdmin->getUserProfile()->getLastName() ; endif;?>,
<br><br>
Your Place Claim for  <?php echo $company->getCompanyTitleByCulture('en');?>, <?php echo $company->getDisplayAddress(); ?> on <a href="http://www.getlokal.rs/en">www.getlokal.rs</a> has been rejected.
<br><br>
We usually verify over the phone whether the person claiming a place is authorized to manage the business information.
<br><br>
The most likely reason why we rejected your claim is that we couldn’t gather sufficient information to prove your entitlement.
<br><br>
It is also possible that the rejection was due to problems with this record in our database for which we apologize. We will contact you as soon as we can to ensure your claim is assigned to the correct place.
<br><br>
If you have any further questions, please feel free to contact us at <a href="mailto:serbia@getlokal.com">serbia@getlokal.com</a>.
<br><br>
The getlokal.rs team

<?php include_partial('mail/mail_footer_sr');?>
