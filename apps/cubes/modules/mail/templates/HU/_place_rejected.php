Kedves, <?php echo $profile->getFirstName();?>,<br>
<br>
Köszönjük hogy időt szántál új hely javaslatára segítve a honlapunk javítását!
<br><br>
Sajnos a (<?php echo $company->getCompanyTitle('hu');?>) hely, amit javasoltál nem lett jóváhagyva. A legvalószinűbb oka erre az hogy a hely már létezik az adatbázisunkban vagy auóz információ róla nem volt helyesen feltöltve. 
<br><br>

Ha van kérdésed nyugodtan írjál nekünk <a href="mailto:hungary@getlokal.com">hungary@getlokal.com-ra</a>.<br><br>
Élvezzd a getlokal.hu-ot!<br>
getlokal.hu csapata<br><br><br>

-----------------------------------------------
<br><br>

Dear, <?php echo $profile->getFirstName();?><br>
Thank you for taking the time to suggest a new place and help us improve our site!<br><br>
Unfortunately the place <?php echo $company->getCompanyTitle('en');?> you suggested was not approved. The most likely reasons for that are that the place already exists in our database or the place information was input incorrectly. <br>
<br>
If you have any questions, feel free to write to us at: <a href="mailto:hungary@getlokal.com">hungary@getlokal.com</a><br>
Enjoy getlokal.hu!<br>
The getlokal.hu team
