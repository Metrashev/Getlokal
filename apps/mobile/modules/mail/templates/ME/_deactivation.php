<br><br>

Dobrodošli na getlokal.me<br>
Vaš getlokal nalog je uspješno deaktiviran.
Molimo kliknite na link ispod kako biste potvrdili registraciju. Ukoliko link nije aktivan, molimo kopirajte ga i unesite u polje za pretragu u vašem brouzeru.
<br>
<br>
<?php echo url_for('@user_activate?key='.$user->getUserProfile()->getHash(), true) ?><br>
Nakon potvrde registracije možete pisati preporuke za svoje omiljene firme i mjesta.<br>

Ako imate bilo kakvo pitanje slobodno nas kontaktirajte na: <a href="mailto:montenegro@getlokal.com">montenegro@getlokal.com</a><br>
Uživajte koristeći getlokal.me!<br>
Getlokal.me tim
<br><br>
-----------------------------------------------
<br><br>

Welcome to getlokal.me<br>
Your getlokal account was deactivated successfully.
Please click on the link below to activate your account. If the link is not active please copy and paste it in the address bar.
<br>
<br>
<?php echo url_for('@user_activate?key='.$user->getUserProfile()->getHash(), true) ?><br>
Once you've activated your account you can start reviewing your favourite companies and places.<br>
If you have any questions, feel free to write to us at: <a href="mailto:montenegro@getlokal.com">montenegro@getlokal.com</a><br>
Enjoy getlokal.me!<br>
The getlokal.me team

<?php include_partial('mail/mail_footer_me');?>