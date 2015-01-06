Здравей,
<br>
За да потвърдиш смяната на имейл адреса, кликни на линка долу. Ако линкът не е активен копирай го и го постави в адрес бара.<br><br>
<?php echo url_for('@user_activate?key='.$user->getUserProfile()->getHash(), true) ?><br><br>
Така твоят профил ще бъде отново активен и ще можеш да пишеш мнения за любимите си фирми и места. Паролата остава непроменена. <br>
Ако имаш някакви въпроси, не се колебай да се свържеш с нас на <a href="mailto:info@getlokal.com">info@getlokal.com</a>.<br>
Благодарим и приятно сърфиране!<br>
Екипът на getlokal.com<br><br><br>
-------------------------------------------------------------------
<br><br>
Hello<br>
Please click on the link below to confirm your new email address. If the link is not active please copy and paste it in the address bar. Your password remains the same.<br><br>
<?php echo url_for('@user_activate?key='.$user->getUserProfile()->getHash(), true) ?><br><br>
This will reactivate your account so you can start reviewing your favourite companies and places.<br>
If you have any questions, feel free to write to us at: <a href="mailto:info@getlokal.com">info@getlokal.com</a><br>
Enjoy getlokal.com!<br>
The getlokal.com team

<?php include_partial('mail/mail_footer_bg');?>