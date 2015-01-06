Здраво,
<br>
За да ја потврдиш промената на твојата е-меил адреса, кликни на линкот подолу. Доколку линкот не е активен, можеш да го ископираш и поставиш во полето за адреса во пребарувачот.<br><br>
<?php echo url_for('@user_activate?key='.$user->getUserProfile()->getHash(), true) ?><br><br>
Ова ќе го реактивира твојот профил и ќе можеш да пишуваш мислења за твоите омилени компании и места. Лозинката останува непроменета.<br>
Ако имаш било какво прашање, слободно пиши ни на <a href="mailto:macedonia@getlokal.com">macedonia@getlokal.com</a>.<br>
Благодарност и пријатно сурфање!<br>
Тимот на getlokal.mk<br><br><br>
-------------------------------------------------------------------
<br><br>
Hello<br>
Please click on the link below to confirm your new email address. If the link is not active please copy and paste it in the address bar. Your password remains the same.<br><br>
<?php echo url_for('@user_activate?key='.$user->getUserProfile()->getHash(), true) ?><br><br>
This will reactivate your account so you can start reviewing your favourite companies and places.<br>
If you have any questions, feel free to write to us at: <a href="mailto:macedonia@getlokal.com">macedonia@getlokal.com</a><br>
Enjoy getlokal.mk!<br>
The getlokal.mk team

<?php include_partial('mail/mail_footer_mk');?>