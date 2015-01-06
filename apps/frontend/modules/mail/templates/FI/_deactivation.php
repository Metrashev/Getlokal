Tervetuloa getlokal.fi palveluun<br>
Getlokal tilisi on suljettu onnistuneesti.<br>
Klikkaa alla olevasta linkistä aktivoidaksesi tilin uudelleen. Jos linkki ei toimi, ole hyvä ja kopioi linkki hakukenttään.
<br><br>
<?php echo url_for('@user_activate?key='.$user->getUserProfile()->getHash(), true) ?><br>
Tilin aktivoinnin jälkeen voit käyttää hakua ja etsiä mieluisia palveluita.<br>
Jos sinulla on kysyttävää, ole hyvä ja kirjoita meille: <a href="mailto:finland@getlokal.com">finland@getlokal.com</a>.<br>
Toivomme, että viihdyt getlokal.fi palvelussamme!<br>
Getlokal.fi tiimi

<br><br>
-----------------------------------------------
<br><br>

Welcome to getlokal.fi<br>
Your getlokal account was deactivated successfully.
Please click on the link below to activate your account. If the link is not active please copy and paste it in the address bar.
<br>
<br>
<?php echo url_for('@user_activate?key='.$user->getUserProfile()->getHash(), true) ?><br>
Once you've activated your account you can start reviewing your favourite companies and places.<br>
If you have any questions, feel free to write to us at: <a href="mailto:finland@getlokal.com">finland@getlokal.com</a><br>
Enjoy getlokal.fi!<br>
The getlokal.fi team
<br>
<?php include_partial('mail/mail_footer_fi');?>
