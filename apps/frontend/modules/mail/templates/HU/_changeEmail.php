Szia,
<br>
Kérünk kattints a lejebb levő linkre az új e-mail címed  megerősítésére.  Ha a link nem aktiv, másold le és illesszd be a címsorba. A jelszavad vátozatlan marad.<br><br> (CHECK)
<?php echo url_for('@user_activate?key='.$user->getUserProfile()->getHash(), true) ?><br><br>
Ez újból aktiválni fogja a profilodat úgyhogy kezdhetsz  megjegyzéseket írni a kedvenc cégeidről és helyekről.<br>
Ha bármi kérdésed van nyugodtan írhatsz nekünk <a href="mailto:hungary@getlokal.com">hungary@getlokal.com-címre.</a>.<br>
Élvezzd a getlokal.hu-ot!<br>
getlokal.hu csapata<br><br><br>
-------------------------------------------------------------------
<br><br>
Hello<br>
Please click on the link below to confirm your new email address. If the link is not active please copy and paste it in the address bar. Your password remains the same.<br><br>
<?php echo url_for('@user_activate?key='.$user->getUserProfile()->getHash(), true) ?><br><br>
This will reactivate your account so you can start reviewing your favourite companies and places.<br>
If you have any questions, feel free to write to us at: <a href="mailto:hungary@getlokal.com">hungary@getlokal.com</a><br>
Enjoy getlokal.hu!<br>
The getlokal.hu team

<?php include_partial('mail/mail_footer_hu');?>