<?php use_helper('Link')?>
<?php  $company = $pageAdmin->getCompanyPage()->getCompany();?>
<?php $path = link_to_frontend('sf_guard_signin', array('sf_culture'=>'sr'));?>

<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? 'Poštovana': (($pageAdmin->getUserProfile()->getGender() == 'm')? 'Poštovani': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdminSr)? $pageAdminSr:$pageAdmin->getUserProfile()->getLastName() ; endif;?>,
<br><br>
odobrili smo vaš zahtev i profil <?php echo $company->getCompanyTitleByCulture('sr');?> je sada linkovan ka Vašem profilu <a href="http://www.getlokal.rs/sr">www.getlokal.rs</a>.
<br><br>
Kliknite na link ispod i lulogujte se na svoj nalog.
<br><br>
<a href="http://www.getlokal.rs/sr/login">http://www.getlokal.rs/sr/login</a><br><br>
U sektoru "Podešavanja" kliknite na 'Moja mesta' i unesite korisničko ime<?php echo $pageAdmin->getUsername();?> kao i lozinku koju ste generisali za <?php echo $company->getCompanyTitleByCulture('sr');?>.
<br><br>
Nakon toga moći ćete objaviti fotografije, definisati radno vreme i uneti opis mesta/firme <?php echo $company->getCompanyTitleByCulture('sr');?> kao i reagovati - odgovarati na preporuke korisnika. Dodavaćemo nove servise za mesta/firme kako bi im olakšali privlačenje što većeg broja korisnika i o mjima ćemo vas na vreme obaveštavati. 

<br><br>
Ako imate bilo kakvo pitanje slobodno nas kontaktirajte na: <a href="mailto:serbia@getlokal.com">serbia@getlokal.com</a><br>
Uživajte koristeći getlokal.rs!<br>
getlokal.rs tim

<br><br>

-----------------------------------------------
<?php $path = link_to_frontend('sf_guard_signin', array('sf_culture'=>'en'));?>
<br><br>
Dear<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' Mrs': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' Mr': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdminSr)? $pageAdminSr:$pageAdmin->getUserProfile()->getLastName() ; endif;?>,
<br><br>
We approved your request and <?php echo $company->getCompanyTitleByCulture('en');?> is now linked to your profile on <a href="http://www.getlokal.rs/en">www.getlokal.rs</a>.
<br><br>
Click on the link below and log into your account.
<br><br>
<a href="http://www.getlokal.rs/en/login">http://www.getlokal.rs/en/login</a><br><br>
From your Settings click on 'My Places' and enter the username <?php echo $pageAdmin->getUsername();?> and the password you generated for <?php echo $company->getCompanyTitleByCulture('en');?>.
<br><br>
You will then be able to upload photos, working hours and a description of <?php echo $company->getCompanyTitleByCulture('en');?> as well as to respond to user reviews. We will be adding more options for companies to attract customers via getlokal.rs and will write to you to let you know about them.

<br><br>
If you have any questions, feel free to write to us at: <a href="mailto:serbia@getlokal.com">serbia@getlokal.com</a><br>
<br>
Thank you very much and enjoy getlokal.rs! <br>
The getlokal.rs team
