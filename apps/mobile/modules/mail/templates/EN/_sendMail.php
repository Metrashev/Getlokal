
Hello ,
<br/>
<?php echo htmlspecialchars($user_data['name']) ?>,
(E-mail: <?php echo $user_data['email']?>,
 <?php if ($user_data['phone']): ?> Phone: <?php echo $user_data['phone']; endif;?>)
 sends you the following message through www.getlokal.com.
<br/>
<p>
	"<?php echo strip_tags(nl2br($user_data['message']), '<br>'); ?>"
</p>
<br/>
Please contact <?php echo htmlspecialchars($user_data['name']) ?> directly and don't send emails to info@getlokal.com.
<br/><br/>
getlokal.com wishes you success in your business.<br/><br/>
You are a recipient of this email because you are a user of the online products/services of getlokal.com and you have explicitly agreed to receive messages through getlokal.com. getlokal.com is not the sender of this message and cannot be held responsible for its contents or the fact that it is unanticipated and/or unsolicited. Please DO NOT reply to this message if you wish to contact its sender as your reply will not be sent to him/her. Thank you!

<?php include_partial('mail/mail_footer_bg');?>
