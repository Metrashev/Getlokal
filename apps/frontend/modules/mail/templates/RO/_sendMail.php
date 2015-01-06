Bună,
<br/>
<?php echo htmlspecialchars($user_data['name']) ?>,
(E-mail: <?php echo $user_data['email']?>,
 <?php if ($user_data['phone']): ?> Telefon: <?php echo $user_data['phone']; endif;?>)
 va trimite următorul mesaj prin www.getlokal.ro.
<br/>
<p>
	"<?php echo strip_tags(nl2br($user_data['message']), '<br>'); ?>"
</p>
<br/>
Vă rugăm să contactaţi <?php echo htmlspecialchars($user_data['name']) ?> în mod direct şi nu trimiteti email-uri la romania@getlokal.com.
<br/><br/>
getlokal.ro vă urează succes în afaceri!<br/><br/>
Sunteţi un destinatar a acestui e-mail deoarece sunteţi un utilizator de produse on-line / servicii de getlokal.ro şi aţi fost de acord în mod explicit pentru a primi mesaje prin intermediul getlokal.ro. getlokal.ro nu este expeditorul acestui mesaj şi nu poate fi considerat responsabil pentru conţinutul său sau faptul că este neprevăzut şi / sau nesolicitat. Vă rugăm să nu răspundeţi la acest mesaj dacă doriţi să contactaţi expeditorul pentru ca răspunsul dvs. nu va fi trimis la ei. Mulţumim!

<br><br>
-----------------------------------------------
<br><br>
<br><br>
Hello,
<br/>
<?php echo htmlspecialchars($user_data['name']) ?>,
(E-mail: <?php echo $user_data['email']?>,
 <?php if ($user_data['phone']): ?> Phone: <?php echo $user_data['phone']; endif;?>)
 sends you the following message through www.getlokal.ro.
<br/>
<p>
	"<?php echo strip_tags(nl2br($user_data['message']), '<br>'); ?>"
</p>
<br/>
Please contact <?php echo htmlspecialchars($user_data['name']) ?> directly and don't send emails to romania@getlokal.com.
<br/><br/>
getlokal.ro wishes you success in your business.<br/><br/>
You are a recipient of this email because you are a user of the online products/services of getlokal.ro and you have explicitly agreed to receive messages through getlokal.ro. getlokal.ro is not the sender of this message and cannot be held responsible for its contents or the fact that it is unanticipated and/or unsolicited. Please DO NOT reply to this message if you wish to contact its sender as your reply will not be sent to him/her. Thank you!

<?php include_partial('mail/mail_footer_ro');?>