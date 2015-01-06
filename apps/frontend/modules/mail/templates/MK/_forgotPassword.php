
Сега можеш да се логираш на getlokal со новата лозинка:<br><br>
<?php echo $password ?><br><br>
Искористи го следниот линк за да се логираш: <br>
<?php echo url_for('@sf_guard_signin', true) ?><br>
<br>
Ако имаш било какво прашање, слободно пиши ни на <a href="mailto:macedonia@getlokal.com">macedonia@getlokal.com</a>.<br>
Благодарност и пријатно сурфање!<br>
Тимот на getlokal.mk
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
If you have any questions, feel free to write to us at: <a href="mailto:macedonia@getlokal.com">macedonia@getlokal.com</a><br>
Thank you very much  and enjoy getlokal.mk<br>
The getlokal.mk team

<?php include_partial('mail/mail_footer_mk');?>