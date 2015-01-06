<?php  $company = $pageAdmin->getCompanyPage()->getCompany();?>
Dragă <?php echo $pageAdmin->getUserProfile()->getFirstName(); ?>
<br><br>
Cererea de revendicare pentru <?php echo $company->getCompanyTitleByCulture('ro');?>, <?php echo $company->getDisplayAddress(); ?> pe <a href="http://www.getlokal.ro">www.getlokal.ro</a> a fost respinsă.
<br><br>
Pentru a evita abuzurile legate de revendicarea unui loc pe site-ul nostru, verificăm datele furnizate prin telefon iar în cazul tău nu am reușit să facem această validare din cauza unuia din motivele de mai jos
- Nu te-am putut identifica oficial ca reprezentant
- Mai există o pagină <?php echo $company->getCompanyTitleByCulture('ro');?> pe site-ul nostru și am programat ștergerea celei pe care ai încercat să o revendici
<br><br>
Dacă ai întrebări, scrie-ne pe <a href="mailto:romania@getlokal.com">romania@getlokal.com</a> – îți vom răspunde cât de repede putem.
<br><br>
Mulțumim,
Echipa getlokal.ro
<br><br><br>
--------------------------------------------------------------------------
<br><br>
Dear <?php echo $pageAdmin->getUserProfile()->getFirstName(); ?>,
<br><br>
Your Place Claim for  <?php echo $company->getCompanyTitleByCulture('en');?>, <?php echo $company->getDisplayAddress(); ?> on <a href="http://www.getlokal.ro/en">www.getlokal.ro</a> has been rejected.
<br><br>
We usually verify over the phone whether the person claiming a place is authorized to manage the business information.
<br><br>
The most likely reason why we rejected your claim is that we couldn’t gather sufficient information to prove your entitlement.
<br><br>
It is also possible that the rejection was due to problems with this record in our database for which we apologize. We will contact you as soon as we can to ensure your claim is assigned to the correct place.
<br><br>
If you have any further questions, please feel free to contact us at <a href="mailto:romania@getlokal.com">romania@getlokal.com</a>
<br><br>
The getlokal.ro team

<?php include_partial('mail/mail_footer_ro');?>