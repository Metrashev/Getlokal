<?php echo ($profile->getGender() == 'f')? 'Draga': (($profile->getGender() == 'm')? 'Dragi': 'Zdravo');?>, <?php echo $firstName;?><br><br>

Mesto/firma (<?php echo $company->getCompanyTitleByCulture('sr');?>) koje ste predložili nije odobreno zbog dupliranja u sistemu.
<br><br>
Molimo proverite ponovo da li mesto/firma postoji na <a href="http://www.getlokal.rs">http://www.getlokal.rs</a> i ako ga ne pronađete pokušajte ponovo da ga unesete. <br>
Hvala!
<br><br>
Ukoliko imate bilo kakvo pitanje slobodno nas kontaktirajte na: <a href="mailto:serbia@getlokal.com">serbia@getlokal.com</a><br>
Uživajte u koriščenju getlokal.rs!<br>
Getlokal.rs tim
<br><br>

-----------------------------------------------

<br><br>
Dear, <?php echo $firstName;?><br><br>
Thank you for taking the time to suggest a new place and help us improve our site!<br><br>
Unfortunately the place <?php echo $company->getCompanyTitleByCulture('en');?> you suggested was not approved. The most likely reasons for that are that the place already exists in our database or the place information was input incorrectly. <br>
<br>
If you have any questions, feel free to write to us at: <a href="mailto:serbia@getlokal.com">serbia@getlokal.com</a><br>
Enjoy getlokal.rs!<br>
The getlokal.rs team
