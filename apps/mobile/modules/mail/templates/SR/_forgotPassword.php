<br><br>
Zdravo, <br><br>
Tražili ste novu lozinku za Vaš getlokal nalog. Izvolite:

<br>
<?php echo $password ?>

<br>
Možete se prijaviti korišćenjem Vaše nove lozinke:<br>

http://www.getlokal.rs/sr/login<br>

Takođe, možete uneti personalizovanu šifru na linku:
<br>
<?php echo url_for('userSettings/security', true) ?>

<br><br>
Ukoliko imate bilo kakvo pitanje slobodno nas kontaktirajte: <a href="mailto:serbia@getlokal.com">serbia@getlokal.com</a><br>
Hvala Vam, uživajte koristeći getlokal.rs<br>
Getlokal.rs tim
<br><br>
-----------------------------------------------
<br><br>
Hello, <br><br>
You requested a new password for your getlokal account. Here it is:

<br>
<?php echo $password ?>

<br>
You can now log in using your new password:<br>

http://www.getlokal.rs/en/login<br>

You can also change this unfriendly computer generated password by pointing your favorite browser to this address:
<br>
<?php echo url_for('userSettings/security', true) ?>

<br><br>
If you have any questions, feel free to write to us at: <a href="mailto:serbia@getlokal.com">serbia@getlokal.com</a><br>
Thank you very much  and enjoy getlokal.rs<br>
The getlokal.rs team

<?php include_partial('mail/mail_footer_sr');?>
