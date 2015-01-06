Zdravo,<br><br>
Tvoja nova lozinka za pristup sajtu getlokal.me je:<br><br>
<?php echo $password ?>
<br><br>
Sa ovom lozinkom se možeš prijaviti klikom na link: <br>
<?php echo url_for('@sf_guard_signin', true) ?><br /><br>

Ako želiš da promeniš automatski generisanu lozinku, to možeš učiniti na sledećoj stranici: <br>
http://www.getlokal.com/mobile.php/userSettings/security
<br><br>
Ako imaš dodatna pitanja slobodno nas kontaktiraj na <a href="mailto:montenegro@getlokal.com">montenegro@getlokal.com</a><br>
Hvala ti puno, uživaj koristeći getlokal.me<br><br>

Getlokal.me tim

<br><br>
-----------------------------------------------
<br><br>
Hello, <br><br>
You requested a new password for your getlokal account. Here it is:

<br><br>
<?php echo $password ?>

<br><br>
You can now log in using your new password:<br>
<?php echo url_for('@sf_guard_signin', true) ?><br /><br>

You can also change this unfriendly computer generated password by pointing your favorite browser to this address:
<br>
http://www.getlokal.com/mobile.php/userSettings/security

<br><br>
If you have any questions, feel free to write to us at: <a href="mailto:montenegro@getlokal.com">montenegro@getlokal.com</a><br>
Thank you very much  and enjoy getlokal.me<br>
The getlokal.me team

<?php include_partial('mail/mail_footer_me');?>
