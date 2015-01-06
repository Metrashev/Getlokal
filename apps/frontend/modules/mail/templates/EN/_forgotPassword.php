Привет от getlokal.com<br>
Вече можете да влезете в профила си в getlokal с нова парола:<br><br>
<?php echo $password ?><br><br>
Използвайте този линк, за да влезете в профила си: <br>
<?php echo url_for('@sf_guard_signin', true) ?><br>
<br>
Ако имате някакви въпроси, не се колебайте да се свържете с нас на <a href="mailto:info@getlokal.com">info@getlokal.com</a>.<br>
<br> Благодарим ви и ви пожелаваме приятно сърфиране!
<br>Екипът на getlokal.com

<br><br><br>

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
If you have any questions, feel free to write to us at: <a href="mailto:info@getlokal.com">info@getlokal.com</a><br>
Thank you very much  and enjoy getlokal.com<br>
The getlokal.com team

<?php include_partial('mail/mail_footer_bg');?>