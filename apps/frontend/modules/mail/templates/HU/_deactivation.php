Üdvözlünk getlokal.hu-ban<br>
A getlokal profilod sikeresen lett deaktiválva<br>
Kérünk, kattints a lejjebb linkre a profilod aktiválására. Ha a link nem aktiv, másold le és illessz be a címsorba.
<br><br>
<?php echo url_for('@user_activate?key='.$user->getUserProfile()->getHash(), true) ?><br>
Ha már aktiváltad a profilodat, kezdhetsz újra megjegyzéseket írni a kedvenc cégeidről és helyekről. <br>
Ha bármi kérdésed lenne, nyugodtan írjál nekünk a  <a href="mailto:hungary@getlokal.com">hungary@getlokal.com-címre</a>.<br>
Élvezz a getlokal.hu-ot!<br>
getlokal.hu csapata<br><br><br>

-----------------------------------------------
<br><br>

Welcome to getlokal.hu<br>
Your getlokal account was deactivated successfully.
Please click on the link below to activate your account. If the link is not active please copy and paste it in the address bar.
<br>
<br>
<?php echo url_for('@user_activate?key='.$user->getUserProfile()->getHash(), true) ?><br>
Once you've activated your account you can start reviewing your favourite companies and places.<br>
If you have any questions, feel free to write to us at: <a href="mailto:hungary@getlokal.com">hungary@getlokal.com</a><br>
Enjoy getlokal.hu!<br>
The getlokal.hu team

<?php include_partial('mail/mail_footer_hu');?>