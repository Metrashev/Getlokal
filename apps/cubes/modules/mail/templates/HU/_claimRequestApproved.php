
<?php  $company = $pageAdmin->getCompanyPage()->getCompany();?>

Tisztelt <?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' Asszony': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' Úr': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo (($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName()) ; endif;?>,
<br><br>
Jóvá hagytuk a kérelmét és a <?php echo $company->getCompanyTitle('hu');?> cég már be van kapcsolva a profiljában <a href="http://www.getlokal.hu">www.getlokal.hu-ban</a>.
<br><br>
Kattintson a lejebb levő linkre és lépjen be a felhasználói profiljába. <br>
<br><br>
<a href="http://www.getlokal.hu/hu/login">http://www.getlokal.hu/hu/login</a><br><br>
A "Beállítások" menűből válassza "Helyeim"-et és vezesse be a felhasználói nevét <?php echo $pageAdmin->getUsername();?> és a jelszót amit generált<?php echo $company->getCompanyTitle('hu');?>-ra.
<br><br>
Olyképpen fényképeket, munkaidőt és tevékenységleírást tölthet fel <?php echo $company->getCompanyTitle('hu');?>cégről, valamint felhasználói megjegyzésekre válaszolhat. Legközelebb több opciót állítunk be a cégek számára hogy több ügyfélt vonzzanak getlokal.hu révén, amelyekről értesítjük.
<br><br>
Ha van kérdése, lépjen kapcsolatba velünk <a href="mailto:hungary@getlokal.com">hungary@getlokal.com címre</a>.<br>

Köszönünk és élvezze a getlokal.hu-ot!
getlokal.hu csapata.

<br><br><br>

-----------------------------------------------
<br><br>
Dear<?php echo ($pageAdmin->getUserProfile()->getGender() == 'f')? ' Mrs': (($pageAdmin->getUserProfile()->getGender() == 'm')? ' Mr': '');?> <?php  if ($pageAdmin->getUserProfile()->getGender()): echo ($pageAdmin->getUserProfile()->getLastName())? $pageAdmin->getUserProfile()->getLastName():$pageAdmin->getUserProfile()->getFirstName() ; endif;?>,
<br><br>
We approved your request and <?php echo $company->getCompanyTitle('en');?> is now linked to your profile on <a href="http://www.getlokal.hu/en">www.getlokal.hu</a>.
<br><br>
Click on the link below and log into your account.
<br><br>
<a href="http://www.getlokal.hu/en/login">http://www.getlokal.hu/en/login</a><br><br>
From your Settings click on 'My Places' and enter the username <?php echo $pageAdmin->getUsername();?> and the password you generated for <?php echo $company->getCompanyTitle('en');?>.
<br><br>
You will then be able to upload photos, working hours and a description of <?php echo $company->getCompanyTitle('en');?> as well as to respond to user reviews.  We will be adding more options for companies to attract customers via getlokal.hu and will write to you to let you know about them.

<br><br>
If you have any questions, feel free to write to us at: <a href="mailto:hungary@getlokal.com">hungary@getlokal.com</a><br>
<br>
Thank you very much and enjoy getlokal.hu! <br>
The getlokal.hu team

<?php include_partial('mail/mail_footer_hu');?>