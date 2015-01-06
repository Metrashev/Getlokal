Hei, <br><br>
Tässä pyytämäsi uusi salasana getlokal.fi tiliisi: <br><br>
<?php echo $password ?><br><br>
Voit nyt kirjautua sisään palveluumme uudella salasanalla: <br>
<?php echo url_for('@sf_guard_signin', true) ?><br>
<br>
Jos Sinulla on kysymyksiä, ole hyvä ja kirjoita meille: <a href="mailto:finland@getlokal.com">finland@getlokal.com</a>.<br>
Toivomme, että viihdyt getlokal.fi palvelun parissa<br>
Getlokal.fi tiimi

<br><br>
-----------------------------------------------
<br><br>

Hello, <br><br>
You requested a new password for your getlokal account. Here it is:

<br><br>
<?php echo $password ?>

<br><br>
You can now log in using your new password:<br>

<?php  echo url_for('@sf_guard_signin', true) ?><br><br>

You can also change this unfriendly computer generated password by pointing your favorite browser to this address:
<br>
<?php echo url_for('userSettings/security', true) ?>

<br><br>
If you have any questions, feel free to write to us at: <a href="mailto:finland@getlokal.com">finland@getlokal.com</a><br>
Thank you very much  and enjoy getlokal.fi<br>
The getlokal.fi team
<br>
<?php include_partial('mail/mail_footer_fi');?>
