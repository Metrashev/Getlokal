Здравейте,
<br/>
<?php echo htmlspecialchars($user_data['name']) ?>
(Имейл: <?php echo $user_data['email']?>,
 <?php if ($user_data['phone']): ?> Телефон: <?php echo $user_data['phone']; endif;?>)
 ви изпраща следното съобщение чрез www.getlokal.com.
<br/>
<p>
	"<?php echo strip_tags(nl2br($user_data['message']), '<br>'); ?>"
</p>
<br/>
Моля свържете се с <?php echo htmlspecialchars($user_data['name']) ?> директно, а не изпращайте отговори на info@getlokal.com.
<br/><br/>
getlokal.com ви пожелава успешен бизнес!<br/><br/>
Вие получавате настоящото електронно писмо, защото сте потребител на онлайн продуктите/услугите на getlokal.com и изрично сте се съгласили да получавате съобщения по електронна поща чрез getlokal.com. getlokal.com не е подател на това съобщение и не носи отговорност за неочакваното и/или нежеланото му получаване, както и за неговото съдържание. Моля НЕ отговаряйте на това съобщение, в случай, че желаете да се свържете с подателя на съобщението, т.к. Вашият отговор няма да бъде директно получен от него. Благодарим Ви!

<br><br>
-----------------------------------------------
<br><br>
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