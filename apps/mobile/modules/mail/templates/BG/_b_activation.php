
Привет от getlokal.com<br><br>
За да потвърдиш регистрацията си, моля кликни на линка долу. Ако линкът не е активен, можеш да го копираш и поставиш в полето за адрес на браузъра.
<br><br>
<?php echo url_for('@user_activate?key='.$user->getUserProfile()->getHash(), true) ?><br>
След като потвърдиш регистрацията си, логни се, намери мястото си и го заяви!   <br> <br>
Ако имаш някакви въпроси, не се колебай да се свържеш с нас на  <a href="mailto:info@getlokal.com">info@getlokal.com</a>.<br>
Наслади се на ползите, които getlokal ще донесе на твоя бизнес! <br>
Екипът на getlokal.com<br><br><br>

-----------------------------------------------
<br><br>

Welcome to getlokal.com<br><br>
Please click on the link below to confirm your registration. If the link is not active, please copy and paste it in the address bar.
<br>
<br>
<?php echo url_for('@user_activate?key='.$user->getUserProfile()->getHash(), true) ?><br><br>
Once you've confirmed your registration, please log in, find your place and claim it!<br>
If you have any questions, feel free to write to us at: <a href="mailto:info@getlokal.com">info@getlokal.com</a><br>
Enjoy the benefits your business will get at getlokal.com!<br>
The getlokal.com team

<?php include_partial('mail/mail_footer_bg');?>