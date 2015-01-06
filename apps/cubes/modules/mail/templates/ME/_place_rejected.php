<?php echo ($profile->getGender() == 'f')? 'Draga': (($profile->getGender() == 'm')? 'Dragi': '');?>, <?php echo $firstName;?><br>

Mjesto/firma (<?php echo $company->getCompanyTitleByCulture('me'); ?>) koje ste predložili nije odobreno zbog dupliranja u sistemu.
<br>Molimo provjerite ponovo da li mjesto/firma postoji na getlokal.me i ako ga ne pronađete pokušajte ponovo da ga unesete. <br>
Hvala!<br>
<a href="http://www.getlokal.me">http://www.getlokal.me</a>

<br><br>
Ukoliko imate bilo kakvo pitanje slobodno nas kontaktirajte na: <a href="mailto:montenegro@getlokal.com">montenegro@getlokal.com</a><br>
Uživajte u koriščenju getlokal.me!<br>
Getlokal.me tim
<br><br>

-----------------------------------------------

<br><br>

Dear, <?php echo $firstName;?><br>
Thank you for taking the time to suggest a new place and help us improve our site!<br><br>
Unfortunately the place <?php echo $company->getCompanyTitleByCulture('en');?> you suggested was not approved. The most likely reasons for that are that the place already exists in our database or the place information was input incorrectly. <br>
<br>
If you have any questions, feel free to write to us at: <a href="mailto:montenegro@getlokal.com">montenegro@getlokal.com</a><br>
Enjoy getlokal.me!<br>
The getlokal.me team
