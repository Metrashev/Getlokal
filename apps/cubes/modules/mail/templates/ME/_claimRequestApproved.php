<?php use_helper('Link')?>
<?php  $company = $pageAdmin->getCompanyPage()->getCompany();?>
<?php $path = link_to_frontend('sf_guard_signin', array('sf_culture'=>'me'));?>

<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? 'Poštovana': (($pageAdmin->getUserProfile()->getGender() == 'm')? 'Poštovani': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdminme)? $pageAdminme:$pageAdmin->getUserProfile()->getLastName() ; endif;?>,
<br><br>
odobrili smo vaš zahtjev i profil <?php echo $company->getCompanyTitleByCulture('me');?> je sada linkovan ka Vašem profilu <a href="http://www.getlokal.me/me">www.getlokal.me</a>.
<br><br>
Kliknite na link ispod i lulogujte se na svoj nalog.
<br><br>
<a href="http://www.getlokal.me/me/login">http://www.getlokal.me/me/login</a><br><br>
U sektoru "Podešavanja" kliknite na 'Moja mjesta' i unesite korisničko ime<?php echo $pageAdmin->getUsername();?> kao i lozinku koju ste generisali za <?php echo $company->getCompanyTitleByCulture('me');?>.
<br><br>
Nakon toga moći ćete objaviti fotografije, definisati radno vrijeme i unijeti opis mjesta/firme <?php echo $company->getCompanyTitleByCulture('me');?> kao i reagovati - odgovarati na preporuke korisnika. Dodavaćemo nove servise za mjesta/firme kako bi im olakšali privlačenje što većeg broja korisnika i o mjima ćemo vas na vreme obavještavati. 

<br><br>
Ako imate bilo kakvo pitanje slobodno nas kontaktirajte na: <a href="mailto:montenegro@getlokal.com">montenegro@getlokal.com</a><br>
Uživajte koristeći getlokal.me!<br>
getlokal.me tim

<br><br>

-----------------------------------------------
<?php $path = link_to_frontend('sf_guard_signin', array('sf_culture'=>'en'));?>
<br><br>
Dear<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' Mrs': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' Mr': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdminme)? $pageAdminme:$pageAdmin->getUserProfile()->getLastName() ; endif;?>,
<br><br>
We approved your request and <?php echo $company->getCompanyTitleByCulture('en');?> is now linked to your profile on <a href="http://www.getlokal.me/en">www.getlokal.me</a>.
<br><br>
Click on the link below and log into your account.
<br><br>
<a href="http://www.getlokal.me/en/login">http://www.getlokal.me/en/login</a><br><br>
From your Settings click on 'My Places' and enter the username <?php echo $pageAdmin->getUsername();?> and the password you generated for <?php echo $company->getCompanyTitleByCulture('en');?>.
<br><br>
You will then be able to upload photos, working hours and a description of <?php echo $company->getCompanyTitleByCulture('en');?> as well as to respond to user reviews. We will be adding more options for companies to attract customers via getlokal.me and will write to you to let you know about them.

<br><br>
If you have any questions, feel free to write to us at: <a href="mailto:montenegro@getlokal.com">montenegro@getlokal.com</a><br>
<br>
Thank you very much and enjoy getlokal.me! <br>
The getlokal.me team
