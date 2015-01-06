<br><br>
Zdravo,
<br/>
<?php echo htmlspecialchars($user_data['name']) ?>,
(E-mail: <?php echo $user_data['email']?>,
 <?php if ($user_data['phone']): ?> Telefon: <?php echo $user_data['phone']; endif;?>)
 vam šalje poruku putem www.getlokal.me.
<br/>
<p>
	"<?php echo strip_tags(nl2br($user_data['message']), '<br>'); ?>"
</p>
<br/>
Molimo kontaktirajte <?php echo htmlspecialchars($user_data['name']) ?> direktno a ne slanjem email poruke na montenegro@getlokal.com.
<br/><br/>
getlokal.me Vam želi puno uspjeha u poslu.<br/><br/>
Primili ste ovaj email zato što ste korisnik usluga i servisa getlokal.me i samim tim ste prihvatili da primate ovakve poruke sa sajta getlokal.me. getlokal.me nije pošiljalac ove poruke i ne odgovara za njen sadržaj kao ni za to što poruku niste tražili ili očekivali.
Molimo da ne odgovarate na poruku ukoliko želite da odgovorite pošiljaocu već se obratite direktno njemu potem njegovog profila. Hvala.
<br><br>
-----------------------------------------------
<br><br>
Hello,
<br/>
<?php echo htmlspecialchars($user_data['name']) ?>,
(E-mail: <?php echo $user_data['email']?>,
 <?php if ($user_data['phone']): ?> Phone: <?php echo $user_data['phone']; endif;?>)
 sends you the following message through www.getlokal.me.
<br/>
<p>
	"<?php echo strip_tags(nl2br($user_data['message']), '<br>'); ?>"
</p>
<br/>
Please contact <?php echo htmlspecialchars($user_data['name']) ?> directly and don't send emails to montenegro@getlokal.com.
<br/><br/>
getlokal.me wishes you success in your business.<br/><br/>
You are a recipient of this email because you are a user of the online products/services of getlokal.me and you have explicitly agreed to receive messages through getlokal.me. getlokal.me is not the sender of this message and cannot be held responsible for its contents or the fact that it is unanticipated and/or unsolicited. Please DO NOT reply to this message if you wish to contact its sender as your reply will not be sent to him/her. Thank you!

<?php include_partial('mail/mail_footer_me');?>