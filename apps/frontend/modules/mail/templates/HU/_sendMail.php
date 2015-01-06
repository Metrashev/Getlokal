Tisztelt Úrak,
<br/>
<?php echo htmlspecialchars($user_data['name']) ?>
(Email: <?php echo $user_data['email']?>,
 <?php if ($user_data['phone']): ?> Telefon: <?php echo $user_data['phone']; endif;?>)
 a következő üzenetet küldi www.getlokal.hu által.
<br/>
<p>
	"<?php echo strip_tags(nl2br($user_data['message']), '<br>'); ?>"
</p>
<br/>
Kérjük lépjenek kapcsolatban <?php echo htmlspecialchars($user_data['name']) ?>-val közvetlenül és ne küldjenek e-mail-eket hungary@getlokal.com-nak.
<br/><br/>
getlokal.hu sok sikert kiván a bizniszükben!<br/><br/>
Önök kapják ezt az e-mail-t mert Önök a getlokal.hu online termékek/szolgálatok felhasználói és kifejezetten beleegyeztek üzeneteket kapni getlokal.hu révén. getlokal.hu nem feladója ennek az üzenetnek és nem tartózik felelősséggel a tartalmáért és a váratlan és/vagy nemkivánt megjelenéséért. Kérjük NE VÁLASZOLJANAK erre az üzenetre ha kapcsolatba akarnak lépni a feladójával, mert az Önök válasza nem lesz továbbítva neki. Köszönjünk!

<br><br>
-----------------------------------------------
<br><br>
Hello ,
<br/>
<?php echo htmlspecialchars($user_data['name']) ?>,
(E-mail: <?php echo $user_data['email']?>,
 <?php if ($user_data['phone']): ?> Phone: <?php echo $user_data['phone']; endif;?>)
 sends you the following message through www.getlokal.hu.
<br/>
<p>
	"<?php echo strip_tags(nl2br($user_data['message']), '<br>'); ?>"
</p>
<br/>
Please contact <?php echo htmlspecialchars($user_data['name']) ?> directly and don't send emails to hungary@getlokal.com.
<br/><br/>
getlokal.hu wishes you success in your business.<br/><br/>
You are a recipient of this email because you are a user of the online products/services of getlokal.hu and you have explicitly agreed to receive messages through getlokal.hu. getlokal.hu is not the sender of this message and cannot be held responsible for its contents or the fact that it is unanticipated and/or unsolicited. Please DO NOT reply to this message if you wish to contact its sender as your reply will not be sent to him/her. Thank you!

<?php include_partial('mail/mail_footer_hu');?>