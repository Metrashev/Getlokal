Hei,
<br/>
<?php echo htmlspecialchars($user_data['name']) ?>
(E-mail: <?php echo $user_data['email']?>,
 <?php if ($user_data['phone']): ?> Phone: <?php echo $user_data['phone']; endif;?>)
 lähettää Sinulle seuraavan viestin www.getlokal.fi palvelun kautta.
<br/>
<p>
	"<?php echo strip_tags(nl2br($user_data['message']), '<br>'); ?>"
</p>
<br/>
Ole hyvä ja ota yhteyttä viestin lähettäjään <?php echo htmlspecialchars($user_data['name']) ?> suoraan. Älä lähetä viestiä finland@getlokal.com palveluun.
<br/><br/>
getlokal.fi toivottaa Sinulle hyvää päivänjatkoa.<br/><br/>
olet saanut tämän viestin koska käytät getlokal.fi palveluita ja olet lupautunut vastaanottamaan viestejä getlokal.fi palvelun kautta. Getlokal.fi ei ole tämän viestin alkuperäinen lähettäjä eikä getlokal.fi palvelua voida pitää vastuussa viestin sisällöstä. Ole hyvä ÄLÄKÄ VASTAA tähän viestiin, jos haluat tavoittaa viestin alkuperäisen lähettäjän, getlokal.fi palvelu ei voi välittää viestiä eteenpäin sen alkuperäiselle lähettäjälle. Kiitos!

<br><br>
-----------------------------------------------
<br><br>

Hello ,
<br/>
<?php echo htmlspecialchars($user_data['name']) ?>,
(E-mail: <?php echo $user_data['email']?>,
 <?php if ($user_data['phone']): ?> Phone: <?php echo $user_data['phone']; endif;?>)
 sends you the following message through www.getlokal.fi.
<br/>
<p>
	"<?php echo strip_tags(nl2br($user_data['message']), '<br>'); ?>"
</p>
<br/>
Please contact <?php echo htmlspecialchars($user_data['name']) ?> directly and don't send emails to finland@getlokal.com.
<br/><br/>
getlokal.fi wishes you success in your business.<br/><br/>
You are a recipient of this email because you are a user of the online products/services of getlokal.fi and you have explicitly agreed to receive messages through getlokal.fi. getlokal.fi is not the sender of this message and cannot be held responsible for its contents or the fact that it is unanticipated and/or unsolicited. Please DO NOT reply to this message if you wish to contact its sender as your reply will not be sent to him/her. Thank you!
<br>
<?php include_partial('mail/mail_footer_fi');?>
