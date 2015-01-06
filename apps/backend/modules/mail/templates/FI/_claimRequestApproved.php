
<?php  $company = $pageAdmin->getCompanyPage()->getCompany();?>

Hyvä<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' Rouva': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' Herra': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo (($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName()) ; endif;?>,
<br><br>
Olemme hyväksyneet pyyntösi ja <?php echo $company->getCompanyTitleByCulture('bg');?> on nyt linkattu profiiliisi <a href="http://www.getlokal.fi">www.getlokal.fi</a>.
<br><br>
Klikkaa allaolevaa linkkiä ja kirjaudu sisään.
<br><br>
<a href="http://www.getlokal.fi/fi/login">http://www.getlokal.fi/fi/login</a><br><br>
Valitse 'Asetukset' valikosta 'Minun Yritykseni' ja kirjoita käyttäjätunnuksesi <?php echo $pageAdmin->getUsername();?> ja salasanasi <?php echo $company->getCompanyTitleByCulture('fi');?>.
<br><br>
Voit ladata kuvia, aukioloajat ja lyhyen esittelyn yrityksestäsi <?php echo $company->getCompanyTitleByCulture('fi');?> ja myös vastata käyttäjien kommentteihin. Kehitämme jatkuvasti uusia mahdollisuuksia tavoittaa lisää asiakkaita yrityksellenne getlokal.fi kautta ja kirjoitamme Sinulle kertoaksemme niistä lisää.
<br><br>
Jos sinulla on kysyttävää, ole hyvä ja ota yhteyttä: <a href="mailto:finland@getlokal.com">finland@getlokal.com</a>.<br>

Haluamme toivottaa sinut tervetulleeksi palveluumme getlokal.fi! <br>
Getlokal.fi tiimi!

<br><br>

-----------------------------------------------
<br><br>

<?php  $company = $pageAdmin->getCompanyPage()->getCompany();?>

Dear<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' Mrs': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' Mr': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName() ; endif;?>,
<br><br>
We approved your request and <?php echo $company->getCompanyTitleByCulture('en');?> is now linked to your profile on <a href="http://www.getlokal.fi">www.getlokal.fi</a>.
<br><br>
Click on the link below and log into your account.
<br><br>
<a href="http://www.getlokal.fi/en/login">http://www.getlokal.fi/en/login</a><br><br>
From your Settings click on 'My Places' and enter the username <?php echo $pageAdmin->getUsername();?> and the password you generated for <?php echo $company->getCompanyTitleByCulture('en');?>.
<br><br>
You will then be able to upload photos, working hours and a description of <?php echo $company->getCompanyTitleByCulture('en');?> as well as to respond to user reviews. We will be adding more options for companies to attract customers via getlokal.fi and will write to you to let you know about them.

<br><br>
If you have any questions, feel free to write to us at: <a href="mailto:finland@getlokal.com">finland@getlokal.com</a><br>
<br>
Thank you very much and enjoy getlokal.fi! <br>
The getlokal.fi team

<?php include_partial('mail/mail_footer_fi');?>
