﻿<?php use_helper('Link')?>
<?php $company = $pageAdmin->getCompanyPage()->getCompany();?>
<?php $path_business =  link_to_frontend('for_business', array('sf_culture'=>'me'));?>
<?php $path = link_to_frontend('sf_guard_signin', array('sf_culture'=>'me', 'my_company' => 1));?>

<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? 'Poštovana': (($pageAdmin->getUserProfile()->getGender() == 'm')? 'Poštovani': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdminme)? $pageAdminme():$pageAdmin->getUserProfile()->getLastName() ; endif;?>,
<br><br>

Sa zadovoljstvom želimo dobrodošlicu mjestu/firmi <?php echo $company->getCompanyTitleByCulture('me');?> na najveću socijalnu mrežu za firme u Crnoj Gori! 
<br><br>
Kako biste najbolje iskoristili ono što Vam naš sajt nudi kliknite <a href="<?php echo $path?>"><?php echo 'ovdje';?></a> ( <?php echo $path?> ) iskoristite podatke <?php echo $pageAdmin->getUserProfile()->getsfGuardUser()->getEmailAddress();?>  i Vašu lozinku kako biste se ulogovali. <br><br>
Kada se ulogujete, registrujte korisničko ime i lozinku za mjesto/firmu i ažurirajte podatke o njoj – opis mjesta/firme, pictures, radno vrijeme, kontakt informacije.<br> <br>
Da biste videli kako profil firme izgleda kliknite <a href="<?php echo $path_business?>"><?php echo 'ovde' ;?></a> (<?php echo $path_business?>).
<br><br>


Ako imate bilo kakvo pitanje slobodno nas kontaktirajte na: <a href="mailto:montenegro@getlokal.com">montenegro@getlokal.com</a><br>
Uživajte koristeći getlokal.me!<br>
getlokal.me tim
<br><br>
-----------------------------------------------
<?php $path_business =  link_to_frontend('for_business', array('sf_culture'=>'en'));?>
<?php $path = link_to_frontend('sf_guard_signin', array('sf_culture'=>'en', 'my_company' => 1));?>
<br><br>
Dear<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' Mrs': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' Mr': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdminme)? $pageAdminme:$pageAdmin->getUserProfile()->getLastName() ; endif;?>,
<br><br>


It is our pleasure to welcome <?php echo $company->getCompanyTitleByCulture('en');?> on joining the largest social network for places and businesses in montenegro! 
<br><br>
To make the most of the benefits our website offers, click <a href="<?php echo $path?>"><?php echo 'here';?></a> ( <?php echo $path?> ) and use <?php echo $pageAdmin->getUserProfile()->getsfGuardUser()->getEmailAddress();?>  and your password to log in your profile. <br><br>
Once you are logged in, create a place username and password and then update the place information – business description, pictures, working hours, contact information.<br> <br>
To see how a place page looks like, please click  <a href="<?php echo $path_business?>"><?php echo 'here' ;?></a> (<?php echo $path_business?>).
<br><br>


If you have any questions,please contact us at <a href="mailto:montenegro@getlokal.com">montenegro@getlokal.com</a><br>
Best Regards<br>
The getlokal.me team
