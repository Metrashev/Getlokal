<?php use_helper('Link')?>
<?php $profile = $user->getUserProfile();?>
<?php $path = link_to_frontend('sf_guard_signin', array('sf_culture'=>'me', 'my_company' => 1 ));?>
<?php $path_business =  link_to_frontend('for_business', array('sf_culture'=>'me'));?>

<?php echo ($profile->getGender() == 'f')? 'Poštovana': (($profile->getGender() == 'm')? 'Poštovani': '');?> <?php  if ($profile->getGender()): echo ($firstName)? $firstName:$user->getLastName() ; endif;?>, 
<br><br>

Dobrodošli na naveću socijalnu mrežu za firme i njihove klijente u Crnoj Gori! 
<br><br>
Kako biste na najbolji način iskoristili ono što vam naš sajt nudi kliknite <a href="<?php echo $path ?>"><?php echo 'ovde' ;?></a> (<?php echo 'ovde' ?>) i upotrebite ove detalje <?php echo $profile->getsfGuardUser()->getEmailAddress();?> i <?php echo $password;?> da biste se ulogovali na svoj profil. <br><br>

<i>Preporučujemo vam da zamenite automatski generisanu lozinku čim se ulogujete na svoj profil - idte na Podešavanja/Sigurnosna podešavanja/Promjena lozinke. </i><br><br>
Kada se ulogujete, registrujte korisničko ime i lozinku za mjesto/firmu i ažurirajte podatke o njoj – opis mjesta/firme, pictures, radno vrijeme, kontakt informacije.<br><br>
Da biste vidjeli kako profil mjesta/firme izgleda kliknite <a href="<?php echo $path_business?>"><?php echo 'ovde' ;?></a> (<?php echo $path_business?>).
<br><br>

Ako imate bilo kakvo pitanje slobodno nas kontaktirajte na: <a href="mailto:montenegro@getlokal.com">montenegro@getlokal.com</a><br>
Uživajte koristeći getlokal.me!<br>
getlokal.me tim
<br><br>
-----------------------------------------------
<br><br>
<?php $path_business = link_to_frontend('for_business', array('sf_culture'=>'en'));?>
Dear<?php echo ($profile->getGender() == 'f')? ' Mrs': (($profile->getGender() == 'm')? ' Mr': '');?> <?php  if ($profile->getGender()): echo ($firstName)? $firstName:$user->getLastName() ; endif;?>,
<br><br>

It is our pleasure to welcome you to the largest social network for places and businesses in Montenegro! 
<br><br>

To make the most of the benefits our website offers, click <a href="<?php echo $path_business ?>"><?php echo 'here' ;?></a> (<?php echo 'here' ?>) and use these details <?php echo $profile->getsfGuardUser()->getEmailAddress();?> and <?php echo $password;?> to log in your profile. <br><br>
<i>We strongly advise you to change the automatically generated password right after you log into your profile from Settings/Security Settings/Change Password. </i>
<br><br>
Once you are logged in, create a place username and password and then update the place information – business description, pictures, working hours, contact information.<br> <br>
To see how a place page looks like, please click  <a href="<?php echo $path_business?>"><?php echo 'here' ;?></a> (<?php echo $path_business?>).
<br><br>


If you have any questions,please contact us at <a href="mailto:montenegro@getlokal.com">montenegro@getlokal.com</a><br>
Best Regards<br>
The getlokal.me team
