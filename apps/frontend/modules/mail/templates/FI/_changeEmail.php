Hei,
<br>
Ole hyvä ja klikkaa allaolevasta linkistä varmistaaksesi uuden sähköpostiosoitteesi. jos linkki ei ole aktiivinen, kopio se hakukenttään. Salasanasi pysyy samana.<br><br>
<?php echo url_for('@user_activate?key='.$user->getUserProfile()->getHash(), true) ?><br><br>
Tämä aktivoi tilisi uudelleen ja nyt voit jälleen etsiä mieluisat palvelut sivustostamme.<br>
Jos Sinulla on kysyttävää, ole hyvä ja kirjoita meille: <a href="mailto:finland@getlokal.com">finland@getlokal.com</a>.<br>
Toivomme, että viihdyt getlokal.fi palvelun parissa!<br>
Getlokal.fi tiimi

<br><br>
-------------------------------------------------------------------
<br><br>

Hello<br>
Please click on the link below to confirm your new email address. If the link is not active please copy and paste it in the address bar. Your password remains the same.<br><br>
<?php echo url_for('@user_activate?key='.$user->getUserProfile()->getHash(), true) ?><br><br>
This will reactivate your account so you can start reviewing your favourite companies and places.<br>
If you have any questions, feel free to write to us at: <a href="mailto:finland@getlokal.com">finland@getlokal.com</a><br>
Enjoy getlokal.fi!<br>
The getlokal.fi team
<br>
<?php include_partial('mail/mail_footer_fi');?>
