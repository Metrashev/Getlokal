<?php use_helper('Link')?>
<?php $path = link_to_frontend('sf_guard_signin', array('sf_culture'=>'ro'));?>

Bună ziua<?php echo ($profile->getGender() == 'f')? ' D-na': (($profile->getGender() == 'm')? ' D-nul': '');?> <?php  if ($profile->getGender()): echo ($profile->getLastName())? $profile->getLastName():$profile->getFirstName() ; endif;?>,
<br />
<br />
Cererea dumneavoastră de adăugare a <?php echo $company->getCompanyTitleByCulture('ro');?> la profilul dumneavoastră de business din 
<a href="http://www.getlokal.ro">www.getlokal.ro</a> a fost respinsă, deoarece există o problemă cu cererea. 
<br />
<br />
Cel mai probabil, există o neconcordanţă între datele despre firmă pe care ni le-aţi trimis, 
iar noi nu am reuşit să luăm legătura telefonică cu dumneavoastră, la telefonul şi contactul indicat, pentru a verifica autenticitatea. 
<br /><br />
Vă rugăm să intraţi din nou în profilul dumneavoastră de business şi verificaţi toate datele de contact, înaintea adăugării 
<?php echo $company->getCompanyTitleByCulture('ro');?>.<br /><br />
<a href="<?php echo $path?>"><?php echo $path;?></a><br /><br />
<br />
Noi vom încerca să luăm legătura cu dumneavoastră, în cel mult 3 zile lucrătoare, 
după ce vom primi noua cerere. Dacă nu vă sunăm în zile lucrătoare, iar cererea nu vă este acceptată, 
vă rugăm să ne scrieţi la <a href="mailto:romania@getlokal.com">romania@getlokal.com</a>.<br />
<br />
Mulţumim şi un surffing plăcut!<br />
Echipa getlokal.ro<br />
<br />
<br />
-----------------------------------------------
<?php $path = link_to_frontend('sf_guard_signin', array('sf_culture'=>'en'));?>

<br /><br />
Dear<?php echo ($profile->getGender() == 'f')? ' Mrs': (($profile->getGender() == 'm')? ' Mr': '');?> <?php  if ($profile->getGender()): echo ($profile->getLastName())? $profile->getLastName():$profile->getFirstName() ; endif;?>,<br /><br />

Your application for claiming <?php echo $company->getCompanyTitleByCulture('en');?> in <a href="http://www.getlokal.ro/en">www.getlokal.ro</a> has been rejected as there was a problem with it. <br /><br />

This is most likely due to a discrepancy with the business information that we have for you and we haven't been able to contact you by phone to verify it.<br /><br />

<a href="<?php echo $path?>"><?php echo $path;?></a><br /><br />


Please log into your business profile and check all the contact information again before you claim <?php echo $company->getCompanyTitleByCulture('en');?> again.<br /><br />

We will try to contact you within 3 working days of receiving the new claim. If you don't hear from us within 3 working days and your claim is not approved please contact us at:<a href="mailto:romania@getlokal.com">romania@getlokal.com</a> 
<br /><br />
Thank you very much and enjoy getlokal.ro <br />
The getlokal.ro team 




