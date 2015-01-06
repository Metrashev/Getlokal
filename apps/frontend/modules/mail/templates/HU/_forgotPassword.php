Szia<br>
Új jelszót kértél a getlokal profilodra. Tessék:<br><br>
<?php echo $password ?><br><br>
Már beléphetsz az új jelszavaddal: <br>
<?php echo url_for('@sf_guard_signin', true) ?><br>
Megváltoztathatod ezt a számítógép generálta barátsagtalan jelszót címezve a kedvenc böngésződet a következő címre:
 <br>
<?php echo url_for('userSettings/security', true) ?>
<br><br>
Ha bármi kérdésed lenne nyúgodtan írjál nekünk a <a href="mailto:hungary@getlokal.com">hungary@getlokal.com</a> címre.<br>
<br> Köszönjünk és élvezzd a getlokal.hu-ot!
<br>getlokal.hu csapata

<br><br><br>

-----------------------------------------------
<br><br>
Hello, <br><br>
You requested a new password for your getlokal account. Here it is:

<br>
<?php echo $password ?>

<br>
You can now log in using your new password:<br>

<?php  echo url_for('@sf_guard_signin', true) ?><br>

You can also change this unfriendly computer generated password by pointing your favorite browser to this address:
<br>
<?php echo url_for('userSettings/security', true) ?>

<br><br>
If you have any questions, feel free to write to us at: <a href="mailto:hungary@getlokal.com">hungary@getlokal.com</a><br>
Thank you very much  and enjoy getlokal.hu<br>
The getlokal.hu team

<?php include_partial('mail/mail_footer_hu');?>