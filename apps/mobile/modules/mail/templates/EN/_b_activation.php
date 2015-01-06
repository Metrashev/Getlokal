
Welcome to getlokal.com<br><br>
Please click on the link below to confirm your registration. If the link is not active, please copy and paste it in the address bar.
<br>
<br>
<?php echo url_for('@user_activate?key='.$user->getUserProfile()->getHash(), true) ?><br><br>
Once you've confirmed your registration, please log in, find your place and claim it!<br>
If you have any questions, feel free to write to us at: <a href="mailto:info@getlokal.com">info@getlokal.com</a><br>
Enjoy the benefits your business will get at getlokal.com!<br>
The getlokal.com team

<?php include_partial('mail/mail_footer_bg');?>
