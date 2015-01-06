Здраво,
<br/>
<?php echo htmlspecialchars($user_data['name']) ?>
(Е-меил: <?php echo $user_data['email']?>,
 <?php if ($user_data['phone']): ?> Телефон: <?php echo $user_data['phone']; endif;?>)
 Ви ја испраќа следната порака преку www.getlokal.mk.
<br/>
<p>
	"<?php echo strip_tags(nl2br($user_data['message']), '<br>'); ?>"
</p>
<br/>
Ве замолуваме да контактирајте со <?php echo htmlspecialchars($user_data['name']) ?> директно и да не одговарате на macedonia@getlokal.com.
<br/><br/>
getlokal.mk ви посакува успех во бизнисот!<br/><br/>
Го добивте овој е-меил бидејќи сте корисник на онлајн производите/услугите на getlokal.mk и експлицитно сте се согласиле да добивате е-маил пораки преку getlokal.mk. getlokal.mk не е испраќач на оваа порака и не е одговорен за содржината или фактот дека е неочекувана и/или непобарана. Ве замолуваме да НЕ ОДГОВАРАТЕ на оваа порака ако сакате да го контактирате нејзиниот испраќач, бидејќи така нема да биде испратена до него. Ви благодариме!

<br><br>
-----------------------------------------------
<br><br>
Hello ,
<br/>
<?php echo htmlspecialchars($user_data['name']) ?>,
(E-mail: <?php echo $user_data['email']?>,
 <?php if ($user_data['phone']): ?> Phone: <?php echo $user_data['phone']; endif;?>)
 sends you the following message through www.getlokal.mk.
<br/>
<p>
	"<?php echo strip_tags(nl2br($user_data['message']), '<br>'); ?>"
</p>
<br/>
Please contact <?php echo htmlspecialchars($user_data['name']) ?> directly and don't send emails to macedonia@getlokal.com.
<br/><br/>
getlokal.mk wishes you success in your business.<br/><br/>
You are a recipient of this email because you are a user of the online products/services of getlokal.mk and you have explicitly agreed to receive messages through getlokal.mk. getlokal.mk is not the sender of this message and cannot be held responsible for its contents or the fact that it is unanticipated and/or unsolicited. Please DO NOT reply to this message if you wish to contact its sender as your reply will not be sent to him/her. Thank you!

<?php include_partial('mail/mail_footer_mk');?>