<br><br>

Dobrodošli na getlokal.rs<br>
Molimo kliknite na link ispod kako biste potvrdili registraciju. Ukoliko link nije aktivan, molimo kopirajte ga i unesite u polje za pretragu u vašem brouzeru.
<br>
<br>
<?php echo url_for('@user_activate?key='.$user->getUserProfile()->getHash(), true) ?><br>
Nakon potvrde registracije možete pisati preporuke za svoje omiljene firme i mesta.<br>

Ako imate bilo kakvo pitanje slobodno nas kontaktirajte na: <a href="mailto:serbia@getlokal.com">serbia@getlokal.com</a><br>
Uživajte koristeći getlokal.rs!<br>
Getlokal.rs tim
<br><br>
-----------------------------------------------
<br><br>

Welcome to getlokal.rs<br>
Please click on the link below to confirm your registration. If the link is not active please copy and paste it in the address bar.
<br>
<br>
<?php echo url_for('@user_activate?key='.$user->getUserProfile()->getHash(), true) ?><br>
Once you've confirmed your registration you can start reviewing your favourite companies and places.<br>
If you have any questions, feel free to write to us at: <a href="mailto:serbia@getlokal.com">serbia@getlokal.com</a><br>
Enjoy getlokal.rs!<br>
The getlokal.rs team

<?php include_partial('mail/mail_footer_sr');?>