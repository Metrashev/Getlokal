
<?php $path = link_to_frontend('sf_guard_signin', array('sf_culture'=>'sr'));?>

<br><br>
<?php echo ($profile->getGender() == 'f')? 'Poštovani': (($profile->getGender() == 'm')? 'Poštovana': '');?> <?php  if ($profile->getGender()): echo ($name)? $name:$profile->getLastName() ; endif;?>,<br><br>

Vaš zahtev za mesto/firmu <?php echo $company->getCompanyTitleByCulture('sr');?> na <a href="http://www.getlokal.rs/sr">www.getlokal.rs</a> je odbijen jer je došlo do problema. <br><br>

To je najverovatnije zbog neslaganja sa poslovnim informacijama koje imamo u vezi Vas, a nismo bili u mogućnosti da Vas kontaktiramo putem telefona.<br><br>

<a href="<?php echo $path?>"><?php echo $path;?></a><br><br>


Molimo, ulogujte se na Vaš poslovni profil i proverite kontakt informacije prenego što pošaljete zahtev za mesto/firmu. <?php echo $company->getCompanyTitleByCulture('sr');?> <br><br>

Nakon dobijana novog zahteva, mi ćemo probati da Vas kontaktiramo u roku od tri radna dana. Ukoliko Vam se ne javimo u roku od tri radna dana znači da Vaš zahtev nije prihvaćen zato Vas molimo kontaktirajte nas na:<a href="mailto:serbia@getlokal.com">serbia@getlokal.com</a> 
<br><br>
Hvala i uživajte sa getlokal.rs <br>
Tim getlokal.rs

<br><br>

-----------------------------------------------

<br><br>

<?php $path = link_to_frontend('sf_guard_signin', array('sf_culture'=>'en'));?>

<br><br>
Dear<?php echo ($profile->getGender() == 'f')? ' Mrs': (($profile->getGender() == 'm')? ' Mr': '');?> <?php  if ($profile->getGender()): echo ($name)? $name:$profile->getLastName() ; endif;?>,<br><br>

Your application for claiming <?php echo $company->getCompanyTitleByCulture('en');?> in <a href="http://www.getlokal.rs/en">www.getlokal.rs</a> has been rejected as there was a problem with it. <br><br>

This is most likely due to a discrepancy with the business information that we have for you and we haven't been able to contact you by phone to verify it.<br><br>

<a href="<?php echo $path?>"><?php echo $path;?></a><br><br>


Please log into your business profile and check all the contact information again before you claim <?php echo $company->getCompanyTitleByCulture('en');?> again.<br><br>

We will try to contact you within 3 working days of receiving the new claim. If you don't hear from us within 3 working days and your claim is not approved please contact us at:<a href="mailto:serbia@getlokal.com">serbia@getlokal.com</a> 
<br><br>
Thank you very much and enjoy getlokal.rs <br>
The getlokal.rs team 