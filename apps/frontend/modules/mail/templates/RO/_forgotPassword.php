
Deja puteţi intra în profilul dumneavoastră din getlokal.ro, cu o nouă parolă:<br /><br>
<?php echo $password ?>
<br /><br>

Intraţi în profil de la acest link: <br />

<?php echo url_for('@sf_guard_signin', true) ?><br />
<br />

Pentru orice fel de întrebări, nu ezitaţi să luaţi legătura cu noi, la:  <a href="mailto:romania@getlokal.com">romania@getlokal.com</a>
<br />Mulţumim şi un surffing plăcut!
<br />Echipa getlokal.ro

<br /><br />

-----------------------------------------------

<br><br>

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
If you have any questions, feel free to write to us at: <a href="mailto:romania@getlokal.com">romania@getlokal.com</a><br>
Thank you very much  and enjoy getlokal.ro<br>
The getlokal.ro team

<?php include_partial('mail/mail_footer_ro');?>