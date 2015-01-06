Привет от getlokal.com<br>
Твоят getlokal профил беше деактивиран успешно.<br>
За да активираш профила си моля кликни на линка долу. Ако линкът не е активен можеш да го копираш и поставиш в полето за адрес на браузъра.
<br><br>
<?php echo url_for('@user_activate?key='.$user->getUserProfile()->getHash(), true) ?><br>
След това ще можеш да пишеш мнения за любимите си фирми и места.   <br>
Ако имаш някакви въпроси, не се колебай да се свържеш с нас на  <a href="mailto:info@getlokal.com">info@getlokal.com</a>.<br>
Благодарим и приятно сърфиране!<br>
Екипът на getlokal.com<br><br><br>

-----------------------------------------------
<br><br>

Welcome to getlokal.com<br>
Your getlokal account was deactivated successfully.
Please click on the link below to activate your account. If the link is not active please copy and paste it in the address bar.
<br>
<br>
<?php echo url_for('@user_activate?key='.$user->getUserProfile()->getHash(), true) ?><br>
Once you've activated your account you can start reviewing your favourite companies and places.<br>
If you have any questions, feel free to write to us at: <a href="mailto:info@getlokal.com">info@getlokal.com</a><br>
Enjoy getlokal.com!<br>
The getlokal.com team

<?php include_partial('mail/mail_footer_bg');?>